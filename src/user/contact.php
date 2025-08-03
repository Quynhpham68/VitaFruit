<!DOCTYPE html>
<?php 
include("connect.php"); 
session_start(); 
?>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ | FreshMarket</title>

    <!-- Google Fonts + Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap + Custom CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', sans-serif;
            padding-top: 120px;
            overflow: hidden; /* Ẩn hoa quả tràn ngoài */
        }
        .contact-container {
            max-width: 600px;
            margin: 0 auto 80px auto;
            background-color: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            position: relative;
            z-index: 10;
        }
        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }
        .btn-success {
            background-color: #7cc400;
            border-color: #7cc400;
        }
        .btn-success:hover {
            background-color: #6ab000;
            border-color: #6ab000;
        }

        /* Biểu tượng bay */
        .fruit-icon {
            position: absolute;
            font-size: 24px;
            animation: floatUp 10s linear infinite;
            opacity: 0.8;
        }

        @keyframes floatUp {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0.5;
            }
            100% {
                transform: translateY(-10vh) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body>

<!-- Biểu tượng bay khắp nền -->
<div id="fruit-icons-container"></div>

<!-- HEADER -->
<?php include_once 'layout/header.php'; ?>

<!-- LIÊN HỆ -->
<div class="contact-container">
    <h2 class="mb-4" style="color: #7cc400;"><i class="fas fa-envelope me-2"></i>Liên hệ với FreshMarket</h2>
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

<!-- FOOTER -->
<?php include_once 'layout/footer.php'; ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>

<!-- Script tạo biểu tượng bay -->
<script>
    const container = document.getElementById('fruit-icons-container');
    const fruits = ["🍎", "🍌", "🍇", "🍊", "🥝", "🍓", "🍍", "🥭", "🍉", "🍒", "🥥"];

    function createFruit() {
        const fruit = document.createElement('div');
        fruit.classList.add('fruit-icon');
        fruit.innerText = fruits[Math.floor(Math.random() * fruits.length)];
        fruit.style.left = Math.random() * 100 + "vw";
        fruit.style.fontSize = (Math.random() * 20 + 20) + "px";
        fruit.style.animationDuration = (Math.random() * 5 + 5) + "s";
        container.appendChild(fruit);

        setTimeout(() => {
            container.removeChild(fruit);
        }, 10000);
    }

    setInterval(createFruit, 500);
</script>

<!-- FOOTER -->
<?php include_once 'layout/footer.php'; ?>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
