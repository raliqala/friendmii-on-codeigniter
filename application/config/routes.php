<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['users/requests'] = 'users/requests';
$route['posts/post'] = 'posts/post';
$route['posts/update'] = 'posts/update';
$route['posts/suggestedUsers'] = 'posts/suggestedUsers';
$route['posts/getAllNofications'] = 'posts/getAllNofications';
$route['posts/getAllReq'] = 'posts/getAllReq';
$route['posts/addReplylike'] = 'posts/addReplylike';
$route['posts/removeReplyLike'] = 'posts/removeReplyLike';
$route['posts/addlike'] = 'posts/addlike';
$route['posts/removeLike'] = 'posts/removeLike';
$route['posts'] = 'posts/index';

$route['admin/print_pdf'] = 'admin/print_pdf';
$route['admin'] = 'admin/overview';



$route['profile/requests'] = 'profile/requests';
$route['profile/upload'] = 'profile/upload';
$route['profile/uploadProfile'] = 'profile/uploadProfile';
$route['profile/edit'] = 'profile/edit';
$route['profile/update_bio'] = 'profile/update_bio';
$route['profile/favourite'] = 'profile/favourite';
$route['profile'] = 'profile/index';
$route['profile/index'] = 'profile/index';
$route['default_controller'] = 'pages/view';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['(:any)'] = 'admin/view/$1';
$route['(:any)'] = 'pages/view/$1';
$route['profile/(:any)'] = 'profile/view/$1';
$route['posts/(:any)'] = 'posts/view/$1';


