<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Đăng nhập</title>
  <link href="styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

  <?php
    session_start();
    if (isset($_SESSION['user'])) {
        header('Location: /VitaFruit/src/user/index.php');
        exit;
    }
    $cookie_name = 'remember_user';
    if (isset($_COOKIE[$cookie_name])) {
        parse_str($_COOKIE[$cookie_name], $arr);
        if (isset($arr['usr'])) {
            $usr = $arr['usr'];
            $_SESSION['user'] = $usr;
            header('Location: /VitaFruit/src/user/index.php');
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
                if (password_verify($password, $product['Password'])) {
                    $_SESSION['user'] = $username;
                    if (isset($_POST['check']) && $_POST['check'] == '1') {
                        $cookie_time = (3600 * 24 * 30);
                        setcookie($cookie_name, 'usr=' . $username , time() + $cookie_time, '/');
                    }
                    header('Location: /VitaFruit/src/user/index.php');
                    exit;
                } else {
                    $error['password'] = 'Password không đúng';
                }
            }
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

    /* Bay icon */
    #flying-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 1;
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
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">ĐĂNG NHẬP</h3>
                </div>
                <div class="card-body">
                  <form method="POST" action="">
                    <div class="form-floating mb-3">
                      <input class="form-control <?php echo !empty($error['username']) ? 'is-invalid' : ''; ?>" id="inputEmail" type="text" name="username" value="<?php echo isset($username) ? $username : ''; ?>" />
                      <?php echo !empty($error['username']) ? '<div class="invalid-feedback">' . $error['username'] . '</div>' : ''; ?>
                      <label for="inputEmail">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control <?php echo !empty($error['password']) ? 'is-invalid' : ''; ?>" id="inputPassword" type="password" name="password" value="<?php echo isset($password) ? $password : ''; ?>" />
                      <?php echo !empty($error['password']) ? '<div class="invalid-feedback">' . $error['password'] . '</div>' : ''; ?>
                      <label for="inputPassword">Password</label>
                    </div>
                    <div class="form-check mb-3">
                      <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="check" value="1" />
                      <label class="form-check-label" for="inputRememberPassword">Ghi nhớ tôi</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                      <a class="small" href="password.html">Quên mật khẩu?</a>
                      <button class="btn btn-primary" type="submit">Đăng nhập</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center py-3">
                  <div class="small"><a href="/VitaFruit/src/auth/register.php">Bạn chưa có tài khoản? Đăng kí!</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <div id="flying-container"></div>

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