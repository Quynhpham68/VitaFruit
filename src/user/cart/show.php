<!DOCTYPE html>
<html lang="en">
<?php include("../connect.php")?>

<head>
    <meta charset="utf-8">
    <title> Giỏ hàng</title>
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
    <!-- Cart-->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/VegetableWeb/src/user/index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chi Tiết Giỏ Hàng</li>
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
                            <th scope="col">Xử lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT c.id FROM cart c JOIN user u ON c.userId = u.id WHERE u.email = '".$username."'";
                            $kq = mysqli_query($code, $query);
                            $tmp = 0;
                            if (mysqli_num_rows($kq) == 0) {
                                echo '<tr>';
                                echo '<td colspan="6">Không có sản phẩm trong giỏ hàng</td>';
                                echo '</tr>';
                            } 

                            else {
                                $cart = mysqli_fetch_assoc($kq);
                                $cartId = $cart['id'];
                                $query = "SELECT cd.id, p.image, p.name, p.price, p.discount_price, cd.quantity,
                                                (cd.quantity * IF(p.discount_price>0, p.discount_price, p.price)) as tien,
                                                p.quantity as slP, 
                                                IF(p.discount_price>0, p.discount_price, p.price) as cdPrice
                                        FROM cart_detail cd 
                                        JOIN product p ON cd.productId = p.id 
                                        WHERE cd.cartId = ".$cartId;
                                $kq = mysqli_query($code, $query);
                                $tmp = mysqli_num_rows($kq);
                                if (mysqli_num_rows($kq) == 0) {
                                    echo '<tr>';
                                    echo '<td colspan="6">Không có sản phẩm trong giỏ hàng</td>';
                                    echo '</tr>';
                                } 
                                else
                                {
                                    $query = "SELECT sum(price * quantity) as sum from cart_detail where cartId = ".$cartId;
                                    $kq1 = mysqli_query($code, $query);
                                    $sum = mysqli_fetch_assoc($kq1);
                                    $totalPrice = $sum['sum'];
                                    // Khởi tạo biến đếm $index
                                    $index = 0;
    
                                    while ($cd = mysqli_fetch_assoc($kq)) {
                                        ?>

                        <tr>
                            <th scope="row">
                                <div class="d-flex align-items-center">
                                    <img src="/VegetableWeb/img/product/<?php echo $cd['image']; ?>"
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
                                <p class="mb-0 mt-4">
                                    <?php 
                                        if($cd['discount_price'] > 0) {
                                            echo '<span class="text-decoration-line-through text-muted me-2">'.number_format($cd['price'], 0, ',', '.').' đ</span>';
                                            echo '<span class="text-danger">'.number_format($cd['cdPrice'], 0, ',', '.').' đ</span>';
                                        } else {
                                            echo number_format($cd['price'], 0, ',', '.') . ' đ';
                                        }
                                    ?>
                                </p>
                            </td>

                            <td>
                                <div class="input-group quantity mt-4" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm text-center border-0"
                                        value="<?php echo $cd['quantity']; ?>"
                                        data-cart-detail-id="<?php echo $cd['id']; ?>"
                                        data-cart-detail-price="<?php echo $cd['cdPrice']; ?>"
                                        data-cart-detail-index="<?php echo $index; ?>"
                                        quantity1="<?php echo $cd['slP']; ?>">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <p class="mb-0 mt-4" data-cart-detail-id="<?php echo $cd['id']; ?>">
                                    <?php echo number_format($cd['cdPrice'] * $cd['quantity'], 0, ',', '.'); ?> đ
                                </p>
                            </td>

                            <td>
                                <form method="post"
                                    action="/VegetableWeb/src/user/cart/delete.php?cartId=<?php echo $cartId?>&cdId=<?php echo $cd['id']; ?>">
                                    <button class="btn btn-md rounded-circle bg-light border mt-4">
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php
                                    $index++;
                                }
                            }
                                }
                            ?>

                    </tbody>
                </table>
                <?php if ($tmp> 0): ?>
                <div class="mt-5 row g-4 justify-content-start">
                    <div class="col-12 col-md-8">
                        <div class="bg-light rounded">
                            <div class="p-4" style="font-family: 'Open Sans', sans-serif; font-size: 16px; color: #333;">
                                <h1 class="order-heading mb-4">Thông Tin <span class="fw-normal">Đơn
                                        Hàng</span>
                                </h1>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Tạm tính:</h5>
                                    <p class="mb-0" data-cart-total-price="<?php echo $totalPrice ?>">
                                        <?php echo number_format($totalPrice, 0, ',', '.'); ?> đ
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Phí vận chuyển</h5>
                                    <div class="">
                                        <p class="mb-0">0 đ</p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Tổng số tiền</h5>
                                <p class="mb-0" data-cart-total-price="<?php echo $totalPrice ?>">
                                    <?php echo number_format($totalPrice, 0, ',', '.'); ?> đ
                                </p>
                            </div>
                            <form action="/VegetableWeb/src/user/cart/checkout.php?index=<?php echo $index?>"
                                method="post">
                                <div>
                                    <?php
                                            $index = 0;
                                            $query = "SELECT cd.id, p.image, p.name, p.price, cd.quantity, (cd.quantity * p.price) as tien, p.quantity as slP, cd.price as cdPrice 
                                                    FROM cart_detail cd JOIN product p ON cd.productId = p.id WHERE cd.cartId = ".$cartId;
                                            $kq = mysqli_query($code, $query);
                                            while ($cd = mysqli_fetch_assoc($kq)) {
                                        ?>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" type="text"
                                                value="<?php echo $cd['id']; ?>" name="id<?php echo $index; ?>" />
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="quantity<?php echo $index; ?>"
                                                type="text" value="<?php echo $cd['quantity']; ?>"
                                                name="quantity<?php echo $index; ?>" />
                                        </div>
                                    </div>
                                    <?php
                                                $index++;
                                            }
                                        ?>
                                </div>
                                <?php mysqli_close($code); ?>
                                <button
                                    class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">
                                    Xác nhận thanh toán
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Cart-->
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