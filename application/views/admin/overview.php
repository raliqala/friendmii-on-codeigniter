  
  <div class="col-md-9">
              <!-- Website Overview -->
    
      <div class="card">
          <div class="card-body">
            Website Overview Date: <?php echo Date('Y-m-d'); ?><a href="<?php echo base_url(); ?>admin/print_pdf" class="pull-right">Print PDF</a>
          </div>
        </div>
        <div class="panel-body mt-3" style="display: flex; margin-left: -1em;">
          <div class="col-lg-4">
            <div class="card card-body bg-ligh text-center">
               <h2><span class="fa fa-users fa-lg"  aria-hidden="true"></span></h2>
              <h4><?php echo $all_users ?> Users</h4>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-body bg-ligh text-center">
              <h2><span class="fa fa-user-o fa-lg" aria-hidden="true"></span> </h2>
              <h4><?php echo $online_users ?> Online Users</h4>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-body bg-ligh text-center">
              <h2><span class="fa fa-ban fa-lg" aria-hidden="true"></span></h2>
              <h4><?php echo $blocked_accounts ?> Blocked</h4>
            </div>
          </div>
        </div>
         <div class="panel-body" style="display: flex;margin-left: -1em;margin-top: .5em;margin-bottom: .5em;">
          <div class="col-lg-4">
            <div class="card card-body bg-ligh text-center" style="height: 9.2em;">
              <h2><span class="fa fa-flag-o fa-lg" aria-hidden="true"></span></h2>
              <h4># Reported Posts</h4>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-body bg-ligh text-center">
              <h2><span class="fa fa-commenting fa-lg" aria-hidden="true"></span></h2>
              <h4># Reported Comments</h4>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-body bg-ligh text-center">
              <h2><span class="fa fa-trash-o fa-lg" aria-hidden="true"></span></h2>
              <h4><?php echo $deleted_accounts ?> Deleted Accounts</h4>
            </div>
          </div>
        </div>
        <div class="panel-body mt-3" style="display: flex; margin-left: -1em;">
          <div class="col-lg-4">
            <div class="card card-body bg-ligh text-center" style="height: 8em;">
              <h2><span class="fa fa-registered fa-lg" aria-hidden="true"></span></h2>
              <h4><?php echo $new_registrations; ?> Registered Today</h4>
            </div>
          </div>
           <div class="col-lg-4">
            <div class="card card-body bg-ligh text-center" style="height: 8em;">
              <h2><span class="fa fa-arrow-circle-down fa-lg" aria-hidden="true"></span></h2>
              <h4><?php echo $posts_today; ?> Posts Today</h4>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-body bg-ligh text-center" style="height: 8em;">
              <h2><span class="fa fa-arrow-circle-down fa-lg" aria-hidden="true"></span></h2>
              <h4><?php echo $last_seen_today; ?> Last seen today</h4>
            </div>
          </div>
        </div>
      </div>
