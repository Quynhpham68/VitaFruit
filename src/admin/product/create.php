<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tạo mới sản phẩm</title>
    <link href="../resources/css/styles.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    $(document).ready(() => {
        const avatarFile = $("#avatarFile");
        avatarFile.change(function(e) {
            const imgURL = URL.createObjectURL(e.target.files[0]);
            $("#avatarPreview").attr("src", imgURL);
            $("#avatarPreview").css({
                "display": "block"
            });
        });
    });
    </script>
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
                    <h1 class="mt-4">Sản phẩm</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="/VitaFruit/src/admin/product/show.php?page=1">Trang
                                chủ</a></li>
                        <li class="breadcrumb-item active">Sản phẩm</li>
                    </ol>
                    <?php
                        if(!empty($_POST))
                        {
                            $name = isset($_POST['name']) ? $_POST['name'] : '';
                            $price = isset($_POST['price']) ? $_POST['price'] : '';
                            $details_desc = isset($_POST['details_desc']) ? $_POST['details_desc'] : '';
                            $short_desc = isset($_POST['short_desc']) ? $_POST['short_desc'] : '';
                            $quantity= isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
                            $factory= isset($_POST['factory']) ? $_POST['factory'] : '';
                            $category= isset($_POST['category']) ? $_POST['category'] : '';
                            $error = [];
                            if(empty($_POST['name']))
                            {
                                $error['name'] = 'Tên không được để trống';
                            }
                            if(empty($_POST['details_desc']))
                            {
                                $error['details_desc'] = 'Miêu tả chi tiết không được để trống';
                            }
                            if(empty($_POST['short_desc']))
                            {
                                $error['short_desc'] = 'Miêu tả ngắn không được để trống';
                            }
                        }
                    ?>
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-md-6 col-12 mx-auto">
                                <h3>Thêm loại cá mới</h3>
                                <hr />
                                <form method="post" action="" class="row" enctype="multipart/form-data">
                                    <div class="mb-3 col-12 col-md-6">
                                        <label class="form-label">Tên sản phẩm:</label>
                                        <input type="text"
                                            class="form-control <?php echo !empty($error['name']) ? 'is-invalid' : ''; ?>"
                                            name="name" value="<?php echo isset($name) ? $name : ''; ?>" />
                                        <?php echo !empty($error['name']) ? '<div class="invalid-feedback">' . $error['name'] . '</div>' : ''; ?>
                                    </div>
                                    <div class="mb-3 col-12 col-md-6">
                                        <label class="form-label">Giá:</label>
                                        <input type="number"
                                            class="form-control <?php echo !empty($error['price']) ? 'is-invalid' : ''; ?>"
                                            name="price" value="<?php echo isset($price) ? $price : ''; ?>" />
                                        <?php echo !empty($error['price']) ? '<div class="invalid-feedback">' . $error['price'] . '</div>' : ''; ?>
                                    </div>
                                    <div class="mb-3 col-12 col-md-6">
                                        <label class="form-label">Khuyến mãi (%):</label>
                                        <input type="number" min="0" max="100"
                                            class="form-control <?php echo !empty($error['discount_percent']) ? 'is-invalid' : ''; ?>"
                                            name="discount_percent" value="<?php echo isset($discount_percent) ? $discount_percent : 0; ?>" />
                                        <?php echo !empty($error['discount_percent']) ? '<div class="invalid-feedback">' . $error['discount_percent'] . '</div>' : ''; ?>
                                    </div>

                                    <div class="mb-3 col-12">
                                        <label class="form-label">Miêu tả chi tiết:</label>
                                        <input type="text"
                                            class="form-control <?php echo !empty($error['details_desc']) ? 'is-invalid' : ''; ?>"
                                            name="details_desc"
                                            value="<?php echo isset($details_desc) ? $details_desc : ''; ?>" />
                                        <?php echo !empty($error['details_desc']) ? '<div class="invalid-feedback">' . $error['details_desc'] . '</div>' : ''; ?>
                                    </div>
                                    <div class="mb-3 col-12 col-md-6">
                                        <label class="form-label">Miêu tả ngắn:</label>
                                        <input type="text"
                                            class="form-control <?php echo !empty($error['short_desc']) ? 'is-invalid' : ''; ?>"
                                            name="short_desc"
                                            value="<?php echo isset($details_desc) ? $details_desc : ''; ?>" />
                                        <?php echo !empty($error['short_desc']) ? '<div class="invalid-feedback">' . $error['short_desc'] . '</div>' : ''; ?>
                                    </div>
                                    <div class="mb-3 col-12 col-md-6">
                                        <label class="form-label">Số lượng:</label>
                                        <input type="number" class="form-control" name="quantity"
                                            value="<?php echo isset($quantity) ? $quantity : ''; ?>" />
                                    </div>

                                    <div class="mb-3 col-12 col-md-6">
                                        <label class="form-label">Nhà sản xuất:</label>
                                        <select class="form-select" name="factory">
                                            <option value="Smat">Smat</option>
                                            <option value="FreshFarm">FreshFarm</option>
                                            <option value="GreenFarm">GreenFarm</option>
                                            <option value="VeggieKing">VeggieKing</option>
                                            <option value="FarmX">FarmX</option>
                                            <option value="TatooFarm">TatooFarm</option>
                                            <option value="OrganicFarm">OrganicFarm</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-12 col-md-6">
                                        <label class="form-label">Thể loại:</label>
                                        <select class="form-select" name="category">
                                            <option value="Hoa quả">Hoa quả</option>
                                            <option value="Rau">Rau Củ</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-12 col-md-6">
                                        <label for="avatarFile" class="form-label">Hình ảnh:</label>
                                        <input class="form-control" type="file" id="avatarFile"
                                            accept=".png, .jpg, .jpeg" name="MinhTriFile" />
                                    </div>
                                    <div class="col-12 mb-3">
                                        <img style="max-height: 250px; display: none;" alt="avatar preview"
                                            id="avatarPreview" />
                                    </div>
                                    <div class="col-12 mb-5">
                                        <button type="submit" class="btn btn-primary">Tạo mới</button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </main>
            <?php 
            include_once '../layout/footer.php';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $code = connect();
                $file = time().".jpg";
                $tenFile = "C:/xampp/htdocs/VitaFruit/img/product/".$file;
                $result = move_uploaded_file($_FILES['MinhTriFile']['tmp_name'], $tenFile);
                $query =  "INSERT INTO product (name, price, details_desc, short_desc, factory, quantity, sold, image, category )
                    VALUES ('$name', $price, '$details_desc', '$short_desc', '$factory', $quantity, 0, '$file', '$category')";
                $kq = mysqli_query($code, $query);
                mysqli_close($code);
                if ($kq) {
                    echo '<script type="text/javascript">
                            window.location.href = "/VitaFruit/src/admin/product/show.php?page=1";
                          </script>';
                    exit();
                } 
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="/js/scripts.js"></script>

</body>

</html>