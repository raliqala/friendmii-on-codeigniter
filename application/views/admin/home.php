
 <section id="main" class="mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="list-group">
          <a href="<?php echo base_url(); ?>admin/overview" class="list-group-item active main-color-bg">
          <span class="#" aria-hidden="true"></span> Dashboard
          </a>
          <a href="<?php echo site_url('/admin/online'); ?>" class="list-group-item"><span class="fa fa-user-circle " aria-hidden="true"></span>  Online Users <span class="badge badge-primary pull-right" style="font-size: 14px;"><?php echo $online_users ?></span></a>
          <a href="<?php echo site_url('/admin/users'); ?>" class="list-group-item"><span class="fa fa-user" aria-hidden="true"></span>  All Users <span class="badge badge-primary pull-right" style="font-size: 14px;"><?php echo $all_users ?></span></a>
           <a href="<?php echo site_url('/admin/blocked') ?>" class="list-group-item"><span class="fa fa-ban " aria-hidden="true"></span> Blocked Accounts <span class="badge badge-primary pull-right" style="font-size: 14px;"><?php echo $blocked_accounts ?></span></a>
          <a href="<?php echo site_url('/admin/users_today'); ?>" class="list-group-item"><span class="fa fa-user-circle-o " aria-hidden="true"></span>  Users last seen today <span class="badge badge-primary pull-right" style="font-size: 14px;"><?php echo $last_seen_today; ?></span></a>
          <a href="<?php echo site_url('/admin/deleted') ?>" class="list-group-item"><span class="fa fa-trash-o" aria-hidden="true"></span>  Deleted Accounts <span class="badge badge-primary pull-right" style="font-size: 14px;"><?php echo $deleted_accounts; ?></span></a>
         
          <a href="<?php echo site_url('/admin/new_registrations') ?>" class="list-group-item"><span class="fa fa-registered" aria-hidden="true"></span>  New Registrations <span class="badge badge-primary pull-right" style="font-size: 14px;"><?php echo $new_registrations ?></span></span></a>

          <a href="<?php echo site_url('/admin/charts') ?>" class="list-group-item"><span class="fa fa-bar-chart" aria-hidden="true"></span>   Charts <span class="badge badge-primary pull-right" style="font-size: 14px;"></span></a>
          </div>
      
      </div>
      
