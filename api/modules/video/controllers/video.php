<?php

class Video extends MX_Controller
{
    var $dtable = 'tbl_eyetube';

    function __construct()
    {
        // PHP Version 5.4
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }

        $postdata = json_decode(file_get_contents("php://input"));
        if(is_object($postdata))
        {
            $this->restapi->__postdata($postdata);
        }

        $this->restapi->__auth();
        $this->load->model('video_model');
    }

    function save()
    {
        if($_POST)
        {
            $text_title = $this->input->post('title');
            $text_desc = $this->input->post('description');

            $new_link = $this->library->seo_title($text_title);
            $uploadpic = $this->video_model->__upload($new_link);
            $uploadvideo = $this->video_model->__upload_video($new_link);

            $cat = explode(';', $this->input->post('category'));

            // Video
            $dt1 = array(// General
                'title' => addslashes($text_title),
                'description' => addslashes($text_desc),
                'thumb' => $uploadpic['data'],
                'video' => $uploadvideo['data'],
                'duration' => $this->input->post('duration'),
                // Data
                'id_category_eyetube' => $cat[0],
                'category_name' => $cat[1],
                'publish_on' => date('Y-m-d h:i:s', strtotime($this->input->post('publish_date'))),
                'createon' => date('Y-m-d h:i:s'),
                'admin_id' => $this->input->post('ses_user_id')
            );

            $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
            if ($option['state'] == 0) {
                $this->video_model->__unlink($uploadpic['data']);
                $this->video_model->__unlink_video($uploadvideo['data']);

                $this->validation->error_message($option);
                return false;
            }

            $id = $this->db->insert_id();
            $key = substr(md5($id), 0, 7);
            $option = $this->action->update(array('table' => $this->dtable, 'update' => array('url' => $new_link.'-'.$key),
                                                  'where' => array('eyetube_id' => $id)));
            if ($option['state'] == 0) {
                $this->video_model->__unlink($uploadpic['data']);
                $this->video_model->__unlink_video($uploadvideo['data']);

                $this->validation->error_message($option);
                return false;
            }

            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

    function update()
    {
        if($_POST)
        {
            $text_title = $this->input->post('title');
            $text_desc = $this->input->post('description');

            $new_link = $this->library->seo_title($text_title);
            $uploadpic = $this->video_model->__upload($new_link);
            $uploadvideo = $this->video_model->__upload_video($new_link);

            $cat = explode(';', $this->input->post('category'));

            // Video
            $dt1 = array(// General
                'title' => addslashes($text_title),
                'description' => addslashes($text_desc),
                'thumb' => $uploadpic['data'],
                'video' => $uploadvideo['data'],
                'duration' => $this->input->post('duration'),
                // Data
                'id_category_eyetube' => $cat[0],
                'category_name' => $cat[1],
                'publish_on' => date('Y-m-d h:i:s', strtotime($this->input->post('publish_date'))),
                'updateon' => date('Y-m-d h:i:s')
            );

            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1,
                                                  'where' => array('eyetube_id' => $this->input->post('idx'))));
            if ($option['state'] == 0) {
                $this->video_model->__unlink($uploadpic['data']);
                $this->video_model->__unlink_video($uploadvideo['data']);

                $this->validation->error_message($option);
                return false;
            }

            $id = $this->input->post('idx');
            $key = substr(md5($id), 0, 7);
            $option = $this->action->update(array('table' => $this->dtable, 'update' => array('url' => $new_link.'-'.$key),
                                                  'where' => array('eyetube_id' => $id)));
            if ($option['state'] == 0) {
                $this->video_model->__unlink($uploadpic['data']);
                $this->video_model->__unlink_video($uploadvideo['data']);

                $this->validation->error_message($option);
                return false;
            }

            // Remove Old Pic If There is Upload Files
            if ($this->input->post('video_pic') != '') {
                $this->video_model->__unlink($this->input->post('video_pic'));
            }

            // Remove Old Video If There is Upload Video
            if ($this->input->post('video_vid') != '') {
                $this->video_model->__unlink_video($this->input->post('video_vid'));
            }

            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

    function delete()
    {
        if($_POST)
        {
            $option = $this->video_model->__delete($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

    function disable()
    {
        if($_POST)
        {
            $option = $this->video_model->__disable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

    function enable()
    {
        if($_POST)
        {
            $option = $this->video_model->__enable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

}