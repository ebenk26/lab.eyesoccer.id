<?php

class Club_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'eyeprofile_club';
    var $xtable = 'eyeprofile_club_career';
    var $ytable = 'eyeprofile_club_official';
    var $ztable = 'eyeprofile_club_register';
    var $mtable = 'tbl_gallery';

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

        if ($dt->logo) {
            $path = $this->__path();
            $this->uploader->__unlink($path, $dt->logo);
        }

        if ($dt->legalitas_pt) {
            $path = $this->__path();
            $this->uploader->__unlink($path, $dt->legalitas_pt);
        }

        if ($dt->legalitas_kemenham) {
            $path = $this->__path();
            $this->uploader->__unlink($path, $dt->legalitas_kemenham);
        }

        if ($dt->legalitas_npwp) {
            $path = $this->__path();
            $this->uploader->__unlink($path, $dt->legalitas_npwp);
        }

        if ($dt->legalitas_dirut) {
            $path = $this->__path();
            $this->uploader->__unlink($path, $dt->legalitas_dirut);
        }

        /* Career */
        $option = $this->action->delete(array('table' => $this->xtable, 'where' => array('id_club' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        /* Official */
        $option = $this->action->delete(array('table' => $this->ytable, 'where' => array('id_club' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        /* Register */
        $option = $this->action->delete(array('table' => $this->ztable, 'where' => array('id_club' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        /* Gallery */
        $option = $this->action->delete(array('table' => $this->mtable, 'where' => array('id_club' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
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
        $path = UPLOAD . FDCLUB;

        // Upload Config
        $config = array(
            'allowed_types' => 'gif|jpg|jpeg|png',
            'max_size' => '1000',
            'resize' => true
        );

        return array('path' => $path, 'resize' => true, 'config' => $config);
    }

    function __upload($input = 'logo_pic', $upload = 'uploadfile', $newname = '')
    {
        $path = $this->__path();

        $pic = '';
        if ($this->input->post($input) != '') {
            $pic = $this->input->post($input);
        } else {
            if ($this->input->post('temp_' . $input) != '') {
                $files = $this->input->post('temp_' . $input);
                $this->uploader->__unlink($path, $files);
            }
        }

        $upload = $this->uploader->single_upload($path['config'], $upload, $path['path'], $pic, $newname);

        return $upload;
    }

    function __unlink($upload = 'uploadfile', $post_pic = '')
    {
        $path = $this->__path();
        $this->uploader->single_unlink($path['config'], $upload, $path['path'], $post_pic);
    }

}
