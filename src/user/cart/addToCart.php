<?php include("../connect.php");
    include_once '../../../include/config.php';
    include_once '../layout/header.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $query = "select id from user where email = '$username'";
        $kq = mysqli_query($code, $query);
        $user = mysqli_fetch_assoc($kq);
        $userId = $user['id'];
        $query = "select id, quantity from cart where userId = $userId";
        $kq = mysqli_query($code, $query);
        if (mysqli_num_rows($kq) == 0)
        {
            $query = "INSERT INTO cart (quantity, userId) VALUES (0, $userId)";
            mysqli_query($code, $query);
            $cartId = mysqli_insert_id($code);
            $quantityCart = 1;
        }
        else
        {
            $cart = mysqli_fetch_assoc($kq);
            $cartId = $cart['id'];
            $quantityCart = $cart['quantity'] + 1;
        }
            $productId = $_POST['idProduct'];

            $query = "SELECT id, quantity FROM cart_detail WHERE productId = $productId AND cartId = $cartId";
            $kq = mysqli_query($code, $query);
            $query = "select price, quantity from product where id = $productId";
            $kq1 = mysqli_query($code, $query);
            $price = mysqli_fetch_assoc($kq1);
            // Kiểm tra hết hàng
            if ($price['quantity'] <= 0) {
                mysqli_close($code);
                echo "<script>alert('Sản phẩm đã hết hàng, không thể thêm vào giỏ!'); window.location='/VitaFruit/src/user/shop.php';</script>";
                exit;
            }
            if (mysqli_num_rows($kq) == 0)
            {
                $priceP = $price['price'];
                $query = "INSERT INTO cart_detail (quantity, cartId, productId, price) VALUES (1, $cartId, $productId, $priceP)";
                mysqli_query($code, $query);

                $query = "UPDATE cart SET quantity = $quantityCart WHERE id = $cartId";
                mysqli_query($code, $query);

            }
            else
            {
                $cd = mysqli_fetch_assoc($kq);
                if($cd['quantity'] < $price['quantity'] - 1)
                    $quantity = $cd['quantity'] + 1;
                else
                    $quantity = $cd['quantity'];
                $cdId = $cd['id'];
                $query = "UPDATE cart_detail SET quantity = $quantity WHERE id = $cdId";
                mysqli_query($code, $query);
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