<!-- list danh sách tin hot-->
<div class="jods-wrap">

    <div class="jods-header">
        <div class="jods-heading-wrap">
            <div class="jods-heading-icon-wrap">
                <div class="jods-heading-icon">
                    <!-- icon heart-->
                    <svg width="25" height="21" viewBox="0 0 25 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M24.2867 6.60341C24.2867 14.855 16.6522 19.7213 13.2317 20.885C12.8262 21.0261 12.1738 21.0261 11.7683 20.885C10.3048 20.3913 8.06564 19.21 6.00275 17.3939C3.21696 14.9431 0.713272 11.3287 0.713272 6.60341C0.713272 2.95367 3.6401 0.00921631 7.25457 0.00921631C9.40563 0.00921631 11.3099 1.04946 12.5088 2.6363C13.6901 1.04946 15.5943 0.00921631 17.7454 0.00921631C18.6799 0.00921631 19.5614 0.203159 20.3725 0.555791C22.6822 1.57842 24.2867 3.88815 24.2867 6.60341Z"
                            fill="#FE4C4C" />
                    </svg>
                    <!-- #end heart-->
                </div>
            </div>
            <h2 class="heading">Tin Tức Hot Nhất</h2>
        </div>
        <a href="#" class="jobs-heading-link">
            Xem Tất Cả
        </a>
    </div>


    <!-- card list jods -->
    <ul class="jods-card-list">

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $image_path = $row['image'];

                echo "<div class='news-card'>";
                echo "<div class='news-image-wrap'>";
                if (file_exists($image_path)) {
                    echo "<img src='" . $image_path . "' alt='" . $row['title'] . "'>";
                } else {
                    echo "<img src='view/img/default-image.jpg' alt='Hình ảnh không tồn tại'>";
                }
                // Icon yêu thích
                echo "<a href='favorite_action.php?news_id=" . $row['id'] . "' class='favorite-icon' title='Thêm vào yêu thích'>";
                echo "<i class='fas fa-heart'></i>";
                echo "</a>";
                echo "</div>";
                echo "<h4><a href='news-detail.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></h4>";
                echo "</div>";
            }
        } else {
            echo "Không có tin tức nào.";
        }
        ?>

    </ul>
    <!-- #end card list jods -->
</div>
<!--End list danh sách tin hot-->