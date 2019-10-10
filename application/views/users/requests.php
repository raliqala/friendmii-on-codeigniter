<script src="https://kit.fontawesome.com/1b5939c109.js"></script>

	<style type="text/css">
		.main-box.no-header {
		    padding-top: 20px;
		}
		.label {
		    border-radius: 3px;
		    font-size: 0.875em;
		    font-weight: 600;
		}
		.user-list tbody td .user-subhead {
	    font-size: 0.875em;
			font-style: italic;
			color: #007bff;
			top: -.5em;
			position: relative;
		}
		.user-list tbody td .user-link {
		  display: block;
			font-size: 1.25em;
			margin-left: 2.7em;
			margin-top: -.1em;
		}
		a, 
		button,
	 .btn,
	 .btn-primary, 
	 .btn-danger{
		    outline: none!important;
		}
		.user-list tbody td img {
		  position: relative;
			max-width: 50px;
			float: left;
			margin-right: 5px;
			background-size: 40px 40px;
			border-radius: 100px;
			-o-object-fit: cover;
			object-fit: cover;
		}

		.table thead tr th {
		    text-transform: uppercase;
		    font-size: 0.875em;
		}
	</style>
     <!-- <div class="row pull-left ml-auto">
      <div class="card" style="width: 17rem; position: absolute; left: em;">
        <img class="card-img-top" src="./public/assets/default-fav.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div> -->

   <!-- <div class="row pull-right mr-auto">
      <div class="card" style="width: 21.5rem; position: absolute; right: 1.2em; top: 10em;">
        <img class="card-img-top" src="./public/assets/default-fav.jpg" width="100" height="100" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div> -->
      <div class="row mt-4">
        <div class="col text-center">
          <h3><?php echo $title; ?></h3>
        </div>
      </div>

		<div class="container">
		  <div class="row">
		    <div class="col-lg-12">
		      <div class="main-box no-header clearfix">
		          <div class="main-box-body clearfix">
		            <div class="table-responsive">
		              <table class="table user-list">
		              <tbody>
		            <?php foreach ($requests as $friendRequest): ?>
		              <tr>
		                  <td>
		                    <a href="<?php echo base_url(); ?>profile?u=<?php echo $friendRequest['username']; ?>">
						              <?php if (!empty($friendRequest['image'])): ?>
						                <img src="<?php echo base_url();?><?php echo 'assets/images/profileimages/'.$friendRequest['image']; ?>" width="40" height="40" alt="p-pic">
						              <?php else: ?>
						                <img src="<?php echo base_url();?>assets/blank-profile.png" width="40" height="40" alt="profile pic">
						              <?php endif; ?>
						            </a>
		                      <a href="javascript:void(0);" class="user-link"><?php echo $friendRequest['firstname'] ." ". $friendRequest['lastname']; ?></a>
		                      <span class="user-subhead"><?php echo "@".$friendRequest['username']; ?></span>
		                  </td>
		                  <td style="font-size: larger;color: #007bff;">
		                  	<?php echo $friendRequest['firstname']?> sent you a friend request <span style="font-size: 12px;color: #03df03;margin-left: .5em;"><?php echo get_time_ago($friendRequest['request_on']); ?></span>
		                  </td>
		                  <td style="width: 14%;">
		                      <button class="btn btn-labeled btn-primary" onclick="addfriend('<?php echo $friendRequest['user_id']; ?>')">
		                         <span class="btn-label"><i class="fa fa-user-plus"></i></span>
			                  		Accept
		                      </button>
		                  </td>
		                  <td style="width: ;">Or</td>
		                  <td style="width: 5%;">
		                  	<button class="btn btn-labeled btn-danger" onclick="cancelfriendRequest('<?php echo $friendRequest['user_id']; ?>')">
				                  <span class="btn-label"><i class="fa fa-user-times"></i></span>
				                  Ignore
				                </button>
		                  </td>
		              </tr>
		              <?php endforeach ?>
		              </tbody>
		              </table>
		            </div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

<script type="text/javascript">
	  function cancelfriendRequest(user_id){
    if(confirm('Are you sure you want to ignore this freiend-request?')){
      $.ajax({
          type:'POST',
          url:'<?php echo base_url(); ?>profile/cancelFriendRequest/'+user_id,
          cache: false,
          success: function(unrequest){
            if (unrequest == true) {
              setTimeout(function(){
                location.reload();
              });
            }else {
              alert('Sorry something went wrong, Please try again');
              return false;
            }
          }
      });
    }
  }

  function addfriend(user_id){
    $.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>/profile/acceptFriendRequest/'+user_id,
        cache: false,
        success: function(addfriend){
          if (addfriend == true) {
            setTimeout(function(){
              location.reload();
            });
          }else {
            alert('Sorry something went wrong, Please try again');
            return false;
          }
        }
    });
  }

</script>


