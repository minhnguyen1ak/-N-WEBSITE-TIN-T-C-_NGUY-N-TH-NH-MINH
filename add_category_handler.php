<?php
// Kết nối cơ sở dữ liệu
include "config.php";

// Kiểm tra nếu dữ liệu đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Thêm danh mục vào cơ sở dữ liệu
    $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $description);

    if ($stmt->execute()) {
        echo "Danh mục đã được thêm thành công!";
        // Chuyển hướng về trang danh sách danh mục sau khi thêm thành công
        header("Location: admin_dashboard.php");
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}


$conn->close();
