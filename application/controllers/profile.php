<?php

class Profile extends CI_Controller{
    public function __construct(){
      parent::__construct();
          if (empty($this->session->userdata('user_id')) && $this->session->userdata('logged_in') == false) {
            redirect('users/login');
          }
    }

    public function index(){

        if (isset($_GET['u']) === true && empty($_GET['u']) === false) {

          $username = trim($_GET['u']);

          $profileId = $this->User_model->getUserIDByUsername($username);
           //die(print_r($data['saved_post_num'],true));
          $profileData = $this->User_model->userData($profileId);

          $data['user_posts'] = $this->Post_model->user_posts($profileId);
          $data['num_posts'] = $this->Post_model->count_user_post($profileId);
          $data['saved_post'] = $this->Post_model->get_saved_user_post($profileId);
          $data['saved_post_num'] = $this->Post_model->get_saved_user_post_count($profileId);

          $data['users'] = $this->User_model->userData($profileId);

          if (!$profileData) {
            redirect('posts');
          }

          $this->load->view('templates/header');
          $this->load->view('profile/index', $data);
          $this->load->view('templates/footer');

        }


    }

    // public function requests(){
    //   $data['title'] = "hello";
    //   $this->load->view('templates/header');
    //   $this->load->view('profile/requests', $data);
    //   $this->load->view('templates/footer');
    // }

    //edit profile
    public function edit(){

      $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[50]');
      $gender = (!empty($this->input->post('gender'))) ? $this->input->post('gender') : '';
      $address = (!empty($this->input->post('address'))) ? $this->input->post('address') : '';

      if ($this->form_validation->run() === FALSE){
        $data = array('error_message' => form_error('email'));
        $error = $data['error_message'];
        $this->session->set_flashdata('error-profile', $error);
        redirect('profile?u='.$this->session->userdata('username'));
      }else {
        if ($this->User_model->update_profile($gender, $address)) {
          $this->session->set_flashdata('profile_updated', 'Profile updated');
          redirect('profile?u='.$this->session->userdata('username'));
        }else{
          $this->session->set_flashdata('error-profile', 'Sorry something went wrong, Please try again');
          redirect('profile?u='.$this->session->userdata('username'));
        }
      }

   }//end edit profile
     // Check if email exists
  public function check_email_exists($email){
     $this->form_validation->set_message('check_email_exists', 'This email is taken. Please choose a different one');
     if($this->User_model->check_email_exists($email)){
       return true;
     } else {
       return false;
     }
 }
//edit favourite stuff
   public function favourite(){
     if ($this->User_model->updateFavourite()) {
        $this->session->set_flashdata('profile_updated', 'Profile updated');
        redirect('profile?u='.$this->session->userdata('username'));
      }else{
        $this->session->set_flashdata('error-profile', 'Sorry something went wrong, Please try again');
        redirect('profile?u='.$this->session->userdata('username'));
      }
  }
  //end edit favourite stuff

//add profile picture
  public function uploadProfile(){

    $config['upload_path'] = './assets/images/profileimages';
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['max_size'] = '2048';

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('image')) {
      $post_image = $_FILES['image']['name'];
      if ($this->User_model->update_profile_pic($post_image)) {
        array('upload_data' => $this->upload->data());
        $this->session->set_flashdata('profile_updated', 'Profile updated');
        redirect('profile?u='.$this->session->userdata('username'));
      }else{
        $this->session->set_flashdata('error-profile', 'Sorry something went wrong, Please try again');
        redirect('profile?u='.$this->session->userdata('username'));
      }

    }else{
      $errors = array('error' => $this->upload->display_errors());
      redirect('profile?u='.$this->session->userdata('username'));
    }

  }
//end profile picture update

    //strat cover_image
    public function upload(){

      $config['upload_path'] = './assets/images/covers';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_size'] = '2048';

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('image')) {
        $post_image = $_FILES['image']['name'];
        if ($this->User_model->update_cover($post_image)) {
          array('upload_data' => $this->upload->data());
          $this->session->set_flashdata('profile_updated', 'Profile updated');
          redirect('profile?u='.$this->session->userdata('username'));
        }else{
          $this->session->set_flashdata('error-profile', 'Sorry something went wrong, Please try again');
          redirect('profile?u='.$this->session->userdata('username'));
        }

      }else{
        $errors = array('error' => $this->upload->display_errors());
        redirect('profile?u='.$this->session->userdata('username'));
      }

    }
    //end cover_image

//update_bio job position
    public function update_bio(){
      if ($this->User_model->updateBio()) {
        $this->session->set_flashdata('profile_updated', 'Profile updated');
        redirect('profile?u='.$this->session->userdata('username'));
      }else{
        $this->session->set_flashdata('error-profile', 'Sorry something went wrong, Please try again');
        redirect('profile?u='.$this->session->userdata('username'));
      }
    }//end update bio..

    public function sendFriendRequest($friend){
      $my_id = $this->session->userdata('user_id');

      if ($this->User_model->is_request_already_sent($my_id, $friend)) {

        redirect('profile?u='.$this->session->userdata('username'));

      }elseif (is_already_friends($my_id, $friend)) {

        redirect('profile?u='.$this->session->userdata('username'));

      }else {

        if ($this->User_model->make_pending_friends($friend)) {
          echo json_encode(1);
        }else {
          echo json_encode(0);
        }

      }

    }

    public function cancelFriendRequest($friend){
     $my_id = $this->session->userdata('user_id');

      if ($this->User_model->cancel_or_ignore_friend_request($my_id, $friend)) {
        echo json_encode(1);
      }else {
        echo json_encode(0);
      }
    }

    public function acceptFriendRequest($friend){
      $my_id = $this->session->userdata('user_id');

      if ($this->User_model->make_friends($my_id, $friend)) {
        echo json_encode(1);
      }else {
        echo json_encode(0);
      }

    }

    public function unfriend($some_id){
      $my_id = $this->session->userdata('user_id');
      if ($this->User_model->delete_friends($my_id, $some_id)) {
        echo json_encode(1);
      }else {
        echo json_encode(0);
      }
    }


}//end profile class
