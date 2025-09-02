<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />   
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Trang Chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../resources/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<?php 
    include_once '../../../include/config.php' ;
    include_once '../../../include/database.php';
    $username = $_SESSION['user'];
    role($username);
?>

<body class="sb-nav-fixed">
    <?php include_once '../layout/header.php'?>
    <div id="layoutSidenav">
        <?php include_once '../layout/sidebar.php'?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Trang Chủ</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Thống kê</li>
                    </ol>
                    <?php
                        $countUsers = countSum("user");
                        $countProducts = countSum("product");
                        $countReview = countSum("review");
                        $countOrders = countSum("orders");
                        $query = "SELECT sum(p.price * od.quantity) AS total_price FROM order_detail od JOIN orders o ON od.orderId = o.id JOIN product p ON od.productId = p.id";
                        $kq2 = view($query);
                        $doanhThu = mysqli_fetch_assoc($kq2);
                        $total = $doanhThu['total_price'];
                        $total = round($total, 1);
                    ?>
                    <div class="row">
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Số lượng người dùng: <?php echo $countUsers; ?></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link"
                                        href="/VitaFruit/src/admin/user/show.php?page=1r">Xem chi
                                        tiết</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Số lượng sản phẩm: <?php echo $countProducts; ?></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link"
                                        href="/VitaFruit/src/admin/product/show.php?page=1">Xem chi
                                        tiết</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Số lượng đánh giá: <?php echo $countReview; ?></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link"
                                        href="/VitaFruit/src/admin/review/show.php?page=1">Xem chi
                                        tiết</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-dark text-white mb-4">
                                <div class="card-body">Số lượng đơn đặt hàng: <?php echo $countOrders; ?></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link"
                                        href="/VitaFruit/src/admin/order/show.php?page=1">Xem chi
                                        tiết</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-dark text-white mb-4">
                                <div class="card-body">Tổng doanh thu: <?php echo number_format($total, 0, '', '.'); ?> đ
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <p class="small text-white stretched-link"></p>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </main>
            <?php
            include_once '../layout/footer.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../resources/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous">
    </script>
    <script src="../resources/js/chart-area-demo.js"></script>
    <script src="../resources/js/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../resources/js/datatables-simple-demo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>

</html>