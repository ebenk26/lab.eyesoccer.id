<?php

class Market_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'eyemarket_toko';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $dt = $this->excurl->reqCurl('market-store', ['id' => $id])->data[0];
        $option = $this->action->delete(array('table' => $this->dtable, 'where' => array('id' => $id)));
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
        if ($id != NULL) {
            $dt = array('table' => $this->dtable, 'update' => array('is_active' => 0), 'where' => array('id' => $id));
            $option = $this->action->update($dt);

            return $option;
        } else {
            redirect('news');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $dt = array('table' => $this->dtable, 'update' => array('is_active' => 1), 'where' => array('id' => $id));

            $option = $this->action->update($dt);

            return $option;
        } else {
            redirect('news');
        }
    }

    function __path()
    {
        // Upload Path
        $path = UPLOAD . FDEYENEWS;

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

}
