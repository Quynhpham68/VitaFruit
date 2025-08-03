<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="MT" />
    <meta name="author" content="MT" />
    <title>Detail User</title>
    <link href="../resources/css/styles.css" rel="stylesheet" />
    <?php
        include_once '../../../include/config.php';
        include_once '../../../include/database.php';
        $username = $_SESSION['user'];
        role($username);
    ?>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
                        <li class="breadcrumb-item"><a href="/admin">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Người dùng</li>
                    </ol>
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-12 mx-auto">
                                <?php
                                    $id = $_GET['id'];
                                    $query = "select u.id, u.email, u.name, u.phone, u.image from user u where u.id = ".$id;
                                    $kq = view( $query);
                                    $row = mysqli_fetch_assoc($kq);
                                ?>
                                <div class="d-flex justify-content-between">
                                    <h3>Người dùng có ID là: <?php echo $id ?></h3>
                                </div>

                                <hr />

                                <div class="card" style="width: 60%">
                                    <div class="card-header">
                                        Thông tin người dùng
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">ID: <?php echo $id; ?></li>
                                        <li class="list-group-item">Email: <?php echo $row['email']; ?></li>
                                        <li class="list-group-item">Tên đầy đủ: <?php echo $row['name']; ?></li>
                                        <li class="list-group-item">Số điện thoại: <?php echo $row['phone']; ?></li>
                                        <li class="list-group-item">
                                            Ảnh:
                                            <?php 
                                                $image = "/VegetableWeb/img/avatar/" . $row['image'];  
                                                ?>
                                            <img src="<?php echo $image; ?>" alt="Chưa có ảnh"
                                                style="max-height: 250px;">
                                        </li>
                                    </ul>
                                </div>

                                <a href="/VegetableWeb/src/admin/user/show.php?page=1" class="btn btn-success mt-3">Trở
                                    về</a>

                            </div>

                        </div>

                    </div>
                </div>
            </main>
            <?php
            include_once '../layout/footer.php'?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../resources/js/scripts.js"></script>

</body>

</html>