<?php 
//code for creating a php table



            <table class="table table-striped table-hover">
              <tr>
              <td>User ID</td>
              <td>First Name</td>
              <td>Last Name</td>
              <td>User Name</td>
          
            </tr>
            <?php foreach ($all_online as $online): ?>
            
            <tr>
              <td><?php echo $online['user_id'] ?></td>
              <td><?php echo $online['firstname'] ?></td>
              <td><?php echo $online['lastname'] ?></td>
              <td><?php echo $online['username'] ?></td>
           
            </tr>
          <?php endforeach; ?>
            </table>





 <div class="col-md-9">
         <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Online Users</h3>
          </div>
          <div class="panel-body">
           
            <div class="table-responsive">  
                <br/>  
                <table class="table table-bordered table-striped">  
                     <thead>
                      <tr><td colspan="4"></td><td colspan="2"><input id="search" type="text" name="search" class="form-control"></td></tr>
                          <tr>  
                               <th width="15%">First Name</th>  
                               <th width="15%">Last Name</th>  
                               <th width="15">User Name</th>  
                               <th width="15">Email</th>  
                               <th width="20%">Action</th>
                          </tr>  
                     </thead>
                   <tbody id="user_data">
                       
                     </tbody>
                </table>  
           </div>  


          </div>
        </div>
        </div>

<script>
  $(document).ready(function(){
    get_online_users();
   });
    function get_online_users(){
       $.ajax({
        url: 'http://localhost:8080/CodeIgniter/pages/fetch_online_users',
        success: function(data){
          $('#user_data').html(data);
        }
      });
    };

      $('#search').on('keyup', function(){
           $.ajax({
            url: 'http://localhost:8080/CodeIgniter/pages/search_online_users',
            method: 'post',
            data: {search: $('#search').val()},
            success: function(data){
              $('#user_data').html(data);
                
            }
            
          });
      });

      $('body').delegate('.block', 'click', function(){
       if(confirm('Are you sure you want to block this user?')){
           var id = $(this).attr('delete_user_id');
            $.ajax({
                url: 'http://localhost:8080/CodeIgniter/pages/block_online_user',
                method: 'post',
                data: {id: id},
                success: function(data){
                  if(data == 'success'){
                    alert('User blocked');
                    get_users();
                  }else{
                    alert('User not blocked');
                  }
                  
                }
              });
       }
      });
 
</script>

?>