<?php 
session_start();
if(!isset($_SESSION["nguoidung"]) || $_SESSION["nguoidung"]["loai"] != "admin")
    header("location:../index.php");

require("../../model/database.php");
require("../../model/donhang.php");

$donhang = new DONHANG();
$dsdonhang = [];
$action = $_REQUEST["action"] ?? "xem";

switch($action){
    case "xem":
        $dsdonhang = $donhang->laydonhang();    
        include("donhang.php");
        break;
    case "xacnhan":
        $donhang->capnhatTrangThai($_GET["id"], "Đã xác nhận");
        $dsdonhang = $donhang->laydonhang();    
        include("donhang.php");
        break;
    case "huy":
        $donhang->capnhatTrangThai($_GET["id"], "Đã hủy");
        $dsdonhang = $donhang->laydonhang();    
        include("donhang.php");
        break;
}
?>
