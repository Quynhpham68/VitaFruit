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
                    <h1 class="mt-4">Đánh giá</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="/VitaFruit/src/admin/dashboard/show.php">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active">Đánh giá</li>
                    </ol>
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-12 mx-auto">
                                <div class="d-flex justify-content-between">
                                    <h3>DANH SÁCH ĐÁNH GIÁ CỦA SẢN PHẨM</h3>
                                </div>
                                <hr />
                                <table class=" table table-bordered table-hover" style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Người đánh giá</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Số sao</th>
                                            <th>Chi tiết đánh giá</th>
                                            <th>Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                                            $page = max($page, 1);
                                            $offset = ($page - 1) * 6;
                                            $query = "SELECT review.id, user.name AS user_name, product.name AS product_name, review.star, review.review_detail FROM review JOIN user ON review.userId = user.id JOIN product ON review.productId = product.id ORDER BY review.id DESC LIMIT 6 OFFSET " . $offset ;
                                            $kq = view($query);
                                            if ($kq && mysqli_num_rows($kq) > 0) {
                                            while ($review = mysqli_fetch_assoc($kq)) {
                                                echo "
                                                <tr>
                                                    <th>{$review['id']}</th>
                                                    <td>{$review['user_name']}</td>
                                                    <td>{$review['product_name']}</td>
                                                    <td>{$review['star']}</td>
                                                    <td>{$review['review_detail']}</td>
                                                    <td>
                                                        <a href='/VitaFruit/src/admin/review/delete.php?id={$review['id']}' class='btn btn-danger'>Xóa</a>
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
                                    $query1 = "SELECT COUNT(*) AS total_rows FROM review";
                                    $sumpage = countPage($query1,6);
                                    $nowPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                    $nowPage = max(1, $nowPage);
                                ?>

                                <?php if ($sumpage > 1): ?>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <!-- Previous Page Link -->
                                        <li class="page-item <?php echo ($nowPage == 1) ? 'disabled' : ''; ?>">
                                            <a class="page-link"
                                                href="/VitaFruit/src/admin/review/show.php?page=<?php echo $nowPage - 1; ?>"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>

                                        <!-- Page Numbers -->
                                        <?php for ($i = 1; $i <= $sumpage; $i++): ?>
                                        <li class="page-item <?php echo ($i == $nowPage) ? 'active' : ''; ?>">
                                            <a class="page-link"
                                                href="/VitaFruit/src/admin/review/show.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                        <?php endfor; ?>

                                        <!-- Next Page Link -->
                                        <li class="page-item <?php echo ($nowPage == $sumpage) ? 'disabled' : ''; ?>">
                                            <a class="page-link"
                                                href="/VitaFruit/src/admin/review/show.php?page=<?php echo $nowPage + 1; ?>"
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