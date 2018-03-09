<?php
class Dashboard extends MX_Controller 
{
    var $roles = 'admin';
    var $mparent = 'Dashboard';
    
    function __construct()
    {
        parent::__construct();
	$this->load->helper('text');
	
	if($this->session->userdata('login') != TRUE AND $this->session->userdata('user_uid') == '')
	{
	    redirect('login');
	}
	
	$raccess = $this->library->role_access('dashboard');
	if(isset($raccess))
	{
	    $this->roles = $raccess;
	}
    }
    
    function index()
    {
	$data['title'] = 'Dashboard';
	$data['parent'] = $this->mparent;
	$data['roles'] = $this->roles;
	$data['content'] = $this->config->item('base_theme').'/dashboard';
	
	//$date = date('Y-m-d');
	//
	//// Based on Days
	//$start_date = date('Y-m-d', strtotime("$date - 14 days"));
	//$end_date = date('Y-m-d', strtotime($date));
	//
	//$total_days = round(abs(strtotime($end_date) - strtotime($start_date)) / 86400, 0) + 1;
	//
	//if($end_date >= $start_date)
	//{
	//    $pernull = [];
	//    $perdays = [];
	//    $periode = [];
	//    for ($day = 0; $day < $total_days; $day++)
	//    {
	//	$pernull[] = 0;
	//	$perdays[] = date("d-m", strtotime("{$start_date} + {$day} days"));
	//	$periode[] = date("Y-m-d", strtotime("{$start_date} + {$day} days"));
	//    }
	//    $data['pernull'] = implode(",",$pernull);
	//    $data['periode_json'] = json_encode($perdays);
	//    $data['periode_array'] = $periode;
	//}
	//
	//$data['daily'] = $this->catalog->get_order_sum(array('created_at' => true, 'start_date' => $start_date, 'end_date' => $end_date, 'groupBy' => 'DATE(created_at)'));
	//
	//// Based on Month
	//$data['monthly'] = date('F');
	//$data['yearly'] = date('Y');
	//$start_date = date('Y-m-01', strtotime($date));
	//$end_date = date('Y-m-t', strtotime($date));
	//
	//$data['onprogress'] = $this->catalog->get_order_chart(array('order_status' => 3, 'created_at' => date('Y-m'), 'set_date' => 'month',
	//							    'groupEmpty' => true, 'row' => true));
	//$data['ondelivery'] = $this->catalog->get_order_chart(array('order_status' => 4, 'created_at' => date('Y-m'), 'set_date' => 'month',
	//							    'groupEmpty' => true, 'row' => true));
	//$data['delivered'] = $this->catalog->get_order_chart(array('order_status' => 5, 'created_at' => date('Y-m'), 'set_date' => 'month',
	//							   'groupEmpty' => true, 'row' => true));
	//
	//$sum = $data['onprogress']->order_count + $data['ondelivery']->order_count + $data['delivered']->order_count;
	//$data['xp1'] = ($data['onprogress']->order_count > 0) ? number_format($data['onprogress']->order_count/$sum * 100, 2) : 0;
	//$data['xp2'] = ($data['ondelivery']->order_count > 0) ? number_format($data['ondelivery']->order_count/$sum * 100, 2) : 0;
	//$data['xp3'] = ($data['delivered']->order_count > 0) ? number_format($data['delivered']->order_count/$sum * 100, 2) : 0;
	//
	//$data['pending'] = $this->catalog->get_order_chart(array('order_status' => 1, 'created_at' => date('Y-m'), 'set_date' => 'month',
	//							 'groupEmpty' => true, 'row' => true));
	//$data['waiting'] = $this->catalog->get_order_chart(array('order_status' => 2, 'created_at' => date('Y-m'), 'set_date' => 'month',
	//							 'groupEmpty' => true, 'row' => true));
	//$data['undelivered'] = $this->catalog->get_order_chart(array('not_in' => true, 'order_status' => "0,5,6,7,8", 'created_at' => date('Y-m'), 'set_date' => 'month',
	//							     'groupEmpty' => true, 'row' => true));
	//
	//$sum = $data['waiting']->order_count + $data['pending']->order_count + $data['undelivered']->order_count;
	//$data['p1'] = ($data['pending']->order_count > 0) ? number_format($data['pending']->order_count/$sum * 100, 2) : 0;
	//$data['w1'] = ($data['waiting']->order_count > 0) ? number_format($data['waiting']->order_count/$sum * 100, 2) : 0;
	//$data['u1'] = ($data['undelivered']->order_count > 0) ? number_format($data['undelivered']->order_count/$sum * 100, 2) : 0;
	
	$this->load->view($this->config->item('base_theme').'/template', $data);
    }
    
    function view($option = array())
    {
	if($this->input->post('val') == true OR isset($option['home']))
	{
	    $data['title'] = 'Dashboard';
	    $data['roles'] = $this->roles;
	    
	    $date = date('Y-m-d');
	    
	    // Based on Days
	    $start_date = date('Y-m-d', strtotime("$date - 14 days"));
	    $end_date = date('Y-m-d', strtotime($date));
	    
	    $total_days = round(abs(strtotime($end_date) - strtotime($start_date)) / 86400, 0) + 1;
	    
	    if($end_date >= $start_date)
	    {
		$pernull = [];
		$perdays = [];
		$periode = [];
		for ($day = 0; $day < $total_days; $day++)
		{
		    $pernull[] = 0;
		    $perdays[] = date("m-d", strtotime("{$start_date} + {$day} days"));
		    $periode[] = date("Y-m-d", strtotime("{$start_date} + {$day} days"));
		}
		$data['pernull'] = implode(",",$pernull);
		$data['periode_json'] = json_encode($perdays);
		$data['periode_array'] = $periode;
	    }
	    
	    $data['daily'] = $this->catalog->get_order_sum(array('order_date' => true, 'start_date' => $start_date, 'end_date' => $end_date));
	    
	    // Based on Month
	    $data['month'] = date('F');
	    $start_date = date('Y-m-01', strtotime($date));
	    $end_date = date('Y-m-t', strtotime($date));
	    
	    $data['pickedup'] = $this->catalog->get_order_chart(array('order_status' => 4, 'order_date' => date('Y-m'), 'set_date' => 'month',
								      'groupEmpty' => true, 'row' => true));
	    $data['delivered'] = $this->catalog->get_order_chart(array('order_status' => 10, 'order_date' => date('Y-m'), 'set_date' => 'month',
								       'groupEmpty' => true, 'row' => true));
	    
	    $sum = $data['pickedup']->order_count + $data['delivered']->order_count;
	    $data['pp1'] = ($data['pickedup']->order_count > 0) ? number_format($data['pickedup']->order_count/$sum * 100, 2) : 0;
	    $data['dd1'] = ($data['delivered']->order_count > 0) ? number_format($data['delivered']->order_count/$sum * 100, 2) : 0;
	    
	    $data['pending'] = $this->catalog->get_order_chart(array('order_status' => 1, 'order_date' => date('Y-m'), 'set_date' => 'month',
								     'groupEmpty' => true, 'row' => true));
	    $data['waiting'] = $this->catalog->get_order_chart(array('order_status' => 2, 'order_date' => date('Y-m'), 'set_date' => 'month',
								     'groupEmpty' => true, 'row' => true));
	    $data['undelivered'] = $this->catalog->get_order_chart(array('not_in' => true, 'order_status' => "0,10,11,12", 'order_date' => date('Y-m'), 'set_date' => 'month',
									 'groupEmpty' => true, 'row' => true));
	    
	    $sum = $data['waiting']->order_count + $data['pending']->order_count + $data['undelivered']->order_count;
	    $data['p1'] = ($data['pending']->order_count > 0) ? number_format($data['pending']->order_count/$sum * 100, 2) : 0;
	    $data['w1'] = ($data['waiting']->order_count > 0) ? number_format($data['waiting']->order_count/$sum * 100, 2) : 0;
	    $data['u1'] = ($data['undelivered']->order_count > 0) ? number_format($data['undelivered']->order_count/$sum * 100, 2) : 0;
	    
	    $html = $this->load->view($this->config->item('base_theme').'/dashboard', $data, true);
	    
	    header('Content-Type: application/json');
	    echo json_encode(array('vHtml' => $html));
	} else {
	    redirect('dashboard');
	}
    }
}