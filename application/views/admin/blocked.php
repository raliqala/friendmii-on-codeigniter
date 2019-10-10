
        <!--Users -->
     <div class="col-md-9">
          <div class="card">
          <div class="card-body">
            <h3>Blocked Users</h3>
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
                               <th width="20%">User Name</th>  
                               <th width="20%">Email</th> 
                               <th width="20%">Last Active</th> 
                          </tr>  
                     </thead>
                     <tbody id="blocked_user_data">
                       
                     </tbody>
                </table>  
           </div>  
          </div>
        </div>
      </div>

    </div>
     </div>

     <script>
  $(document).ready(function(){
    get_blocked_users();
    function get_blocked_users(){
       $.ajax({
        url: '<?php echo site_url('admin/fetch_blocked_users') ?>',
        success: function(data){
          $('#blocked_user_data').html(data);
        }
      });
    };
     $('#search').on('keyup', function(){
           $.ajax({
            url: '<?php echo site_url('admin/search_blocked_users') ?> ',
            method: 'post',
            data: {search: $('#search').val()},
            success: function(data){
              $('#blocked_user_data').html(data);
            }
          });
      });

    $('body').delegate('.unblock', 'click', function(){
       if(confirm('Are you sure you want to acticate this user account?')){
           var id = $(this).attr('delete_user_id');
            $.ajax({
                url: '<?php echo site_url('admin/activate_user') ?>',
                method: 'post',
                data: {id: id},
                success: function(data){
                  if(data == 'success'){
                    alert('User activated');
                    get_users();
                  }else{
                    alert('User not activated');
                  }
                  
                }
              });
       }
      });
  });
</script>