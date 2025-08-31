<div class="container-fluid fixed-top">
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="/VitaFruit/src/user/index.php" class="navbar-brand d-flex align-items-center">
                <img src="/VitaFruit/img/avatar/logo.png" alt="Logo" 
                    style="height: 40px; width: auto; margin-right: 10px;">
            <h1 class="text-primary display-6 mb-0">VitaFruit</h1>
            </a>
            <div class="collapse navbar-collapse bg-white justify-content-between mx-5" id="navbarCollapse">
                <div class="navbar-nav">
                    <a href="/VitaFruit/src/user/index.php" 
                    class="nav-item nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active'; ?>">
                    Trang Chủ
                    </a>
                    <a href="/VitaFruit/src/user/about.php" 
                    class="nav-item nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'about.php') echo 'active'; ?>">
                    Giới thiệu
                    </a>
                    <a href="/VitaFruit/src/user/shop.php" 
                    class="nav-item nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'shop.php') echo 'active'; ?>">
                    Sản phẩm
                    </a>
                    <a href="/VitaFruit/src/user/contact.php" 
                    class="nav-item nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'contact.php') echo 'active'; ?>">
                    Phản hồi
                    </a>
                </div>
                <div class="d-flex m-3 me-0">
                    <?php
                    $cookie_name = 'remember_user';
                    if (isset($_SESSION['user']) || isset($_COOKIE[$cookie_name])): ?>
                    <?php
                        if(isset($_SESSION['user']))
                        {
                            $username = $_SESSION['user'];
                        }
                        else
                        {
                            parse_str($_COOKIE[$cookie_name], $arr);
                            $username = $arr['usr'];
                        }
                        $query = "select name, image from user where email = '".$username. "'";
                        $kq = mysqli_query($code, $query);
                        $user = mysqli_fetch_assoc($kq);
                        $name = $user['name'];
                        $image = $user['image'];
                        $query = "select quantity from cart cd join user u on cd.userId = u.id where u.email = '".$username. "'";
                        $kq = mysqli_query($code, $query);
                        if ($kq && mysqli_num_rows($kq) > 0)
                        {
                            $total = mysqli_fetch_assoc($kq);
                            $sum = $total['quantity'];
                        }
                        else
                            $sum = 0;
                    ?>
                    <a href="/VitaFruit/src/user/cart/show.php" class="position-relative me-4 my-auto">
                        <i class="fa fa-shopping-bag fa-2x"></i>
                        <span
                            class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                            style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo $sum?></span>
                    </a>
                    <div class="dropdown my-auto">
                        <a href="#" class="dropdown" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                            aria-expanded="false" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-2x"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end p-4" aria-labelledby="dropdownMenuLink">
                            <li class="d-flex align-items-center flex-column" style="min-width: 300px;">
                                <img style="width: 150px; height: 150px; border-radius: 50%; overflow: hidden;"
                                    src="/VitaFruit/img/avatar/<?php echo $image ?>" />
                                <div class="text-center my-3">
                                    <p><?php echo $name; ?></p>
                                </div>
                            </li>

                            <li><a class="dropdown-item" href="/VitaFruit/src/admin/dashboard/show.php">Trang dành
                                    cho Admin</a></li>
                            <li><a class="dropdown-item"
                                    href="/VitaFruit/src/user/profile.php?username=<?php echo $username?>">Quản
                                    lý tài khoản</a></li>
                            <li><a class="dropdown-item" href="/VitaFruit/src/user/cart/historyOrder.php">Lịch sử mua
                                    hàng</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="post" action="/VitaFruit/src/auth/logout.php">
                                    <button class="dropdown-item" name="logout">Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <?php else: ?>
                    <a href="/VitaFruit/src/auth/login.php" class="position-relative me-4 my-auto">
                        Đăng nhập
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>
</div>