<html>
	<head>
	<script>
		$(window).bind('scroll', function() {
     if ($(window).scrollTop() > 50) {
         $('#nav').addClass('fixed');
     }
     else {
         $('#nav').removeClass('fixed');
     }
	});
	</script>

		<script src="lib/jquery-2.1.4.min.js" type="text/javascript"></script>
<link href="<?php echo SITE_URL_CSS;?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo SITE_URL_CSS;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo SITE_URL_CSS;?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo SITE_URL_CSS;?>sbootstrap/css/bootstrap-theme.min.css" rel="stylesheet">

<script src="<?php echo SITE_URL_CSS;?>bootstrap/js/bootstrap.js"></script>
<script src="<?php echo SITE_URL_CSS;?>bootstrap/js/bootstrap.min.js"></script>
<link href="<?php echo SITE_URL_CSS;?>style.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo SITE_URL_CSS;?>menu.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo SITE_URL_CSS;?>default.css" type="text/css" media="scree">
	</head>
	<body>
		<div id="example">
		<ul id="nav">
			<?php if(isset($user_type) && $_SESSION['user_type']=="ADMIN"){
			?>
			<li><a href="index.php">Home</a></li>
			<li><a href="profile.php">Profile</a></li>
			<li><a href="add_post.php">Add Post</a></li>
			<li><a href="post.php">View Post</a></li>
			<li><a href="index.php?Add" id="Add">Add New User</a></li>
			<li style="float:right"><a href="logout.php">Logout</a></li>
			<?php
			}else if(isset($user_type) && $_SESSION['user_type']=="NORMAL"){
			?>
			<li><a href="home.php">Home</a></li>
			<li><a href="home.php?action=edit" id="edit">Edit Profile</a></li>
			<li><a href="post.php">Post</a></li>
			<li style="float:right"><a href="logout.php">Logout</a></li>
			<?php
				}
				else
				{
			?>
			<li><a href="login.php">Login</a></li>
			<li><a href="post.php">View Post</a></li>
			<?php
			}
			?>
						<li style="float:right" class="current"><a>Welcome <?php if(isset($user_id)){echo $user_name;}else {echo "Guest";}?></a></li>
		</ul>
	</body>
</html>
