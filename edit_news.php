<?php
// Kết nối cơ sở dữ liệu
include "config.php";


// Lấy ID bài báo cần sửa từ URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy dữ liệu bài báo từ cơ sở dữ liệu
    $sql = "SELECT * FROM news WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $news = $result->fetch_assoc();

    if (!$news) {
        echo "Không tìm thấy bài báo.";
        exit;
    }

    // Lấy danh sách danh mục
    $sql_categories = "SELECT id, name FROM categories";
    $result_categories = $conn->query($sql_categories);

    if (!$result_categories) {
        echo "Lỗi khi lấy danh mục: " . $conn->error;
        exit;
    }
} else {
    echo "Không có ID bài báo.";
    exit;
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

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="view/img/logo reland/icon-logo tab bar browser.png">
    <title>Sửa Tin Tức</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        textarea,
        select {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Sửa Tin Tức</h2>
        <!-- Form sửa bài báo -->
        <form action="edit_news_handler.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $news['id']; ?>">

            <label for="title">Tiêu đề:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($news['title']); ?>" required>

            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($news['description']); ?></textarea>

            <label for="content">Nội dung:</label>
            <textarea id="content" name="content" rows="6" required><?php echo htmlspecialchars($news['content']); ?></textarea>

            <label for="category">Danh mục:</label>
            <select id="category" name="category" required>
                <?php while ($category = $result_categories->fetch_assoc()) { ?>
                    <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $news['category_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php } ?>
            </select>

            <label for="image">Hình ảnh:</label>
            <input type="file" id="image" name="image" accept="image/*">

            <label for="link">Liên kết (nếu có):</label>
            <input type="text" id="link" name="link" value="<?php echo htmlspecialchars($news['link']); ?>">

            <input type="submit" value="Cập nhật Tin Tức">
        </form>
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Chào mừng, <?php echo $_SESSION['user_name']; ?>! <a href="logout.php">Đăng xuất</a></p>
        <?php else: ?>
            <a href="login.php">Đăng nhập</a> | <a href="register.php">Đăng ký</a>
        <?php endif; ?>
    </div>
</body>

</html>