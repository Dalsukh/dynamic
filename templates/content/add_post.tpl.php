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
	
	if(isset($btn_post))
	{
		if(empty($txt_name))
		{
			$count++;
			$err_name="Please Enter Post Name";
		}
		if(empty($txt_desc))
		{
			$count++;
			$err_desc="Please Enter Post Description";
		}
	}		
	
    if(isset($btn_post) && $count==0)
	{
	
		$insert="Insert into tbl_post values('',$user_id,'$txt_name','$txt_desc',1)";
		$res=mysql_query($insert);
		if($res)
			$msg="Posted Successfully";
		else
			$msg="Not Successfully";
	}
	if(isset($btn_comment))
	{
		if(empty($txt_comment))
		{
			$count++;
			$err_comm="Enter Comment:";
		}
	}
	if(isset($btn_comment) && $count==0)
	{
		$insert="Insert Into tbl_comment values('',$txt_post_id,$user_id,'$txt_comment',0)";
		$result=mysql_query($insert);
		
		if($result)
			$msg="Comment Successfully and Forword for Approval";
		else
			$msg="Not Successfully";
	}
	?>
	
<html>
	<head>
		<title>User Post Comment Page</title>
		<script>
			function post_validate()
			{
				var name=document.frm_post.txt_name;
				if(name.value==""){
					alert("Enter Post Name:");
					return false;
				}
				var desc=document.frm_post.txt_desc;
				if(desc.value=="")
				{
					alert("Enter Post Description");
					return false;
					
				}
			}
			function comment_validate(form)
			{
				var error=0;
				var comm=document.forms[form].txt_comment.value;
				if(comm==""){
				alert("Fill  Comment");
				return false;
				}
			}
			//window.history.pushState("User Home Page", "Home Page", "home.php");
			
		
	function acceprOnlyNumeric(evt)
    {
        var num = evt.value.replace(/[^0-9]/g,"");
        evt.value = num;
    }
		</script>
		<script src="lib/jquery-2.1.4.min.js" type="text/javascript"></script>
		<script>
		
		/*$(document).ready(function(){
				
			$("#edit").click(function(){
			//alert("Hi");
			$("#UserReg").show();
			$("#UserReg").attr('class', 'show');
			
			});
			/*$("#show").click(function(){
			$("p").show();
			});*/
			
			
			// binding the check all box to chk_all click event
    
	//	});
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
			#by{
				color:blue;
				font-weight:bolder;
			}
			#title{
				color:#335599
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
			#cname{
				color:#FA00FF;
				font-weight:bold;
			}
			#comment
			{
				//*border:2px solid green;*/
				padding:10px;
			}
		</style>
	</head>
	<?php require_once ("header.php");?>
	<body bgcolor="FAF0FF">
		<br/><br/>
		<h3 align="center" style="color:green"><?php if(isset($msg)){ echo $msg; }?></h3>
		<h1 align="center">Post Added By Admin User</h1>
		
		<div id="PostPage">
		<br/><br/>
		<?php
			$select="Select * from tbl_post p JOIN tbl_user u ON p.post_user_id=u.user_id";
			if(isset($post_id))
				$select=$select." WHERE p.post_id=$post_id";
				
			$result=mysql_query($select);
			while($row=mysql_fetch_array($result))
			{
		?>
		<!--<div id="comment">
		<form method="post" name="frm_comment_<?php echo $row['post_id'];?>" onSubmit="return comment_validate(this.name)">
		<table align="center" width="35%">
			<tr>
				<td id="by">By:<?php echo $row['user_name'];?></td>
			</tr>
			<tr>
				<td id="title">Title:<?php if(strlen($row['post_name'])>25 && !isset($post_id)){
						echo "<a href='?post_id=$row[post_id]'>".substr_replace($row['post_name'],"...",25,50)."</a>";
						}else{echo $row['post_name'];}
						?></td>
			</tr>
			<tr><td colspan=""><?php echo $row['post_discription'];?></td></tr>
			<tr>
				<td><input type="text" name="txt_comment">
				<input type="hidden" name="txt_post_id" value="<?php echo $row['post_id']; ?>">
				<input type="submit" name="btn_comment" value="Comment"></td>
			</tr>
			<tr><td style="color:red" ><span name="err_<?php echo $row['post_id']; ?>">&nbsp;<?php if(isset($err_comm) && $txt_post_id==$row['post_id']){echo $err_comm;}?></span></td></tr>
			<?php
				$query="SELECT * FROM tbl_comment c JOIN tbl_post p ON c.post_id=p.post_id
													JOIN tbl_user u ON c.user_id=u.user_id
													WHERE p.post_id=$row[post_id]";
				if($user_type=="NORMAL")
				{
					$query=$query." AND comm_status=1";
				}
				$res=mysql_query($query);
				$total=mysql_num_rows($res);
				if(mysql_num_rows($res)>0)
					echo "<tr><td>Comments : $total</td></tr>";
				while($rec=mysql_fetch_assoc($res))
				{
					echo "<tr><td>";
					echo "<span id='cname'>".$rec['user_name']."</span><br/>";
					if($user_type=="ADMIN" && $rec['comm_status']==0)
					echo "<A href='approve_comment.php?comment_id=".$rec['comm_id']."&action=1'> <b>Approve </b></a> ";
					else if($user_type=="ADMIN" && $rec['comm_status']==1)
					echo "<A href='approve_comment.php?comment_id=".$rec['comm_id']."&action=0'> <b>Cancel </b></a> ";
					echo $rec['comment'];
					echo "</td></tr>";
				}
													
						
			?>
			<tr>
			</tr>
		</table>
		<hr size="10"/>
		</form>
		</div>
		!--><?php
			}
		?>
		<?php 
			if($user_type=="ADMIN"){
		?>
		<form name="frm_post" id="frm_post" method="POST"  onSubmit="return post_validate()" enctype="multipart/form-data">
		<table align="center" width="35%">
			<tr>
				<td colspan="2" align="center">
					<h3>Add Post</h3>
				</td>
			</tr>
			
			<tr>
				<td width="120px">Post Name</td>
				<td><input type="text" name="txt_name" ></td>
				<td ><span id="err_name"><?Php if(isset($err_name)) echo $err_name;?></span></td>
			</tr>
			<tr>
				<td>Post Desc</td>
				<td><textarea  id="txt_desc" name="txt_desc" cols="23"></textarea></td>
				<td><span id="err_desc"><?Php if(isset($err_desc)) echo $err_desc;?></span>
				</td>
			</tr>
			
			<tr>
				
				<td>&nbsp;</td>
				<td>
				<input type="submit" name="btn_post" value="Post">&nbsp;&nbsp;
				</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	
	</form>
	<?php
	}
	?>
	</div>
	<br/><br/><br/><br/><br/>
	
	</body>
</html> 