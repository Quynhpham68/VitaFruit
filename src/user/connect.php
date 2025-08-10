<?php
$code = mysqli_connect("localhost", "root", "123456", "vegetable3");

if (!$code) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}
?>
