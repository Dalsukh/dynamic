<?php
	/*	Author Name :Dalsukh Parmar
	 *	Start Date	:30-06-2015
	 *	End Date	:04-07-2015
	 *	Comment		:Insert Update Delete Sorting Column-wise Searching in One Page
					With Only One Form for Insert And Update
	 */
	require_once("../include/config.php");
	//include_once('include/AES.php');
	$admin = new Admin($db);
	$admin->checkLogin();
	
	
	extract($_SESSION);
	extract($_POST);
	extract($_GET);
	$count=0;
	
	/*else if(!isset($user_id)){
		header("Location:login.php");
	}*/
	
	if(isset($btn_delete) && isset($chk_del))
	{
		foreach($chk_del as $id)
		{
			$update="update tbl_user set user_status=0 Where user_id=$id";
			$res=re_db_query($update);
			if($res){
				$msg="Delete Success";
			}
		}
	}
	$content="index";
	require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>
