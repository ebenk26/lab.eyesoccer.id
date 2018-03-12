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
            $key = substr(md5($this->library->app_key()), 0, 7);

            $cat = $this->excurl->reqCurl('news-category', ['news_type_id' => $this->input->post('category')])->data[0];
            $catsub = $this->excurl->reqCurl('news-category-sub', ['sub_news_id' => $this->input->post('subcategory')])->data[0];

            // News
            $dt1 = array(// General
                'title' => addslashes($text_title),
                'description' => addslashes($text_desc),
                'meta_description' => $this->input->post('meta_desc'),
                'tag' => $this->input->post('meta_keyword'),
                'credit' => $this->input->post('credit'),
                'category_news' => $this->input->post('recommended'),
                'url' => $new_link.'-'.$key,
                'pic' => $upload['data'],
                // Data
                'newstype_id' => $this->input->post('category'),
                'newstype_sub_id' => $this->input->post('subcategory'),
                'news_type' => $cat->news_type,
                'sub_category_name' => $catsub->sub_category_name,
                'publish_on' => date('Y-m-d h:i:s', strtotime($this->input->post('publish_date'))),
                'createon' => date('Y-m-d h:i:s'),
                'admin_id' => $this->input->post('ses_user_id')
            );

            $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
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
            $key = substr(md5($this->library->app_key()), 0, 7);

            $cat = $this->excurl->reqCurl('news-category', ['news_type_id' => $this->input->post('category')])->data[0];
            $catsub = $this->excurl->reqCurl('news-category-sub', ['sub_news_id' => $this->input->post('subcategory')])->data[0];

            // News
            $dt1 = array(// General
                'title' => addslashes($text_title),
                'description' => addslashes($text_desc),
                'meta_description' => $this->input->post('meta_desc'),
                'tag' => $this->input->post('meta_keyword'),
                'credit' => $this->input->post('credit'),
                'category_news' => $this->input->post('recommended'),
                'url' => $new_link.'-'.$key,
                'pic' => $upload['data'],
                // Data
                'newstype_id' => $this->input->post('category'),
                'newstype_sub_id' => $this->input->post('subcategory'),
                'news_type' => $cat->news_type,
                'sub_category_name' => $catsub->sub_category_name,
                'publish_on' => date('Y-m-d h:i:s', strtotime($this->input->post('publish_date'))),
                'updateon' => date('Y-m-d h:i:s')
            );

            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1,
                                                  'where' => array('eyenews_id' => $this->input->post('idx'))));
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