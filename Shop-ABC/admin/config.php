<?php
// Gọi đường dẫn gốc của dự án (Shop-ABC)
define('ROOT_PATH', realpath(__DIR__ . '/../'));

// Nạp file kết nối CSDL
require_once(ROOT_PATH . '/model/database.php');
