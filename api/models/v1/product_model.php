<?php

class Product_model extends CI_Model {

    var $dtable = 'we_products';

    function __construct() {
        parent::__construct();
	$this->vlink = $this->config->item('aes_vlink');
    }
    
    function __filters($all = '', $lang = '')
    {
	if($all)
	{
	    $id = [];
	    foreach($all as $a)
	    {
		$id[] = $a->product_id;
	    }
	    $id = implode(",", $id);
	    
	    // Brand Data
	    $brand = $this->catalog->get_pr_brands(array('is_multi' => true, 'product_id' => $id, 'groupBy' => 'brand_id',
							 'sortBy' => 'brand_name', 'sortDir' => 'asc'));
	    $filters['brand'] = $brand;
	    
	    // Category Data
	    $catData = $this->catalog->get_pr_lines(array('line_data' => 'category_data', 'line_table' => 'we_categories_line',
							  'is_multi' => true, 'product_id' => $id));
	    if($catData)
	    {
		$i = 0;
		$catID = '';
		foreach($catData as $r1)
		{
		    $catLine = json_decode($r1->category_data); //print_r($catLine);
		    if(is_array($catLine) OR is_object($catLine))
		    {
			foreach($catLine as $r2)
			{
			    if($i > 0)
			    {
				$catID.= ",".implode(",", $r2);
			    } else {
				$catID = implode(",", $r2);
			    }
			}
			
			$i++;
		    }
		}
		
		$filters['category'] = ($catID) ? $this->__categories($catData, $catID, $lang) : '';
	    }
	    
	    // Tag Data
	    $tagData = $this->catalog->get_pr_lines(array('line_data' => 'tag_data', 'line_table' => 'we_tags_line',
							  'is_multi' => true, 'product_id' => $id));
	    if($tagData)
	    {
		$i = 0;
		$tagID = '';
		foreach($tagData as $r1)
		{
		    $tagLine = json_decode($r1->tag_data);
		    if(is_array($tagLine) OR is_object($tagLine))
		    {
			if($i > 0)
			{
			    $tagID.= ",".implode(",", $tagLine);
			} else {
			    $tagID = implode(",", $tagLine);
			}
			
			$i++;
		    }
		}
		
		$filters['tag'] = ($tagID) ? $this->__tags($tagData, $tagID, $lang) : '';
	    }
	    
	    // Features Data
	    $featureData = $this->catalog->get_pr_lines(array('line_data' => 'feature_data', 'line_table' => 'we_features_line',
							      'is_multi' => true, 'product_id' => $id));
	    if($featureData)
	    {
		$i = 0;
		$featureID = '';
		foreach($featureData as $r1)
		{
		    $featureLine = json_decode($r1->feature_data);
		    if(is_array($featureLine) OR is_object($featureLine))
		    {
			if($i > 0)
			{
			    $featureID.= ",".implode(",", $featureLine);
			} else {
			    $featureID = implode(",", $featureLine);
			}
			
			$i++;
		    }
		}
		
		$filters['feature'] = ($featureID) ? $this->__features($featureData, $featureID, $lang) : '';
	    }
	    
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
	
	$cat = $this->catalog->get_pr_categories($query);
	if($cat)
	{
	    $catData = [];
	    foreach($cat as $c)
	    {
		$catChild = $this->__categories($data, $id, $lang, $c->category_id);
		if($catChild)
		{
		    $dt = array('sum_product' => 0, 'child' => $catChild);
		    if($data)
		    {
			$dt = array_merge($dt, array('sum_product' => $this->__sum($data, $c, 'category_id', 'category_data')));
		    }
		    
		    $catData[] = array_merge((array)$c, $dt);
		} else {
		    $dt = [];
		    if($data)
		    {
			$dt = array_merge($dt, array('sum_product' => $this->__sum($data, $c, 'category_id', 'category_data')));
		    }
		    
		    $catData[] = array_merge((array)$c, $dt);
		}
	    }
	    
	    return $catData;
	}
    }
    
    function __tags($data = '', $id = 0, $lang = '', $pid = 0)
    {
	$tag = $this->catalog->get_pr_tags(array('is_multi' => true, 'tag_id' => $id, 'lang_code' => $lang,
						 'sortBy' => 'tag_name', 'sortDir' => 'asc'));
	if($tag)
	{
	    $tagData = [];
	    foreach($tag as $t)
	    {
		$tagData[] = array_merge((array)$t, array('sum_product' => $this->__sum($data, $t, 'tag_id', 'tag_data')));
	    }
	    
	    return $tagData;
	}
    }
    
    function __details($data = '', $id = 0, $lang = '', $pid = 0)
    {
	$detail = $this->catalog->get_pr_details(array('is_multi' => true, 'detail_id' => $id, 'parent_id' => $pid,
						       'lang_code' => $lang, 'sortBy' => 'detail_name', 'sortDir' => 'asc'));
	if($detail)
	{
	    $detailData = [];
	    foreach($detail as $d)
	    {
		$detailChild = $this->__details($data, $id, $lang, $d->detail_id);
		if($detailChild)
		{
		    $detailData[] = array_merge((array)$d, array('sum_product' => $this->__sum($data, $d, 'detail_id', 'detail_data'), 'child' => $detailChild));
		} else {
		    $detailData[] = array_merge((array)$d, array('sum_product' => $this->__sum($data, $d, 'detail_id', 'detail_data')));
		}
	    }
	    
	    return $detailData;
	}
    }
    
    function __features($data = '', $id = 0, $lang = '', $pid = 0)
    {
	$feature = $this->catalog->get_pr_features(array('is_multi' => true, 'feature_id' => $id, 'lang_code' => $lang,
							 'sortBy' => 'feature_name', 'sortDir' => 'asc'));
	if($feature)
	{
	    $featureData = [];
	    foreach($feature as $f)
	    {
		$featureData[] = array_merge((array)$f, array('sum_product' => $this->__sum($data, $f, 'feature_id', 'feature_data')));
	    }
	    
	    return $featureData;
	}
    }
    
    function __colors($data = '', $id = 0, $lang = '', $pid = 0)
    {
	$color = $this->catalog->get_pr_colors(array('is_multi' => true, 'color_id' => $id, 'lang_code' => $lang,
						     'sortBy' => 'color_name', 'sortDir' => 'asc'));
	if($color)
	{
	    $colorData = [];
	    foreach($color as $c)
	    {
		$colorData[] = array_merge((array)$c, array('sum_product' => $this->__sum($data, $c, 'color_id', 'color_data')));
	    }
	    
	    return $colorData;
	}
    }
    
    function __variants($data = '', $id = 0, $lang = '', $pid = 0)
    {
	$variant = $this->catalog->get_pr_variant(array('is_multi' => true, 'variant_id' => $id, 'parent_id' => $pid,
							'lang_code' => $lang, 'sortBy' => 'variant_name', 'sortDir' => 'asc'));
	if($variant)
	{
	    $variantData = [];
	    foreach($variant as $v)
	    {
		$variantChild = $this->__variants($data, $id, $lang, $v->variant_id);
		if($variantChild)
		{
		    $variantData[] = array_merge((array)$v, array('sum_product' => $this->__sum($data, $v, 'variant_id', 'variant_data'), 'child' => $variantChild));
		} else {
		    $variantData[] = array_merge((array)$v, array('sum_product' => $this->__sum($data, $v, 'variant_id', 'variant_data')));
		}
	    }
	    
	    return $variantData;
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
