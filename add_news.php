<?php
// Kết nối cơ sở dữ liệu
include "config.php";


// Lấy danh mục từ cơ sở dữ liệu
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);


//user đăng nhập
session_start();
// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "Bạn cần đăng nhập để thực hiện hành động này.";
    echo "<a href='login.php'>Đăng nhập</a>";
    exit;
}


?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="view/img/logo reland/icon-logo tab bar browser.png">
    <title>Thêm Tin Tức</title>
    <style>
        /* Styles để giao diện đẹp hơn */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .btn_back {
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
        textarea {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="file"] {
            margin: 10px 0;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Thêm Tin Tức Mới</h2>
        <!-- Form thêm bài báo -->
        <form action="add_news_handler.php" method="POST" enctype="multipart/form-data">
            <label for="title">Tiêu đề:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="content">Nội dung:</label>
            <textarea id="content" name="content" rows="6" required></textarea>

            <label for="image">Hình ảnh:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <label for="link">Liên kết (nếu có):</label>
            <input type="text" id="link" name="link">

            <!-- Dropdown danh mục -->
            <label for="category" class="category">Chọn danh mục:</label>
            <select id="category" name="category" required>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Không có danh mục</option>";
                }
                ?>
            </select>

            <br>

            <input type="submit" value="Thêm Tin Tức">
            <br>


        </form>
        <div class="btn_back">
            <a href="admin_dashboard.php"><input type="submit" value="Quay Về"></a>
        </div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Chào mừng, <?php echo $_SESSION['user_name']; ?>! <a href="logout.php">Đăng xuất</a></p>
        <?php else: ?>
            <a href="login.php">Đăng nhập</a> | <a href="register.php">Đăng ký</a>
        <?php endif; ?>
    </div>


</body>

</html>

<?php
$conn->close();
?>