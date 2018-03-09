<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Geocoder {
    
    function __construct() {
        $this->ci = & get_instance();
	$this->vlink = $this->ci->config->item('aes_vlink');
    }
    
    function __location($id = '', $type = '', $dttype = '', $dtother = '', $conf = '') {
	if($id > 0)
	{
	    $vlink = (isset($dtother['vlink'])) ? $this->vlink.'.' : '';
	    
	    $exec = 1;
	    if($type == 'update')
	    {
		$exec = 0;
		if($this->ci->input->post('location_lat') != $this->ci->input->post('location_lat_temp') AND $this->ci->input->post('location_long') != $this->ci->input->post('location_long_temp'))
		{
		    $exec = 1;
		}
	    }
	    
	    $zz = ($this->ci->input->post('iso_code') != '' AND $this->ci->input->post('zone_id') != '' OR $this->ci->input->post('city_id') != '') ? 1 : 0;
	    $zone = array('iso_code' => strtolower($this->ci->input->post('iso_code')),
			  'zone_id' => $this->ci->input->post('zone_id'),
			  'city_id' => $this->ci->input->post('city_id'),
			  'data_id' => $id, 'data_type' => $dttype);
	    
	    $data = array('location_lat' => ($this->ci->input->post('location_lat')) ? $this->ci->input->post('location_lat') : $this->ci->input->post('location_lat_temp'),
			  'location_long' => ($this->ci->input->post('location_long')) ? $this->ci->input->post('location_long') : $this->ci->input->post('location_long_temp'),
			  'data_id' => $id, 'data_type' => $dttype);
	    
	    if($type == 'insert')
	    {
		if($zz > 0)
		{
		    $option = $this->ci->action->insert(array('table' => $vlink.'we_zone', 'insert' => $zone));
		}
		
		if($exec > 0)
		{
		    $option = $this->ci->action->insert(array('table' => $vlink.'we_location', 'insert' => $data));
		}
	    } else {
		if($zz > 0)
		{
		    $zn = $this->ci->catalog->get_pr_zone(array('data_id' => $id, 'data_type' => $dttype, 'vlink' => $vlink, 'row' => true));
		    if($zn)
		    {
			$option = $this->ci->action->update(array('table' => $vlink.'we_zone', 'update' => $zone,
								  'where' => array('data_id' => $id, 'data_type' => $dttype)));
		    } else {
			$option = $this->ci->action->insert(array('table' => $vlink.'we_zone', 'insert' => $zone));
		    }
		}
		
		if($exec > 0)
		{
		    $loc = $this->ci->catalog->get_pr_location(array('data_id' => $id, 'data_type' => $dttype, 'vlink' => $vlink, 'row' => true));
		    if($loc)
		    {
			$option = $this->ci->action->update(array('table' => $vlink.'we_location', 'update' => $data,
								  'where' => array('data_id' => $id, 'data_type' => $dttype)));
		    } else {
			$option = $this->ci->action->insert(array('table' => $vlink.'we_location', 'insert' => $data));
		    }
		}
	    }
	    
	    if(isset($option['state']) AND $option['state'] == 0)
	    {
		if($dtother)
		{
		    $default = isset($dtother['default']) ? $dtother['default'] : $dtother;
		    $this->ci->uploader->single_unlink($conf['config'], 'uploadfile', $conf['path'], $default);
		    
		    if(isset($dtother['filestore']))
		    {
			$this->ci->uploader->__filestore_unlink($dtother['filestore']);
		    }
		}
		
		$this->ci->validation->error_message($option);
		return false;
	    }
	}
    }

}
