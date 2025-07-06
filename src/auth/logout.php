<?php
session_start();

if (isset($_POST['logout'])) {
    // Xóa session
    session_unset();
    session_destroy();

    // Xóa cookie "remember_user" nếu có
    $cookie_name = 'remember_user';
    if (isset($_COOKIE[$cookie_name])) {
        setcookie($cookie_name, '', time() - 3600000, '/'); // Hết hạn cookie
    }

    setcookie(session_name(), '', time() - 3600000, '/');
    header('Location: /VegetableWeb/src/auth/login.php');
    exit;
}
?>