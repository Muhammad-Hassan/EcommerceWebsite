-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2017 at 05:02 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecomdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(1, 'Levis'),
(2, 'Nikes'),
(7, 'Polo'),
(8, 'Armani'),
(9, 'Chase'),
(10, 'Servis'),
(11, 'Bata'),
(12, 'Hush Puppies'),
(13, 'Children Wear'),
(14, 'Kenes Jewellers'),
(15, 'Monster Caps'),
(16, 'Fast Track'),
(17, 'Khaddi');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `shipped` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`, `shipped`) VALUES
(3, '[{\"id\":\"8\",\"size\":\"8\",\"quantity\":1}]', '2017-03-21 10:54:07', 0, 0),
(4, '[{\"id\":\"8\",\"size\":\"8\",\"quantity\":\"1\"}]', '2017-03-23 21:57:31', 0, 0),
(5, '[{\"id\":\"9\",\"size\":\"small\",\"quantity\":\"1\"},{\"id\":\"16\",\"size\":\"Small\",\"quantity\":2}]', '2017-04-10 03:11:34', 1, 0),
(6, '[{\"id\":\"10\",\"size\":\"small\",\"quantity\":\"3\"}]', '2017-04-10 03:26:02', 1, 0),
(7, '[{\"id\":\"13\",\"size\":\"Standard Size\",\"quantity\":\"3\"}]', '2017-04-10 03:30:40', 1, 0),
(8, '[{\"id\":\"12\",\"size\":\"small\",\"quantity\":\"3\"}]', '2017-04-10 03:39:34', 1, 0),
(14, '[{\"id\":\"12\",\"size\":\"small\",\"quantity\":\"2\"}]', '2017-04-11 05:23:51', 1, 0),
(15, '[{\"id\":\"12\",\"size\":\"small\",\"quantity\":\"2\"}]', '2017-04-11 05:26:43', 1, 0),
(17, '[{\"id\":\"14\",\"size\":\"Standard Size\",\"quantity\":\"1\"}]', '2017-04-11 05:34:16', 1, 0),
(20, '[{\"id\":\"9\",\"size\":\"small\",\"quantity\":2}]', '2017-04-11 05:41:56', 1, 1),
(21, '[{\"id\":\"31\",\"size\":\"Standard Size\",\"quantity\":1}]', '2017-04-11 05:43:19', 1, 0),
(22, '[{\"id\":\"20\",\"size\":\"small\",\"quantity\":\"1\"}]', '2017-04-12 04:58:55', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Men', 0),
(2, 'Women', 0),
(3, 'Boys', 0),
(4, 'Girls', 0),
(5, 'Shirts', 1),
(6, 'Pants', 1),
(7, 'Shoes', 1),
(8, 'Accessories', 1),
(9, 'Shirts', 2),
(10, 'Pants', 2),
(11, 'Shoes', 2),
(12, 'Dresses', 2),
(13, 'Shirts', 3),
(14, 'Pants', 3),
(15, 'Dresses', 4),
(16, 'Shoes', 4),
(29, 'Skirts', 4),
(30, 'Accessories', 2),
(31, 'Accessories', 3),
(32, 'Accessories', 4),
(33, 'Dresses', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `sizes` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `sizes`, `deleted`) VALUES
(1, 'Levi&#039;s Jeans', '19.99', '54.99', 1, '6', '', 'These jeans are great and comfortable to wear.', 0, '28:5,32:3,36:1', 1),
(6, 'Girls Dress', '69.00', '89.00', 8, '15', '/ecom/images/products/e03beb163cb8fd9ba8c51f5fe09ec76f.png', 'This dress is very comfortable for girls.', 1, 'small:2,medium:2,large:3', 0),
(7, 'Levis Jeans', '45.00', '50.00', 1, '6', '/ecom/images/products/c0412de7f877f3bc43a7c990a4d8b966.jpg', 'These jeans are highly popular in fashion these days.', 1, 'small:5,med:6', 0),
(8, 'High Heels', '99.00', '110.00', 10, '11', '/ecom/images/products/5d17c4a3bca9cc3d56e7768af9dbf18b.jpg', 'These high heels are very fashionable to wear in parties.', 1, '8:3,9:4,10:2', 0),
(9, 'Hoodie', '35.00', '50.00', 9, '13', '/ecom/images/products/48bb151b560873463438c70a2a6bf3e7.png', 'These hoodies are great for boys to wear and to be in fashion.', 1, 'small:2,medium:6,large:4', 0),
(10, 'Sweater', '49.00', '55.00', 13, '13', '/ecom/images/products/a929cf231f0bb3027059d37bfb61f179.png', 'This sweater is very elegant and made of pure fabric.', 1, 'small:6,medium:11,large:6', 0),
(11, 'Shorts', '25.00', '40.00', 13, '14', '/ecom/images/products/799fadda24f363336f4fff01e35dd20e.png', 'This short is great for boys to wear.', 1, 'small:15,medium:6,large:11', 0),
(12, 'Party Dress', '120.00', '130.00', 9, '15', '/ecom/images/products/74e3b4388b35e145193e9bb859d94d07.png', 'This dress is very fashionable to wear for parties.', 1, 'small:26,medium:10,large:4', 0),
(13, 'Purse', '50.00', '60.00', 9, '30', '/ecom/images/products/68d813c12507e0d36e221066d7dcc1aa.png', 'This purse is very cheap and in fashion for women.', 1, 'Standard Size:42', 0),
(14, 'Jewellery Set', '550.00', '600.00', 14, '30', '/ecom/images/products/8d65db56ecaf50a87e464d21182b2084.jpg', 'This jewellery set is very stylish for women.', 1, 'Standard Size:49', 0),
(15, 'Sun Glasses', '250.00', '300.00', 8, '30', '/ecom/images/products/0684be89a669e72c61a4ce9ec7a2b3cb.jpg', 'These sun glasses are extremely great for fashion these days.', 1, 'Standard Size:20', 0),
(16, 'Armani Shirt', '150.00', '175.00', 8, '5', '/ecom/images/products/889d6e3d5c6aec0e19c298d0d62910d5.jpg', 'These shirts are in for fashion these days . Grab yours as soon as possible.', 1, 'Small:38,medium:30,Large:55', 0),
(17, 'Cap', '100.00', '110.00', 15, '8', '/ecom/images/products/ac31328cfb7c82318a674048b0a2c09b.jpg', 'These caps really fit nice in fashion!', 1, 'Small:50,medium:60', 0),
(18, 'Sports Watch', '299.00', '315.00', 16, '31', '/ecom/images/products/5abfaf5c1ecb19db5ecaba89a746dcc4.jpg', '', 1, 'Standard Size:65', 0),
(19, 'Women Watch', '450.00', '490.00', 9, '30', '/ecom/images/products/94623f008bf33d3c281d855ec3f3fd45.jpg', 'This watch is an amazing in style.', 1, 'Standard Size:65', 0),
(20, 'Shirt', '90.00', '100.00', 7, '13', '/ecom/images/products/cc316d9df9cebff394e483d0983e8f08.jpg', 'Amazing Shirt for boys!', 1, 'small:54', 0),
(21, 'Boys Pants', '155.00', '165.00', 1, '14', '/ecom/images/products/3a55156b3d33a727214f75369f590655.jpg', 'This pant is available and in stock now grab before it runs out!', 1, 'Small:88', 0),
(22, 'Pink Purse', '125.00', '130.00', 9, '32', '/ecom/images/products/80adbe6d45fa9479aad2201f83cad95c.jpg', 'This purse is beautiful and stylish to carry for girls!', 1, 'Standard Size:69', 0),
(23, 'Multi color Scarf ', '45.00', '55.00', 8, '32', '/ecom/images/products/bda2cd76a9124c393cc753476f2fc113.jpg', 'This beautiful scarf is in for fashion and amazing to wear on head.', 1, 'Standard Size:44', 0),
(24, 'Nike Shoes', '225.00', '230.00', 2, '7', '/ecom/images/products/347edaf7a1fede94bdd816fa936dad94.jpg', 'These shoes are great for sports and normal wear.', 1, '8:44,9:55,10:75', 0),
(25, 'Nike Grey Cap', '100.00', '110.00', 2, '31', '/ecom/images/products/aa7c9c2d304c32f26ac89e473c3e6227.jpg', 'This cap is amazing for boys !', 1, 'Standard Size:20', 0),
(26, 'Nike Grey TShirt', '46.00', '60.00', 2, '13', '/ecom/images/products/1fd3a9511f36de484a3814dc5c6c9e73.jpg', 'This tshirt is great to wear for boys during summer.', 1, 'Small:44,Medium:40', 0),
(27, 'Nike Pants', '80.00', '90.00', 2, '6', '/ecom/images/products/42718ec9fa8e79b8d5ca16439f722514.jpg', 'This pant is amazing !', 1, 'Standard Size:45', 0),
(28, 'Denim Jacket', '190.00', '200.00', 1, '5', '/ecom/images/products/fbec5a2469c86380191579a77bf3108a.jpg', 'This Jacket is great fit for men.', 1, 'Medium:44,Large:55,Extra Large:55', 0),
(29, 'Shalwar Kameez', '180.00', '190.00', 17, '12', '/ecom/images/products/13e8be7e1d296f482b4f672c10cdc15a.jpg', 'This shalwar kameez is latest in fashion!', 1, 'Medium:40,Large:50', 0),
(30, 'Business Suit', '500.00', '510.00', 9, '33', '/ecom/images/products/5bd48866671d729debae977243ac7d90.jpg', 'This suit is great for men!', 1, 'Large:50', 0),
(31, 'Purple Tie', '40.00', '45.00', 9, '8', '/ecom/images/products/26a7f35a775a2f4a8891d64a464930a2.gif', 'This tie is great in fashion!', 1, 'Standard Size:4', 0),
(32, 'Pink Shoes', '99.00', '110.00', 12, '16', '/ecom/images/products/af87caaf13232229b8e59958a4bcbe6b.jpg', 'These shoes are great!', 1, '4:5,5:6,6:7', 0),
(33, 'Belt', '45.00', '50.00', 11, '8', '/ecom/images/products/fe2bb56b13e39f2129233181c48867a6.jpg', 'This belt is great and in black color only!', 1, 'Standard:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `charge_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cart_id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `zipCode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `subTotal` int(11) NOT NULL,
  `tax` int(11) NOT NULL,
  `grandTotal` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `txn_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `charge_id`, `cart_id`, `full_name`, `email`, `street`, `city`, `zipCode`, `country`, `contact`, `subTotal`, `tax`, `grandTotal`, `description`, `txn_type`, `txn_date`) VALUES
(1, 'ch_19wC7zBOzsmwDBNnBr75XFVG', 15, 'asdasd', 'mcssmhassan@gmail.com', 'asdasd', 'asdas', '13213', 'sadas', '4512', 240, 0, 240, '2 items from Boutique.', 'charge', '2017-03-11 20:27:12'),
(2, 'ch_19wCFaBOzsmwDBNnjxrQh3kJ', 17, 'Syed Kashif', 'mcssmhassan@gmail.com', 'ksadlnasdn', 'Karachi', '12345', 'Pakistan', '0341555998', 550, 0, 550, '1 item from Boutique.', 'charge', '2017-03-11 20:35:03'),
(3, 'ch_19wCN8BOzsmwDBNnOixjxRXi', 20, 'Syed Wahav', 'wahab@mail.com', 'nandjasnkd', 'knasdnn', '131513', 'nadiasbid', '13215321321', 70, 0, 70, '2 items from Boutique.', 'charge', '2017-03-11 20:42:51'),
(4, 'ch_19wUp5BOzsmwDBNnCuCImAWY', 21, 'Syed', 'mcssmhassan@gmail.com', 'nasdnjasndjn', 'Karachi', '123456', 'Pakistan', '4213265231', 40, 0, 40, '1 item from Boutique.', 'charge', '2017-03-12 17:24:57'),
(5, 'ch_19wkMLBOzsmwDBNnKeDJfrpb', 22, 'Syed Muhammad Kashif', 'kashif@gmail.com', 'askjndkajsndj', 'Karachi', '12345', 'Pakistan', '03115584529', 90, 0, 90, '1 item from Boutique.', 'charge', '2017-03-13 09:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `permissions` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `join_date`, `last_login`, `permissions`) VALUES
(6, 'Abdul Wahab', 'wahab@gmail.com', '$2y$10$.0L2.kcwkgMIlJbTWNkYe.4aYB2ujrNNOoAcd3526tgpWP1jQ5LU.', '2017-02-15 20:49:45', '2017-02-16 05:58:54', 'admin,editor'),
(7, 'Syed Muhammad Hassan', 'mcssmhassan@gmail.com', '$2y$10$JKuRKbI59101EbLN.YxrROD9TtJ0DSXImrxIDbVndl8pRsbVvvO6i', '2017-02-15 20:59:18', '2017-03-12 17:09:43', 'admin,editor'),
(8, 'Syed Kashif', 'kashif@gmail.com', '$2y$10$//G1lzCa9ZzVGqQ2b1DfouQyGMe1QWAeq2A8m28XIqdoISR6eyIca', '2017-02-15 21:04:22', '2017-02-15 21:04:22', 'editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
