<?php

/**
 *
 */
class Post_model extends CI_Model{

	public function __construct(){
		$this->load->database();
	}

	public function get_posts(){
		$this->db->select('*,
				            users.image AS profile_pic,
				            post.image AS post_image');
		$this->db->from('post');
		$this->db->join('users', 'users.user_id = post.user_id');
		$this->db->where('post_closed', 0);
		$this->db->where('users.blocked', 0);
		$this->db->where('users.closed', 0);
		$this->db->order_by('posted_at', 'DESC');
		$query = $this->db->get();
		return $query->result_array(); //$query->result_array();
	}

	// public function get_posts(){
	//     $this->db->select('*,
	//                         users.image AS profile_pic,
	//                         post.image AS post_image');
	//     $this->db->from('post');
	//     $this->db->join('users', 'users.user_id = post.user_id');
	//     $this->db->where('post_closed', 0);
	//     $this->db->order_by('posted_at', 'DESC');
	//     $query = $this->db->get();
	//     $data = [];

	//     while($row = $query->unbuffered_row('array'))
	//     {
	//         $data['data'][] = $row;
	//         $data['ids'][] = $row['post_id'];
	//     }

	//     return $data;
	// }

	public function addPost($image = false){

			$datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
		    $date = $datebytimezone->format('Y-m-d H:i:s');
		    $user_id = $this->session->userdata('user_id');
				$post_num = $this->db->select('post_num')->get_where('users', array('user_id' => $user_id))->row()->post_num;
			$data = array(
				'user_id' => $user_id,
				'post' => $this->input->post('post_text'),
				'posted_at' => $date,
				'comment_count' => 0,
				'like_count' => 0,
				'privacy' => $this->input->post('privacy'),
				'post_closed' => 0,
				'image' => $image,
			);

			if ($this->db->insert('post', $data)) {
				$data = array(
					'post_num' => $post_num+1,
				);

				$this->db->where('user_id', $user_id);
				$this->db->update('users', $data);
				return true;
			}else{
				return false;
			}
	}

	public function getPostById($pid){

      $this->db->where('post_id', $pid);
      $result = $this->db->get('post');
      $row = $result->row();

      return $row;
    }

    public function updatePost($post_id, $image = false){
  		$user_posted_id = $this->db->select('user_id')->get_where('post', array('post_id' => $post_id))->row()->user_id;
  		$user_id = $this->session->userdata('user_id');
			$data = array(
				'post' => $this->input->post('post_text'),
				'privacy' => $this->input->post('privacy'),
				'image' => $image,
			);

			$this->db->where('post_id', $post_id);

			if ($this->db->update('post', $data)) {
				$this->db->where('comment_closed', 0);
				$this->db->where('post_id', $post_id);
				$query = $this->db->get('comment');
				$nofified_users = array();
				while ($row = $query->unbuffered_row('array')) {
					if ($row['user_id'] != $user_posted_id && $row['user_id'] != $user_id && !in_array($row['user_id'], $nofified_users)) {
						$this->notifications($post_id, $row['user_id'], "comment_non_owner");
						array_push($nofified_users, $row['user_id']);
					}
				}
				return true;
			}else{
				return false;
			}
    }

     public function remove_post($post_id){

			$image_file_name = $this->db->select('image')->get_where('post', array('post_id' => $post_id))->row()->image;
			$cwd = getcwd(); // save the current working directory
			$image_file_path = $cwd."\\assets\\images\\postimages\\";
			chdir($image_file_path);
			unlink($image_file_name);
			chdir($cwd); // Restore the previous working directory

			 $data = array(
		    	'post_closed' => 1,
			);

			$this->db->where('post_id', $post_id);
			if ($this->db->update('post', $data)) {
				return true;
			}else{
				return false;
			}

    }

    public function report_post($pid){

    	$datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
	    $date = $datebytimezone->format('Y-m-d H:i:s');

	    $user_id = $this->session->userdata('user_id');
	    $user_email = $this->session->userdata('email');

			$data = array(
				'user_id' => $user_id,
				'post_id' => $pid,
				'user_email' => $user_email,
				'type_nudity' => $this->input->post('nudity'),
				'type_violance' => $this->input->post('violance'),
				'type_hatespeech' => $this->input->post('hatespeech'),
				'type_suicide' => $this->input->post('suicide'),
				'type_falsenews' => $this->input->post('falsenews'),
				'type_spam' => $this->input->post('spam'),
				'type_scam' => $this->input->post('scam'),
				'type_drugs' => $this->input->post('drugs'),
				'type_offensive' => $this->input->post('offensive'),
				'report_comment' => $this->input->post('report'),
				'report_date' => $date,
			);

			if ($this->db->insert('report_post', $data)) {
				return true;
			}else{
				return false;
			}
    }

    public function report_comment($pid){

    	$datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
	    $date = $datebytimezone->format('Y-m-d H:i:s');

	    $user_id = $this->session->userdata('user_id');
	    $user_email = $this->session->userdata('email');

			$data = array(
				'user_id' => $user_id,
				'comment_id' => $pid,
				'user_email' => $user_email,
				'type_nudity' => $this->input->post('nudity'),
				'type_violance' => $this->input->post('violance'),
				'type_hatespeech' => $this->input->post('hatespeech'),
				'type_suicide' => $this->input->post('suicide'),
				'type_falsenews' => $this->input->post('falsenews'),
				'type_spam' => $this->input->post('spam'),
				'type_scam' => $this->input->post('scam'),
				'type_drugs' => $this->input->post('drugs'),
				'type_offensive' => $this->input->post('offensive'),
				'report_comment' => $this->input->post('report'),
				'report_date' => $date,
			);

			if ($this->db->insert('report_comment', $data)) {
				return true;
			}else{
				return false;
			}
    }

    public function saved_post_exist($pid){

    	$this->db->where('post_id', $pid);
      $result = $this->db->get('save_post');

	    	if($result->num_rows() > 0){
				return true;
			} else {
				return false;
			}
    }

    public function save_post($pid){
    	$datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
	    $date = $datebytimezone->format('Y-m-d H:i:s');

	    $user_id = $this->session->userdata('user_id');

	    $data = array(
	    	'user_id' => $user_id,
				'post_id' => $pid,
				'saved_on' => $date,
			);

	    	if ($this->db->insert('save_post', $data)) {
				return true;
			}else{
				return false;
			}
    }


    public function comment_on_post($pid){
    	$datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
	    $date = $datebytimezone->format('Y-m-d H:i:s');
	    $user_id = $this->session->userdata('user_id');

	    $this->db->where('post_id', $pid);
        $result = $this->db->get('post');
        $row = $result->row();
        $n = $row->comment_count;

        $user_posted_id = $this->db->select('user_id')->get_where('post', array('post_id' => $pid))->row()->user_id;


	    $data = array(
	    	'post_id' => $pid,
	    	'user_id' => $user_id,
	    	'comment' => $this->input->post('comment_text'),
	    	'reply_count' => 0,
			'like_count' => 0,
			'commented_at' => $date,
			'comment_closed' => 0,
		);

    	if ($this->db->insert('comment', $data)) {

    		if ($user_posted_id != $user_id) {
	    		$this->notifications($pid, $user_posted_id, "comment");
	    	}

	    	$data = array(
				'comment_count' => $n+1,
			);

			$this->db->where('post_id', $pid);
			$this->db->update('post', $data);

			$this->db->where('comment_closed', 0);
			$this->db->where('post_id', $pid);
			$query = $this->db->get('comment');
			$nofified_users = array();
			while ($row = $query->unbuffered_row('array')) {
				if ($row['user_id'] != $user_posted_id && $row['user_id'] != $user_id && !in_array($row['user_id'], $nofified_users)) {
					$this->notifications($pid, $row['user_id'], "comment_non_owner");
					array_push($nofified_users, $row['user_id']);
				}
			}

			return true;
		}else{
			return false;
		}
    }

    public function update_comment($comment_id, $image = false){

		$data = array(
			'comment' => $this->input->post('comment_text'),
		);

		$this->db->where('comment_id', $comment_id);
		if ($this->db->update('comment', $data)) {
			return true;
		}else{
			return false;
		}

    }

    public function get_comments(){
		$this->db->select('*,
							comment.image AS comment_pic,
				            users.image AS profile_pic');
		$this->db->from('comment');
		$this->db->join('users', 'users.user_id = comment.user_id');
		$this->db->where('comment_closed', 0);
		$this->db->order_by('commented_at', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	// public function get_comments($pid){

	//     $this->db->select('*,
	//                         users.image AS profile_pic');
	//     $this->db->from('comment');
	//     $this->db->join('users', 'users.user_id = comment.user_id');
	//     $this->db->where('comment_closed', 0);
	//     $this->db->where_in('post_id', $pid);
	//     $this->db->order_by('commented_at', 'DESC');
	//     $query = $this->db->get();
	//     $data = [];

	//     while($row = $query->unbuffered_row('array'))
	//     {
	//         $data[$row['post_id']][] = $row;
	//     }

	//     return $data;

	// }

	public function remove_comment($comment_id, $pid){

		// $image_file_name = $this->db->select('image')->get_where('comment', array('comment_id' => $comment_id))->row()->image;
		// $cwd = getcwd(); // save the current working directory
		// $image_file_path = $cwd."\\assets\\images\\commentimages\\";
		// chdir($image_file_path);
		// unlink($image_file_name);
		// chdir($cwd); // Restore the previous working directory

		$this->db->where('post_id', $pid);
        $result = $this->db->get('post');
        $row = $result->row();
        $n = $row->comment_count;

		$data = array(
			'comment_closed' => 1,
		);

		$this->db->where('comment_id', $comment_id);
		if ($this->db->update('comment', $data)) {

			$data = array(
				'comment_count' => $n-1,
			);

			$this->db->where('post_id', $pid);
			$this->db->update('post', $data);
			return true;
		}else{
			return false;
		}

    }

    public function like_post($pid){
    	$datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
	    $date = $datebytimezone->format('Y-m-d H:i:s');
	    $user_id = $this->session->userdata('user_id');
	    $liked = $this->input->post('liked');

	    $this->db->where('post_id', $pid);
        $result = $this->db->get('post');
        $row = $result->row();
        $postedid = $row->user_id;

    	if (isset($liked)) {

	        $num = $this->db->select('like_count')->get_where('post', array('post_id' => $pid))->row()->like_count;

		    $data = array(
		    	'user_id' => $user_id,
				'post_id' => $pid,
				'liked_on' => $date,
			);

	    	$this->db->insert('post_like', $data);

			$data = array(
				'like_count' => $num + 1,
			);

			$this->db->where('post_id', $pid);
			$this->db->update('post', $data);

			if ($postedid != $user_id) {
	    		$this->notifications($pid, $postedid, "like");
	    	}
    	}


    }

    public function unlike_post($pid){
    	$datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
	    $date = $datebytimezone->format('Y-m-d H:i:s');
	    $user_id = $this->session->userdata('user_id');
	    $unliked = $this->input->post('unliked');

    	if (isset($unliked)) {

	    	$num = $this->db->select('like_count')->get_where('post', array('post_id' => $pid))->row()->like_count;

	        $this->db->where('user_id', $user_id);
	        $this->db->where('post_id', $pid);

	    	$this->db->delete('post_like');

			$data = array(
				'like_count' => $num - 1,
			);

			$this->db->where('post_id', $pid);
			$this->db->update('post', $data);
    	}

    }

    public function user_posts($uid){
		$this->db->select('*,
				            users.image AS profile_pic,
				            post.image AS post_image');
		$this->db->from('post');
		$this->db->join('users', 'users.user_id = post.user_id');
		$this->db->where('post_closed', 0);
		$this->db->where('post.user_id', $uid);
		$this->db->order_by('posted_at', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_saved_user_post($uid){
		$this->db->select('*,
										users.image AS profile_pic,
				            post.image AS post_image');
		$this->db->from('save_post');
		$this->db->join('post', 'post.post_id = save_post.post_id');
		$this->db->join('users', 'users.user_id = post.user_id');
		$this->db->where('post.post_closed', 0);
		$this->db->where('save_post.user_id', $uid);
		$this->db->order_by('saved_on', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_saved_user_post_count($uid){
		$this->db->select('*');
		$this->db->from('save_post');
		$this->db->join('users', 'users.user_id = save_post.user_id');
		$this->db->join('post', 'post.post_id = save_post.post_id');
		$this->db->where('post.post_closed', 0);
		$this->db->where('save_post.user_id', $uid);
		$this->db->order_by('saved_on', 'DESC');
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_user_post($user_id){
		$query = $this->db->get_where('post', array('user_id' => $user_id, 'post_closed' => 0));
		return $query->num_rows();
	}

	// public function today_post(){
	//     $datebytimezone = new DateTime("now", new DateTimeZone('UTC'));
	//     $date = $datebytimezone->format('Y-m-d');
	//     $query = $this->db->get_where('post',
	//         array(
	//             'posted_at >=' => "{$date} 00:00:00",
	//             'post_closed' => 0
	//         )
	//     );
	//     return $query->num_rows();
	// }

	public function notifications($post_id, $user_to, $type){
    	$user_id = $this->session->userdata('user_id');
    	$username = $this->session->userdata('username');
    	$user_firstname = $this->session->userdata('firstname');
    	$datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
	    $date = $datebytimezone->format('Y-m-d H:i:s');
	    $data = [];

	    switch ($type) {
	    	case 'comment':
	    		$message = $user_firstname . " commented on your post";
	    		break;
	    	case 'like':
	    		$message = $user_firstname . " liked your post";
	    		break;
	    	case 'comment_non_owner':
	    		$message = $user_firstname . " commented on a post you commented on";
	    		break;
	    	case 'freiend_request_reply':
	    		$message = $user_firstname . " accepted your friend request";
	    		break;
	    	case 'like_reply':
	    		$message = $user_firstname . " liked your comment";
	    		break;
	    	case 'replied':
	    		$message = $user_firstname . " replied on your comment";
	    		break;
	    	case 'replied_non_owner':
	    		$message = $user_firstname . " replied on a comment you replied on";
	    		break;
  		}

	    if ($type == "freiend_request_reply") {
	    	$link = "profile?u=".$username;
	    	$data = array(
		    	'user_to' => $user_to,
				'user_from' => $user_id,
				'message' => $message,
				'link' => $link,
				'notification_datetime' => $date,
				'opened' => 0,
				'viewed' => 0,
			);
	    }else{
	    	$link = "view?post=".$post_id;
	    	 $data = array(
		    	'user_to' => $user_to,
				'user_from' => $user_id,
				'message' => $message,
				'link' => $link,
				'notification_datetime' => $date,
				'opened' => 0,
				'viewed' => 0,
			);
	    }

	    return $this->db->insert('notification', $data);
  	}



  	public function getNotifcations(){
  			$limit = 5;
  			$page = $this->input->post('page');
				$userLoggedIn = $this->session->userdata('user_id');
				$return_string = "";

				if($page == 1)
					$start = 0;
				else 
					$start = ($page - 1) * $limit;

				$data = array(
					'viewed' => 1,
				);
				$this->db->where('user_to', $userLoggedIn);
				$this->db->update('notification', $data);
				//invisibility spell

				$this->db->join('users', 'users.user_id = notification.user_from');
				$this->db->where('user_to', $userLoggedIn);
				$this->db->order_by('notification_datetime', 'DESC');
				$query = $this->db->get('notification');

				if($query->num_rows() == 0) {
					echo "<span style='color:black;'>You have no notifications!</span>";
					return;
				}

				$num_iterations = 0;
				$count = 1;

				foreach($query->result_array() as $row) {
					//die(print_r($row['user_from']));
					if($num_iterations++ < $start)
						continue;

					if($count > $limit)
						break;
					else 
						$count++;

					// $user_from = $row['user_from'];

					// $this->db->where('user_id', $user_from);
					// $query = $this->db->get('users');
					// $user_data = $query->result_array();

					$opened = $row['opened'];
					$style = ($opened == 0) ? "background-color: #DDEDFF78;" : "";

					$return_string .= "<a href='".$row['link']."'> 
											<div class='resultDisplay resultDisplayNotification' style='".$style."'>
												<div class='notificationsProfilePic' style='word-wrap: break-word;'>
													<img src='".base_url()."assets/images/profileimages/".$row['image']."'>
												</div>
												<p class='timestamp_smaller' id='grey'>".get_time_ago($row['notification_datetime'])."</p>
												<p style='word-wrap: break-word;color: #000000b5;position: relative;left: 3.1em;top: -3em;width: 330px;'>".$row['message']."</p>
											</div>
										</a>";
				}


				//If posts were loaded
				if($count > $limit)
					$return_string .= "<input type='hidden' class='nextPageDropdownData' value='" . ($page + 1) . "'><input type='hidden' class='noMoreDropdownData' value='false'>";
				else 
					$return_string .= "<input type='hidden' class='noMoreDropdownData' value='true'> <p style='text-align: center;color:black;'>No more notifications to load!</p>";
				
				return $return_string;
  	}

  	public function reply_comment($cid){
  		$datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
	    $date = $datebytimezone->format('Y-m-d H:i:s');
  		$my_id = $this->session->userdata('user_id');

		  $this->db->where('comment_id', $cid);
      $result = $this->db->get('comment');
      $row = $result->row();
      $commentedid = $row->user_id;
      $postid = $row->post_id;

  		$num = $this->db->select('reply_count')->get_where('comment', array('comment_id' => $cid))->row()->reply_count;

  		$data = array(
  			'user_id' => $my_id,
  			'comment_id' => $cid,
  			'reply' => $this->input->post('reply_text'),
  			'replyed_date' => $date,
  			'reply_closed' => 0,
  		);

  		if ($this->db->insert('comment_reply',$data)) {

  			$data = array(
	  			'reply_count' => $num+1,
	  		);
	  		$this->db->where('comment_id', $cid);
	  		$this->db->update('comment', $data);

	  		if ($commentedid != $my_id) {
		  		$this->notifications($postid, $commentedid, "replied");
		  	}

		  	$this->db->where('reply_closed', 0);
				$this->db->where('comment_id', $cid);
				$query = $this->db->get('comment_reply');
				$nofified_users = array();
				while ($row = $query->unbuffered_row('array')) {
					if ($row['user_id'] != $commentedid && $row['user_id'] != $my_id && !in_array($row['user_id'], $nofified_users)) {
						$this->notifications($postid, $row['user_id'], "replied_non_owner");
						array_push($nofified_users, $row['user_id']);
					}
				}

  			return true;
  		}else{
  			return false;
  		}

  	}

  	// reply like and unlike
  	public function like_reply_post($cid){
	    	$datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
		    $date = $datebytimezone->format('Y-m-d H:i:s');
		    $user_id = $this->session->userdata('user_id');
		    $liked = $this->input->post('liked');

		    $this->db->where('comment_id', $cid);
        $result = $this->db->get('comment');
        $row = $result->row();
        $commentedid = $row->user_id;
        $postid = $row->post_id;

	    	if (isset($liked)) {

	        $num = $this->db->select('like_count')->get_where('comment', array('comment_id' => $cid))->row()->like_count;

				  $data = array(
				    'user_id' => $user_id,
						'comment_id' => $cid,
						'liked_comment_on' => $date,
					);

		    	$this->db->insert('comment_like', $data);

					$data = array(
						'like_count' => $num + 1,
					);

					$this->db->where('comment_id', $cid);
					$this->db->update('comment', $data);

					if ($commentedid != $user_id) {
			  		$this->notifications($postid, $commentedid, "like_reply");
			  	}
	    	}
    }

    public function unlike_reply_post($cid){
    	$datebytimezone = new DateTime("now", new DateTimeZone('UTC') );
	    $date = $datebytimezone->format('Y-m-d H:i:s');
	    $user_id = $this->session->userdata('user_id');
	    $unliked = $this->input->post('unliked');

    	if (isset($unliked)) {

	    	$num = $this->db->select('like_count')->get_where('comment', array('comment_id' => $cid))->row()->like_count;

        $this->db->where('user_id', $user_id);
        $this->db->where('comment_id', $cid);

	    	$this->db->delete('comment_like');

				$data = array(
					'like_count' => $num-1,
				);

				$this->db->where('comment_id', $cid);
				$this->db->update('comment', $data);
    	}

    }

    public function getReply(){
    	$this->db->select('*,
					              users.image AS profile_pic');
			$this->db->from('comment_reply');
			$this->db->join('users', 'users.user_id = comment_reply.user_id');
			$this->db->where('reply_closed', 0);
			$this->db->order_by('replyed_date', 'DESC');
			$query = $this->db->get();
			return $query->result_array();
    }


    public function update_reply($rid){

  		$data = array(
  			'reply' => $this->input->post('reply_text'),
  		);
  			$this->db->where('reply_id', $rid);
  		if ($this->db->update('comment_reply',$data)) {
  			return true;
  		 }else{
  			return false;
  		}

  	}



    public function remove_reply($id, $cid){
    	$num = $this->db->select('reply_count')->get_where('comment', array('comment_id' => $cid))->row()->reply_count;
    		$data = array(
    			'reply_closed' => 1,
    		);

    		$this->db->where('reply_id', $id);
    		if ($this->db->update('comment_reply', $data)) {

    			$data = array(
		  			'reply_count' => $num-1,
			  	);

		  		$this->db->where('comment_id', $cid);
		  		$this->db->update('comment', $data);

    			return true;
    		}else{
    			return false;
    		}
    }

}//end post modal class
