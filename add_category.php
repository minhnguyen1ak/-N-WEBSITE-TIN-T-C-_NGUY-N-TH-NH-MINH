<?php
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
    <title>Thêm Danh Mục</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
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

        .btn_back {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            margin-top: 10px;

            background-color: #45a049;

        }
    </style>
</head>

<body>


    <div class="container">

        <h2>Thêm Danh Mục Mới</h2>
        <form action="add_category_handler.php" method="POST">
            <label for="name">Tên Danh Mục:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Mô Tả:</label>
            <textarea id="description" name="description" rows="4"></textarea>

            <input type="submit" value="Thêm Danh Mục">



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