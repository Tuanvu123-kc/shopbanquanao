
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
<?php
include 'config.php'; // Kết nối database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Mã hóa password

    // Kiểm tra username hoặc email đã tồn tại chưa
    $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $check->execute([$username, $email]);
    
    if ($check->rowCount() > 0) {
        echo "Username hoặc Email đã tồn tại!";
    } else {
        // Chèn dữ liệu vào bảng
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $password])) {
            echo "Đăng ký thành công!";
        } else {
            echo "Lỗi đăng ký!";
        }
    }
}
?>

<form method="POST">
    <label>Username:</label>
    <input type="text" name="username" required>
    <br>
    <label>Email:</label>
    <input type="email" name="email" required>
    <br>
    <label>Password:</label>
    <input type="password" name="password" required>
    <br>
    <button type="submit">Đăng ký</button>
</form>
