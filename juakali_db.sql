-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 08:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `juakali_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `street`, `city`, `state`, `postal_code`, `country`, `created_at`) VALUES
(1, 1, 'Embakasi, Tassia', 'Nairobi', 'Nairobi', '00100', 'Kenya', '2025-05-21 09:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'collins', '$2y$10$M7ILHVoxFt/qayAC5tKzTO0FZpZR/tKQm4fq2D5ODnNTQjbG.c2oS', '2025-05-17 12:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `artisans`
--

CREATE TABLE `artisans` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_url` varchar(255) DEFAULT NULL,
  `average_rating` decimal(3,2) DEFAULT 0.00,
  `user_id` int(11) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artisans`
--

INSERT INTO `artisans` (`id`, `name`, `bio`, `location`, `created_at`, `image_url`, `average_rating`, `user_id`, `is_featured`, `status`) VALUES
(1, 'Collins Odhiambo Otieno', 'Photographer', 'Nairobi', '2025-05-17 13:34:05', 'uploads/IMG20250514174000.jpg', 5.00, NULL, 1, 'active'),
(2, 'Edwin O', 'welder', 'Kisumu', '2025-05-17 16:13:32', NULL, 4.00, NULL, 0, 'active'),
(3, 'Emanuel Kamau', 'Artist', 'Nairobi', '2025-05-18 12:03:30', NULL, 0.00, 9, 0, 'active'),
(4, 'Fredrick Kamau', 'Painter', 'Nairobi', '2025-05-18 12:25:32', '', 5.00, 10, 0, 'active'),
(5, 'Bob Williams Artisan', 'Specializing in unique handmade jewelry and accessories.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_bob.jpg', 4.50, 13, 1, 'active'),
(6, 'David Brown Crafts', 'Crafting custom leather goods with traditional methods.', 'Mombasa', '2025-05-24 11:52:45', 'uploads/artisan_david.jpg', 4.20, 15, 0, 'active'),
(7, 'Frank Wilson Artistry', 'Modern art pieces using recycled materials.', 'Kisumu', '2025-05-24 11:52:45', 'uploads/artisan_frank.jpg', 4.80, 17, 1, 'active'),
(8, 'Henry Taylor Woodworks', 'Fine furniture and wood carvings made to order.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_henry.jpg', 4.00, 19, 0, 'active'),
(9, 'Jack Thomas Textiles', 'Hand-dyed fabrics and bespoke clothing designs.', 'Eldoret', '2025-05-24 11:52:45', 'uploads/artisan_jack.jpg', 4.70, 21, 1, 'active'),
(10, 'Leo White Pottery', 'Functional and decorative ceramic art.', 'Nakuru', '2025-05-24 11:52:45', 'uploads/artisan_leo.jpg', 4.30, 23, 0, 'active'),
(11, 'Noah Martin Glassblowing', 'Exquisite glass art and home decor.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_noah.jpg', 4.90, 25, 1, 'active'),
(12, 'Peter Rodriguez Metalwork', 'Sculptures and functional items from reclaimed metal.', 'Thika', '2025-05-24 11:52:45', 'uploads/artisan_peter.jpg', 4.10, 27, 0, 'active'),
(13, 'Rachel Hernandez Weaves', 'Traditional and contemporary woven wall hangings.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_rachel.jpg', 4.60, 29, 1, 'active'),
(14, 'Tina Gonzalez Paintings', 'Vibrant acrylic paintings capturing Kenyan landscapes.', 'Malindi', '2025-05-24 11:52:45', 'uploads/artisan_tina.jpg', 4.40, 31, 0, 'active'),
(15, 'Vera Sanchez Sculptures', 'Stone and clay sculptures inspired by nature.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_vera.jpg', 4.70, 33, 1, 'active'),
(16, 'Xena Wright Digital Art', 'Custom digital portraits and illustrations.', 'Naivasha', '2025-05-24 11:52:45', 'uploads/artisan_xena.jpg', 4.20, 35, 0, 'active'),
(17, 'Zack Scott Photography', 'Capturing moments, from weddings to wildlife.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_zack.jpg', 4.80, 37, 1, 'active'),
(18, 'Ben Baker Batik Arts', 'Hand-drawn and dyed batik fabrics and apparel.', 'Mombasa', '2025-05-24 11:52:45', 'uploads/artisan_ben.jpg', 4.50, 39, 0, 'active'),
(19, 'Daniel Nelson Leathercraft', 'Custom leather bags, wallets, and accessories.', 'Kisumu', '2025-05-24 11:52:45', 'uploads/artisan_daniel.jpg', 4.10, 41, 1, 'active'),
(20, 'Fred Hall Glassware', 'Hand-blown glass ornaments and drinkware.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_fred.jpg', 4.60, 43, 0, 'active'),
(21, 'Harold Scott Carvings', 'Detailed wood and stone carvings.', 'Eldoret', '2025-05-24 11:52:45', 'uploads/artisan_harold.jpg', 4.30, 45, 1, 'active'),
(22, 'James Phillips Jewelry', 'Unique handcrafted silver and bead jewelry.', 'Nakuru', '2025-05-24 11:52:45', 'uploads/artisan_james.jpg', 4.80, 47, 0, 'active'),
(23, 'Liam Parker Home Decor', 'Creative and functional home decor items.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_liam.jpg', 4.00, 49, 1, 'active'),
(24, 'Nathan Lewis Furniture', 'Bespoke rustic and modern furniture pieces.', 'Thika', '2025-05-24 11:52:45', 'uploads/artisan_nathan.jpg', 4.90, 51, 0, 'active'),
(25, 'Oscar King Fine Art', 'Oil and watercolor paintings of various subjects.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_oscar.jpg', 4.20, 53, 1, 'active'),
(26, 'Quentin Hill Fabric Art', 'Textile art and custom fabric designs.', 'Malindi', '2025-05-24 11:52:45', 'uploads/artisan_quentin.jpg', 4.50, 55, 0, 'active'),
(27, 'Steven Baker Ceramics', 'Hand-thrown pottery and ceramic sculptures.', 'Naivasha', '2025-05-24 11:52:45', 'uploads/artisan_steven.jpg', 4.70, 57, 1, 'active'),
(28, 'Victor Davis Mixed Media', 'Artwork combining painting, collage, and sculpture.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_victor.jpg', 4.10, 59, 0, 'active'),
(29, 'Xavier Hall Photography', 'Landscape and portrait photography services.', 'Mombasa', '2025-05-24 11:52:45', 'uploads/artisan_xavier.jpg', 4.80, 61, 1, 'active'),
(30, 'Zachary Adams Basketry', 'Traditional and contemporary basket weaving.', 'Kisumu', '2025-05-24 11:52:45', 'uploads/artisan_zachary.jpg', 4.40, 63, 0, 'active'),
(31, 'Chris White Woodturning', 'Beautifully turned wooden bowls and vases.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_chris.jpg', 4.60, 65, 1, 'active'),
(32, 'Ethan Clark Pottery', 'Handmade ceramic tableware and decor.', 'Eldoret', '2025-05-24 11:52:45', 'uploads/artisan_ethan.jpg', 4.30, 67, 0, 'active'),
(33, 'Gary Hill Fabric Goods', 'Custom curtains, throws, and home textiles.', 'Nakuru', '2025-05-24 11:52:45', 'uploads/artisan_gary.jpg', 4.90, 69, 1, 'active'),
(34, 'Ian Brown Jewelry', 'Modern and minimalist jewelry designs.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_ian.jpg', 4.00, 71, 0, 'active'),
(35, 'Kevin Miller Leather', 'Handstitched leather accessories.', 'Thika', '2025-05-24 11:52:45', 'uploads/artisan_kevin.jpg', 4.70, 73, 1, 'active'),
(36, 'Mark Moore Fine Art', 'Abstract and figurative art in various mediums.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_mark.jpg', 4.10, 75, 0, 'active'),
(37, 'Oliver Anderson Sculpture', 'Figurative and abstract sculptures in stone and metal.', 'Malindi', '2025-05-24 11:52:45', 'uploads/artisan_oliver.jpg', 4.80, 77, 1, 'active'),
(38, 'Robert Jackson Photography', 'Event and portrait photography.', 'Naivasha', '2025-05-24 11:52:45', 'uploads/artisan_robert.jpg', 4.40, 79, 0, 'active'),
(39, 'Tom Harris Metal Art', 'Decorative and functional metal art pieces.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_tom.jpg', 4.60, 81, 1, 'active'),
(40, 'Vince Garcia Custom Crafts', 'Personalized gifts and handcrafted items.', 'Mombasa', '2025-05-24 11:52:45', 'uploads/artisan_vince.jpg', 4.20, 83, 0, 'active'),
(41, 'Xander Martinez Jewelry', 'Unique statement jewelry from natural materials.', 'Kisumu', '2025-05-24 11:52:45', 'uploads/artisan_xander.jpg', 4.80, 85, 1, 'active'),
(42, 'Zane Lopez Weaving', 'Handwoven textiles for fashion and home.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_zane.jpg', 4.50, 87, 0, 'active'),
(43, 'Brian Perez Digital Creations', 'Digital art prints and custom designs.', 'Eldoret', '2025-05-24 11:52:45', 'uploads/artisan_brian.jpg', 4.10, 89, 1, 'active'),
(44, 'Derek King Wood Crafts', 'Hand-carved wooden figures and decor.', 'Nakuru', '2025-05-24 11:52:45', 'uploads/artisan_derek.jpg', 4.70, 91, 0, 'active'),
(45, 'Felix Hill Fine Woodwork', 'Bespoke wooden furniture and installations.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_felix.jpg', 4.30, 93, 1, 'active'),
(46, 'Harry Brown Custom Shoes', 'Handmade leather shoes and footwear.', 'Thika', '2025-05-24 11:52:45', 'uploads/artisan_harry.jpg', 4.90, 95, 0, 'active'),
(47, 'Jerry Miller Glass Art', 'Stained glass and fused glass art.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_jerry.jpg', 4.20, 97, 1, 'active'),
(48, 'Larry Moore Sculptor', 'Large-scale public and private sculptures.', 'Malindi', '2025-05-24 11:52:45', 'uploads/artisan_larry.jpg', 4.50, 99, 0, 'active'),
(49, 'Neil Anderson Painter', 'Vibrant and expressive abstract paintings.', 'Naivasha', '2025-05-24 11:52:45', 'uploads/artisan_neil.jpg', 4.70, 101, 1, 'active'),
(50, 'Randy Jackson Artisan Goods', 'A variety of unique handmade goods.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_randy.jpg', 4.10, 103, 0, 'active'),
(51, 'Todd Harris Custom Wood', 'Custom wooden signs and unique pieces.', 'Mombasa', '2025-05-24 11:52:45', 'uploads/artisan_todd.jpg', 4.80, 105, 1, 'active'),
(52, 'Wayne Garcia Artisan', 'Handcrafted home decorations and gifts.', 'Kisumu', '2025-05-24 11:52:45', 'uploads/artisan_wayne.jpg', 4.40, 107, 0, 'active'),
(53, 'Zoe Martinez Apparel', 'Unique fashion pieces and accessories.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_zoe.jpg', 4.60, 109, 1, 'active'),
(54, 'Carl Perez Photography', 'Creative and artistic photography services.', 'Eldoret', '2025-05-24 11:52:45', 'uploads/artisan_carl.jpg', 4.30, 137, 0, 'active'),
(55, 'Earl King Furniture', 'Custom-built furniture with modern designs.', 'Nakuru', '2025-05-24 11:52:45', 'uploads/artisan_earl.jpg', 4.90, 139, 1, 'active'),
(56, 'Gavin Hill Ceramics', 'Hand-painted ceramic tiles and dinnerware.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_gavin.jpg', 4.00, 141, 0, 'suspended'),
(57, 'Isaac Brown Artisans', 'Traditional and contemporary handcrafted goods.', 'Thika', '2025-05-24 11:52:45', 'uploads/artisan_isaac.jpg', 4.70, 143, 1, 'active'),
(58, 'Keith Miller Metal Crafts', 'Artistic metal sculptures and decor.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_keith.jpg', 4.10, 145, 0, 'active'),
(59, 'Max Moore Canvas Art', 'Expressive canvas paintings for any space.', 'Malindi', '2025-05-24 11:52:45', 'uploads/artisan_max.jpg', 4.80, 147, 1, 'active'),
(60, 'Owen Anderson Textile Art', 'Intricate textile art pieces.', 'Naivasha', '2025-05-24 11:52:45', 'uploads/artisan_owen.jpg', 4.40, 149, 0, 'active'),
(61, 'Rick Jackson Sculptures', 'Unique sculptures from various materials.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_rick.jpg', 4.60, 151, 1, 'active'),
(62, 'Tony Harris Artisan', 'High-quality handcrafted goods.', 'Mombasa', '2025-05-24 11:52:45', 'uploads/artisan_tony.jpg', 4.20, 153, 0, 'active'),
(63, 'Will Garcia Custom Designs', 'Custom designed and handcrafted items.', 'Kisumu', '2025-05-24 11:52:45', 'uploads/artisan_will.jpg', 4.80, 155, 1, 'active'),
(64, 'Zane Martinez Photography', 'Professional photography services for all occasions.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_zane_martinez.jpg', 4.50, 181, 0, 'active'),
(65, 'Eric Perez Glass Works', 'Handmade glass jewelry and art pieces.', 'Eldoret', '2025-05-24 11:52:45', 'uploads/artisan_eric.jpg', 4.10, 161, 1, 'active'),
(66, 'George King Wooden Art', 'Rustic and contemporary wooden art.', 'Nakuru', '2025-05-24 11:52:45', 'uploads/artisan_george.jpg', 4.70, 163, 0, 'active'),
(67, 'Igor Hill Batik Artist', 'Creating vibrant batik paintings and fabrics.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_igor.jpg', 4.30, 165, 1, 'active'),
(68, 'Matt Miller Artisan Pottery', 'Unique handcrafted pottery for home and garden.', 'Thika', '2025-05-24 11:52:45', 'uploads/artisan_matt.jpg', 4.90, 169, 0, 'active'),
(69, 'Oliver Moore Artisan Works', 'Diverse collection of handcrafted items.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_oliver_moore.jpg', 4.20, 171, 1, 'active'),
(70, 'Rob Anderson Fine Crafts', 'Exquisite handcrafted items with attention to detail.', 'Malindi', '2025-05-24 11:52:45', 'uploads/artisan_rob.jpg', 4.50, 173, 0, 'active'),
(71, 'Tom Jackson Metal Sculptor', 'Modern and abstract metal sculptures.', 'Naivasha', '2025-05-24 11:52:45', 'uploads/artisan_tom_jackson.jpg', 4.70, 175, 1, 'active'),
(72, 'Val Harris Textile Artist', 'Creative textile art and soft furnishings.', 'Nairobi', '2025-05-24 11:52:45', 'uploads/artisan_val.jpg', 4.10, 177, 0, 'active'),
(73, 'Xavier Garcia Wood Craftsman', 'Handcrafted wooden furniture and decor.', 'Mombasa', '2025-05-24 11:52:45', 'uploads/artisan_xavier_garcia.jpg', 4.80, 179, 1, 'active'),
(74, 'Bob C Artisan', 'Creating unique and personalized artisan gifts.', 'Kisumu', '2025-05-24 11:52:45', 'uploads/artisan_bob_c.jpg', 4.40, 183, 0, 'active'),
(75, 'Artisan Smith 5', 'Specializes in custom decor items.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_5.jpg', 4.50, NULL, 0, 'active'),
(76, 'Craft Master 6', 'Expert in traditional textile weaving.', 'Mombasa', '2025-05-24 12:16:36', 'uploads/artisan_6.jpg', 4.80, NULL, 0, 'active'),
(77, 'Culinary Artist 7', 'Creates gourmet food products.', 'Kisumu', '2025-05-24 12:16:36', 'uploads/artisan_7.jpg', 4.90, NULL, 0, 'active'),
(78, 'Wellness Creator 8', 'Handmakes organic personal care products.', 'Nakuru', '2025-05-24 12:16:36', 'uploads/artisan_8.jpg', 4.70, NULL, 0, 'active'),
(79, 'Decor Innovator 9', 'Modern decor solutions.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_9.jpg', 4.60, NULL, 0, 'active'),
(80, 'Fabric Weaver 10', 'Artisanal fabrics and garments.', 'Eldoret', '2025-05-24 12:16:36', 'uploads/artisan_10.jpg', 4.75, NULL, 0, 'active'),
(81, 'Sweet Treats Artisan 11', 'Delicious homemade pastries and sweets.', 'Thika', '2025-05-24 12:16:36', 'uploads/artisan_11.jpg', 4.95, NULL, 0, 'active'),
(82, 'Natural Care Crafter 12', 'Handcrafted soaps and lotions.', 'Malindi', '2025-05-24 12:16:36', 'uploads/artisan_12.jpg', 4.65, NULL, 0, 'active'),
(83, 'Ceramic Artist 13', 'Unique ceramic pottery and art.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_13.jpg', 4.55, NULL, 0, 'active'),
(84, 'Batik Expert 14', 'Vibrant batik and tie-dye creations.', 'Lamu', '2025-05-24 12:16:36', 'uploads/artisan_14.jpg', 4.85, NULL, 0, 'active'),
(85, 'Spice Blender 15', 'Exotic spice blends and marinades.', 'Nanyuki', '2025-05-24 12:16:36', 'uploads/artisan_15.jpg', 4.90, NULL, 0, 'active'),
(86, 'Aromatherapy Maker 16', 'Essential oil blends and diffusers.', 'Naivasha', '2025-05-24 12:16:36', 'uploads/artisan_16.jpg', 4.70, NULL, 0, 'active'),
(87, 'Wood Carver 17', 'Intricate wood carvings and furniture.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_17.jpg', 4.60, NULL, 0, 'active'),
(88, 'Embroidery Artist 18', 'Detailed hand-embroidered textiles.', 'Kitale', '2025-05-24 12:16:36', 'uploads/artisan_18.jpg', 4.80, NULL, 0, 'active'),
(89, 'Organic Farmer 19', 'Fresh organic produce and preserves.', 'Kericho', '2025-05-24 12:16:36', 'uploads/artisan_19.jpg', 4.92, NULL, 0, 'active'),
(90, 'Skincare Formulator 20', 'Natural skincare products for all types.', 'Meru', '2025-05-24 12:16:36', 'uploads/artisan_20.jpg', 4.72, NULL, 0, 'active'),
(91, 'Metal Sculptor 21', 'Creative metal art and sculptures.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_21.jpg', 4.50, NULL, 0, 'active'),
(92, 'Quilt Maker 22', 'Handstitched quilts and blankets.', 'Isiolo', '2025-05-24 12:16:36', 'uploads/artisan_22.jpg', 4.80, NULL, 0, 'active'),
(93, 'Confectioner 23', 'Artisan chocolates and candies.', 'Nyeri', '2025-05-24 12:16:36', 'uploads/artisan_23.jpg', 4.90, NULL, 0, 'active'),
(94, 'Hair Care Specialist 24', 'Natural hair oils and treatments.', 'Embu', '2025-05-24 12:16:36', 'uploads/artisan_24.jpg', 4.70, NULL, 0, 'active'),
(95, 'Glass Blower 25', 'Exquisite hand-blown glass decor.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_25.jpg', 4.60, NULL, 0, 'active'),
(96, 'Knitwear Designer 26', 'Fashionable knitwear for all seasons.', 'Machakos', '2025-05-24 12:16:36', 'uploads/artisan_26.jpg', 4.75, NULL, 0, 'active'),
(97, 'Baker Extraordinaire 27', 'Specialty breads and custom cakes.', 'Eldoret', '2025-05-24 12:16:36', 'uploads/artisan_27.jpg', 4.95, NULL, 0, 'active'),
(98, 'Bath Bomb Artisan 28', 'Luxurious and fragrant bath bombs.', 'Kisii', '2025-05-24 12:16:36', 'uploads/artisan_28.jpg', 4.65, NULL, 0, 'active'),
(99, 'Pottery Master 29', 'Hand-thrown pottery for home and garden.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_29.jpg', 4.55, NULL, 0, 'active'),
(100, 'Fashion Textile Artist 30', 'Unique painted and printed textiles.', 'Garissa', '2025-05-24 12:16:36', 'uploads/artisan_30.jpg', 4.85, NULL, 0, 'active'),
(101, 'Jam & Jelly Maker 31', 'Homemade jams and fruit preserves.', 'Homa Bay', '2025-05-24 12:16:36', 'uploads/artisan_31.jpg', 4.90, NULL, 0, 'active'),
(102, 'Candle Maker 32', 'Hand-poured soy candles with unique scents.', 'Kakamega', '2025-05-24 12:16:36', 'uploads/artisan_32.jpg', 4.70, NULL, 0, 'active'),
(103, 'Recycled Art Creator 33', 'Art from recycled materials.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_33.jpg', 4.60, NULL, 0, 'active'),
(104, 'Crochet Artist 34', 'Beautiful crochet blankets and accessories.', 'Mombasa', '2025-05-24 12:16:36', 'uploads/artisan_34.jpg', 4.80, NULL, 0, 'active'),
(105, 'Pickle & Chutney Chef 35', 'Savory pickles and flavorful chutneys.', 'Nyeri', '2025-05-24 12:16:36', 'uploads/artisan_35.jpg', 4.92, NULL, 0, 'active'),
(106, 'Body Butter Mixer 36', 'Rich, moisturizing body butters.', 'Busia', '2025-05-24 12:16:36', 'uploads/artisan_36.jpg', 4.72, NULL, 0, 'active'),
(107, 'Abstract Painter 37', 'Vibrant abstract art pieces.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_37.jpg', 4.50, NULL, 0, 'active'),
(108, 'Felt Artist 38', 'Whimsical felt sculptures and decor.', 'Kilifi', '2025-05-24 12:16:36', 'uploads/artisan_38.jpg', 4.80, NULL, 0, 'active'),
(109, 'Herbalist Cook 39', 'Dishes infused with fresh herbs.', 'Kisumu', '2025-05-24 12:16:36', 'uploads/artisan_39.jpg', 4.90, NULL, 0, 'active'),
(110, 'Deodorant Crafter 40', 'Natural and effective deodorants.', 'Narok', '2025-05-24 12:16:36', 'uploads/artisan_40.jpg', 4.70, NULL, 0, 'active'),
(111, 'Mosaic Artist 41', 'Stunning mosaic art and functional pieces.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_41.jpg', 4.60, NULL, 0, 'active'),
(112, 'Macrame Creator 42', 'Boho-chic macrame wall hangings and planters.', 'Makueni', '2025-05-24 12:16:36', 'uploads/artisan_42.jpg', 4.75, NULL, 0, 'active'),
(113, 'Juice & Smoothie Bar 43', 'Freshly pressed juices and healthy smoothies.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_43.jpg', 4.95, NULL, 0, 'active'),
(114, 'Essential Oil Distiller 44', 'Pure, therapeutic essential oils.', 'Bomet', '2025-05-24 12:16:36', 'uploads/artisan_44.jpg', 4.65, NULL, 0, 'active'),
(115, 'Gourd Artist 45', 'Decorated and carved gourds.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_45.jpg', 4.55, NULL, 0, 'active'),
(116, 'Dyeing Specialist 46', 'Natural dye textiles and yarns.', 'Siaya', '2025-05-24 12:16:36', 'uploads/artisan_46.jpg', 4.85, NULL, 0, 'active'),
(117, 'Honey Harvester 47', 'Locally sourced raw honey and honey products.', 'Kitui', '2025-05-24 12:16:36', 'uploads/artisan_47.jpg', 4.90, NULL, 0, 'active'),
(118, 'Lip Balm Artisan 48', 'Nourishing handmade lip balms.', 'Kajiado', '2025-05-24 12:16:36', 'uploads/artisan_48.jpg', 4.70, NULL, 0, 'active'),
(119, 'Wire Sculptor 49', 'Intricate wire art and jewelry.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_49.jpg', 4.60, NULL, 0, 'active'),
(120, 'Weaving Craftsman 50', 'Traditional and contemporary woven goods.', 'Vihiga', '2025-05-24 12:16:36', 'uploads/artisan_50.jpg', 4.80, NULL, 0, 'active'),
(121, 'Sourdough Baker 51', 'Artisan sourdough breads and starters.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_51.jpg', 4.92, NULL, 0, 'active'),
(122, 'Hand Sanitizer Maker 52', 'Natural and effective hand sanitizers.', 'Migori', '2025-05-24 12:16:36', 'uploads/artisan_52.jpg', 4.72, NULL, 0, 'active'),
(123, 'Resin Artist 53', 'Resin art coasters and jewelry.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_53.jpg', 4.50, NULL, 0, 'active'),
(124, 'Upcycled Textile Designer 54', 'Fashion and home items from upcycled textiles.', 'Trans Nzoia', '2025-05-24 12:16:36', 'uploads/artisan_54.jpg', 4.80, NULL, 0, 'active'),
(125, 'Nut Butter Maker 55', 'Freshly ground nut butters.', 'Muranga', '2025-05-24 12:16:36', 'uploads/artisan_55.jpg', 4.90, NULL, 0, 'active'),
(126, 'Shaving Cream Crafter 56', 'Luxurious handmade shaving creams.', 'Bungoma', '2025-05-24 12:16:36', 'uploads/artisan_56.jpg', 4.70, NULL, 0, 'active'),
(127, 'Paper Artist 57', 'Handmade paper and paper art.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_57.jpg', 4.60, NULL, 0, 'active'),
(128, 'Block Printer 58', 'Hand block printed textiles and paper.', 'Nandi', '2025-05-24 12:16:36', 'uploads/artisan_58.jpg', 4.75, NULL, 0, 'active'),
(129, 'Cereal & Granola Chef 59', 'Healthy homemade cereals and granola.', 'Uasin Gishu', '2025-05-24 12:16:36', 'uploads/artisan_59.jpg', 4.95, NULL, 0, 'active'),
(130, 'Body Scrub Creator 60', 'Exfoliating body scrubs with natural ingredients.', 'Samburu', '2025-05-24 12:16:36', 'uploads/artisan_60.jpg', 4.65, NULL, 0, 'active'),
(131, 'Stained Glass Artist 61', 'Beautiful stained glass panels and lamps.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_61.jpg', 4.55, NULL, 0, 'active'),
(132, 'Doll Maker 62', 'Handcrafted dolls and soft toys.', 'Kwale', '2025-05-24 12:16:36', 'uploads/artisan_62.jpg', 4.85, NULL, 0, 'active'),
(133, 'Kimchi & Ferments Producer 63', 'Probiotic-rich fermented foods.', 'Taita-Taveta', '2025-05-24 12:16:36', 'uploads/artisan_63.jpg', 4.90, NULL, 0, 'active'),
(134, 'Perfume Blender 64', 'Unique artisan perfumes and colognes.', 'Elgeyo-Marakwet', '2025-05-24 12:16:36', 'uploads/artisan_64.jpg', 4.70, NULL, 0, 'active'),
(135, 'Jewelry Designer 65', 'Handmade jewelry from various materials.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_65.jpg', 4.60, NULL, 0, 'active'),
(136, 'Knitting & Crocheting 66', 'Warm and stylish knitted/crocheted items.', 'Baringo', '2025-05-24 12:16:36', 'uploads/artisan_66.jpg', 4.80, NULL, 0, 'active'),
(137, 'Artisan Coffee Roaster 67', 'Freshly roasted small-batch coffee.', 'Laikipia', '2025-05-24 12:16:36', 'uploads/artisan_67.jpg', 4.92, NULL, 0, 'active'),
(138, 'Facial Serum Mixer 68', 'Custom facial serums for glowing skin.', 'Wajir', '2025-05-24 12:16:36', 'uploads/artisan_68.jpg', 4.72, NULL, 0, 'active'),
(139, 'Digital Artist 69', 'Digital prints and customized art.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_69.jpg', 4.50, NULL, 0, 'active'),
(140, 'Textile Painter 70', 'Hand-painted textiles and home decor.', 'Marsabit', '2025-05-24 12:16:36', 'uploads/artisan_70.jpg', 4.80, NULL, 0, 'active'),
(141, 'Gourmet Chocolate Maker 71', 'Exquisite handmade chocolates.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_71.jpg', 4.90, NULL, 0, 'active'),
(142, 'Body Oil Formulator 72', 'Luxurious body oils for hydration.', 'Mandera', '2025-05-24 12:16:36', 'uploads/artisan_72.jpg', 4.70, NULL, 0, 'active'),
(143, 'Pottery Glazer 73', 'Specialized glazes for ceramic art.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_73.jpg', 4.60, NULL, 0, 'active'),
(144, 'Tapestry Artist 74', 'Intricate handwoven tapestries.', 'Narok', '2025-05-24 12:16:36', 'uploads/artisan_74.jpg', 4.75, NULL, 0, 'active'),
(145, 'Artisan Bread Baker 75', 'Crusty, flavorful artisan breads.', 'Turkana', '2025-05-24 12:16:36', 'uploads/artisan_75.jpg', 4.95, NULL, 0, 'active'),
(146, 'Hair Conditioner Bar Maker 76', 'Zero-waste hair conditioner bars.', 'Bomet', '2025-05-24 12:16:36', 'uploads/artisan_76.jpg', 4.65, NULL, 0, 'active'),
(147, 'Wood Turning Artist 77', 'Beautifully turned wooden bowls and vessels.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_77.jpg', 4.55, NULL, 0, 'active'),
(148, 'Embroidery Designer 78', 'Custom embroidery designs and patterns.', 'Muranga', '2025-05-24 12:16:36', 'uploads/artisan_78.jpg', 4.85, NULL, 0, 'active'),
(149, 'Homemade Pasta Chef 79', 'Fresh, authentic homemade pasta.', 'Kisii', '2025-05-24 12:16:36', 'uploads/artisan_79.jpg', 4.90, NULL, 0, 'active'),
(150, 'Facial Cleanser Crafter 80', 'Gentle, natural facial cleansers.', 'Bungoma', '2025-05-24 12:16:36', 'uploads/artisan_80.jpg', 4.70, NULL, 0, 'active'),
(151, 'Sculpture Artist 81', 'Unique sculptures in various mediums.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_81.jpg', 4.60, NULL, 0, 'active'),
(152, 'Weaving Studio 82', 'Handwoven rugs, throws, and placemats.', 'Siaya', '2025-05-24 12:16:36', 'uploads/artisan_82.jpg', 4.80, NULL, 0, 'active'),
(153, 'Artisan Cheese Maker 83', 'Small-batch, artisanal cheeses.', 'Nyandarua', '2025-05-24 12:16:36', 'uploads/artisan_83.jpg', 4.92, NULL, 0, 'active'),
(154, 'Body Lotion Mixer 84', 'Hydrating and nourishing body lotions.', 'Wajir', '2025-05-24 12:16:36', 'uploads/artisan_84.jpg', 4.72, NULL, 0, 'active'),
(155, 'Printmaker 85', 'Original prints and linocuts.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_85.jpg', 4.50, NULL, 0, 'active'),
(156, 'Custom Textile Artist 86', 'Personalized textile art for gifts.', 'Embu', '2025-05-24 12:16:36', 'uploads/artisan_86.jpg', 4.80, NULL, 0, 'active'),
(157, 'Vegan Food Artisan 87', 'Delicious plant-based food products.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_87.jpg', 4.90, NULL, 0, 'active'),
(158, 'Herbal Soap Maker 88', 'Soaps with natural herbs and botanicals.', 'Tana River', '2025-05-24 12:16:36', 'uploads/artisan_88.jpg', 4.70, NULL, 0, 'active'),
(159, 'Glass Artist 89', 'Fused glass art and functional items.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_89.jpg', 4.60, NULL, 0, 'active'),
(160, 'Quilted Bag Maker 90', 'Handcrafted quilted bags and accessories.', 'Lamu', '2025-05-24 12:16:36', 'uploads/artisan_90.jpg', 4.75, NULL, 0, 'active'),
(161, 'Preserves Producer 91', 'Fruit preserves and gourmet spreads.', 'Kajiado', '2025-05-24 12:16:36', 'uploads/artisan_91.jpg', 4.95, NULL, 0, 'active'),
(162, 'Natural Perfumer 92', 'Blends of natural essential oil perfumes.', 'Narok', '2025-05-24 12:16:36', 'uploads/artisan_92.jpg', 4.65, NULL, 0, 'active'),
(163, 'Handmade Cards Creator 93', 'Unique handmade greeting cards.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_93.jpg', 4.55, NULL, 0, 'active'),
(164, 'Custom Embroidery Shop 94', 'Personalized embroidered items.', 'Migori', '2025-05-24 12:16:36', 'uploads/artisan_94.jpg', 4.85, NULL, 0, 'active'),
(165, 'Artisan Coffee & Tea 95', 'Small-batch roasted coffee and speciality teas.', 'Busia', '2025-05-24 12:16:36', 'uploads/artisan_95.jpg', 4.90, NULL, 0, 'active'),
(166, 'Foot Care Specialist 96', 'Natural foot balms and soaks.', 'Kericho', '2025-05-24 12:16:36', 'uploads/artisan_96.jpg', 4.70, NULL, 0, 'active'),
(167, 'Upcycled Decor Artist 97', 'Creative decor from repurposed materials.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_97.jpg', 4.60, NULL, 0, 'active'),
(168, 'Fabric Decorator 98', 'Decorative fabrics for home interiors.', 'Kakamega', '2025-05-24 12:16:36', 'uploads/artisan_98.jpg', 4.80, NULL, 0, 'active'),
(169, 'Gourmet Condiments 99', 'Unique sauces and condiments.', 'Meru', '2025-05-24 12:16:36', 'uploads/artisan_99.jpg', 4.92, NULL, 0, 'active'),
(170, 'Sensitive Skin Care 100', 'Gentle products for sensitive skin.', 'Nakuru', '2025-05-24 12:16:36', 'uploads/artisan_100.jpg', 4.72, NULL, 0, 'active'),
(171, 'Home Fragrance Maker 101', 'Artisan candles and room sprays.', 'Nairobi', '2025-05-24 12:16:36', 'uploads/artisan_101.jpg', 4.50, NULL, 0, 'active'),
(172, 'Artisan Jeweller 102', 'Handcrafted unique jewelry pieces.', 'Mombasa', '2025-05-24 12:16:36', 'uploads/artisan_102.jpg', 4.80, NULL, 0, 'active'),
(173, 'Gourmet Snack Creator 103', 'Healthy and delicious artisan snacks.', 'Kisumu', '2025-05-24 12:16:36', 'uploads/artisan_103.jpg', 4.90, NULL, 0, 'active'),
(174, 'Beard Care Artisan 104', 'Natural beard oils and balms.', 'Nanyuki', '2025-05-24 12:16:36', 'uploads/artisan_104.jpg', 4.70, NULL, 0, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(3, 10, 1, 1, '2025-05-18 12:46:29'),
(7, 11, 1, 1, '2025-05-19 11:37:23'),
(8, 11, 1, 1, '2025-05-19 17:56:16'),
(28, 1, 533, 1, '2025-05-26 16:47:54'),
(29, 1, 548, 1, '2025-05-26 16:50:51'),
(30, 1, 527, 1, '2025-05-29 06:15:45');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image_url`) VALUES
(1, 'Decor', 'https://via.placeholder.com/150?text=Decor'),
(2, 'Textiles', 'https://via.placeholder.com/150?text=Textiles'),
(3, 'Food', 'https://via.placeholder.com/150?text=Food'),
(4, 'Personal Care', 'https://via.placeholder.com/150?text=Personal Care');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('Processing','Delivered','Cancelled') DEFAULT 'Processing',
  `tracking_number` varchar(255) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `delivery_option` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) DEFAULT 'pending',
  `checkout_request_id` varchar(100) DEFAULT NULL,
  `mpesa_phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `tracking_number`, `payment_method`, `delivery_option`, `created_at`, `payment_status`, `checkout_request_id`, `mpesa_phone_number`) VALUES
(1, 1, 650.00, 'Processing', NULL, 'mpesa', 'Nairobi - Westlands Shop', '2025-05-20 08:44:31', 'pending', NULL, NULL),
(2, 1, 650.00, 'Processing', NULL, 'mpesa', 'Nairobi - CBD Shop', '2025-05-20 09:42:26', 'pending', NULL, NULL),
(3, 1, 150.00, 'Processing', NULL, 'mpesa', 'Nairobi - CBD Shop', '2025-05-20 12:41:50', 'pending', NULL, NULL),
(4, 1, 150.00, 'Processing', NULL, 'mpesa', 'Nairobi - CBD Shop', '2025-05-20 12:43:49', 'pending', NULL, NULL),
(5, 1, 150.00, 'Processing', NULL, 'mpesa', 'Nairobi - CBD Shop', '2025-05-20 12:45:17', 'pending', NULL, NULL),
(6, 9, 200.00, '', '001', 'mpesa', 'Nairobi - CBD Shop', '2025-05-20 15:39:19', 'pending', NULL, NULL),
(7, 1, 500.00, '', NULL, NULL, NULL, '2025-05-21 09:44:00', 'pending', NULL, NULL),
(8, 1, 2000.00, '', NULL, NULL, NULL, '2025-05-21 21:17:42', 'pending', NULL, NULL),
(9, 1, 2000.00, '', NULL, NULL, NULL, '2025-05-21 21:21:04', 'pending', NULL, NULL),
(10, 1, 500.00, '', NULL, NULL, NULL, '2025-05-22 12:39:12', 'pending', NULL, NULL),
(11, 1, 500.00, '', NULL, NULL, NULL, '2025-05-22 12:50:33', 'pending', NULL, NULL),
(12, 1, 200.00, '', NULL, 'mobile_money', NULL, '2025-05-22 13:16:10', 'pending', NULL, '+254768581254'),
(13, 1, 500.00, '', NULL, 'mobile_money', NULL, '2025-05-22 13:45:11', 'pending', NULL, '+254768581254'),
(14, 1, 160.00, '', NULL, 'mobile_money', NULL, '2025-05-24 15:32:53', 'pending', 'ws_CO_24052025183346845768581254', '+254768581254'),
(15, 1, 0.00, '', NULL, 'mobile_money', NULL, '2025-05-24 15:33:56', 'pending', NULL, '0768581254'),
(16, 1, 50.00, '', NULL, 'mobile_money', NULL, '2025-05-26 08:24:56', 'pending', 'ws_CO_26052025112727491768581254', '+254768581254'),
(17, 1, 4430.00, '', NULL, 'mobile_money', NULL, '2025-05-26 13:15:55', 'pending', 'ws_CO_26052025161837463768581254', '+254768581254'),
(18, 1, 0.00, '', NULL, 'mobile_money', NULL, '2025-05-26 13:16:29', 'pending', NULL, '+254768581254');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 9, 2, 4, 500.00),
(2, 10, 2, 1, 500.00),
(3, 11, 2, 1, 500.00),
(4, 12, 3, 1, 200.00),
(5, 13, 2, 1, 500.00),
(6, 14, 526, 1, 80.00),
(7, 14, 526, 1, 80.00),
(8, 16, 527, 1, 50.00),
(9, 17, 527, 1, 50.00),
(10, 17, 536, 1, 130.00),
(11, 17, 528, 1, 750.00),
(12, 17, 429, 1, 3500.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 150.00),
(2, 1, 2, 1, 500.00),
(3, 2, 1, 1, 150.00),
(4, 2, 2, 1, 500.00),
(5, 3, 1, 1, 150.00),
(6, 4, 1, 1, 150.00),
(7, 5, 1, 1, 150.00),
(8, 6, 3, 1, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `artisan_id` int(11) DEFAULT NULL,
  `status` enum('Pending','Approved') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_featured` tinyint(1) DEFAULT 0,
  `category` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `artisan_id`, `status`, `created_at`, `is_featured`, `category`, `quantity`) VALUES
(1, 'Shanga', 'COLOURFUL ', 150.00, 'images/default_product.png', 4, 'Approved', '2025-05-18 12:29:33', 0, 'Decor', 10),
(2, 'PAINTING', 'COLOURFUL', 500.00, 'images/default_product.png', 4, 'Approved', '2025-05-18 12:43:06', 0, 'Decor', 10),
(3, 'Pilau', 'spicy', 200.00, 'images/default_product.png', 3, 'Approved', '2025-05-20 15:32:12', 0, 'Food', 10),
(4, 'Pilau', 'spicy', 200.00, 'images/default_product.png', 3, 'Approved', '2025-05-20 15:37:53', 0, 'Food', 10),
(5, 'Handcrafted Vase', 'A beautiful ceramic vase, perfect for home decor.', 25.99, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(6, 'Artisan Scarf', 'Soft and luxurious hand-woven scarf.', 45.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(7, 'Homemade Jam', 'Sweet and fruity homemade strawberry jam.', 8.50, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(8, 'Natural Soap Bar', 'Handmade soap with essential oils.', 6.25, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(9, 'Decorative Pillow', 'Comfortable and stylish throw pillow.', 18.75, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(10, 'Embroidered Tablecloth', 'Elegant tablecloth with intricate embroidery.', 55.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(11, 'Artisanal Bread', 'Freshly baked sourdough bread.', 7.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(12, 'Bath Bomb Set', 'Relaxing bath bombs with various scents.', 12.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(13, 'Wooden Carving', 'Unique hand-carved wooden sculpture.', 75.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(14, 'Knitted Blanket', 'Warm and cozy hand-knitted blanket.', 80.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(15, 'Organic Honey', 'Pure, unfiltered local honey.', 15.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(16, 'Body Lotion', 'Nourishing body lotion with natural ingredients.', 10.50, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(17, 'Ceramic Mug', 'Hand-painted ceramic coffee mug.', 14.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(18, 'Woven Basket', 'Utility basket woven from natural fibers.', 30.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(19, 'Spiced Nuts', 'Delicious blend of roasted and spiced nuts.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(20, 'Essential Oil Diffuser', 'Aromatherapy diffuser with calming oils.', 22.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(21, 'Wall Art Print', 'Original print on high-quality paper.', 40.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(22, 'Silk Tie-Dye Scarf', 'Vibrant silk scarf with unique tie-dye pattern.', 35.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(23, 'Gourmet Chocolate Bar', 'Rich dark chocolate with sea salt.', 5.75, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(24, 'Hand Sanitizer', 'Alcohol-based hand sanitizer with aloe vera.', 4.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(25, 'Scented Candle', 'Soy wax candle with a calming lavender scent.', 16.50, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(26, 'Crocheted Coasters', 'Set of four colorful crocheted coasters.', 11.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(27, 'Herbal Tea Blend', 'Soothing herbal tea blend for relaxation.', 13.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(28, 'Shampoo Bar', 'Eco-friendly shampoo bar for healthy hair.', 9.50, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(29, 'Small Sculpture', 'Abstract metal sculpture for desk decor.', 60.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(30, 'Hand-painted Silk Fan', 'Elegant folding fan with hand-painted silk.', 28.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(31, 'Artisan Coffee Beans', 'Freshly roasted single-origin coffee beans.', 19.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(32, 'Face Mask', 'Hydrating clay face mask.', 17.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(33, 'Decorative Tray', 'Wooden tray with intricate inlay design.', 38.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(34, 'Linen Napkins Set', 'Set of six pure linen dinner napkins.', 26.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(35, 'Homemade Granola', 'Crunchy granola with oats and dried fruits.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(36, 'Lip Balm Set', 'Assorted natural lip balms.', 7.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(37, 'Terracotta Planter', 'Hand-painted terracotta plant pot.', 20.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(38, 'Quilted Wall Hanging', 'Small decorative wall hanging with patchwork.', 48.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(39, 'Spicy Chili Oil', 'Homemade chili oil for an extra kick.', 11.50, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(40, 'Body Scrub', 'Exfoliating sugar body scrub.', 14.50, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(41, 'Ceramic Bowl Set', 'Set of two unique ceramic serving bowls.', 33.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(42, 'Hand-dyed Fabric Swatch', 'Sample of hand-dyed fabric for crafting.', 9.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(43, 'Artisan Cookies', 'Assorted gourmet cookies.', 12.50, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(44, 'Facial Serum', 'Anti-aging facial serum with vitamin C.', 29.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(45, 'Glass Coasters', 'Set of elegant glass coasters.', 17.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(46, 'Hand-stitched Pouch', 'Small fabric pouch with intricate stitching.', 21.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(47, 'Specialty Tea Bags', 'Box of unique flavored tea bags.', 7.50, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(48, 'Hair Conditioner Bar', 'Solid conditioner bar for eco-conscious care.', 10.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(49, 'Abstract Painting', 'Small canvas with abstract art.', 90.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(50, 'Embroidered Table Runner', 'Long table runner with detailed embroidery.', 42.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(51, 'Homemade Pickles', 'Tangy and crunchy homemade pickles.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(52, 'Body Oil', 'Lightweight moisturizing body oil.', 19.50, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(53, 'Metal Sculpture', 'Modern desk sculpture.', 55.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(54, 'Patchwork Quilt', 'Colorful handmade patchwork quilt.', 120.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(55, 'Dried Fruit Mix', 'Healthy and delicious dried fruit snack mix.', 14.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(56, 'Foot Cream', 'Refreshing foot cream for tired feet.', 11.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(57, 'Decorative Bowl', 'Hand-painted decorative ceramic bowl.', 28.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(58, 'Hand-Woven Placemats', 'Set of four hand-woven placemats.', 24.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(59, 'Gourmet Popcorn', 'Sweet and savory gourmet popcorn.', 6.50, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(60, 'Hand Cream', 'Moisturizing hand cream with shea butter.', 8.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(61, 'Photo Frame', 'Artisan crafted wooden photo frame.', 22.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(62, 'Linen Kitchen Towel', 'Absorbent linen kitchen towel with unique design.', 15.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(63, 'Homemade Muesli', 'Nutritious breakfast muesli with nuts and seeds.', 16.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(64, 'Body Wash', 'Gentle and fragrant body wash.', 13.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(65, 'Dream Catcher', 'Handmade dream catcher with feathers and beads.', 32.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(66, 'Cotton Tote Bag', 'Durable cotton tote bag with printed design.', 20.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(67, 'Flavored Olive Oil', 'Infused olive oil with herbs and garlic.', 18.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(68, 'Face Cleanser', 'Gentle foaming face cleanser.', 15.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(69, 'Candle Holder', 'Rustic metal candle holder.', 19.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(70, 'Wool Socks', 'Warm and cozy hand-knitted wool socks.', 10.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(71, 'Spiced Tea Blend', 'Aromatic black tea with cinnamon and cardamom.', 11.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(72, 'Aftershave Balm', 'Soothing aftershave balm for sensitive skin.', 16.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(73, 'Decorative Clock', 'Unique wall clock made from reclaimed wood.', 65.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(74, 'Embroidered Cushion Cover', 'Cushion cover with intricate floral embroidery.', 25.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(75, 'Fruit Leather', 'Healthy and chewy fruit leather snacks.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(76, 'Hair Serum', 'Silkening hair serum for frizz control.', 20.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(77, 'Ceramic Plate Set', 'Set of four artisanal ceramic plates.', 50.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(78, 'Macrame Wall Hanging', 'Bohemian style macrame wall art.', 37.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(79, 'Artisan Chocolate Truffles', 'Box of gourmet chocolate truffles.', 25.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(80, 'Deodorant Stick', 'Natural deodorant stick with long-lasting freshness.', 10.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(81, 'Miniature Garden Decor', 'Small decorative items for miniature gardens.', 13.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(82, 'Hand-painted Silk Scarf', 'Luxurious silk scarf with a unique hand-painted design.', 50.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(83, 'Homemade Salsa', 'Fresh and zesty homemade salsa.', 8.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(84, 'Sunscreen Lotion', 'Mineral-based sunscreen lotion.', 18.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(85, 'Resin Coasters', 'Set of unique resin art coasters.', 20.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(86, 'Knitted Baby Blanket', 'Soft and cozy hand-knitted baby blanket.', 60.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(87, 'Gourmet Coffee Blend', 'Rich and aromatic gourmet coffee blend.', 22.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(88, 'Eye Cream', 'Nourishing eye cream for delicate skin.', 27.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(89, 'Ceramic Flower Pot', 'Hand-thrown ceramic flower pot.', 25.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(90, 'Woven Tapestry', 'Small decorative woven tapestry.', 40.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(91, 'Artisan Pasta', 'Homemade artisanal pasta.', 15.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(92, 'Shower Gel', 'Refreshing shower gel with natural fragrances.', 12.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(93, 'Wooden Bookends', 'Hand-carved wooden bookends.', 35.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(94, 'Dye Kit', 'Natural dye kit for fabrics.', 28.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(95, 'Fruit Jam Assortment', 'Sampler pack of assorted fruit jams.', 20.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(96, 'Perfume Oil', 'Roll-on perfume oil with a unique scent.', 30.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(97, 'Decorative Mirror', 'Small mirror with an ornate frame.', 45.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(98, 'Felted Coasters', 'Colorful felted wool coasters.', 16.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(99, 'Herbal Infused Vinegar', 'Vinegar infused with culinary herbs.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(100, 'Beard Oil', 'Nourishing beard oil for a healthy beard.', 14.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(101, 'Table Lamp', 'Artisan crafted small table lamp.', 70.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(102, 'Hand-printed Tea Towel', 'Cotton tea towel with a unique hand-printed design.', 16.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(103, 'Homemade Ketchup', 'Rich and flavorful homemade tomato ketchup.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(104, 'Face Toner', 'Balancing face toner with rose water.', 17.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(105, 'Ceramic Figurine', 'Small decorative ceramic animal figurine.', 18.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(106, 'Crocheted Potholders', 'Set of two durable crocheted potholders.', 12.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(107, 'Gourmet Crackers', 'Artisanal crackers perfect for cheese.', 7.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(108, 'Hair Mask', 'Deep conditioning hair mask.', 21.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(109, 'Decorative Vase', 'Glass vase with a unique etched design.', 30.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(110, 'Embroidered Denim Jacket', 'Unique denim jacket with custom embroidery.', 95.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(111, 'Artisan Granola Bars', 'Homemade granola bars for a healthy snack.', 15.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(112, 'Body Mist', 'Light and refreshing body mist.', 14.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(113, 'Wall Decal', 'Artistic wall decal for modern decor.', 25.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(114, 'Hand-knitted Scarf', 'Warm and stylish hand-knitted scarf.', 38.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(115, 'Homemade Hot Sauce', 'Fiery hot sauce with unique flavor.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(116, 'Facial Cleansing Brush', 'Gentle facial cleansing brush.', 23.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(117, 'Sculptural Candle', 'Uniquely shaped decorative candle.', 17.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(118, 'Fabric Coasters', 'Set of colorful fabric coasters.', 10.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(119, 'Gourmet Vinegar', 'Artisanal fruit-infused vinegar.', 12.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(120, 'Shaving Cream', 'Rich lathering shaving cream.', 11.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(121, 'Decorative Plates', 'Set of two decorative wall plates.', 40.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(122, 'Hand-dyed Silk Ribbon', 'Set of various hand-dyed silk ribbons.', 15.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(123, 'Homemade Cookies', 'Assorted classic homemade cookies.', 13.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(124, 'After Sun Lotion', 'Soothing after-sun lotion with aloe.', 16.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(125, 'Ceramic Wall Planter', 'Small wall-mounted ceramic planter.', 22.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(126, 'Embroidered Hand Towel', 'Soft hand towel with decorative embroidery.', 18.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(127, 'Artisan Bread Sticks', 'Crispy homemade bread sticks.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(128, 'Exfoliating Mitt', 'Gentle exfoliating mitt for body care.', 7.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(129, 'Decorative Tray Table', 'Small decorative tray table.', 80.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(130, 'Quilted Coasters', 'Set of four colorful quilted coasters.', 14.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(131, 'Spiced Nuts Mix', 'Bag of mixed spiced nuts.', 11.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(132, 'Cuticle Oil', 'Nourishing cuticle oil for nail care.', 6.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(133, 'Abstract Art Coasters', 'Set of four resin abstract art coasters.', 24.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(134, 'Hand-woven Rug', 'Small hand-woven accent rug.', 70.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(135, 'Gourmet Mustard', 'Stone-ground gourmet mustard.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(136, 'Bath Salts', 'Relaxing bath salts with essential oils.', 15.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(137, 'Geometric Candle Holders', 'Set of two modern geometric candle holders.', 30.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(138, 'Knitted Throw Pillow', 'Cozy knitted throw pillow cover.', 28.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(139, 'Homemade Energy Bites', 'Healthy energy bites with oats and dates.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(140, 'Hair Oil', 'Nourishing hair oil for shine and strength.', 19.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(141, 'Decorative Ceramic Tile', 'Single decorative ceramic tile for display.', 12.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(142, 'Printed Fabric Tote Bag', 'Stylish tote bag with a unique fabric print.', 25.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(143, 'Artisan Crackers Assortment', 'Variety pack of artisanal crackers.', 14.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(144, 'Body Butter', 'Rich and creamy body butter for dry skin.', 22.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(145, 'Glass Art Sculpture', 'Small glass art sculpture.', 50.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(146, 'Embroidered Wall Hanging', 'Medium-sized wall hanging with detailed embroidery.', 55.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(147, 'Homemade Flavored Syrup', 'Maple syrup infused with spices.', 16.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(148, 'Hand Soap', 'Liquid hand soap with moisturizing agents.', 8.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(149, 'Decorative Birds', 'Set of two small decorative bird figurines.', 16.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(150, 'Linen Bread Bag', 'Reusable linen bag for storing bread.', 11.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(151, 'Dried Herb Mix', 'Aromatic dried herb mix for cooking.', 7.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(152, 'Clay Face Mask', 'Purifying clay face mask.', 15.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(153, 'Metal Wall Art', 'Geometric metal wall art piece.', 60.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(154, 'Hand-stitched Tote Bag', 'Unique tote bag with hand-stitched details.', 30.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(155, 'Artisan Coffee Ground', 'Freshly ground artisanal coffee.', 18.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(156, 'Hand Cream Set', 'Set of three travel-sized hand creams.', 20.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(157, 'Small Plant Pot', 'Miniature decorative plant pot.', 10.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(158, 'Embroidered Bookmark', 'Hand-embroidered fabric bookmark.', 5.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(159, 'Gourmet Salt Blend', 'Specialty salt blend with herbs and spices.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(160, 'Body Lotion Bar', 'Solid moisturizing lotion bar.', 12.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(161, 'Decorative Orb Set', 'Set of three decorative orbs for display.', 25.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(162, 'Knitted Dishcloths', 'Set of three reusable knitted dishcloths.', 13.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(163, 'Artisan Chocolate Bar', 'Premium artisanal chocolate bar.', 7.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(164, 'Shampoo for Sensitive Scalp', 'Gentle shampoo for sensitive scalp.', 16.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(165, 'Wooden Wall Shelf', 'Small wooden wall shelf for display.', 35.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(166, 'Patchwork Oven Mitt', 'Colorful patchwork oven mitt.', 15.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(167, 'Homemade Pickled Vegetables', 'Jar of assorted pickled vegetables.', 11.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(168, 'Conditioner for Dry Hair', 'Deep moisturizing conditioner for dry hair.', 17.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(169, 'Ceramic Spoon Rest', 'Hand-painted ceramic spoon rest.', 14.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(170, 'Hand-printed Cushion Cover', 'Cushion cover with a unique block print.', 27.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(171, 'Gourmet Hot Chocolate Mix', 'Rich hot chocolate mix with spices.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(172, 'Body Powder', 'Finely milled body powder with light scent.', 9.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(173, 'Decorative Stone Coasters', 'Set of four polished stone coasters.', 20.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(174, 'Embroidered Apron', 'Stylish apron with custom embroidery.', 30.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(175, 'Artisan Herbal Tea', 'Loose leaf herbal tea blend.', 13.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(176, 'Face Mask Sheet Set', 'Set of five hydrating face mask sheets.', 25.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(177, 'Resin Art Tray', 'Small serving tray with unique resin art.', 40.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(178, 'Hand-woven Wall Basket', 'Decorative wall basket for storage.', 35.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(179, 'Gourmet Caramel Sauce', 'Rich homemade caramel sauce.', 12.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(180, 'Dental Floss', 'Eco-friendly biodegradable dental floss.', 5.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(181, 'Decorative Lantern', 'Small decorative lantern for ambiance.', 28.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(182, 'Knitted Shawl', 'Warm and elegant hand-knitted shawl.', 65.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(183, 'Homemade Apple Butter', 'Sweet and spicy apple butter.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(184, 'Body Oil Spray', 'Lightweight body oil in a spray bottle.', 18.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(185, 'Ceramic Trinket Dish', 'Small ceramic dish for jewelry or keys.', 15.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(186, 'Embroidered Tote Bag', 'Cotton tote bag with unique embroidery.', 28.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(187, 'Artisan Spiced Nuts', 'Bag of mixed spiced nuts.', 12.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(188, 'Hand Sanitizer Spray', 'Refreshing hand sanitizer spray.', 6.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(189, 'Wooden Serving Board', 'Hand-crafted wooden serving board.', 45.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(190, 'Linen Tea Towel Set', 'Set of two high-quality linen tea towels.', 20.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(191, 'Gourmet Caramel Corn', 'Sweet and crunchy gourmet caramel corn.', 8.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(192, 'Beard Balm', 'Conditioning beard balm for styling.', 15.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(193, 'Abstract Sculpture', 'Modern abstract tabletop sculpture.', 70.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(194, 'Hand-printed Scarf', 'Cotton scarf with a unique block print.', 32.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(195, 'Homemade Croutons', 'Crispy homemade croutons for salads.', 7.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(196, 'Face Mist', 'Hydrating face mist with rosewater.', 14.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(197, 'Ceramic Mug Set', 'Set of two hand-painted ceramic mugs.', 30.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(198, 'Woven Storage Basket', 'Large hand-woven basket for storage.', 50.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(199, 'Artisan Pasta Sauce', 'Rich homemade pasta sauce with fresh tomatoes.', 16.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(200, 'Body Spray', 'Light and refreshing body spray.', 10.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(201, 'Decorative Pillar Candle', 'Large decorative pillar candle.', 20.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(202, 'Embroidered Wall Banner', 'Small decorative wall banner with embroidery.', 22.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(203, 'Gourmet Honey Mustard', 'Sweet and tangy gourmet honey mustard.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(204, 'Lip Scrub', 'Exfoliating lip scrub for smooth lips.', 8.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(205, 'Small Abstract Painting', 'Miniature abstract painting on canvas.', 40.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(206, 'Hand-knitted Baby Booties', 'Soft hand-knitted baby booties.', 18.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(207, 'Homemade Granola Cereal', 'Crunchy granola for breakfast.', 11.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(208, 'Shaving Brush', 'Classic shaving brush with soft bristles.', 15.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(209, 'Decorative Tray with Handles', 'Wooden tray with metal handles.', 35.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(210, 'Crocheted Blanket', 'Large and cozy hand-crocheted blanket.', 90.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(211, 'Artisan Chocolate Spread', 'Rich and creamy chocolate spread.', 14.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(212, 'Facial Moisturizer', 'Lightweight facial moisturizer for daily use.', 20.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(213, 'Glass Tealight Holders', 'Set of three small glass tealight holders.', 12.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(214, 'Printed Canvas Bag', 'Durable canvas bag with artistic print.', 22.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(215, 'Gourmet Hot Sauce Set', 'Sampler set of three gourmet hot sauces.', 25.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(216, 'Hair Gel', 'Styling hair gel with strong hold.', 9.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(217, 'Decorative Sculpture', 'Small abstract metal sculpture.', 48.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(218, 'Hand-dyed Yarn Skein', 'Skein of hand-dyed wool yarn.', 10.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(219, 'Homemade Jam Assortment', 'Gift set of assorted homemade jams.', 28.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(220, 'Body Exfoliator', 'Gentle body exfoliator for smooth skin.', 16.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(221, 'Ceramic Plant Pot Set', 'Set of three small ceramic plant pots.', 32.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(222, 'Linen Table Runner', 'Natural linen table runner.', 30.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(223, 'Artisan Coffee Sampler', 'Sampler pack of different coffee blends.', 20.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(224, 'Deodorant Spray', 'Natural deodorant spray.', 11.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(225, 'Wooden Trinket Box', 'Small wooden box for trinkets.', 20.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(226, 'Embroidered Bookmark Set', 'Set of three hand-embroidered bookmarks.', 12.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(227, 'Gourmet Honey', 'Small jar of gourmet local honey.', 13.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(228, 'Perfume Atomizer', 'Refillable perfume atomizer.', 9.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(229, 'Metal Planter Stand', 'Stylish metal stand for plants.', 40.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(230, 'Hand-stitched Potholders', 'Set of two hand-stitched potholders.', 15.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(231, 'Homemade Granola Bars Set', 'Pack of assorted homemade granola bars.', 16.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(232, 'Body Wash Bar', 'Solid body wash bar for travel.', 10.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(233, 'Abstract Ceramic Vase', 'Modern abstract ceramic vase.', 35.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(234, 'Knitted Fingerless Gloves', 'Warm and practical fingerless gloves.', 20.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(235, 'Artisan Cookies Assortment', 'Variety box of artisanal cookies.', 18.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(236, 'Face Wash', 'Gentle and refreshing face wash.', 12.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(237, 'Decorative Feather Art', 'Framed art piece with real feathers.', 55.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(238, 'Embroidered Denim Pouch', 'Small denim pouch with unique embroidery.', 18.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(239, 'Gourmet Popcorn Kernels', 'Bag of gourmet popcorn kernels.', 7.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(240, 'Body Oil Rollerball', 'Convenient body oil rollerball for on-the-go.', 13.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(241, 'Ceramic Wall Decor', 'Small circular ceramic wall decoration.', 20.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(242, 'Hand-dyed Silk Scrunchie', 'Stylish silk scrunchie with hand-dyed pattern.', 8.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(243, 'Homemade Spiced Apple Rings', 'Dried spiced apple rings snack.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(244, 'Hair Conditioner', 'Creamy hair conditioner for all hair types.', 15.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(245, 'Wooden Coaster Set', 'Set of four hand-carved wooden coasters.', 18.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(246, 'Printed Fabric Art', 'Small framed fabric art piece.', 30.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(247, 'Artisan Bread Mix', 'Pre-made mix for baking artisanal bread.', 12.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(248, 'Lip Tint', 'Natural lip tint for a subtle pop of color.', 11.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(249, 'Decorative Wall Hook', 'Unique decorative wall hook.', 15.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(250, 'Linen Tote Bag', 'Simple and elegant linen tote bag.', 28.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(251, 'Gourmet Popcorn Seasoning', 'Set of three gourmet popcorn seasonings.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(252, 'Face Scrub', 'Gentle exfoliating face scrub.', 17.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(253, 'Resin Art Coasters', 'Set of four resin art coasters with glitter.', 22.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(254, 'Hand-knitted Beanie', 'Warm and stylish hand-knitted beanie.', 25.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(255, 'Homemade Granola Trail Mix', 'Nutrient-rich trail mix with granola.', 14.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(256, 'Body Lotion Pump', 'Large bottle of moisturizing body lotion with pump.', 25.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(257, 'Small Wooden Tray', 'Rustic small wooden tray.', 20.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(258, 'Embroidered Kitchen Towel', 'Decorative kitchen towel with embroidery.', 16.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(259, 'Artisan Pickled Onions', 'Jar of sweet and tangy pickled onions.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(260, 'Hair Styling Cream', 'Cream for styling and taming frizz.', 13.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(261, 'Ceramic Salt Cellar', 'Small ceramic salt cellar with lid.', 15.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(262, 'Hand-printed Tote Bag', 'Canvas tote bag with a custom block print.', 28.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(263, 'Gourmet Chocolate Drops', 'Bag of gourmet chocolate baking drops.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(264, 'Face Serum with Hyaluronic Acid', 'Hydrating face serum.', 32.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(265, 'Decorative Candle Snuffer', 'Elegant metal candle snuffer.', 18.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(266, 'Knitted Headband', 'Warm and stylish knitted headband.', 12.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(267, 'Homemade Fruit Jellies', 'Assorted homemade fruit jellies.', 11.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(268, 'Shampoo Bar Holder', 'Wooden holder for shampoo bars.', 7.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(269, 'Wooden Photo Album', 'Hand-bound wooden photo album.', 40.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(270, 'Embroidered Wall Art', 'Small framed wall art with embroidery.', 30.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(271, 'Artisan Bread Starter', 'Active sourdough bread starter.', 15.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(272, 'Body Butter Stick', 'Solid body butter stick for easy application.', 19.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(273, 'Glass Coasters Set', 'Set of four clear glass coasters.', 16.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(274, 'Hand-woven Dish Towel', 'Absorbent hand-woven dish towel.', 14.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(275, 'Gourmet Coffee Syrup', 'Flavored syrup for coffee drinks.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(276, 'Dental Tabs', 'Eco-friendly solid toothpaste tabs.', 8.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(277, 'Decorative Books', 'Set of three decorative faux books.', 25.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(278, 'Linen Bread Basket Liner', 'Linen liner for bread baskets.', 9.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(279, 'Homemade Fruit Compote', 'Sweet fruit compote for desserts.', 12.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(280, 'Body Brush', 'Natural bristle body brush for exfoliation.', 15.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(281, 'Small Metal Vase', 'Miniature metal vase for single flowers.', 12.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(282, 'Embroidered Coasters', 'Set of four embroidered fabric coasters.', 10.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(283, 'Artisan Honeycomb', 'Piece of natural honeycomb.', 20.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(284, 'Bath Oil', 'Luxurious bath oil for a relaxing soak.', 18.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(285, 'Ceramic Ring Dish', 'Small ceramic dish for rings.', 8.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(286, 'Hand-printed Scarf', 'Cotton scarf with unique botanical print.', 35.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(287, 'Gourmet Chocolate Covered Pretzels', 'Bag of chocolate-covered pretzels.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(288, 'Hair Mousse', 'Volumizing hair mousse.', 11.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(289, 'Decorative Tray Organizer', 'Tray with compartments for organization.', 28.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(290, 'Knitted Pot Holders', 'Set of two thick knitted pot holders.', 14.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(291, 'Homemade Fruit Preserves', 'Jar of sweet fruit preserves.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(292, 'Facial Cleansing Oil', 'Oil-based facial cleanser.', 20.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(293, 'Wall Sculpture', 'Small decorative wall sculpture.', 45.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(294, 'Embroidered Tablecloth Small', 'Small tablecloth with delicate embroidery.', 40.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(295, 'Artisan Tea Blends', 'Sampler set of artisanal tea blends.', 18.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(296, 'Hand Cream Travel Size', 'Travel-sized hand cream.', 7.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(297, 'Decorative Ceramic Coasters', 'Set of four hand-painted ceramic coasters.', 20.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(298, 'Hand-woven Scarf', 'Soft hand-woven scarf with fringed edges.', 48.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(299, 'Gourmet Dried Fruit', 'Bag of premium gourmet dried fruit.', 15.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(300, 'Body Lotion with SPF', 'Moisturizing body lotion with sun protection.', 22.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(301, 'Wooden Wall Decor', 'Decorative wooden wall art piece.', 30.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(302, 'Embroidered Drawstring Bag', 'Small fabric bag with custom embroidery.', 15.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(303, 'Artisan Spiced Honey', 'Honey infused with warm spices.', 16.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(304, 'Hair Spray', 'Flexible hold hair spray.', 10.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(305, 'Ceramic Incense Holder', 'Decorative ceramic incense holder.', 10.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(306, 'Hand-printed Pillowcase', 'Pillowcase with a unique hand-printed design.', 20.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(307, 'Homemade Chili Paste', 'Spicy homemade chili paste.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(308, 'Body Cleansing Bar', 'Large cleansing bar for the body.', 8.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(309, 'Glass Decor Piece', 'Small decorative glass art piece.', 25.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(310, 'Knitted Doll Clothes', 'Set of hand-knitted doll clothes.', 18.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(311, 'Gourmet Pretzel Bites', 'Bag of gourmet pretzel bites.', 7.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(312, 'Face Cream', 'Rich moisturizing face cream for night.', 28.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10);
INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `artisan_id`, `status`, `created_at`, `is_featured`, `category`, `quantity`) VALUES
(313, 'Decorative Bird Cage', 'Small decorative bird cage for display.', 30.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(314, 'Embroidered Pencil Case', 'Fabric pencil case with cute embroidery.', 12.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(315, 'Artisan Spice Blend', 'Unique spice blend for cooking.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(316, 'Hand Soap Refill', 'Large refill pouch for hand soap.', 15.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(317, 'Wooden Clock', 'Rustic wooden desk clock.', 38.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(318, 'Linen Makeup Bag', 'Small linen bag for makeup.', 16.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(319, 'Homemade Mustard', 'Spicy homemade mustard.', 8.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(320, 'Body Spray Set', 'Set of three different body sprays.', 25.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(321, 'Abstract Glass Vase', 'Modern abstract glass vase.', 40.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(322, 'Hand-stitched Cushion', 'Small cushion with decorative hand-stitching.', 30.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(323, 'Gourmet Nut Butter', 'Homemade gourmet nut butter.', 18.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(324, 'Facial Roller', 'Jade facial roller for massage.', 20.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(325, 'Ceramic Bud Vase', 'Tiny ceramic vase for a single bud.', 10.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(326, 'Embroidered Eyeglass Case', 'Fabric case for eyeglasses with embroidery.', 14.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(327, 'Artisan Dried Herbs', 'Bag of aromatic dried culinary herbs.', 7.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(328, 'Hand Sanitizer Gel', 'Portable hand sanitizer gel.', 5.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(329, 'Wooden Picture Frame', 'Rustic wooden picture frame.', 22.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(330, 'Knitted Baby Hat', 'Cute hand-knitted baby hat.', 15.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(331, 'Homemade Snack Mix', 'Sweet and savory homemade snack mix.', 12.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(332, 'Body Scrub Bar', 'Solid exfoliating body scrub bar.', 11.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(333, 'Decorative Stone Sculpture', 'Small polished stone sculpture.', 50.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(334, 'Hand-printed Scarf Large', 'Large cotton scarf with a detailed print.', 45.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(335, 'Gourmet Hot Cocoa Mix', 'Rich gourmet hot cocoa mix.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(336, 'Hair Detangler', 'Leave-in hair detangler spray.', 14.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(337, 'Ceramic Plant Hanger', 'Decorative ceramic plant hanger.', 25.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(338, 'Embroidered Wall Pocket', 'Fabric wall pocket with decorative embroidery.', 20.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(339, 'Artisan Infused Oil', 'Olive oil infused with garlic and chili.', 17.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(340, 'Lip Gloss', 'Shiny lip gloss with natural ingredients.', 9.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(341, 'Wooden Coaster with Design', 'Wooden coaster with carved design.', 6.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(342, 'Linen Hand Towel', 'Soft linen hand towel.', 12.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(343, 'Homemade Beef Jerky', 'Savory homemade beef jerky.', 20.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(344, 'Body Wash Sponge', 'Natural body wash sponge.', 7.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(345, 'Decorative Wall Plate', 'Hand-painted decorative wall plate.', 30.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(346, 'Knitted Mug Cozy', 'Cute knitted cozy for mugs.', 8.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(347, 'Gourmet Peanut Brittle', 'Sweet and crunchy peanut brittle.', 11.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(348, 'Facial Cleansing Wipes', 'Gentle facial cleansing wipes.', 9.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(349, 'Resin Bookmark', 'Unique bookmark made from resin.', 10.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(350, 'Embroidered Key Fob', 'Small fabric key fob with embroidery.', 7.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(351, 'Artisan Dried Fruit Assortment', 'Sampler pack of various dried fruits.', 18.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(352, 'Body Oil Mist', 'Light moisturizing body oil mist.', 15.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(353, 'Ceramic Soap Dish', 'Hand-painted ceramic soap dish.', 12.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(354, 'Hand-woven Trivet', 'Decorative and functional hand-woven trivet.', 16.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(355, 'Homemade Granola Clusters', 'Crunchy granola clusters for snacking.', 13.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(356, 'Hair Shine Serum', 'Serum for adding shine to hair.', 17.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(357, 'Decorative Bottle Stopper', 'Artistic bottle stopper.', 14.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(358, 'Printed Fabric Wall Art', 'Small framed fabric wall art.', 28.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(359, 'Gourmet Popcorn Gift Set', 'Gift set of various gourmet popcorn flavors.', 25.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(360, 'Body Milk', 'Light and hydrating body milk.', 19.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(361, 'Wooden Incense Box', 'Wooden box for storing and burning incense.', 18.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(362, 'Knitted Scarf and Hat Set', 'Matching hand-knitted scarf and hat set.', 55.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(363, 'Artisan Hot Cocoa Bombs', 'Set of two gourmet hot cocoa bombs.', 15.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(364, 'Hand Cream with SPF', 'Hand cream with sun protection.', 12.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(365, 'Decorative Ceramic Figurine', 'Unique ceramic animal figurine.', 22.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(366, 'Embroidered Tote Bag Large', 'Large tote bag with extensive embroidery.', 35.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(367, 'Gourmet Chocolate Bar Set', 'Set of three artisan chocolate bars.', 20.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(368, 'Foot Scrub', 'Exfoliating foot scrub for smooth feet.', 10.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(369, 'Abstract Wooden Sculpture', 'Small abstract wooden tabletop sculpture.', 60.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(370, 'Hand-dyed Silk Pillowcase', 'Luxury silk pillowcase with unique dye pattern.', 40.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(371, 'Homemade Energy Bars', 'Pack of healthy homemade energy bars.', 16.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(372, 'Body Mask', 'Hydrating body mask for soft skin.', 23.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(373, 'Glass Candle Holders', 'Set of two modern glass candle holders.', 18.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(374, 'Linen Dishcloths Set', 'Set of two absorbent linen dishcloths.', 15.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(375, 'Artisan Hot Sauce', 'Small batch artisan hot sauce.', 12.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(376, 'Aftershave Splash', 'Refreshing aftershave splash.', 14.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(377, 'Wooden Wall Clock', 'Hand-carved wooden wall clock.', 50.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(378, 'Embroidered Wall Pocket Organizer', 'Wall-mounted organizer with multiple pockets.', 25.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(379, 'Gourmet Vinegar Sampler', 'Set of three different gourmet vinegars.', 20.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(380, 'Shaving Soap', 'Traditional shaving soap in a tin.', 10.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(381, 'Ceramic Planter with Stand', 'Stylish ceramic planter with wooden stand.', 45.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(382, 'Hand-printed Tote Bag Medium', 'Medium-sized canvas tote bag with print.', 25.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(383, 'Homemade Pickled Green Beans', 'Jar of homemade pickled green beans.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(384, 'Body Scrub Brush', 'Natural bristle body scrub brush.', 11.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(385, 'Decorative Metal Tray', 'Ornate metal serving tray.', 32.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(386, 'Knitted Dish Scrubber', 'Durable knitted dish scrubber.', 6.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(387, 'Artisan Coffee Mug', 'Hand-painted ceramic coffee mug.', 18.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(388, 'Hand Cream Set Travel', 'Set of two travel-sized hand creams.', 15.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(389, 'Wooden Serving Bowl', 'Large hand-carved wooden serving bowl.', 55.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(390, 'Embroidered Key Ring', 'Small fabric key ring with embroidery.', 8.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(391, 'Gourmet Spice Rub', 'Homemade gourmet spice rub for meats.', 10.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(392, 'Lip Plumper', 'Lip plumping gloss.', 14.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(393, 'Resin Decorative Tray', 'Decorative tray with colorful resin design.', 38.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(394, 'Hand-knitted Baby Hat and Mittens', 'Matching baby hat and mittens set.', 25.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(395, 'Homemade Pickled Beets', 'Jar of sweet and tangy pickled beets.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(396, 'Body Soufflé', 'Light and airy body soufflé.', 20.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(397, 'Ceramic Cookie Jar', 'Decorative ceramic cookie jar.', 30.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(398, 'Embroidered Glasses Case', 'Soft fabric case for glasses with embroidery.', 12.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(399, 'Artisan Gourmet Popcorn', 'Small batch gourmet popcorn.', 8.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(400, 'Hair Setting Spray', 'Flexible hold hair setting spray.', 11.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(401, 'Decorative Bookends Unique', 'Unique artisan crafted bookends.', 42.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(402, 'Hand-printed Tablecloth', 'Medium-sized tablecloth with a custom print.', 60.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(403, 'Gourmet Flavored Popcorn', 'Bag of unique flavored gourmet popcorn.', 7.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(404, 'Face Sunscreen Stick', 'Convenient stick sunscreen for face.', 16.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(405, 'Wooden Key Holder', 'Wall-mounted wooden key holder.', 20.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(406, 'Knitted Pet Toy', 'Hand-knitted toy for pets.', 10.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(407, 'Homemade Jam Gift Set', 'Set of three small jars of homemade jams.', 22.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(408, 'Body Scrub Mitt', 'Exfoliating mitt for body scrub application.', 9.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(409, 'Decorative Ceramic Planter', 'Small decorative ceramic planter.', 15.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(410, 'Embroidered Wall Tapestry', 'Small wall tapestry with intricate embroidery.', 35.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(411, 'Artisan Spice Grinder', 'Ceramic grinder with unique spice blend.', 25.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(412, 'Hand Sanitizer Gel Travel', 'Travel-sized hand sanitizer gel.', 4.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(413, 'Glass Coasters Square', 'Set of four square glass coasters.', 17.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(414, 'Hand-stitched Wallet', 'Small fabric wallet with hand-stitching.', 20.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(415, 'Gourmet Hot Cocoa Bombs Set', 'Set of four different hot cocoa bombs.', 28.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(416, 'Body Lotion Pump Large', 'Large bottle of body lotion with pump.', 28.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(417, 'Wooden Desk Organizer', 'Desk organizer with multiple compartments.', 30.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(418, 'Knitted Dishcloth Set', 'Set of five colorful knitted dishcloths.', 18.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(419, 'Artisan Tea Sampler', 'Sampler set of various artisan tea blends.', 15.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(420, 'Face Oil', 'Nourishing face oil for radiant skin.', 25.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(421, 'Decorative Wall Basket', 'Round decorative wall basket.', 22.00, 'images/default_product.png', 1, 'Approved', '2025-05-24 12:01:16', 0, 'Decor', 10),
(422, 'Embroidered Drawstring Pouch', 'Small embroidered pouch for jewelry.', 10.00, 'images/default_product.png', 2, 'Approved', '2025-05-24 12:01:16', 0, 'Textiles', 10),
(423, 'Homemade Granola Bags', 'Individual bags of homemade granola.', 9.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:01:16', 0, 'Food', 10),
(424, 'Beard Brush', 'Natural bristle beard brush.', 13.00, 'images/default_product.png', 4, 'Approved', '2025-05-24 12:01:16', 0, 'Personal Care', 10),
(425, 'Hand-Painted Vase', 'A beautifully hand-painted ceramic vase, unique design.', 750.00, 'images/product_5.jpg', 5, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 10),
(426, 'Handwoven Scarf', 'Soft cotton handwoven scarf with traditional patterns.', 1200.00, 'images/product_6.jpg', 6, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 15),
(427, 'Artisan Honey Jar', 'Pure, raw, local honey from the Kenyan highlands.', 450.00, 'images/product_7.jpg', 7, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 20),
(428, 'Natural Rose Soap', 'Handmade soap with essential rose oil and shea butter.', 300.00, 'images/product_8.jpg', 8, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 25),
(429, 'Abstract Wall Art', 'Large abstract canvas painting, vibrant colors.', 3500.00, 'images/product_9.jpg', 9, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 5),
(430, 'Embroidered Cushion Cover', 'Exquisite embroidery on cotton cushion cover.', 850.00, 'images/product_10.jpg', 10, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 12),
(431, 'Homemade Granola', 'Crunchy granola with oats, nuts, and dried fruits.', 600.00, 'images/product_11.jpg', 11, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 18),
(432, 'Lavender Body Lotion', 'Nourishing body lotion with calming lavender scent.', 550.00, 'images/product_12.jpg', 12, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 22),
(433, 'Wooden Coaster Set', 'Set of 4 handcrafted wooden coasters.', 900.00, 'images/product_13.jpg', 13, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 10),
(434, 'Tie-Dye T-Shirt', 'Unisex cotton t-shirt with unique tie-dye design.', 1100.00, 'images/product_14.jpg', 14, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 15),
(435, 'Gourmet Spice Blend', 'Exotic spice blend for African cuisine.', 700.00, 'images/product_15.jpg', 15, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 20),
(436, 'Tea Tree Facial Cleanser', 'Gentle facial cleanser with purifying tea tree oil.', 650.00, 'images/product_16.jpg', 16, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 25),
(437, 'Metal Sculpture', 'Abstract desk sculpture made from recycled metal.', 2800.00, 'images/product_17.jpg', 17, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 7),
(438, 'Patchwork Quilt', 'Hand-stitched patchwork quilt, queen size.', 8000.00, 'images/product_18.jpg', 18, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 3),
(439, 'Artisan Chocolate Bar', 'Dark chocolate bar with chili and sea salt.', 400.00, 'images/product_19.jpg', 19, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 30),
(440, 'Charcoal Detox Mask', 'Deep cleansing charcoal face mask.', 750.00, 'images/product_20.jpg', 20, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 18),
(441, 'Hand-Blown Glass Vase', 'Elegant clear glass vase, unique organic shape.', 1500.00, 'images/product_21.jpg', 21, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 8),
(442, 'Knitted Throw Blanket', 'Cozy knitted throw blanket for sofa.', 2500.00, 'images/product_22.jpg', 22, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 10),
(443, 'Sourdough Bread Loaf', 'Freshly baked sourdough bread, rustic style.', 500.00, 'images/product_23.jpg', 23, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 20),
(444, 'Natural Deodorant Stick', 'Aluminum-free natural deodorant with citrus scent.', 400.00, 'images/product_24.jpg', 24, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 25),
(445, 'Ceramic Planter', 'Small ceramic planter with drainage hole.', 600.00, 'images/product_25.jpg', 25, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 15),
(446, 'Block Print Table Runner', 'Cotton table runner with hand block printed design.', 950.00, 'images/product_26.jpg', 26, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 12),
(447, 'Homemade Berry Jam', 'Sweet and tangy mixed berry jam, 250g.', 350.00, 'images/product_27.jpg', 27, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 20),
(448, 'Vanilla Soy Candle', 'Hand-poured soy candle with warm vanilla scent.', 800.00, 'images/product_28.jpg', 28, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 18),
(449, 'Recycled Bottle Art', 'Unique art piece made from recycled glass bottles.', 1800.00, 'images/product_29.jpg', 29, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 6),
(450, 'Crochet Baby Blanket', 'Soft and colorful crochet blanket for babies.', 1300.00, 'images/product_30.jpg', 30, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 10),
(451, 'Spicy Mango Chutney', 'Sweet and spicy mango chutney, 300g.', 500.00, 'images/product_31.jpg', 31, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 15),
(452, 'Shea Butter Body Balm', 'Intensive moisturizing body balm with shea butter.', 700.00, 'images/product_32.jpg', 32, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 20),
(453, 'Geometric Wall Decal', 'Modern geometric pattern wall decal.', 1000.00, 'images/product_33.jpg', 33, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 10),
(454, 'Hand-Embroidered Pouch', 'Small zippered pouch with floral embroidery.', 700.00, 'images/product_34.jpg', 34, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 15),
(455, 'Sun-Dried Tomato Paste', 'Rich sun-dried tomato paste, 200g.', 450.00, 'images/product_35.jpg', 35, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 18),
(456, 'Peppermint Foot Scrub', 'Exfoliating foot scrub with refreshing peppermint.', 600.00, 'images/product_36.jpg', 36, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 22),
(457, 'Resin Art Coasters', 'Set of 4 resin art coasters with glitter.', 1200.00, 'images/product_37.jpg', 37, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 9),
(458, 'Macrame Plant Hanger', 'Handmade macrame plant hanger, holds medium pot.', 800.00, 'images/product_38.jpg', 38, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 14),
(459, 'Gourmet Coffee Beans', 'Single origin Arabica coffee beans, 250g.', 900.00, 'images/product_39.jpg', 39, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 20),
(460, 'Organic Lip Balm Set', 'Set of 3 organic lip balms, assorted flavors.', 500.00, 'images/product_40.jpg', 40, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 25),
(461, 'Wire Tree Sculpture', 'Miniature wire tree sculpture for tabletop decor.', 950.00, 'images/product_41.jpg', 41, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 10),
(462, 'Woven Storage Basket', 'Large handwoven storage basket with lid.', 1800.00, 'images/product_42.jpg', 42, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 8),
(463, 'Homemade Cookies Assortment', 'Box of assorted gourmet cookies (12 pcs).', 750.00, 'images/product_43.jpg', 43, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 15),
(464, 'Hair Growth Oil', 'Natural hair growth oil with rosemary and castor oil.', 850.00, 'images/product_44.jpg', 44, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 20),
(465, 'Hand-Painted Wooden Tray', 'Decorative wooden serving tray, hand-painted design.', 1100.00, 'images/product_45.jpg', 45, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 10),
(466, 'Batik Sarong', 'Lightweight batik sarong, versatile for beach or home.', 1400.00, 'images/product_46.jpg', 46, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 12),
(467, 'Artisan Bread Dipping Oil', 'Infused olive oil for bread dipping.', 600.00, 'images/product_47.jpg', 47, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 18),
(468, 'Eucalyptus Shower Steamer', 'Aromatherapy shower steamer for relaxation.', 250.00, 'images/product_48.jpg', 48, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 30),
(469, 'Miniature Ceramic House', 'Small decorative ceramic house figurine.', 500.00, 'images/product_49.jpg', 49, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 15),
(470, 'Knitted Baby Booties', 'Soft knitted booties for infants.', 400.00, 'images/product_50.jpg', 50, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 20),
(471, 'Spicy Chili Oil', 'Homemade chili oil for an extra kick.', 300.00, 'images/product_51.jpg', 51, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 25),
(472, 'Aftershave Balm', 'Soothing natural aftershave balm for men.', 700.00, 'images/product_52.jpg', 52, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 15),
(473, 'Terracotta Pot', 'Hand-thrown terracotta pot for plants.', 700.00, 'images/product_53.jpg', 53, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 12),
(474, 'Upcycled Denim Tote Bag', 'Stylish tote bag made from recycled denim.', 1600.00, 'images/product_54.jpg', 54, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 9),
(475, 'Gourmet Caramel Sauce', 'Rich, buttery homemade caramel sauce.', 650.00, 'images/product_55.jpg', 55, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 18),
(476, 'Hair Conditioner Bar', 'Eco-friendly solid conditioner bar.', 500.00, 'images/product_56.jpg', 56, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 20),
(477, 'Handmade Paper Journal', 'A5 journal with handmade paper and leather cover.', 1200.00, 'images/product_57.jpg', 57, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 10),
(478, 'Indigo Dyed Fabric', 'One meter of indigo dyed cotton fabric.', 900.00, 'images/product_58.jpg', 58, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 15),
(479, 'Herbal Tea Blend', 'Relaxing herbal tea blend, 50g.', 400.00, 'images/product_59.jpg', 59, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 25),
(480, 'Shea Butter Hand Cream', 'Intensely moisturizing hand cream with shea butter.', 450.00, 'images/product_60.jpg', 60, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 20),
(481, 'Stained Glass Suncatcher', 'Small stained glass suncatcher, butterfly design.', 800.00, 'images/product_61.jpg', 61, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 10),
(482, 'Hand-Knitted Socks', 'Warm and cozy hand-knitted wool socks.', 750.00, 'images/product_62.jpg', 62, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 15),
(483, 'Spiced Fruit Chutney', 'Sweet and spicy fruit chutney for cheeses.', 400.00, 'images/product_63.jpg', 63, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 20),
(484, 'Natural Bug Spray', 'DEET-free natural insect repellent.', 600.00, 'images/product_64.jpg', 64, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 18),
(485, 'Macrame Wall Hanging', 'Large macrame wall hanging, boho style.', 2500.00, 'images/product_65.jpg', 65, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 5),
(486, 'Silk Scarf', 'Luxurious hand-painted silk scarf.', 1800.00, 'images/product_66.jpg', 66, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 7),
(487, 'Organic Kombucha', 'Homemade organic kombucha, assorted flavors, 500ml.', 400.00, 'images/product_67.jpg', 67, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 30),
(488, 'Natural Sunscreen', 'Broad-spectrum natural mineral sunscreen.', 900.00, 'images/product_68.jpg', 68, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 15),
(489, 'Custom Portrait Sketch', 'Hand-drawn portrait sketch from photo.', 3000.00, 'images/product_69.jpg', 69, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 3),
(490, 'Hand-Stitched Leather Wallet', 'Genuine leather wallet, hand-stitched details.', 2200.00, 'images/product_70.jpg', 70, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 8),
(491, 'Artisan Pickles', 'Fermented vegetable pickles, 500g.', 550.00, 'images/product_71.jpg', 71, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 12),
(492, 'Beard Oil', 'Nourishing beard oil for softness and shine.', 650.00, 'images/product_72.jpg', 72, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 20),
(493, 'Clay Diffuser', 'Unglazed clay essential oil diffuser.', 400.00, 'images/product_73.jpg', 73, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 15),
(494, 'Woven Basket', 'Small decorative woven basket with handle.', 700.00, 'images/product_74.jpg', 74, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 18),
(495, 'Artisan Hot Sauce', 'Gourmet hot sauce, unique flavor blend.', 500.00, 'images/product_75.jpg', 75, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 22),
(496, 'Solid Perfume Balm', 'Portable solid perfume balm, floral scent.', 600.00, 'images/product_76.jpg', 76, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 20),
(497, 'Terracotta Wind Chime', 'Handmade terracotta wind chime.', 950.00, 'images/product_77.jpg', 77, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 10),
(498, 'Embroidered Tote Bag', 'Canvas tote bag with custom embroidery.', 1400.00, 'images/product_78.jpg', 78, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 12),
(499, 'Homemade Pasta', 'Fresh fettuccine pasta, 250g.', 350.00, 'images/product_79.jpg', 79, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 25),
(500, 'Herbal Face Mist', 'Refreshing herbal face mist with rosewater.', 500.00, 'images/product_80.jpg', 80, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 20),
(501, 'Ceramic Mug', 'Hand-thrown ceramic mug, unique glaze.', 700.00, 'images/product_81.jpg', 81, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 15),
(502, 'Woven Wall Basket', 'Set of 3 decorative woven wall baskets.', 1800.00, 'images/product_82.jpg', 82, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 8),
(503, 'Artisan Jam Trio', 'Set of 3 gourmet fruit jams.', 1100.00, 'images/product_83.jpg', 83, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 10),
(504, 'Body Oil Blend', 'Nourishing body oil with jojoba and almond.', 800.00, 'images/product_84.jpg', 84, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 18),
(505, 'Paper Flower Bouquet', 'Everlasting bouquet of handmade paper flowers.', 1500.00, 'images/product_85.jpg', 85, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 7),
(506, 'Hand-Painted Silk Scarf', 'Luxury silk scarf with hand-painted floral design.', 2000.00, 'images/product_86.jpg', 86, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 5),
(507, 'Homemade Nut Butter', 'Creamy almond butter, 200g.', 750.00, 'images/product_87.jpg', 87, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 15),
(508, 'Natural Toothpaste', 'Fluoride-free natural toothpaste.', 400.00, 'images/product_88.jpg', 88, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 25),
(509, 'Fused Glass Coasters', 'Set of 4 fused glass coasters, ocean theme.', 1300.00, 'images/product_89.jpg', 89, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 9),
(510, 'Quilted Wall Hanging', 'Small decorative quilted wall hanging.', 900.00, 'images/product_90.jpg', 90, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 10),
(511, 'Artisan Granola Bars', 'Box of 6 homemade granola bars.', 600.00, 'images/product_91.jpg', 91, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 20),
(512, 'Aromatherapy Roll-On', 'Calming essential oil roll-on blend.', 550.00, 'images/product_92.jpg', 92, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 22),
(513, 'Handmade Greeting Cards', 'Set of 5 unique handmade greeting cards.', 400.00, 'images/product_93.jpg', 93, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 20),
(514, 'Embroidered Denim Jacket', 'Custom embroidered denim jacket, unique design.', 4500.00, 'images/product_94.jpg', 94, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 3),
(515, 'Vegan Protein Bars', 'Plant-based protein bars, pack of 4.', 800.00, 'images/product_95.jpg', 95, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 15),
(516, 'Herbal Shampoo Bar', 'Natural shampoo bar with essential oils.', 500.00, 'images/product_96.jpg', 96, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 20),
(517, 'Driftwood Sculpture', 'Unique decorative sculpture made from driftwood.', 1700.00, 'images/product_97.jpg', 97, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 6),
(518, 'Hand-Dyed Fabric Swatches', 'Set of 10 hand-dyed fabric swatches for crafts.', 700.00, 'images/product_98.jpg', 98, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 12),
(519, 'Gourmet Flavored Popcorn', 'Large bag of gourmet flavored popcorn.', 350.00, 'images/product_99.jpg', 99, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 25),
(520, 'Aloe Vera Gel', 'Pure aloe vera gel for soothing skin.', 600.00, 'images/product_100.jpg', 100, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 18),
(521, 'Ceramic Art Plate', 'Decorative ceramic plate, hand-painted design.', 1100.00, 'images/product_101.jpg', 101, 'Approved', '2025-05-24 12:16:53', 0, 'Decor', 10),
(522, 'Handwoven Table Mat Set', 'Set of 6 handwoven placemats.', 1600.00, 'images/product_102.jpg', 102, 'Approved', '2025-05-24 12:16:53', 0, 'Textiles', 8),
(523, 'Artisan Coffee Blend', 'Signature blend of roasted coffee beans, 500g.', 1200.00, 'images/product_103.jpg', 103, 'Approved', '2025-05-24 12:16:53', 0, 'Food', 15),
(524, 'Natural Beard Balm', 'Conditioning beard balm for styling and softening.', 750.00, 'images/product_104.jpg', 104, 'Approved', '2025-05-24 12:16:53', 0, 'Personal Care', 12),
(525, 'Ugali', 'A staple Kenyan dish made from maize flour', 100.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(526, 'Sukuma Wiki', 'Collard greens cooked with onions and tomatoes', 80.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(527, 'Chapati', 'Soft, layered flatbread', 50.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(528, 'Kienyeji Chicken', 'Locally raised chicken, free-range', 750.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 5),
(529, 'Samaki Fry', 'Fried whole fish', 600.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 8),
(530, 'Githeri', 'Mixture of maize and beans', 120.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(531, 'Mukimo', 'Mashed potatoes, maize, beans, and greens', 180.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(532, 'Nyama Choma', 'Grilled meat, usually goat or beef', 800.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 7),
(533, 'Mahamri', 'Sweet fried doughnuts', 40.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 15),
(534, 'Samosa', 'Savory pastry with minced meat or vegetable filling', 30.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 20),
(535, 'Ndizi Matoke', 'Cooked green bananas', 150.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(536, 'Wali Coco', 'Rice cooked in coconut milk', 130.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(537, 'Mbaazi za Nazi', 'Pigeon peas in coconut sauce', 160.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(538, 'Viazi Karai', 'Fried potatoes coated in a spiced batter', 70.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 15),
(539, 'Mshikaki', 'Grilled meat skewers', 90.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 12),
(540, 'Bhajia', 'Potato fritters', 60.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 15),
(541, 'Dengu', 'Lentil stew', 110.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(542, 'Matumbo', 'Tripe stew', 200.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 8),
(543, 'Mutura', 'Kenyan sausage made from goat intestines', 250.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 7),
(544, 'Maandazi', 'Soft fried bread', 35.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 20),
(545, 'Isi Ewu', 'Goat head soup (Nigerian style, popular in Kenya)', 900.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 4),
(546, 'Omena', 'Small fried fish', 170.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(547, 'Managu', 'African nightshade greens', 90.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(548, 'Terere', 'Amaranth greens', 85.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(549, 'Kunde', 'Cowpea leaves', 95.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(550, 'Mokimo Special', 'Premium Mukimo with added ingredients', 220.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 8),
(551, 'Boiled Maize', 'Fresh boiled maize on the cob', 60.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 15),
(552, 'Roasted Maize', 'Roasted maize on the cob', 70.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 15),
(553, 'Arrowroots', 'Boiled arrowroots', 120.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(554, 'Sweet Potatoes', 'Boiled sweet potatoes', 100.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(555, 'Cassava', 'Boiled cassava', 110.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(556, 'Fresh Juices (Orange)', 'Freshly squeezed orange juice', 150.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 20),
(557, 'Fresh Juices (Passion)', 'Freshly squeezed passion fruit juice', 150.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 20),
(558, 'Fresh Juices (Pineapple)', 'Freshly squeezed pineapple juice', 150.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 20),
(559, 'Maziwa Lala', 'Fermented milk', 100.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(560, 'Mursik', 'Traditional fermented milk (Kalenjin)', 180.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 8),
(561, 'Kenyan Tea', 'Spiced black tea with milk', 50.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 25),
(562, 'Mchele na Maharagwe', 'Rice and beans', 140.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(563, 'Fried Kales', 'Stir-fried kales with spices', 90.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(564, 'Fish Stew', 'Fish cooked in a savory stew', 550.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 6),
(565, 'Beef Stew', 'Tender beef chunks in a rich stew', 450.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 8),
(566, 'Chicken Stew', 'Chicken pieces in a flavorful stew', 400.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 8),
(567, 'Mkate Mayai', 'Swahili egg chapati', 100.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 12),
(568, 'Ugali with Sour Milk', 'Ugali served with fermented milk', 130.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(569, 'Smoked Fish', 'Locally smoked fish', 650.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 5),
(570, 'Nduma (Taro)', 'Boiled taro root', 120.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(571, 'Mrenda (Jute Mallow)', 'Traditional Luhya vegetable', 110.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(572, 'Busaa', 'Traditional millet beer (non-alcoholic version for listing)', 200.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(573, 'Mitoo (Spider Plant)', 'Traditional vegetable', 100.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10),
(574, 'Kunde (Dry)', 'Dried cowpea leaves, a delicacy', 130.00, 'images/default_product.png', 3, 'Approved', '2025-05-24 12:24:32', 0, 'Food', 10);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `artisan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `artisan_response` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `artisan_id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`, `artisan_response`) VALUES
(1, 1, 1, NULL, 5, 'good customer service', '2025-05-17 13:50:01', NULL),
(2, 2, 1, NULL, 5, 'Exeptional customer service. I love the products are of quality', '2025-05-19 11:34:59', NULL),
(3, 2, 11, NULL, 3, 'I did not get some products', '2025-05-19 11:37:04', NULL),
(4, 4, 1, NULL, 5, 'exeptional service', '2025-05-22 17:39:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `spotlights`
--

CREATE TABLE `spotlights` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_artisan` tinyint(1) DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `created_at`, `is_artisan`, `status`) VALUES
(1, 'Collins Otieno', 'otienocollins0549@gmail.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '0768581254', 'Nairobi, Embakasi., Tassia, Joreen Apartment', '2025-05-17 09:34:41', 1, 'active'),
(9, 'Emanuel Kamau', 'kamau@gmail.com', '$2y$10$YeJ30RQ9przNMNmVSaMQLO01FO2KrajAWtCffxyStpnevML1yxxAC', NULL, NULL, '2025-05-18 12:03:30', 0, 'active'),
(10, 'Fredrick Kamau', 'freddy@gmail.com', '$2y$10$IVUtxNLZMW5AkRIuXku.Le9GnSRaBbB6o1wSrQfdb6HMAXv0gf1Dq', NULL, NULL, '2025-05-18 12:25:32', 0, 'active'),
(11, 'Caroline Gethi', 'carol@gmail.com', '$2y$10$2gpGxfrIANd7nNxmo4izQuQkQ3gC3zcLfXBPJp6Rmz98fknQqo3..', '0768581254', NULL, '2025-05-19 11:35:54', 0, 'active'),
(12, 'Alice Johnson', 'alice.johnson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345601', NULL, '2025-05-24 11:52:24', 0, 'active'),
(13, 'Bob Williams', 'bob.williams@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345602', NULL, '2025-05-24 11:52:24', 1, 'active'),
(14, 'Catherine Davis', 'catherine.davis@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345603', NULL, '2025-05-24 11:52:24', 0, 'active'),
(15, 'David Brown', 'david.brown@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345604', NULL, '2025-05-24 11:52:24', 1, 'active'),
(16, 'Eve Miller', 'eve.miller@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345605', NULL, '2025-05-24 11:52:24', 0, 'active'),
(17, 'Frank Wilson', 'frank.wilson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345606', NULL, '2025-05-24 11:52:24', 1, 'active'),
(18, 'Grace Moore', 'grace.moore@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345607', NULL, '2025-05-24 11:52:24', 0, 'active'),
(19, 'Henry Taylor', 'henry.taylor@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345608', NULL, '2025-05-24 11:52:24', 1, 'active'),
(20, 'Ivy Anderson', 'ivy.anderson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345609', NULL, '2025-05-24 11:52:24', 0, 'active'),
(21, 'Jack Thomas', 'jack.thomas@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345610', NULL, '2025-05-24 11:52:24', 1, 'active'),
(22, 'Karen Jackson', 'karen.jackson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345611', NULL, '2025-05-24 11:52:24', 0, 'active'),
(23, 'Leo White', 'leo.white@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345612', NULL, '2025-05-24 11:52:24', 1, 'active'),
(24, 'Mia Harris', 'mia.harris@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345613', NULL, '2025-05-24 11:52:24', 0, 'active'),
(25, 'Noah Martin', 'noah.martin@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345614', NULL, '2025-05-24 11:52:24', 1, 'active'),
(26, 'Olivia Garcia', 'olivia.garcia@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345615', NULL, '2025-05-24 11:52:24', 0, 'active'),
(27, 'Peter Rodriguez', 'peter.rodriguez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345616', NULL, '2025-05-24 11:52:24', 1, 'active'),
(28, 'Quinn Martinez', 'quinn.martinez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345617', NULL, '2025-05-24 11:52:24', 0, 'active'),
(29, 'Rachel Hernandez', 'rachel.hernandez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345618', NULL, '2025-05-24 11:52:24', 1, 'active'),
(30, 'Sam Lopez', 'sam.lopez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345619', NULL, '2025-05-24 11:52:24', 0, 'active'),
(31, 'Tina Gonzalez', 'tina.gonzalez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345620', NULL, '2025-05-24 11:52:24', 1, 'active'),
(32, 'Umar Perez', 'umar.perez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345621', NULL, '2025-05-24 11:52:24', 0, 'active'),
(33, 'Vera Sanchez', 'vera.sanchez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345622', NULL, '2025-05-24 11:52:24', 1, 'active'),
(34, 'Will King', 'will.king@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345623', NULL, '2025-05-24 11:52:24', 0, 'active'),
(35, 'Xena Wright', 'xena.wright@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345624', NULL, '2025-05-24 11:52:24', 1, 'active'),
(36, 'Yara Hill', 'yara.hill@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345625', NULL, '2025-05-24 11:52:24', 0, 'active'),
(37, 'Zack Scott', 'zack.scott@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345626', NULL, '2025-05-24 11:52:24', 1, 'active'),
(38, 'Amy Green', 'amy.green@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345627', NULL, '2025-05-24 11:52:24', 0, 'active'),
(39, 'Ben Baker', 'ben.baker@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345628', NULL, '2025-05-24 11:52:24', 1, 'active'),
(40, 'Chloe Adams', 'chloe.adams@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345629', NULL, '2025-05-24 11:52:24', 0, 'active'),
(41, 'Daniel Nelson', 'daniel.nelson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345630', NULL, '2025-05-24 11:52:24', 1, 'active'),
(42, 'Ella Carter', 'ella.carter@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345631', NULL, '2025-05-24 11:52:24', 0, 'active'),
(43, 'Fred Hall', 'fred.hall@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345632', NULL, '2025-05-24 11:52:24', 1, 'active'),
(44, 'Georgia Rivera', 'georgia.rivera@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345633', NULL, '2025-05-24 11:52:24', 0, 'active'),
(45, 'Harold Scott', 'harold.scott@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345634', NULL, '2025-05-24 11:52:24', 1, 'active'),
(46, 'Isabel Evans', 'isabel.evans@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345635', NULL, '2025-05-24 11:52:24', 0, 'active'),
(47, 'James Phillips', 'james.phillips@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345636', NULL, '2025-05-24 11:52:24', 1, 'active'),
(48, 'Kelly Campbell', 'kelly.campbell@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345637', NULL, '2025-05-24 11:52:24', 0, 'active'),
(49, 'Liam Parker', 'liam.parker@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345638', NULL, '2025-05-24 11:52:24', 1, 'active'),
(50, 'Megan Young', 'megan.young@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345639', NULL, '2025-05-24 11:52:24', 0, 'active'),
(51, 'Nathan Lewis', 'nathan.lewis@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345640', NULL, '2025-05-24 11:52:24', 1, 'active'),
(52, 'Chloe Hall', 'chloe.hall@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345641', NULL, '2025-05-24 11:52:24', 0, 'active'),
(53, 'Oscar King', 'oscar.king@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345642', NULL, '2025-05-24 11:52:24', 1, 'active'),
(54, 'Pamela Wright', 'pamela.wright@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345643', NULL, '2025-05-24 11:52:24', 0, 'active'),
(55, 'Quentin Hill', 'quentin.hill@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345644', NULL, '2025-05-24 11:52:24', 1, 'active'),
(56, 'Rose Clark', 'rose.clark@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345645', NULL, '2025-05-24 11:52:24', 0, 'active'),
(57, 'Steven Baker', 'steven.baker@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345646', NULL, '2025-05-24 11:52:24', 1, 'active'),
(58, 'Tracy Carter', 'tracy.carter@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345647', NULL, '2025-05-24 11:52:24', 0, 'active'),
(59, 'Victor Davis', 'victor.davis@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345648', NULL, '2025-05-24 11:52:24', 1, 'active'),
(60, 'Wendy Green', 'wendy.green@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345649', NULL, '2025-05-24 11:52:24', 0, 'active'),
(61, 'Xavier Hall', 'xavier.hall@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345650', NULL, '2025-05-24 11:52:24', 1, 'active'),
(62, 'Yvonne Lewis', 'yvonne.lewis@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345651', NULL, '2025-05-24 11:52:24', 0, 'active'),
(63, 'Zachary Adams', 'zachary.adams@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345652', NULL, '2025-05-24 11:52:24', 1, 'active'),
(64, 'Brenda Scott', 'brenda.scott@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345653', NULL, '2025-05-24 11:52:24', 0, 'active'),
(65, 'Chris White', 'chris.white@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345654', NULL, '2025-05-24 11:52:24', 1, 'active'),
(66, 'Diana Young', 'diana.young@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345655', NULL, '2025-05-24 11:52:24', 0, 'active'),
(67, 'Ethan Clark', 'ethan.clark@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345656', NULL, '2025-05-24 11:52:24', 1, 'active'),
(68, 'Fiona Wright', 'fiona.wright@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345657', NULL, '2025-05-24 11:52:24', 0, 'active'),
(69, 'Gary Hill', 'gary.hill@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345658', NULL, '2025-05-24 11:52:24', 1, 'active'),
(70, 'Holly Adams', 'holly.adams@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345659', NULL, '2025-05-24 11:52:24', 0, 'active'),
(71, 'Ian Brown', 'ian.brown@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345660', NULL, '2025-05-24 11:52:24', 1, 'active'),
(72, 'Jessica Davis', 'jessica.davis@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345661', NULL, '2025-05-24 11:52:24', 0, 'active'),
(73, 'Kevin Miller', 'kevin.miller@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345662', NULL, '2025-05-24 11:52:24', 1, 'active'),
(74, 'Laura Wilson', 'laura.wilson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345663', NULL, '2025-05-24 11:52:24', 0, 'active'),
(75, 'Mark Moore', 'mark.moore@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345664', NULL, '2025-05-24 11:52:24', 1, 'active'),
(76, 'Nina Taylor', 'nina.taylor@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345665', NULL, '2025-05-24 11:52:24', 0, 'active'),
(77, 'Oliver Anderson', 'oliver.anderson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345666', NULL, '2025-05-24 11:52:24', 1, 'active'),
(78, 'Paula Thomas', 'paula.thomas@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345667', NULL, '2025-05-24 11:52:24', 0, 'active'),
(79, 'Robert Jackson', 'robert.jackson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345668', NULL, '2025-05-24 11:52:24', 1, 'active'),
(80, 'Sarah White', 'sarah.white@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345669', NULL, '2025-05-24 11:52:24', 0, 'active'),
(81, 'Tom Harris', 'tom.harris@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345670', NULL, '2025-05-24 11:52:24', 1, 'active'),
(82, 'Uma Martin', 'uma.martin@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345671', NULL, '2025-05-24 11:52:24', 0, 'active'),
(83, 'Vince Garcia', 'vince.garcia@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345672', NULL, '2025-05-24 11:52:24', 1, 'active'),
(84, 'Whitney Rodriguez', 'whitney.rodriguez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345673', NULL, '2025-05-24 11:52:24', 0, 'active'),
(85, 'Xander Martinez', 'xander.martinez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345674', NULL, '2025-05-24 11:52:24', 1, 'active'),
(86, 'Yolanda Hernandez', 'yolanda.hernandez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345675', NULL, '2025-05-24 11:52:24', 0, 'active'),
(87, 'Zane Lopez', 'zane.lopez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345676', NULL, '2025-05-24 11:52:24', 1, 'active'),
(88, 'Ada Gonzalez', 'ada.gonzalez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345677', NULL, '2025-05-24 11:52:24', 0, 'active'),
(89, 'Brian Perez', 'brian.perez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345678', NULL, '2025-05-24 11:52:24', 1, 'active'),
(90, 'Cindy Sanchez', 'cindy.sanchez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345679', NULL, '2025-05-24 11:52:24', 0, 'active'),
(91, 'Derek King', 'derek.king@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345680', NULL, '2025-05-24 11:52:24', 1, 'active'),
(92, 'Erica Wright', 'erica.wright@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345681', NULL, '2025-05-24 11:52:24', 0, 'active'),
(93, 'Felix Hill', 'felix.hill@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345682', NULL, '2025-05-24 11:52:24', 1, 'active'),
(94, 'Gina Adams', 'gina.adams@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345683', NULL, '2025-05-24 11:52:24', 0, 'active'),
(95, 'Harry Brown', 'harry.brown@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345684', NULL, '2025-05-24 11:52:24', 1, 'active'),
(96, 'Irene Davis', 'irene.davis@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345685', NULL, '2025-05-24 11:52:24', 0, 'active'),
(97, 'Jerry Miller', 'jerry.miller@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345686', NULL, '2025-05-24 11:52:24', 1, 'active'),
(98, 'Kathy Wilson', 'kathy.wilson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345687', NULL, '2025-05-24 11:52:24', 0, 'active'),
(99, 'Larry Moore', 'larry.moore@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345688', NULL, '2025-05-24 11:52:24', 1, 'active'),
(100, 'Monica Taylor', 'monica.taylor@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345689', NULL, '2025-05-24 11:52:24', 0, 'active'),
(101, 'Neil Anderson', 'neil.anderson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345690', NULL, '2025-05-24 11:52:24', 1, 'active'),
(102, 'Patty Thomas', 'patty.thomas@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345691', NULL, '2025-05-24 11:52:24', 0, 'active'),
(103, 'Randy Jackson', 'randy.jackson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345692', NULL, '2025-05-24 11:52:24', 1, 'active'),
(104, 'Shelly White', 'shelly.white@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345693', NULL, '2025-05-24 11:52:24', 0, 'active'),
(105, 'Todd Harris', 'todd.harris@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345694', NULL, '2025-05-24 11:52:24', 1, 'active'),
(106, 'Vicky Martin', 'vicky.martin@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345695', NULL, '2025-05-24 11:52:24', 0, 'active'),
(107, 'Wayne Garcia', 'wayne.garcia@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345696', NULL, '2025-05-24 11:52:24', 1, 'active'),
(108, 'Yvonne Rodriguez', 'yvonne.rodriguez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345697', NULL, '2025-05-24 11:52:24', 0, 'active'),
(109, 'Zoe Martinez', 'zoe.martinez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345698', NULL, '2025-05-24 11:52:24', 1, 'active'),
(110, 'Arthur Hernandez', 'arthur.hernandez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345699', NULL, '2025-05-24 11:52:24', 0, 'active'),
(111, 'Betty Lopez', 'betty.lopez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345700', NULL, '2025-05-24 11:52:24', 1, 'active'),
(112, 'Charles Gonzalez', 'charles.gonzalez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345701', NULL, '2025-05-24 11:52:24', 0, 'active'),
(113, 'Dora Perez', 'dora.perez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345702', NULL, '2025-05-24 11:52:24', 1, 'active'),
(114, 'Edward Sanchez', 'edward.sanchez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345703', NULL, '2025-05-24 11:52:24', 0, 'active'),
(115, 'Fanny King', 'fanny.king@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345704', NULL, '2025-05-24 11:52:24', 1, 'active'),
(116, 'George Wright', 'george.wright@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345705', NULL, '2025-05-24 11:52:24', 0, 'active'),
(117, 'Helen Hill', 'helen.hill@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345706', NULL, '2025-05-24 11:52:24', 1, 'active'),
(118, 'Ivan Adams', 'ivan.adams@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345707', NULL, '2025-05-24 11:52:24', 0, 'active'),
(119, 'Judy Brown', 'judy.brown@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345708', NULL, '2025-05-24 11:52:24', 1, 'active'),
(120, 'Kyle Davis', 'kyle.davis@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345709', NULL, '2025-05-24 11:52:24', 0, 'active'),
(121, 'Lena Miller', 'lena.miller@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345710', NULL, '2025-05-24 11:52:24', 1, 'active'),
(122, 'Mike Wilson', 'mike.wilson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345711', NULL, '2025-05-24 11:52:24', 0, 'active'),
(123, 'Nora Moore', 'nora.moore@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345712', NULL, '2025-05-24 11:52:24', 1, 'active'),
(124, 'Oscar Taylor', 'oscar.taylor@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345713', NULL, '2025-05-24 11:52:24', 0, 'active'),
(125, 'Paul Anderson', 'paul.anderson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345714', NULL, '2025-05-24 11:52:24', 1, 'active'),
(126, 'Queenie Thomas', 'queenie.thomas@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345715', NULL, '2025-05-24 11:52:24', 0, 'active'),
(127, 'Ron Jackson', 'ron.jackson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345716', NULL, '2025-05-24 11:52:24', 1, 'active'),
(128, 'Susan White', 'susan.white@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345717', NULL, '2025-05-24 11:52:24', 0, 'active'),
(129, 'Tim Harris', 'tim.harris@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345718', NULL, '2025-05-24 11:52:24', 1, 'active'),
(130, 'Ursula Martin', 'ursula.martin@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345719', NULL, '2025-05-24 11:52:24', 0, 'active'),
(131, 'Vivian Garcia', 'vivian.garcia@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345720', NULL, '2025-05-24 11:52:24', 1, 'active'),
(132, 'Walter Rodriguez', 'walter.rodriguez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345721', NULL, '2025-05-24 11:52:24', 0, 'active'),
(133, 'Yara Martinez', 'yara.martinez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345722', NULL, '2025-05-24 11:52:24', 1, 'active'),
(134, 'Zelda Hernandez', 'zelda.hernandez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345723', NULL, '2025-05-24 11:52:24', 0, 'active'),
(135, 'Aaron Lopez', 'aaron.lopez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345724', NULL, '2025-05-24 11:52:24', 1, 'active'),
(136, 'Betty Gonzalez', 'betty.gonzalez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345725', NULL, '2025-05-24 11:52:24', 0, 'active'),
(137, 'Carl Perez', 'carl.perez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345726', NULL, '2025-05-24 11:52:24', 1, 'active'),
(138, 'Doris Sanchez', 'doris.sanchez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345727', NULL, '2025-05-24 11:52:24', 0, 'active'),
(139, 'Earl King', 'earl.king@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345728', NULL, '2025-05-24 11:52:24', 1, 'active'),
(140, 'Fay Wright', 'fay.wright@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345729', NULL, '2025-05-24 11:52:24', 0, 'active'),
(141, 'Gavin Hill', 'gavin.hill@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345730', NULL, '2025-05-24 11:52:24', 1, 'active'),
(142, 'Hope Adams', 'hope.adams@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345731', NULL, '2025-05-24 11:52:24', 0, 'active'),
(143, 'Isaac Brown', 'isaac.brown@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345732', NULL, '2025-05-24 11:52:24', 1, 'active'),
(144, 'Jane Davis', 'jane.davis@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345733', NULL, '2025-05-24 11:52:24', 0, 'active'),
(145, 'Keith Miller', 'keith.miller@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345734', NULL, '2025-05-24 11:52:24', 1, 'active'),
(146, 'Lisa Wilson', 'lisa.wilson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345735', NULL, '2025-05-24 11:52:24', 0, 'active'),
(147, 'Max Moore', 'max.moore@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345736', NULL, '2025-05-24 11:52:24', 1, 'active'),
(148, 'Nancy Taylor', 'nancy.taylor@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345737', NULL, '2025-05-24 11:52:24', 0, 'active'),
(149, 'Owen Anderson', 'owen.anderson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345738', NULL, '2025-05-24 11:52:24', 1, 'active'),
(150, 'Pam Thomas', 'pam.thomas@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345739', NULL, '2025-05-24 11:52:24', 0, 'active'),
(151, 'Rick Jackson', 'rick.jackson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345740', NULL, '2025-05-24 11:52:24', 1, 'active'),
(152, 'Sara White', 'sara.white@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345741', NULL, '2025-05-24 11:52:24', 0, 'active'),
(153, 'Tony Harris', 'tony.harris@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345742', NULL, '2025-05-24 11:52:24', 1, 'active'),
(154, 'Valerie Martin', 'valerie.martin@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345743', NULL, '2025-05-24 11:52:24', 0, 'active'),
(155, 'Will Garcia', 'will.garcia@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345744', NULL, '2025-05-24 11:52:24', 1, 'active'),
(156, 'Yara Rodriguez', 'yara.rodriguez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345745', NULL, '2025-05-24 11:52:24', 0, 'active'),
(157, 'Zach Martinez', 'zach.martinez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345746', NULL, '2025-05-24 11:52:24', 1, 'active'),
(158, 'Bella Hernandez', 'bella.hernandez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345747', NULL, '2025-05-24 11:52:24', 0, 'active'),
(159, 'Charlie Lopez', 'charlie.lopez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345748', NULL, '2025-05-24 11:52:24', 1, 'active'),
(160, 'Daisy Gonzalez', 'daisy.gonzalez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345749', NULL, '2025-05-24 11:52:24', 0, 'active'),
(161, 'Eric Perez', 'eric.perez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345750', NULL, '2025-05-24 11:52:24', 1, 'active'),
(162, 'Fiona Sanchez', 'fiona.sanchez@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345751', NULL, '2025-05-24 11:52:24', 0, 'active'),
(163, 'George King', 'george.king@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345752', NULL, '2025-05-24 11:52:24', 1, 'active'),
(164, 'Hannah Wright', 'hannah.wright@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345753', NULL, '2025-05-24 11:52:24', 0, 'active'),
(165, 'Igor Hill', 'igor.hill@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345754', NULL, '2025-05-24 11:52:24', 1, 'active'),
(166, 'Julia Adams', 'julia.adams@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345755', NULL, '2025-05-24 11:52:24', 0, 'active'),
(167, 'Kyle Brown', 'kyle.brown@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345756', NULL, '2025-05-24 11:52:24', 1, 'active'),
(168, 'Lena Davis', 'lena.davis@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345757', NULL, '2025-05-24 11:52:24', 0, 'active'),
(169, 'Matt Miller', 'matt.miller@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345758', NULL, '2025-05-24 11:52:24', 1, 'active'),
(170, 'Nancy Wilson', 'nancy.wilson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345759', NULL, '2025-05-24 11:52:24', 0, 'active'),
(171, 'Oliver Moore', 'oliver.moore@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345760', NULL, '2025-05-24 11:52:24', 1, 'active'),
(172, 'Penny Taylor', 'penny.taylor@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345761', NULL, '2025-05-24 11:52:24', 0, 'active'),
(173, 'Rob Anderson', 'rob.anderson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345762', NULL, '2025-05-24 11:52:24', 1, 'active'),
(174, 'Sandy Thomas', 'sandy.thomas@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345763', NULL, '2025-05-24 11:52:24', 0, 'active'),
(175, 'Tom Jackson', 'tom.jackson@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345764', NULL, '2025-05-24 11:52:24', 1, 'active'),
(176, 'Usha White', 'usha.white@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345765', NULL, '2025-05-24 11:52:24', 0, 'active'),
(177, 'Val Harris', 'val.harris@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345766', NULL, '2025-05-24 11:52:24', 1, 'active'),
(178, 'Wendy Martin', 'wendy.martin@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345767', NULL, '2025-05-24 11:52:24', 0, 'active'),
(179, 'Xavier Garcia', 'xavier.garcia@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345768', NULL, '2025-05-24 11:52:24', 1, 'active'),
(180, 'Yara Rodriguez', 'yara.rodriguez2@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345769', NULL, '2025-05-24 11:52:24', 0, 'active'),
(181, 'Zane Martinez', 'zane.martinez2@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345770', NULL, '2025-05-24 11:52:24', 1, 'active'),
(182, 'Alice B', 'alice.b@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345771', NULL, '2025-05-24 11:52:24', 0, 'active'),
(183, 'Bob C', 'bob.c@example.com', '$2y$10$nKVciHajmntSjlI3s5u6d.JvZWp7k2hskslj3CTkegvCjiNVmkiwi', '254712345772', NULL, '2025-05-24 11:52:24', 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(1, 1, 1, '2025-05-20 21:30:43'),
(2, 1, 2, '2025-05-24 08:42:45'),
(3, 1, 538, '2025-05-26 10:18:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `artisans`
--
ALTER TABLE `artisans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_artisans_users` (`user_id`),
  ADD KEY `is_featured` (`is_featured`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artisan_id` (`artisan_id`),
  ADD KEY `is_featured` (`is_featured`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artisan_id` (`artisan_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_ratings_product` (`product_id`);

--
-- Indexes for table `spotlights`
--
ALTER TABLE `spotlights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `artisans`
--
ALTER TABLE `artisans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=575;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `spotlights`
--
ALTER TABLE `spotlights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `artisans`
--
ALTER TABLE `artisans`
  ADD CONSTRAINT `fk_artisans_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`artisan_id`) REFERENCES `artisans` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `fk_ratings_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`artisan_id`) REFERENCES `artisans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `spotlights`
--
ALTER TABLE `spotlights`
  ADD CONSTRAINT `spotlights_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
