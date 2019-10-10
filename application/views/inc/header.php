
<!DOCTYPE html>
<html>
<head>
	<title>App Test</title>
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" rel="stylesheet">
      
    <link href="<?php echo base_url(); ?>assets/css/Admin.css" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <!-- Datatable CSS -->
  <link href='<?php echo base_url(); ?>assets/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script  src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

  <!-- Datatable JS -->
    <script src="<?php echo base_url(); ?>assets/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/DataTables/DataTables-1.10.18/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/DataTables/datatables.js"></script> 

  
  
    <?php date_default_timezone_set('UTC'); ?>
   
</head>
<body>

 <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">FriendMii</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>pages/overview">Home</a></li>
            <li><a href="<?php echo site_url('/pages/users'); ?>">Users</a></li>
            <li><a href="#">Charts</a></li>
            <li><a href="<?php echo base_url(); ?>pages/help">Help</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="#">Welcome(user)</a></li>
            <li><a href="#">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


   

  