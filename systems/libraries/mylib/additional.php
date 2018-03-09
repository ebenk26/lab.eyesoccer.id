<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Additional {
    
    var $dtable = 'we_information';
    var $ttable = 'tb_translation';
    
    function __construct() {
        $this->ci = & get_instance();
    }
    
    function __error($option, $dtother = '')
    {
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
    
    function __infodel($id = '', $dttype = '')
    {
	$info = $this->ci->catalog->get_pr_info(array('data_id' => $id, 'data_type' => $dttype));
	if($info)
	{
	    foreach($info as $i)
	    {
		$option = $this->ci->action->delete(array('table' => $this->dtable, 'where' => array('info_id' => $i->info_id)));
		$this->__error($option);
		
		$option = $this->ci->action->delete(array('table' => $this->ttable, 'where' => array('element_type' => $dttype, 'element_id' => $i->info_id)));
		$this->__error($option);
	    }
	}
    }
    
    function __info($id = '', $type = '', $dttype = '', $dtother = '', $conf = '')
    {
	if($type == 'update')
	{
	    $info = $this->ci->catalog->get_pr_info(array('info_id_not' => $this->ci->input->post('info_id'),
							  'data_type' => $dttype, 'data_id' => $id));
	    if($info)
	    {
		foreach($info as $i)
		{
		    $this->ci->action->delete(array('table' => $this->dtable, 'where' => array('info_id' => $i->info_id)));
		    $this->ci->action->delete(array('table' => $this->ttable, 'where' => array('element_type' => $dttype, 'element_id' => $i->info_id)));
		}
	    }
	}
	
	if($this->ci->input->post('rows_info') != '')
	{   
	    $option = '';
	    $countlang = $this->ci->input->post('language_row');
	    
	    // Language Translation
	    if($countlang > 1)
	    {
		$langID = explode(",", $this->ci->input->post('lang_code'));
		$langText = explode(",", $this->ci->input->post('lang_text'));
		
		$rowsInfo = count($this->ci->input->post('rows_info'));
		for($r=0;$r<$rowsInfo;$r++)
		{
		    $dtinfo = array(
					'data_type' => $dttype,
					'data_id' => $id,
					'info_name' => $this->ci->input->post('info_name')[$langText[0]][$r],
					'info_desc' => str_replace("'", "~", $this->ci->input->post('info_desc')[$langText[0]][$r])
				    );
		    
		    if($type == 'update')
		    {
			if(isset($this->ci->input->post('info_id')[$r]))
			{
			    $option = $this->ci->action->update(array('table' => $this->dtable, 'update' => $dtinfo,
								      'where' => array('data_type' => $dttype, 'data_id' => $id)));
			} else {
			    $option = $this->ci->action->insert(array('table' => $this->dtable, 'insert' => $dtinfo));
			    $idx = $this->ci->db->insert_id();
			}
		    } else {
			$option = $this->ci->action->insert(array('table' => $this->dtable, 'insert' => $dtinfo));
			$idx = $this->ci->db->insert_id();
		    }
		    
		    $this->__error($option, $dtother);
		    
		    for($l=0;$l<$countlang;$l++)
		    {
			$idx = (isset($this->ci->input->post('info_id')[$r]) AND $this->ci->input->post('info_id')[$r] != '') ? $this->ci->input->post('info_id')[$r] : $idx;
			
			// Info Language
			$dtlang = array(
					    'element_type' => $dttype,
					    'element_id' => $idx,
					    'lang_code' => $langID[$l],
					    'text_title' => $this->ci->input->post('info_name')[$langText[$l]][$r],
					    'text_desc' => str_replace("'", "~", $this->ci->input->post('info_desc')[$langText[$l]][$r])
					);
			
			$numrows = $this->ci->catalog->get_translation(array('element_type' => $dttype, 'element_id' => $idx,
									     'lang_code' => $langID[$l], 'count' => true));
			
			if($numrows > 0)
			{
			    $option = $this->ci->action->update(array('table' => $this->ttable, 'update' => $dtlang,
								      'where' => array('element_type' => $dttype, 'element_id' => $idx, 'lang_code' => $langID[$l])));
			} else {
			    $option = $this->ci->action->insert(array('table' => $this->ttable, 'insert' => $dtlang));
			}
			
			$this->__error($option, $dtother);
		    }
		}
	    } else {
		$rowsInfo = count($this->ci->input->post('rows_info'));
		for($r=0;$r<$rowsInfo;$r++)
		{
		    $dtinfo = array(
					'data_type' => $dttype,
					'data_id' => $id,
					'info_name' => $this->ci->input->post('info_name')[$r],
					'info_desc' => str_replace("'", "~", $this->ci->input->post('info_desc')[$r])
				    );
		    
		    if($type == 'update')
		    {
			$option = $this->ci->action->update(array('table' => $this->dtable, 'update' => $dtinfo,
								  'where' => array('data_type' => $dttype, 'data_id' => $id)));
		    } else {
			$option = $this->ci->action->insert(array('table' => $this->dtable, 'insert' => $dtinfo));
		    }
		    
		    $this->__error($option, $dtother);
		}
	    }
	    
	    return $option;
	}
    }

}
