-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 25, 2022 at 12:08 AM
-- Server version: 10.2.38-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mypos`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `iat_email_queue`
--

CREATE TABLE `iat_email_queue` (
  `supplier_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ibt_email_queue`
--

CREATE TABLE `ibt_email_queue` (
  `supplier_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `product_id` int(11) NOT NULL,
  `quantity` int(10) UNSIGNED DEFAULT NULL,
  `cart_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `new_user_email`
--

CREATE TABLE `new_user_email` (
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `description` varchar(255) DEFAULT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `price` float UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `new_sale` AFTER INSERT ON `products` FOR EACH ROW BEGIN
   INSERT INTO sales(
       num_sales,
       product_id
    )
VALUES(
    0,
    NEW.id
) ;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `product_above_threshold` AFTER INSERT ON `products` FOR EACH ROW BEGIN
        IF NEW.stock > 100 THEN
    INSERT INTO iat_email_queue(
        supplier_id,
        product_id,
        name
    )
VALUES(
    NEW.supplier_id,
    NEW.id,
    NEW.name
) ;
    END IF ;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `product_below_threshold` AFTER INSERT ON `products` FOR EACH ROW BEGIN
        IF NEW.stock < 5 THEN
    INSERT INTO ibt_email_queue(
        supplier_id,
        product_id,
        name
    )
VALUES(
    NEW.supplier_id,
    NEW.id,
    NEW.name
) ;
    END IF ;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_sale` AFTER UPDATE ON `products` FOR EACH ROW BEGIN
	if NEW.stock < OLD.stock THEN
   UPDATE sales SET num_sales = num_sales + (OLD.stock - NEW.stock) WHERE product_id = NEW.id;
   END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `num_sales` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shopping_carts`
--

CREATE TABLE `shopping_carts` (
  `cart_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `subtotal` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `payment_amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `transactions`
--
DELIMITER $$
CREATE TRIGGER `transaction_done` AFTER INSERT ON `transactions` FOR EACH ROW BEGIN
    INSERT INTO transaction_email(
        user_id,
        payment_amount,
        transaction_date
    )
VALUES(
    NEW.user_id,
    NEW.payment_amount,
    NEW.date
) ;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_email`
--

CREATE TABLE `transaction_email` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `payment_amount` float(10,2) NOT NULL,
  `transaction_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `first_name` varchar(32) DEFAULT NULL,
  `last_name` varchar(32) DEFAULT NULL,
  `registration_date` datetime NOT NULL,
  `street` varchar(64) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `state` varchar(32) DEFAULT NULL,
  `zip_code` varchar(8) DEFAULT NULL,
  `country` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `new_user` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    INSERT INTO new_user_email(
        first_name,
        last_name,
        email,
        user_id
    )
VALUES(
    NEW.first_name,
    NEW.last_name,
    NEW.email,
    NEW.user_id
) ;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_payment`
--

CREATE TABLE `user_payment` (
  `card_number` int(16) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `iat_email_queue`
--
ALTER TABLE `iat_email_queue`
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `ibt_email_queue`
--
ALTER TABLE `ibt_email_queue`
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`product_id`,`cart_id`);

--
-- Indexes for table `new_user_email`
--
ALTER TABLE `new_user_email`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaction_email`
--
ALTER TABLE `transaction_email`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `login` (`username`,`pass`);

--
-- Indexes for table `user_payment`
--
ALTER TABLE `user_payment`
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  MODIFY `cart_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `iat_email_queue`
--
ALTER TABLE `iat_email_queue`
  ADD CONSTRAINT `iat_email_queue_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`);

--
-- Constraints for table `ibt_email_queue`
--
ALTER TABLE `ibt_email_queue`
  ADD CONSTRAINT `ibt_email_queue_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`);

--
-- Constraints for table `new_user_email`
--
ALTER TABLE `new_user_email`
  ADD CONSTRAINT `new_user_email_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  ADD CONSTRAINT `shopping_carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `transaction_email`
--
ALTER TABLE `transaction_email`
  ADD CONSTRAINT `transaction_email_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `transactions` (`user_id`);

--
-- Constraints for table `user_payment`
--
ALTER TABLE `user_payment`
  ADD CONSTRAINT `user_payment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `pass`, `first_name`, `last_name`, `registration_date`, `street`, `city`, `state`, `zip_code`, `country`) VALUES
(1, 'admin', 'admin@admin.com', SHA2('admin', 512), 'admin', 'admin', NOW(), NULL, NULL, NULL, NULL, NULL),
(2, 'supplier', 'supplier@supplier.com', SHA2('supplier', 512), 'supplier', 'supplier', NOW(), NULL, NULL, NULL, NULL, NULL),
(3, 'user', 'user@user.com', SHA2('user', 512), 'user', 'user', NOW(), NULL, NULL, NULL, NULL, NULL);

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `user_id`) VALUES
(1, 1);

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`user_id`) VALUES
(1),
(2);

--
-- Dumping data for table `shopping_carts`
--

INSERT INTO `shopping_carts` (`cart_id`, `user_id`, `subtotal`) VALUES
(1, 1, 0),
(2, 2, 0),
(3, 3, 0);

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`name`, `category`, `stock`, `description`, `supplier_id`, `price`) VALUES
('Apple', 'fruit', '23', 'Juicy, sweet, and crisp.', '2', '1.18'),
('Carrot', 'vegetable', '8', 'For you and your rabbit.', '2', '0.98'),
('Dr Pepper, 24 pack', 'soda', '12', 'A sweet treat.', '2', '8.98'),
('Fresh Salmon Portions', 'fish', '4', 'Wild caught.', '2', '11.29'),
('Soap, 12 bars', 'toiletry', '6', 'Smells good.', '2', '13.97'),
('Coconut Water, 4 pack', 'drink', '6', 'The best.', '2', '6.24');