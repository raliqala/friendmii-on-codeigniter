<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title></title>
        <!-- Load Google chart api -->
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    </head>
    <body>  
    <div class="col-md-9">
        <div class="panel panel-default">
            <canvas id="myChart"></canvas>
            <input type="hidden" id="all_users" value="<?php echo $all_users; ?>">
            <input type="hidden" id="online_users" value="<?php echo $online_users; ?>">
            <input type="hidden" id="posts_today" value="<?php echo $posts_today; ?>">
            <input type="hidden" id="deleted_accounts" value="<?php echo $deleted_accounts; ?>">
            <input type="hidden" id="blocked_accounts" value="<?php echo $blocked_accounts; ?>">
            <input type="hidden" id="last_seen_today" value="<?php echo $last_seen_today; ?>">
            <input type="hidden" id="new_registrations" value="<?php echo $new_registrations; ?>">
        </div>
    </div>

    </body>
</html>