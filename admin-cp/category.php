<?php
require_once("../include/config.php");
/*
INSERT INTO `category` (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$category = new Category($db);
$category->store();
$content="category";
require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>


