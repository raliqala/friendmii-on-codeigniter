 <link href="<?php echo base_url(); ?>assets/css/mdb.min.css" rel="stylesheet">
 <?php
   $current_user = $this->session->userdata('user_id');
   $request_num = request_notification($current_user, false);
   $notification_num = notificationUnreadNumber($current_user);
   //<?php echo $notification_num;
 ?>

<!--  <style type="text/css">
  .f-badge{
      position: absolute;
      top: 4px;
      right: 0;
      color: #fff;
      background-color: red;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      line-height: 18px;
      font-size: 10px;
      text-align: center;
      cursor: pointer;
  }
</style> -->
<style type="text/css">
  .badge {
    display: inline-block;
    padding-right: 5px;
    padding-left: 5px;
    font-size: 50%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
  }
  .twitter-typeahead, .tt-hint, .tt-input, .tt-menu { width: 10em; }
</style>
<nav class="mb-4 navbar fixed-top navbar-expand-lg navbar-dark default-color">
  <!-- Navbar brand -->

   <a class="navbar-brand" href="http://localhost/friendmiiDemo/posts">FriendMii</a>


   <!-- Collapse button -->
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
     aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
     <span class="navbar-toggler-icon"></span>
   </button>

   <!-- Collapsible content -->
   <div class="collapse navbar-collapse" id="basicExampleNav">
 <!-- <a href="#" data-activates="slide-out" class="button-collapse white-text"><i class="fa fa-bars"></i></a> -->
     <!-- Links -->
     <ul class="navbar-nav mr-auto mx-auto custom-links">
       <li class="nav-item ">
         <a class="nav-link" href="<?php echo base_url(); ?>posts"> <i class="fa fa-home"></i>
           <span class="sr-only">(current)</span>
         </a>
       </li>
       <li class="nav-item">
         <a class="nav-link" href="<?php echo base_url(); ?>pages/help"><i class="fa fa-question-circle" aria-hidden="true"></i> </a>
       </li>
       <li class="nav-item">
         <a class="nav-link" href="#"><i class="fa fa-envelope" aria-hidden="true"></i> </a>
       </li>
      <!--  <li class="nav-item">
         <a class="nav-link" href="#">FM</a>
       </li> -->
       <li class="nav-item">
         <a class="nav-link" onclick="getDropdownData();"><i class="fa fa-bell" aria-hidden="true"></i>
            <?php if ($notification_num > 0): ?>
            <span class="badge badge-pill badge-danger" id="unread_notification" style="float:right;margin-bottom:-10px;margin-left: -5px;">
              <?php echo notification_counter($notification_num); ?>
            </span>
          <?php endif ?>
         </a>
       </li>

       <div class="dropdown_data_window" style="height:0px; border:none;"></div>
       <input type="hidden" id="dropdown_data_type" value="">

       <li class="nav-item">
           <a class="nav-link" href="<?php echo base_url(); ?>users/requests">
            <i class="fa fa-user" aria-hidden="true"></i>
            <?php if ($request_num > 0): ?>
              <span class="badge badge-pill badge-danger" style="float:right;margin-bottom:-10px;margin-left: -5px;" title="You have <?php echo requestOrrequests($request_num); ?>">
                <?php echo $request_num; ?>
              </span>
            <?php endif ?>
           </a>
       </li>

      <!--  <li class="nav-item">
         <a class="nav-link" href="#"><i class="fa fa-heart" aria-hidden="true"></i>  </a>
       </li> -->

       <!-- Dropdown -->

     <!-- Links -->

       <form class="form-inline my-2 my-lg-0 ml-4" class="search-form" action="<?php echo site_url('users/search');?>" method="post">
          <div class="row">
            <div class="col-lg-12">
             <div class="form-group">
               <input class="typeahead form-control" name="title" style="line-height: 1.4;" id="autocomplete" type="search" placeholder="Search" aria-label="Search" autocomplete="off">
             </div>
           </div>
          </div>
         <button class="mr-4" style="background: transparent; border: none; margin-left: -2em; color: #828688;"><i class="fa fa-search"></i></button>
       </form>
     </ul>
   </div>
   <!-- Collapsible content -->
   <ul class="navbar-nav ml-auto nav-flex-icons">
      <li class="nav-item">
        <a href="<?php echo base_url(); ?>profile?u=<?php echo $this->session->userdata('username'); ?>" class="nav-link waves-effect waves-light">
          <?php echo $this->session->userdata('firstname'); ?>
        </a>
      </li>
      <li class="nav-item avatar dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-55" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
            <?php if (!empty($this->session->userdata('profile_pic'))): ?>
              <img src='<?php echo base_url(); ?><?php echo 'assets/images/profileimages/'.$this->session->userdata('profile_pic'); ?>' class="rounded-circle z-depth-0" alt='profile'>
            <?php else: ?>
              <img src="<?php echo base_url(); ?>/assets/blank-profile.png" width="40" height="40" class="img-circle img-responsive" alt='profile'>
            <?php endif; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-left dropdown-default"
          aria-labelledby="navbarDropdownMenuLink-55">
          <a class="dropdown-item" href="<?php echo base_url(); ?>profile?u=<?php echo $this->session->userdata('username'); ?>">Signed in as <strong><?php echo $this->session->userdata('firstname'); ?></strong></a>
          <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#"><i class="fa fa-pencil" aria-hidden="true"></i> Change theme</a>
            <a class="dropdown-item" href="#"><i class="fa fa-info-circle" aria-hidden="true"></i> Terms</a>
            <a class="dropdown-item" href="#"><i class="fa fa-lock" aria-hidden="true"></i> <span> </span> Privacy policy</a>
            <a class="dropdown-item" href="#"><i class="fa fa-bug" aria-hidden="true"></i> <span> </span> Report a problem</a>
            <a class="dropdown-item" href="<?php echo base_url(); ?>settings"><i class="fa fa-cog" aria-hidden="true"></i> <span> </span> Setting</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-center" href="<?php echo base_url(); ?>users/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Signout</a>
        </div>
      </li>
    </ul>
 </nav>


<script>

function getDropdownData() {

    if($(".dropdown_data_window").css("height") == "0px") {

      $.ajax({
        url: "<?php echo base_url('posts/getAllNofications') ?>",
        type: "POST",
        data: {"page":1},
        //dataType: 'JSON',
        success: function(response) {
          $(".dropdown_data_window").html(response);
          $(".dropdown_data_window").css({"padding" : "0px", "height": "280px", "border" : "1px solid #DADADA"});
          //$("#dropdown_data_type").val(type);
          $("span").remove("#unread_notification");
        },
        error: function(){
          alert("Sorry something went wrong");
        }

      });

    }
    else {
      $(".dropdown_data_window").html("");
      $(".dropdown_data_window").css({"padding" : "0px", "height": "0px", "border" : "none"});
    }

  }


  var userLoggedIn = '<?php echo $this->session->userdata('user_id'); ?>';

  $(document).ready(function() {

    $('.dropdown_data_window').scroll(function() {
      var inner_height = $('.dropdown_data_window').innerHeight(); //Div containing data
      var scroll_top = $('.dropdown_data_window').scrollTop();
      var page = $('.dropdown_data_window').find('.nextPageDropdownData').val();
      var noMoreData = $('.dropdown_data_window').find('.noMoreDropdownData').val();

      if ((scroll_top + inner_height >= $('.dropdown_data_window')[0].scrollHeight) && noMoreData == 'false') {

        var type = $('#dropdown_data_type').val();
        $.ajax({
          url: "<?php echo base_url('posts/getAllNofications') ?>",
          type: "POST",
          data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
          cache:false,
          //dataType: 'JSON',
          success: function(response) {
            $('.dropdown_data_window').find('.nextPageDropdownData').remove(); //Removes current .nextpage 
            $('.dropdown_data_window').find('.noMoreDropdownData').remove(); //Removes current .nextpage 


            $('.dropdown_data_window').append(response);
          }
        });
        //event.preventDefault();

      } //End if 

      return false;

    }); //End (window).scroll(function())


  });

    if (jQuery('input#autocomplete').length > 0) {
      jQuery('input#autocomplete').typeahead({
        source: function (query, process) {
          jQuery.ajax({
              url: "<?php echo base_url('users/search'); ?>",
              data: {query:query},
              dataType: "json",
              type: "POST",
              success: function (data) {
                console.log(data);
                  process(data)
              }
          })
        }   
      });
    }

  </script>