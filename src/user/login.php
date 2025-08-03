<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-success">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                    <form method="post" action="login.php"> <!-- action points to login.php to handle the form submission -->
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" name="email" required />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="password" required />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="remember" value="1" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.php">Forgot Password?</a>
                                                <button type="submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>

                                        <?php
                                        session_start();

                                        // Check if the form is submitted
                                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                            // Assuming proper validation and sanitization is done
                                            $email = $_POST['email'];
                                            $password = $_POST['password'];
                                            
                                            // Store in session
                                            $_SESSION["email"] = $email;
                                            $_SESSION["password"] = password_hash($password, PASSWORD_BCRYPT); // Hash the password for security
                                            
                                            // Redirect or further processing (e.g., validating login)
                                            header("Location: index.php"); // Redirect to the dashboard or another page after successful login
                                            exit();
                                        }
                                        ?>

                                        <?php // Gọi session trước khi gửi dữ liệu nào khác đến trình duyệt

                                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                                $_SESSION['email'] = $_POST['email'] ?? null;
                                                $_SESSION["password"] = password_hash($_POST['password'], PASSWORD_BCRYPT);

                                                header("Location: index.php");
                                                // header("location: cart.php");
                                                exit(); // Dừng script sau khi chuyển hướng
                                            }
                                            ?>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2025</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
