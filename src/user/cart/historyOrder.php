<!DOCTYPE html>
<html lang="en">
<?php include("../connect.php")?>

<head>
    <meta charset="utf-8">
    <title> Lịch sử mua hàng</title>
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
    <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Spinner-->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner-->

    <?php
        include_once '../../../include/config.php';
        include_once '../layout/header.php';
    ?>

    <!-- Cart Page-->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/VegetableWeb/src/user/index.php">Trang Chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lịch sử mua hàng</li>
                    </ol>
                </nav>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Giá cả</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $query = "SELECT id FROM user WHERE email = '$username'";
                                $kq = mysqli_query($code, $query);
                                $user= mysqli_fetch_assoc($kq);
                                $userId = $user['id'];

                                $query = "select id, date, status from orders where userId = $userId";
                                $kq = mysqli_query($code, $query);
                                if (mysqli_num_rows($kq) == 0)
                                {
                                    echo '<tr>';
                                        echo '<td colspan="6">';
                                            echo 'Không có đơn hàng nào được tạo';
                                        echo '</td>';
                                    echo '</tr>';
                                }
                                else
                                {
                                    while($order= mysqli_fetch_assoc($kq))
                                    {
                                        $orderId = $order['id'];
                                        $date = $order['date'];
                        ?>
                        <tr>
                            <td colspan="3" style="color: #0f60f5;">Mã đặt đơn: <?php echo $orderId;?></td>
                            <td colspan="1" style="color: green"><?php echo $date?></td>
                            <td colspan="1" style="color:red"><?php echo $order['status']?></td>
                            <?php 
                                 $query = "SELECT p.image, p.name, p.price, od.quantity,(p.price * od.quantity) AS total_price FROM order_detail od
                                                    JOIN orders o ON od.orderId = o.id JOIN product p ON od.productId = p.id WHERE o.id = $orderId";
                                $kq1 = mysqli_query($code, $query);
                                while($od= mysqli_fetch_assoc($kq1))
                                {
                            ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <div class="d-flex align-items-center">
                                    <img src="/VegetableWeb/img/product/<?php echo $od['image']; ?>"
                                        class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                </div>
                            </th>
                            <td>
                                <p class="mb-0 mt-4">
                                    <?php echo $od['name']?>
                                </p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">
                                    <?php echo $od['price']?> $
                                </p>
                            </td>
                            <td>
                                <div class="input-group quantity mt-4" style="width: 100px;">
                                    <?php echo $od['quantity']?>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 mt-4" data-cart-detail-id="${cartDetail.id}">
                                    <?php echo $od['total_price']?> $
                                </p>
                            </td>
                        </tr>
                        <?php 
                                }
                            }
                        }
                        mysqli_close($code);
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!-- Cart Page End -->


    <jsp:include page="../layout/footer.jsp" />


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/lightbox/js/lightbox.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>