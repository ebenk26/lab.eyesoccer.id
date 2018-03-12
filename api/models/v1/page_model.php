<?php

class Page_model extends CI_Model {

    var $dtable = 'tb_page';

    function __construct() {
        parent::__construct();
	$this->vlink = $this->config->item('aes_vlink');
    }
    
    function __filters($all = '', $lang = '')
    {
	if($all)
	{
	    $id = [];
	    $tagID = [];
	    foreach($all as $a)
	    {
		$id[] = $a->page_id;
		
		$tagData = json_decode($a->tag_id);
		if(is_array($tagData) OR is_object($tagData))
		{
		    foreach($tagData as $a1)
		    {
			$tagID[] = $a1;
		    }
		}
	    }
	    $id = implode(",", $id);
	    $tagID = implode(",", $tagID);
	    
	    // Tag Data
	    $filters['tag'] = ($tagID) ? $this->__tags($all, $tagID, $lang) : '';
	    
	    return $filters;
	}
    }
    
    function __sum($data = '', $line = '', $lineid = '', $linedata = '')
    {
	$x = 0;
	foreach($data as $r1)
	{
	    $dataLine = json_decode($r1->{$linedata});
	    if(is_array($dataLine) OR is_object($dataLine))
	    {
		if(isset($dataLine->p))
		{
		    foreach($dataLine->p as $r2)
		    {
			if($line->{$lineid} == $r2)
			{
			    $x++;
			}
		    }
		    
		    if(isset($dataLine->c))
		    {
			foreach($dataLine->c as $r2)
			{
			    if(is_array($r2) OR is_object($r2))
			    {
				foreach($r2 as $r3)
				{
				    if($line->{$lineid} == $r3)
				    {
					$x++;
				    }
				}
			    } else {
				if($line->{$lineid} == $r2)
				{
				    $x++;
				}
			    }
			}
		    }
		} else {
		    foreach($dataLine as $r2)
		    {
			if(is_array($r2) OR is_object($r2))
			{
			    foreach($r2 as $r3)
			    {
				if($line->{$lineid} == $r3)
				{
				    $x++;
				}
			    }
			} else {
			    if($line->{$lineid} == $r2)
			    {
				$x++;
			    }
			}
		    }
		}
	    }
	}
	
	return $x;
    }
    
    function __page($type = '', $lang = '', $pid = 0)
    {
	$query = array('is_active' => 1, 'page_parent' => $pid, 'lang_code' => $lang, 'sortBy' => 'page_order', 'sortDir' => 'asc');
	if($type)
	{
	    $query = array_merge($query, array('page_type' => $type));
	}
	
	$dt = $this->catalog->get_page($query);
	if($dt)
	{
	    $dtData = [];
	    foreach($dt as $r)
	    {
		$dtChild = $this->__page($type, $lang, $r->page_id);
		if($dtChild)
		{
		    $dt = array('child' => $dtChild);
		    $dtData[] = array_merge((array)$r, $dt);
		} else {
		    $dtData[] = $r;
		}
	    }
	    
	    return $dtData;
	}
    }
    
    function __tags($data = '', $id = 0, $lang = '', $pid = 0)
    {
	$tag = $this->catalog->get_post_tag(array('is_multi' => true, 'tag_id' => $id, 'lang_code' => $lang,
						  'sortBy' => 'tag_name', 'sortDir' => 'asc'));
	if($tag)
	{
	    $tagData = [];
	    foreach($tag as $t)
	    {
		$tagData[] = array_merge((array)$t, array('sum_post' => $this->__sum($data, $t, 'tag_id', 'tag_id')));
	    }
	    
	    return $tagData;
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

}
