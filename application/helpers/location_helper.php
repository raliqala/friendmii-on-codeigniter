<?php 

	function Addresses($CurrentUserAdd, $current_user){
		$CI =& get_instance();
		$ml = 12.00;
		$closed = 0;
		$blocked = 0;
		$where = "closed ='".$closed."' AND blocked = '".$blocked."'";
 		 $CI->db->where($where);
    $query = $CI->db->get('users');
    $results = array();
    while ($row = $query->unbuffered_row('array')) {
    	if (getDistance($CurrentUserAdd, $row['address']) <= $ml) {
    		if ($row['user_id'] != $current_user) {
    			$results[] = $row;
    		}
    	}
    }
    return $results;
	}
	
	function getDistance($CurrentUserAddress, $otherUserAddress, $unit = 'k'){
	    // Google API key
	    $apiKey = 'AIzaSyBRMLF9pK8EoY-wOnp1_N1uZ7pH6fOnlLQ';
	    
	    // Change address format
	    $formattedAddrFrom    = str_replace(' ', '+', $CurrentUserAddress);
	    $formattedAddrTo     = str_replace(' ', '+', $otherUserAddress);
	    
	    // Geocoding API request with start address
	    $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
	    $outputFrom = json_decode($geocodeFrom);
	    if(!empty($outputFrom->error_message)){
	        return $outputFrom->error_message;
	    }
	    
	    // Geocoding API request with end address
	    $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
	    $outputTo = json_decode($geocodeTo);
	    if(!empty($outputTo->error_message)){
	        return $outputTo->error_message;
	    }
	    
	    // Get latitude and longitude from the geodata
	    $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
	    $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
	    $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
	    $longitudeTo    = $outputTo->results[0]->geometry->location->lng;
	    
	    // Calculate distance between latitude and longitude
	    $theta    = $longitudeFrom - $longitudeTo;
	    $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
	    $dist    = acos($dist);
	    $dist    = rad2deg($dist);
	    $miles    = $dist * 60 * 1.1515;
	    
	    // Convert unit and return distance
	    $unit = strtoupper($unit);
	    if($unit == "K"){
	        return round($miles * 1.609344, 2);
	    }elseif($unit == "M"){
	        return round($miles * 1609.344, 2);
	    }else{
	        return round($miles, 2);
	    }
	}