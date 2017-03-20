<?php
require_once("../include/config.php");
/*
INSERT INTO `category` (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$product = new Product($db);
$products = $product->index($data = array('user_id'=>"1"));
$products = $products['data'];


$content=basename($_SERVER['REQUEST_URI'],".php");
require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>


