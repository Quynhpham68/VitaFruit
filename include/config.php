<?php
        session_start();
        if (empty($_SESSION['user'])) {
            $cookie_name = 'remember_user';
            if (isset($_COOKIE[$cookie_name])) {
                parse_str($_COOKIE[$cookie_name], $arr);
                if (isset($arr['usr'])) {
                    $usr = $arr['usr'];
                    $_SESSION['user'] = $usr; // Lưu thông tin vào session
                } 
            }
            else{
                header('Location: /VitaFruit/src/auth/login.php');
                exit;
            }
        }