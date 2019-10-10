<?php

	/**
	 *
	 */
	class User_model extends CI_Model{

		public function register(){
			$datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
	        $date = $datebytimezone->format('Y-m-d H:i:s');
	        $username = random_username($this->input->post('firstname'));
	        $comma = ',';
			$user_email = $this->input->post('email');
        	$user_password = $this->input->post('password');
        	$validation_code = token_generator();
			$enc_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$data = array(
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'username' => $username,
				'email' => $this->input->post('email'),
				'dob' => $this->input->post('dob'),
				'gender' => $this->input->post('gender'),
				'address' => $this->input->post('address'),
				'validation_code' => $validation_code,
				'password' => $enc_password,
				'is_activated' => 0,
				'acount_created_at' => $date,
				'blocked' => 0,
				'closed' => 0,
				'online' => 0,
			);

			if ($this->db->insert('users', $data)) {
				$config = array(
		  		'protocol' => 'smtp',
		  		'smtp_host' => 'ssl://smtp.gmail.com',
		  		'smtp_port' => 465,
		  		'smtp_user' => 'lucyfa45@gmail.com',
		  		'smtp_pass' => '84226Tp45',
		  		'mailtype' => 'html',
		  		'charset' => 'iso-8859-1',
		  		'wordwrap' => TRUE
			);

			$message = '
					<html>
					<head>
						<title>Verification Code</title>
					</head>
					<body>
						<h2>Thank you for Registering.</h2>
						<p>Your Account:</p>
						<p>Email: '.$user_email.'</p>
						<p>Password: '.$user_password.'</p>
						<p>Please click the link below to activate your account.</p>
						<h4><a href="'.base_url().'users/verify?email='.$user_email.'&code='.$validation_code.'">Activate My Account</a></h4>
					</body>
					</html>
			';

		    $this->load->library('email', $config);
		    $this->email->set_newline("\r\n");
		    $this->email->from($config['smtp_user'],'no-reply@gmail.com');
		    $this->email->to($user_email);
		    $this->email->subject('Signup Verification Email');
		    $this->email->message($message);

		    //sending email
		    if($this->email->send()){
		    	return true;
		    }else{
		    	return false;
		    }
				return true;
			}else{
				return false;
			}

		}

		public function check_account_blocked($email){

  		$this->db->where('blocked', 0);
			$this->db->where('email', $email);
			$query = $this->db->get('users');

			if ($query->num_rows() > 0) {
				return true;
			}else{
				return false;
			}
		}

		public function close_account(){
			$Isfc_ivd = $this->session->userdata('user_id');
  		$data = array(
  			'closed' => 1,
  		);
			$this->db->where('user_id', $Isfc_ivd);

			if ($this->db->update('users', $data)) {
				return true;
			}else{
				return false;
			}
		}

		// Log user in
		public function login($email, $password){
			$datebytimezone = new DateTime("now", new DateTimeZone('UTC'));
  		$date = $datebytimezone->format('Y-m-d H:i:s');
  		$remember = $this->input->post('remember');
  		$this->db->where('closed', 0);
  		$this->db->where('blocked', 0);
			$this->db->where('email', $email);
			$query = $this->db->get('users');
			$row = $query->row();

			@$password_hash = $row->password;

			if(password_verify($password, $password_hash) || $this->validateCookie($password)){

				if($remember){

		           $random_password = $this->util->getToken(16);
		           $random_selector = $this->util->getToken(16);
		           //die(print_r($random_password, true));
		           $token_password = password_hash($random_password, PASSWORD_DEFAULT);
		           $selector = password_hash($random_selector, PASSWORD_DEFAULT);

		           if ($this->auth_email_exists($email)) {

		           	 if($this->auth_update($email, $token_password, $selector)){
			             setcookie('friendmii_ue', $email, time() + 86400);
			             setcookie('friendmii_up', $random_password, time() + 86400);
			             setcookie('friendmii_us', $random_selector, time() + 86400);
			           }else {
			             return false;
			           }

		           }else{

		           		if($this->rememberToken($email, $token_password, $selector)){
			             setcookie('friendmii_ue', $email, time() + 86400);
			             setcookie('friendmii_up', $random_password, time() + 86400);
			             setcookie('friendmii_us', $random_selector, time() + 86400);
			           }else {
			             return false;
			           }
		           }

		         }else {
		           // TODO delete the temp-pass-token, temp-selector-pass
		           unset($_COOKIE['friendmii_ue']);
		           setcookie('friendmii_ue', '', time()-86400);

		           unset($_COOKIE['friendmii_up']);
		           setcookie('friendmii_up', '', time()-86400);

		           unset($_COOKIE['friendmii_us']);
		           setcookie('friendmii_us', '', time()-86400);

		         }


			    $data = array(
					'last_active' => $date,
				);

				$this->db->where('email', $email);
				$this->db->update('users', $data);
				return $row;
			} else {
				return false;
			}
		}

				// Check email exists
		public function check_email_exists($email){
			$query = $this->db->get_where('users', array('email' => $email));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}

		public function email_exists($email){
			$this->db->where('email', $email);
			$result = $this->db->get('users');
			if($result->num_rows() > 0){
			   return true;
			} else {
			   return false;
		   }
		}

		public function check_email_activated($email){
			$query = $this->db->get_where('users', array('email' => $email, 'is_activated' => 1));
			if(!empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}

		public function activate_user(){
	      //$validation_code = token_generator();
	      if($_SERVER['REQUEST_METHOD'] == "GET"){

	        if (isset($_GET['email'])) {

	          $email = $_GET['email'];
	          $validation_code = $_GET['code'];

	          $data = array(
	          	'validation_code' => 0,
							'is_activated' => 1,
	          );

	         $results = $this->db->get_where('users', array('email' => $email, 'validation_code' => $validation_code));

	          if(!empty($results->row_array())){

	            $this->db->where('email', $email);
	            $this->db->where('validation_code', $validation_code);

	            if($this->db->update('users', $data)){
	              //return true;
	              $this->session->set_flashdata('account_activated', 'Your account was successfully activated. You can login');
	              redirect('users/login');
	            }else{
	              return false;
	            }
	          }else{
	            $this->session->set_flashdata('account_activated', '<span class="text-danger">Sorry your account could not be activated!</span>');
	            redirect('users/login');
	          }
	          return $results;
	        }
	      }
	    }

	    public function recover_password($email){
	    	$token = $this->input->post('token');
	        if(isset($_SESSION['token']) && $token === $_SESSION['token']){

	          $validation_code = $_SESSION['token'];
	          $data = array(
	          	'validation_code' => $validation_code,
	          );
	          // die(print_r($this->email_exists($email),true));
	          // die();
	          if($this->check_email_activated($email) && $this->email_exists($email)){

	            setcookie('temp_reset_access', $validation_code, time() + 86400);
	            setcookie('temp_reset_email', $email, time() + 86400);

	            $this->db->where('email', $email);

	            if ($this->db->update('users', $data)) {
	            	$config = array(
			  		'protocol' => 'smtp',
			  		'smtp_host' => 'ssl://smtp.gmail.com',
			  		'smtp_port' => 465,
			  		'smtp_user' => 'lucyfa45@gmail.com', // change it to yours
			  		'smtp_pass' => '84226Tp45', // change it to yours
			  		'mailtype' => 'html',
			  		'charset' => 'iso-8859-1',
			  		'wordwrap' => TRUE
				);

				$message = '
						<html>
						<head>
							<title>Password Reset Link from friendmii</title>
						</head>
						<body>
							<p>Here is your reset code: '.$validation_code.'</p>
							<p>To reset your password click the link below:</p>
							<h4><a href="'.base_url().'users/code?email='.$email.'&code='.$validation_code.'">Reset my password</a></h4>
							<p>This link will expire in 24 hours.</p>
							<p>If you did not request for your password to be reset, please ignore this email and your password will not change.</p>
						</body>
						</html>
				';

			    $this->load->library('email', $config);
			    $this->email->set_newline("\r\n");
			    $this->email->from($config['smtp_user'],'no-reply@gmail.com');
			    $this->email->to($email);
			    $this->email->subject('Password Reset Link from friendmii');
			    $this->email->message($message);

			    //sending email
			    if($this->email->send()){
			    	return true;
			    }else{
			    	return false;
			    }
	            	return true;
	            }else{
	            	return false;
	            }


	          }else{
	          	redirect('users/recover');
	          }

	        }else{
	          redirect('users/recover');
	        }

	      }

	    //inserting user email to auth table with 0 0 tp and st so that we can update everytime a cookie is set
		    public function rememberToken($email, $token_password, $selector){

		    	$data = array(
		    	'email' => $email,
				'token_password' => $token_password,
				'selector_hash' => $selector,
		    	);

		      if($this->db->insert('auth', $data)){
		        return true;
		      }else {
		        return false;
		      }

		    }

		    public function auth_update($email, $token_password, $selector){
			  $data = array(
	          	 'token_password' => $token_password,
				 'selector_hash' => $selector,
	            );
	           $this->db->where('email', $email);
	           if ($this->db->update('auth', $data)) {
	           	return true;
	           }else{
	           	return false;
	           }
			}

		    public function auth_email_exists($email){
				$this->db->where('email', $email);
				$result = $this->db->get('auth');
				if($result->num_rows() > 0){
				   return true;
				} else {
				   return false;
			   }
			}

	      public function validate_code(){
	      	//die(print_r($_COOKIE['temp_reset_email'], true));
	        if(isset($_COOKIE['temp_reset_access']) && isset($_COOKIE['temp_reset_email'])){

	          	  $code  = $this->input->post('code');
	              if (isset($code)) {
	              $email = $_COOKIE['temp_reset_email'];

	              $this->db->where('email', $email);
	              $this->db->where('validation_code', $code);
				  $result = $this->db->get('users');

	              if($result->num_rows() > 0){
	                return true;
	              }else {
	                return false;
	              }
	            }
	        }else {
	          $this->session->set_flashdata('error_cookie', '<span class="text-danger">Sorry your cookies has expired, please try again</span>');
	          redirect('users/recover');
	        }

	      }

       	public function reset_password(){
       		//die(print_r(isset($_COOKIE['temp_reset_access']),true));
	        if(isset($_COOKIE['temp_reset_access']) && isset($_COOKIE['temp_reset_email'])){

	          	$email = trim($_COOKIE['temp_reset_email']);
	          	$enc_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

          	 $data = array(
	          	'validation_code' => 0,
				'password' => $enc_password,
	          );

             $this->db->where('email', $email);

              if($this->db->update('users', $data)){
              	unset($_COOKIE['temp_reset_email']);
        		unset($_COOKIE['temp_reset_access']);
                return trure;
              }else{
                return false;
              }

	        }else{
	          $this->session->set_flashdata('error', '<span class="text-danger">Sorry your time has expired, please try again</span>');
	          redirect('users/recover');
	        }
	      }

	        //this function validate the cookies and the password input..
		  public function validateCookie($password = null){

		      if(isset($_COOKIE["friendmii_ue"]) && isset($_COOKIE["friendmii_up"]) && isset($_COOKIE["friendmii_us"])){
		        $member = (isset($_COOKIE['friendmii_ue'])) ? $_COOKIE['friendmii_ue'] : '';

		        $this->db->where('email', $member);
				$query = $this->db->get('auth');
				$userToken = $query->row();

		        @$pass = $userToken->token_password;
		        @$selector_hash = $userToken->selector_hash;
		        $unputpass =  $password;

		        $token_pass = (isset($_COOKIE['friendmii_up'])) ? $_COOKIE['friendmii_up'] : '';
		        $token_select = (isset($_COOKIE['friendmii_us'])) ? $_COOKIE['friendmii_us'] : '';
		        //die(print_r(password_verify($password, $pass), true));


		        if (password_verify($token_pass, $pass) && password_verify($selector_hash, $token_select) || password_verify($pass, $token_pass) && password_verify($token_select, $selector_hash) || password_verify($pass, $token_pass) && password_verify($selector_hash, $token_select) || password_verify($token_pass, $pass) && password_verify($token_select, $selector_hash)) {
		          if(password_verify($unputpass, $pass) || password_verify($pass, $unputpass)){
		            return true;
		          }else{
		            $this->util->clearAuthCookie();
		          }
		        }else {
		          $this->util->clearAuthCookie();
		        }
		      }

		   }

	    public function getUserIDByUsername($username){
	       $this->db->where('username', $username);
		   $query = $this->db->get('users');
		   $row = $query->row();
	       $userid = $row->user_id;
		   return $userid;
	    }

	   //profile functions
	    public function userData($id){
	      $query = $this->db->get_where('users', array('user_id' => $id));
	      return $query->row_array();
	    }

	    public function update_cover($image){
	    	$user_id = $this->session->userdata('user_id');

	    	$data = array(
				'cover_image' => $image,
	        );

            $this->db->where('user_id', $user_id);
            if($this->db->update('users', $data)){
            	return true;
            }else{
            	return false;
            }
	    }

	    public function update_profile_pic($image){
	    	$user_id = $this->session->userdata('user_id');

	    	$data = array(
				'image' => $image,
	        );

	        $user_data = array(
						'profile_pic' => $image,
					);
			$this->session->set_userdata($user_data);

            $this->db->where('user_id', $user_id);
            if($this->db->update('users', $data)){
            	return true;
            }else{
            	return false;
            }
	    }

	    public function update_profile($gender, $address){
	    	$user_id = $this->session->userdata('user_id');

	    	$data = array(
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'email' => $this->input->post('email'),
						'gender' => $gender,
						'address' => $address,
						'hobby' => $this->input->post('hobby'),
	        );

            $this->db->where('user_id', $user_id);
            if($this->db->update('users', $data)){
            $firstname = array(
								'firstname' => $this->input->post('firstname'),
							);
						$this->session->set_userdata($firstname);
            	return true;
            }else{
            	return false;
            }
	    }

	     public function updateBio(){
	    	$user_id = $this->session->userdata('user_id');

	    	$data = array(
				'job_name' => $this->input->post('job'),
				'job_title' => $this->input->post('position'),
				'bio' => $this->input->post('bio'),
	        );

            $this->db->where('user_id', $user_id);
            if($this->db->update('users', $data)){
            	return true;
            }else{
            	return false;
            }
	    }

	     public function updateFavourite(){
	    	$user_id = $this->session->userdata('user_id');

	    	$data = array(
				'music' => $this->input->post('music'),
				'movies' => $this->input->post('movies'),
				'books' => $this->input->post('books'),
				'animals' => $this->input->post('animals'),
	        );

            $this->db->where('user_id', $user_id);
            if($this->db->update('users', $data)){
            	return true;
            }else{
            	return false;
            }
	    }

	      public function offlineStatus(){
	    	$user_id = $this->session->userdata('user_id');

	    	$data = array(
				'online' => $this->input->post('st'),
	        );

            $this->db->where('user_id', $user_id);
            if($this->db->update('users', $data)){
            	return true;
            }else{
            	return false;
            }
	    }

		public function lastLogOut(){
			$datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
		    $date = $datebytimezone->format('Y-m-d H:i:s');
		    $user_id = $this->session->userdata('user_id');

		    $data = array(
				'logout_time' => $date,
				'online' => 0,
			);

			$this->db->where('user_id', $user_id);
			$this->db->update('users', $data);
		}

		// CHECK IF REQUEST HAS ALREADY BEEN SENT
	   public function is_request_already_sent($my_id, $user_id){

	   	  $where = "sender ='".$my_id."' AND receiver = '".$user_id."' OR sender = '".$user_id."'  AND receiver = '".$my_id."'";
		  $this->db->where($where);

		  $result = $this->db->get('friend_request');

		  if ($result->num_rows() > 0) {
		    return true;
		  }else {
		    return false;
		  }

	   }
	   //END CHECK IF REQUEST HAS ALREADY BEEN SENT

	   // MAKE PENDING FRIENDS (SEND FRIEND REQUEST)
	   public function make_pending_friends($friend_id){
	    $datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
	    $date = $datebytimezone->format('Y-m-d H:i:s');
	    $user_id = $this->session->userdata('user_id');

    	$data = array(
			'sender' => $user_id,
			'receiver' => $friend_id,
			'request_on' => $date,
        );

	     if($this->db->insert('friend_request', $data)){
	       return true;
	     }else {
	       return false;
	     }
	   }

	   // CANCLE FRIEND REQUEST
	   public function cancel_or_ignore_friend_request($my_id, $user_id){

	   	$where = "sender ='".$my_id."' AND receiver = '".$user_id."' OR sender = '".$user_id."'  AND receiver = '".$my_id."'";

		  $this->db->where($where);

	     if($this->db->delete('friend_request')){
	       return true;
	     }else {
	       return false;
	     }
	   }
	   //END CANCLE FRIEND REQUEST

	   // MAKE FRIENDS
	   public function make_friends($my_id, $user_id){

	     $datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
	     $date = $datebytimezone->format('Y-m-d H:i:s');
	     $my_username = $this->db->select('username')->get_where('users', array('user_id' => $my_id))->row()->username;
	     $user_username = $this->db->select('username')->get_where('users', array('user_id' => $user_id))->row()->username;

	     $where = "sender ='".$my_id."' AND receiver = '".$user_id."' OR sender = '".$user_id."'  AND receiver = '".$my_id."'";

		  $this->db->where($where);


	     if($this->db->delete('friend_request')){

	     	$data = array(
			  'user_one' => $my_id,
			  'user_two' => $user_id,
			  'friends_since' => $date,
        	);

	     	if ($this->db->insert('friends', $data)) {

	     		$this->db->where('user_id', $my_id);
				$this->db->set('friendArray', 'CONCAT(friendArray,\',\',\''.$user_username.'\')', FALSE);
				$this->db->update('users');

	        	$this->db->where('user_id', $user_id);
				$this->db->set('friendArray', 'CONCAT(friendArray,\',\',\''.$my_username.'\')', FALSE);
				$this->db->update('users');

	     	}

	     	$this->Post_model->notifications($my_username, $user_id, "freiend_request_reply");

	       return true;
	     }else {
	       return false;
	     }
	   }

	   // DELETE FRIENDS
	   public function delete_friends($my_id, $user_id){

	    $where = "user_one ='".$my_id."' AND user_two = '".$user_id."' OR user_one = '".$user_id."'  AND user_two = '".$my_id."'";

		  $this->db->where($where);

	     if ($this->db->delete('friends')) {
	     	//my friend array
	     	$this->db->where('user_id', $my_id);
			$result = $this->db->get('users');
			$row = $result->row();
			$username = $row->username;
			$myfriendArray = $row->friendArray;

			 //the other user's friend array
	     	$this->db->where('user_id', $user_id);
			$result = $this->db->get('users');
			$row = $result->row();
			$user_username = $row->username;
			$userfriendArray = $row->friendArray;

	     	$this->db->where('user_id', $my_id);
	     	$new_friend_array = str_replace(",".$user_username, "", $myfriendArray);
			$data = array(
				'friendArray' => $new_friend_array,
	        );
			$this->db->update('users', $data);

			//for friend

        	$this->db->where('user_id', $user_id);
        	$new_friend_array = str_replace(",".$username, "", $userfriendArray);
			$data = array(
				'friendArray' => $new_friend_array,
	        );
			$this->db->update('users', $data);

	       return true;
	     } else {
	       return false;
	     }

	   }

	   // testing suggest
		public function getFriends($userId) {
	    $where = "user_one ='".$userId."' OR user_two = '".$userId."'";
	    $this->db->where($where);
	    $query = $this->db->get('friends');
	    $return_data = array();
	      
	    while($row = $query->unbuffered_row('array')) {
	      if ($row['user_one'] !== $userId) {
	        $return_data[] = $row['user_one'];
	      }
	      
	      if ($row['user_two'] !== $userId) {
	        $return_data[] = $row['user_two'];
	      }
	    }
	      
	    return $return_data;
	  }

	  public function getUser($uid){
	    $this->db->where('user_id', $uid);
	    $query = $this->db->get('users');
	    return $query->result_array();
	  }

	  public function getFriendSuggestions() {
	    $userId = $this->session->userdata('user_id');
	    $friends = $this->getFriends($userId);
	    $suggestedFriends = [];
	    
	    foreach ($friends as $friendId) {
	      # Friends friends list.
	      $ff_list = $this->getFriends($friendId);
	      
	      foreach ($ff_list as $ffriendId) {
	        # If the friendsFriend(ff) is not us, and not our friend, he can be suggested
	        if ($ffriendId != $userId && !in_array($ffriendId, $friends)) {
	          
	          # The key is the suggested friend
	          $suggestedFriends[$ffriendId] = ['mutual_friends' => []];
	          $ff_friends = $this->getFriends($ffriendId);
	          
	          foreach ($ff_friends as $ff_friendId) {
	            if (in_array($ff_friendId, $friends)) {
	              # If he is a friend of the current user, he is a mutual friend
	              $suggestedFriends[$ffriendId]['mutual_friends'][] = $ff_friendId;
	            }
	          }
	          
	        }
	      }
	      
	    }
	    
	    # Convert the friend id's to user objects.
	    $suggestedFriendObjs = array();
	    if (!empty($suggestedFriends)) {
	      foreach ($suggestedFriends as $suggestedFriend => $mutualFriends) {

	        $suggestedFriendObj = new stdClass();
	        $suggestedFriendObj->suggestedUser = $this->getUser($suggestedFriend);
	        
	        if (!empty($mutualFriends)) {
	          $mutualFriendObjs = [];
	          foreach ($mutualFriends['mutual_friends'] as $mutualFriend) {
	            $mutualFriendObjs[] =  $this->getUser($mutualFriend);
	          }
	        }
	        
	        $suggestedFriendObj->mutualFriends = $mutualFriendObjs;
	        $suggestedFriendObjs[] = $suggestedFriendObj;
	      }
	    }
	    
	    return $suggestedFriendObjs;
	  }
	   /* Start Search User function*/
    public function search($key){

	   	$this->db->select('firstname');
	   	 $this->db->like('firstname', $key, 'After');
	   	 $this->db->or_like('lastname', $key, 'Before');
	   	 $this->db->group_by('firstname');
	   	 $query = $this->db->get("users");
	   	 return $query->result_array();
	   }
	   /* Start Search User function*/
	}


	
