<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Đăng nhập</title>
    <link href="styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <?php
    session_start();

    if (isset($_SESSION['user'])) {
        header('Location: /VegetableWeb/src/user/index.php');
        exit;
    }
    $cookie_name = 'remember_user';
    if (isset($_COOKIE[$cookie_name])) {
        parse_str($_COOKIE[$cookie_name], $arr);
        // Kiểm tra nếu cookie hợp lệ
        if (isset($arr['usr'])) {
            $usr = $arr['usr'];
            $_SESSION['user'] = $usr; // Lưu thông tin vào session
            header('Location: /VegetableWeb/src/user/index.php');
            exit;
        } 
    }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $error = [];
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (empty($username) || empty($password)) {
                if (empty($username)) {
                    $error['username'] = 'Tên đăng nhập không được để trống';
                }
                if (empty($password)) {
                    $error['password'] = 'Mật khẩu không được để trống';
                }
            } else {
                $query = "SELECT Password FROM user WHERE email = '$username'";
                include_once '../../include/database.php';
                $kq = view($query);
                if (mysqli_num_rows($kq) == 0) {
                    $error['username'] = 'Username không tồn tại';
                } else {
                    $product = mysqli_fetch_assoc($kq);
                    if (password_verify($password, $product['Password']))
                    {
                        $_SESSION['user'] = $username;
                        if (isset($_POST['check']) && $_POST['check'] == '1')
                        {  
                            $cookie_time = (3600 * 24 * 30);
                            setcookie($cookie_name, 'usr=' . $username , time() + $cookie_time, '/');
                        }
                        header('Location: /VegetableWeb/src/user/index.php');
                        exit;
                    } else {
                        $error['password'] = 'Password không đúng';
                    }
                }
            }
        }
    ?>

</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">ĐĂNG NHẬP</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <div class="form-floating mb-3">
                                            <input
                                                class="form-control <?php echo !empty($error['username']) ? 'is-invalid' : ''; ?>"
                                                id="inputEmail" type="text" placeholder="" name="username"
                                                value="<?php echo isset($username) ? $username : ''; ?>" />
                                            <?php echo !empty($error['username']) ? '<div class="invalid-feedback">' . $error['username'] . '</div>' : ''; ?>
                                            <label for="inputEmail">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input
                                                class="form-control <?php echo !empty($error['password']) ? 'is-invalid' : ''; ?>"
                                                id="inputPassword" type="password" placeholder="Password"
                                                name="password"
                                                value="<?php echo isset($password) ? $password : ''; ?>" />
                                            <?php echo !empty($error['password']) ? '<div class="invalid-feedback">' . $error['password'] . '</div>' : ''; ?>
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox"
                                                name="check" value="1" />
                                            <label class="form-check-label" for="inputRememberPassword">Ghi nhớ tôi
                                            </label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password.html">Quên mật khẩu?</a>
                                            <button class="btn btn-primary" type="submit">Đăng nhập</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="/VegetableWeb/src/auth/register.php">Bạn chưa có tài
                                            khoản? Đăng kí!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="scripts.js"></script>
</body>

</html>