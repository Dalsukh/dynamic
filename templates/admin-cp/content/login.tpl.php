<?php
	session_start();
	extract($_POST);
	extract($_SESSION);
	require_once("lib/config.php");
	$count=0;
	if(isset($user_type))
	{
		if($user_type=="ADMIN")
			header("Location:index.php");
		else	
			header("Location:home.php");
	}
	if(isset($btn_login))
	{
		if(empty($txt_email))
		{
			$count++;
			$err_email="Please Enter Email";
		}
		else if(!filter_var($txt_email,FILTER_VALIDATE_EMAIL))
		{
			$count++;
			$err_email="Please Enter Valid Email";
		}
		if(empty($txt_password)){
		$count++;
		$err_pass="Please Enter Password";}

		
	}
	if(isset($btn_login) && $count==0)
	{
		
		
		$select="Select * from tbl_user WHERE user_email='$txt_email' AND user_password='$txt_password'";
		$result=mysql_query($select);
		if(mysql_num_rows($result)>0)
		{
			$row=mysql_fetch_array($result);
			$_SESSION['user_id']=$row['user_id'];
			$_SESSION['user_name']=$row['user_name'];
			$_SESSION['user_type']=$row['user_type'];
			
			if($row['user_type']=="ADMIN")
				header("Location:index.php");
			else
				header("Location:home.php");
			
		}
		else
		{
			$msg="User Email OR Password Are Incorrect";
		}
		}
	
	include "boot.php";
	?>
<html>
	<head>	
		<link href="css/style.css" rel="stylesheet"/>
		<title>Login Page</title>
		<script>
			function validate()
			{
				var error=0;
				//alert("Hi");
	
				var reg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
				var email=document.frm_login.txt_email;
				var str = email.value;      
				if(email.value==""){
				document.getElementById("err_email").innerHTML="Enter Email";								
				email.focus(); error++; return false;}
				else if (!reg.test(str)){
				
					document.getElementById("err_email").innerHTML="Enter Proper Email";								
					email.focus();
					error++;
					return false;
				}else{document.getElementById("err_email").innerHTML="";}
				
				
				
				var pass=document.frm_login.txt_password;
				if(pass.value==""){
				document.getElementById("err_pass").innerHTML="Enter Password";								
				pass.focus(); error++;
				}
				else{document.getElementById("err_pass").innerHTML="";}
				
				
				
				if(error>0)
				{
					return false;
				}
			}
		</script>
	</head>
	<body>
		<?php
			include("header.php");
		?>
		<br/><br/>
		<h1 align="center"> USER LOGIN PAGE</h1>
		<h3 align="center"> Login For View Post And Comment On Post</h3>
		<br/><br/>
		<center>
		<div id="login">
		<form method="POST" name="frm_login" action="<?php ///echo $_SERVER['PHP_SELF'];?>" onSubmit="return validate()">
		<table align="center">
			<tr>
			<td colspan="3" align="left">
			<span class="err"><?php if(isset($msg)){echo $msg;}?></span>
			&nbsp;
			</td>
			<tr>
				<td>User Email</td>
				<td><input type="text" name="txt_email"></td>
				<td width="150"><span id="err_email" class="err"><?php if(isset($err_email)){ echo $err_email;}?></span></td>
				 
			</tr>
			<tr><td>Password</td><td><input type="password" name="txt_password"></td>
					<td><span id="err_pass" class="err"><?php if(isset($err_pass)){ echo $err_pass;}?></span></td>
			</tr>
			<tr><td>&nbsp;</td>
				<td><input type="submit" value="Login" name="btn_login" class="btn-success"></td>
			</tr>
			
		</table>
		</form>
	</div>
	</body
	</center>
</html>