<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Form_validation extends CI_Form_validation {
	
	function __construct($config = array()) {
	     parent::__construct($config);
	}
	
	function clearchar($string)
	{
	    return preg_replace("/[^0-9]/", '', $string);
	}
	
	function clearnumber($string)
	{
	    return preg_replace("/[^A-Za-z]/", '', $string);
	}
	
}