<?php

class Official extends MX_Controller
{
    var $roles = 'admin';
    var $mparent = 'Football';
    var $offset = 1;
    var $limit = 10;
    var $dtable = 'eyeprofile_club_official';

    function __construct()
    {
        parent::__construct();
        $this->load->model('Official_model');

        if ($this->session->userdata('login') != TRUE AND $this->session->userdata('user_uid') == '') {
            redirect('login');
        }

        $raccess = $this->library->role_access('official');
        if (isset($raccess)) {
            $this->roles = $raccess;
        }
    }

    public function index()
    {
        $data['title'] = 'official';
        $data['parent'] = $this->mparent;
        $data['roles'] = $this->roles;
        $data['content'] = $this->config->item('base_theme') . '/official/official';

        $id = 'id_official';
        $session = array('xfield_' . $this->dtable => '', 'xsearch_' . $this->dtable => '', 'sortBy_' . $this->dtable => $id, 'sortDir_' . $this->dtable => 'desc',
                         'multi_search_' . $this->dtable => '', 'multi_data_' . $this->dtable => '', 'voffset_' . $this->dtable => '', 'xoffset_' . $this->dtable => '');
        $this->session->set_userdata($session);

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

        $data['dt'] = $this->excurl->reqCurl('profile-official', $query)->data;
        $data['count'] = $this->excurl->reqCurl('profile-official', array_merge($query, array('count' => true)))->data[0];

        $data['limit'] = $limit;
        $data['offset'] = $this->offset;
        $data['prefix'] = $this->dtable;
        $data['showpage'] = ceil($data['count']->cc / $limit);

        $this->load->view($this->config->item('base_theme') . '/template', $data);
    }

    function view($option = array())
    {
        if ($this->input->post('val') == true) {
        $data['title'] = 'Official';
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
                                 'sortBy_' . $this->dtable => 'id_official', 'sortDir_' . $this->dtable => 'desc');
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

        $data['dt'] = $this->excurl->reqCurl('profile-official', $query)->data;
        $data['count'] = $this->excurl->reqCurl('profile-official', $count)->data[0];
        $data['limit'] = $limit;
        $data['offset'] = $offset;
        $data['prefix'] = $this->dtable;
        $data['showpage'] = ceil($data['count']->cc / $limit);

        if ($this->input->post('val') > 0 OR isset($option['is_check'])) {
            $html = $this->load->view($this->config->item('base_theme') . '/official/official_jquery', $data, true);
        } else {
            $html = $this->load->view($this->config->item('base_theme') . '/official/official', $data, true);
        }

        header('Content-Type: application/json');

        if ($option) {
            echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable),
                                    'xCss' => $option['xcss'], 'xMsg' => $option['xmsg']));
        } else {
            echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable), 'query' => $query));
        }
    } else {
        redirect('football/official');
    }
    }

    function search()
    {
        if ($this->input->post('val') == true) {
            $data['title'] = 'Official';

            $split = explode(",", $this->input->post('val'));

            if ($this->session->userdata('limit_' . $this->dtable) > 0) {
                $limit = $this->session->userdata('limit_' . $this->dtable);
            } else {
                $limit = $this->limit;
            }

            if (count($split) > 1) {
                $opt = array('offset' => $this->offset, 'limit' => $this->limit, 'value' => $this->input->post('val'));

                $query = $this->pagextable->search($opt, $this->dtable);

                $session = array_merge($query['session'], array('multi_search_' . $this->dtable => '', 'multi_data_' . $this->dtable => '', 'voffset_' . $this->dtable => '', 'xoffset_' . $this->dtable => ''));
            } else {
                $session = array('multi_search_' . $this->dtable => true,
                                    'multi_data_' . $this->dtable => array(),
                                    'voffset_' . $this->dtable => '',
                                    'xoffset_' . $this->dtable => '');
                $query = array('query' => array_merge($session['multi_data_' . $this->dtable],
                                array('page' => $this->offset,
                                        'limit' => $limit,
                                        'sortby' => $this->session->userdata('sortBy_' . $this->dtable),
                                        'sortdir' => $this->session->userdata('sortDir_' . $this->dtable))),
                                'count' => array_merge($session['multi_data_' . $this->dtable], array('count' => true)));
            }

            if (isset($session)) {
                $this->session->set_userdata($session);
            }

            $data['dt'] = $this->excurl->reqCurl('profile-official', $query['query'])->data;
            $data['count'] = $this->excurl->reqCurl('profile-official', $query['count'])->data[0];

            $data['limit'] = $limit;
            $data['offset'] = $this->offset;
            $data['prefix'] = $this->dtable;
            $data['showpage'] = ceil($data['count']->cc / $query['query']['limit']);

            if (count($split) > 1) {
                $html = $this->load->view($this->config->item('base_theme') . '/official/official_jquery', $data, true);
            } else {
                $html = $this->load->view($this->config->item('base_theme') . '/official/official', $data, true);
            }

            header('Content-Type: application/json');
            echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable)));
        } else {
            redirect('football/official');
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

            if (isset($_GET['id'])) {
                $query['query'] = array_merge($query['query'], array('id_official' => $_GET['id']));
                $query['count'] = array_merge($query['count'], array('id_official' => $_GET['id']));
                $data['sub'] = $this->excurl->reqCurl('official', ['id_official' => $_GET['id']])->data[0];

                $data['dt'] = $this->excurl->reqCurl('official-sub', $query['query'])->data;
                $data['count'] = $this->excurl->reqCurl('official-sub', $query['count'])->data[0];
            } else {
                $data['dt'] = $this->excurl->reqCurl('official', $query['query'])->data;
                $data['count'] = $this->excurl->reqCurl('official', $query['count'])->data[0];
            }

            $data['offset'] = $query['offset']+1;

            $html = $this->load->view($this->config->item('base_theme') . '/official/official_table', $data, true);

            header('Content-Type: application/json');
            echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable)));
        } else {
            redirect('football/official');
        }
    }

    function add()
    {
        if ($this->roles == 'admin' OR $this->roles->menu_created == 1) {
            $data['title'] = 'official';
            $data['parent'] = $this->mparent;
            $data['content'] = $this->config->item('base_theme') . '/official/add_official';

            if (isset($_GET['id'])) {
                $data['sub'] = $this->excurl->reqCurl('official', ['id_official' => $_GET['id']])->data[0];
            }

            if ($this->input->post('val') == true) {
                $this->load->view($this->config->item('base_theme') . '/official/add_official', $data);
            } else {
                $this->load->view($this->config->item('base_theme') . '/template', $data);
            }
        } else {
            if ($this->input->post('val') == true) {
                $this->library->role_failed();
            } else {
                redirect('football/official');
            }
        }
    }

    function save()
    {
        if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_created == 1) {
            $option = $this->excurl->reqAction('football/official/save', array_merge($_POST, array('ses_user_id' => $this->session->userdata('user_id'))), ['uploadfile']);
        
            $this->view(array('xcss' => $option->add_message->xcss, 'xmsg' => $option->message));
        } else {
            redirect('football/official');
        }
    }

    function edit($id = '')
    {
        if ($this->roles == 'admin' OR $this->roles->menu_updated == 1) {
            if ($id == '') {
                redirect('football/official');
            } else {
                $data['title'] = 'official';
                $data['parent'] = $this->mparent;
                $data['content'] = $this->config->item('base_theme') . '/official/edit_official';


                if (isset($_GET['id'])) {
                    $data['sub'] = $this->excurl->reqCurl('official', ['id_official' => $_GET['id']])->data[0];
                    $data['dt1'] = $this->excurl->reqCurl('league', ['id_league' => $id])->data[0];
                } else {
                    $data['dt1'] = $this->excurl->reqCurl('official', ['id_official' => $id])->data[0];
                }

                if ($this->input->post('val') == true) {
                    $this->load->view($this->config->item('base_theme') . '/official/edit_official', $data);
                } else {
                    $this->load->view($this->config->item('base_theme') . '/template', $data);
                }
            }
        } else {
            if ($this->input->post('val') == true) {
                $this->library->role_failed();
            } else {
                redirect('football/official');
            }
        }
    }

    function update()
    {
        if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_updated == 1) {

            $text_title = $this->input->post('title');

            $new_link = $this->library->seo_title($text_title);
            $key = substr(md5($this->library->app_key()), 0, 7);

            // official
            if (isset($_GET['id'])) {
                $dt1 = array('id_official' => $_GET['id'], 'league' => addslashes($text_title));
            } else {
                $dt1 = array('official' => addslashes($text_title));
            }

            $table = $this->dtable;
            $where = (isset($_GET['id'])) ? ['id_official' => $this->input->post('idx')] : ['id_official' => $this->input->post('idx')];
            $option = $this->action->update(array('table' => $table, 'update' => $dt1, 'where' => $where));
            if ($option['state'] == 0) {
                $this->validation->error_message($option);
                return false;
            }

            $this->view(array('xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
        } else {
            redirect('football/official');
        }
    }

    function delete($id = '')
    {
        if ($this->roles == 'admin' OR $this->roles->menu_deleted == 1) {
            if ($id == '') {
                redirect('football/official');
            } else {
                if ($this->input->post('val') == true) {
                    $option = $this->Official_model->__delete($id);
                    $this->view(array('is_check' => true, 'xcss' => $option->add_message->xcss, 'xmsg' => $option->message));
                } else {
                    redirect('football/official');
                }
            }
        } else {
            if ($this->input->post('val') == true) {
                $this->library->role_failed();
            } else {
                redirect('football/official');
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
                            $option = $this->Official_model->__delete($split[$i]);
                        }
                    } else {
                        $this->library->role_failed();
                    }
                    break;

                case 2:
                    if ($this->roles == 'admin' OR $this->roles->menu_updated == 1) {
                        for ($i = 0; $i < $count; $i++) {
                            $option = $this->Official_model->__enable($split[$i]);
                        }
                    } else {
                        $this->library->role_failed();
                    }
                    break;

                case 3:
                    if ($this->roles == 'admin' OR $this->roles->menu_updated == 1) {
                        for ($i = 0; $i < $count; $i++) {
                            $option = $this->Official_model->__disable($split[$i]);
                        }
                    } else {
                        $this->library->role_failed();
                    }
                    break;
            }

            $this->view(array('is_check' => true, 'xcss' => $option->add_message->xcss, 'xmsg' => $option->message));
        } else {
            redirect('football/official');
        }
    }

    function autoteam($idx = '')
    {
        $search = $this->input->post('val');

        $query = array('page' => 1, 'limit' => '100', 'search' => $search);
        $clubs = $this->excurl->reqCurl('profile-club', $query)->data;

        $tag = 'team_a';

        if($clubs)
        {
            foreach($clubs as $t)
            {
                $bold_search = "<b>$search</b>";
                $team_name = str_ireplace($search, $bold_search, $t->name);

                echo "<div class='showauto' val='$t->id_club' idx='$idx' tag='$tag' style='text-transform: capitalize;'>
                        <span class='$t->id_club' val='$t->name'>$team_name</span>
                    </div>";
            }
        }
        else
        {
            echo "<div class='showauto'><span>No Result</span></div>";
        }
    }

}