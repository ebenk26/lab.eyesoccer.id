<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Onemap {
    
    var $query_string = '';
    var $command = '';
    
    function __construct() {
        $this->ci = & get_instance();
    }
    
    function district($str)
    {
	if($str == 01){ return 1; break; }
	if($str == 02){ return 2; break; }
	if($str == 03){ return 3; break; }
	if($str == 04){ return 4; break; }
	if($str == 05){ return 5; break; }
	if($str == 06){ return 6; break; }
	if($str == 07){ return 7; break; }
	if($str == 08){ return 8; break; }
	if($str == 09){ return 9; break; }
	if($str >= 10){ return $str; break; }
	
	//if($str >= 01 && $str <= 05){ return 1; break; }
	//if($str == '07' or $str == '08'){ return 2; break; }
	//if($str >= 14 && $str <= 16){ return 3; break; }
	//if($str == '09' or $str == 10){ return 4; break; }
	//if($str >= 11 && $str <= 13){ return 5; break; }
	//if($str == 17){ return 6; break; }
	//if($str == 18 or $str == 19){ return 7; break; }
	//if($str == 20 or $str == 21){ return 8; break; }
	//if($str == 22 or $str == 23){ return 9; break; }
	//if($str >= 24 && $str <= 27){ return 10; break; }
	//if($str >= 28 && $str <= 30){ return 11; break; }
	//if($str >= 31 && $str <= 33){ return 12; break; }
	//if($str >= 34 && $str <= 37){ return 13; break; }
	//if($str >= 38 && $str <= 41){ return 14; break; }
	//if($str >= 42 && $str <= 45){ return 15; break; }
	//if($str >= 46 && $str <= 48){ return 16; break; }
	//if($str == 49 or $str == 50 or $str == 81){ return 17; break; }
	//if($str == 51 or $str == 52){ return 18; break; }
	//if($str >= 53 && $str <= 55 or $str == 82){ return 19; break; }
	//if($str == 56 or $str == 57){ return 20; break; }
	//if($str == 58 or $str == 59){ return 21; break; }
	//if($str >= 60 && $str <= 64){ return 22; break; }
	//if($str >= 65 && $str <= 68){ return 23; break; }
	//if($str >= 69 && $str <= 71){ return 24; break; }
	//if($str == 72 or $str == 73){ return 25; break; }
	//if($str == 77 or $str == 78){ return 26; break; }
	//if($str == 75 or $str == 76){ return 27; break; }
	//if($str == 79 or $str == 80){ return 28; break; }
    }
    
    function geocode($postalcode = '')
    {
	$this->ci->load->library('mylib/api/excurl');
	
	$xypost = $this->ci->excurl->reqData('http://www.onemap.sg/API/services.svc/basicSearch?token=qo/s2TnSUmfLz+32CvLC4RMVkzEFYjxqyti1KhByvEacEdMWBpCuSSQ+IFRT84QjGPBCuz/cBom8PfSm3GjEsGc8PkdEEOEr&searchVal='.$postalcode);
	$xy = json_decode($xypost);
	
	$address = '';
	if(isset($xy->SearchResults[1]->X) AND $xy->SearchResults[1]->X != '' AND isset($xy->SearchResults[1]->Y) AND $xy->SearchResults[1]->Y != '')
	{
	    $geomap = $this->ci->excurl->reqData('http://www.onemap.sg/API/services.svc/revgeocode?token=qo/s2TnSUmfLz+32CvLC4RMVkzEFYjxqyti1KhByvEacEdMWBpCuSSQ+IFRT84QjGPBCuz/cBom8PfSm3GjEsGc8PkdEEOEr&location='.$xy->SearchResults[1]->X.','.$xy->SearchResults[1]->Y);
	    $geo = json_decode($geomap);
	    $region_no = $this->district(SUBSTR($geo->GeocodeInfo[0]->POSTALCODE, 0, 2));
	    
	    if(isset($geo->GeocodeInfo[0]->POSTALCODE) AND $geo->GeocodeInfo[0]->POSTALCODE != '')
	    {
		$dt = array('table' => 'tb_postcodes',
			    'field' => array('postcode_bldname','postcode_strtno','postcode_strtname','postcode_no','region_id'),
			    'value' => array(ucwords(strtolower($geo->GeocodeInfo[0]->BUILDINGNAME)), $geo->GeocodeInfo[0]->BLOCK, ucwords(strtolower($geo->GeocodeInfo[0]->ROAD)), $geo->GeocodeInfo[0]->POSTALCODE, $region_no));
		$option = $this->ci->action->insert($dt);
		if($option['state'] == 0)
		{
		    $this->ci->validation->error_message($option);
		    return false;
		}
		
		if($geo->GeocodeInfo[0]->BUILDINGNAME == '')
		{
		    $address = $geo->GeocodeInfo[0]->BLOCK." ".ucwords(strtolower($geo->GeocodeInfo[0]->ROAD));
		} else {
		    $address = $geo->GeocodeInfo[0]->BLOCK." ".ucwords(strtolower($geo->GeocodeInfo[0]->ROAD)).", ".ucwords(strtolower($geo->GeocodeInfo[0]->BUILDINGNAME));
		}
	    } else {
		$address = '';
	    }
	}
	
	return $address;
    }
    
}
