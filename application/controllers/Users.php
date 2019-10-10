<?php

	/**
	 *
	 */
	class Users extends CI_Controller{

		public function signup(){
			if($this->isLoggedIn()){
		        redirect('posts');
		      }

			$this->load->model('User_model');
			$data['title'] = 'Sign Up';

			$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|min_length[2]|max_length[35]');
			$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|min_length[2]|max_length[35]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[50]|callback_check_email_exists');
			$this->form_validation->set_rules('dob', 'Date of birth', 'trim|required|max_length[45]|callback_check_dob_valid');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			$this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[225]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[32]');
			$this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');
			//$this->form_validation->set_message('validate_age','Sorry you need to be 18 years or older');

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header');
				$this->load->view('users/signup', $data);
				$this->load->view('templates/footer');
			}else{

				if ($this->User_model->register()) {
					redirect('users/verify');
				}else{
					echo "Sorry something went wrong";
				}

			}
		}

				// Check if email exists
		public function check_email_exists($email){
			$this->form_validation->set_message('check_email_exists', 'This email is taken. Please choose a different one');
			if($this->User_model->check_email_exists($email)){
				return true;
			} else {
				return false;
			}
		}

		public function login(){
			if($this->isLoggedIn()){
		        redirect('posts');
		      }

			$data['title'] = 'Sign In';
			$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_activated|callback_check_account_blocked');
			$this->form_validation->set_rules('password', 'Password', 'required');
			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/login', $data);
				$this->load->view('templates/footer');
			} else {

				$username = $this->input->post('email');
				$password = $this->input->post('password');
				// Login user
				$loggedInUser = $this->User_model->login($username, $password);
				//die(print_r($loggedInUser,true));

				if(!empty($loggedInUser)){
					// Create session
					$user_data = array(
						'user_id' => $loggedInUser->user_id,
						'username' => $loggedInUser->username,
						'firstname' => $loggedInUser->firstname,
						'profile_pic' => $loggedInUser->image,
						'email' => $loggedInUser->email,
						'address' => $loggedInUser->address,
						'logged_in' => true
					);
					$this->session->set_userdata($user_data);
					redirect('posts');
				} else {
					// Set message
					$this->session->set_flashdata('login_failed', 'Incorrect credencials');
					redirect('users/login');
				}
			}
		}

		public function recover(){
			if($this->isLoggedIn()){
		        redirect('posts');
		      }
	    	$data['title'] = 'Reset password';
			$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_activated');
			$email = $this->input->post('email');
			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/recover', $data);
				$this->load->view('templates/footer');
			} else{
				if ($this->User_model->recover_password($email)) {
					$this->session->set_flashdata('email_recov_sent', 'Password recovery code was sent to your email account');
					redirect('http://localhost/friendmiiDemo/');
				}else{
					echo "Sorry something went wrong";
				}
			}
	    }

	    public function code(){
	    	if($this->isLoggedIn()){
		        redirect('posts');
		      }
	    	$data['title'] = 'Please enter your reset code in the form below';
	    	$this->form_validation->set_rules('code', 'Code', 'trim|required|min_length[8]|max_length[45]');
			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/code', $data);
				$this->load->view('templates/footer');
			} else{
				if ($this->User_model->validate_code()) {
					$this->session->set_flashdata('reset_pass', 'Please create a new password.');
	            	redirect("users/reset");
				}else{
					$this->session->set_flashdata('incorrect', 'Sorry your password could not be updated.');
	            	redirect("users/recover");
				}
			}
	    }

	    public function reset(){
	    	if($this->isLoggedIn()){
		        redirect('posts');
		      }
	    	$data['title'] = 'Please reset your password in the form below';
	    	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[32]');
			$this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');
			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/reset', $data);
				$this->load->view('templates/footer');
			} else{
				if ($this->User_model->reset_password()) {
					$this->session->set_flashdata('pass_updated', 'Your password was updated you may login');
					redirect('users/login');
				}else{
					echo "Sorry something went wrong";
				}
			}
	    }

		public function check_email_activated($email){
			$this->form_validation->set_message('check_email_activated', 'This account is not activated or Does not exist.');
			if($this->User_model->check_email_activated($email)){
				return true;
			} else {
				return false;
			}
		}

		public function check_account_blocked($email){
			$this->form_validation->set_message('check_account_blocked', 'Sorry this account was blocked due to blablabla.');
			if($this->User_model->check_account_blocked($email)){
				return true;
			} else {
				return false;
			}
		}

		public function check_dob_valid($date){
		  	$this->form_validation->set_message('check_dob_valid','Sorry you need to be 18 years or older to sign up.');
		  	$birth = (date('Y') - 17).'/'.date('01/01');
		    if(strtotime($date) >=  strtotime($birth)){
		      return false;
		    }else{
		      return true;
		    }
		}

		public function onlineOfline()
		{
			$this->User_model->offlineStatus();
		}

		public function verify(){
			if($this->isLoggedIn()){
		        redirect('posts');
		   }

			$data['title'] = 'You are successfully registered';
			$data['code'] = $this->User_model->activate_user();

			$this->load->view('templates/header');
			$this->load->view('users/verify', $data);
			$this->load->view('templates/footer');
		}

			// Log user out
		public function logout(){
			// Unset user data and destry..
			if ($this->User_model->lastLogOut()) {
				$this->session->unset_userdata('logged_in');
				$this->session->unset_userdata('user_id');
				$this->session->unset_userdata('username');
				$this->session->unset_userdata('email');
				$this->session->sess_destroy();
				redirect('users/login');
			}else{
				$this->session->unset_userdata('logged_in');
				$this->session->unset_userdata('user_id');
				$this->session->unset_userdata('username');
				$this->session->unset_userdata('email');
				$this->session->sess_destroy();
				redirect('users/login');
			}

		}

		public function requests(){
			if(!$this->isLoggedIn()){
		        redirect('users/login');
		   }
		   $my_id = $this->session->userdata('user_id');

      if (getMy_friendrequests_num($my_id) == 0) {
      	$data['title'] = "Hello ".$this->session->userdata('firstname')." you have 0 friends requests";
      }else{
      	$data['title'] = "Hello ".$this->session->userdata('firstname')." you have ".requestOrrequests(getMy_friendrequests_num($my_id, false))."";
      }
 
      $data['requests'] = getMy_friendrequests($my_id);

      $this->load->view('templates/header');
      $this->load->view('users/requests', $data);
      $this->load->view('templates/footer');
    }

	public function isLoggedIn(){
      if(!empty($this->session->userdata('user_id')) && $this->session->userdata('logged_in') == true){
        return true;
      } else {
        return false;
      }
    }

  public function search(){
		$key = $this->input->post('query');
		$data['users'] = $this->User_model->search($key);
		$res = array();
		foreach ($data['users'] as $key) {
			$res[] = $key['firstname'];
		}
		echo json_encode($res);
			//die($key);
		// $this->load->view('templates/header');
  //   $this->load->view('users/search', $data);
  //   $this->load->view('templates/footer');
	}
	/* End Search User function*/

}
