<?php
require_once("../include/config.php");

if(isset($_REQUEST['latitude']) && isset($_REQUEST['longitude']))
{
		$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($_REQUEST['latitude']).','.trim($_REQUEST['longitude']).'&sensor=false';
		$geocode_stats = file_get_contents($url); 
		$result='no city found';
		$output_deals = json_decode($geocode_stats); 
		$json = array();
		if($output_deals->status=='OK'){
		  $address_components=$output_deals->results[0]->address_components;


		  for($i=0;$i<count($address_components);++$i){
			if(array("locality", "political")==$address_components[$i]->types){
			  $result=$address_components[$i]->short_name;
					  $json['data']['city'] = $result;
				$json['success'] = '1';

			 break;
			}
			
			}

		} else{
		  
				$json['success'] = '0';
					$json["message"] = "No data found";
		  
		}
		
}else{
		
		$json['success'] = '0';
		$json["message"] = "Parameters not valid";
}
if(isset($json['data']['city']) && isset($_REQUEST['user_id'])){
	
	$user_id = $_REQUEST['user_id'];
	$city = new City($db);
	$result = $city->index($json['data']['city']);
	if(isset($result['data'][0]['id']))
	{
		$user = new User($db);
		$user->update(array("city"=>$result['data'][0]['id']),$user_id);
	}

}

echo json_encode($json);
?>