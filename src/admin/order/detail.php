<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dashboard</title>
    <link href="../resources/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <?php
        include_once '../../../include/config.php';
        include_once '../../../include/database.php';
        $username = $_SESSION['user'];
        role($username);
    ?>
</head>

<body class="sb-nav-fixed">
    <?php include_once '../layout/header.php'?>
    <div id="layoutSidenav">
        <?php include_once '../layout/sidebar.php'?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Quản lí đơn đặt hàng</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="/VitaFruit/src/admin/dashboard/show.php">Trang Chủ</a>
                        </li>
                        <li class="breadcrumb-item"><a href="/VitaFruit/src/admin/order/show.php">Danh sách</a>
                        </li>
                        <li class="breadcrumb-item active">Đơn đặt hàng</li>
                    </ol>
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-12 mx-auto">
                                <?php
                                    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                                ?>
                                <div class="d-flex justify-content-between">
                                    <h3>BẢNG ĐƠN ĐẶT HÀNG</h3>
                                    <?php
                                        $id = isset($_GET['id']) ? intval($_GET['id']) : 1;
                                        $query = "SELECT sum(p.price * od.quantity) AS total_price FROM order_detail od JOIN orders o ON od.orderId = o.id JOIN product p ON od.productId = p.id WHERE o.id = ".$id;
                                        $kq = view($query);
                                        $order = mysqli_fetch_assoc($kq);
                                        $total = $order['total_price'];
                                        $total = round($total, 1);
                                    ?>
                                    <p class="btn btn-primary">Tổng doanh thu: <?php echo number_format($total, 0, '', '.'); ?> đ</p>
                                </div>

                                <hr />
                                <table class=" table table-bordered table-hover" style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên sản phẩm:</th>
                                            <th>Giá sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Số tiền:</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                                            $page = max($page, 1);
                                            $offset = ($page - 1) * 6;
                                            $query = "SELECT od.id, p.name AS product_name, p.price, od.quantity,(p.price * od.quantity) AS total_price FROM order_detail od
                                                    JOIN orders o ON od.orderId = o.id JOIN product p ON od.productId = p.id WHERE o.id = ".$id ." LIMIT 6 OFFSET " . $offset ;
                                            $kq = view($query);
                                            $stt = 1 * $offset + 1;
                                            if ($kq && mysqli_num_rows($kq) > 0) {
                                            while ($order = mysqli_fetch_assoc($kq)) {
                                                echo "
                                                <tr>
                                                    <th>$stt</th>
                                                    <td>{$order['product_name']}</td>
                                                    <td>".number_format($order['price'], 0, '', '.')." đ</td>
                                                    <td>{$order['quantity']}</td>
                                                    <td>".number_format($order['total_price'], 0, '', '.')." đ</td>
                                                </tr>";
                                                $stt++;
                                            }
                                            } else {
                                            echo "<tr>
                                                <td colspan='5'>Không có dữ liệu</td>
                                            </tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                                    $query1 = "SELECT COUNT(*) AS total_rows FROM order_detail od join orders o on od.orderId = o.id where o.id = ".$id;
                                    $sumpage = countPage($query1, 6);
                                    $nowPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                    $nowPage = max(1, $nowPage);
                                ?>

                                <?php if ($sumpage > 1): ?>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <!-- Previous Page Link -->
                                        <li class="page-item <?php echo ($nowPage == 1) ? 'disabled' : ''; ?>">
                                            <a class="page-link"
                                                href="/VitaFruit/src/admin/order/detail.php?id=<?php echo $id; ?>&page=<?php echo $nowPage - 1; ?>"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>


                                        <!-- Page Numbers -->
                                        <?php for ($i = 1; $i <= $sumpage; $i++): ?>
                                        <li class="page-item <?php echo ($i == $nowPage) ? 'active' : ''; ?>">
                                            <a class="page-link"
                                                href="/VitaFruit/src/admin/order/detail.php?id=<?php echo $id; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                        <?php endfor; ?>

                                        <!-- Next Page Link -->
                                        <li class="page-item <?php echo ($nowPage == $sumpage) ? 'disabled' : ''; ?>">
                                            <a class="page-link"
                                                href="/VitaFruit/src/admin/order/detail.php?id=<?php echo $id; ?>&page=<?php echo $nowPage + 1; ?>"
                                                aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                                <?php endif; ?>

                            </div>

                        </div>

                    </div>
                </div>
            </main>
            <?php 
            include_once '../layout/footer.php'
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>\
    <script src="../resources/js/scripts.js"></script>


</body>

</html>