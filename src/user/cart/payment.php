<?php
session_start();
include("../connect.php");

// Kiểm tra user đã đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: ../user/login.php");
    exit;
}

$username = $_SESSION['username'];
$qUser = mysqli_query($conn, "SELECT id FROM user WHERE email='" . mysqli_real_escape_string($conn, $username) . "'");
$user = mysqli_fetch_assoc($qUser);
$userId = $user['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitOrder'])) {
    $paymentMethod = $_POST['paymentMethod'] ?? 'COD';

    // Tạo đơn hàng
    $orderSql = "INSERT INTO orders (userId, status, date, paymentMethod) 
                 VALUES ($userId, 'Chờ xử lý', NOW(), '$paymentMethod')";
    if (!mysqli_query($conn, $orderSql)) {
        die("Lỗi tạo đơn hàng: " . mysqli_error($conn));
    }
    $orderId = mysqli_insert_id($conn);

    // Lấy sản phẩm trong giỏ hàng
    $cartRes = mysqli_query($conn, "SELECT c.id as cartId, cd.productId, cd.quantity, p.price 
                                    FROM cart c 
                                    JOIN cart_detail cd ON c.id = cd.cartId
                                    JOIN product p ON cd.productId = p.id
                                    WHERE c.userId = $userId");

    while ($row = mysqli_fetch_assoc($cartRes)) {
        $pid = (int)$row['productId'];
        $qty = (int)$row['quantity'];
        $price = (int)$row['price'];
        mysqli_query($conn, "INSERT INTO order_detail (orderId, productId, quantity, price) 
                             VALUES ($orderId, $pid, $qty, $price)");
    }

    // Xóa giỏ hàng
    $rsCart = mysqli_query($conn, "SELECT id FROM cart WHERE userId=$userId");
    if ($cart = mysqli_fetch_assoc($rsCart)) {
        $cid = (int)$cart['id'];
        mysqli_query($conn, "DELETE FROM cart_detail WHERE cartId=$cid");
        mysqli_query($conn, "DELETE FROM cart WHERE id=$cid");
    }

    // Xử lý COD
    if ($paymentMethod === 'COD') {
        mysqli_query($conn, "UPDATE orders SET status='Đặt hàng thành công' WHERE id=$orderId");
        header("Location: order_success.php?orderId=" . $orderId);
        exit;
    }

    // Xử lý VNPay
    if ($paymentMethod === 'VNPAY') {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/VitaFruit/src/payment/payment_return.php";
        $vnp_TmnCode = "B6Q0E1V9"; 
        $vnp_HashSecret = "5935VL1QPUHLFHIN4Q7AFXXG726DQX34";

        $totalRes = mysqli_query($conn, "SELECT SUM(quantity*price) as total FROM order_detail WHERE orderId=$orderId");
        $totalRow = mysqli_fetch_assoc($totalRes);
        $amount = (int)$totalRow['total'];

        $vnp_TxnRef = $orderId;
        $vnp_OrderInfo = "Thanh toan don hang #" . $orderId;
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $amount * 100;
        $vnp_Locale = "vn";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        ksort($inputData);
        $hashdata = urldecode(http_build_query($inputData));
        $query = http_build_query($inputData);
        $vnp_Url = $vnp_Url . "?" . $query;

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;

        header("Location: " . $vnp_Url);
        exit;
    }
}
?>
