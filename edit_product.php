<?php
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT name, price, image FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "<script>alert('Không tìm thấy sản phẩm!'); window.location='index.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $image = $product['image'];
    
    if (!empty($_FILES["image"]["name"])) {
        $image = $_FILES["image"]["name"];
        $target = "upload/" . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target);
    }
    
    $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sdsi", $name, $price, $image, $id);
    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật sản phẩm thành công!'); window.location='index.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F8F9FA;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-submit {
            background-color: #000;
            border: none;
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
            color: white;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .btn-submit:hover {
            background-color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Chỉnh sửa sản phẩm</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" value="<?php echo $product['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Giá sản phẩm (VNĐ)</label>
            <input type="number" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Hình ảnh</label>
            <input type="file" name="image" class="form-control">
            <p>Hình ảnh hiện tại: <img src="upload/<?php echo $product['image']; ?>" width="100"></p>
        </div>
        <button type="submit" class="btn btn-submit">Cập nhật</button>
    </form>
</div>

</body>
</html>
