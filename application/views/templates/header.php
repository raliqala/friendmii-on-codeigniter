<!DOCTYPE html>
<html>
<head>
	<title>friendmiiDemo</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/post.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/profile.css">
  <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/popper.min.js"></script> -->
  <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
  <script src="https://twemoji.maxcdn.com/1/twemoji.min.js"></script>
  <script src="https://twemoji.maxcdn.com/twemoji.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
  <link href="<?php echo base_url(); ?>assets/css/emoji.css" rel="stylesheet">

  <?php
    date_default_timezone_set('UTC');
		ini_set('max_execution_time', 300); //300 seconds = 5 minutes
		set_time_limit(300);
   ?>

  <script type="text/javascript">
   window.onbeforeunload = function(){
      var st = "0";
      $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>users/onlineOfline/",
          data: {'st':st}
      });
   }
 </script>
</head>
<body class="fixed-sn black-skin">
  
 <?php
   if(!empty($this->session->userdata('user_id'))){
          require APPPATH.'/views/templates/navbar.php';
      if (!empty($this->session->userdata('user_id')) && $this->session->userdata('logged_in') == true) {
        $online_status = 1;
        onlineOrOffline($online_status, $this->session->userdata('user_id'));
      }else {
        $online_status = 0;
        onlineOrOffline($online_status, $this->session->userdata('user_id'));
      }
  }else{
    print '<nav style="margin-top:-3.77em;" class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="d-flex flex-grow-1">
                <span class="w-100 d-lg-none d-block"></span>
                <a class="navbar-brand" href="http://localhost/friendmiiDemo/">
                    FriendMii
                </a>
                <div class="w-100 text-right">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar7">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
              <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-question-circle" aria-hidden="true"></i>
Help</a>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse flex-grow-1 text-right" id="myNavbar7">
                <ul class="navbar-nav ml-auto flex-nowrap">
                    <li class="nav-item">
                        <a style="border:1.7px solid #007bff;" href="http://localhost/friendmiiDemo/users/signup" class="nav-link btn btn-outline-primary mr-2 text-dark"><i class="fa fa-user" aria-hidden="true"></i>
Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a style="border:1.9px solid #007bff;" href="http://localhost/friendmiiDemo/users/login" class="nav-link btn btn-outline-primary text-dark"><i class="fa fa-sign-in" aria-hidden="true"></i>
 Login</a>
                    </li>
                </ul>
            </div>
        </nav>';
  }
?>

<div class="container">