<?php
// Kết nối cơ sở dữ liệu
include "config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $link = $_POST['link'];
    $category_id = $_POST['category']; // Lấy ID danh mục từ form

    // Xử lý file hình ảnh
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/"; // Thư mục lưu hình ảnh
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra nếu tệp là hình ảnh thực sự
    if (getimagesize($_FILES['image']['tmp_name']) === false) {
        echo "Chỉ chấp nhận file hình ảnh!";
        exit;
    }

    // Kiểm tra kích thước file (Tối đa 5MB)
    if ($_FILES['image']['size'] > 5000000) {
        echo "Xin lỗi, hình ảnh của bạn quá lớn.";
        exit;
    }

    // Chuyển file lên thư mục
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Insert vào cơ sở dữ liệu
        $sql = "INSERT INTO news (title, description, content, image, link, category_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $title, $description, $content, $target_file, $link, $category_id);

        if ($stmt->execute()) {
            echo "Tin tức đã được thêm thành công!";
            header("Location: admin_dashboard");  // Chuyển hướng về trang danh sách bài báo
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    } else {
        echo "Xin lỗi, đã có lỗi xảy ra khi tải hình ảnh lên.";
    }
}

$conn->close();
