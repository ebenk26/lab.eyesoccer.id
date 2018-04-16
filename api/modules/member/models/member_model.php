<?php

class Member_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'tbl_member';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {   

        $dt = $this->excurl->reqCurl('me',array('id_member' => $id))->data[0];
        $option = $this->action->delete(array('table' => $this->dtable, 'where' => array('id_member' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        if ($dt->pic) {
            $path = $this->__path();
            $this->uploader->__unlink($path, $dt->pic);
        }

        return $option;
    }

    function __disable($id = '')
    {
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 0), 'where' => array('eyenews_id' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

    function __enable($id = '')
    {
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 1), 'where' => array('eyenews_id' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

    function __path()
    {
        // Upload Path
        $path = UPLOAD . 'eyenews/';

        // Upload Config
        $config = array(
            'allowed_types' => 'gif|jpg|jpeg|png',
            'max_size' => '1000',
            'resize' => true
        );

        return array('path' => $path, 'resize' => true, 'config' => $config);
    }

    function __upload($newname = '')
    {
        $path = $this->__path();

        $pic = '';
        if ($this->input->post('news_pic') != '') {
            $pic = $this->input->post('news_pic');
        } else {
            if ($this->input->post('temp_news_pic') != '') {
                $files = $this->input->post('temp_news_pic');
                $this->uploader->__unlink($path, $files);
            }
        }

        $upload = $this->uploader->single_upload($path['config'], 'uploadfile', $path['path'], $pic, $newname);

        return $upload;
    }

    function __unlink($post_pic = '')
    {
        $path = $this->__path();
        $this->uploader->single_unlink($path['config'], 'uploadfile', $path['path'], $post_pic);
    }

     function findUser($tbl,$where = array(),$select=array()){
        if(is_array($where)){
            foreach($where as $k => $v){
                $this->db->where($k,$v);
            }
        }
        $s = '';
        if(is_array($select)){
            if(count($select) > 0){
                foreach($select as $vs){                
                    $s .= ','.$vs;
                }
                $s = substr($s,1);
                $this->db->select($s);
            }
        }
        $this->db->set_dbprefix('');
        $get = $this->db->get($tbl);
        return $get->result();
    }


}
