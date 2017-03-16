<?php
require_once("../include/config.php");
/*
INSERT INTO `sub_category` (`id`, `category_id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, NULL, '', '', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '');
*/
$category = new Category($db);
$data = $category->index();
$data = $data['data'];
$subCategory = new SubCategory($db);
$subCategory->store($_REQUEST);

require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");

?>


