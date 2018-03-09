<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class V1 extends CI_Controller 
{
    function __construct()
    {
	parent::__construct();
    }
    
    function index()
    {
	?>
	    <html>
	    <head>
		    <title>403 Forbidden</title>
	    </head>
	    <body>
	    
	    <p>Directory access is forbidden.</p>
	    
	    </body>
	    </html>
	<?php
    }
    
    function cache($folder = '', $file = '', $size = '')
    {
	$ctype = get_mime_by_extension($file);
	if($ctype != '')
	{
	    $filename = '';
	    $main = UPLOAD.$folder;
	    $size = ($size) ? $size : 'ori';
	    
	    if(is_file($main.'/'.$size.'_'.$file))
	    {
		$filename = $main.'/'.$size.'_'.$file;
	    }
	    
	    if($filename == '')
	    {
		$sub = array('default','category');
		foreach($sub as $s)
		{
		    if(is_file($main.'/'.$s.'/'.$size.'_'.$file))
		    {
			$filename = $main.'/'.$s.'/'.$size.'_'.$file;
			break;
		    }
		}
		
		if(is_file($main.'/'.$file))
		{
		    $filename = $main.'/'.$file;
		}
	    }
	    
	    if($filename != '')
	    {
		$fileModTime = filemtime($filename);
		$headers = $this->RequestHeaders();
		if (isset($headers['If-Modified-Since']) && (strtotime($headers['If-Modified-Since']) == $fileModTime))
		{
		    header('Last-Modified: '.gmdate('D, d M Y H:i:s', $fileModTime).' GMT', true, 304);
		} else {
		    header('Last-Modified: '.gmdate('D, d M Y H:i:s', $fileModTime).' GMT', true, 200);
		    header('Content-Type:'.$ctype);
		    header('Content-transfer-encoding: binary');
		    header('Content-Length: ' . filesize($filename));
		    readfile($filename);
		}
	    } else {
		redirect('../home');
	    }
	} else {
	    redirect('../home');
	}
    }
    
    function lines()
    {
	$size = '';
	$str = str_replace(APPFOLDER, '', $_SERVER['REQUEST_URI']);
	$file = strtolower(substr(strrchr($str, '/'), 1));
	$folder = str_replace($file, '', $str);
	$folder = str_replace('v1/lines/', '', $folder);
	switch($file)
	{
	    case 'thumb':
	    case 'small':
	    case 'medium':
		$size = strtolower(substr(strrchr($str, '/'), 1));
		$split = explode("/", $str);
		$count = count($split) - 2;
		$file = $split[$count];
		
		$folder = str_replace($file, '', $str);
		$folder = str_replace('/'.$size, '', $folder);
		$folder = str_replace('v1/lines/', '', $folder);
	    break;
	}
	
	$ctype = get_mime_by_extension($file);
	if($ctype != '')
	{
	    $filename = '';
	    $main = ASSETS.$folder;
	    if(is_file($main.$size.'_'.$file))
	    {
		$filename = $main.$size.'_'.$file;
	    } else {
		if(is_file($main.$file))
		{
		    $filename = $main.$file;
		}
	    }
	    
	    if($filename != '')
	    {
		$fileModTime = filemtime($filename);
		$headers = $this->RequestHeaders();
		if (isset($headers['If-Modified-Since']) && (strtotime($headers['If-Modified-Since']) == $fileModTime))
		{
		    header('Last-Modified: '.gmdate('D, d M Y H:i:s', $fileModTime).' GMT', true, 304);
		} else {
		    header('Last-Modified: '.gmdate('D, d M Y H:i:s', $fileModTime).' GMT', true, 200);
		    header('Content-Type:'.$ctype);
		    header('Content-transfer-encoding: binary');
		    header('Content-Length: ' . filesize($filename));
		    readfile($filename);
		}
	    } else {
		redirect('../home');
	    }
	} else {
	    redirect('../home');
	}
    }
    
    function RequestHeaders() {
	if (function_exists("apache_request_headers")) {
	    if($headers = apache_request_headers()) {
		return $headers;
	    }
	}
	
	$headers = array();
	// Grab the IF_MODIFIED_SINCE header
	if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
	    $headers['If-Modified-Since'] = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
	}
	
	return $headers;
    }

}