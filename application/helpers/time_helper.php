<?php

date_default_timezone_set('UTC');

function get_time_ago($time){

    $time_difference = time() - strtotime($time);

    if( $time_difference < 1 ) { return 'just now'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return '' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}

function friend_for_period($time){

    $time_difference = time() - strtotime($time);

    if( $time_difference < 1 ) { return ' a second'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return '' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . '';
        }
    }
}

function likesOrLike($dataMod){
    $like_count = $dataMod;
    if ($like_count == 0) {
      return '' . $like_count . ' ' . 'Likes';
    }else if($like_count == 1){
      return '' . $like_count . ' ' . 'Like';
    }else {
      return '' . $like_count . ' ' . 'Likes';
    }
  }

  function requestOrrequests($dataMod){
    $request_count = $dataMod;
    if ($request_count == 1) {
      return ' ' . 'a friend request';
    }else {
      return '' .$request_count. ' ' . 'friend requests';
    }
  }

  function joined($friendmii_unix){
    $datetimeLast = date("Y-m-d",strtotime($friendmii_unix));
    return $datetimeLast;
  }

  function lastSeen($friendmii_unix){
    $datetimeLast = date("Y-m-d",strtotime($friendmii_unix));
    return $datetimeLast;
  }

  function getPostLink($post_link){
    $post_link = preg_replace(array('/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?������]))/',
    '/(^|[^a-z0-9_])@([a-z0-9_]+)/i', '/(^|[^a-z0-9_])#([a-z0-9_]+)/i'), array('<a href="$1" target="_blank">$1</a>', '$1<a href="profile?u=$2">@$2</a>', '<b>$1</b><a href="hashtag?tag=$2">#$2</a>'), $post_link);
    return $post_link;
  }

// function fix_url($url) {
//   if (substr($url, 0, 7) == 'http://') { return $url; }
//   if (substr($url, 0, 8) == 'https://') { return $url; }
//   return 'http://'. $url;
// }

  function format_num($num, $precision = 2) {
     if ($num >= 1000 && $num < 1000000) {
        $n_format = number_format($num/1000, $precision).'K';
     } else if ($num >= 1000000 && $num < 1000000000) {
        $n_format = number_format($num/1000000, $precision).'M';
     } else if ($num >= 1000000000) {
        $n_format = number_format($num/1000000000, $precision).'B';
     } else {
        $n_format = $num;
     }
        return $n_format;
   }

   function add3dots($string, $repl, $limit){
    if(strlen($string) > $limit){
      return substr($string, 0, $limit) . $repl;
    }else{
      return $string;
    }
  }

function notification_counter($dataMod){
    $notification_count = $dataMod;
    if ($notification_count > 9) {
        return 9 . '+';
    }else{
      return $notification_count;
    }
  }

  function mutual_counter($dataMod){
    $mutual_count = $dataMod;
    if ($mutual_count > 1) {
        return $mutual_count . ' Mutual friends';
    }else{
      return $mutual_count . ' Mutual friend';
    }
  }


 ?>
