<?php

class News extends MX_Controller
{
    var $dtable = 'tbl_eyenews';

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
        $this->load->model('news_model');
    }

    function save()
    {
        if($_POST)
        {
            $text_title = $this->input->post('title');
            $text_desc = $this->input->post('description');

            $new_link = $this->library->seo_title($text_title);
            $upload = $this->news_model->__upload($new_link);

            $cat = explode(';', $this->input->post('category'));
            $catsub = explode(';', $this->input->post('subcategory'));

            // News
            $dt1 = array(// General
                'title' => addslashes($text_title),
                'description' => addslashes($text_desc),
                'meta_description' => $this->input->post('meta_desc'),
                'tag' => $this->input->post('meta_keyword'),
                'credit' => $this->input->post('credit'),
                'category_news' => $this->input->post('recommended'),
                'pic' => $upload['data'],
                // Data
                'newstype_id' => isset($cat[0]) ? $cat[0] : 0,
                'newstype_sub_id' => isset($catsub[0]) ? $catsub[0] : 0,
                'news_type' => isset($cat[1]) ? $cat[1] : '',
                'sub_category_name' => isset($catsub[1]) ? $catsub[1] : '',
                'publish_on' => date('Y-m-d H:i:s', strtotime($this->input->post('publish_date'))),
                'createon' => date('Y-m-d H:i:s'),
                'admin_id' => $this->input->post('ses_user_id')
            );

            $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
            if ($option['state'] == 0) {
                $this->news_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            $id = $this->db->insert_id();
            $key = substr(md5($id), 0, 7);
            $option = $this->action->update(array('table' => $this->dtable, 'update' => array('url' => $new_link.'-'.$key),
                                                  'where' => array('eyenews_id' => $id)));
            if ($option['state'] == 0) {
                $this->news_model->__unlink($upload['data']);

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
            $upload = $this->news_model->__upload($new_link);

            $cat = explode(';', $this->input->post('category'));
            $catsub = explode(';', $this->input->post('subcategory'));

            // News
            $dt1 = array(// General
                'title' => addslashes($text_title),
                'description' => addslashes($text_desc),
                'meta_description' => $this->input->post('meta_desc'),
                'tag' => $this->input->post('meta_keyword'),
                'credit' => $this->input->post('credit'),
                'category_news' => $this->input->post('recommended'),
                'pic' => $upload['data'],
                // Data
                'newstype_id' => isset($cat[0]) ? $cat[0] : 0,
                'newstype_sub_id' => isset($catsub[0]) ? $catsub[0] : 0,
                'news_type' => isset($cat[1]) ? $cat[1] : '',
                'sub_category_name' => isset($catsub[1]) ? $catsub[1] : '',
                'publish_on' => date('Y-m-d H:i:s', strtotime($this->input->post('publish_date'))),
                'updateon' => date('Y-m-d H:i:s')
            );

            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1,
                                                  'where' => array('eyenews_id' => $this->input->post('idx'))));
            if ($option['state'] == 0) {
                $this->news_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            $id = $this->input->post('idx');
            $key = substr(md5($id), 0, 7);
            $option = $this->action->update(array('table' => $this->dtable, 'update' => array('url' => $new_link.'-'.$key),
                                                  'where' => array('eyenews_id' => $id)));
            if ($option['state'] == 0) {
                $this->news_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            // Remove Old Pic If There is Upload Files
            if ($this->input->post('news_pic') != '') {
                $this->news_model->__unlink($this->input->post('news_pic'));
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
            $option = $this->news_model->__delete($this->input->post('idx'));
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
            $option = $this->news_model->__disable($this->input->post('idx'));
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
            $option = $this->news_model->__enable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

}