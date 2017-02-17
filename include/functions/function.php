<?php
// Get file extension of given file
function getEXT($str)
{
	$t="";
	$string =$str;
	$tok = strtok($string,".");
 	while($tok) {
 		$t=$tok;
 		$tok = strtok(".");
 	}
 	 return $t;
}

function re_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') 
{
    global $$link;

    if (USE_PCONNECT == 'true') {
      $$link = mysql_pconnect($server, $username, $password);
    } else {
      $$link = mysql_connect($server, $username, $password);
    }

    if ($$link) mysql_select_db($database);

    return $$link;
}

function re_db_close($link = 'db_link')
{
    global $$link;
    return mysql_close($$link);
}

function re_db_error($query, $errno, $error) {
    die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br><br>' . $query . '<br><br><small><font color="#ff0000">[RE STOP]</font></small><br><br></b></font>');
}
 
function re_db_query($query, $link = 'db_link')
{
    // Start code for track case book auto delete record........................................
    if(strtolower(substr($query,0,6))=="delete" && isset($_SESSION['mwc']['type']) && $_SESSION['mwc']['type']!="1")
    {
        if($_SESSION['mwc']['type']=="2")
        {
            $delete_access_qry="select * from ".MWC_USER_MASTER." where id='".$_SESSION['mwc']['admin_id']."' and status='1' and is_delete='0'";    
            $delete_access_sql=re_db_query($delete_access_qry);
            $delete_access_rec=re_db_fetch_array($delete_access_sql);
            
            if($delete_access_rec['delete_access']=="1")
            {
                //if(strtotime($delete_access_rec['from_date'])>=strtotime(date('Y-m-d')) && strtotime($delete_access_rec['to_date'])<=strtotime(date('Y-m-d'))) {
                if(strtotime(date('Y-m-d H:i:s'))>=strtotime($delete_access_rec['from_date']) && strtotime(date('Y-m-d H:i:s'))<=strtotime($delete_access_rec['to_date'])) {
                    
                } else {
                    return "";
                }
            }
            else {
                return "";
            }
        }
        else if($_SESSION['mwc']['type']=="3") {
            return "";
        }
    }
    // End code for track case book auto delete record.......................................... 


    global $$link;
	
	if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
	  error_log('QUERY ' . $query . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
	}
		
	$_start = explode(' ', microtime());
	$result = mysql_query($query, $$link) or re_db_error($query, mysql_errno(), mysql_error());
	$_end = explode(' ', microtime());
	$_time = number_format(($_end[1] + $_end[0] - ($_start[1] + $_start[0])), 8);

	if ( defined('EXPLAIN_QUERIES') && (EXPLAIN_QUERIES == 'true') )
	{		
		/* Initially set to store every query */
		$explain_this_query = true;
		/* If the include filter is true just explain queries for those scripts */		
		if ( defined('EXPLAIN_USE_INCLUDE') && (EXPLAIN_USE_INCLUDE == 'true') )
		{
			$explain_this_query = ( ( stripos( EXPLAIN_INCLUDE_FILES, basename($_SERVER['PHP_SELF']) ) ) === false ? false : true );
		}
		/* If the exclude filter is true just explain queries for those that are not listed */		
		if ( defined('EXPLAIN_USE_EXCLUDE') && (EXPLAIN_USE_EXCLUDE == 'true') )
		{
			$explain_this_query = ( ( stripos( EXPLAIN_EXCLUDE_FILES, basename($_SERVER['PHP_SELF']) ) ) === false ? true : false );
		}			
		/* If it still true after running it through the filters store it */	
		if ($explain_this_query) re_explain_query($query, $_time);			
	} # End if EXPLAIN_QUERIES
	
	if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) 
	{
	   $result_error = mysql_error();
	   error_log('RESULT ' . $result . ' ' . $result_error . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
	}	
	
    return $result;
}
  
function re_explain_query($query, $_time, $link = 'db_link')
{
    global $$link;
	/* Makes sure it's a select query and it's not for a session */
	if ( stristr($query, 'select') && !stristr($query, 'sessions') )
    { 
		/* Add the EXPLAIN to the query */
		$explain_query = 'EXPLAIN ' . $query;
		$_query = array('explain_id' => '', # Leave blank to get an autoincrement
						'md5query' => md5($query), # MD5() the query to get a unique that can be indexed
						'query' => $query, # Actual query
						'time' => $_time*1000, # Multiply by 1000 to get milliseconds
						'script' => basename($_SERVER['PHP_SELF']), # Script name
						'request_string' => $_SERVER['QUERY_STRING'] # Query string since some pages are constructed from parameters
						);
		/* Merge the _query and explain arrays */
		$container = array_merge($_query, mysql_fetch_assoc(mysql_query($explain_query)));
		/* Break the array into components so elements can be wrapped */
		foreach($container as $column => $value){
				$columns[] = $column;
				$values[] = $value;
		}		
		/* Wrap the columns and values */ 
		wrap($columns, '`');
		wrap($values);
		/* Implode the columns so they can be used for the insert query below */
		$_columns = implode(', ', $columns);
		$_values = implode(', ', $values);
		/* Insert the data */
		$explain_insert = "INSERT into `explain_queries` ($_columns) VALUES ($_values)";
		mysql_query($explain_insert) or re_db_error($explain_insert, mysql_errno(), mysql_error());		
		/* unset some variables...clean as we go */
		unset( $_query, $container, $columns, $values, $_columns, $_values );
    }
}

  
function re_db_fetch_array($db_query) {
    return mysql_fetch_array($db_query, MYSQL_ASSOC);
}

function re_db_num_rows($db_query) {
    return mysql_num_rows($db_query);
}

function re_db_fetch_assoc($db_query) {
    return mysql_fetch_assoc($db_query);
}

function re_db_affected_rows($db_query) {
    return mysql_affected_rows($db_query);
}

function re_db_data_seek($db_query, $row_number) {
    return mysql_data_seek($db_query, $row_number);
}

function re_db_insert_id() {
    return mysql_insert_id();
}

function re_db_free_result($db_query) {
    return mysql_free_result($db_query);
}

function re_db_fetch_fields($db_query) {
    return mysql_fetch_field($db_query);
}

function re_db_output($string)
{
    $string=preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string);
    $string= stripslashes($string);
    return htmlspecialchars($string);
    //return $string; //htmlspecialchars($string);
}

function re_db_input($string,$db='') 
{
	// Stripslashes
	if (get_magic_quotes_gpc()) 
	{
		$string = stripslashes($string);
	}
	if (!is_numeric($string)) // Quote if not integer
	{
		$string = mysqli_real_escape_string($db,$string);
	}
	else
		$string=$string;

	return $string;
}
  
function re_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link')
{
    reset($data);
    if ($action == 'insert')
    {
        $query = 'insert into ' . $table . ' (';
        while (list($columns, ) = each($data)) {
            $query .= $columns . ', ';
        }
        $query = substr($query, 0, -2) . ') values (';
        reset($data);
        while (list(, $value) = each($data))
        {
            switch ((string)$value)
            {
                case 'now()':
                    $query .= 'now(), ';
                    break;
                case 'CURRENT_DATE()':
                    $query .= 'CURRENT_DATE(), ';
                    break;		  
                case 'null':
                    $query .= 'null, ';
                    break;
                default:
                    if(substr(re_db_input($value),0,23)=="date_add(CURRENT_DATE()") {
                        $query .= re_db_input($value) .', ';
                    }
                    else {
                        $query .= '\'' . re_db_input($value) . '\', ';
                    }
                    break;
            }
        }
        $query = substr($query, 0, -2) . ')';
    }
    elseif ($action == 'update')
    {
      $query = 'update ' . $table . ' set ';
      while (list($columns, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
		  case 'CURRENT_DATE()':
            $query .= 'CURRENT_DATE(), ';
            break;		  
          case 'null':
            $query .= $columns .= ' = null, ';
            break;
          default:
		  	if(substr(re_db_input($value),0,23)=="date_add(CURRENT_DATE()")
			{
				$query .= re_db_input($value) .', ';
			}
			else{
            	$query .= $columns . ' = \'' . re_db_input($value) . '\', ';
			}
            break;
        }
      }
      $query = substr($query, 0, -2) . ' where ' . $parameters;
    }

    return re_db_query($query, $link);
}
  
//function to get ip address while forgot passowrd
function get_ip_address()
{
    if (isset($_SERVER)) {
      if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      } else {
        $ip = $_SERVER['REMOTE_ADDR'];
      }
    } else {
      if (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
      } elseif (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
      } else {
        $ip = getenv('REMOTE_ADDR');
      }
    }

    return $ip;
}

function re_get_all_get_params($exclude_array = '', $extra='')
{
	if(!is_array($exclude_array)) $exclude_array = array();

	$get_url = '';
	if (is_array($_GET) && (sizeof($_GET) > 0))
	{
		reset($_GET);
	  	while (list($key, $value) = each($_GET))
		{
            if ( !is_array($value) && (strlen($value) > 0) && ($key != re_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array)) && ($key != 'x') && ($key != 'y') )
			{
		   		$get_url .=  '&' .$key . '=' . rawurlencode(stripslashes($value)) ;
			}
	  	}
	}
	return ($extra?substr($get_url,1):$get_url);
}

function re_session_name($name = '')
{
    if (!empty($name)) {
        return session_name($name);
    } else {
        return session_name();
    }
}

function shortstr($str,$maxlen)
{
	if(strlen($str)>$maxlen)
	{
		$str=substr($str,0,$maxlen);
		$str.="...";
	}
	return $str;
}

/************************** Pagination Start ****************************/
function pagination($qry_listing, $href_url, $extralink='', $pageno='1', $rec_per_page, $style='subheading', $separator='', $get_var='pageno', $show_first_last_link=true)
{
    $separator='';	 
	$res_listing = re_db_query($qry_listing);        
    $totalRecFound = re_db_num_rows($res_listing);
    
	if($rec_per_page=='' || $rec_per_page=='0')
    {
		$noofpages = RECORDS_PER_PAGE; // this is the number of records to be display on the screen
    } 
	else
    {
		$noofpages = $rec_per_page; // this is the number of records to be display on the screen
    }
    
	$totalRecords=$totalRecFound;
    $totalPages=ceil($totalRecords/$noofpages);    

      
	$showingpage="";
	if($pageno=='')
	{
		$pageno=1;
		$initlimit=0;
	}
	else
	{
		$pageno=$pageno;
		$initlimit=($pageno*$noofpages)-$noofpages;
	}
	
	if($pageno < 6 )
	{
		$startpage = 1;
		if($pageno + 5  > $totalPages )
		{
			$endpage = $totalPages;
		}
		else
		{
			$endpage = 10 ;
		}
	}
	else
	{
		$startpage = $pageno - 5 ;
		if($pageno + 5  > $totalPages )
		{
			$endpage = $totalPages;
		}
		else
		{
			$endpage = $pageno + 5 ;
		}
	}
	
	for($i=$startpage; $i<=$endpage && $i<=$totalPages; $i++)
	{
		if($i==$pageno && $i==$totalPages)
		{
			//$showingpage.=" <strong>$i</strong> ";
            $showingpage.=' <strong>'.$i.'</strong> ';
		}
		else if($i==$pageno) {
            //$showingpage.=" <strong>$i</strong> ".$separator."";
            $showingpage.=' <strong>'.$i.'</strong> '.$separator.'';
            
		}
		else {
            //$showingpage.="<a class='subheading' href='".$href_url."?".$get_var."=$i".$extralink."'>".$i."</a> ".$separator." ";// change link name and give u'r page link
            $showingpage.='<a class="subheading" href="'.$href_url.'?'.$get_var.'='.$i.$extralink.'">'.$i.'</a> '.$separator.' ';// change link name and give u'r page link
		}
	}
	
    if($style=="") { $style='subheading'; }
    
    if($totalPages>1)
	{
		if($pageno=="1")
		{
			$page=$pageno + 1;
			//$next="&nbsp;<a class='".$style."' href='".$href_url."?".$get_var."=$page".$extralink."'>Next</a>";// change link name and give u'r page link
            $next='&nbsp;<a class="'.$style.'" href="'.$href_url.'?'.$get_var.'='.$page.$extralink.'">Next</a>';// change link name and give u'r page link
			$prev="";
		}
        else if($pageno==$totalPages)
		{
			$page=$pageno - 1;
			$next="";
			//$prev="<a class='".$style."' href='".$href_url."?".$get_var."=$page".$extralink."'>Previous</a>&nbsp;&nbsp;";// change link name and give u'r page link
            $prev='<a class="'.$style.'" href="'.$href_url.'?'.$get_var.'='.$page.$extralink.'">Previous</a>&nbsp;&nbsp;';// change link name and give u'r page link
		}
        else
		{
			$page1=$pageno + 1;
			$page2=$pageno - 1;
			//$next="&nbsp;<a class='".$style."' href='".$href_url."?".$get_var."=$page1".$extralink."'>Next</a>";// change link name and give u'r page link
			//$prev="<a class='".$style."' href='".$href_url."?".$get_var."=$page2".$extralink."'>Previous</a>&nbsp;&nbsp;";// change link name and give u'r page link
            $next='&nbsp;<a class="'.$style.'" href="'.$href_url.'?'.$get_var.'='.$page1.$extralink.'">Next</a>';// change link name and give u'r page link
            $prev='<a class="'.$style.'" href="'.$href_url.'?'.$get_var.'='.$page2.$extralink.'">Previous</a>&nbsp;&nbsp;';// change link name and give u'r page link
		}
	}
    else
	{
		$next="";
		$prev="";		
	}
	
    $qry_listing.=" LIMIT $initlimit,$noofpages";
	$res_listing = re_db_query($qry_listing);
	
	$totalRecordFound = re_db_num_rows($res_listing);
	$firstlink='';
	$lastlink='';
	
	if($next != "")
	{
		//$lastlink="... <a class='subheading' href='".$href_url."?".$get_var."=$totalPages".$extralink." ".$status."'>Last&nbsp;<img src="."images/arrow_last.gif"." style='border:0px;'></a> &nbsp;".$next;
        //$lastlink=$next."&nbsp;&nbsp;&nbsp;<a class='subheading' href='".$href_url."?".$get_var."=$totalPages".$extralink."'>Last&nbsp;<img src="."images/next_arrow.gif"." style='border:0px;' class='next_arrow_img'></a>";
        $lastlink=$next.'&nbsp;&nbsp;&nbsp;<a class="subheading" href="'.$href_url.'?'.$get_var.'='.$totalPages.$extralink.'">Last&nbsp;<img src="images/next_arrow.gif" style="border:0px;" class="next_arrow_img"></a>';
	}
	if($prev != "")
	{
		//$firstlink=$prev."&nbsp; <a class='subheading' href='".$href_url."?".$get_var."=1".$extralink." ".$status."'><img src="."images/arrow_first.gif"." style='border:0px;'>&nbsp;First</a> ... ";
        //$firstlink="<a class='subheading' href='".$href_url."?".$get_var."=1".$extralink."'><img src="."images/prev_arrow.gif"." style='border:0px;' class='prev_arrow_img'>&nbsp;First</a>&nbsp;&nbsp;&nbsp;".$prev;
        $firstlink='<a class="subheading" href="'.$href_url.'?'.$get_var.'=1'.$extralink.'"><img src="images/prev_arrow.gif" style="border:0px;" class="prev_arrow_img">&nbsp;First</a>&nbsp;&nbsp;&nbsp;'.$prev;
	}
	
	if($show_first_last_link==true)
    $showingpage="".$firstlink.$showingpage.$lastlink;
    $ret_str=array($res_listing,$showingpage,$totalRecFound,$initlimit,$noofpages,$totalPages);
    return $ret_str;
}
/*####################### Paging function end #################################### */

// add by sunil for the email valid date=>31/07/2009
function validemail($email)
{
    if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
        return 0; 
    }
    else {
		return 1; 
	}
}

function noRecordFound()
{
	echo '<div style="width:100%; color:#FF0000; font-size:18px; text-align:center; margin:10px 0px 10px 0px; ">No Record Found</div>';
}

//function to insert date in databse in yyyy/mm/dd format..................................
function input_date($date)
{

	if($date!="" && strlen($date)>=10)
	{
		$dd=substr($date,0,2);
		$mm=substr($date,3,2);
		$yyyy=substr($date,6,4);
		return $yyyy.'-'.$mm.'-'.$dd;
	}
	else {
		return $date;
	}
}

//function to disaplay date in dd/mm/yyyy format..................................
function output_date($date)
{

	if($date!="" && strlen($date)>=10)
	{
		$yyyy=substr($date,0,4);
		$mm=substr($date,5,2);
		$dd=substr($date,8,2);
		return $dd.'/'.$mm.'/'.$yyyy;
	}
	else {
		return $date;
	}

}

//date validation function $str=yyyy-mm-dd........................................
function is_date($str)
{
	$stamp = strtotime( $str );
	if (!is_numeric($stamp))
	{
		return FALSE;
	}
	
	//$month = date( 'm', $stamp ); $day   = date( 'd', $stamp ); $year  = date( 'Y', $stamp );
    $date_arr = explode('/', output_date($str));    //output_date function return date in dd/mm/yyyy formate
    $day = $date_arr[0];
    $month = $date_arr[1];
    $year = $date_arr[2];
	
	if (checkdate($month, $day, $year))
	{
	 	return TRUE;
	}
	else
	{
        return FALSE;
	}
}

//email validation function.......................
function is_email($email)
{
	if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email)) {
		return 0; 
		//echo $email; exit;
	}
	else
    {
		$email_arr=explode("@",$email);
        $after_at=explode(".",$email_arr[1]);        
        if(strlen($email_arr[0])<2) {
                    return 0; 
        }
        else if(strlen($after_at[0])<2) { 
            return 0;
        }  
        else { 
            return 1; 
        }                   
        //return 1; 
	}
}

// function for validate only charactor and wite space............................
function is_char_space($name)
{
    if(!preg_match("/^[a-zA-Z -]+$/",$name))
    {
        return 0;
    }
    else {
        return 1;
    }
}

//phone number validation function........................................
function is_phone_number($phoneNumber)
{    
    //Check to make sure the phone number format is valid 
    if( !preg_match("/^([1]-)?[0-9]{3}-[0-9]{3}-[0-9]{4}$/i", $phoneNumber)) {
		return 0; 
	}
	else {
		return 1; 
	}
}

function get_single_value($field,$tabel,$where)
{
    $sql=re_db_query("select ".$field." from ".$tabel." where ".$where);
	if(re_db_num_rows($sql)>0)
	{
		$rec=re_db_fetch_array($sql);
		return $rec[$field];
	}
	else { return ''; }
}

function random_password_generate()
{
    $possible_letters = '23456789bcdfghjkmnpqrstvwxyz';
    $i = 0;
    $code="";
    
    for($i=0; $i<6; $i++)
    { 
        $code .= substr($possible_letters, mt_rand(0, strlen($possible_letters)-1), 1);
    }
    return $code;
}

function display_error_msg(&$error_msg)
{	?>
	<div style="width:95%; clear:both;padding-bottom:5px;">
	<?php
    for($i=0;$i<sizeof($error_msg); $i++)
	{	?>
		<div style="clear:both;font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; color:#000000" align="left">
			<font color="#FF0000"><?php echo ucfirst(strtolower($error_msg[$i])); ?></font>
		</div>
	<?php
	}	?>
	</div>
	<?php
}
function display_msg($val)
{  ?>
		<div class="sucessBox" align="left" style="clear:both; width:auto"> 
					<?php echo $val; ?>
		</div><br />
<?php }
// Start of Check Email is valid or Not

function sendMail($from="parmar.dalsukh@gmail.com",$to="",$subject="")
{
	/**
	 * This example shows making an SMTP connection without using authentication.
	 */

	//SMTP needs accurate times, and the PHP time zone MUST be set
	//This should be done in your php.ini, but this is how to do it if you don't have access to that
	date_default_timezone_set('Etc/UTC');

	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	//Tell PHPMailer to use SMTP
	//$mail->isSendmail();
	$mail->isSMTP();
	$mail->Host = 'mx1.hostinger.nl';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = false;                              

	$mail->Port = 587;
		
	//Set who the message is to be sent from
	$mail->setFrom($from, 'Dalsukh Parmar');
	
	//Set who the message is to be sent to
	$mail->addAddress($to, "test");
	//Set the subject line
	$mail->Subject = $subject;
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
	//Replace the plain text body with one created manually
	$mail->AltBody = 'This is a plain-text message body';
	
	//send the message, check for errors
	$return = array();
	if (!$mail->send()) {
	    $return['status'] = "fail";
	    $return['msg'] = "Mailer Error: " . $mail->ErrorInfo;
	} else {
	    $return['status'] = "success";
	    $return['msg'] = "Message sent!";
	}
	return $return;
}
?>