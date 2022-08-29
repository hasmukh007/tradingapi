SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `account_id` int(10) UNSIGNED NOT NULL,
  `date` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `order_id` varchar(25) NOT NULL,
  `symbol` varchar(20) NOT NULL,
  `side` enum('buy','sell') NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL,
  `charges` decimal(10,2) UNSIGNED DEFAULT NULL,
  `charges_details` varchar(255) DEFAULT NULL,
  `status` enum('pending','open','closing','closed','cancel') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid_aid_dt_status` (`client_id`,`account_id`,`date`,`time`,`status`) USING BTREE,
  ADD KEY `date_status` (`date`,`status`) USING BTREE,
  ADD KEY `cid_dt_status` (`client_id`,`date`,`time`,`status`) USING BTREE,
  ADD KEY `cid_date_status` (`client_id`,`date`,`status`) USING BTREE;


ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
