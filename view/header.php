<?php
session_start();
include "config.php";
// Kiểm tra nếu người dùng chưa đăng nhập
//if (!isset($_SESSION['user_id'])) {
//header("Location: login.php");
//exit;
//}



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

//user đăng nhập

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    //echo "Bạn cần đăng nhập để thực hiện hành động này.";
    //echo "<a href='login.php'>Đăng nhập</a>";
    //exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="view/img/logo reland/icon-logo tab bar browser.png">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Recland</title>

    <!--add font text-->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!--icon bài báo yêu thích-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!--End icon bài báo yêu thích-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- link icon banner-->
    <!-- End link icon banner-->


    <link rel="stylesheet" href="view/css/Base.css">
    <link rel="stylesheet" href="view/css/style.css">
    <link rel="stylesheet" href="view/css/reset.css">
    <link rel="stylesheet" href="view/responsive/responsive_index.css">
    <link rel="stylesheet" href="view/responsive_mobile/responsive_index_tablet.css">
    <link rel="stylesheet" href="view/responsive_tablet/responsive_index_mobile.css">


    <style>
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

        .news-card {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
            /* Bo góc cho thẻ tin tức */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Đổ bóng nhẹ */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            /* Hiệu ứng hover */
        }

        .news-card img {

            border-radius: 8px;
            /* Bo góc cho ảnh */
            margin-bottom: 10px;

            height: 156px;
            width: 380.33px;
        }

        .news-card a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .news-card a:hover {
            color: var(--primary);
        }


        .news-card:hover {
            transform: translateY(-5px);
            /* Hiệu ứng nổi lên khi hover */
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
            border-color: var(--primary);
        }

        .category {
            padding: 5px 17.4px;
            border: 0px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
            gap: 4px;
        }


        form {
            margin-bottom: 20px;

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

        .favorite-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 18px;
            color: #FF6347;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            padding: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            transition: transform 0.3s, background-color 0.3s;
        }

        .favorite-icon:hover {
            transform: scale(1.2);
            background-color: rgba(255, 99, 71, 1);
            color: #fff;
        }

        .news-card h4 {
            margin: 15px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .news-card h4 a {
            text-decoration: none;
            color: #333;
            transition: color 0.3s;
        }

        .news-card h4 a:hover {
            color: #007BFF;
        }
    </style>


</head>



<body>
    <div class="wapper">
        <!--Header-->
        <header class="header">
            <div class="wapper header-wapper">
                <a href="index.php" class="logo">
                    <img src="view/img/logo bao 2.png" alt="BÁO ONLINE">
                </a>
                <!--button đăng ký, đăng nhập-->
                <nav class="header-nav">
                    <ul class="header-nav_list">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <p>
                                <!-- Hiển thị hình tròn chứa chữ cái đầu tiên của tên người dùng -->
                                <span class="user-avatar"><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></span>
                                <a href="logout.php">Đăng xuất</a>
                            </p>
                        <?php else: ?>
                            <a href="login.php">Đăng nhập</a> | <a href="register.php">Đăng ký</a>

                        <?php endif; ?>
                    </ul>
                </nav>
                <!--end button đăng ký, đăng nhập-->
            </div>
        </header>
        <!--End Header-->



        <!-- Banner -->
        <div class="slide-show">
            <div class="banner">
                <img src="view/img/banner/bander.png" alt="Banner Recland">
                <img src="view/img/banner/ảnh chính 1.jpg" alt="Banner Recland">
                <img src="view/img/banner/ảnh 2.jpg" alt="Banner Recland">
            </div>

            <!--button icon banner-->
            <div class="btns">

                <div class="btn-left btn">
                    <i class='bx bx-chevron-left'></i>
                </div>

                <div class="btn-right btn">
                    <i class='bx bx-chevron-right'></i>
                </div>

            </div>
            <!--End button icon banner-->

        </div>

        <script src="view/index.js"></script>

        <!-- End Banner -->


        <!-- From tìm kiếm -->


        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; margin-top: 10px; flex-wrap: wrap;">
            <!-- Form tìm kiếm -->
            <form id="searchForm" method="GET" style="flex: 1; display: flex; gap: 10px; flex-wrap: wrap;">
                <input type="text" name="search" id="searchInput" placeholder="Nhập tiêu đề bài báo..."
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                    style="padding: 10px; flex: 1; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;">
                <button type="submit"
                    style="padding: 10px 20px; background-color: #007BFF; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
                    Tìm kiếm
                </button>
            </form>

            <!-- Phần chọn danh mục -->
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; width: 100%;">
                <label for="category" style="font-size: 14px;">Chọn danh mục:</label>
                <select class="category" name="category" id="category" onchange="location = this.value;"
                    style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;">
                    <option value="index.php">Tất cả</option>

                    <?php
                    if ($categories->num_rows > 0) {
                        while ($row = $categories->fetch_assoc()) {
                            echo "<option value='index.php?category=" . $row['id'] . "'";
                            if ($category_id == $row['id']) {
                                echo " selected";
                            }
                            echo ">" . $row['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <style>
            /* Responsive layout */
            @media (max-width: 768px) {

                /* Khi màn hình nhỏ hơn 768px */
                div[style*="display: flex; align-items: center;"] {
                    flex-direction: column;
                    /* Chuyển từ hàng sang cột */
                    gap: 20px;
                    /* Tăng khoảng cách giữa các phần tử */
                }

                #searchForm {
                    flex: 1;
                    width: 100%;
                    /* Form tìm kiếm chiếm toàn bộ chiều rộng */
                }

                .category {
                    width: 100%;
                    /* Chọn danh mục chiếm toàn bộ chiều rộng */
                }
            }
        </style>

        <!-- End From tìm kiếm -->

        <!-- list đề xuất key word sreach-->
        <div class="supgest-wrap">
            <span class="supgest-title">Đề Xuất:</span>
            <ul class="supgest-list">
                <li class="supgest-item">#Tin Tức</li>
                <li class="supgest-item">#Tin 24H</li>

                <li class="supgest-item">#Cuộc Sống</li>
                <li class="supgest-item">#Tuổi Trẻ</li>
                <li class="supgest-item">#Doanh Nghiệp</li>
                <li class="supgest-item">#Kinh Tế</li>
                <li class="supgest-item">#khởi Nghiệp</li>
            </ul>
        </div>
        <!--End list đề xuất key word sreach-->