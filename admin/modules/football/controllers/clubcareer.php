<?php

class Clubcareer extends MX_Controller
{
    var $roles = 'admin';
    var $mparent = 'Football';
    var $offset = 1;
    var $limit = 10;
    var $dtable = 'eyeprofile_club_career';

    function __construct()
    {
        parent::__construct();
        $this->load->model('club_career_model');

        if ($this->session->userdata('login') != TRUE AND $this->session->userdata('user_uid') == '') {
            redirect('login');
        }

        $raccess = $this->library->role_access('clubcareer');
        if (isset($raccess)) {
            $this->roles = $raccess;
        }
    }

    public function index()
    {
		$data['id'] = $_GET['id'];
        $data['title'] = 'Club Career';
        $data['parent'] = $this->mparent;
        $data['roles'] = $this->roles;
        $data['content'] = $this->config->item('base_theme') . '/clubcareer/clubcareer';

        $session = array('xfield_' . $this->dtable => '', 'xsearch_' . $this->dtable => '', 'sortBy_' . $this->dtable => 'id_club', 'sortDir_' . $this->dtable => 'desc',
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
                'limit' => $limit,
				'id_club' => $data['id']
            );
        } else {
            $query = array(
                'page' => $this->offset,
                'limit' => $limit,
				'id_club' => $data['id']
            );
        }
		$queryclub = array(
			'id_club' => $data['id']
		);
        $ulevel = $this->library->user_check();
        if($ulevel->ff > 0)
        {
            $query = array_merge($query, array($ulevel->fu => $this->session->userdata('user_id')));
        }

        $data['dt'] = $this->excurl->reqCurl('club-career', $query)->data;
		$data['club'] = $this->excurl->reqCurl('profile-club', $queryclub)->data[0];
        $data['count'] = $this->excurl->reqCurl('club-career', array_merge($query, array('count' => true)))->data[0];
        $data['limit'] = $limit;
        $data['offset'] = $this->offset;
        $data['prefix'] = $this->dtable;
        $data['showpage'] = ceil($data['count']->cc / $limit);

        $this->load->view($this->config->item('base_theme') . '/template', $data);
    }

    function view($option = array())
    {
		$data['id'] = $_GET['id'];
        if ($this->input->post('val') == true) {
            $data['title'] = 'Club Career';
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
                                     'sortBy_' . $this->dtable => 'id_club', 'sortDir_' . $this->dtable => 'desc');
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
                    'limit' => $limit,
					'id_club' => $data['id']
                );
            } else {
                $query = array(
                    $xfield => $xsearch,
                    'page' => $offset,
                    'limit' => $limit,
					'id_club' => $data['id']
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
			$queryclub = array(
				'id_club' => $data['id']
			);
            $data['dt'] = $this->excurl->reqCurl('club-career', $query)->data;
			$data['club'] = $this->excurl->reqCurl('profile-club', $queryclub)->data[0];
			$data['count'] = $this->excurl->reqCurl('club-career', array_merge($query, array('count' => true)))->data[0];
            $data['limit'] = $limit;
            $data['offset'] = $offset;
            $data['prefix'] = $this->dtable;
            $data['showpage'] = ceil($data['count']->cc / $limit);

            if ($this->input->post('val') > 0 OR isset($option['is_check'])) {
                $html = $this->load->view($this->config->item('base_theme') . '/clubcareer/clubcareer_jquery', $data, true);
            } else {
                $html = $this->load->view($this->config->item('base_theme') . '/clubcareer/clubcareer', $data, true);
            }

            header('Content-Type: application/json');

            if ($option) {
                echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable),
                                        'xCss' => $option['xcss'], 'xMsg' => $option['xmsg']));
            } else {
                echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable), 'query' => $query));
            }
        } else {
            redirect('clubcareer');
        }
    }

    function search()
    {
		$data['id'] = $_GET['id'];
        if ($this->input->post('val') == true) {
            $data['title'] = 'Club Career';

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
			
			$queryclub = array(
				'id_club' => $data['id']
			);
			
            $data['dt'] = $this->excurl->reqCurl('club-career', $query)->data;
			$data['club'] = $this->excurl->reqCurl('profile-club', $queryclub)->data[0];
            $data['count'] = $this->excurl->reqCurl('club-career', $query['count'])->data[0];
            $data['limit'] = $limit;
            $data['offset'] = $this->offset;
            $data['prefix'] = $this->dtable;
            $data['showpage'] = ceil($data['count']->cc / $query['query']['limit']);

            if (count($split) > 1) {
                $html = $this->load->view($this->config->item('base_theme') . '/clubcareer/clubcareer_jquery', $data, true);
            } else {
                $html = $this->load->view($this->config->item('base_theme') . '/clubcareer/clubcareer', $data, true);
            }

            header('Content-Type: application/json');
            echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable)));
        } else {
            redirect('clubcareer');
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

            $data['dt'] = $this->excurl->reqCurl('profile-club', $query['query'])->data;
            $data['count'] = $this->excurl->reqCurl('profile-club', $query['count'])->data[0];
            $data['offset'] = $query['offset']+1;

            $html = $this->load->view($this->config->item('base_theme') . '/clubcareer/clubcareer_table', $data, true);

            header('Content-Type: application/json');
            echo json_encode(array('vHtml' => $html, 'sortDir' => $this->session->userdata('sortDir_' . $this->dtable)));
        } else {
            redirect('clubcareer');
        }
    }

    function add()
    {
        if ($this->roles == 'admin' OR $this->roles->menu_created == 1) {
            $data['title'] = 'Club Career';
            $data['parent'] = $this->mparent;
            $data['content'] = $this->config->item('base_theme') . '/clubcareer/add_club_career';

            $queryclub = array(
				'id_club' => $_GET['id']
			);
			$data['club'] = $this->excurl->reqCurl('profile-club', $queryclub)->data[0];

            if ($this->input->post('val') == true) {
                $this->load->view($this->config->item('base_theme') . '/clubcareer/add_club_career', $data);
            } else {
                $this->load->view($this->config->item('base_theme') . '/template', $data);
            }
        } else {
            if ($this->input->post('val') == true) {
                $this->library->role_failed();
            } else {
                redirect('clubcareer/view?id='.$_GET['id'].'');
            }
        }
    }

    function save()
    {
		if(isset($_GET['id'])){
			$id = '?id='.$_GET['id'];
		}else{
			$id = '';
		}
        if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_created == 1) {
            $option = $this->excurl->reqAction('football/clubcareer/save'.$id.'', array_merge($_POST, array('ses_user_id' => $this->session->userdata('user_id'))), '');
			// print_r($option);exit();
            $this->view(array('xcss' => $option->add_message->xcss, 'xmsg' => $option->message));
        } else {
            redirect('clubcareer/view?id='.$_GET['id'].'');
        }
    }

    function edit($id = '')
    {
        if ($this->roles == 'admin' OR $this->roles->menu_updated == 1) {
            if ($id == '') {
                redirect('club');
            } else {
                $data['title'] = 'Club';
                $data['parent'] = $this->mparent;
                $data['content'] = $this->config->item('base_theme') . '/clubcareer/edit_clubcareer';
				// $queryclub = array(
					// 'id_club' => $id
				// );
				// $data['club'] = $this->excurl->reqCurl('profile-club', $queryclub)->data[0];

                $query = array('id_career' => $id, 'detail' => true);
                $ulevel = $this->library->user_check();
                if($ulevel->ff > 0)
                {
                    $query = array_merge($query, array('admin_id' => $this->session->userdata('user_id')));
                }

                $data['dt1'] = $this->excurl->reqCurl('club-career', $query)->data[0];
                if ($this->input->post('val') == true) {
                    $this->load->view($this->config->item('base_theme') . '/clubcareer/edit_clubcareer', $data);
                } else {
                    $this->load->view($this->config->item('base_theme') . '/template', $data);
                }
            }
        } else {
            if ($this->input->post('val') == true) {
                $this->library->role_failed();
            } else {
                redirect('clubcareer');
            }
        }
    }

    function update()
    {
        if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_updated == 1) {
            $option = $this->excurl->reqAction('football/clubcareer/update', array_merge($_POST, array('ses_user_id' => $this->session->userdata('user_id'))), '');
            $this->view(array('xcss' => $option->add_message->xcss, 'xmsg' => $option->message));
        } else {
            redirect('clubcareer/view?id='.$_GET['id'].'');
        }
    }

    function delete($id = '')
    {
        if ($this->roles == 'admin' OR $this->roles->menu_deleted == 1) {
            if ($id == '') {
                redirect('clubcareer');
            } else {
                if ($this->input->post('val') == true) {
                    $option = $this->club_career_model->__delete($id);
                    $this->view(array('is_check' => true, 'xcss' => $option->add_message->xcss, 'xmsg' => $option->message));
                } else {
                    redirect('clubcareer');
                }
            }
        } else {
            if ($this->input->post('val') == true) {
                $this->library->role_failed();
            } else {
                redirect('clubcareer');
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
                            $option = $this->club_career_model->__delete($split[$i]);
                        }
                    } else {
                        $this->library->role_failed();
                    }
                    break;

                case 2:
                    if ($this->roles == 'admin' OR $this->roles->menu_updated == 1) {
                        for ($i = 0; $i < $count; $i++) {
                            $option = $this->club_career_model->__enable($split[$i]);
                        }
                    } else {
                        $this->library->role_failed();
                    }
                    break;

                case 3:
                    if ($this->roles == 'admin' OR $this->roles->menu_updated == 1) {
                        for ($i = 0; $i < $count; $i++) {
                            $option = $this->club_career_model->__disable($split[$i]);
                        }
                    } else {
                        $this->library->role_failed();
                    }
                    break;
            }

            $this->view(array('is_check' => true, 'xcss' => $option->add_message->xcss, 'xmsg' => $option->message));
        } else {
            redirect('club');
        }
    }

    function subcompetition()
    {
        $search = explode(';', $this->input->post('val'));
        $category = $this->excurl->reqCurl('league', ['id_competition' => $search[0]]);

        if ($category) {
            if ($category->data) {
                foreach ($category->data as $cat) {
                    echo "<option value='$cat->sub_club_id;$cat->sub_category_name'>$cat->sub_category_name</option>";
                }
            } else {
                echo "<option value=''>- Select -</option>";
            }
        }
    }

    function autoclub($idx = '')
    {
        $search = $this->input->post('val');

        $query = array('page' => 1, 'limit' => '100', 'search' => $search);
        $clubs = $this->excurl->reqCurl('club', $query)->data;

        if($clubs)
        {
            foreach($clubs as $t)
            {
                $bold_search = "<b>$search</b>";
                $title = str_ireplace($search, $bold_search, $t->title);

                echo "<div class='showauto' val='$t->id_club' idx='$idx' tag='club' show='showclub' style='text-transform: capitalize;'>
                        <span class='$t->id_club' val='$t->title'>$title</span>
                    </div>";
            }
        } else {
            echo "<div class='showauto'><span>No Result</span></div>";
        }
    }
	
	function subkabupaten()
    {
        $search = explode(',', $this->input->post('val'));
        $kabupaten = $this->excurl->reqCurl('kabupaten', ['provinsi' => md5($search[23])]);

        if ($kabupaten) {
            if ($kabupaten->data) {
                foreach ($kabupaten->data as $kab) {
                    echo "<option value='$kab->IDKabupaten'>$kab->nama</option>";
                }
            } else {
                echo "<option value=''>- Select -</option>";
            }
        }
    }

}