<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$servername = "database-6.c3gmegauif3s.ap-southeast-2.rds.amazonaws.com";
$username = "admin";
$password = "12345678";
$dbname = "qlbh";

// Kết nối database
$conn = new mysqli($servername, $username, $password, $dbname, 3306);

// Kiểm tra lỗi kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thiết lập mã hóa UTF-8 để tránh lỗi tiếng Việt
$conn->set_charset("utf8");

?>
