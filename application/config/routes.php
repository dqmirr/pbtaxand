<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$admin_controller = 'admin442e17d83025ac7201c9b487db03fe226f67808ad2912247d72fac704c624d7b';
$admin_url = 'adminpage';

$route['default_controller'] = 'page';
$route[$admin_url] = $admin_controller;

// tambahan routing
$admquiz = 'admin/Admin_quiz';
$route[$admin_controller.'/quiz'] = $admquiz;
$route[$admin_controller.'/quiz/(.*)'] = $admquiz.'/$1';

$ajxquiz = 'ajax/Ajax_quiz';
$route[$admin_controller.'/ajax_quiz'] = $ajxquiz;
$route[$admin_controller.'/ajax_quiz/(.*)'] = $ajxquiz.'/$1';

$admsesi = 'admin/Admin_sesi';
$route[$admin_controller.'/sesi'] = $admsesi;
$route[$admin_controller.'/sesi/(.*)'] = $admsesi.'/$1';

$ajxsesi = 'ajax/Ajax_sesi';
$route[$admin_controller.'/ajax_sesi'] = $ajxsesi;
$route[$admin_controller.'/ajax_sesi/(.*)'] = $ajxsesi.'/$1';

$admdash = 'admin/Admin_dashboard';
$route[$admin_controller] = $admdash;

$ajxdash = 'ajax/Ajax_dashboard';
$route[$admin_controller.'/ajax_dashboard'] = $ajxdash;
$route[$admin_controller.'/ajax_dashboard/(.*)'] = $ajxdash.'/$1';

// $admuser = 'admin/Admin_users';
// $route[$admin_controller.'/users'] = $admuser;
// $route[$admin_controller.'/users/(.*)'] = $admuser.'/$1';
$psycogram = 'admin/Admin_psycogram';
$route[$admin_controller.'/psycogram'] = $psycogram;
$route[$admin_controller.'/psycogram/(.*)'] = $psycogram.'/$1';

$ajxpsyco = 'ajax/Ajax_psycogram';
$route[$admin_controller.'/ajax_psycogram'] = $ajxpsyco;
$route[$admin_controller.'/ajax_psycogram/(.*)'] = $ajxpsyco.'/$1';

$princepsy = 'admin/Prince_psycogram';
$route[$admin_controller.'/pdf_psycogram'] = $princepsy;


$pchart = 'admin/Pchart';
$route[$admin_controller.'/pchart'] = $pchart;

 $admformasi = 'admin/Admin_formasi';
 $route[$admin_controller.'/formasi'] = $admformasi;
 $route[$admin_controller.'/formasi/(.*)'] = $admformasi.'/$1';

 $ajxformasi = 'ajax/Ajax_formasi';
 $route[$admin_controller.'/ajax_formasi'] = $ajxformasi;
 $route[$admin_controller.'/ajax_formasi/(.*)'] = $ajxformasi.'/$1';
// sampai sini

$admgnr = 'admin/Admin_generate';
$route[$admin_controller.'/soal/generate_exam'] = $admgnr;
$route[$admin_controller.'/soal/generate_exam/detail/(:any)'] = $admgnr.'/detail/$1';
$route[$admin_controller.'/soal/generate_exam/(:any)'] = $admgnr.'/$1';

$route[$admin_controller.'/choice/(\d+)'] = 'admin/admin_choice/index/$1';
$route[$admin_controller.'/choice/(\d+)/(:any)'] = 'admin/admin_choice/index/$1';
$route[$admin_controller.'/choice/(\d+)/index/(:any)/(\d+)'] = function($multiplechoice_id, $method, $choice_id)
{
	return 'admin/admin_choice/index/'.$multiplechoice_id.'/'.$method.'/'.$choice_id;
};
$route[$admin_controller.'/choice/(\d+)/index/(:any)'] = function($multiplechoice_id, $method)
{
	return 'admin/admin_choice/index/'.$multiplechoice_id.'/'.$method;
};

$mulstr = 'admin/admin_story';
$route[$admin_controller.'/story'] = $mulstr."/story";
$route[$admin_controller.'/story/(:any)'] = $mulstr."/index/$1";
$route[$admin_controller.'/story/(:any)/index/(:any)/(:any)'] = function($library, $method, $code)
{
	return 'admin/admin_story/index/'.$library.'/'.$method.'/'.$code;
};
$route[$admin_controller.'/story/(:any)/index/(:any)'] = function($library, $method)
{
	return 'admin/admin_story/index/'.$library.'/'.$method;
};

$admgti = 'admin/admin_gti';
$route[$admin_controller.'/report_gti'] = $admgti;

$route[$admin_controller.'/report_gti/(:any)'] = function($method) {
	return 'admin/admin_gti/'.$method;
};

$route[$admin_controller.'/report_gti/(:any)/(:any)'] = function($method, $arg1) {
	return 'admin/admin_gti/'.$method.'/'.$arg1;
};

$route[$admin_controller.'/report_gti/(:any)/(:any)/(:any)'] = function($method, $arg1, $arg2) {
	return 'admin/admin_gti/'.$method.'/'.$arg1.'/'.$arg2;
};

$route['loginulang'] = 'LoginUlang';

$route[$admin_url.'/(.*)'] = $admin_controller.'/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
