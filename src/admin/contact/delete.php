<?php
include_once '../../../include/config.php';
include_once '../../../include/database.php';

session_start();
$username = $_SESSION['user'] ?? null;
role($username);

if (!isset($_GET['id'])) {
    header("Location: show.php");
    exit();
}

$id = intval($_GET['id']);
$query = "DELETE FROM contact WHERE id = $id";
delete($query);

header("Location: show.php");
exit();
?>
