<div class="col-md-9">  
               <div class="card">
          <div class="card-body">
            <h3>Last Seen Today Users</h3>
          </div>
        </div>
            <div class="table-responsive">  
                <br />  
                <table class="table table-bordered table-striped">  
                     <thead>
                      <tr><td colspan="3"></td><td colspan="2"><input id="search" type="text" name="" placeholder="Search" class="form-control"></td></tr>
                          <tr>  
                               <th width="20%">First Name</th>  
                               <th width="20%">Last Name</th>  
                               <th width="35%">User Name</th>  
                               <th width="15">Email</th>  
                            
                          </tr>  
                     </th ead>
                     <tbody id="user_data">
                       
                     </tbody>
                </table>  
           </div>  
          </div>
        </div>
      

<script>
  $(document).ready(function(){
    fetch_today_users();
    function fetch_today_users(){
       $.ajax({
        url: '<?php echo site_url('admin/fetch_today_users'); ?>',
        success: function(data){
          $('#user_data').html(data);
        }
      });
    };

      $('#search').on('keyup', function(){
           $.ajax({
            url: '<?php echo site_url('admin/search_today_users'); ?>',
            method: 'post',
            data: {search: $('#search').val()},
            success: function(data){
              $('#user_data').html(data);
            }
          });
      });

     /* $('body').delegate('.delete', 'click', function(){
       if(confirm('Are you sure you want to delete this user?')){
           var id = $(this).attr('delete_user_id');
            $.ajax({
                url: 'http://localhost:8080/CodeIgniter/admin/',
                method: 'post',
                data: {id: id},
                success: function(data){
                  if(data == 'success'){
                    alert('User deleted');
                    get_users();
                  }else{
                    alert('User not deleted');
                  }
                  
                }
              });
       }
      });*/
  });
</script>