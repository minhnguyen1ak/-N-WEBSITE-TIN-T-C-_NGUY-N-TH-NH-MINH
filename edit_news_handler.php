<?php
// Kết nối cơ sở dữ liệu
include "config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $link = $_POST['link'];
    $category_id = $_POST['category']; // Danh mục bài viết

    // Kiểm tra nếu người dùng tải hình ảnh mới lên
    if ($_FILES['image']['name']) {
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

        // Di chuyển tệp hình ảnh vào thư mục
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Cập nhật bài báo với hình ảnh mới
            $sql = "UPDATE news SET title = ?, description = ?, content = ?, image = ?, link = ?, category_id = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssii", $title, $description, $content, $target_file, $link, $category_id, $id);

            if ($stmt->execute()) {
                echo "Bài báo đã được cập nhật thành công!";
                header("Location: admin_dashboard"); // Chuyển hướng về trang danh sách bài báo
                exit;
            } else {
                echo "Lỗi khi cập nhật bài báo: " . $stmt->error;
            }
        } else {
            echo "Đã có lỗi xảy ra khi tải hình ảnh lên.";
        }
    } else {
        // Nếu không có hình ảnh mới, chỉ cập nhật các trường khác
        $sql = "UPDATE news SET title = ?, description = ?, content = ?, link = ?, category_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $title, $description, $content, $link, $category_id, $id);

        if ($stmt->execute()) {
            echo "Bài báo đã được cập nhật thành công!";
            header("Location: admin_dashboard"); // Chuyển hướng về trang danh sách bài báo
            exit;
        } else {
            echo "Lỗi khi cập nhật bài báo: " . $stmt->error;
        }
    }
}

$conn->close();
