<!DOCTYPE html>
<?php include("connect.php")?>
<?php
        session_start();
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Fruitables - Vegetable Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

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
        <div class="img_container" style="display: flex; justify-content: center;">
            <img src="./img/Minimalist Fresh Market Instagram Post.png" alt=""
                style="height: 550px; width: 550px; object-fit: contain; margin-top: 108px;">
        </div>
    </div>
    <!-- Panel End -->

    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Sản phẩm nổi bật</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill"
                                    href="#tab-1">
                                    <span class="text-dark" style="width: 130px;">Tất cả sản phẩm</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                                    <span class="text-dark" style="width: 130px;">Rau</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3">
                                    <span class="text-dark" style="width: 130px;">Hoa quả</span>
                                </a>
                            </li>
                        </ul>
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
                                        $qr = mysqli_query($code, "SELECT * FROM product WHERE category = 'Rau' LIMIT 8");

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





    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        <div class="container py-5">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <a href="#">
                            <h1 class="text-primary mb-0">Fruitables</h1>
                            <p class="text-secondary mb-0">Fresh products</p>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex justify-content-end pt-3">
                            <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

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
</body>

</html>