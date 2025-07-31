<?php 
session_start();
require("../model/database.php");
require("../model/danhmuc.php");
require("../model/mathang.php");
require("../model/giohang.php");
require("../model/khachhang.php");
require("../model/diachi.php");
require("../model/donhang.php");
require("../model/donhangct.php");

$dm = new DANHMUC();
$danhmuc = $dm->laydanhmuc();
$mh = new MATHANG();
$mathangxemnhieu = $mh->laymathangxemnhieu();
$batdau = 0;
$soluong = 10;

$mathang = $mh->laymathangphantrang($batdau, $soluong);

if(isset($_REQUEST["action"])){
    $action = $_REQUEST["action"];
}
else{
    $action="null"; 
}


// Đăng xuất  
if(isset($_GET['action']) && $_GET['action'] == 'logout') {

  unset($_SESSION['user']);
  header("Location: index.php");

}


switch($action){
    case "null": 	
    	$mathang = $mh->laymathang();	
        include("main.php");
        break;

    case "group": 
        if(isset($_REQUEST["id"])){
            $madm = $_REQUEST["id"];
            $dmuc = $dm->laydanhmuctheoid($madm);
            $tendm =  $dmuc["tendanhmuc"];   
            $mathang = $mh->laymathangtheodanhmuc($madm);
            include("group.php");
        }
        else{
            include("main.php");
        }
        break;

    case "detail": 
        if(isset($_GET["id"])){
            $mahang = $_GET["id"];
            // tăng lượt xem lên 1
            $mh->tangluotxem($mahang);
            // lấy thông tin chi tiết mặt hàng
            $mhct = $mh->laymathangtheoid($mahang);
            // lấy các mặt hàng cùng danh mục
            $madm = $mhct["danhmuc_id"];
            $mathang = $mh->laymathangtheodanhmuc($madm);
            include("detail.php");
        }
        break;

    case "chovaogio":    
        if(isset($_REQUEST["id"]))
            $id = $_REQUEST["id"];
        if(isset($_REQUEST["soluong"]))
            $soluong = $_REQUEST["soluong"];
        else
            $soluong = 1;

        if(isset($_SESSION['giohang'][$id])){ // nếu đã có trong giỏ thi tăng số lượng
            $soluong += $_SESSION['giohang'][$id];
            $_SESSION['giohang'][$id] = $soluong;
        }
        else{       // nếu chưa thì thêm vào giỏ
            themhangvaogio($id, $soluong);
        }

        themhangvaogio($_REQUEST["id"], $soluong);

        $giohang = laygiohang();   
        include("cart.php");
        break;

    case "giohang":  
        $giohang = laygiohang();   
        include("cart.php");
        break;

    case "capnhatgio":
        if(isset($_REQUEST["mh"])){
            $mh = $_REQUEST["mh"];
            foreach ($mh as $id => $soluong) {
                if($soluong > 0)
                    capnhatsoluong($id, $soluong);
                else 
                    xoamotmathang($id);                
            }
        }  
        $giohang = laygiohang();   
        include("cart.php");
        break;

    case "xoagiohang":  
        xoagiohang();
        $giohang = laygiohang();   
        include("cart.php");
        break;

    case "thanhtoan":        
        $giohang = laygiohang();
        include("checkout.php");
        break;

    case "luudonhang": 
        $diachi = $_POST["txtdiachi"];
        if(!isset($_SESSION["khachhang"])){
            $email = $_POST["txtemail"];
            $hoten = $_POST["txthoten"];
            $sodienthoai = $_POST["txtsodienthoai"];
            
            // lưu thông tin khách nếu chưa có trong db (kiểm tra email có tồn tại chưa)
            // xử lý thêm...
            $kh = new KHACHHANG();
            $id = $kh->themkhachhang($email,$sodienthoai,$hoten);
            
            
        }
        else{
            $id = $_SESSION["khachhang"]["id"];
            
            $dc = new DIACHI();
            $diachi = $dc->laydiachikhachhang($id);            
            $diachi = $dc->laydiachikhachhang($id);

if (!$diachi || !isset($diachi['id'])) {
    $diachi_id = $dc->themdiachi($id, $diachi); // thêm mới nếu chưa có
} else {
    $diachi_id = $diachi['id']; // dùng lại nếu đã có
}
        }
        // lưu địa chỉ giao hàng
            $dc = new DIACHI();
            $diachi_id = $dc->themdiachi($id,$diachi);

        // lưu đơn hàng
        $dh = new DONHANG();
        $tongtien = tinhtiengiohang();
        $donhang_id = $dh->themdonhang($id,$diachi_id,$tongtien);
        
        // lưu chi tiết đơn hàng
        $ct = new DONHANGCT();      
        $giohang = laygiohang();
        foreach($giohang as $id => $mh){
            $dongia = $mh["giaban"];
            $soluong = $mh["soluong"];
            $thanhtien = $mh["thanhtien"];
            $ct->themchitietdonhang($donhang_id,$id,$dongia,$soluong,$thanhtien);
            $mh = new MATHANG();
            $mh->capnhatsoluong($id, $soluong);
        }
        
        // xóa giỏ hàng
        xoagiohang();
        
        // chuyển đến trang cảm ơn
        include("message.php");
        break;

   case "dangnhap":
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $matkhau = $_POST['matkhau'];

        $kh = new KHACHHANG();
        if ($kh->kiemtrakhachhanghople($email, $matkhau)) {
            $_SESSION["khachhang"] = $kh->laythongtinkhachhang($email);
            header("Location: index.php");
            exit();
        } else {
            $tb = "Đăng nhập không thành công!";
        }
    }
    include("loginform.php");
    break;

    case "xldangnhap":
        $email = $_POST["txtemail"];
        $matkhau = $_POST["txtmatkhau"];

        $kh = new KHACHHANG();
        $khachhang = $kh->laythongtinkhachhang($email);

        if ($khachhang && password_verify($matkhau, $khachhang["matkhau"])) {
            $_SESSION["khachhang"] = $khachhang;
            include("info.php");
        } else {
            $tb = "Đăng nhập không thành công!";
            include("loginform.php");
        }
        break;

    case "thongtin":
    $kh = new KHACHHANG();
    if (isset($_SESSION["khachhang"]["email"])) {
        $email = $_SESSION["khachhang"]["email"];
        $khachhang = $kh->laythongtinkhachhang($email);
        include("info.php");
    } else {
        echo "<div class='alert alert-danger'>Bạn chưa đăng nhập!</div>";
    }
    break;

	case "dangky":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $hoten = $_POST["hoten"];
            $email = $_POST["email"];
            $sodienthoai = $_POST["sodienthoai"];
            $matkhau = $_POST["matkhau"];

            $kh = new KHACHHANG();

            if ($kh->kiemtraemail($email)) {
                $error = "Email đã tồn tại!";
            } else {
                $kh->themkhachhang($hoten, $email, $sodienthoai, $matkhau);
                header("Location: index.php?action=dangnhap");
                exit();
            }
        }
        include("dangky.php");
        break;

	case "hienthongtinkhachhang":
	// add_customer.php

		$name = $_POST['name'];
		$email = $_POST['email'];

		// Lưu vào CSDL
		$sql = "INSERT INTO customers VALUES (
					   NULL, 
					   '$name', 
					   '$email',
					   '$phone',
					   '$address'
				  )";

		// Thực thi câu lệnh          
		$conn->query($sql);
        break;

    case "dangxuat":
        unset($_SESSION["khachhang"]);
        // chuyển về trang chủ
        // xử lý phân trang
		$tongso = $mh->demtongsomathang();
        $tongmh = $mh->demtongsomathang();   // tổng số mặt hàng
        $soluong = 4;                           // số lượng mh hiển thị trên trang 
        $tongsotrang = ceil($tongmh/$soluong);  // tổng số trang
        if(!isset($_REQUEST["trang"]))          // trang hiện hành: mặc định là trang đầu
            $tranghh = 1;   
        else                                    // hoặc hiển thị trang do người dùng chọn
            $tranghh = $_REQUEST["trang"];
        if($tranghh > $tongsotrang)
            $tranghh = $tongsotrang;
        else if($tranghh < 1)
            $tranghh = 1;
        $batdau = ($tranghh-1)*$soluong;          // mặt hàng bắt đầu sẽ lấy
        $mathang = $mh->laymathangphantrang($batdau, $soluong);

        $mathang = $mh->laymathang();   
        include("main.php");
        break;

	case "gioithieu":
        include("gioithieu.php");
        break;

    case "xldangky":
        $hoten = $_POST["txthoten"];
        $email = $_POST["txtemail"];
        $sodienthoai = $_POST["txtsodienthoai"];
        $matkhau = password_hash($_POST["txtmatkhau"], PASSWORD_DEFAULT);
    
        $kh = new KHACHHANG();
    
        if ($kh->kiemtraemail($email)) {
            $error = "Email đã tồn tại!";
            include("dangky.php");
        } else {
            // Thêm người dùng vào bảng quản lý người dùng (giống bảng `nguoidung`)
            $kh->themkhachhang($email, $sodienthoai, $hoten, $matkhau, "Khách hàng", "Kích hoạt");



            header("Location: index.php?action=dangnhap");
        }
        break;

        default:
        break;
}
?>
