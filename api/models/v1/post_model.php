<?php

class Post_model extends CI_Model {

    var $dtable = 'tb_post';

    function __construct() {
        parent::__construct();
	$this->vlink = $this->config->item('aes_vlink');
    }
    
    function __filters($all = '', $lang = '')
    {
	if($all)
	{
	    $id = [];
	    $catID = [];
	    $tagID = [];
	    foreach($all as $a)
	    {
		$id[] = $a->post_id;
		
		$catData = json_decode($a->category_id);
		if(is_array($catData) OR is_object($catData))
		{
		    foreach($catData as $a1)
		    {
			if(is_array($a1) OR is_object($a1))
			{
			    foreach($a1 as $a2)
			    {
				$catID[] = $a2;
			    }
			}
		    }
		}
		
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
	    $catID = implode(",", $catID);
	    $tagID = implode(",", $tagID);
	    
	    // Category Data
	    $filters['category'] = ($catID) ? $this->__categories($all, $catID, $lang) : '';
	    
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
    
    function __categories($data = '', $id = 0, $lang = '', $pid = 0)
    {
	$query = array('is_active' => 1, 'parent_id' => $pid, 'lang_code' => $lang, 'sortBy' => 'is_order', 'sortDir' => 'asc');
	if($data)
	{
	    $query = array_merge($query, array('is_multi' => true, 'category_id' => $id));
	}
	
	$cat = $this->catalog->get_post_category($query);
	if($cat)
	{
	    $catData = [];
	    foreach($cat as $c)
	    {
		$catChild = $this->__categories($data, $id, $lang, $c->category_id);
		if($catChild)
		{
		    $dt = array('sum_post' => 0, 'child' => $catChild);
		    if($data)
		    {
			$dt = array_merge($dt, array('sum_post' => $this->__sum($data, $c, 'category_id', 'category_id')));
		    }
		    
		    $catData[] = array_merge((array)$c, $dt);
		} else {
		    $dt = [];
		    if($data)
		    {
			$dt = array_merge($dt, array('sum_post' => $this->__sum($data, $c, 'category_id', 'category_id')));
		    }
		    
		    $catData[] = array_merge((array)$c, $dt);
		}
	    }
	    
	    return $catData;
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
