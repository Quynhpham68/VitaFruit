 <!DOCTYPE html>
    <?php include("connect.php")?>
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
        <link
            href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Poppins&display=swap" 

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

        <!-- Spinner Start -->
        <div id="spinner"
            class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->

        <?php
        session_start();
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
        include_once 'layout/header.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $form = $_POST['form'];
            if ($form == 'form1')
            {
                $rvId = $_POST['id'];
                $query = "DELETE FROM review WHERE id = $rvId";
                $kq = mysqli_query($code, $query);
            }
            else
            {
                $star = $_POST['star'];
                $detail = $_POST['detail'];
                $productId = $_GET['id'];
                $query = "select id from user where email = '$username'";
                $kq = mysqli_query($code, $query);
                $row = mysqli_fetch_assoc($kq);
                $userId = $row['id'];
                $query = "INSERT INTO review (star, review_detail, userId, productId) VALUES ($star,'$detail',$userId,$productId)";
                $kq = mysqli_query($code, $query);
            }

        }
    ?>


        <div class="container-fluid py-5 mt-5">
            <div class="container py-5">
                <div class="row g-4 mb-5">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/VitaFruit/src/user/index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi Tiết Sản Phẩm</li>
                            </ol>
                        </nav>
                    </div>
                    <?php
                    $id = $_GET['id'];
                    $query = "select * from product where id = $id";
                    $kq = mysqli_query($code, $query);
                    $product = mysqli_fetch_assoc($kq);
                    $query = "SELECT AVG(star) AS average_star FROM review WHERE productId = $id";
                    $kq1 = mysqli_query($code, $query);
                    $star = mysqli_fetch_assoc($kq1);
                    if ($star['average_star'] === NULL)
                        $avg = 5;
                    else
                        $avg = (int)$star['average_star'];
                ?>
                    <div class="col-lg-8 col-xl-9">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="border rounded">
                                    <a href="#">
                                        <img src="/VitaFruit/img/product/<?php echo $product['image']?>"
                                            class="img-fluid rounded" alt="Image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="fw-bold mb-3" style="color: rgba(214, 55, 55, 0.8); font-size:2rem;">
                                    <?php echo $product['name'] ?></h4>
                                <p class="mb-4"><?php echo $product['category']?></p>
                                <p class="mb-4">Đã bán: <?php echo $product['sold'] ?></p>
                                <h5 class="fw-bold mb-3">
                                    <?php
                                    $price = floatval($product['price']); 
                                    $discountPrice = !empty($product['discount_price']) ? floatval($product['discount_price']) : 0;
                                    ?>

                                    <div style="font-family: 'Open Sans', sans-serif; line-height:1.4;">
                                        <?php if($discountPrice > 0 && $discountPrice < $price): 
                                            $percent = round((($price - $discountPrice)/$price)*100); ?>
                                            
                                            <!-- Giá giảm -->
                                            <span style="font-family: 'Open Sans', sans-serif; font-weight:700; font-size:1.25rem; color:#333; display:block; margin-bottom:5px;">
                                                <?= number_format($discountPrice, 0, ',', '.') ?> / kg
                                            </span>
                                            
                                            <!-- Giá gốc + % giảm trên cùng 1 dòng -->
                                            <span style="font-family: 'Open Sans', sans-serif; font-size:1rem; color:#6c757d; text-decoration:line-through; margin-right:10px;">
                                                <?= number_format($price, 0, ',', '.') ?>
                                            </span>
                                            <span style="font-family: 'Open Sans', sans-serif; font-size:1rem; color:#d63737; font-weight:600;">
                                                Giảm: <?= $percent ?>%
                                            </span>
                                            
                                        <?php else: ?>
                                            <!-- Giá bình thường -->
                                            <span style="font-family: 'Open Sans', sans-serif; font-weight:700; font-size:1.5rem; color:#555; display:block;">
                                                <?= number_format($price, 0, ',', '.') ?> / kg
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </h5>


                                <div class="d-flex mb-4">
                                    Xếp hạng:
                                    <?php
                                    for($i = 1; $i <= 5; $i++)
                                    {
                                        if($i <= $avg)
                                            echo '<i class="fa fa-star text-secondary"></i>';
                                        else
                                            echo '<i class="fa fa-star"></i>';

                                    }
                                ?>
                                </div>
                                <p class="mb-3"><?php echo $product['short_desc'] ?></p>
                                <form action="/VitaFruit/src/user/cart/addToCart.php" method="post">
                                    <input type="hidden" name="idProduct" value="<?php echo $id?>" />
                                    <button type="submit"
                                        class="mx-auto btn border border-secondary rounded-pill px-3 text-primary">
                                        <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                        Thêm vào giỏ hàng
                                    </button>

                                </form>
                            </div>
                            <div class="col-lg-12">
                                <nav>
                                    <div class="nav nav-tabs mb-3">
                                        <button class="nav-link active border-white border-bottom-0" type="button"
                                            role="tab" id="nav-about-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-about" aria-controls="nav-about"
                                            aria-selected="true">Miêu tả chi tiết</button>
                                        <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                            id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                            aria-controls="nav-mission" aria-selected="false">Đánh giá</button>
                                    </div>
                                </nav>
                                <div class="tab-content mb-5">
                                    <div class="tab-pane active" id="nav-about" role="tabpanel"
                                        aria-labelledby="nav-about-tab">
                                        <p><?php echo $product['details_desc']?></p>
                                    </div>
                                    <div class="tab-pane" id="nav-mission" role="tabpanel"
                                        aria-labelledby="nav-mission-tab">
                                        <?php
                                        $query = "SELECT r.id, r.star,r.review_detail, u.name, u.email, u.image FROM review r join user u on r.userId = u.id WHERE productId = $id";
                                        $kq = mysqli_query($code, $query);
                                        if(mysqli_num_rows($kq) == 0)
                                        {
                                    ?>
                                        <tr>
                                            <td colspan="6">
                                                Chưa có đánh giá.
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        else
                                        {
                                            while($review = mysqli_fetch_assoc($kq))
                                            {
                                    ?>
                                        <div class="d-flex">
                                            <img src="/VitaFruit/img/avatar/<?php echo $review['image']?>"
                                                class="img-fluid rounded-circle p-3"
                                                style="width: 100px; height: 100px;" alt="">
                                            <div class="">
                                                <?php 
                                                    if($username == $review['email'])
                                                    {
                                                ?>
                                                <form action="" method="post">
                                                    <input type="hidden" name="form" value="form1">
                                                    <input style="display: none;" name="id"
                                                        value="<?php echo $review['id']?>" />
                                                    <button class="btn btn-danger">Xóa</button>
                                                </form>
                                                <?php }?>
                                                <div class="d-flex justify-content-between">
                                                    <h5><?php echo $review['name']?></h5>
                                                    <div class="d-flex mb-3 ">
                                                        <?php 
                                                            for($i = 1; $i <= 5; $i++)
                                                                if($i <= $review['star'])
                                                                    echo '<i class="fa fa-star text-secondary"></i>';
                                                                else
                                                                    echo '<i class="fa fa-star"></i>';
                                                        ?>
                                                    </div>
                                                </div>
                                                <p>
                                                    <?php echo $review['review_detail']?>
                                                </p>
                                            </div>


                                        </div>
                                        <?php
                                            }
                                        }
                                        mysqli_close($code);
                                        ?>
                                    </div>
                                </div>
                                <h4 class="mb-5 fw-bold">Thêm đánh giá:</h4>
                                <div class="col-lg-12 s">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center" data-start="5">
                                            <p class="mb-0 me-3">Đánh giá:</p>
                                            <div class="d-flex align-items-center stars" style="font-size: 12px;">
                                                <button style="border: 0; padding: 0;" class="fa fa-star text-secondary"
                                                    data-index="1"></button>
                                                <button style="border: 0; padding: 0;" class="fa fa-star"
                                                    data-index="2"></button>
                                                <button style="border: 0; padding: 0;" class="fa fa-star"
                                                    data-index="3"></button>
                                                <button style="border: 0; padding: 0;" class="fa fa-star"
                                                    data-index="4"></button>
                                                <button style="border: 0; padding: 0;" class="fa fa-star"
                                                    data-index="5"></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <form action="" method="post">
                                    <input type="hidden" name="form" value="form2">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="border-bottom rounded">
                                                <textarea class="form-control border-0" cols="120" rows="8"
                                                    placeholder="Miêu tả đánh giá:" name="detail" type="text"
                                                    spellcheck="false"></textarea>
                                            </div>
                                            <input type="hidden" id="ratingInput" name="star" value="1" />
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="btn border border-secondary text-primary rounded-pill px-4 py-3"
                                        style="margin: 5px;">
                                        Lưu đánh giá</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-3">
                            <div class="row g-4 fruite">
                                <div class="col-lg-12">
                                </div>
                                <div class="col-lg-12">
                                    <div class="position-relative">
                                        <img src="img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                        <div class="position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%);">
                                            <h3 class="text-secondary fw-bold">Vita <br> Fruits <br> Banner</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
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
    </body>