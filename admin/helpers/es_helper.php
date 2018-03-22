<?php
if( !defined('BASEPATH')) exit(' No Direct Script Allow');

function p($arr){
	echo '<pre>';
		print_r($arr);
	echo '</pre>';
}
define('NOW',date('Y-m-d G:i:s'));