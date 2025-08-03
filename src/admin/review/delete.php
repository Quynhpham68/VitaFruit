<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="MT" />
    <meta name="author" content="MT" />
    <title>Xóa đánh giá</title>
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
                    <h1 class="mt-4">Quản lí đánh giá</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="/VegetableWeb/src/admin/review/show.php?page=1">Trang
                                chủ</a></li>
                        <li class="breadcrumb-item active">Đánh giá</li>
                    </ol>
                    <div class=" mt-5">
                        <div class="row">
                            <div class="col-12 mx-auto">
                                <?php
                                    $id = $_GET['id'];
                                ?>
                                <div class="d-flex justify-content-between">
                                    <h3>Xóa đánh giá có ID là: <?php echo $id; ?> </h3>
                                </div>

                                <hr />
                                <div class="alert alert-danger">
                                    Bạn có chắc chắn muốn xóa chứ ?
                                </div>
                                <form method="post" action="">
                                    <div class="mb-3" style="display: none;">
                                        <label class="form-label">ID:</label>
                                        <input value=<?php echo $id ?> type="text" class="form-control" name="id" />
                                    </div>
                                    <button class="btn btn-danger">Confirm</button>
                                </form>

                                <?php
                                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                            $id = $_POST['id'];
                                            $query = "delete from review u where u.id = " .$id;
                                            delete($query);
                                                echo '<script type="text/javascript">
                                                        window.location.href = "/VegetableWeb/src/admin/review/show.php?page=1";
                                                      </script>';
                                                exit();
                                        }
                                ?>

                            </div>

                        </div>

                    </div>
                </div>
            </main>
            <?php include_once '../layout/footer.php'?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../resources/js/scripts.js"></script>

</body>

</html>