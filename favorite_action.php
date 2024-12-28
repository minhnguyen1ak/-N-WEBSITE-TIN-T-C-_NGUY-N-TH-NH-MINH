<?php
session_start();
include "config.php";

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Chuyển đến trang đăng nhập nếu chưa đăng nhập
    exit;
}

$user_id = $_SESSION['user_id'];
$news_id = isset($_GET['news_id']) ? intval($_GET['news_id']) : 0;

// Kiểm tra bài báo đã tồn tại trong danh sách yêu thích chưa
$sql_check = "SELECT * FROM favorite_news WHERE user_id = ? AND news_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $user_id, $news_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    $_SESSION['message'] = "Bài báo đã tồn tại trong danh sách yêu thích!";
} else {
    // Thêm bài báo vào danh sách yêu thích
    $sql_insert = "INSERT INTO favorite_news (user_id, news_id) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ii", $user_id, $news_id);

    if ($stmt_insert->execute()) {
        $_SESSION['message'] = "Bài báo đã được thêm vào danh sách yêu thích!";
    } else {
        $_SESSION['message'] = "Có lỗi xảy ra, vui lòng thử lại!";
    }
}

// Chuyển hướng đến trang danh sách yêu thích
header("Location: favorite_list.php");
exit;
