-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2024 at 03:24 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ph_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(100) NOT NULL,
  `dish_id` int(100) NOT NULL,
  `uid` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `size` varchar(100) NOT NULL,
  `qty` int(50) NOT NULL,
  `price` int(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `totalprice` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `dish_id`, `uid`, `name`, `size`, `qty`, `price`, `img`, `totalprice`) VALUES
(29, 14, 131810001, 'Hawaiian Supreme', '9\"', 1, 409, 'hawaiian_supreme.png', 818),
(30, 4, 131810001, 'BBQ Chicken Supreme', '9\"', 1, 409, 'bbq_supreme.jpg', 3681),
(36, 17, 131810001, 'Cheese Lovers', '9\"', 1, 379, 'cheese_lovers.png', 379);

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `dish_id` int(100) NOT NULL,
  `categoryID` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slogan` varchar(255) NOT NULL,
  `size` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`dish_id`, `categoryID`, `name`, `slogan`, `size`, `price`, `img`) VALUES
(4, 1, 'BBQ Chicken Supreme', 'BBQ sauce, mozzarella, BBQ-coated chicken chunks, mushrooms, onions and parsley.', '9\" Pan Pizza', 409, 'bbq_supreme.jpg'),
(6, 2, 'Baked Ziti', 'Ziti noodles, Bolognese sauce, white sauce, mozzarella cheese, parmesan cheese, dried parsley', 'Regular', 199, 'baked_ziti.jpg'),
(7, 2, 'Baked Carbonara', 'Baked spaghetti in the classic creamy white sauce with ham and mushrooms.', 'Regular', 359, 'baked_carbonara.jpg'),
(8, 2, 'Baked Bolognese', 'Baked spaghetti pasta cooked al dente with savory sweet Bolognese sauce.', 'Regular', 349, 'baked_bolognese.jpg'),
(9, 2, 'Baked Bolognese with Meatballs', 'Baked pasta in savory-sweet Bolognese sauce and Italian meatballs. An all-time fave!', 'Regular', 679, 'baked_bolognese-meatballs.jpg'),
(10, 3, 'Pepsi', '', '1.5L', 139, 'pepsi.png'),
(11, 3, '7-UP', '', '1.5L', 139, '7-up.png'),
(12, 3, 'Mountain Dew', '', '1.5L', 139, 'mt_dew.png'),
(14, 1, 'Hawaiian Supreme', 'Say \'Aloha\' to our all-time favorite with double layers of ham and pineapple!', '9\" Pan Pizza', 409, 'hawaiian_supreme.png'),
(15, 1, 'Pepperoni Lovers', 'A true classic- pepperoni and mozzarella cheese on our signature pizza sauce.', '9\" Pan Pizza', 379, 'pepperoni_lovers.jpg'),
(16, 1, 'Veggie Lovers', 'Crunchy bell peppers, mushrooms, onions and juicy pineapples on a double layer of mozzarella cheese.', '9\" Pan Pizza', 379, 'veggie_lovers.jpg'),
(17, 1, 'Cheese Lovers', 'Mozzarella, parmesan and cheddar cheeses. A cheese lover\'s delight.', '9\" Pan Pizza', 379, 'cheese_lovers.png'),
(18, 1, 'Bacon Cheeseburger', 'Beef, bacon and a triple layer of cheddar and mozzarella on our signature pizza sauce', '9\" Pan Pizza', 409, 'bacon_cheeseburger.png'),
(19, 1, 'Bacon Supreme', 'Two layers of toasted bacon with bell peppers, onions and mushrooms on our signature pizza sauce.', '9\" Pan Pizza', 409, 'bacon_supreme.png'),
(21, 1, 'Supreme', 'Six delightful toppings - beef, pepperoni, seasoned pork, bell pepper, onions and mushrooms.', '9\" Pan Pizza', 409, 'supreme.png'),
(22, 1, 'Bacon Margherita', 'Tomatoes, basil, cheddar and mozzarella cheese topped with bacon and parmesan.', '9\" Pan Pizza', 409, 'bacon_margherita.png'),
(23, 3, 'Bottled Water', '', '500ML', 39, 'bottled_water.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `food_category`
--

CREATE TABLE `food_category` (
  `categoryID` int(100) NOT NULL,
  `cName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_category`
--

INSERT INTO `food_category` (`categoryID`, `cName`) VALUES
(1, 'Pizza'),
(2, 'Pasta'),
(3, 'Beverages');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msgID` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msgID`, `title`, `category`, `description`, `image`, `date_created`) VALUES
(2, 'Grand Opening of Pizza Hut Ayala', 'Promotion', 'Join us in the GRAND OPENING of our newest store in Ayala Circuit Makati! 🎉 \r\nLocated at the Lower GF, Circuit Lane, Ayala Malls Circuit. Open for dine-in, takeout, delivery and with our delivery partners GrabFood and foodpanda. 🍕\r\n#PizzaHutPH #NewStore #NewStoreAlert', 'ph_ayala.jpg', '2024-02-02 01:15:27');

-- --------------------------------------------------------

--
-- Table structure for table `msg_users`
--

CREATE TABLE `msg_users` (
  `user_msgID` int(50) NOT NULL,
  `uid` int(50) NOT NULL,
  `msgID` int(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `address` varchar(255) NOT NULL,
  `id` int(50) NOT NULL,
  `uid` int(50) NOT NULL,
  `details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `email`, `address`, `password`) VALUES
(131810001, 'customer01@gmail.com', 'B4 L23 Kimberton Ville, Niog 2, Bacoor City, Cavite', '202cb962ac59075b964b07152d234b70'),
(131810002, 'pizzahut_kiosk@gmail.com', NULL, '202cb962ac59075b964b07152d234b70');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_cart` (`uid`),
  ADD KEY `dish_cart` (`dish_id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`dish_id`),
  ADD KEY `dish_category` (`categoryID`);

--
-- Indexes for table `food_category`
--
ALTER TABLE `food_category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msgID`);

--
-- Indexes for table `msg_users`
--
ALTER TABLE `msg_users`
  ADD PRIMARY KEY (`user_msgID`),
  ADD KEY `msgID` (`msgID`),
  ADD KEY `users` (`uid`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `dish_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `food_category`
--
ALTER TABLE `food_category`
  MODIFY `categoryID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msgID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `msg_users`
--
ALTER TABLE `msg_users`
  MODIFY `user_msgID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131810003;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `dish_cart` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_cart` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dishes`
--
ALTER TABLE `dishes`
  ADD CONSTRAINT `dish_category` FOREIGN KEY (`categoryID`) REFERENCES `food_category` (`categoryID`) ON DELETE CASCADE;

--
-- Constraints for table `msg_users`
--
ALTER TABLE `msg_users`
  ADD CONSTRAINT `msgID` FOREIGN KEY (`msgID`) REFERENCES `messages` (`msgID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
