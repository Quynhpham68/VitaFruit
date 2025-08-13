<!DOCTYPE html>
<?php 
include("connect.php"); 
session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dùng biến $code thay vì $conn
    $name = mysqli_real_escape_string($code, $_POST['name']);
    $email = mysqli_real_escape_string($code, $_POST['email']);
    $message = mysqli_real_escape_string($code, $_POST['message']);

    $sql = "INSERT INTO contact (name, email, message, created_at) VALUES ('$name', '$email', '$message', NOW())";

    if (mysqli_query($code, $sql)) {
        echo "<script>alert('Cảm ơn bạn đã liên hệ với VitaFruit.'); window.location.href='contact.php';</script>";
        exit();
    } else {
        echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại!');</script>";
    }
}
?>

<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ | VitaFruit</title>

    <!-- Google Fonts + Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap + Custom CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/contact_style.css" rel="stylesheet">

</head>
<body>


<!-- HEADER -->
<?php include_once 'layout/header.php'; ?>

<!-- LIÊN HỆ -->
<div class="contact-container">
    <h2 class="mb-4" style="color:#c20f1a;"><i class="fas fa-envelope me-2"></i>Liên hệ với VitaFruit</h2>
    <p>Vui lòng để lại thông tin, chúng tôi sẽ phản hồi sớm nhất có thể.</p>

    <form action="#" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Họ tên</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Nguyễn Văn A" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email liên hệ</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="example@email.com" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Nội dung</label>
            <textarea name="message" id="message" rows="5" class="form-control" placeholder="Viết lời nhắn của bạn..." required></textarea>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success">Gửi liên hệ</button>
        </div>
    </form>
</div>


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
<script src="js/floating_icons.js"></script>


<!-- FOOTER -->
<?php include_once 'layout/footer.php'; ?>


</body>
</html>
