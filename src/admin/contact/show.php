<?php
include_once '../../../include/config.php';
include_once '../../../include/database.php';

session_start();
$username = $_SESSION['user'] ?? null;
role($username);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="MT" />
    <meta name="author" content="MT" />
    <title>Quản lý Liên hệ</title>
    <link href="../resources/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include_once '../layout/header.php' ?>
    <div id="layoutSidenav">
        <?php include_once '../layout/sidebar.php' ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Liên hệ</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="/VegetableWeb/src/admin/dashboard/show.php">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Liên hệ</li>
                    </ol>

                    <div class="mt-5">
                        <div class="row">
                            <div class="col-12 mx-auto">
                                <div class="d-flex justify-content-between">
                                    <h3>DANH SÁCH LIÊN HỆ TỪ NGƯỜI DÙNG</h3>
                                </div>
                                <hr />
                                <table class="table table-bordered table-hover" style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Họ tên</th>
                                            <th>Email</th>
                                            <th>Nội dung</th>
                                            <th>Thời gian</th>
                                            <th>Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                                        $page = max($page, 1);
                                        $limit = 6;
                                        $offset = ($page - 1) * $limit;

                                        $query = "SELECT * FROM contact ORDER BY id DESC LIMIT $limit OFFSET $offset";
                                        $result = view($query);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($contact = mysqli_fetch_assoc($result)) {
                                                echo "<tr>
                                                    <td>{$contact['id']}</td>
                                                    <td>{$contact['name']}</td>
                                                    <td>{$contact['email']}</td>
                                                    <td>{$contact['message']}</td>
                                                    <td>{$contact['created_at']}</td>
                                                    <td>
                                                        <a href='delete.php?id={$contact['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>Xóa</a>
                
                                                    </td>
                                                </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>Không có liên hệ nào.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <?php
                                $count_query = "SELECT COUNT(*) AS total_rows FROM contact";
                                $total_rows = countPage($count_query, $limit);
                                $nowPage = max(1, $page);
                                ?>

                                <?php if ($total_rows > 1): ?>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item <?php echo ($nowPage == 1) ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="/VegetableWeb/src/admin/contact/show.php?page=<?php echo $nowPage - 1; ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $total_rows; $i++): ?>
                                                <li class="page-item <?php echo ($i == $nowPage) ? 'active' : ''; ?>">
                                                    <a class="page-link" href="/VegetableWeb/src/admin/contact/show.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                </li>
                                            <?php endfor; ?>
                                            <li class="page-item <?php echo ($nowPage == $total_rows) ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="/VegetableWeb/src/admin/contact/show.php?page=<?php echo $nowPage + 1; ?>" aria-label="Next">
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
            <?php include_once '../layout/footer.php' ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../resources/js/scripts.js"></script>
</body>

</html>
