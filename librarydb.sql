-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 10:25 PM
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
-- Database: `librarydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(11) NOT NULL,
  `author_name` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `author_name`) VALUES
(1, 'George R. R. Martin'),
(2, 'Andrzej Sapkowski');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `publication_date` date DEFAULT NULL,
  `added_date` date DEFAULT curdate(),
  `pages` int(11) DEFAULT NULL CHECK (`pages` > 0),
  `path_to_cover` varchar(255) DEFAULT NULL,
  `rented_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `publisher_id`, `category_id`, `title`, `publication_date`, `added_date`, `pages`, `path_to_cover`, `rented_count`) VALUES
(1, 1, 1, 'A Game of Thrones', '1996-08-06', '2024-02-15', 694, '/covers/agameofthrones.jpg', 15),
(2, 1, 1, 'A Clash of Kings', '1998-11-16', '2023-12-10', 768, '/covers/aclashofkings.jpg', 10),
(3, 1, 1, 'A Storm of Swords', '2000-08-08', '2024-01-20', 973, '/covers/astormofswords.jpg', 20),
(4, 1, 1, 'A Feast for Crows', '2005-10-17', '2024-05-05', 753, '/covers/afeastforcrows.jpg', 8),
(5, 1, 1, 'A Dance with Dragons', '2011-07-12', '2024-03-15', 1056, '/covers/adancewithdragons.jpg', 12),
(6, 2, 1, 'The Last Wish', '1993-01-01', '2023-11-21', 384, '/covers/thelastwish.jpg', 19),
(7, 2, 1, 'Sword of Destiny', '1992-01-01', '2024-02-28', 400, '/covers/swordofdestiny.jpg', 15),
(8, 2, 1, 'Blood of Elves', '1994-01-01', '2024-05-15', 320, '/covers/bloodofelves.jpg', 12),
(9, 2, 1, 'Time of Contempt', '1995-01-01', '2024-04-10', 352, '/covers/timeofcontempt.jpg', 14),
(10, 2, 1, 'Baptism of Fire', '1996-01-01', '2024-01-05', 378, '/covers/baptismoffire.jpg', 10),
(11, 2, 1, 'The Tower of the Swallow', '1997-01-01', '2023-12-15', 439, '/covers/thetoweroftheswallow.jpg', 5),
(12, 2, 1, 'The Lady of the Lake', '1999-01-01', '2024-06-20', 540, '/covers/theladyofthelake.jpg', 8);

-- --------------------------------------------------------

--
-- Table structure for table `book_copy`
--

CREATE TABLE `book_copy` (
  `book_copy_id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `is_rented` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_copy`
--

INSERT INTO `book_copy` (`book_copy_id`, `book_id`, `is_rented`) VALUES
(1, 1, 0),
(2, 1, 1),
(3, 2, 0),
(4, 2, 1),
(5, 2, 0),
(6, 3, 0),
(7, 3, 1),
(8, 4, 0),
(9, 5, 1),
(10, 5, 1),
(11, 6, 1),
(12, 6, 0),
(13, 6, 0),
(14, 7, 1),
(15, 7, 1),
(16, 8, 0),
(17, 8, 1),
(18, 9, 1),
(19, 9, 0),
(20, 10, 0),
(21, 11, 1),
(22, 12, 1),
(23, 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `book_to_author`
--

CREATE TABLE `book_to_author` (
  `book_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_to_author`
--

INSERT INTO `book_to_author` (`book_id`, `author_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `book_copy_id` int(11) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `added_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Fantasy');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(25) NOT NULL,
  `address` varchar(128) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `pwd`, `is_admin`) VALUES
(4, 'Mateusz', 'asd', 'asddas@gmail.com', '312123123 123', 'sadsad ', '$2y$10$sb9Hu/631oix5iPnW/re/O.Woi964ssqQx0aqOqS4JT0biW0vEiCW', 0),
(6, 'adsdas', 'adsdsa', 'asdasdasd@gmail.com', '123123123', 'dsaasd', '$2y$10$b0A5ARMQefiIHpYwqjNGeOsFUFKldP5aT3CwWrzO9FSI1AKBgpN3G', 0),
(7, 'sasdsd', 'asasd', 'asda@gmail.com', '12312312', 'adsdsasda', '$2y$10$DZD2aO6cAGWiqvSc2gIAMOVO5ywIJzixxg2YWW/972LOQumYwYXwi', 0),
(8, 'ads', 'ads', 'mat21mat12mat@gmail.com', '123123', 'sdaas', '$2y$10$LAN3m6f3fTp/zo1Po1bwcOAQmBtMDx8O7K1T/1DRPehdH9awZBRR2', 0),
(9, 'asd', 'sad', 'mat21mat12mt@gmail.com', '1312123123', 'dasdasdas', '$2y$10$SkITg4polK6TV6dqdOlx0O.NaAA9/rmxrmlWGTRi1D1EY/iY/rLRC', 0),
(10, 'asd', 'asd', 'warek1160@gmail.com', '132123123', 'ads123asd132', '$2y$10$fbiPNnGmw2oqqoRwWY1cOOIBk.ZRQzdiqY03elcv6coDVeGbGYtI2', 0),
(11, 'asdads', 'dasasd', 'mates-96@wp.pl', '132312132', 'dsadas', '$2y$10$TDIKc3WEP83ziug3iSWyTuW0qssF9B0pEv37abvrCBYiMKjv3V7qi', 0),
(12, 'dsadsa', 'dsadsa', 'mat21ma12mat@gmail.com', '123213213', 'asd213', '$2y$10$Oaz6.KnLp9gO3MEwCZwGsunlJWDOdi9Lwt.KMW6p/O6LxpCpzEile', 0),
(13, 'asdads', 'dasdas', 'mat21matmat@gmail.com', '3112132', 'adasdas132123', '$2y$10$XMIp7uf2oBY4g.3uJQUCz.YyjuHhwJs6zdMajCv0vCxQTTHhPwOR2', 0),
(14, 'sda', 'ads', 'mat21m2mat@gmail.com', '21123132', 'adsdasads321', '$2y$10$zIN8ModbiGuKaeQI74luh.NyKpyvQvaFLu.C1RXDqdR/X9/7GkXcO', 0),
(15, 'adssad', 'asdads', 'mat@gmail.com', '123312132', 'dsasdasda', '$2y$10$NZZ9YrQL2ocK00xRlslXSeTuSIGYV1LUvPi3T1sejzQpcaNyHwv5O', 0),
(16, 'asasd', 'asdasd', 'asdasdasdasd@gmail.com', '1321221312', 'asasd', '$2y$10$5UxkGigmAX2S0QVUgzRAeOq7fe0CVT60SYbn7.K3Vau3h9j/LGdgy', 0),
(17, 'asd', 'qwe', 'qwe@gmail.com', '123 1231 213', 'asads 23', '$2y$10$xyPqGhAk5qdGeOHQZMzbUeLufwbRsF8V5teigL5F4IHZ./s0xlqdG', 0),
(18, 'dasasd', 'asdasd', 'maaasdt@gmail.com', '123132132', 'adsadsdas', '$2y$10$h2m9Mc2.S0q/cWrPduUEqeKexkICVcXb2TDgvKk2tBo/kxmJB.YUO', 0),
(19, 'Admin', 'Admin', 'admin@gmail.com', '213 132123213', 'dsadsada 12/2 a', '$2y$10$haxS2g4kj2xzvgCnQT.FEue9buhiAyeme9OQ1sk2ulPLPB4NB/8VW', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('ordered','rented','completed') NOT NULL,
  `rented_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `member_id`, `created_at`, `status`, `rented_at`, `completed_at`) VALUES
(1, 17, '2024-11-29 10:36:09', 'completed', '2024-11-30 14:17:52', '2024-11-30 14:19:03'),
(3, 17, '2024-11-29 10:43:11', 'completed', '2024-11-30 14:18:06', '2024-11-30 16:53:00'),
(10, 17, '2024-11-30 16:27:46', 'completed', '2024-11-30 16:42:20', '2024-11-30 16:51:02'),
(11, 17, '2024-11-30 17:08:21', 'completed', '2024-12-01 19:40:42', '2024-12-01 19:40:55'),
(12, 17, '2024-12-02 16:36:41', 'completed', '2024-12-02 17:03:26', '2024-12-05 20:57:00'),
(13, 17, '2024-12-02 17:02:59', 'completed', '2024-12-04 20:05:16', '2024-12-04 20:05:23'),
(18, 17, '2024-12-05 21:44:12', 'completed', '2024-12-05 21:45:55', '2024-12-05 21:46:29');

--
-- Triggers `orders`
--
DELIMITER $$
CREATE TRIGGER `set_completed_at` BEFORE UPDATE ON `orders` FOR EACH ROW BEGIN
   IF NEW.status = 'completed' AND OLD.status != 'completed' THEN
      SET NEW.completed_at = IFNULL(NEW.completed_at, NOW());
   END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `set_rented_at` BEFORE UPDATE ON `orders` FOR EACH ROW BEGIN
   IF NEW.status = 'rented' AND OLD.status != 'rented' THEN
      SET NEW.rented_at = IFNULL(NEW.rented_at, NOW());
   END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_copy_id` int(11) NOT NULL,
  `added_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `book_copy_id`, `added_at`) VALUES
(1, 1, 6, '2024-11-29 10:35:37'),
(2, 1, 12, '2024-11-29 10:35:43'),
(5, 3, 6, '2024-11-29 10:42:53'),
(22, 10, 16, '2024-11-30 16:27:44'),
(23, 11, 12, '2024-11-30 17:08:16'),
(24, 11, 6, '2024-11-30 17:08:19'),
(25, 12, 12, '2024-12-02 16:36:35'),
(26, 12, 6, '2024-12-02 16:36:35'),
(28, 13, 1, '2024-12-02 17:02:30'),
(29, 13, 19, '2024-12-02 17:02:55'),
(36, 18, 12, '2024-12-05 21:43:53');

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `publisher_id` int(11) NOT NULL,
  `publisher_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`publisher_id`, `publisher_name`) VALUES
(1, 'Bantam Books'),
(2, 'Orbit');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `publisher_id` (`publisher_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `book_copy`
--
ALTER TABLE `book_copy`
  ADD PRIMARY KEY (`book_copy_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `book_to_author`
--
ALTER TABLE `book_to_author`
  ADD PRIMARY KEY (`book_id`,`author_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `book_copy_id` (`book_copy_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_copy_id` (`book_copy_id`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`publisher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `book_copy`
--
ALTER TABLE `book_copy`
  MODIFY `book_copy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `publisher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`publisher_id`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `book_copy`
--
ALTER TABLE `book_copy`
  ADD CONSTRAINT `book_copy_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Constraints for table `book_to_author`
--
ALTER TABLE `book_to_author`
  ADD CONSTRAINT `book_to_author_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `book_to_author_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `authors` (`author_id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`book_copy_id`) REFERENCES `book_copy` (`book_copy_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_copy_id`) REFERENCES `book_copy` (`book_copy_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
