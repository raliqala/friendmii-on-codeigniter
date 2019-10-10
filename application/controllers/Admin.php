<?php

	class Admin extends CI_Controller{

		function __construct(){
			parent::__construct();
			if (empty($this->session->userdata('user_id')) && $this->session->userdata('logged_in') == false) {
	        	redirect('users/login');
	        }
			$this->load->model('Admin_model');
		}
          


		public function view($page = 'home')
		{
			if(!file_exists(APPPATH.'views/admin/'.$page.'.php')){
				show_404();
		}

			$data['title'] = ucfirst($page);
			$data['users'] = $this->Admin_model->get_users();
			$data['all_users'] = $this->Admin_model->count_users();
			$data['online_users'] = $this->Admin_model->count_online();
			$data['posts_today'] = $this->Admin_model->count_posts_today();
			$data['deleted_accounts'] = $this->Admin_model->count_deleted_accounts();
	        $data['blocked_accounts'] = $this->Admin_model->count_blocked();
	    	$data['last_seen_today'] = 	$this->Admin_model->count_last_seen_today();
	    	$data['new_registrations'] = $this->Admin_model->count_new_registrations();

       
			$this->load->view('templates/header');
			$this->load->view('admin/'.$page, $data);
			$this->load->view('templates/footer');
		}

		public function overview(){
			$data['users'] = $this->Admin_model->get_users();
			$data['all_users'] = $this->Admin_model->count_users();
			$data['online_users'] = $this->Admin_model->count_online();
			$data['posts_today'] = $this->Admin_model->count_posts_today();
			$data['deleted_accounts'] = $this->Admin_model->count_deleted_accounts();
	        $data['blocked_accounts'] = $this->Admin_model->count_blocked();
	    	$data['last_seen_today'] = 	$this->Admin_model->count_last_seen_today();
	    	$data['new_registrations'] = $this->Admin_model->count_new_registrations();


			 $this->load->view('templates/header');
			 $this->load->view('admin/home', $data);
	         $this->load->view('admin/overview');
		}

		public function users(){
			
			$data['all_users'] = $this->Admin_model->count_users();
			$data['posts_today'] = $this->Admin_model->count_posts_today();
		    $data['deleted_accounts'] = $this->Admin_model->count_deleted_accounts();
	    	$data['blocked_accounts'] = $this->Admin_model->count_blocked();
	    	$data['online_users'] = $this->Admin_model->count_online();
	    	$data['last_seen_today'] = 	$this->Admin_model->count_last_seen_today();	
	    	$data['new_registrations'] = $this->Admin_model->count_new_registrations();  
		
			 $this->load->view('templates/header');
		     $this->load->view('admin/home', $data);
			 $this->load->view('admin/users', $data);
			  $this->load->view('templates/footer');
		}

		public function help(){
			$this->load->view('templates/header');
			$this->load->view('admin/help');
			$this->load->view('templates/footer');
		}

	  public function users_today(){
	  	  $data['all_users'] = $this->Admin_model->count_users();
			$data['posts_today'] = $this->Admin_model->count_posts_today();
		    $data['deleted_accounts'] = $this->Admin_model->count_deleted_accounts();
	         $data['blocked_accounts'] = $this->Admin_model->count_blocked();
	    	$data['online_users'] = $this->Admin_model->count_online();
	    	$data['last_seen_today'] = 	$this->Admin_model->count_last_seen_today();
	        $data['new_registrations'] = $this->Admin_model->count_new_registrations();	

		
			 $this->load->view('templates/header');
		     $this->load->view('admin/home', $data);
			 $this->load->view('admin/users_today', $data);
			  $this->load->view('templates/footer');
	  }

		  public function get_online_datatable(){
		    
		    // POST data
            $postData = $this->input->post();
		    // Get data
		    $data = $this->Admin_model->get_online_datatable();

		    echo json_encode($data);
		  }

		public function online(){
			$data['all_online'] = $this->Admin_model->get_online_users();
			$data['all_users'] = $this->Admin_model->count_users();
			$data['posts_today'] = $this->Admin_model->count_posts_today();
		    $data['deleted_accounts'] = $this->Admin_model->count_deleted_accounts();
	        $data['blocked_accounts'] = $this->Admin_model->count_blocked();
	    	$data['online_users'] = $this->Admin_model->count_online();
	    	$data['last_seen_today'] = 	$this->Admin_model->count_last_seen_today();
	    	$data['new_registrations'] = $this->Admin_model->count_new_registrations();

		
			 $this->load->view('templates/header');
			  $this->load->view('admin/home', $data);
			 $this->load->view('admin/online', $data);
			 $this->load->view('templates/footer');
		}
		public function blocked(){
            
            $data['all_online'] = $this->Admin_model->get_online_users();
			$data['all_users'] = $this->Admin_model->count_users();
			$data['posts_today'] = $this->Admin_model->count_posts_today();
		    $data['deleted_accounts'] = $this->Admin_model->count_deleted_accounts();
	    	$data['blocked_accounts'] = $this->Admin_model->count_blocked();
	    	$data['online_users'] = $this->Admin_model->count_online();
	    	$data['last_seen_today'] = 	$this->Admin_model->count_last_seen_today();
	    	$data['new_registrations'] = $this->Admin_model->count_new_registrations();

			$this->load->view('templates/header');
		    $this->load->view('admin/home', $data);
			$this->load->view('admin/blocked', $data);
		}

        public function charts(){

           	$data['users'] = $this->Admin_model->get_users();
			$data['all_users'] = $this->Admin_model->count_users();
			$data['online_users'] = $this->Admin_model->count_online();
			$data['posts_today'] = $this->Admin_model->count_posts_today();
			$data['deleted_accounts'] = $this->Admin_model->count_deleted_accounts();
	        $data['blocked_accounts'] = $this->Admin_model->count_blocked();
	    	$data['last_seen_today'] = 	$this->Admin_model->count_last_seen_today();
	    	$data['new_registrations'] = $this->Admin_model->count_new_registrations();


        	$this->load->view('templates/header');
		    $this->load->view('admin/home', $data);
			$this->load->view('admin/charts');
			$this->load->view('templates/footer');
        }
		public function deleted(){

           	$data['users'] = $this->Admin_model->get_users();
			$data['all_users'] = $this->Admin_model->count_users();
			$data['online_users'] = $this->Admin_model->count_online();
			$data['posts_today'] = $this->Admin_model->count_posts_today();
			$data['deleted_accounts'] = $this->Admin_model->count_deleted_accounts();
	        $data['blocked_accounts'] = $this->Admin_model->count_blocked();
	    	$data['last_seen_today'] = 	$this->Admin_model->count_last_seen_today();
	    	$data['new_registrations'] = $this->Admin_model->count_new_registrations();

			$this->load->view('templates/header');
		    $this->load->view('admin/home', $data);
			$this->load->view('admin/deleted', $data);
		}

		public function pdf(){
			$this->load->view('admin/pdf');
		}

		public function new_registrations(){

		
           	$data['users'] = $this->Admin_model->get_users();
			$data['all_users'] = $this->Admin_model->count_users();
			$data['online_users'] = $this->Admin_model->count_online();
			$data['posts_today'] = $this->Admin_model->count_posts_today();
			$data['deleted_accounts'] = $this->Admin_model->count_deleted_accounts();
	        $data['blocked_accounts'] = $this->Admin_model->count_blocked();
	    	$data['last_seen_today'] = 	$this->Admin_model->count_last_seen_today();
	    	$data['new_registrations'] = $this->Admin_model->count_new_registrations();


			$this->load->view('templates/header');
		    $this->load->view('admin/home', $data);
			$this->load->view('admin/new_registrations', $data);
		}


		 public function fetch_online_users(){

		 	$res = $this->Admin_model->get_online_users();

		 	foreach ($res as $re) : ?>
		 		<tr>
		 			<td><?php echo $re['firstname'] ?></td>
	              	<td><?php echo $re['lastname'] ?></td>
	              	<td><?php echo $re['username'] ?></td>
	              	<td><?php echo $re['email'] ?></td>
	              	<td><button delete_user_id="<?php echo $re['user_id']; ?>" class="btn btn-danger block">Block</button></td>
		 		</tr>
		 	<?php endforeach;
		 	exit();
		 }

		 public function fetch_new_registrations(){

		 	$resu = $this->Admin_model->get_new_registrations();

		 	foreach ($resu as $re) : ?>
		 		<tr>
		 			<td><?php echo $re['firstname'] ?></td>
	              	<td><?php echo $re['lastname'] ?></td>
	              	<td><?php echo $re['username'] ?></td>
	              	<td><?php echo $re['email'] ?></td>
	    
		 		</tr>
		 	<?php endforeach;
		 	exit();
		 }

		 public function search_new_registrations(){
            
            $key = $this->input->post('search');

             if(!empty($key)){

		 	$resul = $this->Admin_model->search_new_registrations($key);
            
		 	foreach ($resul as $re) : ?>
		 		<tr>
		 			<td><?php echo $re['firstname'] ?></td>
	              	<td><?php echo $re['lastname'] ?></td>
	              	<td><?php echo $re['username'] ?></td>
	              	<td><?php echo $re['email'] ?></td>
		 		</tr>
		 		
		 	<?php endforeach;	
		 }else{

		 	$result = $this->Admin_model->get_new_registrations();

		 	foreach ($result as $res) : ?>
		 		<tr>
		 			<td><?php echo $res['firstname'] ?></td>
	              	<td><?php echo $res['lastname'] ?></td>
	              	<td><?php echo $res['username'] ?></td>
	              	<td><?php echo $res['email'] ?></td>
	    
		 		</tr>
		 	<?php endforeach;
		 	exit();
		 }
		 }

		 public function search_users(){

            $key = $this->input->post('search');
		 	$sec_results = $this->Admin_model->search_users($key);
            
            if (empty($key)) {
            	$resuls = $this->Admin_model->get_users();

		 	foreach ($resuls as $res) : ?>
		 		<tr>
		 			<td><?php echo $res['firstname'] ?></td>
	              	<td><?php echo $res['lastname'] ?></td>
	              	<td><?php echo $res['username'] ?></td>
	              	<td><?php echo $res['email'] ?></td>
	              	<td><?php echo $res['last_active'] ?></td>
	              	<td><button delete_user_id="<?php echo $res['user_id']; ?>" class="btn btn-danger block">Block</button></td>
		 		</tr>
		 	<?php endforeach;
            }else{


		 	foreach ($sec_results as $res) : ?>
		 		<tr>
		 			<td><?php echo $res['firstname'] ?></td>
	              	<td><?php echo $res['lastname'] ?></td>
	              	<td><?php echo $res['username'] ?></td>
	              	<td><?php echo $res['email'] ?></td>
	              	<td><?php echo $res['last_active'] ?></td>
	              	<td><button delete_user_id="<?php echo $res['user_id']; ?>" class="btn btn-danger block">Block</button></td>
		 		</tr>
		 	<?php endforeach;
            }

        }


	    public function fetch_users(){
		 	$esults = $this->Admin_model->get_users();

		 	foreach ($esults as $res) : ?>
		 		<tr>
		 			<td><?php echo $res['firstname'] ?></td>
	              	<td><?php echo $res['lastname'] ?></td>
	              	<td><?php echo $res['username'] ?></td>
	              	<td><?php echo $res['email'] ?></td>
	              	<td><?php echo $res['last_active'] ?></td>
	              	<td><button delete_user_id="<?php echo $res['user_id']; ?>" class="btn btn-danger block">Block</button></td>
		 		</tr>
		 	<?php endforeach;
		 	
		 	exit();

		 }
		 
		 public function fetch_blocked_users(){

		 	$results = $this->Admin_model->get_all_blocked();

		 	foreach ($results as $res) : ?>
		 		 <tr>
		 		 	<td><?php echo $res['firstname'] ?></td>
		 		 	<td><?php echo $res['lastname'] ?></td>
		 		 	<td><?php echo $res['username'] ?></td>
		 		 	<td><?php echo $res['email'] ?></td>
		 		 	<td><?php echo $res['last_active'] ?></td>
		 		 	<td><button type="button" delete_user_id="<?php echo $res['user_id']; ?>" class="btn btn-primary unblock">Activate</button></td>
		 		 </tr>
		 	<?php endforeach;
		 	exit();
		 	
		 }

		 public function search_blocked_users(){
		   $key = $this->input->post('search');
         
		   if(!empty($key)){
		   
            $results = $this->Admin_model->search_blocked_users($key);
		 	foreach ($results as $res) : ?>
		 		<tr>
		 			<td><?php echo $res['firstname'] ?></td>
	              	<td><?php echo $res['lastname'] ?></td>
	              	<td><?php echo $res['username'] ?></td>
	              	<td><?php echo $res['email'] ?></td>
	              	<td><?php echo $res['last_active'] ?></td>
	              	
	              	<td><button type="button" delete_user_id="<?php echo $res['user_id']; ?>" class="btn btn-primary unblock">Activate</button></td>
		 		</tr>
		 		
		 	<?php endforeach;	
		 }else{
		 		$resu = $this->Admin_model->get_all_blocked();

		 	foreach ($resu as $res) : ?>
		 		 <tr>
		 		 	<td><?php echo $res['firstname'] ?></td>
		 		 	<td><?php echo $res['lastname'] ?></td>
		 		 	<td><?php echo $res['username'] ?></td>
		 		 	<td><?php echo $res['email'] ?></td>
		 		 	<td><?php echo $res['last_active'] ?></td>
		 		 	<td><button type="button" delete_user_id="<?php echo $res['user_id']; ?>" class="btn btn-primary unblock">Activate</button></td>
		 		 </tr>
		 	<?php endforeach;
		 	exit();
		 }
		 	
		 }

		  public function search_deleted_users(){

            $key = $this->input->post('search');

            if (!empty($key)) {
            		$results = $this->Admin_model->search_deleted_users($key);
            
		 	foreach ($results as $res) : ?>
		 		<tr>
		 			<td><?php echo $res['firstname'] ?></td>
	              	<td><?php echo $res['lastname'] ?></td>
	              	<td><?php echo $res['username'] ?></td>
	              	<td><?php echo $res['email'] ?></td>
	              	<td><?php echo $res['last_active'] ?></td>
	              	
	              	<td><button type="button" activate_user_id="<?php echo $res['user_id']; ?>" class="btn btn-primary activate" id="activate">Activate</button></td>
		 		</tr>
		 		
		 	<?php endforeach;	
		 	exit();
            }else{
            	$resu = $this->Admin_model->get_deleted();

		 	foreach ($resu as $res) : ?>
		 		 <tr>
		 		 	<td><?php echo $res['firstname'] ?></td>
		 		 	<td><?php echo $res['lastname'] ?></td>
		 		 	<td><?php echo $res['username'] ?></td>
		 		 	<td><?php echo $res['email'] ?></td>
		 		 	<td><?php echo $res['last_active'] ?></td>
		 		 	<td><button type="button" activate_user_id="<?php echo $res['user_id']; ?>" class="btn btn-primary activate" id="activate">Activate</button></td>
		 		 </tr>
		 	<?php endforeach;
		 	exit();
            }
		 
         }

		 public function search_today_users(){
            

		 	 $key = $this->input->post('search');

		 	 if(!empty($key)){
		 	 	$results = $this->Admin_model->search_today_users($key);
            
			 	foreach ($results as $res) : ?>
			 		<tr>
			 			<td><?php echo $res['firstname'] ?></td>
		              	<td><?php echo $res['lastname'] ?></td>
		              	<td><?php echo $res['username'] ?></td>
		              	<td><?php echo $res['email'] ?></td>
			 		</tr>
			 		
			 	<?php endforeach;	
			 	 }
			 	else{
			 			$resu = $this->Admin_model->get_today_users();

					 	foreach ($resu as $res) : ?>
					 		<tr>
					 			<td><?php echo $res['firstname'] ?></td>
				              	<td><?php echo $res['lastname'] ?></td>
				              	<td><?php echo $res['username'] ?></td>
				              	<td><?php echo $res['email'] ?></td>
					 		</tr>
					 	<?php endforeach;
			 	}

			 	
		 }

		 	 public function fetch_today_users(){

		 	$results = $this->Admin_model->get_today_users();

		 	foreach ($results as $res) : ?>
		 		<tr>
		 			<td><?php echo $res['firstname'] ?></td>
	              	<td><?php echo $res['lastname'] ?></td>
	              	<td><?php echo $res['username'] ?></td>
	              	<td><?php echo $res['email'] ?></td>
		 		</tr>
		 	<?php endforeach;
		 	exit();
		 }

		 public function fetch_deleted_users(){

		 	$results = $this->Admin_model->get_deleted();

		 	foreach ($results as $res) : ?>
		 		 <tr>
		 		 	<td><?php echo $res['firstname'] ?></td>
		 		 	<td><?php echo $res['lastname'] ?></td>
		 		 	<td><?php echo $res['username'] ?></td>
		 		 	<td><?php echo $res['email'] ?></td>
		 		 	<td><?php echo $res['last_active'] ?></td>
		 		 	<td><button type="button" activate_user_id="<?php echo $res['user_id']; ?>" class="btn btn-primary activate" id="activate">Activate</button></td>
		 		 </tr>
		 	<?php endforeach;
		 	exit();
		 }


		 public function block_user(){
		 	$result = $this->Admin_model->delete_user();
		 	echo $result;
		 	exit();
		 }
		 public function activate_user(){
		 	$result = $this->Admin_model->activate_user();
		 	echo $result;
		 	exit();
		 }
		 public function activate_deleted_user(){
		 	$result = $this->Admin_model->activate_deleted_user();
		 	echo $result;
		 	exit();
		 }


		 public function block_online_user(){
		 	$result = $this->Admin_model->block_online_user();
		 	echo $result;
		 	exit();
		 }

		public function get_all_users(){

			$results = $this->Admin_model->get_all_users();

		 	foreach ($results as $res) : ?>
		 		<tr>
		 			<td><?php echo $res['user_id'] ?></td>
	              	<td><?php echo $res['firstname'] ?></td>
	              	<td><?php echo $res['lastname'] ?></td>
	              	<td><button edit_user_id="<?php echo $res['user_id']; ?>" class="btn btn-info edit">Edit</button></td>
	              	<td><button delete_user_id="<?php echo $res['user_id']; ?>" class="btn btn-danger block">Block</button></td>
		 		</tr>
		 	<?php endforeach;
		 	exit();

		}
		public function get_all_online_users(){

			$results = $this->Admin_model->get_all_online_users();

		 	foreach ($results as $res) : ?>
		 		<tr>
		 			<td><?php echo $res['user_id'] ?></td>
	              	<td><?php echo $res['firstname'] ?></td>
	              	<td><?php echo $res['lastname'] ?></td>
	             
	              	<td><button delete_user_id="<?php echo $res['user_id']; ?>" class="btn btn-danger block">Block</button></td>
		 		</tr>
		 	<?php endforeach;
		 	exit();
		}
		 public function search_online_users(){

		    $key = $this->input->post('search');

            if(!empty($key)){

            		$results = $this->Admin_model->search_online_users($key);           
				 	foreach ($results as $res) : ?>
				 		<tr>
				 			<td><?php echo $res['firstname'] ?></td>
			              	<td><?php echo $res['lastname'] ?></td>
			              	<td><?php echo $res['username'] ?></td>
			              	<td><?php echo $res['email'] ?></td>
			              	
			              	<td><button delete_user_id="<?php echo $res['user_id']; ?>" class="btn btn-danger block">Block</button></td>
				 		</tr>
				 		
				 	<?php endforeach;	
		 }else{
		 		$resu = $this->Admin_model->get_all_online_users();

		 	foreach ($resu as $res) : ?>
		 		<tr>
		 			<td><?php echo $res['user_id'] ?></td>
	              	<td><?php echo $res['firstname'] ?></td>
	              	<td><?php echo $res['lastname'] ?></td>
	             
	              	<td><button delete_user_id="<?php echo $res['user_id']; ?>" class="btn btn-danger block">Block</button></td>
		 		</tr>
		 	<?php endforeach;
		 }
		   

		 }

		public function print_pdf()
		{
				$data['users'] = $this->Admin_model->get_users();
			$data['all_users'] = $this->Admin_model->count_users();
			$data['online_users'] = $this->Admin_model->count_online();
			$data['posts_today'] = $this->Admin_model->count_posts_today();
			$data['deleted_accounts'] = $this->Admin_model->count_deleted_accounts();
	        $data['blocked_accounts'] = $this->Admin_model->count_blocked();
	    	$data['last_seen_today'] = 	$this->Admin_model->count_last_seen_today();
	    	$data['new_registrations'] = $this->Admin_model->count_new_registrations();
            
            $this->load->view('templates/header');
			$this->load->library('Pdf');
			$this->load->view('admin/print_pdf', $data);

			
		}
      
		
	}


	

  
