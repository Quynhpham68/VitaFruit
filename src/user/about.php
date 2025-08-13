<!DOCTYPE html>
<?php include("connect.php") ?>
<?php session_start(); ?>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giới thiệu - FreshMarket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Web Fonts + Bootstrap Icons + FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/about_style.css" rel="stylesheet">    
</head>
<body>

<!-- HEADER -->
<?php include_once 'layout/header.php'; ?>

<!-- Giới thiệu -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 d-flex flex-column justify-content-center text-start">
                <h2 class="mb-4">Chào mừng đến với <span class="highlight">VitaFruit</span></h2>
                <p>
                    VitaFruit là nơi chuyên cung cấp thực phẩm sạch, đặc biệt là rau củ quả tươi ngon, đảm bảo an toàn cho sức khỏe người tiêu dùng. Chúng tôi cam kết mang đến cho bạn những sản phẩm được tuyển chọn kỹ lưỡng từ những nông trại uy tín trên khắp cả nước, đáp ứng đầy đủ tiêu chuẩn vệ sinh an toàn thực phẩm.
                </p>
                <p>
                    Với sứ mệnh nâng cao chất lượng cuộc sống cộng đồng, VitaFruit không ngừng cải tiến dịch vụ – từ khâu bảo quản, vận chuyển cho đến tư vấn và chăm sóc khách hàng. Đồng thời, chúng tôi luôn đa dạng hóa các mặt hàng để phù hợp với nhu cầu ngày càng cao và phong phú của người tiêu dùng hiện đại.
                </p>   
            </div>
            <div class="col-md-6">
                <img src="/VegetableWeb/src/user/img/image1.jpg" alt="Giới thiệu VitaFruit" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Sứ mệnh và giá trị -->
<section class="core-values-section py-5">
    <div class="container">
        <h2 class="text-center text-success mb-5">Sứ mệnh & Giá trị cốt lõi</h2>
        <div class="row justify-content-center g-4">
            <div class="col-md-4 col-sm-6">
                <div class="value-card text-center">
                    <h5>🥬 Thực phẩm sạch</h5>
                    <p>Không hóa chất độc hại, đạt tiêu chuẩn an toàn thực phẩm.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="value-card text-center">
                    <h5>🤝 Khách hàng là trung tâm</h5>
                    <p>Luôn đặt lợi ích khách hàng lên hàng đầu với sự tận tâm.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="value-card text-center">
                    <h5>🌱 Phát triển bền vững</h5>
                    <p>Hợp tác cùng nông dân, bảo vệ môi trường và phát triển địa phương.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<?php include_once 'layout/footer.php'; ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
<script src="js/floating_icons.js"></script>
</body>
</html>
