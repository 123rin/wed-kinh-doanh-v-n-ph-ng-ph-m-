<?php
session_start();
if (!isset($_SESSION['nguoidung']) || $_SESSION['nguoidung']['loai'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
require_once("../dbconnect.php");

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == 'xacnhan') {
        $sql = "UPDATE donhang SET trangthai = 'Đã xác nhận' WHERE id = $id";
    } elseif ($action == 'huy') {
        $sql = "UPDATE donhang SET trangthai = 'Đã hủy' WHERE id = $id";
    }

    if (isset($sql)) {
        mysqli_query($conn, $sql);
    }
}
header("Location: donhang.php");
exit();
