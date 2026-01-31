-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 31, 2026 lúc 07:43 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `bookstore`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `author`
--

INSERT INTO `author` (`id`, `name`, `bio`, `avatar`, `status`, `created_at`) VALUES
(1, 'Saekisan', '', '', 'active', '2026-01-31 02:14:02'),
(2, 'Yuji Yuji', '', '', 'active', '2026-01-31 02:16:09'),
(3, 'Na Đa', '', '', 'active', '2026-01-31 02:17:29'),
(4, 'Masahiro Imamura', '', '', 'active', '2026-01-31 02:18:12'),
(5, 'Rachel Caine', '', '', 'active', '2026-01-31 02:19:13'),
(6, 'Quốc Thái', '', '', 'active', '2026-01-31 02:20:10'),
(7, 'Vương Vũ Thần', '', '', 'active', '2026-01-31 02:21:02'),
(8, 'Yoshito Usui', '', '', 'active', '2026-01-31 02:21:51'),
(9, 'Akira Toriyama', '', '', 'active', '2026-01-31 02:23:13'),
(10, 'Minh Niệm', '', '', 'active', '2026-01-31 02:23:58'),
(11, 'Diana Wynne Jones', '', '', 'active', '2026-01-31 02:24:27'),
(12, 'Gege Akutami', '', '', 'active', '2026-01-31 02:25:25'),
(13, 'Kohei Horikoshi', '', '', 'active', '2026-01-31 02:25:46'),
(14, 'José Mauro de Vasconcelos', '', '', 'active', '2026-01-31 02:26:15'),
(15, 'Koyoharu Gotouge', '', '', 'active', '2026-01-31 02:26:37'),
(16, 'Eiichiro Oda', '', '', 'active', '2026-01-31 02:27:01'),
(17, 'Tớ Là Mây', '', '', 'active', '2026-01-31 02:27:23'),
(18, 'Muneyuki Kaneshiro', '', '', 'active', '2026-01-31 02:27:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` enum('active','inactive','out_of_stock','') NOT NULL,
  `content` text NOT NULL,
  `size` varchar(50) NOT NULL,
  `bookcover` varchar(50) NOT NULL,
  `number_pages` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `book`
--

INSERT INTO `book` (`id`, `category_id`, `name`, `author_id`, `amount`, `price`, `image`, `status`, `content`, `size`, `bookcover`, `number_pages`) VALUES
(11, 3, 'My Hero Academia - Tập 27: One’s Justice', 13, 200, 20000.00, '01.jpg', 'active', 'Cuối cùng chiến lược đột kích đồng loạt của giới siêu anh hùng đã triển khai. Toàn bộ công sức nằm vùng bấy lâu cũng đều vì khoảnh khắc áp chế được Chiến Tuyến Giải Phóng Siêu Năng này! Tôi nhất định sẽ bay nhanh hơn tất thảy! Tất cả vì mọi người, giống vị siêu anh hùng mình ngưỡng mộ từ thuở bé! “Plus Ultra”!!', '19 x 27 cm', 'Bìa gập', 168),
(12, 3, 'ブルーロック 3 - Blue Lock 3', 18, 1000, 145800.00, '02.jpg', 'active', 'Một huấn luyện viên trẻ điên rồ tập hợp các cầu thủ bóng đá từ khắp đất nước để thi đấu trong một loạt thử thách kỳ lạ trong một đấu trường công nghệ cao mà anh ta gọi là Blue Lock. Đó là một trận chiến không có giới hạn để trở thành tiền đạo hàng đầu tiếp theo của Nhật Bản, trong manga Squid Game –meets–World Cup này, hiện đã có bản in! Anime đang phát sóng! BẠN SẼ TẠO BỎ QUÁ KHỨ CHƯA? Thưởng thức hương vị ngọt ngào của chiến thắng trước Đội Y, Đội Z tràn đầy năng lượng để đối đầu với đối thủ t', '18.3 x 13 x 1.3 cm', 'Bìa Mềm', 192),
(21, 19, 'Chưa Kịp Lớn Đã Trưởng Thành (Tái Bản 2023)', 17, 50, 63200.00, 'chualon.jpg', 'active', 'Chưa Kịp Lớn Đã Trưởng Thành\r\n\r\nChúng ta của hiện tại, đều chưa kịp lớn đã phải trưởng thành.\r\n\r\nLúc còn nhỏ có thể khóc cười tuỳ ý. Trưởng thành rồi mới biết hành động cũng cần nhìn sắc mặt người khác.\r\n\r\nLúc còn nhỏ có thể sống vô tư, vô lo. Trưởng thành rồi mới biết nếu chậm chân hơn người khác, chắc chắn sẽ bị đào thải bất cứ lúc nào.\r\n\r\nLúc còn nhỏ có thể khao khát, mơ mộng. Trưởng thành rồi mới biết thế giới ngoài kia thực sự rất tàn khốc.', '17 x 14 x 1.1 cm', 'Bìa Mềm', 240),
(22, 3, 'One Piece - Tập 97 (Tái Bản)', 16, 0, 22500.00, 'onepiece97.jpg', 'out_of_stock', 'Ngay trước cuộc chinh phạt diễn ra, Kanjuro bất ngờ có động thái lạ... Chưa kể Momono suke còn bị bắt cóc... Trong lúc Kinemon và mọi người đang tuyệt vọng tràn trề, Luffy - Law - Kid bất ngờ xuất trận, mang lại nguồn sáng mới cho cả bọn!! Cả binh đoàn rồng rắn thẳng tiến về đảo Quỷ!!', '17.6 x 11.3 x 1 cm', 'Bìa Mềm', 196),
(31, 3, 'Thanh Gươm Diệt Quỷ - Kimetsu No Yaiba - Tập 12: Các Thượng Huyền Tập Hợp', 15, 200, 22250.00, 'thanh-guom-diet-quy-tap-12.jpg', 'active', 'Thanh Gươm Diệt Quỷ - Kimetsu No Yaiba - Tập 12: Các Thượng Huyền Tập Hợp\r\n\r\n113 năm rồi mới để mất một Thượng huyền, Muzan nổi cơn thịnh nộ, ra mệnh lệnh tiếp theo với các Thượng huyền còn lại. Trong khi đó, Tanjiro làm mẻ gươm trong trận chiến với Gyutaro và giờ phải đối mặt với cơn giận dữ của Haganezuka. Cậu lên đường đến làng thợ rèn nơi Haganezuka sống để tìm kiếm thanh gươm mới cho mình, nhưng điều gì đang chờ đón cậu ở phía trước…!?', '17.6 x 11.3 cm', 'Bìa Mềm', 192),
(32, 19, 'Cây Cam Ngọt Của Tôi', 14, 450, 86400.00, 'caycam.jpg', 'active', '“Vị chua chát của cái nghèo hòa trộn với vị ngọt ngào khi khám phá ra những điều khiến cuộc đời này đáng sống... một tác phẩm kinh điển của Brazil.” - Booklist\r\n\r\n“Một cách nhìn cuộc sống gần như hoàn chỉnh từ con mắt trẻ thơ… có sức mạnh sưởi ấm và làm tan nát cõi lòng, dù người đọc ở lứa tuổi nào.” - The National\r\n\r\nHãy làm quen với Zezé, cậu bé tinh nghịch siêu hạng đồng thời cũng đáng yêu bậc nhất, với ước mơ lớn lên trở thành nhà thơ cổ thắt nơ bướm. Chẳng phải ai cũng công nhận khoản “đáng', '20 x 14.5 cm', 'Bìa Mềm', 244),
(33, 3, 'My Hero Academia - Học Viện Siêu Anh Hùng Tập 5: Todoroki Shoto: Khởi Đầu (Tái Bản 2019)', 13, 50, 20000.00, 'image_186914.jpg', 'active', 'ĐẦUTRẬN CUỐI CÙNG trong VÒNG ĐẤU CHÍNH THỨC!! Trước một đối thủ siêu đáng gờm như Bakugo, Uraraka vẫn giữ tinh thần hăng hái.\r\nCả hai bên đều dốc hết sức mình vào cuộc so tài. Mọi người vừa là bạn , vừa là ĐỐI THỦ ! Mình cũng phải đấu một trận không hổ thẹn để trở thành siêu anh hùng giống như anh hai mới được!', '17.6 x 11.3 x 1.2 cm', 'Bìa Mềm', 192),
(66, 3, 'Tiểu Thuyết The Movie Chú Thuật Hồi Chiến Tập 0', 12, 10, 63200.00, '04.jpg', 'active', 'Cậu học sinh trung học Okkotsu Yuta luôn khốn đốn vì bị Rika - cô bạn thanh mai trúc mã hóa thành “lời nguyền” ám theo. Đúng lúc đó, Gojo Satoru - chú thuật sư mạnh nhất xuất hiện, dẫn dắt cậu vào trường chuyên chú thuật. Tại ngôi trường học về “lời nguyền” để thanh tẩy “lời nguyền” ấy, Yuta hạ quyết tâm giải trừ lời nguyền của Rika và cùng các bạn đặt chân lên con đường trở thành chú thuật sư.\r\n', '19 x 13 x 1.5 cm', 'Bìa Mềm', 300),
(67, 22, 'Lâu Đài Bay Của Pháp Sư Howl (Tái Bản 2019)', 11, 10, 90100.00, '05.jpg', 'active', 'Cô gái Sophie Hatter đang sống và làm việc yên ổn trong cửa hiệu bán mũ của bố mẹ ở Ingary, xứ sở của những đôi ủng bảy lý và áo tàng hình thì bỗng một ngày, mụ phù thuỷ xứ Waste xuất hiện biến cô thành bà già xấu xí. Quyết tâm giải cứu bản thân mình, Sophie đi tới lâu đài bay tìm kiếm sự giúp đỡ của Pháp sư Howl - kẻ vốn bị đồn là khoái “ăn tươi nuốt sống” trái tim của những cô gái trẻ.\r\n\r\n“…Sophie ngậm ngón tay bị bỏng nhẹ và lấy tay kia nhặt những lát thịt ba chỉ xông khói rơi trên váy, mắt chằm chằm nhìn Calcifer. Lão đang quật từ bên này sang bên kia lò sưởi. Những bộ mặt xanh lơ của lão gần như trắng bệch. Trong khoảnh khắc, lão có vô số những con mắt da cam, rồi khoảnh khắc sau đó đã có hàng dãy những con mắt bạc sáng như sao. Cô chưa bao giờ hình dung ra cái gì giống như thế.\r\nCó cái gì đó quét qua trên đầu với một phát nổ và tiếng đùng làm rung chuyển mọi thứ trong phòng. Một cái gì đó thứ hai theo sau, với tiếng rống dài chói tai. Calcifer rung lên gần như xanh đen, và da Sophie xèo xèo vì tàn lửa từ phép thần thông đó…”', '20.5 x 13 cm', 'Bìa Mềm', 400),
(68, 21, 'Hiểu Về Trái Tim (Tái Bản 2023)', 10, 50, 134300.00, '07.jpg', 'active', 'Trong dòng chảy tất bật của cuộc sống, có bao giờ chúng ta dừng lại và tự hỏi: Tại sao ta giận? Tại sao ta buồn? Tại sao ta hạnh phúc? Tại sao ta cô đơn?... Tất cả những hiện tượng tâm lý ấy không ngừng biến hóa trong ta và tác động lên đời sống của ta, nhưng ta lại biết rất ít về nguồn gốc và sự vận hành của nó. Chỉ cần một cơn giận, hay một ý niệm nghi ngờ, cũng có thể quét sạch năng lượng bình yên trong ta và khiến ta nhìn mọi thứ đều sai lệch. Từ thất bại này đến đổ vỡ khác mà ta không lý giải nổi, chỉ biết dùng ý chí để tự nhắc nhở mình cố gắng tiến bộ hơn. Cho nên, hiểu về trái tim chính là nhu cầu căn bản nhất của con người.', '20.5 x 13 x 2.5 cm', 'Bìa Mềm', 479),
(69, 3, 'Dragon Ball Super - Tập 16: Chiến Binh Mạnh Nhất Vũ Trụ', 9, 50, 20000.00, '08.jpg', 'active', 'Granola là người hành tinh Cereal cuối cùng còn sống sau trận càn quét của Frieza và quân đội Saiya. Anh đã dùng ngọc rồng của hành tinh Cereal để thực hiện điều ước biến mình thành chiến binh mạnh nhất vũ trụ, trả thù cho quê hương. Trong khi đó, Goku và các bạn lại nhận được yêu cầu tiêu diệt Granola từ một nhóm người tên Heeter.', '17.6 x 11.3 x 1.3 cm', 'Bìa Mềm', 192),
(70, 3, 'Shin - cậu bé bút chì - Hoạt hình màu - Tập 13 (2020)', 8, 0, 36000.00, 'shin13.jpg', 'out_of_stock', 'Được phát hành lần đầu vào năm 1992, bộ truyện sớm gây được tiếng vang đối với độc giả Nhật Bản và nhiều nước khác trên thế giới. Vài năm sau đó, loạt phim hoạt hình về cậu bé Shin cũng được sản xuất và phát sóng liên tục cho đến bây giờ.\r\n\r\nVề hình thức thể hiện, tác giả sử dụng bút pháp đơn giản, thậm chí có vẻ \"ngây ngô\" hơn so với các bộ manga khác. Nội dung truyện cũng đơn giản: tất cả xoay quanh nhân vật chính là cậu bé Shin 5 tuổi với những mối quan hệ thân sơ, bố mẹ, hàng xóm, thầy cô, bạn bè, người quen và... cả những người không quen.\r\n\r\nMỗi tập truyện khoảng 190 trang, nhưng cứ thử cầm lên xem, bạn sẽ không thể rời mắt khỏi cuốn sách cho đến tận trang cuối cùng. Với tài năng kể chuyện hấp dẫn, tác giả đã biến các trang sách của mình thành những sân chơi ngập tràn tiếng cười của những cô bé, cậu bé hồn nhiên và một thế giới tuổi thơ đa sắc màu.\r\nNhững bài học giáo dục nhẹ nhàng, thấm thía cũng được lồng ghép một cách khéo léo trong từng tình huống truyện. Có thể Shin là một cậu bé cá tính, hiếu động. Có thể những trò tinh nghịch của Shin đôi khi quá trớn, chẳng chừa một ai. Nhưng sau những \"sự cố\" do Shin gây ra, người lớn thấy mình cần \"quan tâm\" đến trẻ con nhiều hơn nữa, các bạn đọc nhỏ tuổi chắc hẳn cũng được dịp nhìn nhận lại bản thân, để phân biệt điều tốt điều xấu trong cuộc sống.\r\nCộng thêm hình ảnh có màu sắc sẽ khiến cho bộ truyện càng thêm hấp dẫn, hãy cùng theo dõi diễn biến trong mỗi tập nhé.', '13x18 cm', ' Bìa Mềm', 184),
(71, 22, 'Chuyện Kinh Dị Hằng Đêm', 7, 0, 151000.00, 'bia1_chuyen-kinh-di-hang-dem.jpg', 'out_of_stock', 'Chuyện Kinh Dị Hằng Đêm\r\n\r\nTháng Bảy đêm rằm mở cửa âm\r\n\r\nNgười dương giữ miệng kẻo lầm gọi tên\r\n\r\nTừ xửa từ xưa người ta bảo đêm tối là lúc âm dương gần nhau nhất thế nên cứ đến khuya họ lại kể cho nhau nghe những câu chuyện không nên nhắc vào ban ngày.\r\n\r\nCâu chuyện những người bạn chí thân sẵn sàng tàn sát lẫn nhau để tranh giành thứ báu vật thần kỳ giúp cài tử hoàn sinh.\r\n\r\nCâu chuyện đêm Rằm tháng Bảy có đứa trẻ không nghe lời vẫn ra ngoài khi trời đã tối và đáp lời khi có người gọi tên mình.\r\n\r\nCâu chuyện về những cái chết dưới đáy sông không phải lúc nào cũng là tai nạn, đôi khi là món nợ tới kéo xuống đáy nước.\r\n\r\nChuyện kinh dị hằng đêm như người làng kể chuyện cũ như tiếng thì thầm xuyên qua tấm chăn dày lúc nửa đêm. Ở đó có ma dân gian chưa siêu thoát, có những điều cấm kỵ truyền đời, và có nhân quả âm thầm đã gieo từ rất lâu.\r\n\r\nTrong những câu chuyện ấy, ma quỷ không phải lúc nào cũng hiện hình. Thứ đáng sợ hơn là nhân tâm: lòng tham không đáy, cơn giận bị nuôi lớn, sự ích kỷ được bao che bằng im lặng. Nghiệp báo trong Chuyện kinh dị hằng đêm thường tích tụ trở thành cơn ác mộng và chọn đúng một đêm để gõ cửa.\r\n\r\nChuyện kinh dị hằng đêm giống như những lời ru ngược, càng nghe càng tỉnh, càng đọc càng lạnh sống lưng. Hi vọng khi gập sách lại, bạn vẫn sẽ ngủ ngon.\r\n\r\n---------\r\n\r\nVề tác giả:\r\n\r\nVương Vũ Thần\r\n\r\nSinh năm 1983 tại Giang Tây, Trung Quốc. Từng theo học Đại học Hàng không Giang Tây, chuyên ngành Khoa học Máy tính và Ứng dụng.\r\n\r\nHiện là nhà văn tự do, tác giả yêu thích gồm Dư Hoa và Edogawa Ranpo.\r\n\r\nPhương châm sáng tác: Mặc dù tôi viết về mặt tối của con người và xã hội, nhưng tôi tin rằng ánh sáng của lương tri và sự tử tế sẽ không bao giờ tàn lụi.', '24 x 16 x 1.9 cm', 'Bìa Mềm', 392),
(72, 22, 'Tháp Nhốt Vong', 6, 0, 209000.00, 'bia1_tnv.jpg', 'out_of_stock', 'Một tòa nhà cũ kỹ, những nghi lễ trừ tà thất bại, những linh hồn không siêu thoát… Tất cả tạo nên bầu không khí rùng rợn bao trùm “Tháp nhốt vong” - tiểu thuyết tâm linh, kinh dị mang đậm màu sắc đô thị.\r\n\r\nSau cái chết của người vợ, Tâm và con gái phải chuyển vào một tòa nhà đã bắt đầu xuống cấp - chung cư Thiên Kính. Nhưng thay vì có một khởi đầu mới, họ dần bị cuốn vào vòng xoáy rùng rợn của quá khứ: những cái chết bất thường, những vong linh vất vưởng, những nghi lễ trừ tà thất bại và những câu chuyện tưởng như đã bị lãng quên.\r\n\r\nThiên Kính đã sừng sững đứng giữa đất trời qua biến thiên lịch sử nhưng câu chuyện phía sau sự tồn tại của nó là gì? Điều gì đã thực sự đưa Tâm đến với tòa nhà này và thân phận của anh có gì bí ẩn? Ai là kẻ đứng đằng sau những âm mưu và tà thuật, mục đích của kẻ đó là gì?\r\n\r\nTruyện ma đô thị, mặc dù đã được tam sao thất bản khá nhiều bởi tính truyền miệng nhưng luôn khiến người ta sợ hãi bởi sự gần gũi và chân thực của nó, đồng thời cũng tạo ra một sự hấp dẫn lạ kỳ cho những ai biết đến chúng. Lấy cảm hứng từ những truyền thuyết đô thị và các lời đồn ma ám gắn với một khu chung cư ở quận 5 (Sài Gòn), Tháp nhốt vong được xây dựng trên nền tảng văn hóa tâm linh Việt Nam, kết hợp những yếu tố lịch sử, tín ngưỡng dân gian và không khí hiện đại. Những giai thoại về bùa Lỗ Ban, cô dâu áo đỏ, trục hồn, long mạch bị cắt đứt… cùng các truyền thuyết nổi tiếng như hồ Con Rùa, Cao Biền trở thành chất liệu tạo nên một câu chuyện vừa gần gũi, vừa ám ảnh.\r\n\r\nTrong quá trình dựng các tuyến truyện, tác giả đã sưu tầm rất nhiều sách về văn hóa tâm linh Việt Nam để tìm hiểu và nghiên cứu. Đây sẽ là một tác phẩm phù hợp với nhiều đối tượng bạn đọc, đặc biệt là các độc giả yêu thích thể loại tâm linh, kinh dị, cũng như những bạn dành nhiều tình yêu cho văn hóa, lịch sử.', '20.5 x 14.5 x 1.6 cm', 'Bìa Mềm', 323),
(73, 1, 'Stillhouse - Ác Mộng Ven Hồ', 5, 0, 111000.00, 'image_195509_1_39575.jpg', 'out_of_stock', 'Gina Royal là một phụ nữ bình dị sống cuộc sống êm đềm bên chồng và hai đứa con thơ tại vùng Wichita, tiểu bang Kansas. Thế giới của cô bỗng đảo lộn hoàn toàn vào ngày nọ, khi cô lái xe đưa các con đi học về thì phát hiện một chiếc xe hơi đã tông vào bức tường gara nhà cô, để lại một khoảng trống hoác đồng thời phơi bày bí mật kinh hoàng: một thi thể phụ nữ chết trong tư thế bị treo cổ. Gia đình Gina bỗng chốc rơi xuống vực thẳm. Để sinh tồn, cô buộc phải trốn chạy, bỏ đi mọi thứ mình từng có, những mong làm lại cuộc đời.\r\n\r\nGina cuối cùng tìm được bến đỗ tại ngôi nhà nhỏ bên hồ Stillhouse. Nhưng hy vọng mới còn chưa kịp bén rễ thì cuộc đời một lần nữa đẩy cô đến bờ vực khốn cùng. Cô phải làm thế nào để giữ được sự tỉnh táo trong trò chơi ú tim của kẻ giết người đã hiểu rõ cô và cô cũng hiểu hắn rất rõ? Phải làm thế nào để vừa giữ an toàn cho các con, vừa phải gìn giữ sợi dây tình cảm mong manh với hai đứa trẻ tuy còn nhỏ mà đã phải chịu quá nhiều thương tổn? \r\n\r\nLà tập đầu tiên trong series trinh thám Stillhouse gồm ba cuốn, cùng với Con lạch chết chóc và Dòng sông hắc ám, Ác mộng ven hồ sẽ đưa người đọc cùng Gina trải qua hành trình đi tìm sự thật với vô vàn ngã rẽ cùng những nút thắt mở bất ngờ đến phút chót.\r\n\r\nMời các bạn đón đọc! ', '24 x 16 x 1.9 cm', 'Bìa Mềm', 400),
(74, 1, 'Sát Nhân Trong Chiếc Hộp Mắt Ma', 4, 0, 126000.00, 'b_a_6_23.jpg', 'out_of_stock', 'Ngày hôm đó, chín người – trong đó có Hamura Yuzuru và Kenzaki Hiruko, hai thành viên thuộc Hội những người yêu thích bí ẩn của trường đại học Shinko – đã đến Chiếc hộp Mắt Ma, một cơ sở nghiên cứu cũ của tổ chức Madarame tọa lạc ở một khu vực hẻo lánh. Chủ nhân của nó, một bà lão được mệnh danh là Nhà Tiên Tri, đã nói với họ rằng: “Trong hai ngày tới, sẽ có bốn người chết tại đây.”\r\n\r\nNgay sau đó, cây cầu duy nhất nối cơ sở này với thế giới bên ngoài bị cháy rụi. Một người thiệt mạng. Lời tiên tri bắt đầu ứng nghiệm, nỗi sợ hãi bao trùm những người đang bị mắc kẹt tại đây. Mọi thứ càng rối ren hơn khi một nữ sinh trung học trong số họ thú nhận rằng cô ấy cũng có khả năng dự đoán tương lai.\r\n\r\nVới 48 giờ còn lại trong Chiếc Hộp Mắt Ma, bị chi phối bởi những lời tiên đoán chồng chéo, liệu Hamura và Hiruko có thể sống sót và vén màn bí ẩn hay không?', '20.5 x 14.5 x 2.1 cm', 'Bìa Mềm', 432),
(75, 1, 'Đứa Trẻ Giấy', 3, 0, 109000.00, '1_22_30.jpg', 'out_of_stock', 'Một bức thư cầu cứu đã kéo Na Đa phóng viên báo Sao Mai, quay trở lại ký ức đáng sợ vào ba năm trước, khi anh đi phỏng vấn một người sản phụ đã sinh ra…một bộ da mỏng như giấy.\r\n\r\nVì lòng trắc ẩn và sự tò mò vốn có của một người phóng viên, Na Đa đã dấn thân vào cuộc tìm kiếm đứa trẻ mất tích, để rồi bị cuốn vào một loạt những vụ án kỳ bí tới mức phi lý, với những chi tiết không thể dùng khoa học giải thích.\r\n\r\nCùng với đó một pháp y lạnh lùng, một nhóm máu kỳ lạ và một bí mật vượt xa tưởng tượng lần lượt xuất hiện. Đâu là sự thật? Là trò đùa của số phận, hay thứ gì đó chưa từng được con người biết đến?\r\n\r\nCuối cùng chân tướng chờ đợi Na Đa là gì?', '20.5 x 14.5 x 1.6 cm', 'Bìa Mềm', 326),
(76, 2, 'Bạn Gái Vs. Bạn Thời Thơ Ấu - Tập 2', 2, 0, 84000.00, 'bangai2_biaao_thumb_1.jpg', 'out_of_stock', 'Cuộc chiến không ngừng nghỉ giành giật sự chú ý từ nhân vật chính giữa cô bạn thời thơ ấu Chiwa và cô hot girl trường Masuzu, xảy ra song song cùng với vô vàn những diễn biến thú vị chốn học đường; tưởng chừng như không bao giờ có hồi kết. Liệu nhân vật chính có tìm ra được câu trả lời cho riêng mình?', '13 x 18 x 1.5', 'Bìa Mềm', 296),
(77, 2, 'Thiên Sứ Nhà Bên - Tập 4', 1, 0, 85000.00, 'thien_su_nha_ben_-_tap_4_-_bia.jpg', 'out_of_stock', '“Đối với tôi... cậu ấy là người quan trọng nhất.”\r\n\r\nTrong khi cả lớp náo loạn vì phát ngôn gây sốc ấy của Mahiru thì Amane - người không thể đoán định được suy nghĩ của cô - đã quyết tâm trở thành chàng trai xứng đáng ở bên cạnh cô ấy.\r\n\r\nĐể theo kịp Mahiru, cô gái xinh đẹp, thông minh, hoàn hảo và luôn dành sự tin tưởng cho cậu, Amane đang rất phấn đấu trong cả chuyện học hành lẫn rèn luyện thể thao. Chẳng rõ Mahiru có hiểu cho tâm ý của Amane hay không, nhưng chính Mahiru cũng đang cố gắng tiến thêm một bước để xoay chuyển trạng thái mơ hồ trong mối quan hệ của hai người.\r\n\r\nĐây là câu chuyện tình ngọt ngào với cô gái nhà bên tuy lạnh lùng nhưng thật đáng yêu đã được ủng hộ nhiệt tình trên trang Shousetsuka ni Narou.', '19 x 13 cm', 'Bìa Mềm', 316);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Truyện trinh thám'),
(2, 'LightNovel'),
(3, 'Manga'),
(19, 'Tiểu Thuyết'),
(21, 'Kỹ năng sống'),
(22, 'Kinh dị');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`id`, `name`, `email`, `password`, `address`, `phone`) VALUES
(1, 'Nguyễn Phúc Đức', 'duc@gmail.com', '$2y$10$bxC/.IttmQb8hSE5iCN27eV1Q95sogO9DAAbftsk3YHqom7SBCBni', 'ngõ 32/2, số nhà 15, tổ 6, Phường Yên Nghĩa, Hà Nội', '0123456789'),
(2, 'Nguyễn Phúc Nhật Thành', 'thanh@gmail.com', '$2y$10$xLvBMezoBLiVVNbCA9CG4.x3/iM1.PCDmMNTu/tDKdb0iwXj/t38C', 'Hà Đông', '0961581328'),
(9, 'Phan Văn Thai', 'thai@gmail.com', 'thai', 'Nam Định', '0915006655'),
(10, 'Tran Van A', 'a@gmail.com', '123', 'Nam Định', '0915006655');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer_cart`
--

CREATE TABLE `customer_cart` (
  `customer_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer_cart`
--

INSERT INTO `customer_cart` (`customer_id`, `book_id`, `quantity`) VALUES
(2, 68, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detailed_invoice`
--

CREATE TABLE `detailed_invoice` (
  `invoice_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `detailed_invoice`
--

INSERT INTO `detailed_invoice` (`invoice_id`, `book_id`, `quantity`, `unit_price`) VALUES
(4, 12, 1, 145800),
(5, 11, 1, 20000),
(6, 12, 1, 145800);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_receipts`
--

CREATE TABLE `import_receipts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `status` enum('completed','canceled') DEFAULT 'completed',
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `import_receipts`
--

INSERT INTO `import_receipts` (`id`, `user_id`, `date_time`, `status`, `total_amount`, `note`) VALUES
(1, 1, '2026-01-31 07:11:00', 'completed', 500000.00, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_receipt_items`
--

CREATE TABLE `import_receipt_items` (
  `id` int(11) NOT NULL,
  `receipt_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `import_receipt_items`
--

INSERT INTO `import_receipt_items` (`id`, `receipt_id`, `book_id`, `quantity`, `unit_price`) VALUES
(1, 1, 21, 50, 10000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_time` datetime NOT NULL,
  `status` enum('pending','approved','completed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` enum('cash','transfer') NOT NULL DEFAULT 'cash',
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `invoice`
--

INSERT INTO `invoice` (`id`, `customer_id`, `user_id`, `date_time`, `status`, `payment_method`, `total_amount`) VALUES
(4, 2, 1, '2026-01-24 04:28:35', 'completed', 'cash', 145800.00),
(5, 1, NULL, '2026-01-24 13:03:24', 'pending', 'transfer', 20000.00),
(6, 1, NULL, '2026-01-24 12:49:48', 'pending', 'transfer', 145800.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `gender` enum('male','female','other','') DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `gender`, `password`) VALUES
(1, 'Nguyễn Phúc Nhật Thành', 'npnthanh.03@gmail.com', '0961581328', 'male', '$2y$10$ZDDNrh6MiS4l5X897LOhcO13taBNc9orJrEbB0Gd2/Fp5WrMq.fXy');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categories` (`category_id`),
  ADD KEY `fk_book_author` (`author_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customer_cart`
--
ALTER TABLE `customer_cart`
  ADD PRIMARY KEY (`customer_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Chỉ mục cho bảng `detailed_invoice`
--
ALTER TABLE `detailed_invoice`
  ADD KEY `id_prdetailed` (`book_id`),
  ADD KEY `id_invoice` (`invoice_id`);

--
-- Chỉ mục cho bảng `import_receipts`
--
ALTER TABLE `import_receipts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `import_receipt_items`
--
ALTER TABLE `import_receipt_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receipt_id` (`receipt_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Chỉ mục cho bảng `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ad` (`user_id`),
  ADD KEY `id_custumer` (`customer_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `import_receipts`
--
ALTER TABLE `import_receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `import_receipt_items`
--
ALTER TABLE `import_receipt_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_book_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`);

--
-- Các ràng buộc cho bảng `customer_cart`
--
ALTER TABLE `customer_cart`
  ADD CONSTRAINT `customer_cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_cart_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `detailed_invoice`
--
ALTER TABLE `detailed_invoice`
  ADD CONSTRAINT `detailed_invoice_ibfk_3` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`),
  ADD CONSTRAINT `detailed_invoice_ibfk_4` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`);

--
-- Các ràng buộc cho bảng `import_receipts`
--
ALTER TABLE `import_receipts`
  ADD CONSTRAINT `import_receipts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Các ràng buộc cho bảng `import_receipt_items`
--
ALTER TABLE `import_receipt_items`
  ADD CONSTRAINT `import_receipt_items_ibfk_1` FOREIGN KEY (`receipt_id`) REFERENCES `import_receipts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `import_receipt_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`);

--
-- Các ràng buộc cho bảng `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
