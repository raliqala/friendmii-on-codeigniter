
	<style>

	h3{
		font-size: 24px; 
		color: #555;	
		font-weight: bold;
	}
	h4{
		font-size: 18px; 
		color: #555;	
		font-weight: bold;
	}
	.card{
		border-radius: 0; 
		/*box-shadow: 5px 5px 15px #e74c3c;
		transition: all 0.3s ease-in;
		-webkit-transition: all 0.3s ease-in;
		/*-moz-transition: all 0.3s ease-in;*/
	}
	.card:hover{
		background: #e74c3c;
		color:#fff;
		border-radius: 5px;
		border: none;
		box-shadow: 5px 5px 15px #9E9E9E;
	}
	.card:hover h3{
		color: #fff;
	}

	.container{
		margin-top: 100px;
	}
	.newarrival{
		background: green;
		width: 200px;
		color: white;
		font-size: 20px; font-weight: bold;
	}
	.cart:hover
	{
		background: green; color: white;
		 background-color: green;
	}
	.active img{
		border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 150px;
	}
	</style>

	<a class="btn btn-info" href="<?php echo site_url('posts')?>">Back</a>
	<table>
		<tbody>
			<?php foreach($users as $user) :?>

				<?php if (empty($user)): ?>
					Sorry we couldn't find the results you are searching for..
					<?php else: ?>
						<div class="container">
				<div class="row">
					<div class="col-md-5">
							<div id="carouselExampleControls"> 
							  <div class="carousel-inner">
							    <div class="carousel-item active">
							      <img src="<?php echo base_url(); ?><?php echo 'assets/images/profileimages/'.$user['image']; ?>" class="d-block w-100" alt="firstSlide">
							    </div>
							</div>
							  </div>
							  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
							    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
							  </a>
							</div>
							<div class="col-md-5">
								<p class="newarrival text-center">Friend Information</p>
								<h4><p>Name:&nbsp;<?=$user['firstname']?>&nbsp;&nbsp;<?=$user['lastname']?></p></h4>
								<h4><p><p>Email Address:&nbsp;<?=$user['email']?></p></h4>
								<h4><p><p>Biography:&nbsp;<?=$user['bio']?></p></h4>
								<p>
									
									<?php
                    if (is_already_friends($this->session->userdata('user_id'), $user['user_id'])) {
                      echo 'You and '.$user['firstname'].' are friends.';
                    }elseif (i_am_sender($this->session->userdata('user_id'), $user['user_id'])) {
                      echo '<a class="btn btn-danger white-text" style="width:100%;" onclick="cancelfriendRequest('.$user['user_id'].')">
                        Cancel friend request
                      </a>';
                      echo '<a class="btn btn-light white-text disabled" style="width:100%;">
                        Friend request sent
                      </a>';
                    }elseif (i_am_receiver($this->session->userdata('user_id'), $user['user_id'])) {
                      echo '<a class="btn btn-primary white-text" style="width:100%;" onclick="addfriend('.$user['user_id'].')">
                        Accept
                      </a>';
                      echo "Or";
                      echo '<a class="btn btn-danger white-text" style="width:100%;" onclick="cancelfriendRequest('.$user['user_id'].')">
                        Ignore
                      </a>';
                    }else {
                      echo '<a class="btn btn-primary white-text" style="width:100%;" onclick="sendfriendRequest('.$user['user_id'].')">
                        Send friend request
                      </a>';
                    }
                  ?>
							  </p>
								</div>
						</div>
					</div>
				<?php endif ?>
				</div>
		</tbody>
		<?php endforeach; ?>
	</table>

<script type="text/javascript">
	  function sendfriendRequest(user_id){
    $.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>profile/sendFriendRequest/'+user_id,
        cache: false,
        success: function(request){
          if (request == true) {
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
    function cancelfriendRequest(user_id){
    if(confirm('Are you sure you want to cancel this freiend-request?')){
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

  function unfriend(user_id){
    if(confirm('Are you sure you want to unfriend this user?')){
      $.ajax({
          url:'<?php echo base_url(); ?>/profile/unfriend/'+user_id,
          type:'POST',
          success: function(unrequest){
            setTimeout(function(){
              location.reload();
            });
          },
          error: function(){
            alert("Sorry something went wrong please try again..");
          }
      });
    }
  }
</script>