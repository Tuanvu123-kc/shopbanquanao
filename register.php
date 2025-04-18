<?php
include 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Kiểm tra xem username hoặc email đã tồn tại chưa
    $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "Username hoặc Email đã tồn tại!";
    } else {
        // Thêm người dùng mới
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $message = "Đăng ký thành công!";
        } else {
            $message = "Lỗi đăng ký: " . $stmt->error;
        }

        $stmt->close();
    }

    $check->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 15px;
        }
        .form-container label {
            display: block;
            margin: 10px 0 5px;
        }
        .form-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background: #4CAF50;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }
        .form-container .message {
            margin-top: 10px;
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Đăng ký</h2>
        <?php if (!empty($message)) echo "<div class='message'>$message</div>"; ?>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Đăng ký</button>
        </form>
    </div>
</body>
</html>
