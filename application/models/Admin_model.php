<?php
	class Admin_model extends CI_Model{

      var $table = "users";  
      var $select_column = array("user_id", "firstname", "lastname");  
      var $order_column = array(null, "firstname", "lastname");  


		public function __construct(){
			$this->load->database();
		}

    public function get_online_datatable($postData=null){

       $response = array();

      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value

      ## Search 
      $searchQuery = "";
      if($searchValue != ''){
          $searchQuery = " (firstname like '%".$searchValue."%' or 
                lastname like '%".$searchValue."%' or 
                email like'%".$searchValue."%' )";
      }


      ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $records = $this->db->get('users')->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $records = $this->db->get('users')->result();
      $totalRecordwithFilter = $records[0]->allcount;

      
      ## Fetch records
      $this->db->select('*');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->order_by($columnName, $columnSortOrder);
      $this->db->limit($rowperpage, $start);
      $records = $this->db->get('users')->result();

      $data = array();

      foreach($records as $record ){
         
          $data[] = array( 
              "firstname"=>$record->firstname,
              "lastname"=>$record->lastname,
              "username"=>$record->username,
              "email"=>$record->email,
  
          ); 
      }

      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );

      return $response; 
  }
    

		public function get_users(){
			 $query = $this->db->query('SELECT * FROM users WHERE  is_activated = 1 AND blocked = 0 AND closed = 0');
       return $query->result_array();
		}

    public function get_online_users(){
      $query = $this->db->query('SELECT * FROM users WHERE online = 1 AND blocked = 0 AND closed = 0 AND is_activated = 1');
      return $query->result_array();
    }

    public function search_users($key){

   $sql = "SELECT * FROM users WHERE is_activated = 1 AND closed = 0 AND blocked = 0 AND firstname like ? OR lastname like ?";
   $result = $this->db->query($sql, array("%".$key."%", "%".$key."%"));
   return $result->result_array();
    
    }

    public function search_blocked_users($key){
      $sql = "SELECT * FROM users WHERE is_activated = 1 AND closed = 0 AND blocked = 1 AND firstname like ? OR lastname like ?";
       $result = $this->db->query($sql, array("%".$key."%", "%".$key."%"));
       return $result->result_array();
    }

    public function search_deleted_users($key){
       $sql = "SELECT * FROM users WHERE is_activated = 1 AND closed = 1 AND blocked = 0 AND firstname like ? OR lastname like ? ";
       $result = $this->db->query($sql, array("%".$key."%", "%".$key."%"));
       return $result->result_array();
    }

    public function search_online_users($key){
    
     $sql = "SELECT * FROM users WHERE online = 1 AND is_activated = 1 AND closed = 0 AND blocked = 0 AND  firstname like ? OR lastname like ? ";
       $result = $this->db->query($sql, array("%".$key."%", "%".$key."%"));
       return $result->result_array();
    
    }

		public function count_users() {
         $query = $this->db->query('SELECT * FROM users WHERE  is_activated = 1 AND closed = 0 And blocked = 0');
          return $query->num_rows();
  
       }

       public function delete_user(){
        $this->db->where('user_id', $this->input->post('id'));
        $result = $this->db->update('users', array('blocked' => 1));
        if($result)
          return 'success';
        else
          return 'error';
       }

       public function block_online_user(){
         $this->db->where('user_id', $this->input->post('id'));
        $result = $this->db->update('users', array('blocked' => 1));
        if($result)
          return 'success';
        else
          return 'error';
       }

       public function activate_user(){
         $this->db->where('user_id', $this->input->post('id'));
        $result = $this->db->update('users', array('blocked' => 0));
        if($result)
          return 'success';
        else
          return 'error';
       }

       public function activate_deleted_user(){
        $this->db->where('user_id', $this->input->post('id'));
        $result = $this->db->update('users', array('closed' => 0));
        if($result)
          return 'success';
        else
          return 'error';
       }
       public function count_online(){
        
         $query = $this->db->query('SELECT * FROM users WHERE online = 1 AND blocked = 0 AND closed = 0 AND is_activated = 1'); 
       	return $query->num_rows();
       }


       public function count_posts_today(){

        $datebytimezone = new DateTime("now",new DateTimeZone('UCT'));
        $date = $datebytimezone->format('Y-m-d');
        $query = $this->db->get_where('post',array('posted_at >=' => "{$date} 00:00:00",'post_closed' => 0)
         );
        return $query->num_rows();
       }

       public function count_new_registrations(){

        $datebytimezone = new DateTime("now",new DateTimeZone('UCT'));
        $date = $datebytimezone->format('Y-m-d');
        $query = $this->db->get_where('users',array('acount_created_at >=' => "{$date} 00:00:00")
         );
        return $query->num_rows();
       }

       public function get_new_registrations(){
         $datebytimezone = new DateTime("now",new DateTimeZone('UCT'));
        $date = $datebytimezone->format('Y-m-d');
        $query = $this->db->get_where('users',array('acount_created_at >=' => "{$date} 00:00:00")
         );
        return $query->result_array();
       }

       public function count_last_seen_today(){
        $datebytimezone = new DateTime("now",new DateTimeZone('UCT'));
        $date = $datebytimezone->format('Y-m-d');
        $query = $this->db->get_where('users',array('last_active>=' => "{$date} 00:00:00",'is_activated' => 1 ,'blocked' => 0 ,'closed' => 0)
      );
        return $query->num_rows();
       }

       public function get_today_users(){
        $datebytimezone = new DateTime("now",new DateTimeZone('UCT'));
        $date = $datebytimezone->format('Y-m-d');
        $query = $this->db->get_where('users',array('last_active>=' => "{$date} 00:00:00",'is_activated' => 1 ,'blocked' => 0 ,'closed' => 0)
         );
        return $query->result_array();
       }

        public function search_today_users($key){

        $datebytimezone = new DateTime("now",new DateTimeZone('UCT'));
        $date = $datebytimezone->format('Y-m-d');
       $sql = "SELECT * FROM users WHERE is_activated = 1 AND closed = 0 AND blocked = 0 AND firstname like ? OR lastname like ? AND 'last_active' = ? ";
       $result = $this->db->query($sql, array("%".$key."%", "%".$key."%", "%".$date."%"));
       return $result->result_array();
    }

      public function search_new_registrations($key){
         $datebytimezone = new DateTime("now",new DateTimeZone('UCT'));
        $date = $datebytimezone->format('Y-m-d');
       $sql = "SELECT * FROM users WHERE is_activated = 1 AND firstname like ? OR lastname like ? AND 'acount_created_at' = ? ";
       $result = $this->db->query($sql, array("%".$key."%", "%".$key."%", "%".$date."%"));
       return $result->result_array();
      }

     public function count_deleted_accounts(){
     	$query = $this->db->query('SELECT * FROM users WHERE closed = 1');
     	return $query->num_rows();
     	
     	
     }
     public function get_deleted(){
     	$query = $this->db->query('SELECT * FROM users WHERE closed = 1 AND is_activated = 1');
     	 return $query->result_array();
     }

     public function count_blocked(){
     	$query = $this->db->query('SELECT * FROM users WHERE is_activated = 1 AND blocked = 1 AND closed = 0
        ');
     	return $query->num_rows();
     }


     public function get_all_users(){
          
          $query = $this->db->get('users' );
         return $query->result_array();

      }     

     public function get_all_blocked(){
      $query = $this->db->query('SELECT * FROM users WHERE blocked = 1 AND closed = 0 AND is_activated = 1');
      return $query->result_array();
     }
    //force user to enter more than 1 character to search

	}



