<?php

class Playergallery_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'es_gallery';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $dt = $this->excurl->reqCurl('list-pic', ['id_gallery' => $id])->data[0];
        $option = $this->action->delete(array('table' => $this->dtable, 'where' => array('id_gallery' => $id)));
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
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 0), 'where' => array('id_gallery' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

    function __enable($id = '')
    {
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 1), 'where' => array('id_gallery' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

    function __path()
    {
        // Upload Path
        $path = UPLOAD . FDIMAGES;

        // Upload Config
        $config = array(
            'allowed_types' => 'gif|jpg|jpeg|png',
            'max_size' => '1000',
            'resize' => true
        );

        return array('path' => $path, 'resize' => true, 'config' => $config);
    }

}
