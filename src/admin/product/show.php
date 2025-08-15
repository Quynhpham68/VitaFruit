<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="MT" />
    <meta name="author" content="MT" />
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
                    <h1 class="mt-4">Quản lí sản phẩm</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="/VegetableWeb/src/admin/dashboard/show.php">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active">Sản phẩm</li>
                    </ol>
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-12 mx-auto">
                                <div class="d-flex justify-content-between">
                                    <h3>DANH SÁCH SẢN PHẨM ĐÃ DUYỆT</h3>
                                    <a href="/VegetableWeb/src/admin/product/create.php" class="btn btn-primary">Tạo
                                        sản phẩm
                                        mới</a>
                                </div>

                                <hr />
                                <table class=" table table-bordered table-hover" style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">ID</th>
                                            <th style="width: 10%;">Tên sản phẩm</th>
                                            <th style="width: 8%;">Giá sản phẩm</th>
                                            <th style="width: 5%;">Khuyến mãi (%)</th>
                                            <th style="width: 10%;">Giá sau khuyến mãi</th>
                                            <th style="width: 12%;">Nhà sản xuất</th>
                                            <th style="width: 5%;">SL còn lại</th>
                                            <th style="width: 5%;">SL đã bán</th>
                                            <th style="width: 8%;">Phân loại</th>
                                            <th style="width: 25%;">Vai trò</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                                            $page = max($page, 1);
                                            $offset = ($page - 1) * 6;
                                            $query = "SELECT id, name, price, factory, quantity, sold, category, discount_percent FROM product ORDER BY id LIMIT 6 OFFSET " . $offset ;
                                            $kq = view($query);
                                            if ($kq && mysqli_num_rows($kq) > 0) {
                                            while ($product = mysqli_fetch_assoc($kq)) {
                                                $discount_price = $product['price'] * (1 - $product['discount_percent'] / 100);
                                                echo "
                                                <tr>
                                                    <th>{$product['id']}</th>
                                                    <td>{$product['name']}</td>
                                                    <td>" . number_format($product['price'], 0, ',', '.') . " đ</td>
                                                    <td>{$product['discount_percent']}%</td>
                                                    <td>" . number_format($discount_price, 0, ',', '.') . " đ</td>
                                                    <td>{$product['factory']}</td>
                                                    <td>{$product['quantity']}</td>
                                                    <td>{$product['sold']}</td>
                                                    <td>{$product['category']}</td>
                                                    <td>
                                                        <a href='/VegetableWeb/src/admin/product/detail.php?id={$product['id']}' class='btn btn-success'>Xem chi tiết</a>
                                                        <a href='/VegetableWeb/src/admin/product/update.php?id={$product['id']}' class='btn btn-warning mx-2'>Cập nhật</a>
                                                        <a href='/VegetableWeb/src/admin/product/delete.php?id={$product['id']}' class='btn btn-danger'>Xóa</a>
                                                    </td>
                                                </tr>";
                                            }

                                            } else {
                                            echo "<tr>
                                                <td colspan='7'>Không có dữ liệu</td>
                                            </tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                                    $query1 = "SELECT COUNT(*) AS total_rows FROM product";
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
                                                href="/VegetableWeb/src/admin/product/show.php?page=<?php echo $nowPage - 1; ?>"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>

                                        <!-- Page Numbers -->
                                        <?php for ($i = 1; $i <= $sumpage; $i++): ?>
                                        <li class="page-item <?php echo ($i == $nowPage) ? 'active' : ''; ?>">
                                            <a class="page-link"
                                                href="/VegetableWeb/src/admin/product/show.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                        <?php endfor; ?>

                                        <!-- Next Page Link -->
                                        <li class="page-item <?php echo ($nowPage == $sumpage) ? 'disabled' : ''; ?>">
                                            <a class="page-link"
                                                href="/VegetableWeb/src/admin/product/show.php?page=<?php echo $nowPage + 1; ?>"
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
            include_once '../layout/footer.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../resources/js/scripts.js"></script>

</body>

</html>