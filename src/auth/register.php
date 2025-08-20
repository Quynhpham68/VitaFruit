<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Đăng kí</title>
    <link href="styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <?php
        include_once '../../include/database.php';
        if(!empty($_POST))
        {
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';
            $ho = isset($_POST['ho']) ? $_POST['ho'] : '';
            $ten = isset($_POST['ten']) ? $_POST['ten'] : '';
            $error = [];
            if(empty($_POST['email']))
            {
                $error['email']['required'] = 'Email không được để trông';
            }
            else
            {
                $query = "select id from user where email = '". $_POST['email']. "'";
                $kq = view($query);
                if (mysqli_num_rows($kq) > 0)
                    $error['email']['invalid'] = 'Email đã tồn tại';
            }

            if(empty($_POST['password']))
            {
                 $error['password']['required'] = 'Password không được để trông';
            }
            else
            {
                if(strlen($_POST['password']) < 6)
                    $error['password']['length'] = 'password không được nhỏ hơn 6 kí tự';
                if(empty($_POST['confirmPassword']))
                    $error['confirmPassword']['required'] = 'password không được để trông';
                else
                {
                   if($_POST['password'] != $_POST['confirmPassword'])
                       $error['confirmPassword']['invalid'] = 'Mật khẩu không khớp';
                }
            }

            if(empty($_POST['ho']))
            {
                $error['ho']['required'] = 'Họ không được để trống';
            }
            else
            {
                if(strlen($_POST['ho']) < 2)
                    $error['ho']['length'] = 'Ho không được nhỏ hơn 2 kí tự';
            }
            if(empty($_POST['ten']))
            {
                $error['ten']['required'] = 'Họ không được để trống';
            }
            else
            {
                if(strlen($_POST['ten']) < 2)
                    $error['ten']['length'] = 'Ten không được nhỏ hơn 2 kí tự';
            }
        }
    ?>
    <style>
    body.bg-primary {
        background-color: #e6f4ea !important;
    }

    .btn-primary {
        background-color: #81c784;
        border-color: #81c784;
    }

    .btn-primary:hover {
        background-color: #66bb6a;
        border-color: #66bb6a;
    }

    .card-header {
        background-color: #81c784;
        color: white;
        border-bottom: none;
    }

    a {
        color: #388e3c;
    }

    a:hover {
        color: #2e7d32;
    }
.floating-icon {
    position: fixed;
    top: -50px;
    z-index: 1;
    pointer-events: none;
    opacity: 0.7;
    animation: fall linear infinite;
}

@keyframes fall {
    0% {
        transform: translateY(100vh) translateX(0) rotate(0deg);
        opacity: 0;
    }
    10% {
        opacity: 0.6;
    }
    100% {
        transform: translateY(-120vh) translateX(60px) rotate(360deg);
        opacity: 0;
    }
}

/* Đảm bảo form đè lên icon */
.card {
    position: relative;
    z-index: 10;
}

</style>

</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Tạo tài khoản</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input
                                                        class="form-control <?php echo !empty($error['ho']) ? 'is-invalid' : ''; ?>"
                                                        id="inputFirstName" type="text" name="ho"
                                                        placeholder="Enter your first name"
                                                        value="<?php echo isset($ho) ? $ho : ''; ?>" />
                                                    <?php echo !empty($error['ho']['required']) ? '<div class="invalid-feedback">' . $error['ho']['required'] . '</div>' : ''; ?>
                                                    <?php echo !empty($error['ho']['length']) ? '<div class="invalid-feedback">' . $error['ho']['length'] . '</div>' : ''; ?>
                                                    <label for="inputFirstName">Họ</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input
                                                        class="form-control <?php echo !empty($error['ten']) ? 'is-invalid' : ''; ?>"
                                                        id="inputLastName" type="text" name="ten"
                                                        value="<?php echo isset($ten) ? $ten : ''; ?>"
                                                        placeholder="Enter your last name" />
                                                    <?php echo !empty($error['ten']['required']) ? '<div class="invalid-feedback">' . $error['ten']['required'] . '</div>' : ''; ?>
                                                    <?php echo !empty($error['ten']['length']) ? '<div class="invalid-feedback">' . $error['ten']['length'] . '</div>' : ''; ?>
                                                    <label for="inputLastName">Tên</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input
                                                class="form-control <?php echo !empty($error['email']) ? 'is-invalid' : ''; ?>"
                                                id="inputEmail" type="email" name="email" placeholder="name@example.com"
                                                value="<?php echo isset($email) ? $email : ''; ?>" />
                                            <?php echo !empty($error['email']['required']) ? '<div class="invalid-feedback">' . $error['email']['required'] . '</div>' : ''; ?>
                                            <?php echo !empty($error['email']['invalid']) ? '<div class="invalid-feedback">' . $error['email']['invalid'] . '</div>' : ''; ?>
                                            <label for="inputEmail">Email</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input
                                                        class="form-control <?php echo !empty($error['password']) ? 'is-invalid' : ''; ?>"
                                                        id="inputPassword" type="password" name="password"
                                                        placeholder="Create a password"
                                                        value="<?php echo isset($password) ? $password : ''; ?>" />
                                                    <?php echo !empty($error['password']['required']) ? '<div class="invalid-feedback">' . $error['password']['required'] . '</div>' : ''; ?>
                                                    <?php echo !empty($error['password']['length']) ? '<div class="invalid-feedback">' . $error['password']['length'] . '</div>' : ''; ?>
                                                    <label for="inputPassword">Mật khẩu</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input
                                                        class="form-control <?php echo !empty($error['confirmPassword']) ? 'is-invalid' : ''; ?>"
                                                        id="inputPasswordConfirm" type="password"
                                                        placeholder="Confirm password" name="confirmPassword"
                                                        value="<?php echo isset($confirmPassword) ? $confirmPassword : ''; ?>" />
                                                    <?php echo !empty($error['confirmPassword']['required']) ? '<div class="invalid-feedback">' . $error['confirmPassword']['required'] . '</div>' : ''; ?>
                                                    <?php echo !empty($error['confirmPassword']['invalid']) ? '<div class="invalid-feedback">' . $error['confirmPassword']['invalid'] . '</div>' : ''; ?>
                                                    <label for="inputPasswordConfirm">Xác nhận mật khẩu</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><button class="btn btn-primary btn-block"
                                                    type="submit">Tạo tài khoản</button></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="/VegetableWeb/src/auth/login.php">Bạn đã có tài khoản?
                                            Tới đăng nhập</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php 
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error)) {
                $code = connect();
                $name = $ho.' '. $ten;
                $password = password_hash($password, PASSWORD_DEFAULT);
                $query =  "INSERT INTO user (email, name, password, roleID )
                    VALUES ('$email', '$name', '$password', 1)";
                $kq = mysqli_query($code, $query);
                mysqli_close($code);
                if ($kq) {
                    echo '<script type="text/javascript">
                            window.location.href = "/VegetableWeb/src/auth/login.php";
                          </script>';
                    exit();
                } else {
                    echo "Error: " . mysqli_error($code);
                }
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="scripts.js"></script>
    <script>
    const foodIcons = ["🍎", "🍓", "🍊", "🍇", "🥝", "🍅", "🍆", "🥦", "🥬", "🌽", "🍍", "🍌"];

    function createFloatingIcon() {
        const icon = document.createElement("div");
        icon.classList.add("floating-icon");
        icon.textContent = foodIcons[Math.floor(Math.random() * foodIcons.length)];

        // Tạo vị trí ngẫu nhiên tránh vùng giữa (ví dụ: tránh từ 35vw đến 65vw)
        let randomLeft = Math.random() * 100;
        while (randomLeft > 35 && randomLeft < 65) {
            randomLeft = Math.random() * 100;
        }

        icon.style.left = randomLeft + "vw";
        icon.style.fontSize = (Math.random() * 20 + 20) + "px";
        icon.style.animationDuration = (Math.random() * 10 + 15) + "s";
        document.body.appendChild(icon);

        setTimeout(() => icon.remove(), 25000);
    }

    setInterval(createFloatingIcon, 600);
</script>

</body>

</html>