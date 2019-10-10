 <div class="col-md-9">
            <div class="card">
          <div class="card-body">
            <h3>New Registrations</h3>
          </div>
        </div>

          <div class="panel-body">
           
            <div class="table-responsive">  
                <br />  
                <table class="table table-bordered table-striped">  
                     <thead>
                      <tr><td colspan="3"></td><td colspan="2"><input id="search" type="text" name="" placeholder="Search" class="form-control"></td></tr>
                          <tr>  
                               <th width="20%">First Name</th>  
                               <th width="20%">Last Name</th>  
                               <th width="20">User Name</th>  
                               <th width="20">Email</th>   
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
    get_new_users();
    function get_new_users(){
       $.ajax({
        url: 'http://localhost:8080/CodeIgniter/admin/fetch_new_registrations',
        success: function(data){
          $('#user_data').html(data);
        }
      });
    };

      $('#search').on('keyup', function(){
           $.ajax({
            url: 'http://localhost:8080/CodeIgniter/admin/search_new_registrations',
            method: 'post',
            data: {search: $('#search').val()},
            success: function(data){
              $('#user_data').html(data);
            }
          });
      });

  });
</script>