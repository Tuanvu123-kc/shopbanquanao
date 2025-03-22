<?php
include "config.php";

// Kiểm tra nếu có yêu cầu xóa sản phẩm
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Xóa sản phẩm từ database
    $sql = "DELETE FROM products WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Xóa sản phẩm thành công!'); window.location='index.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "Không có sản phẩm nào được chọn để xóa.";
}

$conn->close();
?>
