<?php

class Member extends MX_Controller
{
    var $roles = 'admin';
    var $mparent = 'News';
    var $offset = 1;
    var $limit = 10;
    var $dtable = 'tbl_member';

    function __construct()
    {
        parent::__construct();
        $this->load->model('member_model');

        if ($this->session->userdata('login') != TRUE AND $this->session->userdata('user_uid') == '') {
            redirect('login');
        }

        $raccess = $this->library->role_access('member');
        if (isset($raccess)) {
            $this->roles = $raccess;
        }
    }

    public function index()
    {
        $data['title'] = 'News';
        $data['parent'] = $this->mparent;
        $data['roles'] = $this->roles;
        $data['content'] = $this->config->item('base_theme') . '/member/member';

        $session = array('xfield_' . $this->dtable => '', 'xsearch_' . $this->dtable => '', 'sortBy_' . $this->dtable => 'newjoin',
                         'multi_search_' . $this->dtable => '', 'multi_data_' . $this->dtable => '', 'voffset_' . $this->dtable => '', 'xoffset_' . $this->dtable => '');
        $this->session->set_userdata($session);
       # p($session);

        if ($this->session->userdata('limit_' . $this->dtable) > 0) {
            $limit = $this->session->userdata('limit_' . $this->dtable);
        } else {
            $limit = $this->limit;
        }

        // Sort By
        if ($this->session->userdata('sortDir_' . $this->dtable) == 'asc' OR
            $this->session->userdata('sortDir_' . $this->dtable) == 'desc'
        ) {
            $query = array(
                'sortby' => $this->session->userdata('sortBy_' . $this->dtable),
                'sortdir' => $this->session->userdata('sortDir_' . $this->dtable),
                'page' => $this->offset,
                'limit' => $limit
            );
        } else {
            $query = array(
                'page' => $this->offset,
                'limit' => $limit
            );
        }

        $ulevel = $this->library->user_check();
        if($ulevel->ff > 0)
        {
            $query = array_merge($query, array($ulevel->fu => $this->session->userdata('user_id')));
        }
        #p($ulevel);
        #p($query);
        $data['dt'] = $this->excurl->reqCurl('me', $query)->data;
        $data['count'] = $this->excurl->reqCurl('me', array_merge($query, array('count' => true)))->data[0];
        $data['limit'] = $limit;
        $data['offset'] = $this->offset;
        $data['prefix'] = $this->dtable;
        $data['showpage'] = ceil($data['count']->cc / $limit);

        $this->load->view($this->config->item('base_theme') . '/template', $data);
    }

    function view($option = array())
    {
        if ($this->input->post('val') == true) {
            $data['title'] = 'News';
            $data['roles'] = $this->roles;

            // Limit Session
            if ($this->input->post('val') > 0) {
                $session = array('limit_' . $this->dtable => $this->input->post('val'));
            } else {
                if ($this->session->userdata('sortDir_' . $this->dtable) == 'asc' OR
                    $this->session->userdata('sortDir_' . $this->dtable) == 'desc'
                ) {
                    $session = array('xfield_' . $this->dtable => $this->session->userdata('xfield_' . $this->dtable), 'xsearch_' . $this->dtable => $this->session->userdata('xsearch_' . $this->dtable),
                                     'sortBy_' . $this->dtable => $this->session->userdata('sortBy_' . $this->dtable), 'sortDir_' . $this->dtable => $this->session->userdata('sortDir_' . $this->dtable));
                } else {
                    $session = array('xfield_' . $this->dtable => $this->session->userdata('xfield_' . $this->dtable), 'xsearch_' . $this->dtable => $this->session->userdata('xsearch_' . $this->dtable),
                                     'sortBy_' . $this->dtable => 'news_id', 'sortDir_' . $this->dtable => 'desc');
                }
            }
            $this->session->set_userdata($session);

            if ($this->session->userdata('limit_' . $this->dtable) > 0) {
                $limit = $this->session->userdata('limit_' . $this->dtable);
            } else {
                $limit = $this->limit;
            }

            // Offset
            if ($this->session->userdata('voffset_' . $this->dtable) > 0) {
                if ($this->session->userdata('limit_' . $this->dtable) > 0) {
                    $offset = $this->offset;
                } else {
                    $offset = $this->session->userdata('voffset_' . $this->dtable);
                }
            } else {
                $offset = $this->offset;
            }

            // Search
            $xfield = $this->session->userdata('xfield_' . $this->dtable);
            $xsearch = $this->session->userdata('xsearch_' . $this->dtable);

            // Sort By
            if ($this->session->userdata('sortDir_' . $this->dtable) == 'asc' OR
                $this->session->userdata('sortDir_' . $this->dtable) == 'desc'
            ) {
                $query = array(
                    $xfield => $xsearch,
                    'sortby' => $this->session->userdata('sortBy_' . $this->dtable),
                    'sortdir' => $this->session->userdata('sortDir_' . $this->dtable),
                    'page' => $offset,
                    'limit' => $limit
                );
            } else {
                $query = array(
                    $xfield => $xsearch,
                    'page' => $offset,
                    'limit' => $limit
                );
            }

            $count = array($xfield => $xsearch, 'count' => true);
            if ($this->session->userdata('multi_search_' . $this->dtable) == true) {
                $query = array_merge($query, $this->session->userdata('multi_data_' . $this->dtable));
                $count = array_merge($count, $this->session->userdata('multi_data_' . $this->dtable));
            }

            $ulevel = $this->library->user_check();
            if($ulevel->ff > 0)
            {
                $query = array_merge($query, array($ulevel->fu => $this->session->userdata('user_id')));
                $count = array_merge($count, array($ulevel->fu => $this->session->userdata('user_id')));
            }

            $data['dt'] = $this->excurl->reqCurl('news', $query)->data;
            $data['count'] = $this->excurl->reqCurl('news', $count)->data[0];
            $data['limit'] = $limit;
            $data['offset'] = $offset;
            $data['prefix'] = $this->dtable;
            $data['showpage'] = ceil($data['count']->cc / $limit);

            if ($this->input->post('val') > 0 OR isset($option['is_check'])) {
                $html = $this->load->view($this->config->item('base_theme') . '/news/news_jquery', $data, true);
            } else {
                $html = $this->load->view($this->config->item('base_theme') . '/news/news', $data, true);
            }

            header('Content-Type: application/json');

            if ($option) {
                echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable),
                                        'xCss' => $option['xcss'], 'xMsg' => $option['xmsg']));
            } else {
                echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable), 'query' => $query));
            }
        } else {
            redirect('news');
        }
    }

    function search()
    {
        if ($this->input->post('val') == true) {
            $data['title'] = 'Member';

            $split = explode(",", $this->input->post('val'));

            if ($this->session->userdata('limit_' . $this->dtable) > 0) {
                $limit = $this->session->userdata('limit_' . $this->dtable);
            } else {
                $limit = $this->limit;
            }
            // p($query);
            // exit;

            if (count($split) > 1) {
                $opt = array('offset' => $this->offset, 'limit' => $this->limit, 'value' => $this->input->post('val'));
                $query = $this->pagextable->search($opt, $this->dtable);

                $session = array_merge($query['session'], array('multi_search_' . $this->dtable => '', 'multi_data_' . $this->dtable => '', 'voffset_' . $this->dtable => '', 'xoffset_' . $this->dtable => ''));
            } else {
                $session = array('multi_search_' . $this->dtable => true, 'multi_data_' . $this->dtable => array(), 'voffset_' . $this->dtable => '', 'xoffset_' . $this->dtable => '');
                $query = array('query' => array_merge($session['multi_data_' . $this->dtable], array('page' => $this->offset, 'limit' => $limit,
                                                                                                     'sortby' => $this->session->userdata('sortBy_' . $this->dtable),
                                                                                                     'sortdir' => $this->session->userdata('sortDir_' . $this->dtable))),
                               'count' => array_merge($session['multi_data_' . $this->dtable], array('count' => true)));
            }


            if (isset($session)) {
                $this->session->set_userdata($session);
            }

            $ulevel = $this->library->user_check();
            if($ulevel->ff > 0)
            {
                $query['query'] = array_merge($query['query'], array($ulevel->fu => $this->session->userdata('user_id')));
                $query['count'] = array_merge($query['count'], array($ulevel->fu => $this->session->userdata('user_id')));
            }

            $data['dt'] = $this->excurl->reqCurl('me', $query['query'])->data;
            $data['count'] = $this->excurl->reqCurl('me', $query['count'])->data[0];
            $data['limit'] = $limit;
            $data['offset'] = $this->offset;
            $data['prefix'] = $this->dtable;
            $data['showpage'] = ceil($data['count']->cc / $query['query']['limit']);

            if (count($split) > 1) {
                $html = $this->load->view($this->config->item('base_theme') . '/member/member_jquery', $data, true);
            } else {
                $html = $this->load->view($this->config->item('base_theme') . '/member/member', $data, true);
            }

            header('Content-Type: application/json');
            echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable)));
        } else {
            redirect('member');
        }
    }

    function pagetable()
    {
        if ($this->input->post('val') == true) {
            $opt = array('offset' => $this->offset, 'limit' => $this->limit, 'value' => $this->input->post('val'));
            $query = $this->pagextable->pagination($opt, $this->dtable);

            if ($this->session->userdata('multi_search_' . $this->dtable) == true) {
                $query['query'] = array_merge($query['query'], $this->session->userdata('multi_data_' . $this->dtable));
                $query['count'] = array_merge($query['count'], $this->session->userdata('multi_data_' . $this->dtable));
            }

            $ulevel = $this->library->user_check();
            if($ulevel->ff > 0)
            {
                $query['query'] = array_merge($query['query'], array($ulevel->fu => $this->session->userdata('user_id')));
                $query['count'] = array_merge($query['count'], array($ulevel->fu => $this->session->userdata('user_id')));
            }

            $data['dt'] = $this->excurl->reqCurl('me', $query['query'])->data;
            $data['count'] = $this->excurl->reqCurl('me', $query['count'])->data[0];
            $data['offset'] = $query['offset']+1;

            $html = $this->load->view($this->config->item('base_theme') . '/member/member_table', $data, true);

            header('Content-Type: application/json');
            echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable)));
        } else {
            redirect('member');
        }
    }

    function add()
    {
        if ($this->roles == 'admin' OR $this->roles->menu_created == 1) {
            $data['title'] = 'News';
            $data['parent'] = $this->mparent;
            $data['content'] = $this->config->item('base_theme') . '/news/add_news';

            $data['category'] = $this->excurl->reqCurl('news-category');

            if ($this->input->post('val') == true) {
                $this->load->view($this->config->item('base_theme') . '/news/add_news', $data);
            } else {
                $this->load->view($this->config->item('base_theme') . '/template', $data);
            }
        } else {
            if ($this->input->post('val') == true) {
                $this->library->role_failed();
            } else {
                redirect('news');
            }
        }
    }

    function save()
    {
        if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_created == 1) {
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
                'news_type' => $cat->news_type,
                'sub_category_name' => $catsub->sub_category_name,
                'publish_on' => date('Y-m-d h:i:s', strtotime($this->input->post('publish_date'))),
                'createon' => date('Y-m-d h:i:s'),
                'admin_id' => $this->session->userdata('user_id')
            );

            $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
            if ($option['state'] == 0) {
                $this->news_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            $this->view(array('xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
        } else {
            redirect('news');
        }
    }

    function edit($id = '')
    {
        if ($this->roles == 'admin' OR $this->roles->menu_updated == 1) {
            if ($id == '') {
                redirect('news');
            } else {
                $data['title'] = 'News';
                $data['parent'] = $this->mparent;
                $data['content'] = $this->config->item('base_theme') . '/news/edit_news';

                $query = array('member_id' => $id, 'detail' => true);
                $ulevel = $this->library->user_check();
                if($ulevel->ff > 0)
                {
                    $query = array_merge($query, array('admin_id' => $this->session->userdata('user_id')));
                }

                $data['dt1'] = $this->excurl->reqCurl('news', $query)->data[0];
                $data['category'] = $this->excurl->reqCurl('news-category');
                $data['subcategory'] = $this->excurl->reqCurl('news-category-sub', ['category' => $data['dt1']->news_type]);

                if ($this->input->post('val') == true) {
                    $this->load->view($this->config->item('base_theme') . '/news/edit_news', $data);
                } else {
                    $this->load->view($this->config->item('base_theme') . '/template', $data);
                }
            }
        } else {
            if ($this->input->post('val') == true) {
                $this->library->role_failed();
            } else {
                redirect('news');
            }
        }
    }

    function update()
    {
        if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_updated == 1) {
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
                'news_type' => $cat->news_type,
                'sub_category_name' => $catsub->sub_category_name,
                'publish_on' => date('Y-m-d h:i:s', strtotime($this->input->post('publish_date'))),
                'updateon' => date('Y-m-d h:i:s')
            );

            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1,
                                                  'where' => array('member_id' => $this->input->post('idx'))));
            if ($option['state'] == 0) {
                $this->news_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            // Remove Old Pic If There is Upload Files
            if ($this->input->post('news_pic') != '') {
                $this->news_model->__unlink($this->input->post('news_pic'));
            }

            $this->view(array('xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
        } else {
            redirect('news');
        }
    }

    function delete($id = '')
    {
        if ($this->roles == 'admin' OR $this->roles->menu_deleted == 1) {
            if ($id == '') {
                redirect('news');
            } else {
                if ($this->input->post('val') == true) {
                    $option = $this->news_model->__delete($id);
                    $this->view(array('is_check' => true, 'xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
                } else {
                    redirect('news');
                }
            }
        } else {
            if ($this->input->post('val') == true) {
                $this->library->role_failed();
            } else {
                redirect('news');
            }
        }
    }

    function checked($id = '')
    {
        if ($this->input->post('checked') != NULL) {
            $split = explode(",", $this->input->post('checked'));
            $count = count($split);

            switch ($id) {
                case 1:
                    if ($this->roles == 'admin' OR $this->roles->menu_deleted == 1) {
                        for ($i = 0; $i < $count; $i++) {
                            $option = $this->news_model->__delete($split[$i]);
                        }
                    } else {
                        $this->library->role_failed();
                    }
                    break;

                case 2:
                    if ($this->roles == 'admin' OR $this->roles->menu_updated == 1) {
                        for ($i = 0; $i < $count; $i++) {
                            $option = $this->news_model->__enable($split[$i]);
                        }
                    } else {
                        $this->library->role_failed();
                    }
                    break;

                case 3:
                    if ($this->roles == 'admin' OR $this->roles->menu_updated == 1) {
                        for ($i = 0; $i < $count; $i++) {
                            $option = $this->news_model->__disable($split[$i]);
                        }
                    } else {
                        $this->library->role_failed();
                    }
                    break;
            }

            $this->view(array('is_check' => true, 'xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
        } else {
            redirect('news');
        }
    }

    function subcategory()
    {
        $search = $this->input->post('val');
        $category = $this->excurl->reqCurl('news-category-sub', ['news_type_id' => $search]);

        if ($category) {
            if ($category->data) {
                foreach ($category->data as $cat) {
                    echo "<option value='$cat->sub_news_id'>$cat->sub_category_name</option>";
                }
            } else {
                echo "<option value=''>- Select -</option>";
            }
        }
    }

}