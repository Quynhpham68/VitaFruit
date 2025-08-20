<?php
$code = mysqli_connect("localhost", "root", "", "vitafruit");

if (!$code) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}
?>
