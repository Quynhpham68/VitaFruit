<!DOCTYPE html>
<html lang="en">
<?php include("../connect.php")?>

<head>
    <meta charset="utf-8">
    <title> Thanh toán</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">


    <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">



    <link href="../css/bootstrap.min.css" rel="stylesheet">


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
        $index= isset($_GET['index']) ? (int)$_GET['index'] : 0;
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            for($i = 0; $i < $index; $i++)
            {
                $cartId = $_POST["id$i"];
                $quantity = $_POST["quantity$i"];
                $query = "UPDATE cart_detail SET quantity = $quantity WHERE id = $cartId";
                mysqli_query($code, $query);

                $query = "select p.quantity, p.sold, p.id from cart_detail cd join product p on cd.productId = p.id where cd.id  = $cartId";
                $kq = mysqli_query($code, $query);
                $product = mysqli_fetch_assoc($kq);
                $quantityP= $product['quantity'] - $quantity;
                $soldP = $product['sold'] + $quantity;
                $productId = $product['id'];
                $query = "UPDATE product SET quantity = $quantityP, sold = $soldP WHERE id = $productId";
                mysqli_query($code, $query);
            }
        }
    ?>

    <!-- Cart-->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/VitaFruit/src/user/index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thông tin thanh toán</li>
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
                         $query = "SELECT c.id FROM cart c JOIN user u ON c.userId = u.id WHERE u.email = '".$username."'";
                         $kq = mysqli_query($code, $query);
                         $tmp = mysqli_num_rows($kq);
                         $cart = mysqli_fetch_assoc($kq);
                         $idCart = $cart['id'];
                         $query = "SELECT SUM(cd.quantity * IF(p.discount_price>0, p.discount_price, p.price)) as total
                                    FROM cart_detail cd
                                    JOIN product p ON cd.productId = p.id
                                    WHERE cd.cartId = ".$idCart;
                            $kq1 = mysqli_query($code, $query);
                            $sum = mysqli_fetch_assoc($kq1);
                            $totalPrice = $sum['total'];
                         if ($kq && mysqli_num_rows($kq) == 0) {
                             echo '<tr>';
                             echo '<td colspan="6">Không có sản phẩm trong giỏ hàng</td>';
                             echo '</tr>';
                         }
                         else {
                            $query = "SELECT p.image, p.name, p.price, p.discount_price, cd.quantity, 
                                            (cd.quantity * IF(p.discount_price>0, p.discount_price, p.price)) as tien,
                                            IF(p.discount_price>0, p.discount_price, p.price) as cdPrice
                                    FROM cart_detail cd 
                                    JOIN product p ON cd.productId = p.id 
                                    WHERE cd.cartId = ".$idCart;
                            $kq = mysqli_query($code, $query);
                            while ($cd = mysqli_fetch_assoc($kq)) {
                        ?>
                        <tr>
                            <th scope="row">
                                <div class="d-flex align-items-center">
                                    <img src="/VitaFruit/img/product/<?php echo $cd['image']; ?>"
                                        class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                </div>
                            </th>
                            <td>
                                <p class="mb-0 mt-4">
                                    <a href="" target="_blank">
                                        <?php echo $cd['name']; ?>
                                    </a>
                                </p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4" style="font-family: 'Open Sans', sans-serif; font-size: 1rem; line-height: 1.25;">
                                    <?php 
                                        if($cd['discount_price'] > 0) {
                                            // Giá gốc
                                            echo '<span class="text-decoration-line-through text-muted me-2" style="font-family: \'Open Sans\', sans-serif;">' . number_format($cd['price'], 0, ',', '.') . ' đ</span>';
                                            
                                            // Giá giảm
                                            echo '<span class="text-danger" style="font-family: \'Open Sans\', sans-serif;">' . number_format($cd['cdPrice'], 0, ',', '.') . ' đ</span>';
                                        } else {
                                            // Giá bình thường
                                            echo '<span style="font-family: \'Open Sans\', sans-serif;">' . number_format($cd['price'], 0, ',', '.') . ' đ</span>';
                                        }
                                    ?>
                                </p>
                            </td>
                            <td>
                                <div class="input-group quantity mt-4" style="width: 100px;">
                                    <p class="form-control form-control-sm text-center border-0">
                                        <?php echo $cd['quantity']; ?></p>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">
                                    <?php echo number_format($cd['cdPrice'] * $cd['quantity'], 0, ',', '.'); ?>
                                </p>
                            </td>

                        </tr>
                        <?php 
                                    } 
                                }
                            ?>

                    </tbody>
                </table>
            </div>
            <?php 
                if($tmp > 0)
                {
            ?>
            <form action="/VitaFruit/src/user/cart/Ordersuccess.php" method="post">
                <div class="mt-5 row g-4 justify-content-start">
                    <div class="col-12 col-md-6">
                        <div class="p-4 ">
                            <h5>Thông Tin Người Nhận
                            </h5>
                            <div class="row">
                                <div class="col-12 form-group mb-3">
                                    <label>Tên người nhận</label>
                                    <input class="form-control" name="receiverName" required />
                                </div>
                                <div class="col-12 form-group mb-3">
                                    <label>Địa chỉ người nhận</label>
                                    <input class="form-control" name="receiverAddress" required />
                                </div>
                                <div class="col-12 form-group mb-3">
                                    <label>Số điện thoại</label>
                                    <input class="form-control" name="receiverPhone" required />
                                </div>
                                <input type="hidden" name="cartId" value="<?php echo $idCart?>">
                                <div class="mt-4">
                                    <i class="fas fa-arrow-left"></i>
                                    <a href="/VitaFruit/src/user/cart/show.php">Quay lại giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="order-heading mb-4" style="font-family: 'Open Sans', sans-serif; font-weight: 900;">Thông Tin <span class="fw-normal">Thanh
                                        Toán</span>
                                </h1>

                                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                                    <h5 class="mb-0">Phí vận chuyển</h5>
                                    <div>
                                        <p class="mb-0">0 đ</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                <h5 class="mb-3 mt-4">Hình thức thanh toán</h5>
                                <div class="d-flex flex-column align-items-start">
                                    <div class="form-check mb-2 d-flex align-items-center">
                                        <input class="form-check-input" type="radio" name="paymentMethod" value="COD" id="cod" checked>
                                        <label class="form-check-label ms-2" for="cod">
                                            Thanh toán khi nhận hàng (COD)
                                        </label>
                                    </div>
                                    <!-- <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input" type="radio" name="paymentMethod" value="VNPay" id="vnpay">
                                        <label class="form-check-label ms-2" for="vnpay">
                                            Thanh toán bằng tài khoản ngân hàng (VNPay)
                                        </label>
                                    </div> -->
                                </div>

                            </div>

                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Tổng số tiền</h5>
                                <p class="mb-0 pe-4">
                                    <?php echo number_format($totalPrice, 0, ',', '.'); ?>
                                </p>

                            </div>
                            <?php mysqli_close($code); ?>
                            <button
                                class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">
                                Xác nhận thanh toán
                            </button>

                        </div>
                    </div>
                </div>
            </form>
            <?php
                }
            ?>

        </div>
    </div>
    <!-- Cart-->

    <!-- Trở về top-->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Thư viện -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/lightbox/js/lightbox.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>


    <script src="../js/main.js"></script>
</body>

</html>