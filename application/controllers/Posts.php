<?php
	/**
	 *
	 */
	class Posts extends CI_Controller{

		function __construct() {
	        parent::__construct();
	        if (empty($this->session->userdata('user_id')) && $this->session->userdata('logged_in') == false) {
	        	redirect('users/login');
	        }
	        
    	}//$myid = $this->session->userdata('user_id');

		public function index(){
			//$this->send();
			$data['replies'] = $this->Post_model->getReply();
			$data['suggested'] = $this->User_model->getFriendSuggestions();
			//die(print_r($data['suggest']['suggestedUser']));
			$data['posts'] = $this->Post_model->get_posts();
			$data['comments'] = $this->Post_model->get_comments();

			$this->load->view('templates/header');
			$this->load->view('posts/index', $data);
			$this->load->view('templates/footer');

		}

		// public function index(){

		// 	$data['post_data'] = $this->Post_model->get_posts();

		// 	$data['posts'] = array(
		// 		'data' => $data['post_data']['data'],
		// 		'post_id' => $data['post_data']['ids'],
		// 	);
		// 	//die(print_r($data['posts']['post_id'],true));
		// 	$data['comments'] = $this->Post_model->get_comments($data['posts']['post_id']);

		// 	//die(print_r($data['comments'],true));
		// 	$this->load->view('templates/header');
		// 	$this->load->view('posts/index', $data);
		// 	$this->load->view('templates/footer');

		// }

		// public function getallcomments(){
		// 	echo json_encode($this->Post_model->get_comments());
		// }
		// public function requests(){
  //     $data['title'] = "hello";
  //     $this->load->view('templates/header');
  //     $this->load->view('profile/requests', $data);
  //     $this->load->view('templates/footer');
  //   }

		public function post(){

		  if (empty($this->input->post('post_text')) && empty($_FILES['image']['name'])) {
			redirect('posts');
		  }

		  $config['upload_path'] = './assets/images/postimages';
          $config['allowed_types'] = 'gif|jpg|png|jpeg';
          $config['max_size'] = '2048';
          $config['encrypt_name'] = TRUE;
          $config['remove_spaces'] = TRUE;

          $this->load->library('upload', $config);



          if (!empty($_FILES['image']['name'])) {

          	if ($this->upload->do_upload('image')) {

          		$data = $this->upload->data();
	            $post_image = $data["file_name"];

		        if ($this->Post_model->addPost($post_image)) {
		          redirect('posts');
		        }else{
		          $this->session->set_flashdata('post_errors', 'Sorry something went wrong, Please try again');
		          redirect('posts');
		        }
            }

          }else{
          	if ($this->Post_model->addPost()) {
	          redirect('posts');
		    }else{
	          $this->session->set_flashdata('post_errors', 'Sorry something went wrong, Please try again');
	          redirect('posts');
		    }
          }


		}

		public function update($pid){
		   if (empty($this->input->post('post_text')) && empty($_FILES['image']['name'])) {
			redirect('posts');
		  }

		  $config['upload_path'] = './assets/images/postimages';
          $config['allowed_types'] = 'gif|jpg|png|jpeg';
          $config['max_size'] = '2048';

          $this->load->library('upload', $config);

		  $postFile = $this->Post_model->getPostById($pid);

		  if (!empty($_FILES['image']['name'])) {

		  		$image_file_name = $postFile->image;
			  	$cwd = getcwd(); // save the current working directory
				$image_file_path = $cwd."\\assets\\images\\postimages\\";
				chdir($image_file_path);
				unlink($image_file_name);
				chdir($cwd); // Restore the previous working directory

		  	  if ($this->upload->do_upload('image')) {

          		$post_image = $_FILES['image']['name'];

		        if ($this->Post_model->updatePost($pid, $post_image)) {
		          array('upload_data' => $this->upload->data());
		          redirect('posts');
		        }else{
		          $this->session->set_flashdata('post_errors', 'Sorry something went wrong, Please try again');
		          redirect('posts');
		        }
            }

		  }else{
		  	$post_image = $postFile->image;
		  	if ($this->Post_model->updatePost($pid, $post_image)) {
	          redirect('posts');
	        }else{
	          $this->session->set_flashdata('post_errors', 'Sorry something went wrong, Please try again');
	          redirect('posts');
	        }
		  }

		}

		public function deletePost($pid){
			if ($this->Post_model->remove_post($pid)) {
			  echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}

		public function reportPost($pid){

			$type_nudity = $this->input->post('nudity');
			$type_violance = $this->input->post('violance');
			$type_hatespeech = $this->input->post('hatespeech');
			$type_suicide = $this->input->post('suicide');
			$type_falsenews = $this->input->post('falsenews');
			$type_spam = $this->input->post('spam');
			$type_scam = $this->input->post('scam');
			$type_drugs = $this->input->post('drugs');
			$type_offensive = $this->input->post('offensive');

			if (empty($type_nudity) && empty($type_violance) && empty($type_hatespeech) && empty($type_suicide) && empty($type_falsenews) && empty($type_spam) && empty($type_scam) && empty($type_drugs) && empty($type_offensive)) {
				$this->session->set_flashdata('post_errors', 'Please select at least one problem you notice with the post');
				redirect('posts');
			}

			if ($this->Post_model->report_post($pid)) {
			  $this->session->set_flashdata('post_success', 'Your report was received and it is under review');
	          redirect('posts');
			}else{
			  $this->session->set_flashdata('post_errors', 'Sorry something went wrong, Please try again');
	          redirect('posts');
			}
		}

		public function savePost($pid){
			if ($this->Post_model->saved_post_exist($pid)) {
				echo json_encode(0);
			}else{
				if ($this->Post_model->save_post($pid)) {
					echo json_encode(1);
				}else{
					echo json_encode(0);
				}
			}
		}

		public function addComment($pid){

        	if ($this->Post_model->comment_on_post($pid)) {
        		echo json_encode(1);
        	}else{
        		echo json_encode(0);
        	}
		}

		public function deleteComment($cid){
			$pid = $this->input->post('postid');
			if ($this->Post_model->remove_comment($cid, $pid)) {
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}

		public function UpdateComments($cid){
			if ($this->Post_model->update_comment($cid)) {
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}

		public function reportComment($pid){

			$type_nudity = $this->input->post('nudity');
			$type_violance = $this->input->post('violance');
			$type_hatespeech = $this->input->post('hatespeech');
			$type_suicide = $this->input->post('suicide');
			$type_falsenews = $this->input->post('falsenews');
			$type_spam = $this->input->post('spam');
			$type_scam = $this->input->post('scam');
			$type_drugs = $this->input->post('drugs');
			$type_offensive = $this->input->post('offensive');

			if (empty($type_nudity) && empty($type_violance) && empty($type_hatespeech) && empty($type_suicide) && empty($type_falsenews) && empty($type_spam) && empty($type_scam) && empty($type_drugs) && empty($type_offensive)) {
				$this->session->set_flashdata('post_errors', 'Please select at least one problem you notice with the comment');
				redirect('posts');
			}

			if ($this->Post_model->report_comment($pid)) {
			  $this->session->set_flashdata('post_success', 'Your report was received and it is under review');
	          redirect('posts');
			}else{
			  $this->session->set_flashdata('post_errors', 'Sorry something went wrong, Please try again');
	          redirect('posts');
			}
		}

		public function addlike(){
			$pid = $this->input->post('postid');
			if ($this->Post_model->like_post($pid)) {
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}

		public function removeLike(){
			$pid = $this->input->post('postid');
			if ($this->Post_model->unlike_post($pid)) {
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}

		public function getAllNofications(){
			//json_encode($this->Post_model->getNotifcations());
			echo $this->Post_model->getNotifcations();
		}

		public function replyComment($cid){
			if ($this->Post_model->reply_comment($cid)) {
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}

		public function addReplylike(){
			$cid = $this->input->post('comment_id');
			if ($this->Post_model->like_reply_post($cid)) {
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}

		public function removeReplyLike(){
			$cid = $this->input->post('comment_id');
			if ($this->Post_model->unlike_reply_post($cid)) {
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}

		public function updatereply($rid){
			if ($this->Post_model->update_reply($rid)) {
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}

		public function delete_reply($rid){
			$cid = $this->input->post('comment_id');
			if ($this->Post_model->remove_reply($rid, $cid)) {
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}


		// reserved code for image resizing
			// $config['image_library'] = 'gd2';
			// $config['source_image'] = './assets/images/postimages/'.$data["file_name"];
			// $config['create_thumb'] = FALSE;
			// $config['maintain_ratio'] = FALSE;
			// $config['quality'] = '60%';
			// $config['max_width'] = '1024';
			// $config['max_height'] = '768';
			// $config['new_image'] = './assets/images/postimages/'.$data["file_name"];
			// $this->load->library('image_lib', $config);
			// $this->image_lib->resize();
		// end comment
	}
