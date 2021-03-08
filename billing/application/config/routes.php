<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$route['default_controller'] = 'Auth/index';
$route['404_override'] = 'Auth/get404';
$route['translate_uri_dashes'] = FALSE;


//login
$route['login'] = 'Auth/onSetLogin';
$route['chk_login'] = 'Auth/onCheckLogin';
$route['logout'] = 'Auth/onSetLogout';
$route['dashboard'] = 'Auth/onGetDashboard';

//user management
$route['users'] = 'Users/index';
$route['duplicate_check_un'] = 'Users/onCheckDuplicateUser';
$route['adduser'] = 'Users/onCreateUserView';
$route['createuser'] = 'Users/onCreateUser';
$route['profile'] = 'Users/onGetUserProfile/';
$route['profile/(:num)'] = 'Users/onGetUserProfile/$1';
$route['changeprofile'] = 'Users/onChangeUserProfile';
$route['deluser'] = 'Users/onDeleteUser';


//billing - invoices
$route['billings'] = 'Billing/index';
$route['invoices'] = 'Billing/onGetInvoiceView';
$route['newinvoice'] = 'Billing/onCreateInvoiceView';
$route['createinvoice'] = 'Billing/onCreateInvoice';
$route['get_dropdowns'] = 'Billing/onGetInvoiceDrops';
$route['save_invoice'] = 'Billing/onSetInvoice';
$route['print_invoice/(:any)'] = 'Billing/onPrintInvoice/$1';
$route['invoicereport'] = 'Billing/onReportInvoice';
$route['deleteinv'] = 'Billing/onDeleteInvoice';

//billing - Money Receipts
$route['moneyreceipts'] = 'MoneyReceipt/onGetMReceiptView';
$route['newmoneyreceipt'] = 'MoneyReceipt/onCreateMReceiptView';
$route['createmoneyreceipt'] = 'MoneyReceipt/onCreateMReceipt';
$route['editmoneyreceipt/(:num)'] = 'MoneyReceipt/onCreateMReceipt/$1';
$route['deletemreceipt'] = 'MoneyReceipt/onDeleteMR';
$route['print_receipt/(:any)'] = 'MoneyReceipt/onPrintReceipt/$1';
$route['mrreport'] = 'MoneyReceipt/onReportMR';


//groups
$route['groups'] = 'Groups/index';
$route['addgroup'] = 'Groups/onCreateGroupView';
$route['duplicate_check_group'] = 'Groups/onCheckDuplicateGroup';
$route['creategroup'] = 'Groups/onCreateGroup';
$route['editgroup/(:num)'] = 'Groups/onCreateGroupView/$1';
$route['deletegroup'] = 'Groups/onDeleteGroup';


//items
$route['items'] = 'Items/index';
$route['additem'] = 'Items/onCreateItemView';
$route['duplicate_check_item'] = 'Items/onCheckDuplicateItem';
$route['createitem'] = 'Items/onCreateItem';
$route['edititem/(:num)'] = 'Items/onCreateItemView/$1';
$route['deleteitem'] = 'Items/onDeleteItem';

//doctors
$route['doctors'] = 'Doctor/index';
$route['adddoctor'] = 'Doctor/onCreateDoctorView';
$route['duplicate_check_doc'] = 'Doctor/onCheckDuplicateDoctor';
$route['createdoctor'] = 'Doctor/onCreateDoctor';
$route['editdoctor/(:num)'] = 'Doctor/onCreateDoctorView/$1';
$route['deletedoctor'] = 'Doctor/onDeleteDoctor';