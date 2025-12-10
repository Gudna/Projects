<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'qlbh_xe');
define('DB_CHARSET', 'utf8mb4');

define('APP_NAME', 'Quản lý Bảo hiểm Xe');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://localhost/FProjects/5');
define('BASE_PATH', dirname(dirname(__FILE__)));

define('ROLE_CUSTOMER_STAFF', 'KhachHangNV');
define('ROLE_VEHICLE_STAFF', 'PhuongTienNV');
define('ROLE_CLAIMS_STAFF', 'BoiThuongNV');
define('ROLE_ACCOUNTING_STAFF', 'KeToanNV');

date_default_timezone_set('Asia/Ho_Chi_Minh');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once BASE_PATH . '/core/Database.php';
require_once BASE_PATH . '/core/Logger.php';
require_once BASE_PATH . '/core/Model.php';
require_once BASE_PATH . '/core/Controller.php';
