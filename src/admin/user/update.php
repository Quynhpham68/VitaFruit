<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cập nhật người dùng</title>
    <link href="../resources/css/styles.css" rel="stylesheet" />
    <?php
        include_once '../../../include/config.php';
        include_once '../../../include/database.php';
        $username = $_SESSION['user'];
        role($username);
    ?>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <?php
        $id = $_GET['id'];
        $query = "select * from user where id = ".$id;
        $kq = view($query);
        $user = mysqli_fetch_assoc($kq);
        $image = $user['image'];
        $email = $user['email'];
        $password = $user['password'];
        $fullname = $user['name'];
        $phone = $user['phone'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
            $roleID = isset($_POST['roleID']) ? (int)$_POST['roleID'] : 1;
            $error = [];
        
            if(empty($_POST['fullname']))
            {
                $error['fullname']['required'] = 'tên không được để trông';
            }
            else
            {
                if(strlen($_POST['fullname']) < 2)
                {
                    $error['fullname']['length'] = 'tên không được nhỏ hơn 2 kí tự';
                }

            }

            if (preg_match('/[a-zA-Z]/', $_POST['phone']))
            {
                $error['phone']['invalid'] = 'Vui lòng nhập đúng định dạng số điện thoại';
            }
            else {
                if(strlen($_POST['phone']) < 9)
                {
                    $error['phone']['length'] = 'Số điện thoại phải có 9 chữ số';
                }
            }
            if(empty($error))
            {
                $file = "";
                if (isset($_FILES['DiemQuynhFile']['tmp_name']) && !empty($_FILES['DiemQuynhFile']['tmp_name'])) {
                    $file = time() . ".jpg";
                    $tenFile = "C:/xampp/htdocs/VitaFruit/img/avatar/" . $file;
                    move_uploaded_file($_FILES['DiemQuynhFile']['tmp_name'], $tenFile);
                } else {
                    $file = $image;
                }
                $query = "UPDATE user SET email = '$email', name = '$fullname', phone = '$phone', image = '$file' WHERE id = '$id'";
                if (update($query)) {
                    echo '<script type="text/javascript">
                            window.location.href = "/VitaFruit/src/admin/user/show.php?page=1";
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
            const defaultImagePath = "/VegetableWeb/img/avatar/" + tmp;
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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Quản lí người dùng</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="/admin">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Người dùng</li>
                    </ol>
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-md-6 col-12 mx-auto">
                                <h3>Cập nhật người dùng</h3>
                                <hr />
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label class="form-label">Email:</label>
                                        <input type="email" class="form-control" name="email" readonly="true"
                                            value="<?php echo isset($email) ? $email : ''; ?>" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Số điện thoại:</label>
                                        <input type="text"
                                            class="form-control <?php echo !empty($error['phone']) ? 'is-invalid' : ''; ?>"
                                            name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>" />
                                        <?php echo !empty($error['phone']['invalid']) ? '<div class="invalid-feedback">' . $error['phone']['invalid'] . '</div>' : ''; ?>
                                        <?php echo !empty($error['phone']['length']) ? '<div class="invalid-feedback">' .$error['phone']['length'] . '</div>' : ''; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tên đầy đủ:</label>
                                        <input type="text"
                                            class="form-control <?php echo !empty($error['fullname']) ? 'is-invalid' : ''; ?>"
                                            name="fullname" value="<?php echo isset($fullname) ? $fullname : ''; ?>" />
                                        <?php echo !empty($error['fullname']['required']) ? '<div class="invalid-feedback">' . $error['fullname']['required'] . '</div>' : ''; ?>
                                        <?php echo !empty($error['fullname']['length']) ? '<div class="invalid-feedback">' .$error['fullname']['length'] . '</div>' : ''; ?>
                                    </div>

                                    <div class="mb-3 col-12 col-md-6">
                                        <label for="avatarFile" class="form-label">Ảnh đại diện:</label>
                                        <input class="form-control" type="file" id="avatarFile"
                                            accept=".png, .jpg, .jpeg" name="DiemQuynhFile" />
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