<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
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
                        <li class="breadcrumb-item"><a href="/VitaFruit/src/admin/dashboard/show.php">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active">Sản phẩm</li>
                    </ol>
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-12 mx-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Thanh tìm kiếm -->
                                    <form class="d-flex" method="GET" action="">
                                        <input 
                                            class="form-control me-2" 
                                            type="search" 
                                            name="keyword" 
                                            placeholder="Tìm sản phẩm..." 
                                            value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>"
                                            id="searchInput"
                                        >
                                        <button class="btn btn-primary" type="submit">Tìm</button>
                                    </form>

                                    <script>
                                    document.getElementById('searchInput').addEventListener('search', function () {
                                        if (this.value === "") {
                                            window.location.href = "show.php"; // trả về danh sách ban đầu
                                        }
                                    });
                                    </script>


                                    <!-- Nút tạo sản phẩm -->
                                    <a href="/VitaFruit/src/admin/product/create.php" class="btn btn-primary">Tạo sản phẩm mới</a>
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

                                             // Lấy từ khóa tìm kiếm
                                            $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
                                            $where = "";
                                            if ($keyword !== "") {
                                                $keyword_safe = addslashes($keyword);
                                                $where = "WHERE name LIKE '%$keyword_safe%' OR factory LIKE '%$keyword_safe%'";
                                            }


                                            // Query sản phẩm
                                            $query = "SELECT id, name, price, factory, quantity, sold, category, discount_percent 
                                                    FROM product 
                                                    $where
                                                    ORDER BY id 
                                                    LIMIT 6 OFFSET " . $offset;
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
                                                        <a href='/VitaFruit/src/admin/product/detail.php?id={$product['id']}' class='btn btn-success'>Xem chi tiết</a>
                                                        <a href='/VitaFruit/src/admin/product/update.php?id={$product['id']}' class='btn btn-warning mx-2'>Cập nhật</a>
                                                        <a href='/VitaFruit/src/admin/product/delete.php?id={$product['id']}' class='btn btn-danger'>Xóa</a>
                                                    </td>
                                                </tr>";
                                            }

                                            } else {
                                            echo "<tr>
                                                <td colspan='7'>Không có dữ liệu</td>
                                            </tr>";
                                            }
                                            // Đếm tổng số sản phẩm cho phân trang
                                            $query1 = "SELECT COUNT(*) AS total_rows FROM product $where";
                                            $result = view($query1);
                                            $row = mysqli_fetch_assoc($result);
                                            $total_rows = $row['total_rows'] ?? 0;
                                            $sumpage = ceil($total_rows / 6);
                                            $nowPage = max(1, $page);

                                        ?>
                                    </tbody>
                                </table>
                              
                                <?php if ($sumpage > 1): ?>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <!-- Previous -->
                                        <li class="page-item <?php echo ($nowPage == 1) ? 'disabled' : ''; ?>">
                                            <a class="page-link"
                                                href="/VitaFruit/src/admin/product/show.php?page=<?php echo $nowPage - 1; ?>&keyword=<?php echo urlencode($keyword); ?>"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>

                                        <!-- Page numbers -->
                                        <?php for ($i = 1; $i <= $sumpage; $i++): ?>
                                        <li class="page-item <?php echo ($i == $nowPage) ? 'active' : ''; ?>">
                                            <a class="page-link"
                                                href="/VitaFruit/src/admin/product/show.php?page=<?php echo $i; ?>&keyword=<?php echo urlencode($keyword); ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                        <?php endfor; ?>

                                        <!-- Next -->
                                        <li class="page-item <?php echo ($nowPage == $sumpage) ? 'disabled' : ''; ?>">
                                            <a class="page-link"
                                                href="/VitaFruit/src/admin/product/show.php?page=<?php echo $nowPage + 1; ?>&keyword=<?php echo urlencode($keyword); ?>"
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