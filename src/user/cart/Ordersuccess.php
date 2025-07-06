<html lang="en">
<?php include("../connect.php")?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng - Laptopshop</title>


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

    <?php
        session_start();
        include_once '../../../include/config.php';
        include_once '../layout/header.php';
        //Lấy id user
        $query = "SELECT id FROM user WHERE email = '$username'";
        $kq = mysqli_query($code, $query);
        $user= mysqli_fetch_assoc($kq);
        $userId = $user['id'];
        $name = isset($_POST['receiverName']) ? $_POST['receiverName'] : '';
        $address = isset($_POST['receiverAddress']) ? $_POST['receiverAddress'] : '';
        $phone = isset($_POST['receiverPhone']) ? $_POST['receiverPhone'] : '';
        $cartId = isset($_POST['cartId']) ? $_POST['cartId'] : '';
        
        //tạo order
        $currentDate = date("d/m/Y");
        $query = "INSERT INTO orders (userId, name, address, phone, status,date) VALUES  ($userId,'$name','$address','$phone','Đang giao', '$currentDate')";
        $kq = mysqli_query($code, $query);
        $lastInsertId = mysqli_insert_id($code); //lấy id bản ghi vừa được tạo

        //Thêm sản phẩm cào order_detail
        $query = "SELECT quantity, productId FROM cart_detail WHERE cartId = $cartId";
        $kq = mysqli_query($code, $query);
        while($cd= mysqli_fetch_assoc($kq))
        {
            $quantity = $cd['quantity'];
            $productId = $cd['productId'];
            $query = "INSERT INTO order_detail (quantity, productId, orderId) VALUES  ($quantity,$productId,$lastInsertId)";
            $kq1 = mysqli_query($code, $query);
        }

        //Xóa sản phẩm trong cart_detail
        $query = "DELETE FROM cart_detail WHERE cartId = $cartId";
        $kq = mysqli_query($code, $query);

        //Xóa giỏ hàng
        $query = "DELETE FROM cart WHERE id = $cartId";
        $kq = mysqli_query($code, $query);
        mysqli_close($code);

    ?>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <div class="container" style="margin-top: 100px;">
        <div class="row ">
            <div class="col-12 mt-5">
                <div class="alert alert-success" role="alert">
                    Cảm ơn bạn đã đặt hàng, đơn hàng đã được xác nhận thành công.
                </div>
            </div>
            <div class="col-12 mt-5">
                <a href="/VegetableWeb/src/user/index.php" class="btn btn-success">Trở về</a>
            </div>
        </div>
    </div>


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