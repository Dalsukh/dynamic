ALTER TABLE `merchants`  
ADD `latitude` VARCHAR(25) NOT NULL  AFTER `business_type`,  
ADD `longitude` VARCHAR(25) NOT NULL  AFTER `latitude`;

ALTER TABLE `users`  
ADD `latitude` VARCHAR(25) NOT NULL  AFTER `pincode`,  
ADD `longitude` VARCHAR(25) NOT NULL  AFTER `latitude`;

13-02-2017
ALTER TABLE `users`  ADD `image` VARCHAR(512) NOT NULL  AFTER `pincode`,  ADD `mobile_verified` TINYINT NOT NULL  AFTER `image`,  ADD `email_verified` INT NOT NULL  AFTER `mobile_verified`,  ADD `user_package_type` INT NOT NULL  AFTER `email_verified`;


DROP TABLE `merchants`;

CREATE TABLE `merchants` (
  `id` int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,  
  `member_id` varchar(255) NOT NULL,  
  `member_qr_code` varchar(255) NOT NULL,  
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `job_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `pincode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `mobile1` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `mobile2` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `landline1` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `landline2` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `fax1` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `fax2` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `google` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci NOT NULL,  
  `merchant_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `business_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `additional_business` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0-INACTIVE OR UNAPROVED 1-ACTIVE OR APPROVED',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` tinyint(4) NOT NULL COMMENT '0-NO 1-YES'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `category` (
  `id` int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `keywords` text,
  `status` tinyint(4) NOT NULL COMMENT '0-INACTIVE OR UNAPROVED 1-ACTIVE OR APPROVED',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int,
  `deleted` tinyint(4) NOT NULL COMMENT '0-NO 1-YES'
  );
  
CREATE TABLE `sub_category` (
  `id` int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED ,
  `name` varchar(50) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `keywords` text,
  `status` tinyint(4) NOT NULL COMMENT '0-INACTIVE OR UNAPROVED 1-ACTIVE OR APPROVED',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int,
  `deleted` tinyint(4) NOT NULL COMMENT '0-NO 1-YES'
  );
  
CREATE TABLE `products` (
  `id` int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED ,
  `name` varchar(50) NOT NULL,
  `image1` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `image4` varchar(255) NOT NULL,
  `price` float(16,2),
  `description` text,
  `keywords` text,
  `product_code` varchar(25),
  `total_likes` int,
  `total_views` int,
  `status` tinyint(4) NOT NULL COMMENT '0-INACTIVE OR UNAPROVED 1-ACTIVE OR APPROVED',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int,
  `deleted` tinyint(4) NOT NULL COMMENT '0-NO 1-YES'
  );
  


  CREATE TABLE `products_likes` (
  `id` int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED ,  
  `product_id` varchar(25),
  `status` tinyint(4) NOT NULL COMMENT '0-INACTIVE OR UNAPROVED 1-ACTIVE OR APPROVED',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` tinyint(4) NOT NULL COMMENT '0-NO 1-YES'
  );
  

  CREATE TABLE `products_views` (
  `id` int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED ,  
  `product_id` varchar(25),
  `ip_address` varchar(255),
  `status` tinyint(4) NOT NULL COMMENT '0-INACTIVE OR UNAPROVED 1-ACTIVE OR APPROVED',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` tinyint(4) NOT NULL COMMENT '0-NO 1-YES'
  );



  CREATE TABLE `chatting` (
  `id` int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `from_user_id` int(10) UNSIGNED ,  
  `to_user_id` int(10) UNSIGNED ,  
  `message` text,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` tinyint(4) NOT NULL COMMENT '0-NO 1-YES'
  );

  

