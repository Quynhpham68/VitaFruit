<?php
    include_once '../../../include/config.php';
    include_once '../../../include/database.php';
    $username = $_SESSION['user'];
    role($username);
    if(isset($_GET['page']))
    {
        $id = $_GET['id'];
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $query = "UPDATE orders SET status = 'Đã giao'  WHERE id =" .$id;
        update($query);
        header('Location: /VegetableWeb/src/admin/order/show.php?page='.$page);
        exit;
    }

?>