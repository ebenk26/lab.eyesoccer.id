<?php

class Setting_model extends CI_Model {

    var $query_string = '';
    var $command = '';

    function __construct() {
        parent::__construct();
    }

    function __path()
    {
        // Upload Path
        $path = UPLOAD.'images/';
        
        // Resize Image
        $resize = array(
                            'thumb' => array(100, 100),
                            'xthumb' => array(150, 150),
                            'medium' => array(300, 300),
                            'large' => array(450, 450),
                            'xlarge' => array(600, 600)
                        );
        
        // Upload Config
        $config = array(
                            'allowed_types' => 'gif|jpg|png',
                            'max_size' => '1000',
                            'resize' => $resize
                        );
        
        return array('path' => $path,
                     'resize' => $resize,
                     'config' => $config);
    }
    
    function __upload()
    {
        $path = $this->__path();
        
        $web_logo = '';
        if($this->input->post('web_logo') != '')
        {
            $web_logo = $this->input->post('web_logo');
	    
	    $i = 0;
	    foreach($web_logo as $pic)
	    {
		if($pic == '' AND $this->input->post('temp_web_logo')[$i] != '')
		{
		    $files = $this->input->post('temp_web_logo')[$i];
		    $this->uploader->__unlink($path, $files);
		}
		$i++;
	    }
        }
        
        $upload = $this->uploader->multi_upload($path['config'], 'uploadfile', $path['path'], $web_logo);
        
        return $upload;
    }
    
    function __unlink($web_logo = '')
    {
        $path = $this->__path();
        $this->uploader->multi_unlink($path['config'], 'uploadfile', $path['path'], $web_logo);
    }
    
}
