<?php

class Order_model extends CI_Model {

    var $dtable = 'we_order';

    function __construct() {
        parent::__construct();
	$this->vlink = $this->config->item('aes_vlink');
    }
    
    function __state($option = '')
    {
	if($option['state'] == 0)
	{
	    $this->restapi->__error($option['message']);
	}
    }
    
    function __path()
    {
        // Upload Path
        $path = UPLOAD.'temp/';
        
        // Upload Config
        $config = array(
                            'allowed_types' => 'gif|jpg|png',
                            'max_size' => '1000',
                            'resize' => true
                        );
        
        return array('path' => $path, 'resize' => true, 'config' => $config);
    }
    
    function __autono($type = '')
    {
	$mid = strtoupper(substr(md5($this->input->post('user_id')), 0, 5)); $y = date('y'); $m = date('m'); $d = date('d');
	switch($type)
	{
	    case 'bill':
		// Bill No
		$code = 'EX';
		$filter = array('auto_id' => true, 'code' => $code, 'year' => $y, 'month' => $m, 'mid' => $mid, 'sortBy' => 'bill_id', 'sortDir' => 'desc', 'row' => true);
		$bill = $this->catalog->get_bills($filter);
		$order = ($bill) ? substr($bill->bill_no, 11, 4) + 1 : 1;
		$autono = sprintf("%s%s%s%s%04d",$code,$y,$m,$mid,$order);
	    break;
	    
	    case 'order':
		// Order No
		$code = 'EOD';
		$filter = array('auto_id' => true, 'year' => $y, 'month' => $m, 'day' => $d, 'mid' => $mid, 'sortBy' => 'order_no', 'sortDir' => 'desc', 'row' => true);
		$bill = $this->catalog->get_order($filter);
		$order = ($bill) ? substr($bill->order_no, 11, 4) + 1 : 1;
		$autono = sprintf("%s%s%s%s%04d",$y,$m,$d,$mid,$order);
	    break;
	}
	
	return $autono;
    }
    
    function __temp($temps = '')
    {
	$dest = $this->input->post('destination');
	if($temps)
	{
	    if($dest != '')
	    {
		$wmerchant = []; $b2cweight = 0; //b2c
		$wmember = []; $b2bweight = 0; //b2b
	    }
	    
	    $m = 0;
	    $data = [];
	    $member = [];
	    $merchant = [];
	    $subtotal = 0;
	    foreach($temps as $t)
	    {
		$detail = json_decode($t->product_detail);
		$mm = array('id' => ($t->merchant_id > 0) ? $t->merchant_id : $t->member_id, 'display_name' => $t->merchant_dname, 'first_name' => $t->merchant_fname,
			    'last_name' => $t->merchant_lname, 'email' => $t->merchant_email, 'contact' => $t->merchant_contact, 'pic' => $t->merchant_pic, 'type' => $t->merchant_type);
		
		$temp = $t;
		unset($temp->merchant_dname);
		unset($temp->merchant_fname);
		unset($temp->merchant_lname);
		unset($temp->merchant_email);
		unset($temp->merchant_contact);
		unset($temp->merchant_pic);
		unset($temp->merchant_type);
		
		if($t->merchant_id > 0)
		{
		    $x = 0;
		    $index = '';
		    foreach($merchant as $v1 => $m1)
		    {
			if($m1 == $t->merchant_id)
			{
			    $x = 1;
			    $index = $v1;
			    break;
			}
		    }
		    
		    if($x == 0)
		    {
			$merchant[$m] = $t->merchant_id;
		    }
		    
		    if($x > 0)
		    {
			$data[$index]['temps'][] = $temp;
			if($dest != '')
			{
			    $b2cweight = $t->product_qty * $detail->product_weight;
			    $wmerchant[$index] = array_merge($wmerchant[$index], array('weight' => $wmerchant[$index]['weight'] + $b2cweight));
			}
		    } else {
			$data[] = array('merchant' => $mm, 'temps' => array($temp));
			if($dest != '')
			{
			    $b2cweight = $t->product_qty * $detail->product_weight;
			    $wmerchant[]= array('merchant_id' => $t->merchant_id, 'weight' => $b2cweight);
			}
		    }
		}
		
		if($t->member_id > 0)
		{
		    $x = 0;
		    $index = '';
		    foreach($member as $v1 => $m1)
		    {
			if($m1 == $t->member_id)
			{
			    $x = 1;
			    $index = $v1;
			    break;
			}
		    }
		    
		    if($x == 0)
		    {
			$member[$m] = $t->member_id;
		    }
		    
		    if($x > 0)
		    {
			$data[$index]['temps'][] = $temp;
			if($dest != '')
			{
			    $b2bweight = $t->product_qty * $detail->product_weight;
			    $wmember[$index] = array_merge($wmember[$index], array('weight' => $wmember[$index]['weight'] + $b2bweight));
			}
		    } else {
			$data[] = array('member' => $mm, 'temps' => array($temp));
			if($dest != '')
			{
			    $b2bweight = $t->product_qty * $detail->product_weight;
			    $wmember[]= array('member_id' => $t->member_id, 'weight' => $b2bweight);
			}
		    }
		}
		
		$subtotal+= $t->product_qty * $t->product_price;
		
		$m++;
	    }
	    
	    if($this->input->post('destination') != '')
	    {
		$totalweight = 0;
		$this->load->library('mylib/shipment');
		if($wmerchant)
		{
		    $datafull = [];
		    foreach($wmerchant as $m1)
		    {
			$ori = $this->catalog->get_pr_merchant(array('user_id' => $m1['merchant_id'], 'row' => true));
			$oriid = ($ori AND $ori->city_id > 0) ? $ori->city_id : '';
			
			$weight = ceil($m1['weight']) * 1000;
			$shipment = $this->shipment->__cost($weight, $oriid, 'm1/'.$m1['merchant_id']);
			
			foreach($data as $d)
			{
			    if($m1['merchant_id'] == $d['merchant']['id'])
			    {
				$datafull[] = array_merge($d, array('weight' => $m1['weight'], 'package' => $shipment));
				break;
			    }
			}
			
			$totalweight+= ceil($m1['weight']);
		    }
		}
		
		if($wmember)
		{
		    $datafull = ($datafull) ? $datafull : [];
		    foreach($wmember as $m2)
		    {
			$ori = $this->catalog->get_pr_users(array('user_id' => $m2['member_id'], 'row' => true));
			$oriid = ($ori AND $ori->city_id > 0) ? $ori->city_id : '';
			
			$weight = ceil($m2['weight']) * 1000;
			$shipment = $this->shipment->__cost($weight, $oriid, 'm2/'.$m2['member_id']);
			
			foreach($data as $d)
			{
			    if($m2['member_id'] == $d['member']['id'])
			    {
				$datafull[] = array_merge($d, array('weight' => $m2['weight'], 'package' => $shipment));
				break;
			    }
			}
			
			$totalweight+= ceil($m2['weight']);
		    }
		}
		
		$totalweight = ceil($totalweight) * 1000;
		$shipment = $this->shipment->__cost($totalweight);
		
		$data = $datafull;
	    }
	    
	    if($dest != '')
	    {
		return ['order' => $data, 'package' => $shipment, 'subtotal' => $subtotal];
	    } else {
		return $data;
	    }
	}
    }
    
    function __tempdel()
    {
	$date = date('Y-m-d');
	$date = date('Y-m-d', strtotime("$date - 1 days"));
	$this->action->delete(array('table' => 'we_order_temp', 'where' => array('user_id' => 0, 'DATE(updated_at)' => $date)));
    }
    
    function __cartdel()
    {
	if($this->input->post('user_id') > 0)
	{
	    $temp = array('user_id' => $this->input->post('user_id'));
	} else {
	    $temp = array('user_session' => $this->session->userdata('session_id'));
	}
	
	$this->action->delete(array('table' => 'we_order_temp', 'where' => array_merge($temp, array('product_code' => $this->input->post('product_code')))));
    }
    
    function __address($set = '', $options = array())
    {
	if($set != '' AND $set > 0)
	{
	    $addr = $this->catalog->get_pr_address(array('address_id' => $options['id'], 'row' => true));
	    $reg = json_decode($addr->address_detail);
	    
	    $address = json_decode($addr->address_detail);
	    $regfull = $reg->region;
	    $regid = $addr->address_region;
	    $contact = $addr->address_contact;
	    $latitude = $addr->latitude;
	    $longitude = $addr->longitude;
	} else {
	    $region = $this->catalog->get_pr_regions(array('region_id' => $options['region'], 'row' => true));
	    $address = array('address' => $options['address'], 'region' => $region->region_full);
	    $regfull = $region->region_full;
	    $regid = $options['region'];
	    $contact = $options['contact'];
	    $latitude = $options['latitude'];
	    $longitude = $options['longitude'];
	}
	
	return array('address' => $address, 'regfull' => $regfull, 'regid' => $regid,
		     'contact' => $contact, 'latitude' => $latitude, 'longitude' => $longitude);
    }
    
    function __payment($vpay = '', $id = '', $autono = '', $total = 0)
    {
	if($vpay != '' AND isset($vpay->production))
	{
	    $pmethod = $this->input->post('payment_method');
	    
	    $this->load->library('mylib/midtrans/midtrans');
	    
	    $config = array('client_key' => $vpay->midtrans_client, 'server_key' => $vpay->midtrans_server, 'production' => $vpay->production);
	    $this->midtrans->config($config);
	    
	    switch($pmethod)
	    {
		case 'midtrans_va':
		    $vcode = $this->input->post('payment_vcode');
		    
		    $data = $this->midtrans->setData($autono, $total, $vcode);
		    $mdata = $this->midtrans->charge($data);
		    
		    switch($vcode)
		    {
			case 'bca':
			    $vn = isset($mdata->va_numbers[0]->va_number) ? $mdata->va_numbers[0]->va_number : '';
			break;
			
			case 'echannel':
			    $vn = isset($mdata->bill_key) ? $mdata->bill_key : '';
			break;
			
			case 'permata':
			    $vn = isset($mdata->permata_va_number) ? $mdata->permata_va_number : '';
			break;
		    }
		    
		    $update = array('gateway_code' => isset($mdata->transaction_id) ? $mdata->transaction_id : '',
				    'gateway_status' => isset($mdata->transaction_status) ? $mdata->transaction_status : '',
				    'gateway_method' => $vcode.'/'.$vn, 'updated_at' => date('Y-m-d h:i:s'));
		    $option = $this->action->update(array('table' => 'we_bills', 'update' => $update, 'where' => array('bill_id' => $id)));
		    $this->order_model->__state($option);
		    
		    $message = $this->restapi->__getdata(array('query' => $_POST, 'autono' => $autono, 'gateway' => $mdata, 'update' => $update));
		    $this->restapi->__haccess(json_encode($message));
		break;
		
		case 'midtrans_cc':
		    $this->load->library('encrypt');
		    $this->load->library('mylib/encrypto');
		    $this->encrypto->initialize($this->input->post('user_uid'));
		    $cc = $this->encrypto->ssdecrypt(json_encode($this->input->post('payment_cc')));
		    $cc = json_decode($cc);
		    $mdata = $this->midtrans->regcard($total, $cc->number, $cc->ccv, $cc->month, $cc->year); //print_r($mdata);exit;
		    
		    $update = array('gateway_code' => isset($mdata->token_id) ? $mdata->token_id : '',
				    'gateway_status' => isset($mdata->status_message) ? $mdata->status_message : '',
				    'gateway_method' => isset($mdata->redirect_url) ? $mdata->redirect_url : '',
				    'updated_at' => date('Y-m-d h:i:s'));
		    $option = $this->action->update(array('table' => 'we_bills', 'update' => $update, 'where' => array('bill_id' => $id)));
		    $this->order_model->__state($option);
		    
		    if($mdata->status_code == '400')
		    {
			$this->action->delete(array('table' => 'we_bills', 'where' => array('bill_id' => $id)));
			$this->action->delete(array('table' => 'we_order', 'where' => array('bill_id' => $id)));
			$this->action->delete(array('table' => 'we_order_detail', 'where' => array('bill_id' => $id)));
			$this->action->delete(array('table' => 'we_order_product', 'where' => array('bill_id' => $id)));
			$this->action->delete(array('table' => 'we_order_location', 'where' => array('bill_id' => $id)));
			
			$this->restapi->__error($mdata->validation_messages[0]);
		    }
		    
		    $message = $this->restapi->__getdata(array('query' => $_POST, 'autono' => $autono, 'gateway' => $mdata, 'update' => $update), array('msg' => $option['message']));
		    $this->restapi->__haccess(json_encode($message));
		    
		    return $message;
		break;
	    }
	}
    }
    
    function __mail($id = '', $payment = '', $code = '')
    {
	if($id > 0)
	{
	    // Delete Temp Order
	    $this->action->delete(array('table' => 'we_order_temp', 'where' => array('user_id' => $this->input->post('user_id'))));
	    
	    // Unset Userdata
	    $this->session->unset_userdata(array('user_level' => '', 'user_id' => ''));
	    
	    $payment = ($this->input->post('payment_method') != '') ? $this->input->post('payment_method') : $payment;
	    
	    // Load Lang
	    $data['lang'] = $this->library->load_lang();
	    
	    // Load Setting
	    $data['set'] = $this->tools->__setting();
	    $data['tcode'] = $this->library->textcode(json_decode($data['set']->text_code), $data['lang'][0]);
	    
	    // Data Bill
	    $data['dt1'] = $this->catalog->get_bills(array('bill_id' => $id, 'user_id' => $this->input->post('user_id'), 'row' => true));
	    if($data['dt1'])
	    {
		// Data Order
		$data['dt2'] = $this->catalog->get_order(array('bill_id' => $id));
		
		switch($payment)
		{
		    case 'cash_on_delivery':
			// Load Notif
			$data['notif'] = $this->tools->__notif('checkout-pending', $data['lang'][0]);
			$html = $this->load->view($this->config->item('base_theme').'/order/checkout_mail', $data, true);
		    break;
		    
		    case 'bank_transfer':
		    case 'midtrans_va':
			// Load Notif
			$data['notif'] = $this->tools->__notif('checkout-pending', $data['lang'][0]);
			$html = $this->load->view($this->config->item('base_theme').'/order/checkout_mail', $data, true);
		    break;
		    
		    case 'midtrans_cc':
			if($code == '200')
			{
			    // Load Notif
			    $data['notif'] = $this->tools->__notif('checkout-success', $data['lang'][0]);
			}
			$html = $this->load->view($this->config->item('base_theme').'/order/checkout_mail', $data, true);
		    break;
		}
		
		$message = $this->restapi->__getdata(array('query' => $_POST, 'bill' => $data['dt1']));
		$this->restapi->__haccess(json_encode($message));
		
		return $message;
	    }
	}
    }
    
}
