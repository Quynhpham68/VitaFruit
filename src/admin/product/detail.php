<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Detail User</title>
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
                        <li class="breadcrumb-item"><a href="/VitaFruit/src/admin/product/show.php?page=1">Trang
                                chủ</a></li>
                        <li class="breadcrumb-item active">Sản phẩm</li>
                    </ol>
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-12 mx-auto">
                                <?php
                                    $id = $_GET['id'];
                                    $query = "select * from product p where p.id = ".$id;
                                    $kq = view( $query);
                                    $row = mysqli_fetch_assoc($kq);
                                ?>
                                <div class="d-flex justify-content-between">
                                    <h3>Sản phẩm có ID là: <?php echo $id ?></h3>
                                </div>

                                <hr />

                                <div class="card" style="width: 60%">
                                    <div class="card-header">
                                        Thông tin sản phẩm
                                    </div>
                                    <li class="list-group-item">Khuyến mãi: <?php echo $row['discount_percent']; ?>%</li>
                                        <li class="list-group-item">ID: <?php echo $id; ?></li>
                                        <li class="list-group-item">Tên: <?php echo $row['name']; ?></li>
                                        <li class="list-group-item">Giá: <?php echo $row['price']; ?> đ</li>
                                        <li class="list-group-item">Miêu tả ngắn: <?php echo $row['short_desc']; ?></li>
                                        <li class="list-group-item">Miêu tả chi tiết:
                                            <?php echo $row['details_desc']; ?></li>
                                        <li class="list-group-item">Nhà cung cấp: <?php echo $row['factory']; ?></li>
                                        <li class="list-group-item">Số lượng còn lại: <?php echo $row['quantity']; ?>
                                        </li>
                                        <li class="list-group-item">Số lượng đã bán: <?php echo $row['sold']; ?></li>
                                        <li class="list-group-item">
                                            Ảnh:
                                            <?php 
                                                $image = "/VitaFruit/img/product/" . $row['image'];  
                                                ?>
                                            <img src="<?php echo $image; ?>" alt="Chưa có ảnh"
                                                style="max-height: 250px;">
                                        </li>
                                    </ul>
                                </div>

                                <a href="/VitaFruit/src/admin/product/show.php?page=1"
                                    class="btn btn-success mt-3">Trở về</a>

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