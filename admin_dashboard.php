<?php
session_start();

include "config.php";


// Kiểm tra nếu không phải admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Xử lý thêm danh mục nếu form được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {
    $name = $_POST['category_name'];
    $description = $_POST['category_description'];

    if (!empty($name)) {
        $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $description);

        if ($stmt->execute()) {
            echo "<script>alert('Danh mục đã được thêm thành công!');</script>";
        } else {
            echo "<script>alert('Lỗi khi thêm danh mục: " . $stmt->error . "');</script>";
        }
    } else {
        echo "<script>alert('Tên danh mục không được để trống!');</script>";
    }
}

// Lấy tất cả các danh mục
$sql = "SELECT * FROM categories";
$categories = $conn->query($sql);

// Lấy bài báo theo danh mục
$category_id = isset($_GET['category']) ? $_GET['category'] : null;
$sql = "SELECT * FROM news";
if ($category_id) {
    $sql .= " WHERE category_id = " . $category_id;
}
$result = $conn->query($sql);

//tìm kiếm bài báo 

// Lấy từ khóa tìm kiếm từ form
$search_query = isset($_GET['search']) ? $_GET['search'] : null;

// Lấy bài báo theo danh mục hoặc từ khóa tìm kiếm
$sql = "SELECT * FROM news";
if ($category_id || $search_query) {
    $conditions = [];
    if ($category_id) {
        $conditions[] = "category_id = " . $conn->real_escape_string($category_id);
    }
    if ($search_query) {
        $conditions[] = "title LIKE '%" . $conn->real_escape_string($search_query) . "%'";
    }
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$result = $conn->query($sql);



?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="view/img/logo reland/icon-logo tab bar browser.png">
    <title>Admin Dashboard</title>

    <style>
        .news-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .news-card {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .news-card img {
            width: 100%;
            height: 300px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .news-card a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        form {
            margin-bottom: 20px;
            margin-left: 37%;
        }

        form input,
        form textarea {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }

        form button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
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

        a {
            color: #28a745;
            text-decoration: none;
            background-color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            margin: 10px;
            display: inline-block;
        }

        a:hover {
            background-color: #45a049;
            color: white;
            text-decoration: none;
        }

        /* Tiêu đề và các liên kết thêm tin tức và danh mục */
        h1 {
            text-align: center;
            color: #333;
            margin-top: 30px;
        }

        /* Phần đăng nhập, đăng ký */
        /* Phần người dùng */
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #4CAF50;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <h1>Chào mừng Admin, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>

    <a href="logout.php">Đăng xuất</a>

    <!-- Các nội dung quản trị khác -->
    <a href="add_news.php" style="margin-bottom: 20px; display: inline-block;">Thêm Tin Tức Mới</a>
    <a href="add_category.php">Thêm danh mục</a>


    <form id="searchForm" method="GET" style="margin-bottom: 20px;">
        <input type="text" name="search" id="searchInput" placeholder="Nhập tiêu đề bài báo..."
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
            style="padding: 10px; width: 300px;">
        <button type="submit" style="padding: 10px;">Tìm kiếm</button>

        <?php if ($search_query): ?>
            <p>Kết quả tìm kiếm cho từ khóa: <strong><?php echo htmlspecialchars($search_query); ?></strong></p>
        <?php endif; ?>

    </form>
    <!-- Form chọn danh mục -->
    <div>
        <label for="category">Chọn danh mục:</label>
        <select name="category" id="category" onchange="location = this.value;">
            <option value="admin_dashboard.php">Tất cả</option>
            <?php
            if ($categories->num_rows > 0) {
                while ($row = $categories->fetch_assoc()) {
                    echo "<option value='admin_dashboard?category=" . $row['id'] . "' ";
                    if ($category_id == $row['id']) {
                        echo "selected";
                    }
                    echo ">" . $row['name'] . "</option>";
                }
            }

            ?>
        </select>
    </div>
    <!-- Xóa Danh Mục  bài báo -->
    <ul>
        <?php
        // Lấy lại danh mục
        $categories_result = $conn->query("SELECT * FROM categories");

        if ($categories_result->num_rows > 0) {
            while ($row = $categories_result->fetch_assoc()) {
                echo "<li>";
                echo $row['name'];
                echo " <a href='delete_category.php?id=" . $row['id'] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa danh mục này?')\">Xóa</a>";
                echo "</li>";
            }
        } else {
            echo "Chưa có danh mục nào.";
        }
        ?>
    </ul>
    <!--End  Xóa Danh Mục  bài báo -->

    <!-- Hiển thị các bài báo -->
    <div class="news-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='news-card'>";
                echo "<img src='" . $row['image'] . "' alt='" . $row['title'] . "'>";
                echo "<h4><a href='admin_news-detail.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></h4>";
                // Thêm nút sửa và xóa tin tức
                echo "<a href='edit_news.php?id=" . $row['id'] . "'>Sửa</a> | ";
                echo "<a href='delete_news.php?id=" . $row['id'] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa tin tức này?')\">Xóa</a>";
                echo "</div>";
            }
        } else {
            echo "Không có tin tức nào.";
        }
        ?>
    </div>
</body>

</html>
<?php
$conn->close();
?>