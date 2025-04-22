SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `address` (
  `address_id` int NOT NULL,
  `user_id` int NOT NULL,
  `address_type` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `street_number` int NOT NULL,
  `street_number_addon` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
  `postal_code` varchar(55) NOT NULL,
  `created_at` varchar(55) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `offline` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `address` (`address_id`, `user_id`, `address_type`, `country`, `province`, `city`, `street_name`, `street_number`, `street_number_addon`, `postal_code`, `created_at`, `active`, `offline`) VALUES
(2, 1, 'factuuradres', 'Nederland', 'Noord-Holland', 'Asmterdam', 'Kerkstraat', 2, '0', '1671AB', '14/03/2025 09:50:02', 0, 0),
(3, 1, 'bezorgadres', 'Nederland', 'Noord-Holland', 'Medemblik', 'Koningshof', 25, '0', '1671AM', '14/03/2025 10:20:08', 0, 0);

-- --------------------------------------------------------


CREATE TABLE `category` (
  `category_id` int NOT NULL,
  `restaurant_id` int NOT NULL,
  `category_name` varchar(55) NOT NULL,
  `dish_amount` int DEFAULT NULL,
  `category_img_src` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `offline` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `category` (`category_id`, `restaurant_id`, `category_name`, `dish_amount`, `category_img_src`, `created_at`, `offline`) VALUES
(1, 7, 'Pizza', NULL, NULL, '2025-03-10 14:20:50', 0),
(2, 7, 'Sushi', NULL, NULL, '2025-03-11 09:22:35', 0),
(3, 7, 'Test', NULL, NULL, '2025-03-11 14:42:32', 0);

-- --------------------------------------------------------


CREATE TABLE `dishes` (
  `dish_id` int NOT NULL,
  `restaurant_id` int NOT NULL,
  `category_id` int NOT NULL,
  `toppings_id` int DEFAULT NULL,
  `dish_name` varchar(55) NOT NULL,
  `dish_price` decimal(20,2) NOT NULL,
  `dish_desc` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `dish_img_src` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `order_amount` int DEFAULT NULL,
  `active_discount` int DEFAULT NULL,
  `created_by` varchar(55) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `offline` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `dishes` (`dish_id`, `restaurant_id`, `category_id`, `toppings_id`, `dish_name`, `dish_price`, `dish_desc`, `dish_img_src`, `order_amount`, `active_discount`, `created_by`, `created_at`, `offline`) VALUES
(1, 7, 1, NULL, 'Pizza Margherita', 12.95, 'Beste pizza ooit, gemaakt vanuit italiaans recept', '../img/productimg/bakkerijraat_productimg/product_img_resid-7_67d1612541e13.jpg', NULL, NULL, 'Jan jansen', '2025-03-10 14:20:50', 0),
(2, 7, 2, NULL, 'Sushi Roll Zalm 6st.', 14.95, 'Vers gerolde sushiroll met zalm', '../img/productimg/bakkerijraat_productimg/product_img_resid-7_67d13bc2998d4.jpg', NULL, NULL, 'Jan jansen', '2025-03-11 10:50:15', 0),
(3, 7, 1, NULL, 'Pizza Pollo', 14.95, 'Steenoven pizza versgebakken', '../img/productimg/bakkerijraat_productimg/product_img_resid-7_67d13bd870eaa.jpg', NULL, NULL, 'Jan jansen', '2025-03-11 12:09:40', 0),
(4, 7, 1, NULL, 'Pizza Salame', 9.99, 'Meest gekozen pizza', '../img/productimg/bakkerijraat_productimg/product_img_resid-7_67d13c1d69f97.jpg', NULL, NULL, 'Jan jansen', '2025-03-11 13:47:04', 0),
(5, 7, 1, NULL, 'Pizza Tonno', 14.99, 'Beste pizza ooit', '../img/productimg/bakkerijraat_productimg/product_img_resid-7_67d15e8436281.jpg', NULL, NULL, 'Jan jansen', '2025-03-11 13:47:59', 0),
(6, 7, 2, NULL, 'Sushi Roll Kip 6st.', 18.99, 'Vers gerolde sushi rolls', '../img/productimg/bakkerijraat_productimg/product_img_resid-7_67d159fcf1613.jpg', NULL, NULL, 'Jan jansen', '2025-03-11 13:52:37', 0);

-- --------------------------------------------------------


CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `restaurant_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `address_id` int DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `order_date` varchar(55) NOT NULL,
  `order_delivery_note` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `order_food_note` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `offline` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `orders` (`order_id`, `restaurant_id`, `user_id`, `address_id`, `address`, `order_date`, `order_delivery_note`, `order_food_note`, `offline`) VALUES
(2, 7, 0, 2, 'Kerkstraat 20, 1671AB Asmterdam, Nederland', '2025-03-14 15:38:43', 'peetje', '', 0);


CREATE TABLE `order_dishes` (
  `dish_order_id` int NOT NULL,
  `order_id` int NOT NULL,
  `dish_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `order_dishes` (`dish_order_id`, `order_id`, `dish_id`, `quantity`, `price`, `created_at`) VALUES
(1, 2, 1, 5, 12.95, '2025-03-14 15:38:43'),
(2, 2, 4, 2, 9.99, '2025-03-14 15:38:43'),
(3, 2, 3, 5, 14.95, '2025-03-14 15:38:43'),
(4, 2, 2, 3, 14.95, '2025-03-14 15:38:43');


CREATE TABLE `restaurants` (
  `restaurant_id` int NOT NULL,
  `restaurant_name` varchar(255) NOT NULL,
  `total_orders` int DEFAULT NULL,
  `total_dishes` int DEFAULT NULL,
  `total_categories` int DEFAULT NULL,
  `restaurant_logo_src` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `offline` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `restaurants` (`restaurant_id`, `restaurant_name`, `total_orders`, `total_dishes`, `total_categories`, `restaurant_logo_src`, `offline`) VALUES
(1, 'Bij Oost', NULL, NULL, NULL, NULL, 0),
(2, 'New York Pizza', NULL, NULL, NULL, NULL, 0),
(3, 'Bistro Op3', NULL, NULL, NULL, NULL, 0),
(4, 'Pizzeria Medemblik', NULL, NULL, NULL, NULL, 0),
(5, 'Herberg de Compagnie', NULL, NULL, NULL, NULL, 0),
(6, 'IJssalon Medemblik', NULL, NULL, NULL, NULL, 0),
(7, 'Bakkerij Raat', NULL, NULL, NULL, NULL, 0),
(8, 'Eetcafé De Kwikkel', NULL, NULL, NULL, NULL, 0),
(9, 'De Driemaster', NULL, NULL, NULL, NULL, 0),
(10, 'Eetcafé Rumours', NULL, NULL, NULL, NULL, 0);


CREATE TABLE `toppings` (
  `toppings_id` int NOT NULL,
  `dish_id` int NOT NULL,
  `topping_name` varchar(55) NOT NULL,
  `topping_price` int NOT NULL,
  `offline` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `restaurant_id` int DEFAULT NULL,
  `fname` varchar(55) NOT NULL,
  `lname` varchar(55) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(55) DEFAULT NULL,
  `profile_img_src` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `offline` tinyint(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`user_id`, `user_type`, `restaurant_id`, `fname`, `lname`, `email`, `password`, `username`, `phone`, `date_of_birth`, `gender`, `profile_img_src`, `created_at`, `offline`, `last_login`) VALUES
(1, 'res_owner', 7, 'Jan', 'jansen', 'janjansen@voorbeeld.com', '$2y$10$teN7dDE8EFHEWocd6MuiaOA8231siv/BMbG3Y1hv4WyQM6N3/biAS', 'janjansen12', '+31 0687654321', '2003-02-22', 'male', '67d4303eb1d487.44047900.webp', '04/03/2025 om 13:07:11', 0, '2025-03-14 15:21:50'),
(2, 'gebruiker', NULL, 'peetje', 'peet', 'peetje@voorbeeld.com', '$2y$10$VTdPG2iLaFY8lfJ6tUatau1vYb0KWDEmvYqKkjlUeRVibPS5ZYzrC', 'peetje', '+31 0612345678', NULL, NULL, NULL, '04/03/2025 om 13:15:05', 0, NULL);

ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);


ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);


ALTER TABLE `dishes`
  ADD PRIMARY KEY (`dish_id`);


ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);


ALTER TABLE `order_dishes`
  ADD PRIMARY KEY (`dish_order_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `dish_id` (`dish_id`);


ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`restaurant_id`);


ALTER TABLE `toppings`
  ADD PRIMARY KEY (`toppings_id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);


ALTER TABLE `address`
  MODIFY `address_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `dishes`
  MODIFY `dish_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `order_dishes`
  MODIFY `dish_order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `restaurants`
  MODIFY `restaurant_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;


ALTER TABLE `toppings`
  MODIFY `toppings_id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;




ALTER TABLE `order_dishes`
  ADD CONSTRAINT `order_dishes_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_dishes_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`);
COMMIT;
