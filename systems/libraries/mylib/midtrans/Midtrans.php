<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Midtrans
{
    /**
     * Your merchant's server key
     * @static
     */
    public static $clientKey = 'VT-client-oYvBrIVPhYmLJevH';
    public static $serverKey = 'VT-server-4ElKCW9qaUrtECuPqBbKFW-W';

    /**
     * true for production
     * false for sandbox mode
     * @static
     */
    public static $isProduction = false;

    /**
     * Default options for every request
     * @static
     */
    public static $curlOptions = array();
    
    const SNAP_SANDBOX_BASE_URL = 'https://app.sandbox.midtrans.com/snap/v1';
    const SNAP_PRODUCTION_BASE_URL = 'https://app.midtrans.com/snap/v1';
    const CORE_SANDBOX_BASE_URL = 'https://api.sandbox.midtrans.com/v2';
    const CORE_PRODUCTION_BASE_URL = 'https://api.midtrans.com/v2';
    
    public function config($params = array())
    {
	Midtrans::$clientKey = $params['production'] ? $params['client_key'] : Midtrans::$clientKey;
	Midtrans::$serverKey = $params['production'] ? $params['server_key'] : Midtrans::$serverKey;
	Midtrans::$isProduction = $params['production'] ? $params['production'] : Midtrans::$isProduction;
    }

    /**
     * @return string Veritrans API URL, depends on $isProduction
     */
    public static function getUrlSnap()
    {
	return Midtrans::$isProduction ? Midtrans::SNAP_PRODUCTION_BASE_URL : Midtrans::SNAP_SANDBOX_BASE_URL;
    }

    public static function getUrlCore()
    {
	return Midtrans::$isProduction ? Midtrans::CORE_PRODUCTION_BASE_URL : Midtrans::CORE_SANDBOX_BASE_URL;
    }

    /**
     * Send GET request
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     */
    public static function get($url, $server_key, $data_hash, $ke_api = false)
    {
	return self::remoteCall($url, $server_key, $data_hash, false, $ke_api);
    }

    /**
     * Send POST request
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     */
    public static function post($url, $server_key, $data_hash, $ke_api = false)
    {
	return self::remoteCall($url, $server_key, $data_hash, true, $ke_api);
    }

    /**
     * Actually send request to API server
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     * @param bool    $post
     */
    public static function remoteCall($url, $server_key, $data_hash, $post = true, $ke_api = false)
    {
	$ch = curl_init();
	$curl_options = array(
	    CURLOPT_URL => $url,
	    CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json',
		'Accept: application/json',
		'Authorization: Basic ' . base64_encode($server_key . ':')
	    ) ,
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_CAINFO => dirname(__FILE__) . "/veritrans/cacert.pem"
	);

	// merging with Veritrans_Config::$curlOptions

	if (count(Midtrans::$curlOptions))
	{

	    // We need to combine headers manually, because it's array and it will no be merged

	    if (Midtrans::$curlOptions[CURLOPT_HTTPHEADER])
	    {
		$mergedHeders = array_merge($curl_options[CURLOPT_HTTPHEADER], Midtrans::$curlOptions[CURLOPT_HTTPHEADER]);
		$headerOptions = array(
		    CURLOPT_HTTPHEADER => $mergedHeders
		);
	    } else {
		$mergedHeders = array();
	    }

	    $curl_options = array_replace_recursive($curl_options, Midtrans::$curlOptions, $headerOptions);
	}

	if ($post)
	{
	    $curl_options[CURLOPT_POST] = 1;
	    if ($data_hash)
	    {
		$body = json_encode($data_hash);
		$curl_options[CURLOPT_POSTFIELDS] = $body;
	    } else {
		$curl_options[CURLOPT_POSTFIELDS] = '';
	    }
	}

	curl_setopt_array($ch, $curl_options);
	$result = curl_exec($ch);
	$info = curl_getinfo($ch);

	// curl_close($ch);

	if ($result === FALSE)
	{
	    throw new Exception('CURL Error: ' . curl_error($ch) , curl_errno($ch));
	} else {
	    $result_array = json_decode($result); //print_r($result_array);exit;
	    if ($ke_api)
	    {
		return $result_array;
	    } else {
		if ($info['http_code'] != 201)
		{
		    $message = 'Midtrans Error (' . $info['http_code'] . '): ' . implode(',', $result_array->error_messages);
		    throw new Exception($message, $info['http_code']);
		} else {
		    return $result_array;
		}
	    }
	}
    }

    public static function getSnapToken($params = array())
    {
	if(empty($params))
	{
	    $params = array('transaction_details' => array('order_id' => 'ORDER-101', 'gross_amount' => 10000),
			    'credit_card' => array('secure' => true));
	}
	
	$result = Midtrans::post(Midtrans::getUrlSnap() . '/transactions', Midtrans::$serverKey, $params);
	return $result->token;
    }

    /**
     * Retrieve transaction status
     * @param string $id Order ID or transaction ID
     * @return mixed[]
     */
    public static function status($id)
    {
	return Midtrans::get(Midtrans::getUrlSnap() . '/' . $id . '/status', Midtrans::$serverKey, false);
    }

    /**
     * Appove challenge transaction
     * @param string $id Order ID or transaction ID
     * @return string
     */
    public static function approve($id)
    {
	return Midtrans::post(Midtrans::getUrlSnap() . '/' . $id . '/approve', Midtrans::$serverKey, false)->status_code;
    }

    /**
     * Cancel transaction before it's setteled
     * @param string $id Order ID or transaction ID
     * @return string
     */
    public static function cancel($id)
    {
	return Midtrans::post(Midtrans::getUrlSnap() . '/' . $id . '/cancel', Midtrans::$serverKey, false)->status_code;
    }

    /**
     * Expire transaction before it's setteled
     * @param string $id Order ID or transaction ID
     * @return mixed[]
     */
    public static function expire($id)
    {
	return Midtrans::post(Midtrans::getUrlSnap() . '/' . $id . '/expire', Midtrans::$serverKey, false);
    }

    /* Created By GG */
    
    public static function regcard($gross_amount = '1000', $card_no = '4811111111111114', $card_cvv = '123', $card_exp_month = '01', $card_exp_year = '20')
    {
	return Midtrans::get(Midtrans::getUrlCore() . '/token?secure=true&gross_amount=' . $gross_amount . '&card_number=' . $card_no . '&card_cvv=' . $card_cvv . '&card_exp_month=' . $card_exp_month . '&card_exp_year=' . $card_exp_year . '&client_key=' . Midtrans::$clientKey, Midtrans::$serverKey, null, true);
	
	// Output Veritrans
	//stdClass Object
	//(
	//    [status_code] => 200
	//    [status_message] => OK, success request new token
	//    [token_id] => 481111-1114-b75147a8-6d45-4c3f-83b9-b6f854a04882
	//    [bank] => mandiri
	//    [redirect_url] => https://api.veritrans.co.id/v2/token/redirect/481111-1114-4e267bf9-d714-41e5-ac54-9b42e9be2dc2
	//)
    }

    public static function charge($params = array())
    {
	return Midtrans::post(Midtrans::getUrlCore() . '/charge', Midtrans::$serverKey, $params, true);
    }
    
    public static function setData($id = '', $amount = '', $type = '', $token = '')
    {
	$params = array('transaction_details' => array('order_id' => $id ? $id : 'ORDER-101', 'gross_amount' => $amount ? $amount : 10000));
	
	switch($type)
	{
	    case 'bca':
		$params = array_merge($params, array('payment_type' => 'bank_transfer',
						     'bank_transfer' => array('bank' => $type,
									      'va_number' => '111111')));
	    break;
	    
	    case 'echannel': //Mandiri
		$params = array_merge($params, array('payment_type' => 'echannel',
						     'echannel' => array('bill_info1' => 'Payment For:',
									 'bill_info2' => $id ? $id : 'Order')));
	    break;
	    
	    case 'permata':
		$params = array_merge($params, array('payment_type' => 'bank_transfer',
						     'bank_transfer' => array('bank' => $type)));
	    break;
	    
	    case 'credit_card':
		$params = array_merge($params, array('payment_type' => 'credit_card',
						     'credit_card' => array('token_id' => $token)));
	    break;
	}
	
	return $params;
    }
    
    /*Output BCA
     *stdClass Object
    (
	[status_code] => 201
	[status_message] => Success, Bank Transfer transaction is created
	[transaction_id] => cefa8490-eb2e-4cb1-8768-e4bdb54499ac
	[order_id] => TP1710480F3003
	[gross_amount] => 21000.00
	[payment_type] => bank_transfer
	[transaction_time] => 2017-10-09 09:22:59
	[transaction_status] => pending
	[va_numbers] => Array
	    (
		[0] => stdClass Object
		    (
			[bank] => bca
			[va_number] => 98675111111
		    )
	    )
	[fraud_status] => accept
    )*/
    
    /*Output Mandiri
     *stdClass Object
    (
	[status_code] => 201
	[status_message] => OK, Mandiri Bill transaction is successful
	[transaction_id] => 0544a88e-8b0e-40fc-95af-ad97cf43aed7
	[order_id] => TP1710480F3005
	[gross_amount] => 26250.00
	[payment_type] => echannel
	[transaction_time] => 2017-10-09 09:25:49
	[transaction_status] => pending
	[fraud_status] => accept
	[bill_key] => 825173349907
	[biller_code] => 70012
    )*/

    /*Output Permata
     *stdClass Object
    (
	[status_code] => 201
	[status_message] => Success, PERMATA VA transaction is successful
	[transaction_id] => d6a79130-d034-4203-b430-491c63d509f3
	[order_id] => TP1710480F3004
	[gross_amount] => 26250.00
	[payment_type] => bank_transfer
	[transaction_time] => 2017-10-09 09:24:42
	[transaction_status] => pending
	[fraud_status] => accept
	[permata_va_number] => 8778009818617205
    )*/

}