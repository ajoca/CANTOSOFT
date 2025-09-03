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

$route['default_controller'] = 'authentication/frontend';
$route['waiter-login'] = 'Login/waiter_login';
$route['waiter-login'] = 'login/waiter_login';
$route['access-denied'] = 'login/accessDenied';
$route['access-denied'] = 'Login/accessDenied';
$route['send-subscribe_email'] = 'authentication/subscribeEmail';
$route['waiter-login-check'] = 'Login/waiter_login_check';
$route['waiter-login-check'] = 'login/waiter_login_check';
$route['customer-panel'] = 'Authentication/customer_panel';
$route['customer-panel'] = 'authentication/customer_panel';
$route['order-status-screen'] = 'Authentication/order_display_screen';
$route['order-status-screen'] = 'authentication/order_display_screen';
$route['online_order_logout'] = 'authentication/logout_online_order';
$route['online_order_logout'] = 'Authentication/logout_online_order'; 
$route['back-to-main-page'] = 'Authentication/backtomainpage'; 
$route['order-status-screen-data'] = 'Authentication/order_display_screen_data';
$route['order-status-screen-data'] = 'authentication/order_display_screen_data';
$route['get_prom_details'] = 'authentication/get_prom_details';
$route['customer-panel-data'] = 'Authentication/customer_panel_data';
$route['customer-panel-data'] = 'authentication/customer_panel_data';;
$route['put-customer-panel-data'] = 'Authentication/put_customer_panel_data';
$route['put-customer-panel-data'] = 'authentication/put_customer_panel_data';
$route['payment-form'] = 'PaymentController/payment';
$route['payment-form-saas'] = 'PaymentController/payment_saas';
$route['payOnline/(:any)'] = 'PaymentController/payOnline/$1';
$route['stripePayment'] = 'PaymentController/stripePayment';
$route['stripePaymentSaas'] = 'PaymentController/stripePaymentSaas';
$route['paymentStatus'] = 'PaymentController/paymentStatus';
$route['ipn_paypal'] = 'PaymentController/ipn_paypal';
$route['plan/(:any)/(:any)'] = 'authentication/plan/$1/$2';
$route['plan/(:any)/(:any)'] = 'Authentication/plan/$1/$2';
$route['plan'] = 'Authentication/plan';
$route['plan'] = 'authentication/plan';
$route['singup'] = 'Authentication/singup';
$route['singup'] = 'authentication/singup';
$route['send-email'] = 'authentication/sendEmail';
$route['contact-us'] = 'authentication/contactUs';
$route['invoice/(:any)'] = 'Authentication/qr_code_invoice/$1';
$route['invoice/(:any)'] = 'authentication/qr_code_invoice/$1';
$route['hst'] = 'authentication/hst';
$route['forgot-password-step-one'] = 'authentication/forgotPasswordStepOne';
$route['forgot-password-step-two'] = 'authentication/forgotPasswordStepTwo';
$route['forgot-password-step-final'] = 'authentication/forgotPasswordStepDone';
$route['self-order/(:any)/(:any)/(:any)/(:any)'] = 'POSChecker/posAndSelfOrderMiddleman/$1/$2/$3/$4';
$route['online-order/(:any)/(:any)'] = 'POSChecker/posAndOnlineOrderMiddleman/$1/$2';
$route['404_override'] = '';
$route['payment-now/(:any)'] = 'Authentication/payment/$1';
$route['active/(:any)'] = 'Frontend/active/$1';
$route['login'] = 'frontend/login';
$route['register'] = 'frontend/register';
$route['forgot-password'] = 'frontend/forgotPassword';
$route['order-success/(:any)'] = 'frontend/orderSuccess/$1';
$route['checkout'] = 'Frontend/checkoutPage';
$route['about-us'] = 'Frontend/aboutUs';
$route['old-orders'] = 'Frontend/oldOrders';
$route['order-details/(:any)'] = 'Frontend/orderDetails/$1';
$route['contact-us'] = 'Frontend/contactUs';
$route['reservation'] = 'Frontend/reservations';
$route['payment-success'] = 'PaymentController/paymentSuccess';
$route['payment-fail'] = 'PaymentController/paymentError';
$route['online-order'] = 'Frontend/menuPage'; 
$route['set-nearest-outlet'] = 'Frontend/setNearestOutlet'; 
$route['food-details/(:any)/(:any)'] = 'Frontend/menuItemDetails/$1/$2';
$route['rating-submit'] = 'Frontend/ratingSubmit';
$route['translate_uri_dashes'] = FALSE;


