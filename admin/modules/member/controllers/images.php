<?php

class images extends MX_Controller
{
    var $roles = 'admin';
    var $mparent = 'images';
    var $offset = 1;
    var $limit = 10;
    var $dtable = 'me_img';

    function __construct()
    {
        parent::__construct();
        $this->load->model('images_model');

        if ($this->session->userdata('login') != TRUE AND $this->session->userdata('user_uid') == '') {
            redirect('login');
        }

        $raccess = $this->library->role_access('member/images');
        if (isset($raccess)) {
            $this->roles = $raccess;
        }
    }

    public function index()
    {
        $data['title'] = 'images';
        $data['parent'] = $this->mparent;
        $data['roles'] = $this->roles;
        $data['content'] = $this->config->item('base_theme') . '/images/images';

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
        $data['dt'] = $this->excurl->reqCurl('me-images', $query)->data;
        $data['count'] = $this->excurl->reqCurl('me-images', array_merge($query, array('count' => true)))->data[0];
        $data['limit'] = $limit;
        $data['offset'] = $this->offset;
        $data['prefix'] = $this->dtable;
        $data['showpage'] = ceil($data['count']->cc / $limit);

        $this->load->view($this->config->item('base_theme') . '/template', $data);
    }

    function view($option = array())
    {
        if ($this->input->post('val') == true) {
            $data['title'] = 'images';
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
                                     'sortBy_' . $this->dtable => 'newjoin', 'sortDir_' . $this->dtable => 'desc');
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

            $data['dt'] =$this->excurl->reqCurl('me-images', $query)->data;
            $data['count'] = $this->excurl->reqCurl('me-images', $count)->data[0];
            $data['limit'] = $limit;
            $data['offset'] = $offset;
            $data['prefix'] = $this->dtable;
            $data['showpage'] = ceil($data['count']->cc / $limit);

            if ($this->input->post('val') > 0 OR isset($option['is_check'])) {
                $html = $this->load->view($this->config->item('base_theme') . '/images/images_jquery', $data, true);
            } else {
                $html = $this->load->view($this->config->item('base_theme') . '/images/images', $data, true);
            }

            header('Content-Type: application/json');

            if ($option) {
                echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable),
                                        'xCss' => $option['xcss'], 'xMsg' => $option['xmsg']));
            } else {
                echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable), 'query' => $query));
            }
        } else {
            redirect('images');
        }
    }

    function search()
    {
        if ($this->input->post('val') == true) {
            $data['title'] = 'images';

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
                $html = $this->load->view($this->config->item('base_theme') . '/images/images_jquery', $data, true);
            } else {
                $html = $this->load->view($this->config->item('base_theme') . '/images/images', $data, true);
            }

            header('Content-Type: application/json');
            echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable)));
        } else {
            redirect('images');
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

            $html = $this->load->view($this->config->item('base_theme') . '/images/images_table', $data, true);

            header('Content-Type: application/json');
            echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable)));
        } else {
            redirect('images');
        }
    }

    function add()
    {
        if ($this->roles == 'admin' OR $this->roles->menu_created == 1) {
            $data['title'] = 'images';
            $data['parent'] = $this->mparent;
            $data['content'] = $this->config->item('base_theme') . '/images/add_images';

            // $data['category'] = $this->excurl->reqCurl('images-category');

            if ($this->input->post('val') == true) {
                $this->load->view($this->config->item('base_theme') . '/images/add_images', $data);
            } else {
                $this->load->view($this->config->item('base_theme') . '/template', $data);
            }
        } else {
            if ($this->input->post('val') == true) {
                $this->library->role_failed();
            } else {
                redirect('images');
            }
        }
    }

    function save()
    {
        if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_created == 1) {
            $option = $this->excurl->reqAction('images/save', array_merge($_POST, array('ses_user_id' => $this->session->userdata('user_id'),'join_date'=> NOW)));
            $this->view(array('xcss' => $option->add_message->xcss, 'xmsg' => $option->message));
        } else {
            redirect('images');
        }
    }

    function edit($id= '')
    {
        if ($this->roles == 'admin' OR $this->roles->menu_updated == 1) {
            if ($id == '') {
                redirect('images');
            } else {
                $data['title'] = 'images';
                $data['parent'] = $this->mparent;
                $data['content'] = $this->config->item('base_theme') . '/images/edit_images';

                $query = array('id_images' => $id, 'detail' => true);
                $ulevel = $this->library->user_check();
                if($ulevel->ff > 0)
                {
                    $query = array_merge($query, array('admin_id' => $this->session->userdata('user_id')));
                }
                $data['dt1'] = $this->excurl->reqCurl('me',$query)->data[0];
                // p($data['dt1']);
                // exit;
                if ($this->input->post('val') == true) {
                    $this->load->view($this->config->item('base_theme') . '/images/edit_images', $data);
                } else {
                    $this->load->view($this->config->item('base_theme') . '/template', $data);
                }
                // p($data['dt1']);
            }
        } else {
            if ($this->input->post('val') == true) {
                $this->library->role_failed();
            } else {
                redirect('images');
            }
        }
    }

    function update()
    {
    
       if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_created == 1) {
            $option = $this->excurl->reqAction('images/update', array_merge($_POST, array('ses_user_id' => $this->session->userdata('user_id'))));
            $this->view(array('xcss' => $option->add_message->xcss, 'xmsg' => $option->message));
        } else {
            redirect('images');
        }
    }

    function delete($id = '')
    {
        if ($this->roles == 'admin' OR $this->roles->menu_deleted == 1) {
            if ($id == '') {
                redirect('images');
            } else {
                // echo '1';
                // exit;
                if ($this->input->post('val') == true) {
                    $option = $this->images_model->__delete($id);

                    $this->view(array('is_check' => true, 'xcss' => $option->add_message->xcss, 'xmsg' => $option->message));
                } else {
                    redirect('images');
                }
            }
        } else {
            if ($this->input->post('val') == true) {
                $this->library->role_failed();
            } else {
                redirect('images');
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
                            $option = $this->images_model->__delete($split[$i]);
                        }
                    } else {
                        $this->library->role_failed();
                    }
                    break;

                case 2:
                    if ($this->roles == 'admin' OR $this->roles->menu_updated == 1) {
                        for ($i = 0; $i < $count; $i++) {
                            $option = $this->images_model->__enable($split[$i]);
                        }
                    } else {
                        $this->library->role_failed();
                    }
                    break;

                case 3:
                    if ($this->roles == 'admin' OR $this->roles->menu_updated == 1) {
                        for ($i = 0; $i < $count; $i++) {
                            $option = $this->images_model->__disable($split[$i]);
                        }
                    } else {
                        $this->library->role_failed();
                    }
                    break;
            }

            $this->view(array('is_check' => true, 'xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
        } else {
            redirect('images');
        }
    }

    function subcategory()
    {
        $search = $this->input->post('val');
        $category = $this->excurl->reqCurl('images-category-sub', ['images_type_id' => $search]);

        if ($category) {
            if ($category->data) {
                foreach ($category->data as $cat) {
                    echo "<option value='$cat->sub_images_id'>$cat->sub_category_name</option>";
                }
            } else {
                echo "<option value=''>- Select -</option>";
            }
        }
    }
    function sess(){
        p($this->session->userdata);
    }
}