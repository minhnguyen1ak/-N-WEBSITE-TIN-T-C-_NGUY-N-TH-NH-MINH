<?php
session_start();
include "config.php";

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Vui lòng đăng nhập để thực hiện thao tác này.";
    header("Location: favorite_list.php");
    exit;
}

$user_id = $_SESSION['user_id']; // ID người dùng từ session
$news_id = isset($_POST['news_id']) ? intval($_POST['news_id']) : 0;

if ($news_id > 0) {
    // Xóa bài báo khỏi danh sách yêu thích
    $sql_delete = "DELETE FROM favorite_news WHERE user_id = ? AND news_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("ii", $user_id, $news_id);

    if ($stmt_delete->execute()) {
        $_SESSION['message'] = "Đã xóa bài báo khỏi danh sách yêu thích.";
    } else {
        $_SESSION['message'] = "Lỗi khi xóa bài báo.";
    }
} else {
    $_SESSION['message'] = "Bài báo không hợp lệ.";
}

// Chuyển hướng lại trang danh sách yêu thích
header("Location: favorite_list.php");
exit;
