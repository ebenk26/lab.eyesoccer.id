<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Translation {
    
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
    
    function __del($id = '', $dttype = '')
    {
	$option = $this->ci->action->delete(array('table' => $this->ttable, 'where' => array('element_type' => $dttype, 'element_id' => $id)));
	$this->__error($option);
    }
    
    function __ins($id = '', $dttype = '', $dtinput = '', $dtother = '', $conf = '')
    {
	$countlang = $this->ci->input->post('language_row');
        
        // Language Translation
        if($countlang > 1)
        {
            $langID = explode(",", $this->ci->input->post('lang_code'));
            
            for($l=0;$l<$countlang;$l++)
            {
                if($this->ci->input->post('link_seo')[$l] == '')
                {
		    if($this->ci->input->post($dtinput['name'].'_'.$l) != '')
		    {
			$new_link = $this->ci->library->seo_link(array('trans' => true, 'title' => $this->ci->input->post($dtinput['name'].'_'.$l), 
								   'lgcode' => $langID[$l], 'element_type' => $dttype));
		    }
                } else {
                    $new_link = $this->ci->input->post('link_seo')[$l];
                    if($this->ci->library->seo_title($this->ci->input->post($dtinput['name'].'_'.$l)) != $new_link)
                    {
			if($this->ci->input->post($dtinput['name'].'_'.$l) != '')
			{
			    $new_link = $this->ci->library->seo_link(array('trans' => true, 'title' => $this->ci->input->post($dtinput['name'].'_'.$l), 
								       'lgcode' => $langID[$l], 'element_type' => $dttype));
			}
                    }
                }
                
                $dtlang = array(
				    'element_type' => $dttype,
				    'element_id' => $id,
				    'lang_code' => $langID[$l],
				    'text_title' => $this->ci->input->post($dtinput['name'].'_'.$l),
				    'text_title_seo' => $new_link
                                );
                
		if(isset($dtinput['desc']) AND $this->ci->input->post($dtinput['desc'].'_'.$l) != '')
		{
		    $dtlang = array_merge($dtlang, array('text_desc' => str_replace("'", "~", $this->ci->input->post($dtinput['desc'].'_'.$l))));
		}
		
		if(isset($dtinput['url']) AND $this->ci->input->post($dtinput['url'].'_'.$l) != '')
		{
		    $dtlang = array_merge($dtlang, array('text_url' => $this->ci->input->post($dtinput['url'].'_'.$l)));
		}
		
		if(isset($dtinput['tag']) AND $this->ci->input->post($dtinput['tag'].'_'.$l) != '')
		{
		    $dtlang = array_merge($dtlang, array('text_tag' => $this->ci->input->post($dtinput['tag'].'_'.$l)));
		}
		
                $numrows = $this->ci->catalog->get_translation(array('element_type' => $dttype, 'element_id' => $id,
								     'lang_code' => $langID[$l], 'count' => true));
                
                if($numrows > 0)
                {
                    $option = $this->ci->action->update(array('table' => $this->ttable, 'update' => $dtlang,
							      'where' => array('element_type' => $dttype, 'element_id' => $id, 'lang_code' => $langID[$l])));
                } else {
                    $option = $this->ci->action->insert(array('table' => $this->ttable, 'insert' => $dtlang));
                }
                
                $this->__error($option, $dtother);
            }
            
            return $option;
        }
    }

}
