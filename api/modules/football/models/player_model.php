<?php

class Player_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'eyeprofile_player';
    var $xtable = 'eyeprofile_player_career';
    var $ytable = 'eyeprofile_player_achievement';
    var $ztable = 'eyeprofile_player_register';
    var $mtable = 'es_gallery';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $dt = $this->excurl->reqCurl('profile', ['id_player' => $id])->data[0];
        $option = $this->action->delete(array('table' => $this->dtable, 'where' => array('id_player' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        if ($dt->pic) {
            $path = $this->__path();
            $this->uploader->__unlink($path, $dt->pic);
        }

        /* Career */
        $option = $this->action->delete(array('table' => $this->xtable, 'where' => array('id_player' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        /* Achievement */
        $option = $this->action->delete(array('table' => $this->ytable, 'where' => array('id_player' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        /* Register */
        $option = $this->action->delete(array('table' => $this->ztable, 'where' => array('id_player' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        /* Gallery */
        $option = $this->action->delete(array('table' => $this->mtable, 'where' => array('id_player' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        return $option;
    }

    function __disable($id = '')
    {
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 0), 'where' => array('id_player' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

    function __enable($id = '')
    {
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 1), 'where' => array('id_player' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

    function __path()
    {
        // Upload Path
        $path = UPLOAD . FDPLAYER;

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
        if ($this->input->post('photo_pic') != '') {
            $pic = $this->input->post('photo_pic');
        } else {
            if ($this->input->post('temp_photo_pic') != '') {
                $files = $this->input->post('temp_photo_pic');
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
