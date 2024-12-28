    <?php
    session_start();
    include "config.php";

    // Hiển thị thông báo từ session
    if (isset($_SESSION['message'])) {
        echo "<p style='color: green; font-weight: bold;'>" . htmlspecialchars($_SESSION['message']) . "</p>";
        unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị
    }

    // Kiểm tra người dùng đã đăng nhập chưa
    if (!isset($_SESSION['user_id'])) {
        echo "Vui lòng đăng nhập để xem danh sách yêu thích.";
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Lấy danh sách bài báo yêu thích
    $sql = "
       SELECT news.id, news.title, news.description
       FROM favorite_news
       INNER JOIN news ON favorite_news.news_id = news.id
       WHERE favorite_news.user_id = ?
   ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

        <title>Danh sách yêu thích</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f9;
                color: #333;
            }

            header {
                background-color: #007BFF;
                color: white;
                padding: 15px 20px;
                text-align: center;
                font-size: 24px;
                font-weight: bold;
            }

            .container {
                max-width: 800px;
                margin: 20px auto;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .message {
                color: green;
                font-weight: bold;
                margin-bottom: 20px;
            }

            .news-item {
                margin-bottom: 20px;
                padding: 15px;
                border: 1px solid #ddd;
                border-radius: 8px;
                background-color: #f9f9f9;
                transition: all 0.3s ease;
            }

            .news-item:hover {
                border-color: #007BFF;
                box-shadow: 0 2px 8px rgba(0, 123, 255, 0.2);
                background-color: #eef5ff;
            }

            .news-item h3 {
                margin: 0 0 10px;
                font-size: 20px;
                color: #007BFF;
            }

            .news-item h3 a {
                text-decoration: none;

            }

            .news-item h3 a:hover {
                text-decoration: underline;
            }

            .news-item p {
                margin: 0 0 10px;
                color: #555;
                line-height: 1.6;
            }

            .news-item a {
                display: inline-block;
                margin-top: 10px;
                padding: 10px 15px;
                color: white;
                background-color: #007BFF;
                text-decoration: none;
                border-radius: 4px;
                font-size: 14px;
                transition: background-color 0.3s ease;
            }

            .news-item a:hover {
                background-color: #0056b3;
            }

            .empty-list {
                text-align: center;
                color: #777;
                font-size: 16px;
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 8px;
                border: 1px solid #ddd;
            }


            button[type="submit"] {
                padding: 8px 12px;
                background-color: #FF6347;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            button[type="submit"]:hover {
                background-color: #FF4500;
            }
        </style>
    </head>

    <body>
        <header>Danh sách bài báo yêu thích</header>
        <div class="container">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message"><?php echo htmlspecialchars($_SESSION['message']); ?></div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="news-item">
                        <h3>
                            <a href="news-detail.php?id=<?php echo $row['id']; ?>">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </a>
                        </h3>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <a href="news-detail.php?id=<?php echo $row['id']; ?>">Xem chi tiết</a>

                        <form action="favorite_delete.php" method="POST" style="display: inline;">
                            <input type="hidden" name="news_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" style="margin-left: 10px; padding: 8px 12px; background-color: #FF6347; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
                                Xóa
                            </button>
                        </form>

                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-list">Bạn chưa có bài báo yêu thích nào.</div>
            <?php endif; ?>
        </div>
    </body>

    </html>