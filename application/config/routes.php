
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
$route['default_controller'] = 'C_login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = "C_login/index";
$route['home'] = "C_dashboard/index";
$route['barang'] = "C_barang/index";
$route['barang/masuk'] = "C_barang/barang_masuk";
$route['barang/trmasuk'] = "C_barang/tr_barang_masuk";
$route['barang/penjualan'] = "C_barang/barang_penjualan";
$route['barang/trpenjualan'] = "C_barang/tr_barang_penjualan";
$route['customer'] = "C_customer/index";
$route['profil'] = "C_customer/profil";
$route['supplier'] = "C_supplier/index";
$route['user'] = "C_user/index";

$route['lap/customer'] = "C_laporan/lap_customer";
$route['lap/barang'] = "C_laporan/lap_barang";
$route['lap/trmasuk'] = "C_laporan/lap_tr_barang_masuk";
$route['lap/trkeluar'] = "C_laporan/lap_tr_barang_keluar";
$route['lap/fma'] = "C_laporan/forecasting_moving_average";
$route['lap/forecasting-moving-average/hitung']['POST'] = "C_laporan/hitung_fma";
