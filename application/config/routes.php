<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$route['default_controller'] = 'Main/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['sitemap\.xml'] = "Seo/sitemap";
$route['robots\.txt'] = "Seo/robots";

//suraha

$route['sendemail'] = 'Main/onSetContUs';
$route['saveapponit'] = 'Main/onSetAppoint';

