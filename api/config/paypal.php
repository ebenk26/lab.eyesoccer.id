<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$this->ci = & get_instance();

/* Paypal Setting */
$set = $this->ci->catalog->get_payment(array('payment_type' => 'paypal', 'row' => true));
$detail = json_decode(str_replace("~", '"', $set->payment_detail));

//print_r($detail);exit;

/** 
 * Sandbox / Test Mode
 * -------------------------
 * TRUE means you'll be hitting PayPal's sandbox/test servers.  FALSE means you'll be hitting the live servers.
 */
$config['Sandbox'] = TRUE;
$config['PaypalMode'] = 'sandbox';

/* 
 * PayPal API Version
 * ------------------
 * The library is currently using PayPal API version 98.0.  
 * You may adjust this value here and then pass it into the PayPal object when you create it within your scripts to override if necessary.
 */
$config['APIVersion'] = '98.0';

/*
 * PayPal Gateway API Credentials
 * ------------------------------
 * These are your PayPal API credentials for working with the PayPal gateway directly.
 * These are used any time you're using the parent PayPal class within the library.
 * 
 * We're using shorthand if/else statements here to set both Sandbox and Production values.
 * Your sandbox values go on the left and your live values go on the right.
 * 
 * You may obtain these credentials by logging into the following with your PayPal account: https://www.paypal.com/us/cgi-bin/webscr?cmd=_login-api-run
 */
$config['APIUsername'] = $config['Sandbox'] ? 'kharizuno-facilitator_api1.yahoo.com' : $detail->paypal_username;
$config['APIPassword'] = $config['Sandbox'] ? '1369899529' : $detail->paypal_password;
$config['APISignature'] = $config['Sandbox'] ? 'AmwFWrLhkdk-vl6V4G2HjdxahvX3AHMpv2FTFCjUniwILuzSZpBvlwMx' : $detail->paypal_signature;

/*
 * Payflow Gateway API Credentials
 * ------------------------------
 * These are the credentials you use for your PayPal Manager:  http://manager.paypal.com
 * These are used when you're working with the PayFlow child class.
 * 
 * We're using shorthand if/else statements here to set both Sandbox and Production values.
 * Your sandbox values go on the left and your live values go on the right.
 * 
 * You may use the same credentials you use to login to your PayPal Manager, 
 * or you may create API specific credentials from within your PayPal Manager account.
 */
$config['PayFlowUsername'] = $config['Sandbox'] ? 'SANDBOX_USERNAME_GOES_HERE' : 'PRODUCTION_USERNAME_GOGES_HERE';
$config['PayFlowPassword'] = $config['Sandbox'] ? 'SANDBOX_PASSWORD_GOES_HERE' : 'PRODUCTION_PASSWORD_GOES_HERE';
$config['PayFlowVendor'] = $config['Sandbox'] ? 'SANDBOX_VENDOR_GOES_HERE' : 'PRODUCTION_VENDOR_GOES_HERE';
$config['PayFlowPartner'] = $config['Sandbox'] ? 'SANDBOX_PARTNER_GOES_HERE' : 'PRODUCTION_PARTNER_GOES_HERE';

/*
 * PayPal Application ID
 * --------------------------------------
 * The application is only required with Adaptive Payments applications.
 * You obtain your application ID but submitting it for approval within your 
 * developer account at http://developer.paypal.com
 *
 * We're using shorthand if/else statements here to set both Sandbox and Production values.
 * Your sandbox values go on the left and your live values go on the right.
 * The sandbox value included here is a global value provided for developrs to use in the PayPal sandbox.
 */
$config['ApplicationID'] = $config['Sandbox'] ? 'APP-80W284485P519543T' : 'PRODUCTION_APP_ID_GOES_HERE';

/*
 * PayPal Developer Account Email Address
 * This is the email address that you use to sign in to http://developer.paypal.com
 */
$config['DeveloperEmailAccount'] = 'kharizuno@yahoo.com';

/**
 * Third Party User Values
 * These can be setup here or within each caller directly when setting up the PayPal object.
 */
$config['DeviceID'] = 'DEVICE_ID_GOES_HERE';
$config['Currency'] = $detail->paypal_convert;
$config['Email'] = $detail->paypal_email;
/* End of file paypal.php */
/* Location: ./system/application/config/paypal.php */