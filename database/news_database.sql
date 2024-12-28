-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th12 28, 2024 lúc 03:36 PM
-- Phiên bản máy phục vụ: 8.3.0
-- Phiên bản PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `news_database`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Tin Tức', '', '0000-00-00 00:00:00'),
(2, 'Tin Tức 24h', '', '0000-00-00 00:00:00'),
(3, 'Cuộc Sống', 'Tổng hợp các bài báo về cuộc sống', '0000-00-00 00:00:00'),
(5, 'kinh tế', '', '0000-00-00 00:00:00'),
(6, 'Giáo Dục', '', '0000-00-00 00:00:00'),
(7, 'Thể Thao', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `news_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `news_id`, `name`, `comment`, `created_at`) VALUES
(27, 28, 'minh', 'hay', '2024-12-05 20:51:22'),
(10, 17, 'khánh', 'bài báo hay quá', '2024-12-03 23:07:59'),
(21, 0, 'Hoàng', 'bài báo quá hay', '2024-12-04 13:18:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `favorite_news`
--

DROP TABLE IF EXISTS `favorite_news`;
CREATE TABLE IF NOT EXISTS `favorite_news` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `news_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `favorite_news`
--

INSERT INTO `favorite_news` (`id`, `user_id`, `news_id`, `created_at`) VALUES
(4, 1, 0, '2024-12-28 12:01:38'),
(5, 1, 16, '2024-12-28 12:09:17'),
(6, 1, 31, '2024-12-28 12:09:39'),
(8, 6, 16, '2024-12-28 15:33:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `title`, `image`, `description`, `link`, `content`, `category_id`) VALUES
(16, 'Người Việt khắp nơi ghi lại những khoảnh khắc cực quang rực rỡ do bão mặt trời', 'uploads/nguoi viet ghi lai khoanh khac cuc quang ruc ro mat troi.webp', 'Nhiều người Việt Nam đang sống và làm việc ở nước ngoài bất ngờ được chiêm ngưỡng cực quang rực rỡ trên bầu trời, do tác động của cơn bão mặt trời mạnh nhất trong 20 năm trở lại đây.', 'link-to-article1', 'Mới đây, vết đen mặt trời khổng lồ AR3664 rộng gấp 15 trái đất bắn ra ngọn lửa mạnh nhất (loại X) về phía hành tinh của chúng ta, gây ra tình trạng mất sóng vô tuyến ở nhiều khu vực. Bên cạnh những tác động tiêu cực đáng quan ngại, cơn bão mặt trời này cũng tạo ra cảnh tượng cực quang ngoạn mục trên bầu trời ở nhiều quốc gia trên thế giới.\r\n\r\nNhiều người Việt đang sinh sống, làm việc ở Phần Lan, Iceland, Đức, New Zealand… bất ngờ chứng kiến cảnh tượng cực quang rực rỡ trên bầu trời tháng 5 và đã ghi lại những khoảnh khắc đẹp.Bức ảnh cực quang được chị Thủy Phạm sống ở thủ đô Helsinki (Phần Lan) chụp lại vào đêm 10.5, rạng sáng 11.5. Chị Thủy cho biết thời điểm đó, ánh sáng cực quang rất mạnh và chị dành nhiều giờ để ngắm và ghi lại khoảnh khắc đẹp trên bầu trời\"Bình thường, vào khoảng tháng 4 đã không còn cực quang. Tuy nhiên, tháng 5 cực quang xuất hiện và rực rỡ trên bầu trời, nhìn mắt thường vẫn thấy rất đẹp, nên mọi người quan tâm. Tôi dự định sẽ tiếp tục quan sát vào đêm tiếp theo\", chị Thủy Phạm chia sẻ thêm', 1),
(17, 'Lâm Đồng: Làm rõ việc tổ chức đua xe địa hình trái phép ở H.Bảo Lâm', 'uploads/dua xe trai phep.webp', 'Hàng chục tay đua mô tô địa hình tập trung đua xe tại xã Lộc Đức, bất chấp UBND H.Bảo Lâm đã thông báo hoãn cuộc đua.\r\n', 'link-to-article3', 'Ngày 11.5, Công an H.Bảo Lâm cùng các cơ quan chức năng đang làm rõ vụ tổ chức đua xe địa hình trái phép trên địa bàn xã Lộc Đức (H.Bảo Lâm), bất chấp UBND H.Bảo Lâm đã thông báo hoãn cuộc đua.\r\n\r\nGiải đua xe mô tô địa hình Lâm Đồng mở rộng \"Núi xanh Enduro 2024\" được thông báo để các vận động viên trong và ngoài nước đủ 18 tuổi, có giấy phép lái xe 2 bánh tham gia. Lệ phí 1,2 triệu đồng/ người.\r\n\r\nGiải đua có 5 hạng thi gồm hạng xe chuyên nghiệp, bán chuyên nghiệp, hạng xe phong trào, hạng xe Adventure và hạng xe phổ thông. Mỗi hạng thi có 3 vòng đua có cự ly tối đa 5,2 km.Theo đó, ngày 7.5, UBND H.Bảo Lâm ban hành giấy mời gửi các lãnh đạo, đơn vị và các địa phương tham dự Giải đua xe mô tô địa hình Lâm Đồng mở rộng \"Núi xanh Enduro 2024\". Tuy nhiên, đến ngày 10.5, cơ quan này có thông báo hoãn tổ chức giải đua nói trên. Được biết Giải đua xe mô tô địa hình Lâm Đồng mở rộng \"Núi xanh Enduro 2024\" chưa được cơ quan chức năng cấp giấy phép.\r\n\r\nThế nhưng bất chấp lệnh hoãn từ chính quyền, sáng 11.5, hàng chục tay đua vẫn tập trung ở xã Lộc Đức tổ chức và đua xe cùng nhau và đã hoàn tất 3 hạng thi trước sự cổ vũ của nhiều người nhưng không có sự giám sát của cơ quan có thẩm quyền.', 1),
(20, 'Phụ huynh nhận đơn in sẵn \'xin không tham gia kỳ thi tuyển sinh lớp 10\'', 'uploads/phu huynh nhan don san khong tham gia ky thi.webp', 'Ngày 11.5, trên các diễn đàn mạng xã hội lan truyền lá đơn có tựa đề \'Đơn xin không tham gia kỳ thi tuyển sinh lớp 10, năm học 2024-2025\' được cho là xuất phát từ một trường THCS tại TP.HCM.', '', 'Bên cạnh thông tin cá nhân của phụ huynh, học sinh, nội dung \"Đơn xin không tham gia kỳ thi tuyển sinh lớp 10, năm học 2024-2025\" có in sẵn các chi tiết sau:\r\n\r\n\"Căn cứ vào kết quả học tập năm học vừa qua và năng lực nhận thức của cháu không tốt, gia đình nhận thấy khả năng của cháu khó có thể theo học chương trình trung học phổ thông - hệ công lập.\r\n\r\nNay gia đình làm đơn này xin ban giám hiệu nhà trường cho phép cháu không tham gia kỳ thi tuyển sinh lớp 10…\r\n\r\nGia đình tôi sẽ không khiếu nại mọi vấn đề về sau\".\r\n\r\nTheo các thành viên trên diễn đàn phụ huynh, lá đơn được cho là xuất phát từ Trường THCS Nguyễn Văn Bứa (H.Hóc Môn, TP.HCM). Nhiều phụ huynh học sinh đã bình luận, bày tỏ sự bức xúc trước việc nhà trường in sẵn lá đơn để phụ huynh điền thông tin và xác nhận trách nhiệm.\r\n\r\nTrả lời với báo chí, ông Nguyễn Văn Hiệp, Trưởng phòng GD-ĐT H.Hóc Môn (TP.HCM), cho hay, qua xác minh ban đầu của đơn vị, lá đơn này xuất phát từ một lớp 9 của Trường THCS Nguyễn Văn Bứa. Giáo viên đã in lá đơn này ra, để học sinh điền vào. Hiện Phòng GD-ĐT H.Hóc Môn yêu cầu nhà trường làm báo cáo, đồng thời chỉ đạo nhà trường mời phụ huynh học sinh để trao đổi lại.\r\n\r\nÔng Hiệp gọi đây là sự việc xảy ra ngoài ý muốn, không phải chủ trương và Phòng GD-ĐT H.Hóc Môn hồi tuần trước đã tổ chức cuộc họp với các trường THCS, căn dặn rất kỹ về vấn đề này.\r\n\r\nSau khi nắm bắt thông tin về lá đơn in sẵn xin không thi tuyển sinh lớp 10, lãnh đạo Sở GD-ĐT TP.HCM chỉ đạo khẩn đến các trưởng phòng GD-ĐT TP.Thủ Đức và quận, huyện, nhấn mạnh rà soát lại việc phân luồng, tư vấn học sinh. \r\n\r\nTheo lãnh đạo Sở GD-ĐT TP.HCM, mục đích cuối cùng của việc phân luồng phải dựa trên nguyện vọng của học sinh. Vì vậy, Sở GD-ĐT TP.HCM đề nghị phòng GD-ĐT nhắc nhở các lãnh đạo trường THCS, giáo viên chủ nhiệm lớp 9 cần lưu ý.\r\n\r\nTrước đó, hồi tháng 12.2023, trong buổi sơ kết về công tác khảo thí năm học 2023-2024, định hướng xây dựng cho tuyển sinh lớp 10 năm 2024-2025, lãnh đạo Sở GD-ĐT TP.HCM đã đưa ra mục tiêu để đảm bảo quyền lợi tối đa cho học sinh học lớp 10 công lập.\r\n\r\nTheo đó, Sở GD-ĐT sẽ phối hợp với các phòng GD-ĐT rà soát lại toàn bộ quy trình tư vấn, hướng dẫn của một số trường THCS có tỷ lệ cao thí sinh trúng tuyển nhưng không nộp hồ sơ; thay đổi, bổ sung tiêu chí đánh giá thi đua về việc đánh giá kết quả tuyển sinh lớp 10. Kết quả phải dựa trên số lượng học sinh nộp hồ sơ vào trường trúng tuyển nhằm tránh tình trạng một số đơn vị chạy theo thành tích, hướng dẫn học sinh đăng ký vào các trường ở xa nhà.', 6),
(21, 'Giá vàng vượt 92 triệu đồng, \'14 năm trước vay vàng, giờ trả bằng tiền được không\'?', 'uploads/gia vang vuot 92tr.webp', 'Giá vàng liên tục lập đỉnh, đến nay đã vượt 92 triệu đồng mỗi lượng. Nhiều người tranh luận về tình huống \'10 năm trước vay bằng vàng, giờ trả bằng tiền có được không?\'.', '', 'Những ngày gần đây, giá vàng liên tục lập đỉnh, đến nay đã vượt 92 triệu đồng mỗi lượng. Trên một số diễn đàn trao đổi về pháp luật, nhiều chủ đề được mang ra tranh luận xung quanh giá vàng.\r\n\r\n\"Năm 2010, vợ chồng tôi có vay của anh chị 10 lượng vàng, giá vàng khi đó là 36 triệu đồng mỗi lượng. Khi vay, anh chị có quy ra 360 triệu đồng, yêu cầu trả lãi mỗi tháng 2 triệu đồng, gốc bao giờ có thì trả.\r\n\r\nVừa rồi, tôi có bán miếng đất để gom tiền trả nợ, nhưng anh chị đòi phải trả bằng 10 lượng vàng chứ không phải 360 triệu đồng.\r\n\r\nMong mọi người cho ý kiến để anh chị nhận bằng tiền (360 triệu đồng), chứ với giá vàng như hiện giờ thì tôi không thể trả bằng vàng được\", một thành viên đăng tải.\r\n\r\nGiá vàng vượt 92 triệu đồng, \'14 năm trước vay vàng, giờ trả bằng tiền được không\'?- Ảnh 1.\r\nGiá vàng liên tục lập đỉnh trong thời gian qua\r\n\r\nT.N\r\n\r\nCâu chuyện trên hiện đang nhận được rất nhiều ý kiến. Một số cho rằng vay vàng thì phải trả bằng vàng, số khác lại nghĩ chỉ cần trả bằng tiền (360 triệu đồng) vì khi người em vay thì anh chị đã quy đổi vàng ra tiền để tính lãi rồi.\r\n\r\nGiá vàng tăng chóng mặt: \'14 năm trước vay vàng, giờ trả bằng tiền được không\'?\r\n\r\nVậy, pháp luật quy định ra sao về trường hợp này?\r\n\r\nVay vàng thì phải trả bằng vàng\r\nLuật sư Hà Công Tâm, Đoàn luật sư TP.Hà Nội, viện dẫn điều 463 bộ luật Dân sự, quy định về hợp đồng vay tài sản. Theo đó, hợp đồng vay tài sản là sự thỏa thuận giữa các bên. Bên cho vay giao tài sản cho bên vay; khi đến hạn trả, bên vay phải hoàn trả cho bên cho vay tài sản cùng loại theo đúng số lượng, chất lượng và chỉ phải trả lãi nếu có thỏa thuận hoặc pháp luật có quy định.\r\n\r\nĐiều 466 bộ luật này cũng quy định rất rõ về nghĩa vụ trả nợ của bên vay. Đó là, bên vay tài sản là tiền thì phải trả đủ tiền khi đến hạn; nếu tài sản là vật thì phải trả vật cùng loại đúng số lượng, chất lượng, trừ trường hợp có thỏa thuận khác.\r\n\r\nTrường hợp bên vay không thể trả vật thì có thể trả bằng tiền theo trị giá của vật đã vay tại địa điểm và thời điểm trả nợ, nếu được bên cho vay đồng ý.\r\n\r\nĐối chiếu với quy định trên, 14 năm trước vợ chồng người em vay anh chị 10 lượng vàng thì nay phải trả lại đúng 10 lượng vàng.\r\n\r\nTrường hợp có nguyện vọng trả bằng tiền và được anh chị đồng ý, vợ chồng người em có thể trả nợ bằng tiền, nhưng là số tiền tương đương giá của 10 lượng vàng tại thời điểm trả nợ, chứ không phải số tiền 360 triệu đồng khi vay.\r\n\r\nNhưng khi cho vay, anh chị đã quy đổi vàng ra số tiền tương ứng và tính lãi hàng tháng, tình huống này có ngoại lệ?\r\n\r\nLuật sư Tâm nhận định, nếu 2 bên có thỏa thuận bằng văn bản về việc trả nợ bằng số tiền tương ứng với giá vàng tại thời điểm cho vay, thì bên vay chỉ cần trả 360 triệu đồng. Còn không, bên vay vẫn phải trả bằng vàng.\r\n\r\nVới số tiền lãi đã trả hàng tháng, đây là sự thỏa thuận giữa 2 bên, ngay từ khi xác lập việc cho vay. Theo quy định, trường hợp các bên có thỏa thuận về lãi suất thì lãi suất theo thỏa thuận không được vượt quá 20%/năm của khoản tiền vay.Cần rõ ràng ngay từ đầu, tránh \"đòi được nợ nhưng mất tình cảm\"\r\nThực tế, câu chuyện \"vay vàng thì trả bằng vàng hay bằng tiền\" không phải hiếm gặp, luôn gây nhiều tranh luận, nhất là khi giá vàng liên tục tăng như hiện nay.\r\n\r\nĐể tránh trường hợp khó xử, thậm chí \"đòi được nợ nhưng mất tình cảm\", luật sư Hà Công Tâm khuyến nghị cả người cho vay và người vay nên có sự rõ ràng với nhau ngay từ đầu.\r\n\r\nKhi vay vàng, các bên nên lập thành hợp đồng, ghi rõ nội dung thỏa thuận đã thống nhất như: số lượng, lãi suất (nếu có), thời hạn trả… Đặc biệt, các bên cần ghi rõ khi bên vay trả nợ thì trả bằng vàng hay bằng tiền. Điều này sẽ là cơ sở pháp lý để bảo đảm quyền và nghĩa vụ của mỗi bên, tránh xảy ra tranh chấp không đáng có.\r\n\r\nVí dụ, anh chị cho em vay bằng vàng, thỏa thuận rõ khi trả bằng vàng, thì khi trả phải trả bằng vàng, không phụ thuộc giá vàng lên hay xuống tại thời điểm trả.\r\n\r\nTrường hợp thỏa thuận trả bằng tiền nhưng quy đổi theo giá vàng ở thời điểm cho vay, người em phải trả bằng số tiền tương ứng với thời điểm đó. \"Lúc cho vay giá vàng là 36 triệu đồng mỗi lượng, đến nay giá vàng tăng lên 92 triệu đồng mỗi lượng, bên vay cũng chỉ cần trả số tiền tương ứng 36 triệu đồng mỗi lượng\", luật sư Tâm đặt tình huống giả định.', 5),
(25, 'Lý Hải tiết lộ lý do chưa giàu dù sê ri \'Lật mặt\' vượt mốc ngàn tỉ', 'uploads/ly hai tiet lo.webp', 'Phim \'Lật mặt 7: Một điều ước\' của Lý Hải đang gây sốt phòng vé, góp phần giúp sê ri \'Lật mặt\' vượt mốc doanh thu ngàn tỉ đồng. Nhưng đạo diễn này cho biết mình không giàu như mọi người nghĩ.', '', 'Theo ghi nhận trên trang Box Office Vietnam - đơn vị quan sát phòng vé độc lập, phim Lật mặt 7 của Lý Hải khi đã vượt mốc 330 tỉ đồng và được xem là phần phim thành công nhất về doanh thu trong sê ri Lật mặt. \r\n\r\nChia sẻ trong chương trình Lời tự sự vừa phát sóng, \"đạo diễn ngàn tỉ\" nhớ về những ngày dừng lại con đường ca hát để chọn điện ảnh: \"Lúc trước, tôi học chuyên về diễn xuất rồi làm ca sĩ, rồi quay lại đúng với chuyên môn đã học. Tôi phải chuẩn bị rất dài. Đi hát tôi cũng âm thầm, ấp ủ như làm phim ca nhạc Trọn đời bên em, vừa ca nhưng cũng có nội dung như phim ngắn. Sau 2010, tôi nhờ bà xã gom những tư liệu về điện ảnh bằng tiếng nước ngoài, lọc ra, dịch rồi tìm hiểu, học cách sản xuất phim điện ảnh, học biên kịch, đặc biệt là học về đạo diễn, nói chung là tất tần tật trong vòng 3 năm. Và năm 2014 tôi mới viết kịch bản và làm cuốn Lật mặt đầu tiên. Trong giai đoạn đầu đó xác định mình ngưng hát để chuyển sang lĩnh vực mới thì rất hồi hộp vì không biết có phù hợp với mình không, có làm được không, đắn đo suy nghĩ rất nhiều. Nhưng nếu không tạo cơ hội thì không biết lúc nào. Hơn nữa, sau lưng mình luôn có bà xã đôn đốc. May mắn là Lật mặt đầu tiên được khán giả ủng hộ, yêu mến\".Nói thêm với MC chương trình, Lý Hải cho rằng anh đến với điện ảnh trong vai trò đạo diễn, diễn viên, nhà sản xuất vốn là đam mê, ước mơ cháy bỏng của bản thân và đến tận lúc này điều đó luôn nguyên vẹn: \"Lúc chưa có cơ hội để làm điện ảnh, mới quen bà xã Minh Hà, hai đứa mua vé ra rạp xem phim và ước ao, ngồi nghĩ một ngày nào đó mình ngồi đây xem phim của mình chiếu trên màn ảnh thì điều đó tuyệt vời lắm. Nên giờ tôi làm hoài mà không thấy mệt mỏi. Tôi được cái là ý chí rất cao, đã xác định được mục tiêu, mục đích là tập trung khủng khiếp lắm. Giai đoạn sau này khi tôi bắt tay viết kịch bản thì trong vòng 1 tháng phải ra được cái sườn là tự động làm việc, viết ngày viết đêm và làm việc rất hăng say. Ra hiện trường thì tôi làm việc rất căng, tỉ mỉ và tương đối khó tính\".\r\n\r\nTrong chương trình Lời tự sự, Lý Hải cũng cho biết thêm về hành trình của sê ri Lật mặt: \"Hồi xưa tôi làm không dám nghĩ là có phần tiếp theo. Thật ra, Lật mặt chỉ là chuỗi thương hiệu riêng thôi còn tất cả các phần ở Lật mặt đều có nội dung khác, khác thể loại luôn. Giống như hồi xưa tôi tạo thương hiệu Trọn đời bên em. Nên mọi người không xem các phần trước thì vẫn có thể xem phần sau bình thường, diễn viên cũng khác nhau\".Đang trở thành tâm điểm với doanh thu \"khủng\" từ Lật mặt 7 và sê ri Lật mặt vượt mốc 1.000 tỉ đồng nên khi được MC chương trình hỏi về chuyện trở thành đại gia nhờ doanh thu phim, Lý Hải chia sẻ: \"Chưa bao giờ Lý Hải nghĩ mình giàu gì hết. Xuất phát điểm của mình lúc đầu tư làm phim chỉ mong đủ tiền để làm thôi. Nhưng cũng may mắn là khi làm phim xong được mọi người ủng hộ, thu hồi vốn nhanh, có lãi để tái đầu tư. Đó cũng là lý do những phần sau được đầu tư nhiều hơn những phần trước\". \r\n\r\n\"Tôi nghĩ một bộ phim muốn đạt được doanh thu cao thì phải đảm bảo hai yếu tố quan trọng nhất: kịch bản tốt và thời điểm đúng. Tôi gọi đó là \"điểm rơi\". Nếu rơi vào thời điểm cái bánh chia năm xẻ bảy thì thu hồi vốn rất khó. Yếu tố nữa là quảng bá. Giờ kênh giải trí rất nhiều, mọi người có nhiều sự lựa chọn. Nếu mình không phải lựa chọn hàng đầu thì người ta sẽ lướt qua. Nếu chỉ có 40 tỉ để thực hiện phim thì phải trích ra 10 tỉ để PR còn sản xuất cỡ 30 tỉ thôi. Chúng ta không tính trước, sẽ không còn tiền để quảng bá cho phim thì rất nguy hiểm. Có những bộ phim đang rơi vào tình trạng như thế mà môi trường này cạnh tranh rất khốc liệt\", đạo diễn 56 tuổi nói thêm.', 2),
(26, 'HLV Lê Huỳnh Đức nắm trong tay tương lai hàng tiền đạo đội tuyển Việt Nam', 'uploads/hlv le huynh duc nam trong tay tuong lai.webp', 'Thật trùng hợp khi 3 trong số những tiền đạo tốt nhất hoặc triển vọng nhất bóng đá Việt Nam đang khoác áo CLB Bình Dương, đội bóng vốn được dẫn dắt bởi cựu tiền đạo số một của bóng đá nội là ông Lê Huỳnh Đức.', '', 'Không tính tiền đạo Công Phượng giờ hầu như không còn được thi đấu trong màu áo CLB Yokohama FC (Nhật Bản), trong số các chân sút của bóng đá nội có thể khoác áo đội tuyển quốc gia, gồm Tiến Linh, Tuấn Hải, Văn Toàn, Nhâm Mạnh Dũng, Vĩ Hào, Văn Tùng, Võ Nguyên Hoàng, Việt Cường, đội Bình Dương của HLV Lê Huỳnh Đức sở hữu đến 3 người (Tiến Linh, Việt Cường, Vĩ Hào). Trong số này, Nguyễn Tiến Linh là chân sút số một của bóng đá Việt Nam hiện nay, trong khi Bùi Vĩ Hào là cầu thủ thuộc vào hàng triển vọng hàng đầu của bóng đá nội.So với 2 cầu thủ vừa nêu, Nguyễn Trần Việt Cường không nổi tiếng bằng, nhưng Việt Cường cũng đã có thời gian khoác áo đội tuyển U.23 Việt Nam trước đây. Anh vẫn còn khá trẻ (sinh năm 2000), tương lai vẫn rộng mở.\r\n\r\nKhông phải ngẫu nhiên mà HLV Lê Huỳnh Đức vẫn thường luân phiên sử dụng Tiến Linh và Việt Cường ở từng trận đấu của Bình Dương từ cuối mùa giải vừa rồi cho đến mùa giải hiện nay. Tức là Việt Cường đã đủ sức hoạt động độc lập, không còn chịu cái bóng quá lớn của đàn anh Tiến Linh. Riêng Bùi Vĩ Hào sẽ là phương án dự phòng cho 2 tiền đạo nói trên. Hiện tại, Tiến Linh đã ghi được 5 bàn thắng tại V-League 2023-2024, là cầu thủ nội ghi bàn nhiều thứ nhì giải đấu, sau Nguyễn Quang Hải của CLB Công an Hà Nội (7 bàn). Việt Cường có 1 bàn thắng và Bùi Vĩ Hào có 2 bàn thắng tại V-League mùa này.\r\n\r\nMới nhất, Bùi Vĩ Hào có pha ghi bàn rất đẹp vào lưới đội Nam Định ở vòng 17 V-League, sau cú sút hiểm hóc từ ngoài khu vực cấm địa, đánh bại cựu thủ môn đội tuyển quốc gia là Trần Nguyên Mạnh.Điểm chung của 3 tiền đạo Tiến Linh, Việt Cường và Vĩ Hào là họ đều cao từ 1,80 m trở lên, chơi bóng bổng khá, tốc độ cao, tích cực di chuyển rộng và tích cực dứt điểm khi có cơ hội. Đây đều là những nét phảng phất hình ảnh của chính tiền đạo Lê Huỳnh Đức ngày nào: mẫu trung phong có tốc độ, có thể hình, di chuyển không bóng tốt, kỹ thuật khá…\r\n\r\nCũng không loại trừ khả năng họ chịu ảnh hưởng của HLV Lê Huỳnh Đức, trong những ngày ông Đức nắm đội Bình Dương. Ít nhiều, vị HLV nổi tiếng này đã truyền đạt kinh nghiệm cho các học trò chơi ở vị trí tiền đạo, nhất là về kinh nghiệm di chuyển và kinh nghiệm chọn vị trí trước khung thành đối phương.\r\n\r\nCòn nhớ, khi còn dẫn dắt đội SHB Đà Nẵng trước đây, ngoài việc sử dụng rất tốt các chân sút ngoại gồm Almeida và Gaston Merlo (sau này có tên tiếng Việt là Đỗ Merlo), HLV Lê Huỳnh Đức còn giúp bồi dưỡng cho tiền đạo nội Hà Minh Tuấn, giúp Hà Minh Tuấn về sau có suất khoác áo đội tuyển quốc gia.\r\n\r\nĐiều đó có nghĩa khả năng phát hiện, bồi dưỡng cho các tiền đạo là khả năng mà HLV Lê Huỳnh Đức rất giỏi. Khả năng này của ông Đức tiếp tục giúp ích cho đội tuyển Việt Nam và đội tuyển U.23 Việt Nam hiện tại. Chí ít, việc HLV Lê Huỳnh Đức rèn luyện cho Tiến Linh, Việt Cường và Bùi Vĩ Hào trở nên nguy hiểm hơn trước khung thành đối phương, phần nào giúp cho các đội tuyển Việt Nam vơi đi nỗi lo khủng hoảng chân sút.Bình Dương còn có tiền vệ Minh Khoa và thủ môn Minh Toàn rất hay\r\nNgoài các tiền đạo, đội Bình Dương của HLV Lê Huỳnh Đức còn đang sở hữu tiền vệ trung tâm Võ Hoàng Minh Khoa và thủ môn Trần Minh Toàn rất hay. Trong số này, Minh Khoa là tiền vệ đá tốt nhất của đội U.23 Việt Nam tại giải U.23 châu Á 2024, còn thủ môn Minh Toàn có nhiều pha cứu thua ngoạn mục tại V-League các mùa giải 2023 và 2023-2024.Điều đáng nói ở chỗ trước khi HLV Lê Huỳnh Đức dẫn dắt đội Bình Dương, các cầu thủ này không chơi hay đến vậy. Riêng HLV Lê Huỳnh Đức mới đây khẳng định thủ môn Trần Minh Toàn (cao 1,86 m) xứng đáng được trao cơ hội ở đội tuyển Việt Nam.', 7),
(27, 'Cụ bà U70 mất 15 tỷ đồng sau khi nghe cuộc gọi mạo danh công an', 'uploads/gia danh cong an lua 15 ty dong.webp', 'Thủ đoạn giả danh cơ quan công an gọi điện để lừa đảo chiếm đoạt tài sản không phải thủ đoạn mới nhưng nhiều người vẫn mất cảnh giác, sập bẫy của các đối tượng.', '', 'Mới đây, Công an quận Hà Đông, Tp.Hà Nội đang điều tra, xác minh vụ giả danh cán bộ Công an, lừa đảo chiếm đoạt tài sản 15 tỷ đồng.\r\n\r\nTheo Công an nhân dân, vào ngày 5/4, bà P (SN 1956, HKTT Hà Đông, Hà Nội) nhận được điện thoại của một đối tượng tự xưng là cán bộ Công an. Đối tượng nói căn cước công dân của bà P có liên quan đến đường dây buôn bán ma túy, rửa tiền. Nếu bà P. không chứng minh được mình không liên quan thì vài ngày nữa sẽ bắt bà.\r\n\r\nLo sợ, bà P đã nhiều lần chuyển tiền vào tài khoản của các đối tượng để xác minh. Tổng cộng, bà P đã thực hiện 32 lần chuyển khoản với tổng số tiền là 15 tỷ đồng. Sau đó, biết bị lừa, bà P đã đến cơ quan Công an trình báo sự việc.\r\n\r\nCông an Tp.Hà Nội đề nghị, người dân cần cảnh giác, tuyên truyền đến người thân, bạn bè về thủ đoạn trên, tránh mắc bẫy của đối tượng xấu.\r\n\r\nThông tin trên Dân Việt, để làm việc với người dân, cơ quan Công an sẽ trực tiếp gửi giấy mời, giấy triệu tập hoặc gửi qua Công an địa phương; tuyệt đối không yêu cầu người dân chuyển tiền vào tài khoản ngân hàng. Khi phát hiện các trường hợp có dấu hiệu lừa đảo như trên, người dân cần báo ngay cho cơ quan Công an nơi gần nhất.', 2),
(28, 'Một hành tinh khác ẩn trong lòng Trái Đất làm lục địa dịch chuyển', 'uploads/mot hanh tinh khac an trong long dat.webp', 'Các nhà khoa học Mỹ đã tìm ra bằng chứng cho thấy tàn tích một hành tinh khác bên trong Trái Đất đã thúc đẩy quá trình kiến tạo mảng.', '', 'Theo một nghiên cứu vừa công bố trên Geophysical Research Letters, hành tinh ẩn mình bên trong Trái Đất chính là Theia, với một phần chưa tan vỡ hết tạo thành những \"đốm màu\" mà các dữ liệu địa vật lý đã xác định ở khu vực đáy lớp phủ, ngay bên trên lõi ngoài.Theia là một hành tinh giả thuyết to bằng Sao Hỏa, đã va chạm với Trái Đất sơ khai khoảng 4,5 tỉ năm trước.Cú va chạm khiến cả 2 hành tinh non trẻ tan vỡ, phần lớn vật chất Theia trộn lẫn vào Trái Đất, trong khi một phần nhỏ văng lên quỹ đạo, hợp nhất với các mảnh vỡ từ Trái Đất, dần kết tụ thành Mặt Trăng.', 1),
(29, 'Sao Man City giải thích lý do từ chối lập hat-trick để đi vào lịch sử Premier League', 'uploads/sao mancity giai thich ly do tu choi lap hattrick.jpg', '(PLO)- Trung vệ Josko Gvardiol giải thích lý do anh từ chối thực hiện quả phạt đền để hoàn tất hat-trick trong trận Man City đánh bại Fulham 4-0 ở vòng 37 Premier League.', '', 'Josko Gvardiol từ chối cơ hội lập hat-trick sau khi để Julian Alvarez thực hiện quả phạt đền ở phút bù giờ ghi bàn ấn định tỉ số 4-0 cho Man City trước Fulham ở vòng 37 Premier League. Cầu thủ người Croatia không thể trở thành hậu vệ đầu tiên ở Premier League lập hat-trick.\r\nJosko Gvardiol đã tiết lộ lý do anh từ chối cơ hội trở thành hậu vệ đầu tiên lập hat-trick ở Premier League, bỏ lỡ cơ hội làm nên lịch sử tại Premier League. Với 3 điểm có được, Man City chính thức vươn lên ngôi đầu bảng xếp hạng Premier League với 85 điểm, hơn Arsenal 2 điểm.Josko Gvardiol nói: “Thêm hai bàn thắng nữa cho tôi và tất nhiên là một trận giữ sạch lưới nữa, rất vui. Chúng tôi đã thảo luận về việc tôi sẽ thực hiện quả phạt đền, và tất nhiên là tôi rất muốn, nhưng chúng tôi có một người thực hiện chính và anh ấy sẽ thực hiện chúng. Cuối cùng, Julian Alvarez bước lên và anh ấy đã ghi bàn thắng”.\r\n\r\nChỉ 13 phút sau khi trận đấu bắt đầu, Gvardiol đã ghi bàn mở tỉ số cho Man City. Trong pha tấn công với 19 đường chuyền, Kevin De Bruyne đã kiến tạo cho Gvardiol thực hiện pha đi bóng và dứt điểm trong vòng cấm y như một tiền đạo chính hiệu. Đây là bàn thắng thứ 4 của trung vệ 22 tuổi người Croatia Gvardiol cho Man City trong 7 trận gần nhất và anh không phải đợi lâu để có bàn thứ 5.\r\n\r\n20 phút trước khi trận đấu kết thúc, Gvardiol lẻn xuống phía sau hàng thủ Fulham nhận đường chuyền vào như đặt của Bernardo Silva để đệm bóng vào lưới ghi bàn nâng tỉ số lên 3-0 cho Man City. Trước đó, Phil Foden là người lập công nâng tỉ số lên 2-0.Trong lịch sử Premier League, hậu vệ duy nhất lập hat-trick trong 1 trận đấu tại Premier League là Steve Watson của Everton. Tuy nhiên, Watson lại không chơi ở hàng thủ Everton trong trận gặp Leeds United năm 2003 mà anh lập hat-trick.\r\n\r\nBất chấp Josko Gvardiol không thể làm nên lịch sử, Man City đang tiến gần đến thành tích vô tiền khoáng hậu trở thành đội bóng Anh đầu tiên vô địch Premier League 4 mùa liên tiếp. Chỉ cần thắng Tottenham và West Ham trong 2 trận còn lại, đoàn quân của Pep Guardiola sẽ vô địch Premier League, bất chấp kết quả của Arsenal ra sao.Thậm chí, Man City của Pep Guardiola có thể vô địch trước vòng cuối cùng, nếu Arsenal không thắng Manchester United vào đêm nay 12-5, còn Man City thắng Tottenham trong trận đấu bù vào giữa tuần sau.', 7),
(30, 'Chuyên gia Mỹ: NATO có nguy cơ bị lôi kéo tham gia \'Thế chiến 3 ở Ukraine\', kích thích Nga làm điều \'không thể tưởng tượng\'', 'uploads/chuyen gia my nato co nguy co bi loi keo tham gia ct.webp', 'Cựu trợ lý đặc biệt phụ trách chính sách và truyền thông của Lầu Năm Góc nhận định rằng, tổ chức Hiệp ước Bắc Đại Tây Dương có nguy cơ tham gia Chiến tranh thế giới thứ 3 ở Ukraine.', '', 'Ngày 12/5, Cựu trợ lý đặc biệt phụ trách chính sách và truyền thông của Lầu Năm Góc Douglas McKinnon đưa ra nhận định trong bài viết đăng trên tờ The Hill rằng, tổ chức Hiệp ước Bắc Đại Tây Dương (NATO) có nguy cơ tham gia Chiến tranh thế giới thứ 3 ở Ukraine, trong khi giới tinh hoa chính trị các nước phương Tây hoàn toàn không hiểu được hậu quả của chiều hướng leo thang xung đột hạt nhân toàn cầu.\r\n\r\nÔng Douglas McKinnon viết: “NATO đang mạo hiểm gây ra Chiến tranh thế giới thứ 3 ở Ukraine, đồng thời đổ tiền vào ngành công nghiệp quốc phòng… ngày qua ngày, cuộc chiến ở Ukraine đang tiến gần hơn đến cú đòn hạt nhân”. Ông MacKinnon đề cập đến tuyên bố của ứng cử viên tổng thống độc lập Mỹ Robert Kennedy, người gần đây đã tuyên bố nhận định tình hình ở Ukraine “đang ở bên bờ vực leo thang thảm khốc”.\r\n\r\nTác giả đặt câu hỏi: “Liệu đế quốc quân sự ở Washington và tay sai ở châu Âu có hiểu được mối nguy hiểm mà họ đang phải đối mặt?”, so sánh chính sách đối ngoại của Mỹ với kiểu “hai con dê qua cầu”. Theo tác giả, ông Kennedy “rất đúng”, vì mọi thứ đều chỉ rõ Mỹ, Anh và Pháp có ý định thúc đẩy Nga “làm điều không thể tưởng tượng được”.', 1),
(31, 'Tiếp thêm sức mạnh để hoàn thành mục tiêu phát triển đất nước giàu đẹp, văn minh', 'uploads/tiep them suc mạnh de hoan thanh muc tieu phat trien dat nuoc giau dep.jpg', 'Theo ý kiến của nhiều nhà khoa học, đảng viên, bài viết của Tổng Bí thư nhân kỷ niệm 94 năm Ngày thành lập Đảng Cộng sản Việt Nam đã tiếp thêm sức mạnh cho toàn Đảng, toàn dân nỗ lực phấn đấu để hoàn thành mục tiêu vì dân giàu, nước mạnh, dân chủ, công bằng, văn minh.', '', 'Suốt 94 năm qua, trong sự nghiệp đấu tranh giải phóng dân tộc cũng như trong công cuộc xây dựng và bảo vệ Tổ quốc ngày nay, Đảng Cộng sản Việt Nam luôn ý thức được vị trí, vai trò, trọng trách của mình trước vận mệnh dân tộc, tương lai của đất nước. Nhân kỷ niệm 94 năm Ngày thành lập Đảng Cộng sản Việt Nam (3/2/1930-3/2/2024), Tổng Bí thư Nguyễn Phú Trọng đã có bài viết \"Tự hào và tin tưởng dưới lá cờ vẻ vang của Đảng, quyết tâm xây dựng một nước Việt Nam ngày càng giàu mạnh, văn minh, văn hiến và anh hùng\". Theo ý kiến của nhiều nhà khoa học, đảng viên, bài viết của Tổng Bí thư đã tiếp thêm sức mạnh cho toàn Đảng, toàn dân nỗ lực phấn đấu để hoàn thành mục tiêu vì dân giàu, nước mạnh, dân chủ, công bằng, văn minh.\r\n\r\nĐánh giá cao bài viết của Tổng Bí thư, Phó Giáo sư, Tiến sỹ Hà Quý Quỳnh, Trưởng Ban Tổ chức Cán bộ và Kiểm tra, Viện Hàn lâm Khoa học và Công nghệ Việt Nam cho rằng, bài viết thể hiện toàn bộ thành tựu vượt bậc do Đảng lãnh đạo đất nước đạt được. Với văn phong ngắn gọn, đơn giản, dễ hiểu, bài viết đảm bảo chuyển tải đầy đủ nội dung mà đồng chí Tổng Bí thư muốn gửi gắm. Ngay từ phần mở đầu, bài viết đã thể hiện được Đảng ta đã cùng trải qua nhiều giai đoạn phát triển của thế giới và nhân loại. Từ đó, Đảng đã xác định đúng mục tiêu của từng giai đoạn và lãnh đạo đất nước phát triển phù hợp với từng thời kỳ phát triển của thế giới.\r\n\r\nPhó Giáo sư, Tiến sỹ Hà Quý Quỳnh cho rằng, bài viết đã xác định những khó khăn, thách thức mà Đảng ta phải đối mặt; những thời cơ phải nắm bắt; nhiệm vụ trọng tâm, chính, cốt yếu; nhiệm vụ thường xuyên liên tục và yêu cầu cần phải quyết tâm, thực hiện tốt hơn nữa từ Trung ương tới từng tổ chức Đảng, Đảng viên và toàn dân để tiến tới Đại hội Đảng toàn quốc lần thứ XIV, đưa nước ta ngày càng phát triển.\r\n\r\nĐể hoàn thành mục tiêu vì dân giàu, nước mạnh, dân chủ, công bằng, văn minh, Phó Giáo sư, Tiến sỹ Hà Quý Quỳnh cho rằng, mỗi cán bộ, đảng viên cần tiếp tục quán triệt sâu sắc, tổ chức thực hiện nghiêm túc các chủ trương, đường lối của Đảng và pháp luật, chính sách của Nhà nước về phát triển nhanh, bền vững; vận dụng vào thực tiễn hoạt động ở địa phương, cơ quan, đơn vị. Cùng với đó, mỗi đảng viên tích cực chủ động nắm bắt thời cơ, vận hội để thúc đẩy sự phát triển kinh tế, quan tâm hơn nữa đến nhiệm vụ phát triển văn hóa, xã hội, hài hòa và ngang tầm với phát triển kinh tế; bảo đảm an sinh và phúc lợi xã hội; không ngừng nâng cao đời sống vật chất, tinh thần của nhân dân.\r\n\r\nĐể triển khai có hiệu quả những nội dung đồng chí Tổng Bí thư nêu trong bài viết: \"Triển khai thực hiện thắng lợi các chương trình, kế hoạch, mục tiêu, nhiệm vụ đã đề ra cho nhiệm kỳ khóa XIII và đến năm 2030. Đặc biệt là, cần phải tiếp tục quán triệt, vận dụng sáng tạo những bài học kinh nghiệm Đại hội XIII của Đảng đã đúc kết được \" và \"Đảng cần tiếp tục quán triệt, vận dụng thật tốt một số bài học kinh nghiệm về việc đổi mới phương thức lãnh đạo và phong cách, lề lối làm việc được rút ra tại Hội nghị Trung ương giữa nhiệm kỳ khóa XIII. Trong đó, tập trung ưu tiên triển khai thực hiện thật tốt 5 nhóm nhiệm vụ trọng tâm: Phát triển kinh tế; văn hóa, xã hội…\", thiết nghĩ mỗi đồng chí đảng viên luôn phải thấm nhuần tư tưởng của Đảng; chấp hành nghiêm kỷ cương, liêm chính; sáng tạo, đổi mới trong lĩnh vực của mình; dám nghĩ, dám làm, dám chịu trách nhiệm; vì lợi ích của tập thể của nhân dân và của đất nước; với vị trò vị trí của mình luôn thể hiện tính tiền phong, gương mẫu của người đảng viên lan tỏa tinh thần này đến thành viên trong gia đình, người thân, bạn bè và đồng nghiệp từ đó tạo một sự đồng thuận trong toàn xã hội.\r\n\r\nLà đảng viên hiện đang công tác tại Văn phòng Đảng ủy Bộ Tài nguyên và Môi trường, Tiến sỹ Trần Quang Đẩu nhận thức sâu sắc về vai trò trách nhiệm của một đảng viên với Đảng, với Tổ quốc, nhân dân. Bản thân Tiến sỹ Trần Quang Đẩu thường xuyên rèn luyện, học tập để nâng cao trình độ chính trị và chuyên môn nghiệp vụ, tham gia tích cực mọi phong trào ở cơ quan, đơn vị.\r\n\r\nTheo Tiến sỹ Trần Quang Đẩu, bài viết của Tổng Bí thư gồm 3 phần chính đã khái quát quá trình Đảng ta ra đời, lãnh đạo đấu tranh giành độc lập dân tộc, giải phóng miền Nam, thống nhất đất nước; Đảng lãnh đạo khắc phục hậu quả chiến tranh, tiến hành công cuộc đổi mới và hội nhập quốc tế. Chặng đường 94 năm qua, Đảng ta luôn là niềm tự hào của dân tộc Việt Nam, được nhân dân tin cậy, xác định Đảng Cộng sản Việt Nam là đội tiên phong chính trị, người lãnh đạo chân chính duy nhất của cả dân tộc. Đảng Cộng sản Việt Nam không chỉ là nhân tố quyết định mọi thắng lợi của cách mạng nước ta mà còn trở thành niềm tin sắt son, niềm tự hào của dân tộc.\r\n\r\nNghiên cứu bài viết, Tiến sỹ Trần Quang Đẩu tâm đắc với phần 3: \"Tiến hành công cuộc đổi mới và hội nhập quốc tế của Đảng và Nhà nước ta\"; cho rằng, nội dung này đã được Tổng Bí thư Nguyễn Phú Trọng đúc kết sâu sắc. Phần này không những nêu một số chủ trương, định hướng lớn, vấn đề bao quát, tổng thể, toàn diện, hội nhập mà còn nêu những nội dung rất cụ thể, chi tiết, yêu cầu về kỷ cương, đạo đức, trí tuệ của mỗi tổ chức, cá nhân Đảng viên và từng người dân.\r\n\r\nĐợt kỷ niệm thành lập Đảng năm nay trùng với dịp mừng Xuân Giáp Thìn năm 2024, với khí thế mới, quyết tâm thực hiện thắng lợi Nghị quyết Đại hội XIII của Đảng, Tiến sỹ Trần Quang Đẩu mong muốn bài viết của Tổng Bí thư sẽ lan tỏa và in dấu sâu đậm trong tâm trí mỗi cán bộ đảng viên, cá nhân, tổ chức về trang sử hào hùng của Đảng quang vinh, lịch sử vẻ vang của dân tộc, quê hương, đất nước anh hùng; góp phần thực hiện thành công con đường xã hội chủ nghĩa mà Đảng, Bác Hồ và nhân dân ta đã lựa chọn.', 1),
(32, 'Đưa siêu tàu 1.000 khách từ TP.HCM đi Côn Đảo vào khai thác từ 13/5', 'uploads/ngay_mai_khai_truong_tau_sai_gon_-_con_dao_anh_cdt.jpg', 'VOV.VN -  Ngày mai (13/5), tuyến vận chuyển hành khách cố định từ Thành phố Hồ Chí Minh-Côn Đảo (Bà Rịa-Vũng Tàu) và ngược lại trên siêu tàu Thăng Long, có mức vé từ 615.000 đồng-1,1 triệu đồng/lượt sẽ đi vào hoạt động.', '', 'Tàu từ TP.HCM đi Côn Đảo xuất phát từ cảng Sài Gòn- Hiệp Phước (Nhà Bè) 3 chuyến/tuần, xuất phát lúc 7h. Để hỗ trợ hành khách, sẽ có xe trung chuyển từ công viên 23/9 (Quận 1) khởi hành vào 5h - 5h20. Trong khi đó, tàu đi chiều Côn Đảo – TP.HCM là 13h từ cảng Bến Đầm.\r\n\r\nTàu sử dụng trên tuyến là “Siêu tàu Thăng Long”, lớn nhất, nhanh nhất hiện nay với các tiêu chuẩn quốc tế, có sức chứa lên đến 1017 hành khách. Với vận tốc lên tới 35 hải lý/ giờ, trong điều kiện thời tiết thuận thì hành trình từ TP.HCM đi Côn Đảo chỉ mất hơn 4 giờ.\r\n\r\nGiá vé tàu từ 615.000 đồng -1,1 triệu đồng tùy theo đối tượng, hạng vé và thời điểm xuất phát.\r\n\r\nTrước kia, người dân và du khách muốn ra Côn Đảo thường phải đi bằng máy bay, chủ yếu là máy bay nhỏ với giá vé rất đắt đỏ.\r\n\r\nDo đó, việc đưa vào tuyến tàu khách cố định với sức chở lớn, thời gian di chuyển ngắn được kỳ vọng sẽ thúc đẩy nhu cầu đi lại và du lịch của người dân.', 2),
(33, 'tin 20', 'uploads/gia vang vuot 92tr.webp', 'jkjkj', '', 'jkjkjk', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `news_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `user_id` (`user_id`)
) ;

--
-- Đang đổ dữ liệu cho bảng `ratings`
--

INSERT INTO `ratings` (`id`, `news_id`, `user_id`, `rating`, `created_at`) VALUES
(1, 16, 1, 1, '2024-12-28 14:07:59'),
(2, 25, 1, 2, '2024-12-28 14:24:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('admin','user') DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'minh', 'minhnguyen1ak@gmail.com', '$2y$10$FeNQuTd3e3plDigY9kO6d.UtvHJxtlZJzIZMzh5ZvVYdR9y8hOGcy', '2024-12-03 23:08:46', 'user'),
(2, 'hoang', 'hoang@gmail.com', '$2y$10$eUQJ5tzJUFL6LnoCsS.kjuICxAfMpYcB5VFqpxv2qg9FJmjwcxpqW', '2024-12-03 23:46:45', 'user'),
(3, 'kinh tế', 'hau69710@gmail.com', '$2y$10$LaRp1PhfQ15p8e8Dc0mJ/.FQdKBf7Bz71/NMQJEPvhlWaBUwy/o2y', '2024-12-05 17:48:43', 'user'),
(4, 'minh', 'minhnguyen11ak@gmail.com', '$2y$10$XdxoiwBh/OZdFNRKfsixkulNKg3ImsiosbGVAYFce4kKQX6qzPIoe', '2024-12-27 22:48:20', 'user'),
(5, 'máy tính', 'minhnguyene1ak@gmail.com', '$2y$10$RTaUwI/TBmnMVdxnlPdvEezcsRKOw38ATn4TQqfhwDRdnv.DZJPqS', '2024-12-28 14:08:51', 'user'),
(6, 'admin', 'admin@gmail.com', '$2y$10$y9tuBG9mifbpGlGFLeTuOu5YEYHuLdNfoTEtqJIdpQz78JCiuun9a', '2024-12-28 15:31:28', 'admin');

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
