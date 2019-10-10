 <div class="col-md-9">                
          <div class="card">
          <div class="card-body">
            <h3>Deleted Accounts</h3>
          </div>
        </div>
          <div class="panel-body">
            <div class="table-responsive">  
                <br />  
                <table class="table table-bordered table-striped">  
                     <thead>
                      <tr><td colspan="4"></td><td colspan="2"><input id="search" type="text" name="" placeholder="Search"class="form-control"></td></tr>
                          <tr>  
                               <th width="20%">First Name</th>  
                               <th width="20%">Last Name</th>  
                               <th width="20">User Name</th>  
                               <th width="20">Email</th>   
                               <th width="20%">Last Active</th>
                              <th width="10%"></th>

                          </tr>  
                     </thead>
                     <tbody id="user_data">
                       
                     </tbody>
                </table>  
           </div> 
          </div>    
        </div>
<script>
  $(document).ready(function(){
    get_online_users();
    function get_online_users(){
       $.ajax({
        url: '<?php echo site_url('admin/fetch_deleted_users'); ?>',
        success: function(data){
          $('#user_data').html(data);
        }
      });
    };

      $('#search').on('keyup', function(){
           $.ajax({
            url: '<?php echo site_url('admin/search_deleted_users'); ?>',
            method: 'post',
            data: {search: $('#search').val()},
            success: function(data){
              $('#user_data').html(data);
            }
          });
      });

      $('body').delegate('.activate', 'click', function(){
       if(confirm('Are you sure you want to re-activate this user?')){
           var id = $(this).attr('activate_user_id');
            $.ajax({
                url: '<?php echo site_url('admin/activate_deleted_user'); ?>',
                method: 'post',
                data: {id: id},
                success: function(data){
                  console.log(data);
                  if(data == 'success'){
                    alert('User Activated');
                    get_users();
                  }else{
                    alert('User not Activated');
                  }
                  
                }
              });
       }
      });
  });
</script>