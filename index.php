<?php
include "config.php";

// Truy vấn danh sách sản phẩm
$mysql = "SELECT id, name, image, price FROM products";
$result = $conn->query($mysql);

// Kiểm tra lỗi truy vấn
if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa Hàng Áo Da Nam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #333;
            text-align: center;
            padding: 20px;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            background-color: #343a40;
            padding: 10px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: auto;
        }
        .product {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            background: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .product img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .product h2 {
            font-size: 16px;
            margin: 10px 0;
        }
        .product p {
            font-size: 14px;
            color: #e60000;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin-top: 5px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="index.php">Trang chủ</a>
            <?php if (isset($_SESSION['username'])): ?>
                <a href="add_product.php">Thêm sản phẩm</a>
                <a href="logout.php">Đăng xuất (<?php echo $_SESSION['username']; ?>)</a>
            <?php else: ?>
                <a href="login.php">Đăng nhập</a>
                <a href="register.php">Đăng ký</a>
            <?php endif; ?>
        </div>
    </div>
    <h1>Cửa Hàng Quần Áo Nam</h1>
    <div class="product-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product">
                <img src="upload/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                <p><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</p>
                <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn">Chỉnh sửa</a>
                <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
<?php 
// Đóng kết nối database
mysqli_close($conn);
?>
