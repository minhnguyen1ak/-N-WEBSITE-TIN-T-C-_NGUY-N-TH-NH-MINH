<?php
// Kết nối cơ sở dữ liệu
include "config.php";


// Xử lý tìm kiếm
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

// Lấy ID từ URL, nếu có
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Nếu có tìm kiếm, thực hiện truy vấn tìm kiếm
if ($search_query) {
    $sql = "SELECT * FROM news WHERE title LIKE ? OR description LIKE ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $search_query_param = "%$search_query%";
    $stmt->bind_param("ss", $search_query_param, $search_query_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Nếu không tìm kiếm, chỉ lấy bài báo theo ID
    $sql = "SELECT * FROM news WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
}

if ($result->num_rows > 0) {
    $news = $result->fetch_assoc();
} else {
    echo "Bài báo không tồn tại.";
    exit;
}

// Lấy danh sách bài báo ngẫu nhiên (4 bài báo)
$news_list_sql = "SELECT * FROM news ORDER BY RAND() LIMIT 4"; // Lấy 4 bài báo ngẫu nhiên
$news_list_result = $conn->query($news_list_sql);

// Xử lý bình luận
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    $name = $_POST['name'];
    $comment = $_POST['comment'];

    // Thêm bình luận vào cơ sở dữ liệu
    if (!empty($name) && !empty($comment)) {
        $comment_sql = "INSERT INTO comments (news_id, name, comment) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($comment_sql);
        $stmt->bind_param("iss", $id, $name, $comment);
        $stmt->execute();
    }
}

// Xử lý xóa bình luận
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_comment'])) {
    $comment_id = $_POST['comment_id'];

    // Xóa bình luận từ cơ sở dữ liệu
    $delete_sql = "DELETE FROM comments WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $comment_id);
    if ($stmt->execute()) {
        echo "Bình luận đã được xóa.";
    } else {
        echo "Lỗi khi xóa bình luận.";
    }
}

// Lấy các bình luận của bài báo
$comments_sql = "SELECT * FROM comments WHERE news_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($comments_sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$comments_result = $stmt->get_result();

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
    <title><?php echo $news['title']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* Header styles */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            position: relative;
        }

        header .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .search-box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        header .search-box input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            width: 250px;
            outline: none;
        }

        header .search-box button {
            padding: 10px 15px;
            background-color: #0056b3;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        header .buttons {
            display: flex;
            gap: 10px;
        }

        header .menu-toggle {
            display: none;
            font-size: 24px;
            cursor: pointer;
        }

        header .menu {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 100%;
            right: 20px;
            background-color: #007BFF;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        header .menu a {
            color: #fff;
            padding: 10px;
            text-decoration: none;
            text-align: center;
        }

        header .menu a:hover {
            background-color: #0056b3;
        }

        /* Main content styles */
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        img {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            text-decoration: none;
            color: blue;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Footer styles */
        footer {
            margin-top: 40px;
            padding: 20px;
            background-color: #f1f1f1;
            text-align: center;
            color: #333;
        }

        footer .logo {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        footer p {
            margin: 5px 0;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            header .search-box {
                display: none;
            }

            header .menu-toggle {
                display: block;
            }

            header .buttons {
                display: none;
            }

            header .menu {
                display: flex;
            }
        }

        .news-list {
            margin-top: 30px;
        }

        .news-list h2 {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
        }

        .news-item {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .news-item img {
            max-width: 200px;
            height: auto;
            margin-right: 20px;
            border-radius: 8px;
        }

        .news-item .content {
            flex: 1;
        }

        .news-item h3 {
            font-size: 20px;
            color: #007BFF;
            margin: 0 0 10px;
        }

        .news-item h3 a {
            text-decoration: none;
            color: inherit;
        }

        .news-item h3 a:hover {
            text-decoration: underline;
        }

        .news-item p {
            font-size: 16px;
            color: #555;
        }

        /* Bình luận */
        .comment-section {
            margin-top: 40px;
        }

        .comment-section h2 {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
        }

        .comment-item {
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .comment-item p {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }

        .comment-item .author {
            font-weight: bold;
            color: #333;
        }

        .comment-form {
            margin-top: 20px;
        }

        .comment-form input,
        .comment-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .comment-form button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #4CAF50;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <a href="admin_dashboard.php" style="text-decoration: none; color: inherit;">ReclandNews</a>
        </div>
        <div class="search-box">
            <form action="news-detail.php" method="GET">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Tìm kiếm...">
                <button type="submit">Tìm</button>
            </form>
        </div>

        <div class="buttons">

            <?php if (isset($_SESSION['user_id'])): ?>
                <p>
                    <!-- Hiển thị hình tròn chứa chữ cái đầu tiên của tên người dùng -->
                    <span class="user-avatar"><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></span>
                    <a href="logout.php">Đăng xuất</a>
                </p>
            <?php else: ?>
                <a href="login.php">Đăng nhập</a> | <a href="register.php">Đăng ký</a>
            <?php endif; ?>

        </div>
        <div class="menu-toggle" onclick="toggleMenu()">☰</div>
        <div class="menu" id="menu">
            <?php if (isset($_SESSION['user_id'])): ?>
                <p>
                    <!-- Hiển thị hình tròn chứa chữ cái đầu tiên của tên người dùng -->
                    <span class="user-avatar"><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></span>
                    <a href="logout.php">Đăng xuất</a>
                </p>
            <?php else: ?>
                <a href="login.php">Đăng nhập</a> | <a href="register.php">Đăng ký</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="container">
        <h1><?php echo $news['title']; ?></h1>
        <p><strong><?php echo $news['description']; ?></strong></p>
        <img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>">
        <p><?php echo nl2br($news['content']); ?></p>
        <a href="admin_dashboard.php">Quay lại danh sách tin tức</a>

        <!-- Display List of News Articles -->
        <div class="news-list">
            <h2>Các bài báo khác</h2>
            <?php
            if ($news_list_result->num_rows > 0) {
                while ($row = $news_list_result->fetch_assoc()) {
                    echo '<div class="news-item">';
                    echo '<img src="' . $row['image'] . '" alt="' . $row['title'] . '">';
                    echo '<div class="content">';
                    echo '<h3><a href="admin_news-detail.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h3>';
                    echo '<p>' . substr($row['description'], 0, 100) . '...</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Không có bài báo nào.</p>';
            }
            ?>
        </div>

        <!-- Bình luận -->
        <div class="comment-section">
            <h2>Bình luận</h2>

            <?php
            // Hiển thị các bình luận
            while ($comment = $comments_result->fetch_assoc()) {
                echo '<div class="comment-item">';
                echo '<p class="author">' . htmlspecialchars($comment['name']) . ':</p>';
                echo '<p>' . nl2br(htmlspecialchars($comment['comment'])) . '</p>';

                echo '<form method="POST" action="" style="display:inline;">';
                echo '<input type="hidden" name="comment_id" value="' . $comment['id'] . '">';
                echo '<button type="submit" name="delete_comment" style="color: red;">Xóa</button>';
                echo '</form>';

                echo '</div>';
            }
            ?>

            <!-- Form bình luận -->
            <div class="comment-form">
                <h3>Thêm bình luận</h3>
                <form method="POST" action="">
                    <input type="text" name="name" placeholder="Tên của bạn" required />
                    <textarea name="comment" rows="4" placeholder="Nhập bình luận của bạn" required></textarea>


                    <button type="submit">Gửi bình luận</button>
                </form>
            </div>
        </div>
    </div>

    </div>

    <footer>
        <div class="logo">ReclandNews</div>
        <p>Liên hệ: admin@mynews.com</p>
        <p>© 2024 ReclandNews. Bản quyền được bảo lưu.</p>
    </footer>

    <script>
        // Toggle menu visibility
        function toggleMenu() {
            const menu = document.getElementById("menu");
            if (menu.style.display === "flex") {
                menu.style.display = "none";
            } else {
                menu.style.display = "flex";
            }
        }
    </script>

</body>

</html>