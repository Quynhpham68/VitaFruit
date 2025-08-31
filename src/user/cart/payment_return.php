<?php
include("../connect.php");

// Khóa bí mật để verify chữ ký
$vnp_HashSecret = "5935VL1QPUHLFHIN4Q7AFXXG726DQX34";

// Lấy dữ liệu trả về từ VNPay
$inputData = [];
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") $inputData[$key] = $value;
}
$vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
unset($inputData['vnp_SecureHash']);

// Sắp xếp và tạo chuỗi hash
ksort($inputData);
$hashData = "";
foreach ($inputData as $key => $value) {
    $hashData .= ($hashData ? '&' : '') . $key . "=" . $value;
}
$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

// Lấy thông tin đơn hàng
$orderId      = (int)($inputData['vnp_TxnRef'] ?? 0);
$responseCode = $inputData['vnp_ResponseCode'] ?? '';
$payAmount    = (int)($inputData['vnp_Amount'] ?? 0); // *100

// Kiểm tra chữ ký
if ($secureHash !== $vnp_SecureHash) {
    mysqli_query($conn, "UPDATE orders SET status='Thanh toán không hợp lệ' WHERE id={$orderId}");
    die("<h3 style='color:#c00'>Dữ liệu không hợp lệ (sai chữ ký).</h3>");
}

// Nếu hợp lệ
if ($responseCode === '00') {
    mysqli_query($conn, "UPDATE orders SET status='Đã thanh toán' WHERE id={$orderId}");

    // Trừ kho và tăng sold
    $rsItems = mysqli_query($conn, "SELECT productId, quantity FROM order_detail WHERE orderId={$orderId}");
    while($it = mysqli_fetch_assoc($rsItems)) {
        $pid = (int)$it['productId'];
        $q   = (int)$it['quantity'];
        mysqli_query($conn, "UPDATE product SET quantity = quantity - {$q}, sold = sold + {$q} WHERE id={$pid}");
    }

    // Dọn giỏ hàng user
    $rsOrder = mysqli_query($conn, "SELECT userId FROM orders WHERE id={$orderId}");
    $od = mysqli_fetch_assoc($rsOrder);
    if ($od && $od['userId']) {
        $uId = (int)$od['userId'];
        $rsCart = mysqli_query($conn, "SELECT id FROM cart WHERE userId={$uId}");
        if ($cart = mysqli_fetch_assoc($rsCart)) {
            $cid = (int)$cart['id'];
            mysqli_query($conn, "DELETE FROM cart_detail WHERE cartId={$cid}");
            // nếu muốn xóa luôn cart, bỏ comment dòng dưới
            // mysqli_query($conn, "DELETE FROM cart WHERE id={$cid}");
        }
    }

    echo "<h2 style='color:green'>Thanh toán thành công!</h2>";
    echo "<p>Mã đơn: #{$orderId}</p>";
    echo "<p>Số tiền: ".number_format($payAmount/100,0,',','.')." đ</p>";

} else {
    mysqli_query($conn, "UPDATE orders SET status='Thanh toán thất bại' WHERE id={$orderId}");
    echo "<h2 style='color:#c00'>Thanh toán thất bại hoặc đã hủy.</h2>";
    echo "<p>Mã đơn: #{$orderId}</p>";
}
?>
