<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="view/img/logo reland/icon-logo tab bar browser.png">
    <title>article list_Tin_Tức</title>

    <!--add font text-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap"
        rel="stylesheet" />

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- link icon banner-->
    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet" />
    <!-- End link icon banner-->
    <link rel="stylesheet" href="view/css/Base.css" />
    <link rel="stylesheet" href="view/css/style.css" />
    <link rel="stylesheet" href="view/css/reset.css" />
    <link rel="stylesheet" href="view/responsive/responsive_index.css" />
    <link
        rel="stylesheet"
        href="view/responsive_mobile/responsive_index_tablet.css" />
    <link
        rel="stylesheet"
        href="view/responsive_tablet/responsive_index_mobile.css" />
    <link rel="stylesheet" href="view/css/style_article_details.css" />
</head>

<body>
    <div class="wapper">
        <!--Header-->
        <header class="header">
            <div class="wapper header-wapper">
                <a href="user_login.php" class="logo">
                    <img src="view/img/logo bao 2.png" alt="BÁO ONLINE" />
                </a>
                <!--button đăng ký, đăng nhập-->
                <nav class="header-nav">
                    <ul class="header-nav_list">
                        <li class="header-nav_item">
                            <a href="user_login.php" class="logo_user">
                                <img
                                    src="view/img/logo_user_login/pngwing.com.png"
                                    alt="logo_user" />
                            </a>
                            <a
                                href="login.php"
                                title="Đăng Xuất"
                                class="header-nav_link button button-border">Đăng Xuất</a>
                        </li>
                    </ul>
                </nav>
                <!--end button đăng ký, đăng nhập-->
            </div>
        </header>
        <!--End Header-->

        <!-- From tìm kiếm -->
        <div class="wapper_container">
            <div class="from-sreach-layout">
                <form class="from-sreach">
                    <div class="form-sreach-input">
                        <!-- icon sreach -->
                        <div class="sreach-icon">
                            <svg
                                width="24"
                                height="25"
                                viewBox="0 0 24 25"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11 20.5126C15.9706 20.5126 20 16.4832 20 11.5126C20 6.54207 15.9706 2.51263 11 2.51263C6.02944 2.51263 2 6.54207 2 11.5126C2 16.4832 6.02944 20.5126 11 20.5126Z"
                                    stroke="#999999"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M18.9299 21.2024C19.4599 22.8024 20.6699 22.9624 21.5999 21.5624C22.4499 20.2824 21.8899 19.2324 20.3499 19.2324C19.2099 19.2224 18.5699 20.1124 18.9299 21.2024Z"
                                    stroke="#999999"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <!-- End icon sreach -->

                        <input
                            type="text"
                            placeholder="Nhập để tìm kiếm..."
                            id="sreach" />
                    </div>

                    <div class="from-sreach-option">
                        <div class="form-sreach-option-left">
                            <!-- icon sreach option 1-->
                            <svg
                                width="24"
                                height="25"
                                viewBox="0 0 24 25"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M14.5 11.0131C14.5 9.63187 13.3808 8.51263 12.0005 8.51263C10.6192 8.51263 9.5 9.63187 9.5 11.0131C9.5 12.3934 10.6192 13.5126 12.0005 13.5126C13.3808 13.5126 14.5 12.3934 14.5 11.0131Z"
                                    stroke="#999999"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M11.9995 21.5126C10.801 21.5126 4.5 16.411 4.5 11.0759C4.5 6.89927 7.8571 3.51263 11.9995 3.51263C16.1419 3.51263 19.5 6.89927 19.5 11.0759C19.5 16.411 13.198 21.5126 11.9995 21.5126Z"
                                    stroke="#999999"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <!--End icon sreach option 1-->
                            <span>Chọn địa điểm</span>
                            <!-- Dropdown menu -->
                            <select name="location" id="location" class="location-select">
                                <option value="tp_hcm">TP HCM</option>
                                <option value="ha_noi">Hà Nội</option>
                                <option value="binh_duong">Bình Dương</option>
                                <option value="phu_yen">Phú Yên</option>
                                <option value="binh_dinh">Bình Định</option>
                                <option value="nha_trang">Nha Trang</option>
                            </select>
                        </div>
                    </div>
                    <!-- button sreach-->
                    <button type="submit" class="button button-solid from-sreach-btn">
                        Tìm Kiếm
                    </button>
                    <!--End button sreach-->
                </form>
            </div>
        </div>
        <!-- End From tìm kiếm -->