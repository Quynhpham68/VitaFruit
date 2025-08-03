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

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            padding-top: 90px;
        }

        h2, h5 {
            font-family: 'Raleway', sans-serif;
        }

        .hero-section {
            background-color: #e9f5e1;
            padding:105px 0;
        }

        .hero-section h2 {
            font-weight: 800;
            font-size: 2rem;
        }

        .hero-section p {
            font-size: 1.05rem;
            color: #333;
            line-height: 1.7;
        }

        .highlight {
            color: #4CAF50;
            font-weight: bold;
        }

        .core-values-section {
            background-color: #f9fdf8;
            margin-top: 60px;
        }

        .core-values-section h2 {
            font-weight: 800;
            font-size: 2rem;
        }

        .value-card {
            width: 100%;
            min-height: 300px;
            padding: 35px 25px;
            background-color: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0, 128, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .value-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 128, 0, 0.15);
            border-color: #a5d6a7;
        }

        .value-card h5 {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .value-card p {
            font-size: 1.05rem;
            color: #444;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<?php include_once 'layout/header.php'; ?>

<!-- Giới thiệu -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 d-flex flex-column justify-content-center text-start">
                <h2 class="mb-4">Chào mừng đến với <span class="highlight">FreshMarket</span></h2>
                <p>
                    FreshMarket là nơi chuyên cung cấp thực phẩm sạch, đặc biệt là rau củ quả tươi ngon, đảm bảo an toàn cho sức khỏe người tiêu dùng. Chúng tôi cam kết mang đến cho bạn những sản phẩm được tuyển chọn kỹ lưỡng từ những nông trại uy tín trên khắp cả nước, đáp ứng đầy đủ tiêu chuẩn vệ sinh an toàn thực phẩm.
                </p>
                <p>
                    Với sứ mệnh nâng cao chất lượng cuộc sống cộng đồng, FreshMarket không ngừng cải tiến dịch vụ – từ khâu bảo quản, vận chuyển cho đến tư vấn và chăm sóc khách hàng. Đồng thời, chúng tôi luôn đa dạng hóa các mặt hàng để phù hợp với nhu cầu ngày càng cao và phong phú của người tiêu dùng hiện đại.
                </p>   
            </div>
            <div class="col-md-6">
                <img src="/VegetableWeb/src/user/img/about.jpg" alt="Giới thiệu FreshMarket" class="img-fluid rounded shadow">
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

<!-- Flying Fruits & Veggies Start -->
<style>
  .floating-icon {
    position: fixed;
    z-index: 1;
    font-size: 24px;
    animation: floatIcon 20s linear infinite;
    opacity: 0.7;
    pointer-events: none;
  }

  @keyframes floatIcon {
    0% {
      transform: translateY(100vh) translateX(0) rotate(0deg);
      opacity: 0;
    }
    10% {
      opacity: 0.6;
    }
    100% {
      transform: translateY(-120vh) translateX(60px) rotate(360deg);
      opacity: 0;
    }
  }
</style>

<script>
  const foodIcons = [
    "🍎", "🍌", "🍊", "🍉", "🍇", "🍍", "🍒", "🥝", "🍓",
    "🥑", "🥭", "🍅", "🥬", "🥦", "🥕", "🌽", "🧄", "🧅"
  ];

  function createFloatingIcon() {
    const icon = document.createElement("div");
    icon.classList.add("floating-icon");
    icon.textContent = foodIcons[Math.floor(Math.random() * foodIcons.length)];
    icon.style.left = Math.random() * 100 + "vw";
    icon.style.top = "100vh";
    icon.style.fontSize = (Math.random() * 20 + 20) + "px";
    icon.style.animationDuration = (Math.random() * 10 + 15) + "s";
    document.body.appendChild(icon);

    setTimeout(() => icon.remove(), 25000);
  }

  setInterval(createFloatingIcon, 600);
</script>
<!-- Flying Fruits & Veggies End -->

</body>
</html>
