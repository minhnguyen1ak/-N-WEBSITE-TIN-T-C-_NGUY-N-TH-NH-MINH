<?php
// Kết nối cơ sở dữ liệu
include "config.php";


// Kiểm tra nếu có tham số ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn xóa
    $sql = "DELETE FROM news WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Tin tức đã được xóa thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "Không tìm thấy ID của tin tức.";
}


//user đăng nhập
session_start();
// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "Bạn cần đăng nhập để thực hiện hành động này.";
    echo "<a href='login.php'>Đăng nhập</a>";
    exit;
}
$conn->close();
?>
<?php if (isset($_SESSION['user_id'])): ?>
    <p>Chào mừng, <?php echo $_SESSION['user_name']; ?>! <a href="logout.php">Đăng xuất</a></p>
<?php else: ?>
    <a href="login.php">Đăng nhập</a> | <a href="register.php">Đăng ký</a>
<?php endif; ?>
<a href="admin_dashboard">Quay lại danh sách tin tức</a>