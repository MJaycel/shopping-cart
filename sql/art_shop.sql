-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2021 at 04:26 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `art_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`) VALUES
(1, 'Jonathen Klassen'),
(2, 'Jenny Yu'),
(3, 'Vanessa Gillings'),
(4, 'Mall'),
(5, 'Yvan Duque'),
(6, 'Kirstin Kwan'),
(7, 'Sara Kipin'),
(8, 'Jisoo Kim'),
(9, 'Kevin Jay Stanton'),
(10, 'Nathan Fowkes');

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `id` int(11) NOT NULL,
  `name` varchar(90) NOT NULL,
  `card_number` varchar(15) NOT NULL,
  `exp_date` varchar(25) NOT NULL,
  `cvv` varchar(3) NOT NULL,
  `card_type` varchar(15) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `card`
--

INSERT INTO `card` (`id`, `name`, `card_number`, `exp_date`, `cvv`, `card_type`, `user_id`) VALUES
(1, 'Mary Jaycel', '4263982640269', '2021-08-18', '123', 'visa', 2),
(2, 'Mary Jaycel', '4373855948394', '2021-08-18', '456', 'visa', 2),
(3, 'Mary Benedicto', '12345678901', '04/09', '123', 'visa', 2),
(4, 'Sarah Hamil', '12345432341', '08/21', '456', 'visa', 3),
(5, 'Meredith Grey', '12321454565', '08/24', '544', 'master-card', 4),
(6, 'Mary Benedicto', '4332564356543', '08/26', '444', 'american-expres', 2);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`) VALUES
(1, 'Abstract'),
(2, 'Animals'),
(3, 'Cartoon'),
(4, 'Fantasy'),
(5, 'Figurative'),
(6, 'Floral'),
(7, 'Graphic'),
(8, 'Landscape'),
(9, 'Narrative'),
(10, 'Surreal');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `filename`) VALUES
(1, 'art1.jpg'),
(2, 'art2.jpg'),
(3, 'art3.jpg'),
(4, 'art4.jpg'),
(5, 'art5.jpg'),
(6, 'art6.jpg'),
(7, 'art7.jpg'),
(8, 'art8.jpg'),
(9, 'art9.jpg'),
(10, 'art10.jpg'),
(11, 'art11.jpg'),
(12, 'art12.jpg'),
(13, 'art13.jpg'),
(14, 'art14.jpg'),
(15, 'art15.jpg'),
(16, 'art11.jpg'),
(17, 'art11.jpg'),
(18, 'art11.jgp'),
(19, 'art11.jgp'),
(21, 'art11.jgp'),
(22, 'art11.jgp'),
(23, 'art11.jgp'),
(24, 'art11.jgp'),
(25, 'art11.jgp'),
(26, 'art11.jgp');

-- --------------------------------------------------------

--
-- Table structure for table `orderproduct`
--

CREATE TABLE `orderproduct` (
  `id` int(11) NOT NULL,
  `quantity` varchar(90) NOT NULL,
  `order_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderproduct`
--

INSERT INTO `orderproduct` (`id`, `quantity`, `order_id`, `prod_id`) VALUES
(1, '1', 2, 2),
(2, '5', 3, 1),
(3, '1', 3, 6),
(4, '1', 4, 2),
(5, '2', 4, 1),
(6, '2', 5, 5),
(7, '1', 6, 2),
(8, '1', 6, 10),
(9, '1', 7, 10),
(10, '1', 7, 2),
(11, '1', 7, 8);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `ord_date` date NOT NULL,
  `status` varchar(90) NOT NULL,
  `card_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `ord_date`, `status`, `card_id`) VALUES
(1, '2021-04-22', 'Delivered March 12', 3),
(2, '2021-04-22', 'new', 3),
(3, '2021-04-22', 'new', 3),
(4, '2021-04-22', 'new', 4),
(5, '2021-04-24', 'new', 3),
(6, '2021-04-26', 'new', 1),
(7, '2021-04-26', 'new', 6);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `availability` varchar(30) NOT NULL,
  `height` varchar(90) NOT NULL,
  `width` varchar(90) NOT NULL,
  `paper_type` varchar(90) NOT NULL,
  `img_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `availability`, `height`, `width`, `paper_type`, `img_id`, `artist_id`) VALUES
(1, 'Haircut', '35.00', 'In stock', '11.0\"(27.94 cm)', '6.5\" (22.86 cm)', 'Giclee', 10, 2),
(2, 'Class', '35.00', 'In stock', '11.0\"(27.94 cm)', '8.5\" (21.59 cm)', 'Watercolor Paper', 9, 2),
(3, 'Gate', '35.00', 'In stock', '8.0\" (20.32 cm)', '8.0\" (20.32 cm)', 'Giclee', 8, 2),
(4, 'Bunnies', '35.00', 'Out of Stock', '8.0\" (20.32 cm)	', '8.0\" (20.32 cm)	', 'Giclee', 7, 2),
(5, 'Fishtank', '35.00', 'In stock', '8.0\" (20.32 cm)	', '8.0\" (20.32 cm)	', 'Watercolor Paper', 6, 2),
(6, 'Beach Walk', '35.00', 'In stock', '13.0\" (33.02 cm)	', '19.0\" (48.26 cm)	', 'Giclee	', 5, 1),
(7, 'I want my hat back (fox)', '35.00', 'Out of Stock', '19.0\" (48.26 cm)	', '13.0\" (33.02 cm)	', 'Watercolor Paper', 4, 1),
(8, 'I want my hat back (Red Hat)', '35.00', 'In stock', '19.0\" (48.26 cm)	', '13.0\" (33.02 cm)	', 'Watercolor Paper', 3, 1),
(9, 'Waterfall', '35.00', 'In stock', '19.0\" (48.26 cm)	', '13.0\" (33.02 cm)	', 'Giclee', 2, 1),
(10, 'Rock From the Sky - Page 70', '35.00', 'In stock', '9.0\" (22.86 cm)	', '19.0\" (48.26 cm)	', 'Velvet Fine Art', 1, 1),
(11, 'The Fox\'s Apprentice', '35.00', 'Out of Stock', '11.0\" (27.94 cm)', '8.5\" (21.59 cm)	', 'Watercolor Paper', 11, 3),
(12, 'The Dream Princess\' Wish', '35.00', 'In stock', '8.5\" (21.59 cm)	', '11.0\" (27.94 cm)	', 'Giclee', 12, 3),
(13, 'Seasons Change', '35.00', 'In stock', '11.0\" (27.94 cm)	', '8.5\" (21.59 cm)	', 'Watercolor Paper', 13, 3),
(14, 'The winter Witch', '35.00', 'In Stock', '11.0\" (27.94 cm)	', '8.5\" (21.59 cm)	', 'Watercolor Paper', 14, 3),
(15, 'After The Battle', '35.00', 'In Stock', '11.0\" (27.94 cm)	', '8.5\" (21.59 cm)	', 'Giclee', 15, 3);

-- --------------------------------------------------------

--
-- Table structure for table `prod_cat`
--

CREATE TABLE `prod_cat` (
  `id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prod_cat`
--

INSERT INTO `prod_cat` (`id`, `prod_id`, `cat_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2),
(4, 3, 9),
(5, 4, 2),
(6, 4, 9),
(7, 5, 1),
(8, 5, 8),
(9, 6, 10),
(10, 6, 2),
(11, 6, 4),
(12, 7, 2),
(13, 8, 9),
(14, 9, 2),
(15, 9, 10),
(16, 10, 10),
(17, 10, 9),
(18, 10, 5),
(19, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`) VALUES
(1, 'admin'),
(4, 'customer'),
(3, 'employee'),
(2, 'manager');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(90) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `address_1` varchar(90) NOT NULL,
  `address_2` varchar(90) NOT NULL,
  `city` varchar(90) NOT NULL,
  `country` varchar(90) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `role_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `address_1`, `address_2`, `city`, `country`, `postcode`, `phone`, `role_id`) VALUES
(1, '', 'admin@bookworms.com', '$2y$10$9DwoD.YVzCMleCri1pRRyeRewrPbNXgG0539GiTYyQD41HwQOWYoK', '', '', '', '', '', '', 1),
(2, 'Mary Benedicto', 'mbenedicto@bloggs.com', '$2y$10$j9.Us9xosNq491yL/9PkpuDmwz0tfq/FBMwifbIatdxqc13MeIoUK', '19 Gort na Mara', 'Blackrock', 'Dublin', 'Germany', 'D04 K5X1', '085-9654127', 4),
(3, 'Sarah', 'sarah.h@bloggs.com', '$2y$10$5kmfqH6smlxNHUA2HSqZMuLQaz2LhAnzXdgoJzREZVBxihsHjRmly', '24 Middle Lane', 'Tulane', 'Dublin', 'Ireland', 'A09 K3X1', '084-1234567', 4),
(4, 'Meredith Grey', 'meredith.grey@gmail.com', '$2y$10$tH1QunnO3yY0UEyid1iJE.OLXS6oaIkV5.X4ust9o5bBu.V7M5UjG', '19 Gort na Mara', 'Stillorgan Road', 'Dublin', 'Germany', 'D04 K5X1', '084-1234567', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderproduct`
--
ALTER TABLE `orderproduct`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_card` (`card_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_image` (`img_id`),
  ADD KEY `product_artist` (`artist_id`);

--
-- Indexes for table `prod_cat`
--
ALTER TABLE `prod_cat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_prod` (`cat_id`),
  ADD KEY `prod_cat` (`prod_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_title_unique` (`title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orderproduct`
--
ALTER TABLE `orderproduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `prod_cat`
--
ALTER TABLE `prod_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `card`
--
ALTER TABLE `card`
  ADD CONSTRAINT `user_card` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orderproduct`
--
ALTER TABLE `orderproduct`
  ADD CONSTRAINT `orderproduct_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `orderproduct_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_card` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `product_artist` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`),
  ADD CONSTRAINT `product_image` FOREIGN KEY (`img_id`) REFERENCES `images` (`id`);

--
-- Constraints for table `prod_cat`
--
ALTER TABLE `prod_cat`
  ADD CONSTRAINT `cat_prod` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `prod_cat` FOREIGN KEY (`prod_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
