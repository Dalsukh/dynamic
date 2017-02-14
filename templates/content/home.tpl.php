<?php
	session_start();
	/*	Author Name :Dalsukh Parmar
	 *	Start Date	:07-07-2015
	 *	End Date	:07-07-2015
	 *	Comment		:Insert Update Delete Sorting Column-wise Searching in One Page
					With Only One Form for Insert And Update
	 */
	extract($_SESSION);
	if(!isset($user_id))
	{
		header("Location:login.php");
		exit(0);
	}
	
	include "boot.php";
	require_once("lib/config.php");
	
?>
<?php
	extract($_POST);
	extract($_GET);
	$count=0;
	
	
	
	
	if(isset($btn_submit))
	{
		if(empty($txt_name))
		{
			$count++;
			$err_name="Please Enter Name";
		}
		require_once("ajax_user.php");
		if(empty($txt_email))
		{
			$count++;
			$err_email="Please Enter Email";
		}
		else if(!filter_var($txt_email,FILTER_VALIDATE_EMAIL))
		{
			$count++;
			$err_email="Please Enter Proper Email";
		}
		else if(isset($user_exist)){
		
			$count++;
			$err_email="User Already Registered";
		}
		if(empty($txt_password))
		{
			$err_pass="Enter Password";
			$count++;
		}
		if(empty($txt_city))
		{
			$count++;
			$err_city="Please Enter City";
		}
		if(empty($txt_mobile))
		{
			$count++;
			$err_mobile="Please Enter Mobile No.";
		}
		else if(strlen($txt_mobile)<10 || !is_numeric($txt_mobile))
		{
			$count++;
			$err_mobile="Enter 10 Digit No. only.";
		}
		if(!isset($chk_hobby))
		{
			$count++;
			$err_hobby="Please Select Hobby";
		}
        if($sel_stream=="Select")
        {
            $count++;
            $err_stream="Please Select Stream";   
        }
		
        $photo=$_FILES['file_img']['name'];
		$target_file = basename($_FILES["file_img"]["name"]);
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	    
		}
		
    
	
		if(!empty($photo)){
		
			if($imageFileType != "jpg" && $imageFileType != "png" 
				&& $imageFileType != "jpeg" && $imageFileType != "gif" ) 
			{
				$count++;
				$err_file="Select Only jpg png gif image";
			}
		}
        
    
			
	
	
    if(isset($btn_submit) && $btn_submit=="Update" && $count==0)
	{
		$target_file="";
		if($_FILES['file_img']['name']=="")
		{
			$target_file="$txt_file";
		}
		else{
		$target_file="upload/".$_FILES['file_img']['name'];
		move_uploaded_file($_FILES["file_img"]["tmp_name"], $target_file);
		}
		$hobby=implode(",",$chk_hobby);
		
		$hobby=implode(",",$chk_hobby);
		$update="Update tbl_user set
                user_name='$txt_name',
                user_email='$txt_email',
				user_password='$txt_password',
				user_stream='$sel_stream',
				user_photo='$target_file',
				user_hobby='$hobby',
                user_city='$txt_city'
				Where user_id=$txt_id";
				//echo $update;
				
		$res=mysql_query($update);
		if($res)
			$msg="Update Successfully";
		else
			$msg="Not Successfully";
	}
	
	
?>
<html>
	<head>
		<title>User Home Page</title>
		<script>
			function validate()
			{
				var error=0;
				//alert("Hi");
				var name=document.frm_reg.txt_name;
				if(name.value==""){
				document.getElementById("err_name").innerHTML="Enter Name";				
				name.focus(); error++; return false;}
				else{
				document.getElementById("err_name").innerHTML="";
				}
				
				var reg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
				
				
 
				var email=document.frm_reg.txt_email;
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
				
				var mobile=document.frm_reg.txt_mobile;
				if(mobile.value=="")
				{
					document.getElementById("err_mobile").innerHTML="Enter Mobile No";
					mobile.focus();
					error++;
					return false;
					
				}
				hobby=document.getElementsByName("chk_hobby[]");
				var mark=0;
				for(var i=0;i<hobby.length;i++)
				{
					//alert("Hi");
					
					if(hobby[i].checked==true)
					{
						mark=mark+1;
					}
					
				}
				
				if(mark<1)
					{
					document.getElementById("err_hobby").innerHTML="Select Hobby";
					//	alert("Please Attempt Hobby");
					error++;
					return false;
					}
					else{
						document.getElementById("err_hobby").innerHTML="";
					}
			
			
	var pass=document.frm_reg.txt_password;
				if(pass.value==""){
				document.getElementById("err_pass").innerHTML="Enter Password";								
				pass.focus(); error++;
				}
				else{document.getElementById("err_pass").innerHTML="";}
				
				
				var file=document.frm_reg.file_img;
				var txt_file=document.frm_reg.txt_file;
				//alert(file.value);
				if(file.value=="" && txt_file=="")
				{
					document.getElementById("err_file").innerHTML="Select a Image";
					file.focus();
					return false;
				}
				var city=document.frm_reg.txt_city;
				if(city.value==""){
				document.getElementById("err_city").innerHTML="Enter City";
				city.focus(); 
				error++;
				return false;
				}
				
				if(error>0)
				{
					return false;
				}
			}
			window.history.pushState("User Home Page", "Home Page", "home.php");
			function check_user()
		{
		var xmlhttp;
		var email=document.getElementById("txt_email").value;
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 )
			{
				if(xmlhttp.responseText=="")
				{
				}
				else
				{
				document.getElementById("err_email").innerHTML=xmlhttp.responseText;
				}
			}
		  }
		 if(email!=="")
		 {
		xmlhttp.open("GET","ajax_user.php?email="+email,true);
		xmlhttp.send();
		}
		}
		
	function acceprOnlyNumeric(evt)
    {
        var num = evt.value.replace(/[^0-9]/g,"");
        evt.value = num;
    }
		</script>
		<script src="lib/jquery-2.1.4.min.js" type="text/javascript"></script>
		<script>
		
		$(document).ready(function(){
				
			$("#edit").click(function(){
			//alert("Hi");
			$("#UserReg").show();
			$("#UserReg").attr('class', 'show');
			
			});
			/*$("#show").click(function(){
			$("p").show();
			});*/
			
			
			// binding the check all box to chk_all click event
    $(".chk_all").click(function () {
	
		var checkAll = $(".chk_all").prop('checked');
		if (checkAll) {
			$(".checkboxes").prop("checked", true);
		} else {
			$(".checkboxes").prop("checked", false);
		}	
        
    });
 
    // if all checkbox are selected, check the chk_all checkbox class and vise versa
    $(".checkboxes").click(function(){
 
        if($(".checkboxes").length == $(".subscheked:checked").length) {
            $(".chk_all").attr("checked", "checked");
        } else {
            $(".chk_all").removeAttr("checked");
        }
 
    });
	
		});
		</script>
		<style>
			.hide
			{
				visibility:hidden;
				display:none;
			}
			.show{
				display:block;
				visibility:visible;
				
			}
			input
			{
				hieght:30px;
				border-radius:2px;
			}
			#frm_reg span
			{
				color:red;
				width:250px;
				text-align:left;
				
			}
			.bold
			{
				font-weight:bolder;
				color:white;
				background:red;
			}
		</style>
	</head>
	<?php require_once ("header.php");?>
	<body bgcolor="FAF0FF">
		<h3 align="center" style="color:green"><?php if(isset($msg)){ echo $msg; }?></h3>
		<div id="UserReg" class="<?php if(isset($action) || isset($Add)|| $count>0){echo "show";}else{echo "hide";}?>">
		<h1 align="center"> User <?php if(!isset($action)){ echo "Registration";  }else {echo "Update";} ?> Page</h1>
		<br/><br/>
		<form name="frm_reg" id="frm_reg" method="POST"  onSubmit="return validate()" enctype="multipart/form-data">
		
		<table align="center" width="0%" >
			<?php
				//if(isset($action)){
				$select="select * from tbl_user Where user_id=$user_id";
				$result=mysql_query($select);
				$action="edit";
				$erow=mysql_fetch_array($result);
				echo "<input type='hidden' value='$user_id' name='txt_id'>";
				//}
				//else{
					//unset($action);
				//}
				if(isset($btn_submit) && $btn_submit=="Update")
				{
					echo "<input type='hidden' value='$txt_id' name='txt_id'>";
				}
				
			?>
			<tr>
				<td width="120px">User Name</td>
				<td><input type="text" name="txt_name" 
				<?php if(isset($action)){echo "value='$erow[user_name]'"; }?>
				<?php if(isset($btn_submit)){echo "value='$txt_name'"; }?>></td>
				<td ><span id="err_name"><?Php if(isset($err_name)) echo $err_name;?></span></td>
				
			</tr>
			<tr>
				<td>User Email</td>
				<td><input type="text" id="txt_email" name="txt_email" <?php if(!isset($action)){ echo "onBlur='check_user()'";}?> <?php if(isset($action)){echo "value='$erow[user_email]'"; }?>
				<?php if(isset($btn_submit)){echo "value='$txt_email'"; }?>				
				placeholder="sometext@example.com"></td>
				<td><span id="err_email"><?Php if(isset($err_email)) echo $err_email;?></span>
				</td>
			</tr>
			<tr>
				<td>User Password</td>
				<td><input type="password" id="txt_password" name="txt_password" value="<?php echo $erow['user_password']?>"></td>
				<td><span id="err_pass"><?Php if(isset($err_pass)) echo $err_pass;?></span>
				</td>
			</tr>
			<tr>
				<?php $stream=array("BCA","MCA","BBA","MBA");?>
				<td>User Stream</td>
				<td><select name="sel_stream">
					<option value="Select">Select Stream</option>
					<?php 
						foreach($stream as $val)
						{
							echo "<option value='$val'";
							if(isset($action) && $erow['user_stream']==$val){echo "selected";}
							else if(isset($btn_submit) && $sel_stream==$val){echo "selected";}
							echo ">$val</option>";
						}
					?>
					
				</td>
				<td><span id="err_stream"><?Php if(isset($err_stream)) echo $err_stream;?></span>
				</td>
			</tr>
			
			<tr>
				<td>User Mobile</td>
				<td><input type="text" name="txt_mobile" onKeyUp="acceprOnlyNumeric(this)" maxlength="10" <?php if(isset($action)){echo "value='$erow[user_mobile]'"; }?>
					<?php if(isset($btn_submit)){echo "value='$txt_mobile'"; }?>
				></td>
				<td width=""><span id="err_mobile"><?Php if(isset($err_mobile)) echo $err_mobile;?></span></td>
			</tr>
			<tr>
				<?php
					$hb="";
					if(isset($action))
					{
						$h=array();
						$h=explode(",",$erow['user_hobby'],3);
						$hb=$erow['user_hobby'];
					}
					else if(isset($btn_submit) && isset($chk_hobby))
					{
						$h=array();
						//$h=explode(",",$chk_hobby,3);
						$hb=implode($chk_hobby);
					}
					
				?>
				<td>User Hobby</td>
				<td>Cricket<input type="checkbox" name="chk_hobby[]" value="Cricket" <?php if(strstr($hb,"Cricket")){echo "checked";}?>><br/>
					Vollyball<input type="checkbox" name="chk_hobby[]" value="Vollyball" <?php if(strstr($hb,"Vollyball")){echo "checked";}?>><br/>
					Bedmintan<input type="checkbox" name="chk_hobby[]" value="Bedmintan" <?php if(strstr($hb,"Bedmintan")){echo "checked";}?>>
				</td>
			<td width="150px"><span id="err_hobby"><?Php if(isset($err_hobby)) echo $err_hobby;?></span></td>
			</tr>
			
			<!--tr>
				<td>User Password</td>
				<td><input type="password" name="txt_password" <?php if(isset($action)){echo "value='$erow[user_password]'"; }?> ></td>
				<td><span id="err_pass"><?Php if(isset($err_pass)) echo $err_pass;?></span>
				</td>
			</tr>
			<tr>
				<td>Confirm Password</td>
				<td><input type="password" name="txt_cpassword" <?php if(isset($action)){echo "value='$erow[user_cpassword]'"; }?> ></td><td>
				<span id="err_cpass"><?Php if(isset($err_cpass)) echo $err_cpass;?></span>
				</td>
			</tr-->
			<tr>
				<td>User City</td>
				<td><input type="text" name="txt_city" <?php if(isset($action)){echo "value='$erow[user_city]'"; }?>
				<?php if(isset($btn_submit)){echo "value='$txt_city'"; }?>
				></td><td>
				<span id="err_city"><?Php if(isset($err_city)) echo $err_city;?></span>
				</td>
			</tr>
			<tr>
				<td>User Photo</td>
				<td><input type="file" name="file_img"> 
				<?php if(isset($action)){
					echo "<img src='$erow[user_photo]' width='30'>"; 
					echo "<input type='hidden' name='txt_file' value='$erow[user_photo]'>";
					}else if(isset($btn_submit))
					{	
						if($btn_submit=="Update"){
						echo "<img src='$txt_file' width='30'>"; 
						echo "<input type='hidden' name='txt_file' value='$txt_file'>";
						}
					}
					?></td>
				<td width=""><span id="err_file"><?Php if(isset($err_file)) echo $err_file;?></span></td>
			</tr>
			<tr>
				
				<td>&nbsp;</td>
				<td>
					<?php 
						if(isset($action) || isset($btn_submit) && $btn_submit=="Update")
						{?>
							<input type="submit" name="btn_submit" value="Update">&nbsp;&nbsp;
						<?php
						}
						?>
					
					<input type="reset" name="btn_reset" value="clear"/>
				</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	
	</form>
	</div>
	<br/><br/><br/><br/><br/>
	<?php
	extract($_GET);
	extract($_POST);
	?>

	
	<?php
		$select="select * from tbl_user Where user_status=1 AND user_id=$user_id";
		$result=mysql_query($select);
		$row=mysql_fetch_assoc($result);
	?>
	<table align="center" cellspacing="5">
		<tr>
			<td>&nbsp;</td>
			<td><h1 align="center"> User Profile</h1></td>
		</tr>
		<tr>
			<td rowspan="5" width="200"><img src="<?php echo $row['user_photo'];?>" height="200" width="150"></td>
			<td><h2>User Name :</h2></td><td><h2><?php echo $row['user_name'];?></h2></td>
		</tr>
		<tr>
			<td><h3>Email :</td><td><?php echo $row['user_email'];?></h3></td>
		</tr>
		<tr>
			<td><h3>Stream:</td><td><?php echo $row['user_stream'];?></h3></td>
		</tr>
		<tr>
			<td><h3>Mobile :</td><td><?php echo $row['user_mobile'];?></h3></td>
		</tr>
		<tr>
			<td><h3>Hobby :</td><td><?php echo $row['user_hobby'];?></h3></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><h3>City :</td><td><?php echo $row['user_city'];?></h3></td>
		</tr>
	</table>
	<br/><br/><br/>
	</body>
</html> 