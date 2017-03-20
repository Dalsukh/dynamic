<?php
$admin = new Admin($db);
$admin->checkLogin();
require_once('header.php');
require_once('left-side-bar.php');
require_once(DIR_FS_CONTENT_ADMIN.$content.'.tpl.php');
require_once('footer.php');
?>