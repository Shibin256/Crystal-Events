-- ========================================================
-- Crystal Events Database Schema & Seed Data
-- Database: `crystal-events`
-- Character Set: utf8mb4, Collation: utf8mb4_unicode_ci
-- ========================================================

CREATE DATABASE IF NOT EXISTS `crystal-events` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `crystal-events`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `review`;
DROP TABLE IF EXISTS `payment`;
DROP TABLE IF EXISTS `bookings`;
DROP TABLE IF EXISTS `cart`;
DROP TABLE IF EXISTS `events`;
DROP TABLE IF EXISTS `gallery`;
DROP TABLE IF EXISTS `category`;
DROP TABLE IF EXISTS `complaint`;
DROP TABLE IF EXISTS `contact`;
DROP TABLE IF EXISTS `company`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `login`;
SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
-- Table structure for table `login`
-- --------------------------------------------------------
CREATE TABLE `login` (
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `usertype` INT(1) NOT NULL COMMENT '1=Admin, 2=User, 3=Company',
  `status` INT(1) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1=Verified/Active',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE `users` (
  `email` VARCHAR(255) NOT NULL,
  `firstname` VARCHAR(100) NOT NULL,
  `lastname` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `housename` VARCHAR(255) DEFAULT NULL,
  `place` VARCHAR(255) DEFAULT NULL,
  `district` VARCHAR(100) DEFAULT NULL,
  `pincode` VARCHAR(10) DEFAULT NULL,
  `date_of_birth` DATE DEFAULT NULL,
  `acc_no` VARCHAR(50) DEFAULT NULL,
  `ifsc_code` VARCHAR(20) DEFAULT NULL,
  `profile_pic` VARCHAR(255) NOT NULL DEFAULT 'default.jpg',
  PRIMARY KEY (`email`),
  CONSTRAINT `fk_users_login` FOREIGN KEY (`email`) REFERENCES `login` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `company`
-- --------------------------------------------------------
CREATE TABLE `company` (
  `email` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `ownername` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `place` VARCHAR(255) DEFAULT NULL,
  `district` VARCHAR(100) DEFAULT NULL,
  `pincode` VARCHAR(10) DEFAULT NULL,
  `est_date` DATE DEFAULT NULL,
  `acc_no` VARCHAR(50) DEFAULT NULL,
  `ifsc_code` VARCHAR(20) DEFAULT NULL,
  `aadhar` VARCHAR(50) DEFAULT NULL,
  `about` TEXT DEFAULT NULL,
  `profile_pic` VARCHAR(255) NOT NULL DEFAULT 'default.jpg',
  PRIMARY KEY (`email`),
  CONSTRAINT `fk_company_login` FOREIGN KEY (`email`) REFERENCES `login` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `category`
-- --------------------------------------------------------
CREATE TABLE `category` (
  `cat_id` INT(11) NOT NULL AUTO_INCREMENT,
  `cat_title` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `events`
-- --------------------------------------------------------
CREATE TABLE `events` (
  `event_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `category` INT(11) NOT NULL,
  `description` TEXT NOT NULL,
  `company_email` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`event_id`),
  CONSTRAINT `fk_events_cat` FOREIGN KEY (`category`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_events_company` FOREIGN KEY (`company_email`) REFERENCES `company` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `cart`
-- --------------------------------------------------------
CREATE TABLE `cart` (
  `cart_id` INT(11) NOT NULL AUTO_INCREMENT,
  `event_id` INT(11) NOT NULL,
  `user` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`cart_id`),
  CONSTRAINT `fk_cart_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_cart_user` FOREIGN KEY (`user`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `payment`
-- --------------------------------------------------------
CREATE TABLE `payment` (
  `payment_id` INT(11) NOT NULL AUTO_INCREMENT,
  `amount` DECIMAL(10,2) NOT NULL,
  `paid_date` DATETIME NOT NULL,
  `ref_id` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `bookings`
-- --------------------------------------------------------
CREATE TABLE `bookings` (
  `book_id` INT(11) NOT NULL AUTO_INCREMENT,
  `event_id` INT(11) NOT NULL,
  `user_email` VARCHAR(255) NOT NULL,
  `requirements` TEXT NOT NULL,
  `event_date_time` DATETIME NOT NULL,
  `event_place` VARCHAR(255) NOT NULL,
  `event_district` VARCHAR(100) NOT NULL,
  `event_pincode` VARCHAR(10) NOT NULL,
  `price` DECIMAL(10,2) DEFAULT NULL,
  `reply` TEXT DEFAULT NULL,
  `book_status` INT(1) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1=Rejected, 2=Approved, 3=Completed',
  `pay_id1` INT(11) NOT NULL DEFAULT 0,
  `pay_id2` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`book_id`),
  CONSTRAINT `fk_bookings_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bookings_user` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `review`
-- --------------------------------------------------------
CREATE TABLE `review` (
  `review_id` INT(11) NOT NULL AUTO_INCREMENT,
  `book_id` INT(11) NOT NULL,
  `star` INT(1) NOT NULL,
  `review` TEXT NOT NULL,
  `review_date` DATETIME NOT NULL,
  PRIMARY KEY (`review_id`),
  CONSTRAINT `fk_review_booking` FOREIGN KEY (`book_id`) REFERENCES `bookings` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `gallery`
-- --------------------------------------------------------
CREATE TABLE `gallery` (
  `gallery_id` INT(11) NOT NULL AUTO_INCREMENT,
  `photo` VARCHAR(255) NOT NULL,
  `caption` VARCHAR(255) NOT NULL,
  `company_email` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`gallery_id`),
  CONSTRAINT `fk_gallery_company` FOREIGN KEY (`company_email`) REFERENCES `company` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `complaint`
-- --------------------------------------------------------
CREATE TABLE `complaint` (
  `complaint_id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `topic` VARCHAR(255) NOT NULL,
  `complaint` TEXT NOT NULL,
  `submitted_date` DATETIME NOT NULL,
  `reply` TEXT DEFAULT NULL,
  `status` INT(1) NOT NULL DEFAULT 1 COMMENT '1=Pending, 2=Closed',
  PRIMARY KEY (`complaint_id`),
  CONSTRAINT `fk_complaint_user` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `contact`
-- --------------------------------------------------------
CREATE TABLE `contact` (
  `contact_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- SEED DATA
-- ========================================================

-- 1. Master Login Accounts
-- Admin Password: 'admin123'
-- User & Company Password: 'Test@123'
INSERT INTO `login` (`email`, `password`, `usertype`, `status`) VALUES
('admin@crystalevents.com', '$2y$12$W/Mo1t.h0e1UozwVFGGFleKVj.7al/G9jmb77Qx/UHsoWb.xGEmEq', 1, 1),
('autodoc@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 2, 1),
('nandusasikumar007@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 2, 1),
('vishnuraj1846@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 2, 1),
('cevexcorporate@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('dolphinevents@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('eventiquehouse@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('eventosmagic@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('executiveevents@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('fonixevents@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('giaanmedias@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('hoorayevents@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('icecubeeventplanner@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('magnoliaevents@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('makemydayevents@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('maritusevents@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('oakstreetevents@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('onetouchevents@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1),
('trisolevents@gmail.com', '$2y$12$iRJCyUw4J1iRQRe5I/WgqeO0Dv91GoSDfTvU8xwygOT8Q8ec6aaVm', 3, 1);

-- 2. Client Users
INSERT INTO `users` (`email`, `firstname`, `lastname`, `phone`, `housename`, `place`, `district`, `pincode`, `date_of_birth`, `acc_no`, `ifsc_code`, `profile_pic`) VALUES
('autodoc@gmail.com', 'Vishnu', 'Raj', '9876543210', 'Auto Villa', 'Kaloor', 'Ernakulam', '682017', '1996-05-14', '123456789012', 'SBIN0001234', 'autodocgmailcom.jpeg'),
('nandusasikumar007@gmail.com', 'Nandu', 'Sasikumar', '9847123456', 'Sreyas Nilayam', 'Vennala', 'Ernakulam', '682028', '1998-08-22', '987654321098', 'HDFC0005678', 'nandusasikumar007gmailcom.jpg'),
('vishnuraj1846@gmail.com', 'Vishnu', 'K P', '9447012345', 'Krishna Kripa', 'Kadavantra', 'Ernakulam', '682020', '1995-11-03', '456789012345', 'ICIC0009876', 'vishnuraj1846gmailcom.jpeg');

-- 3. Event Companies
INSERT INTO `company` (`email`, `name`, `ownername`, `phone`, `place`, `district`, `pincode`, `est_date`, `acc_no`, `ifsc_code`, `aadhar`, `about`, `profile_pic`) VALUES
('cevexcorporate@gmail.com', 'Cevex Events', 'Rahul Menon', '9846011111', 'Edappally', 'Ernakulam', '682024', '2018-03-15', '112233445566', 'SBIN0007890', '458912347890', 'Cevex Corporate Events specializes in premier corporate summits, product launches, luxury weddings, and annual gala banquets across Kerala with bespoke planning.', 'cevexcorporategmailcom.jpg'),
('dolphinevents@gmail.com', 'Dolphin Events', 'Sujith Kumar', '9846022222', 'Marine Drive', 'Ernakulam', '682031', '2016-08-20', '223344556677', 'HDFC0001234', '789012345678', 'Dolphin Events delivers unforgettable celebration experiences, magical wedding setups, and immersive concert stage designs backed by state-of-the-art audiovisual setups.', 'dolphineventsgmailcom.jpg'),
('eventiquehouse@gmail.com', 'Eventique House', 'Anjali Nair', '9846033333', 'Panampilly Nagar', 'Ernakulam', '682036', '2019-01-10', '334455667788', 'ICIC0002345', '123498765432', 'Eventique House is a luxury wedding planning and celebration design atelier curating timeless aesthetics, floral mandaps, and high-end experiential catering.', 'eventiquehousegmailcom.png'),
('eventosmagic@gmail.com', 'Eventos Magic', 'Faizal Rahman', '9846044444', 'Kakkanad', 'Ernakulam', '682030', '2020-05-18', '445566778899', 'BARB0003456', '654321987654', 'Eventos Magic crafts whimsical celebrations, fairy-tale lighting setups, and dynamic stage productions tailored to your exact dreams and celebrations.', 'eventosmagicgmailcom.JPG'),
('executiveevents@gmail.com', 'Executive Events', 'Kiran Varma', '9846055555', 'Vytilla', 'Ernakulam', '682019', '2015-11-25', '556677889900', 'PUNB0004567', '987612345678', 'Executive Events stands at the pinnacle of luxury event management in South India, having organized prestigious international conventions, exhibitions, and royal weddings.', 'executiveeventsgmailcom.jpg'),
('fonixevents@gmail.com', 'Fonix Events', 'Deepak Jose', '9846066666', 'MG Road', 'Ernakulam', '682016', '2017-07-12', '667788990011', 'CNRB0005678', '321098765432', 'Fonix Events provides complete end-to-end event production, sound reinforcement, destination weddings, and theatrical stage engineering.', 'fonixeventsgmailcom.jpg'),
('giaanmedias@gmail.com', 'Giaan Media', 'Girish Nair', '9846077777', 'Palarivattom', 'Ernakulam', '682025', '2018-09-05', '778899001122', 'UBIN0006789', '876543210987', 'Giaan Media provides photography, videography, live broadcasting, and contemporary celebration setups with cutting-edge visual storytelling.', 'giaanmediasgmailcom.jpg'),
('hoorayevents@gmail.com', 'Hooray Events', 'Naveen George', '9846088888', 'Thevara', 'Ernakulam', '682013', '2021-02-14', '889900112233', 'IOBA0007890', '234567890123', 'Hooray Events brings joy and vibrancy to private parties, birthday bashes, baby showers, and anniversary galas with creative themes and interactive entertainment.', 'hoorayeventsgmailcom.jpg'),
('icecubeeventplanner@gmail.com', 'Ice Cubes Planner', 'Siddharth Roy', '9846099999', 'Ravipuram', 'Ernakulam', '682015', '2016-12-01', '990011223344', 'MAHB0008901', '567890123456', 'Ice Cubes Event Planner specializes in cool, modern celebration designs, youth festivals, fashion shows, and contemporary corporate seminars.', 'icecubeeventplannergmailcom.jpg'),
('magnoliaevents@gmail.com', 'Magnolia Events', 'Meera Krishnan', '9846100000', 'Aluva', 'Ernakulam', '683101', '2019-06-30', '101112131415', 'BDBL0009012', '901234567890', 'Magnolia Events blends traditional cultural warmth with modern sophistication, crafting breathtaking floral installations and bespoke banquet decor.', 'magnoliaeventsgmailcom.jpg'),
('makemydayevents@gmail.com', 'Make My Day', 'Jithesh Paul', '9846111111', 'Chittoor Road', 'Ernakulam', '682011', '2020-10-10', '121314151617', 'IDIB0000123', '345678901234', 'Make My Day Events turns every milestone into a timeless memory through customized decor, stellar hospitality, and seamless guest coordination.', 'makemydayeventsgmailcom.jpg'),
('maritusevents@gmail.com', 'Maritus Events', 'Bipin Mathew', '9846122222', 'Kaloor Stadium', 'Ernakulam', '682017', '2014-04-18', '141516171819', 'SBIN0002345', '678901234567', 'Maritus Events is one of the most trusted names for grand destination weddings in Kerala, renowned for royal set constructions and world-class artist management.', 'marituseventsgmailcom.jpg'),
('oakstreetevents@gmail.com', 'Oakstreet Events', 'Vivek Thomas', '9846133333', 'Fort Kochi', 'Ernakulam', '682001', '2019-11-20', '161718192021', 'HDFC0003456', '012345678901', 'Oakstreet Events curates artistic, heritage-inspired beachside weddings, boutique corporate retreats, and live music festivals.', 'oakstreeteventsgmalicom.jpg'),
('onetouchevents@gmail.com', 'One Touch Events', 'Ajith Chandran', '9846144444', 'Tripunithura', 'Ernakulam', '682301', '2018-08-08', '181920212223', 'ICIC0004567', '432109876543', 'One Touch Events provides single-window turnkey management for banquets, wedding receptions, and catering services with flawless execution.', 'onetoucheventsgmailcom.jpg'),
('trisolevents@gmail.com', 'Trisol Events', 'Harish Nambiar', '9846155555', 'Cherai', 'Ernakulam', '683514', '2021-04-05', '202122232425', 'BARB0005678', '890123456789', 'Trisol Events specializes in outdoor open-air events, beach wedding stages, thematic lighting installations, and DJ sound systems.', 'trisoleventsgmailcom.jpg');

-- 4. Categories
INSERT INTO `category` (`cat_id`, `cat_title`) VALUES
(1, 'Wedding Planning'),
(2, 'Birthday Parties'),
(3, 'Corporate Events'),
(4, 'Stage Decoration'),
(5, 'Catering Services'),
(6, 'Photography & Videography'),
(7, 'Musical Concerts'),
(8, 'Lighting & Sound'),
(9, 'Destination Weddings'),
(10, 'Product Launches');

-- 5. Events / Packages
INSERT INTO `events` (`event_id`, `name`, `category`, `description`, `company_email`) VALUES
(1, 'Royal Grand Wedding Package', 1, 'Comprehensive royal wedding management including traditional mandap design, bridal entrance choreography, premium floral arrangements, and guest coordination.', 'cevexcorporate@gmail.com'),
(2, 'Corporate Annual Summit & Gala', 3, 'Full turnkey corporate event management featuring LED wall backdrops, acoustic sound setup, keynote stage production, and multi-cuisine buffet catering.', 'cevexcorporate@gmail.com'),
(3, 'Fairy Tale Stage & Floral Decor', 4, 'Bespoke crystal and fresh flower stage backdrop with cascading orchids, fairy lights, and illuminated aisle runner for grand evening receptions.', 'dolphinevents@gmail.com'),
(4, 'Live Concert & DJ Extravaganza', 7, 'Heavy-duty trussing, concert-grade line array sound system, moving head lights, smoke machines, and celebrity artist liaison.', 'dolphinevents@gmail.com'),
(5, 'Luxury Destination Beach Wedding', 9, 'Beachfront bamboo canopy, pastel sunset styling, rustic welcome lounge, live acoustic band, and complete bridal party hospitality.', 'eventiquehouse@gmail.com'),
(6, 'Gourmet Multi-Cuisine Wedding Banquet', 5, 'Lavish 5-course live buffet including traditional Kerala Sadhya, Arabian barbecue, live dessert stations, and personalized tablescape service.', 'eventiquehouse@gmail.com'),
(7, 'Kids Magical Fantasy Birthday Party', 2, 'Themed balloon arch, cartoon character mascots, interactive magic show, chocolate fountain, and customized return gift hampers.', 'eventosmagic@gmail.com'),
(8, 'Thematic Stage Illumination & Pyros', 8, 'Computerized DMX light shows, cold pyro sparklers, low-fog dry ice stage effects, and ambient ballroom mood lighting.', 'eventosmagic@gmail.com'),
(9, 'International Business Expo Setup', 3, 'Modular exhibition stall construction, conference audio translation systems, VIP lounge fabrication, and registration desk automation.', 'executiveevents@gmail.com'),
(10, 'Cinematic Wedding Film & Photography', 6, 'Drone aerial coverage, candid 4K cinematography, traditional family portraits, same-day highlight reels, and custom leather albums.', 'giaanmedias@gmail.com'),
(11, 'Vibrant Sangeet & Haldi Celebration', 1, 'Marigold floral decor, colorful Rajasthani umbrellas, dhol players, customized photo booths, and festive dance floor staging.', 'fonixevents@gmail.com'),
(12, 'High-Impact Brand & Product Launch', 10, 'Dramatic product unveil mechanism, 3D hologram projection, corporate press liaison, and high-energy laser reveal show.', 'icecubeeventplanner@gmail.com'),
(13, 'Traditional Temple Wedding Styling', 1, 'Authentic Kerala lotus and jasmine floral backdrop, bronze lamp decor, instrumental Nadaswaram troupe, and traditional hospitality.', 'maritusevents@gmail.com'),
(14, 'Romantic Sunset Reception on the Lawn', 9, 'Fairy light canopy over open lawns, vintage wooden benches, live violin ensemble, and cocktail bar setup under starlight.', 'oakstreetevents@gmail.com'),
(15, 'Open Air Coastal Music & Food Festival', 7, 'Festival stage design, outdoor acoustic sound, food truck zone layout, security barricades, and carnival lighting.', 'trisolevents@gmail.com');

-- 6. Gallery Rows
INSERT INTO `gallery` (`gallery_id`, `photo`, `caption`, `company_email`) VALUES
(1, 'cevex_events_thumb.jpg', 'Grand Corporate Convention & Awards Gala', 'cevexcorporate@gmail.com'),
(2, 'dolphin_events_thumb.jpg', 'Luxury Evening Wedding Reception Stage', 'dolphinevents@gmail.com'),
(3, 'eventique_house_thumb.png', 'Beachside Sunset Mandap Styling', 'eventiquehouse@gmail.com'),
(4, 'eventos_magic_thumb.jpg', 'Thematic Floral Mandap at Le Meridien', 'eventosmagic@gmail.com'),
(5, 'executive_evnts_thumb.jpg', 'International Summit Plenary Hall Setup', 'executiveevents@gmail.com'),
(6, 'fonix_thumb.jpg', 'Traditional Sangeet Evening Stage', 'fonixevents@gmail.com'),
(7, 'giaan_media_thumb.jpg', 'Cinematic Wedding Candid Moments', 'giaanmedias@gmail.com'),
(8, 'hooray_events_thumb.jpg', 'Color Carnival Birthday Theme Party', 'hoorayevents@gmail.com'),
(9, 'icecubes_thumb.jpg', 'Modern Geometric LED Reception Setup', 'icecubeeventplanner@gmail.com'),
(10, 'magnolia_events_thumb.jpg', 'Orchid & Rose Floral Extravaganza', 'magnoliaevents@gmail.com'),
(11, 'make_my_day_thumb.jpg', 'Dream Wedding Aisle & Stage Setting', 'makemydayevents@gmail.com'),
(12, 'maritus_events_thumb.jpg', 'Royal Heritage Wedding Palace Setup', 'maritusevents@gmail.com'),
(13, 'oakstreet_events_thumb.jpg', 'Coastal Lawn Reception Fairy Lights', 'oakstreetevents@gmail.com'),
(14, 'one_touch_thumb.jpg', 'Elegant Banquet Hall Interior Styling', 'onetouchevents@gmail.com'),
(15, 'trisol_events_thumb.jpg', 'Live Music Concert Stage Production', 'trisolevents@gmail.com');

-- 7. Payment Records (for sample bookings)
INSERT INTO `payment` (`payment_id`, `amount`, `paid_date`, `ref_id`) VALUES
(1, 30000.00, '2026-10-15 11:20:00', 'pay_mock_adv_cevex001'),
(2, 24000.00, '2026-10-18 14:35:00', 'pay_mock_adv_dolphin002'),
(3, 36000.00, '2026-10-25 17:10:00', 'pay_mock_bal_dolphin002'),
(4, 32000.00, '2026-09-10 10:15:00', 'pay_mock_adv_eventique003'),
(5, 48000.00, '2026-09-28 16:40:00', 'pay_mock_bal_eventique003'),
(6, 40000.00, '2026-10-01 12:00:00', 'pay_mock_adv_executive004'),
(7, 60000.00, '2026-10-20 18:30:00', 'pay_mock_bal_executive004');

-- 8. Bookings across all 4 lifecycle states
INSERT INTO `bookings` (`book_id`, `event_id`, `user_email`, `requirements`, `event_date_time`, `event_place`, `event_district`, `event_pincode`, `price`, `reply`, `book_status`, `pay_id1`, `pay_id2`) VALUES
-- Pending Booking (book_status = 0)
(1, 1, 'autodoc@gmail.com', 'Grand wedding reception for 800 guests. Need royal white and gold thematic decor with live instrumental music.', '2026-12-15 18:00:00', 'Lulu Bolgatty Grand Hyatt', 'Ernakulam', '682504', NULL, NULL, 0, 0, 0),

-- Approved Booking awaiting Advance Payment (book_status = 2, pay_id1 = 0)
(2, 7, 'nandusasikumar007@gmail.com', 'First birthday party for 150 guests. Jungle safari theme with interactive games and customized cake table backdrop.', '2026-11-20 16:30:00', 'Crowne Plaza Ballroom', 'Ernakulam', '682040', 50000.00, 'Quotation confirmed including jungle theme stage, mascot, and balloon decor.', 2, 0, 0),

-- Advance Paid Booking awaiting Balance Payment (book_status = 2, pay_id1 > 0, pay_id2 = 0)
(3, 2, 'vishnuraj1846@gmail.com', 'Annual corporate awards ceremony for 400 attendees with high-resolution LED backdrop, podium, and audio engineering.', '2026-11-28 10:00:00', 'Kochi Marriott Hotel', 'Ernakulam', '682024', 75000.00, 'Corporate package approved. 40% advance received. Vendor preparing customized stage design.', 2, 1, 0),

-- Fully Paid Booking awaiting execution / completion mark (book_status = 2, pay_id1 > 0, pay_id2 > 0)
(4, 3, 'autodoc@gmail.com', 'Fairy tale stage backdrop with fresh white lilies and orchid arrangements for wedding reception.', '2026-11-05 18:30:00', 'Gokulam Park Hotel', 'Ernakulam', '682017', 60000.00, 'Both advance and balance payments cleared. Stage setup scheduled for event date.', 2, 2, 3),

-- Completed Booking with Reviews (book_status = 3, pay_id1 > 0, pay_id2 > 0)
(5, 5, 'nandusasikumar007@gmail.com', 'Destination wedding at Cherai beach. Pastel floral canopy, live music, and seafood buffet catering for 300 guests.', '2026-10-02 17:00:00', 'Cherai Beach Resort', 'Ernakulam', '683514', 80000.00, 'Event executed with glowing client acclaim and flawless stage management.', 3, 4, 5),

(6, 9, 'vishnuraj1846@gmail.com', 'Tech startup conference exhibition setup with 15 presentation booths and keynote live stream setup.', '2026-10-22 09:00:00', 'Rajiv Gandhi Indoor Stadium', 'Ernakulam', '682020', 100000.00, 'Event successfully delivered on schedule with full exhibition logistics.', 3, 6, 7);

-- 9. Reviews & Star Ratings
INSERT INTO `review` (`review_id`, `book_id`, `star`, `review`, `review_date`) VALUES
(1, 5, 5, 'Eventique House made our destination beach wedding truly magical! The floral mandap against the sunset was breathtaking and our guests cannot stop talking about the hospitality.', '2026-10-04 11:30:00'),
(2, 6, 5, 'Executive Events handled our technical conference with supreme professionalism. Sound, lighting, and stage mechanics were spotless. Highly recommended for corporate functions.', '2026-10-24 15:45:00');

-- 10. Sample Complaints
INSERT INTO `complaint` (`complaint_id`, `email`, `topic`, `complaint`, `submitted_date`, `reply`, `status`) VALUES
(1, 'autodoc@gmail.com', 'Advance Payment Receipt', 'I completed the advance payment for my booking but the confirmation took a few minutes to refresh.', '2026-10-28 14:00:00', 'Hello Vishnu, your transaction has been verified and your booking status is active. Thank you for choosing Crystal Events.', 2),
(2, 'nandusasikumar007@gmail.com', 'Venue District Clarification', 'Can we select venues outside Ernakulam district for destination wedding setups?', '2026-10-30 09:15:00', NULL, 1);

-- 11. Public Contact Messages
INSERT INTO `contact` (`contact_id`, `name`, `email`, `message`) VALUES
(1, 'Anandhu Krishnan', 'anandhuk@gmail.com', 'Interested in booking Cevex Events for our wedding next February. Could you connect us with their planning team?'),
(2, 'Dr. Sarah Thomas', 'drsarah@gmail.com', 'We are organizing an international medical symposium in Kochi. Looking for full exhibition stall fabrication.');
