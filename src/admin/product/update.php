<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="MT" />
    <meta name="author" content="MT" />
    <title>Cập nhật người dùng</title>
    <link href="../resources/css/styles.css" rel="stylesheet" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <?php
        include_once '../../../include/config.php';
        include_once '../../../include/database.php';
        $username = $_SESSION['user'];
        role($username);
        $id = $_GET['id'];
        $query = "select * from product where id = ".$id;
        $kq = view($query);
        $product = mysqli_fetch_assoc($kq);
        $image = $product['image'];
        $name = $product['name'];
        $price = $product['price'];
        $quantity = (int) $product['quantity'];
        $details_desc = $product['details_desc'];
        $short_desc = $product['short_desc'];
        $factory = $product['factory'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $price = isset($_POST['price']) ? $_POST['price'] : '';
            $details_desc = isset($_POST['details_desc']) ? $_POST['details_desc'] : '';
            $short_desc = isset($_POST['short_desc']) ? $_POST['short_desc'] : '';
            $quantity= isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
            $factory= isset($_POST['factory']) ? $_POST['factory'] : '';
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
            if(empty($error))
            {
                include_once '../../../include/database.php';
                $file = "";
                if (isset($_FILES['DiemQuynhFile']['tmp_name']) && !empty($_FILES['DiemQuynhFile']['tmp_name'])) {
                    $file = time() . ".jpg";
                    $tenFile = "C:/xampp/htdocs/VegetableWeb/img/product/" . $file;
                    move_uploaded_file($_FILES['DiemQuynhFile']['tmp_name'], $tenFile);
                } else {
                    $file = $image;
                }
                $query = "UPDATE product SET name = '$name', price = $price, details_desc = '$details_desc', image = '$file', short_desc = '$short_desc', factory = '$factory', quantity = $quantity WHERE id = '$id'";
                if (update($query)) {
                    echo '<script type="text/javascript">
                            window.location.href = "/VegetableWeb/src/admin/product/show.php?page=1";
                          </script>';
                    exit();
                } else {
                    echo "Error: " . mysqli_error($code);
                }
            }
            else
            {
               echo 1;
            }
        }
    ?>
    <script>
    $(document).ready(function() {
        const avatarFile = $("#avatarFile");
        const tmp = "<?php echo $image; ?>";

        if (tmp) {
            const defaultImagePath = "/VegetableWeb/img/product/" + tmp;
            $("#avatarPreview").attr("src", defaultImagePath);
            $("#avatarPreview").css({
                "display": "block"
            });
        }

        avatarFile.change(function(e) {
            const file = e.target.files[0];
            if (file) {
                const imgURL = URL.createObjectURL(file);
                $("#avatarPreview").attr("src", imgURL);
                $("#avatarPreview").css({
                    "display": "block"
                });
            }
        });
    });
    </script>
</head>

<body class="sb-nav-fixed">
    <?php include_once '../layout/header.php' ?>
    <div id="layoutSidenav">
        <?php include_once '../layout/sidebar.php' ?>
        <div id="layoutSidenav_content">
            <main>
                <?php print_r($error) ?>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Quản lí sản phẩm</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="/admin">Trang chủ</a></li>
                        <li class="breadcrumb-item active">sản phẩm</li>
                    </ol>
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-md-6 col-12 mx-auto">
                                <h3>Cập nhật người dùng</h3>
                                <hr />
                                <form method="post" action="" enctype="multipart/form-data">
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
                                            <option value="Smat" <?php echo ($factory == "Smat") ? 'selected' : ''; ?>>
                                                Smat</option>
                                            <option value="FreshFarm"
                                                <?php echo ($factory == "FreshFarm") ? 'selected' : ''; ?>>FreshFarm
                                            </option>
                                            <option value="GreenFarm"
                                                <?php echo ($factory == "GreenFarm") ? 'selected' : ''; ?>>GreenFarm
                                            </option>
                                            <option value="VeggieKing"
                                                <?php echo ($factory == "VeggieKing") ? 'selected' : ''; ?>>VeggieKing
                                            </option>
                                            <option value="FarmX"
                                                <?php echo ($factory == "FarmX") ? 'selected' : ''; ?>>FarmX</option>
                                            <option value="TatooFarm"
                                                <?php echo ($factory == "TatooFarm") ? 'selected' : ''; ?>>TatooFarm
                                            </option>
                                            <option value="OrganicFarm"
                                                <?php echo ($factory == "OrganicFarm") ? 'selected' : ''; ?>>OrganicFarm
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-12 col-md-6">
                                        <label for="avatarFile" class="form-label">Ảnh sản phẩm:</label>
                                        <input class="form-control" type="file" id="avatarFile"
                                            accept=".png, .jpg, .jpeg" name="MinhTriFile" />
                                    </div>

                                    <div class="col-12 mb-3">
                                        <img style="max-height: 250px; display: none;" alt="avatar preview"
                                            id="avatarPreview" />
                                    </div>

                                    <button type="submit" class="btn btn-warning">Cập nhật</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php 
               
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../resources/js/scripts.js"></script>
</body>

</html>