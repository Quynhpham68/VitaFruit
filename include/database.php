<?php
    function connect()
    {
        $code = @mysqli_connect("localhost", "root", "");
        mysqli_select_db($code, "vegetable3");
        return $code;
    }

    function view(string $query)
    {
        $code = connect();
        $kq = mysqli_query($code, $query);
        mysqli_close($code);
        return $kq;
    }

    function countPage( string $query, int $offset)
    {
        $code = connect();
        $kq = mysqli_query($code, $query);
        if ($kq) {
            $row = mysqli_fetch_assoc($kq);
            $page = (int) $row['total_rows'];
            mysqli_close($code);
            return  ceil($page / $offset);
        } else {
            mysqli_close($code);
            return 0;
        }
    }

    function countSum(string $name)
    {
        $code = connect();
        $query = "SELECT COUNT(*) AS total_rows FROM ".$name;
        $kq = mysqli_query($code, $query);
        if ($kq) {
            $row = mysqli_fetch_assoc($kq);
            $num = (int) $row['total_rows'];
            mysqli_close($code);
            return $num;
        } else {
            mysqli_close($code);
            return 0;
        }
    }
    function create($code, string $query)
    {
        mysqli_query($code, $query);
        mysqli_close($code);
    }

    function delete(string $query)
    {
        $code = connect();
        mysqli_query($code, $query);
        mysqli_close($code);
    }

    function update(string $query)
    {
        $code = connect();
        $kq = mysqli_query($code, $query);
        mysqli_close($code);
        return $kq;
    }

    function role(string $username)
    {
        $code = connect();
        $query = "select r.id from user u join role r on u.roleID = r.id where u.email = '$username'";
        $kq = mysqli_query($code, $query);
        $row = mysqli_fetch_assoc($kq);
        $role =  (int) $row['id'];
        mysqli_close($code);
        if($role == 1)
        {
            header('Location: /VegetableWeb/src/admin/deny.php');
            exit;
        }
    }
?>