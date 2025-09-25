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
                    <h1 class="mt-4">Quản lí người dùng</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="/VitaFruit/src/admin/dashboard/show.php">Trang Chủ</a>
                        </li>
                        <li class="breadcrumb-item active">Người dùng</li>
                    </ol>
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-12 mx-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <!-- Thanh tìm kiếm -->
                                    <form class="d-flex" method="GET" action="">
                                        <input 
                                            class="form-control me-2" 
                                            type="search" 
                                            name="keyword" 
                                            placeholder="Tìm người dùng..." 
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
                                    <a href="/VitaFruit/src/admin/user/create.php" class="btn btn-primary">Tạo người dùng mới</a>
                                </div>

                                <hr />
                                <table class=" table table-bordered table-hover" style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Tên đầy đủ</th>
                                            <th>Số điện thoại</th>
                                            <th>Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                                            $page = max($page, 1);
                                            $offset = ($page - 1) * 6;
                                            $search_raw = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
                                            $search = $search_raw !== '' ? addslashes($search_raw) : '';

                                            if ($search !== '') {                                                
                                                $query = "SELECT id, email, name, phone 
                                                        FROM user 
                                                        WHERE email LIKE '%$search%' OR name LIKE '%$search%' OR phone LIKE '%$search%' 
                                                        ORDER BY id 
                                                        LIMIT 6 OFFSET $offset";
                                                $queryCount = "SELECT COUNT(*) AS total_rows 
                                                            FROM user 
                                                            WHERE email LIKE '%$search%' OR name LIKE '%$search%' OR phone LIKE '%$search%'";
                                            } else {
                                                $query = "SELECT id, email, name, phone 
                                                        FROM user 
                                                        ORDER BY id 
                                                        LIMIT 6 OFFSET $offset";
                                                $queryCount = "SELECT COUNT(*) AS total_rows FROM user";
                                            }
                                            $kq = view($query);
                                            if ($kq && mysqli_num_rows($kq) > 0) {
                                            while ($user = mysqli_fetch_assoc($kq)) {
                                                echo "
                                                <tr>
                                                    <th>{$user['id']}</th>
                                                    <td>{$user['email']}</td>
                                                    <td>{$user['name']}</td>
                                                    <td>{$user['phone']}</td>
                                                    <td>
                                                        <a href='/VitaFruit/src/admin/user/detail.php?id={$user['id']}' class='btn btn-success'>Xem chi tiết</a>
                                                        <a href='/VitaFruit/src/admin/user/update.php?id={$user['id']}' class='btn btn-warning mx-2'>Cập nhật</a>
                                                        <a href='/VitaFruit/src/admin/user/delete.php?id={$user['id']}' class='btn btn-danger'>Xóa</a>
                                                    </td>
                                                </tr>";
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
                                    $query1 = "SELECT COUNT(*) AS total_rows FROM user";
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
                                                href="/VitaFruit/src/admin/user/show.php?page=<?php echo $nowPage - 1; ?>"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>

                                        <!-- Page Numbers -->
                                        <?php for ($i = 1; $i <= $sumpage; $i++): ?>
                                        <li class="page-item <?php echo ($i == $nowPage) ? 'active' : ''; ?>">
                                            <a class="page-link"
                                                href="/VitaFruit/src/admin/user/show.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                        <?php endfor; ?>

                                        <!-- Next Page Link -->
                                        <li class="page-item <?php echo ($nowPage == $sumpage) ? 'disabled' : ''; ?>">
                                            <a class="page-link"
                                                href="/VitaFruit/src/admin/user/show.php?page=<?php echo $nowPage + 1; ?>"
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