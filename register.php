<?php
require 'config.php'; // Kết nối database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($name) || empty($email) || empty($password)) {
        echo "Vui lòng điền đầy đủ thông tin!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email không hợp lệ!";
    } else {
        // Kiểm tra email đã tồn tại chưa
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            echo "Email đã được sử dụng!";
        } else {
            // Mã hóa mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$name, $email, $hashed_password])) {
                echo "Đăng ký thành công!";
            } else {
                echo "Lỗi khi đăng ký!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 50px; }
        form { max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { background: #28a745; color: white; padding: 10px; width: 100%; border: none; }
    </style>
</head>
<body>
    <h2>Đăng ký tài khoản</h2>
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Họ và tên" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng ký</button>
    </form>
</body>
</html>
