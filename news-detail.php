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
//if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_comment'])) {
//$comment_id = $_POST['comment_id'];

// Xóa bình luận từ cơ sở dữ liệu
//$delete_sql = "DELETE FROM comments WHERE id = ?";
//$stmt = $conn->prepare($delete_sql);
//$stmt->bind_param("i", $comment_id);
//if ($stmt->execute()) {
//echo "Bình luận đã được xóa.";
//} else {
//echo "Lỗi khi xóa bình luận.";
//}
//}

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

// Xử lý đánh giá
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating']) && isset($_POST['news_id'])) {
    $user_id = $_SESSION['user_id'];
    $news_id = $_POST['news_id'];
    $rating = (int) $_POST['rating'];

    // Kiểm tra xem người dùng đã đánh giá bài báo này chưa
    $check_sql = "SELECT * FROM ratings WHERE news_id = $news_id AND user_id = $user_id";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Cập nhật đánh giá nếu đã tồn tại
        $update_sql = "UPDATE ratings SET rating = $rating WHERE news_id = $news_id AND user_id = $user_id";
        $conn->query($update_sql);
    } else {
        // Thêm đánh giá mới
        $insert_sql = "INSERT INTO ratings (news_id, user_id, rating) VALUES ($news_id, $user_id, $rating)";
        $conn->query($insert_sql);
    }

    echo "Đánh giá của bạn đã được lưu.";
}

// Lấy đánh giá trung bình cho bài báo
$news_id = $news['id'];
$rating_sql = "SELECT AVG(rating) AS average_rating, COUNT(*) AS total_ratings FROM ratings WHERE news_id = $news_id";
$rating_result = $conn->query($rating_sql);
$average_rating = 0;
$total_ratings = 0;

if ($rating_result->num_rows > 0) {
    $rating_data = $rating_result->fetch_assoc();
    $average_rating = isset($rating_data['average_rating']) ? round($rating_data['average_rating'], 1) : 0;
    $total_ratings = $rating_data['total_ratings'];
}

// Lấy danh sách đánh giá
$ratings_list_sql = "SELECT r.rating, r.created_at, u.name FROM ratings r JOIN users u ON r.user_id = u.id WHERE r.news_id = ? ORDER BY r.created_at DESC";
$stmt = $conn->prepare($ratings_list_sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$ratings_result = $stmt->get_result();


$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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

        .share-section {
            margin-top: 20px;

        }

        .share-section h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .share-section button {
            padding: 10px 15px;
            margin: 5px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .share-section button:hover {
            background-color: #0056b3;
        }

        .share-section a {
            text-decoration: none;
        }

        /* css đánh giá bài báo*/

        .star-rating {
            display: flex;
            gap: 5px;
            font-size: 24px;
            cursor: pointer;
            color: #ccc;
        }

        .star-rating .star.selected,
        .star-rating .star:hover,
        .star-rating .star:hover~.star {
            color: #f39c12;
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <a href="index.php" style="text-decoration: none; color: inherit;">ReclandNews</a>
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

        <!-- chia sẻ bài báo -->
        <div class="share-section">
            <h2>Chia sẻ bài viết</h2>
            <button onclick="shareArticle()">Sao chép liên kết</button>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("http://yourwebsite.com/news-detail.php?id=" . $id); ?>" target="_blank">
                <button>Chia sẻ Facebook</button>
            </a>
            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode("http://yourwebsite.com/news-detail.php?id=" . $id); ?>" target="_blank">
                <button>Chia sẻ Twitter</button>
            </a>

            <a href="">
                <!-- Thêm nút Yêu thích -->
                <form action="favorite_action.php" method="POST" style="margin-top: 20px;">
                    <input type="hidden" name="news_id" value="<?php echo $id; ?>">
                    <button type="submit" style="padding: 10px 20px; background-color: #FFD700; color: #000; border: none; border-radius: 4px; cursor: pointer;">
                        Thêm vào Yêu thích
                    </button>
                </form>

            </a>

        </div>
        <!--End chia sẻ bài báo -->


        <p><strong><?php echo $news['description']; ?></strong></p>
        <img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>">
        <p><?php echo nl2br($news['content']); ?></p>
        <a href="index.php">Quay lại danh sách tin tức</a>

        <!-- lấy ngẫu nhiên danh sách bài báo và hiển thị ra -->
        <div class="news-list">
            <h2>Các bài báo khác</h2>
            <?php
            if ($news_list_result->num_rows > 0) {
                while ($row = $news_list_result->fetch_assoc()) {
                    echo '<div class="news-item">';
                    echo '<img src="' . $row['image'] . '" alt="' . $row['title'] . '">';
                    echo '<div class="content">';
                    echo '<h3><a href="news-detail.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h3>';
                    echo '<p>' . substr($row['description'], 0, 100) . '...</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Không có bài báo nào.</p>';
            }
            ?>
        </div>

        <!-- Đánh giá bài báo -->
        <div class="rating-section">
            <p>Đánh giá bài báo: <?php echo $average_rating; ?> / 5 (<?php echo $total_ratings; ?> đánh giá)</p>
            <form id="rating-form" method="POST" action="">
                <input type="hidden" name="news_id" value="<?php echo $news_id; ?>">
                <input type="hidden" id="selected-rating" name="rating" value="0">
                <div class="star-rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="star" data-value="<?php echo $i; ?>">&#9733;</span>
                    <?php endfor; ?>
                </div>
                <button type="submit" style="margin-top: 10px;">Gửi đánh giá</button>
            </form>
        </div>

        <!-- Danh sách đánh giá -->
        <div class="rating-list">
            <h2>Danh sách đánh giá bài báo</h2>
            <?php
            if ($ratings_result->num_rows > 0) {
                while ($rating = $ratings_result->fetch_assoc()) {
                    echo '<p>' . htmlspecialchars($rating['name']) . ' đã đánh giá: ';
                    echo str_repeat('⭐', $rating['rating']) . str_repeat('☆', 5 - $rating['rating']);
                    echo '<br>  Vào lúc: ' . htmlspecialchars($rating['created_at']) . '</p>';
                }
            } else {
                echo '<p>Chưa có đánh giá nào.</p>';
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
                //echo '<button type="submit" name="delete_comment" style="color: red;">Xóa</button>';
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

        //share bài báo
        function shareArticle() {
            const link = "<?php echo "http://localhost/Do_AN_Website_Tin_Tuc/news-detail.php?id=" . $id; ?>";
            navigator.clipboard.writeText(link).then(() => {
                alert("Liên kết bài viết đã được sao chép!");
            }).catch(err => {
                alert("Không thể sao chép liên kết. Vui lòng thử lại.");
            });
        }

        // JavaScript để xử lý sự kiện click vào ngôi sao
        const stars = document.querySelectorAll('.star-rating .star');
        const ratingInput = document.getElementById('selected-rating');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const ratingValue = this.getAttribute('data-value');
                ratingInput.value = ratingValue;

                // Reset màu sắc các ngôi sao
                stars.forEach(s => s.classList.remove('selected'));

                // Đánh dấu các ngôi sao được chọn
                this.classList.add('selected');
                let prevSibling = this.previousElementSibling;
                while (prevSibling) {
                    prevSibling.classList.add('selected');
                    prevSibling = prevSibling.previousElementSibling;
                }
            });
        });
    </script>

</body>

</html>