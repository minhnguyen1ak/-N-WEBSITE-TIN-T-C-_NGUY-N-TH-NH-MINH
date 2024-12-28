<?php
// Kết nối cơ sở dữ liệu
include "config.php";


// Xử lý yêu cầu xóa danh mục
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Kiểm tra xem danh mục có bài viết nào không
    $check_sql = "SELECT COUNT(*) as total FROM news WHERE category_id = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("i", $category_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['total'] > 0) {
        echo "<script>alert('Không thể xóa danh mục vì có bài viết liên quan.');</script>";
    } else {
        $delete_sql = "DELETE FROM categories WHERE id = ?";
        $stmt_delete = $conn->prepare($delete_sql);
        $stmt_delete->bind_param("i", $category_id);

        if ($stmt_delete->execute()) {
            echo "<script>alert('Danh mục đã được xóa thành công!');</script>";
        } else {
            echo "<script>alert('Lỗi khi xóa danh mục: " . $stmt_delete->error . "');</script>";
        }
    }

    // Quay về trang danh sách
    echo "<script>window.location = 'admin_dashboard';</script>";
} else {
    echo "<script>alert('ID danh mục không hợp lệ!');</script>";
    echo "<script>window.location = 'admin_dashboard';</script>";
}

$conn->close();
