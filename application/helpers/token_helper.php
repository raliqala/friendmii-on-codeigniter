<?php

	 function token_generator(){
	  $code = md5(uniqid(mt_rand(), true));
	  return $code;
	}

	function validation_token(){
	  $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
	  return $token;
	}

	function random_username($string_name){
    // echo $string_name."".$rand_no;
     while(true){
          $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
          $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part

          $part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):""; //cut first name to 8 letters
          $part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):""; //cut second name to 5 letters
          $part3 = rand(0, 10000);

          $username = trim($part1).trim($part2).trim($part3); //str_shuffle to randomly shuffle all characters
           //check username in databa
          $username_exist_in_db = username_exist_in_database($username); //check username in database
          if(!$username_exist_in_db){
              return $username;
          }
      }
  }

function username_exist_in_database($username){
	$CI =& get_instance();
	$CI->db->where('username', $username);
	$result = $CI->db->get('users');
	if($result->num_rows() > 0){
	   return true;
	 } else {
	   return false;
	}
}


function onlineOrOffline($status, $uid){
  $CI =& get_instance();

  $data = array(
		'online' => $status,
	);

  $CI->db->where('user_id', $uid);
  if($CI->db->update('users', $data)){
	 return true;
   }else{
	 return false;
  }

}

function UserLikedOrNot($uid,$pid){
  $CI =& get_instance();

  $CI->db->where('user_id', $uid);
  $CI->db->where('post_id', $pid);

  $result = $CI->db->get('post_like');

  if ($result->num_rows() > 0) {
    return true;
  }else {
    return false;
  }

}

function Liked_Comment_Or_Not($uid,$cid){
  $CI =& get_instance();

  $CI->db->where('user_id', $uid);
  $CI->db->where('comment_id', $cid);

  $result = $CI->db->get('comment_like');

  if ($result->num_rows() > 0) {
    return true;
  }else {
    return false;
  }

}

//follow functionality
function following_or_not($senderId, $receiverId){

  $CI =& get_instance();

  $CI->db->where('sender', $senderId);
  $CI->db->where('receiver', $receiverId);

  $result = $CI->db->get('follow');

  if ($result->num_rows() > 0) {
    return true;
  }else {
    return false;
  }

}


//friend request
// CHECK IF ALREADY FRIENDS
function is_already_friends($my_id, $user_id){

  $CI =& get_instance();

  $where = "user_one ='".$my_id."' AND user_two = '".$user_id."' OR user_one = '".$user_id."'  AND user_two = '".$my_id."'";
  $CI->db->where($where);

  $result = $CI->db->get('friends');

  if ($result->num_rows() > 0) {
    return true;
  }else {
    return false;
  }

}

//  IF I AM THE REQUEST SENDER
function i_am_sender($my_id, $user_id){

  $CI =& get_instance();

  $CI->db->where('sender', $my_id);
  $CI->db->where('receiver', $user_id);

  $result = $CI->db->get('friend_request');

  if ($result->num_rows() > 0) {
    return true;
  }else {
    return false;
  }

}

//  IF I AM THE RECEIVER
function i_am_receiver($my_id, $user_id){

  $CI =& get_instance();

  $CI->db->where('sender', $user_id);
  $CI->db->where('receiver', $my_id);

  $result = $CI->db->get('friend_request');

  if ($result->num_rows() > 0) {
    return true;
  }else {
    return false;
  }

}

//friendsfunctions




function isMyFriend($uid, $userToCheck){
  $CI =& get_instance();

  $CI->db->where('user_id', $uid);

  $result = $CI->db->get('users');

  $row = $result->row();

  @$userna = "," . $row->username;
  @$friendArray = $row->friendArray;
  $usernameComma = "," . $userToCheck;

  if ((strstr($friendArray,$usernameComma) || $usernameComma == $userna)) {
    return true;
  }else {
    return false;
  }

}

function request_notification($my_id, $send_data){

  $CI =& get_instance();
  $CI->db->where('receiver', $my_id);
  $CI->db->join('users', 'friend_request.sender = users.user_id');
  $query = $CI->db->get('friend_request');
  if($send_data){
      return $query->result_array();
  }
  else{
      return $query->num_rows();
  }

}

 function mutualFriends($my_id, $user_id){
    $CI =& get_instance();
    $mutualFriend = 0;
    //my friend array
    $CI->db->where('user_id', $my_id);
    $result = $CI->db->get('users');
    $row = $result->row();
    $myfriendArray = $row->friendArray;
    $user_array_explode = explode(",", $myfriendArray);

    //the other user's friend array
    $CI->db->where('user_id', $user_id);
    $result = $CI->db->get('users');
    $row = $result->row();
    $userfriendArray = $row->friendArray;
    $user_to_check_array_explode = explode(",", $userfriendArray);


    foreach ($user_array_explode as $i) {
      foreach ($user_to_check_array_explode as $t) {
         if ($i == $t && $i != "") {
            $mutualFriend++;
         }
      }
    }

    return $mutualFriend;

   }

  function notificationUnreadNumber($currentUser){
    $CI =& get_instance();
    $query = $CI->db->get_where('notification', array('viewed' => 0, 'user_to' => $currentUser));
    return $query->num_rows();
  }


function getfriends($my_id, $send_data){

  $CI =& get_instance();
  $where = "user_one ='".$my_id."' OR user_two = '".$my_id."'";
  $CI->db->where($where);
  $query = $CI->db->get('friends');
  //die(print_r($query->result_array()));
  $all_users = $query->result_array();
  $return_data = [];

  if ($send_data) {
    foreach($all_users as $row){
      if($row['user_one'] == $my_id){
          $CI->db->join('friends', 'friends.user_two = users.user_id');
          $query = $CI->db->get_where('users', array('user_id' => $row['user_two']));
          $results = $query->result_array();
          array_push($return_data, $results);
      }else{
          $CI->db->join('friends', 'friends.user_one = users.user_id');
          $query = $CI->db->get_where('users', array('user_id' => $row['user_one']));
          $results = $query->result_array();
          array_push($return_data, $results);
      }
    }
    return $return_data;

  }else{
    return $query->num_rows();
  }

}

function getfriend_requests($my_id, $send_data){
	$CI =& get_instance();
	$CI->db->where('sender', $my_id);
	$result = $CI->db->get('friend_request');
	$all_requests = $result->result_array();
	$return_data = [];
	if ($send_data) {
		foreach($all_requests as $row){
			$query = $CI->db->get_where('users', array('user_id' => $row['receiver']));
			$results = $query->result_array();
			array_push($return_data, $results);
		}
		return $return_data;

	}else{
		return $result->num_rows();
	}
}

function is_account_closed($user_id){

  $CI =& get_instance();

 $account_status = $CI->db->select('closed')->get_where('users', array('user_id' => $user_id))->row()->closed;

  if ($account_status == 1) {
    return true;
  }else {
    return false;
  }

}

function getMy_friendrequests_num($my_id){
  $CI =& get_instance();
  $CI->db->where('receiver', $my_id);
  $result = $CI->db->get('friend_request');
  return $result->num_rows();
}

function getMy_friendrequests($my_id){
  $CI =& get_instance();
  $CI->db->where('receiver', $my_id);
  $CI->db->join('users', 'users.user_id = friend_request.sender');
  $result = $CI->db->get('friend_request');
  return $result->result_array();
}

function get_online_friends($my_id){

  $CI =& get_instance();
  $where = "user_one ='".$my_id."' OR user_two = '".$my_id."'";
  $CI->db->where($where);
  $query = $CI->db->get('friends');
  //die(print_r($query->result_array()));
  $all_users = $query->result_array();
  $return_data = [];

  foreach($all_users as $row){
    if($row['user_one'] == $my_id){
        $query = $CI->db->get_where('users', array('user_id' => $row['user_two'], 'online' => 1));
        $results = $query->result_array();
        array_push($return_data, $results);
    }else{
        $query = $CI->db->get_where('users', array('user_id' => $row['user_one'], 'online' => 1));
        $results = $query->result_array();
        array_push($return_data, $results);
    }
  }

  return $return_data;

}


