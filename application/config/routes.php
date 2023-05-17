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

$route['default_controller'] = 'home'; 
$route['login'] = 'front/account/login'; 
$route['manage'] = 'admin/account/login';
$route['admin/kunjungan'] = 'admin/pendaftaran/laporan';
$route['admin/pemeriksaan/kasir/edit/(:any)'] = 'admin/pemeriksaan/kasir_edit/$1';
$route['admin/pemeriksaan/kasir'] = 'admin/pemeriksaan/kasir_index';
$route['admin/pemeriksaan/apotek/add'] = 'admin/pemeriksaan/apotek_add';
$route['admin/pemeriksaan/apotek/edit/(:any)'] = 'admin/pemeriksaan/apotek_edit/$1';
$route['admin/pemeriksaan/apotek'] = 'admin/pemeriksaan/apotek_index';
$route['admin/pemeriksaan/lab/edit/(:any)'] = 'admin/pemeriksaan/lab_edit/$1';
$route['admin/pemeriksaan/lab'] = 'admin/pemeriksaan/lab_index';
$route['admin/pasien/klinik/index'] = 'admin/pasien/klinik';
$route['admin/pasien/klinik/edit/(:any)'] = 'admin/pasien/klinik_edit/$1';
$route['admin/pasien/apotek/index'] = 'admin/pasien/apotek';
$route['admin/pasien/apotek/edit/(:any)'] = 'admin/pasien/apotek_edit/$1';
$route['admin/pasien/apotek/add'] = 'admin/pasien/apotek_add';
$route['cron'] = 'admin/log/execute';
$route['404_override'] = 'error';
$route['translate_uri_dashes'] = FALSE;
