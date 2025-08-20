<?php 
    include("../connect.php");
    include_once '../../../include/config.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $cdID = $_GET['cdId'];
        $cartId = $_GET['cartId'];
        $query = "DELETE FROM cart_detail WHERE id = $cdID";
        $kq = mysqli_query($code, $query);
        $query = "SELECT COUNT(*) as dem FROM cart_detail WHERE cartId = $cartId";
        $kq = mysqli_query($code, $query);
        $count = mysqli_fetch_assoc($kq);
        $num = (int) $count['dem'];
        if($num == 0)
        {
            $query = "DELETE FROM cart WHERE id = $cartId";
            $kq = mysqli_query($code, $query);
        }
        else
        {
            $query = "UPDATE cart SET quantity = $num WHERE id = $cartId";
            $kq = mysqli_query($code, $query);
        }
        mysqli_close($code);
        header('Location: /VitaFruit/src/user/cart/show.php');
        exit;
    }
    else
    {
        header('Location: /VitaFruit/src/user/index.php');
        exit;
    }
?>