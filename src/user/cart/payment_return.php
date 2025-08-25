<?php
include("../connect.php");

// Khóa bí mật để verify chữ ký
$vnp_HashSecret = "5935VL1QPUHLFHIN4Q7AFXXG726DQX34"; // <-- THAY BẰNG HASH SECRET CỦA BẠN

// Lấy dữ liệu trả về từ VNPay
$inputData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}
$vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
unset($inputData['vnp_SecureHash']);
ksort($inputData);
$hashData = "";
foreach ($inputData as $key => $value) {
    $hashData .= ($hashData ? '&' : '') . $key . "=" . $value;
}
$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

// Lấy orderId (vnp_TxnRef) & response
$orderId       = (int)($_GET['vnp_TxnRef'] ?? 0);
$responseCode  = $_GET['vnp_ResponseCode'] ?? '';
$payAmount     = (int)($_GET['vnp_Amount'] ?? 0); // số tiền *100

// Kiểm tra chữ ký
if ($secureHash !== $vnp_SecureHash) {
    // Sai chữ ký → không tin cậy
    mysqli_query($code, "UPDATE orders SET status='Thanh toán không hợp lệ' WHERE id={$orderId}");
    die("<h3 style='color:#c00'>Dữ liệu không hợp lệ (sai chữ ký).</h3>");
}

// Nếu hợp lệ, xét mã phản hồi
if ($responseCode === '00') {
    // THÀNH CÔNG → cập nhật đơn & lúc này mới trừ kho + dọn giỏ
    mysqli_query($code, "UPDATE orders SET status='Đã thanh toán' WHERE id={$orderId}");

    // Lấy cartId gắn với đơn này (dựa theo các product trong order_detail → tìm cart tương ứng không có sẵn,
    // nên ta sẽ lấy cart của user còn tồn tại. Nếu bạn đã xóa cart sau checkout COD, hãy giữ lại cartId ở orders.)
    // Ở đây đơn giản chỉ cần trừ kho theo order_detail và xóa cart hiện tại của user nếu còn:
    $rsItems = mysqli_query($code, "SELECT productId, quantity FROM order_detail WHERE orderId={$orderId}");
    while($it = mysqli_fetch_assoc($rsItems)) {
        $pid = (int)$it['productId'];
        $q   = (int)$it['quantity'];
        // trừ kho & tăng sold
        mysqli_query($code, "UPDATE product SET quantity = quantity - {$q}, sold = sold + {$q} WHERE id={$pid}");
    }

    // Nếu bạn muốn dọn giỏ của user: tìm userId của đơn rồi xóa cart/cart_detail
    $rsOrder = mysqli_query($code, "SELECT userId FROM orders WHERE id={$orderId}");
    $od = mysqli_fetch_assoc($rsOrder);
    if ($od && $od['userId']) {
        $uId = (int)$od['userId'];
        $rsCart = mysqli_query($code, "SELECT id FROM cart WHERE userId={$uId}");
        if ($cart = mysqli_fetch_assoc($rsCart)) {
            $cid = (int)$cart['id'];
            mysqli_query($code, "DELETE FROM cart_detail WHERE cartId={$cid}");
            // (cân nhắc có nên xóa bản ghi cart luôn hay giữ lại)
            // mysqli_query($code, "DELETE FROM cart WHERE id={$cid}");
        }
    }

    echo "<h2 style='color:green'>Thanh toán thành công!</h2>";
    echo "<p>Mã đơn: #{$orderId}</p>";
    echo "<p>Số tiền: ".number_format($payAmount/100,0,',','.')." đ</p>";

} else {
    // THẤT BẠI / HỦY
    mysqli_query($code, "UPDATE orders SET status='Thanh toán thất bại' WHERE id={$orderId}");
    echo "<h2 style='color:#c00'>Thanh toán thất bại hoặc đã hủy.</h2>";
    echo "<p>Mã đơn: #{$orderId}</p>";
}
