<!DOCTYPE html>
<?php include("connect.php")?>
<?php
        session_start();
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>VitaFruit Website</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="Search">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Poppins&display=swap" rel="stylesheet">


    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/home.css" rel="stylesheet">

</head>

<body>

    <?php
        session_start();
    ?>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar start -->

    <?php
        include_once 'layout/header.php';
    ?>

    <!-- Navbar End -->



   <!-- Panel Start -->
<div class="col-md-12 col-lg-12">
    <div class="img_container" style="display: flex; justify-content: center; position: relative; margin-top: 85px;"> <!-- giảm từ 95px xuống 50px -->

        <img src="./img/trang chủ.png" alt=""
            style="max-width: 100%; max-height: 80vh; height: auto; width: auto; object-fit: contain; border-radius: 12px; box-shadow: 0 0 40px rgba(0,0,0,0.05);">

       <button class="shop-now-btn" onclick="document.getElementById('featured-products').scrollIntoView({ behavior: 'smooth' });">
    SHOP NOW
</button>
    </div>
</div>
<!-- Panel End -->


    <!-- Fruits Shop Start-->
    <div id="featured-products" class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>SẢN PHẨM NỔI BẬT</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <div class="d-flex justify-content-end mb-4">
                      <div class="dropdown">
                        <button class="btn btn-outline-success dropdown-toggle rounded-pill px-4 py-2 bg-light text-dark"
                                type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Tất cả sản phẩm
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                            <li><a class="dropdown-item active" data-tab="#tab-1" href="#">Tất cả sản phẩm</a></li>
                            <li><a class="dropdown-item" data-tab="#tab-2" href="#">Rau Củ</a></li>
                            <li><a class="dropdown-item" data-tab="#tab-3" href="#">Hoa quả</a></li>
                        </ul>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <!-- Tab All Products -->
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <?php
                                        $qr = mysqli_query($code, "SELECT * FROM product limit 8");

                                        while ($row = mysqli_fetch_assoc($qr)) {
                                            $imagePath = "/VegetableWeb/img/product/" . $row['image'];
                                            ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <a href="./shop-detail.php?id=<?php echo $row['id']; ?>"
                                            class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="<?php echo $imagePath; ?>" class="img-fluid w-100 rounded-top"
                                                    style="height: 200px; object-fit: cover;">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">
                                                <?php echo $row['category']; ?>
                                            </div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4><?php echo $row['name']; ?></h4>
                                                <p><?php echo $row['short_desc']; ?></p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0 price">
                                                        $<?php echo $row['price']; ?> / kg</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Vegetables -->
                    <div id="tab-2" class="tab-pane fade p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <?php
                                        $qr = mysqli_query($code, "SELECT * FROM product WHERE category = 'Rau Củ' LIMIT 8");

                                        while ($row = mysqli_fetch_assoc($qr)) {
                                            $imagePath = "/VegetableWeb/img/product/" . $row['image'];
                                            ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <a href="./shop-detail.php?id=<?php echo $row['id']; ?>"
                                            class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="<?php echo $imagePath; ?>" class="img-fluid w-100 rounded-top"
                                                    style="height: 200px; object-fit: cover;">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">
                                                <?php echo $row['category']; ?>
                                            </div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4><?php echo $row['name']; ?></h4>
                                                <p><?php echo $row['short_desc']; ?></p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0 price">
                                                        $<?php echo $row['price']; ?> / kg</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Fruits -->
                    <div id="tab-3" class="tab-pane fade p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <?php
                                        $qr = mysqli_query($code, "SELECT * FROM product WHERE category = 'Hoa quả' LIMIT 8");

                                        while ($row = mysqli_fetch_assoc($qr)) {
                                            $imagePath = "/VegetableWeb/img/product/" . $row['image'];
                                            ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <a href="./shop-detail.php?id=<?php echo $row['id']; ?>"
                                            class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="<?php echo $imagePath; ?>" class="img-fluid w-100 rounded-top"
                                                    style="height: 200px; object-fit: cover;">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">
                                                <?php echo $row['category']; ?>
                                            </div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4><?php echo $row['name']; ?></h4>
                                                <p><?php echo $row['short_desc']; ?></p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0 price">
                                                        $<?php echo $row['price']; ?> / kg</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->





    <!-- FOOTER -->
    <?php include_once 'layout/footer.php'; ?>
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function () {
        // Xóa active cũ ở dropdown
        document.querySelectorAll('.dropdown-item').forEach(i => i.classList.remove('active'));
        this.classList.add('active');

        // Ẩn tất cả tab
        document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('show', 'active'));

        // Hiện tab được chọn
        const target = this.getAttribute('data-tab');
        const selectedTab = document.querySelector(target);
        if (selectedTab) {
            selectedTab.classList.add('show', 'active');
        }

        // Cập nhật nội dung trên nút dropdown
        document.getElementById('filterDropdown').textContent = this.textContent;
        });
    });
    </script>
    <script src="js/floating_icons.js"></script>



</body>

</html>