-- Vistaprint Clone Database Schema

CREATE DATABASE IF NOT EXISTS `vistaprint_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `vistaprint_db`;

-- Drop tables in correct order if they exist
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `banners`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `subcategories`;
DROP TABLE IF EXISTS `categories`;
SET FOREIGN_KEY_CHECKS = 1;

-- Categories Table
CREATE TABLE `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `icon_class` VARCHAR(100) DEFAULT NULL,
  `template_type` VARCHAR(50) DEFAULT 'category_detail',
  `description` TEXT DEFAULT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Subcategories Table
CREATE TABLE `subcategories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `is_new` TINYINT DEFAULT 0,
  `status` TINYINT DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Products Table
CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `subcategory_id` INT NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `starting_price` DECIMAL(10,2) NOT NULL,
  `unit_price` DECIMAL(10,2) DEFAULT NULL,
  `unit_label` VARCHAR(50) DEFAULT '100 units',
  `rating` DECIMAL(2,1) DEFAULT 4.5,
  `review_count` INT DEFAULT 0,
  `tag` VARCHAR(100) DEFAULT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `section` VARCHAR(50) DEFAULT 'other',
  `is_new` TINYINT DEFAULT 0,
  `status` TINYINT DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Banners Table
CREATE TABLE `banners` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `type` VARCHAR(50) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `subtitle` VARCHAR(255) DEFAULT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `button1_text` VARCHAR(100) DEFAULT NULL,
  `button1_link` VARCHAR(255) DEFAULT NULL,
  `button2_text` VARCHAR(100) DEFAULT NULL,
  `button2_link` VARCHAR(255) DEFAULT NULL,
  `button3_text` VARCHAR(100) DEFAULT NULL,
  `button3_link` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Users Table
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Orders Table
CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT DEFAULT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `shipping_address` TEXT NOT NULL,
  `payment_status` VARCHAR(50) DEFAULT 'Pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Order Items Table
CREATE TABLE `order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `product_id` INT DEFAULT NULL,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `options` TEXT DEFAULT NULL,
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
