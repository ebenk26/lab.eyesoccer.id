<?php

class Club_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'eyeprofile_club';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $dt = $this->excurl->reqCurl('profile-club', ['id_club' => $id])->data[0];
        $option = $this->action->delete(array('table' => $this->dtable, 'where' => array('id_club' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        if ($dt->url_logo) {
            $path = $this->__path();
            $this->uploader->__unlink($path, $dt->url_logo);
        }

        return $option;
    }

    function __disable($id = '')
    {
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 0), 'where' => array('id_club' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

    function __enable($id = '')
    {
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 1), 'where' => array('id_club' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

    function __path()
    {
        // Upload Path
        $path = UPLOAD . 'eyeprofile/';

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
        if ($this->input->post('logo') != '') {
            $pic = $this->input->post('logo');
        } else {
            if ($this->input->post('temp_logo') != '') {
                $files = $this->input->post('temp_logo');
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

}
