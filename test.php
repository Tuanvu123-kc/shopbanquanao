<?php
session_start();
$servername = "54.206.216.177";
$username = "admin";
$password = "123456";
$database = "tam"; // Nếu có database cụ thể

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
echo "Kết nối MySQL thành công!";
?>