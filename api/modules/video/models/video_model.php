<?php

class Video_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'tbl_eyetube';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $dt = $this->excurl->reqCurl('video', ['eyetube_id' => $id])->data[0];
        $option = $this->action->delete(array('table' => $this->dtable, 'where' => array('eyetube_id' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        if ($dt->thumb) {
            $path = $this->__path();
            $this->uploader->__unlink($path, $dt->thumb);
        }

        if ($dt->video) {
            $path = $this->__path('video');
            $this->uploader->__unlink($path, $dt->video);
        }

        return $option;
    }

    function __disable($id = '')
    {
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 0), 'where' => array('eyetube_id' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

    function __enable($id = '')
    {
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 1), 'where' => array('eyetube_id' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

    function __path($type = 'image')
    {
        // Upload Path
        $path = UPLOAD . FDEYETUBE;

        // Upload Config
        $config = array(
            'allowed_types' => ($type == 'image') ? 'gif|jpg|jpeg|png' : 'mp4',
            'max_size' => ($type == 'image') ? '1000' : '5000000'
        );

        if ($type == 'image')
        {
            $config = array_merge($config, array('resize' => true));
            return array('path' => $path, 'resize' => true, 'config' => $config);
        } else {
            return array('path' => $path, 'config' => $config);
        }
    }

    function __upload($newname = '')
    {
        $path = $this->__path();

        $pic = '';
        if ($this->input->post('video_pic') != '') {
            $pic = $this->input->post('video_pic');
        } else {
            if ($this->input->post('temp_video_pic') != '') {
                $files = $this->input->post('temp_video_pic');
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

    function __upload_video($newname = '')
    {
        $path = $this->__path('video');

        $video = '';
        if ($this->input->post('video_vid') != '') {
            $video = $this->input->post('video_vid');
        } else {
            if ($this->input->post('temp_video_vid') != '') {
                $files = $this->input->post('temp_video_vid');
                $this->uploader->__unlink($path, $files);
            }
        }

        $upload = $this->uploader->single_upload($path['config'], 'uploadvideo', $path['path'], $video, $newname);

        return $upload;
    }

    function __unlink_video($post_pic = '')
    {
        $path = $this->__path('video');
        $this->uploader->single_unlink($path['config'], 'uploadvideo', $path['path'], $post_pic);
    }

}
