<?php
session_start();
include("../connect.php");

// Nếu đã đăng nhập thì lấy username, không thì null
$username = $_SESSION['username'] ?? null;

// Lấy userId nếu đã login, null nếu chưa
$userId = null;
if ($username) {
    $qUser = mysqli_query($code, "SELECT id FROM user WHERE email = '".mysqli_real_escape_string($code, $username)."'");
    $user = mysqli_fetch_assoc($qUser);
    if ($user) {
        $userId = (int)$user['id'];
    }
}

// Lấy thông tin người nhận từ form
$receiverName    = mysqli_real_escape_string($code, $_POST['receiverName'] ?? '');
$receiverAddress = mysqli_real_escape_string($code, $_POST['receiverAddress'] ?? '');
$receiverPhone   = mysqli_real_escape_string($code, $_POST['receiverPhone'] ?? '');
$cartId          = (int)($_POST['cartId'] ?? 0);

// Tính tổng tiền trong giỏ
$sqlTotal = "SELECT SUM(cd.quantity * IF(p.discount_price>0, p.discount_price, p.price)) as total
             FROM cart_detail cd
             JOIN product p ON cd.productId = p.id
             WHERE cd.cartId = {$cartId}";
$rsTotal = mysqli_query($code, $sqlTotal);
$rowTotal = mysqli_fetch_assoc($rsTotal);
$totalAmount = (float)($rowTotal['total'] ?? 0);
if ($totalAmount <= 0) { die("Giỏ hàng rỗng hoặc tổng tiền không hợp lệ."); }

// 1) Tạo đơn hàng
$currentDate = date("d/m/Y"); // giữ nguyên kiểu VARCHAR
$statusInit  = "Chờ thanh toán";

// Nếu userId null thì insert NULL
$userIdSql = $userId === null ? "NULL" : $userId;

$sqlOrder = "INSERT INTO orders (name, address, phone, status, userId, date)
             VALUES ('{$receiverName}','{$receiverAddress}','{$receiverPhone}','{$statusInit}',{$userIdSql},'{$currentDate}')";

// Debug nếu lỗi
if (!mysqli_query($code, $sqlOrder)) {
    die("Không tạo được đơn hàng. Lỗi SQL: " . mysqli_error($code));
}

$orderId = mysqli_insert_id($code);
if (!$orderId) { die("Không tạo được đơn hàng."); }

// 2) Copy item từ cart_detail → order_detail
$sqlItems = "SELECT quantity, productId FROM cart_detail WHERE cartId = {$cartId}";
$rsItems = mysqli_query($code, $sqlItems);
while($it = mysqli_fetch_assoc($rsItems)) {
    $q  = (int)$it['quantity'];
    $pid= (int)$it['productId'];
    mysqli_query($code, "INSERT INTO order_detail (quantity, productId, orderId) VALUES ({$q}, {$pid}, {$orderId})");
}

// 3) Tạo URL thanh toán VNPay
$vnp_Url        = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "https://abcd1234.ngrok.io/VitaFruit/src/user/cart/payment_return.php";
$vnp_TmnCode    = "BKWEX44J";
$vnp_HashSecret = "5935VL1QPUHLFHIN4Q7AFXXG726DQX34";

$vnp_TxnRef   = (string)$orderId;
$vnp_Amount   = (int)round($totalAmount * 100);
$vnp_IpAddr   = $_SERVER['REMOTE_ADDR'];
$vnp_OrderInfo= "Thanh toan don hang #{$orderId}";
$vnp_OrderType= "billpayment";
$vnp_Locale   = "vn";

$inputData = array(
    "vnp_Version"   => "2.1.0",
    "vnp_TmnCode"   => $vnp_TmnCode,
    "vnp_Amount"    => $vnp_Amount,
    "vnp_Command"   => "pay",
    "vnp_CreateDate"=> date('YmdHis'),
    "vnp_CurrCode"  => "VND",
    "vnp_IpAddr"    => $vnp_IpAddr,
    "vnp_Locale"    => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef"    => $vnp_TxnRef
);

ksort($inputData);
$query = "";
$hashdata = "";
foreach ($inputData as $key => $value) {
    $query    .= urlencode($key) . "=" . urlencode($value) . '&';
    $hashdata .= ($hashdata ? '&' : '') . $key . "=" . $value;
}
$vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
$vnp_Url .= "?" . $query . "vnp_SecureHash=" . $vnpSecureHash;

// 4) Redirect sang VNPay
header("Location: $vnp_Url");
exit;
