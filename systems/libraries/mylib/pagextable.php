<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pagextable
{

    var $offset = 0;
    var $limit = 10;

    function __construct()
    {
        $this->ci = &get_instance();
    }

    public function search($opt = array(), $prefix = '')
    {
        //Define $query here
        $split = explode(",", $opt['value']);
        $count = count($split);

        if ($this->ci->session->userdata('limit_' . $prefix) > 0) {
            $limit = $this->ci->session->userdata('limit_' . $prefix);
        } else {
            $limit = $opt['limit'];
        }

        // Search & Sort By
        $xfield = $this->ci->session->userdata('xfield_' . $prefix);
        $xsearch = $this->ci->session->userdata('xsearch_' . $prefix);

        if ($split[1] == 'asc' OR $split[1] == 'desc') {
            $query = array(
                $xfield => $xsearch,
                'sortby' => $split[0],
                'sortdir' => $split[1],
                'page' => $opt['offset'],
                'limit' => $limit
            );

            $session = array('sortBy_' . $prefix => $split[0], 'sortDir_' . $prefix => $split[1]);
            $count = array('count' => true);
        } else {
            $search = $split[1];
            switch ($split[0]) {
                case 'is_active':
                    $search = $this->ci->enum->active_val($split[1]);
                    break;

                case 'is_paid':
                    $search = $this->ci->enum->crstatus_val($split[1]);
                    break;

                case 'user_type':
                    $search = $this->ci->enum->utype_val($split[1]);
                    break;
            }

            // Sort By
            if ($this->ci->session->userdata('sortDir_' . $prefix) == 'asc' OR
                $this->ci->session->userdata('sortDir_' . $prefix) == 'desc'
            ) {
                $query = array(
                    $split[0] => $search,
                    'sortby' => $this->ci->session->userdata('sortBy_' . $prefix),
                    'sortdir' => $this->ci->session->userdata('sortDir_' . $prefix),
                    'page' => $opt['offset'],
                    'limit' => $limit
                );
            } else {
                $query = array(
                    $split[0] => $search,
                    'page' => $opt['offset'],
                    'limit' => $limit
                );
            }

            $session = array('xfield_' . $prefix => $split[0], 'xsearch_' . $prefix => $search);
            $count = array($split[0] => $search, 'count' => true);
        }

        return array('query' => $query, 'count' => $count, 'session' => $session);
    }

    public function pagination($opt = array(), $prefix = '')
    {
        // Limit Page
        if ($this->ci->session->userdata('limit_' . $prefix) > 0) {
            $limit = $this->ci->session->userdata('limit_' . $prefix);
        } else {
            $limit = $opt['limit'];
        }

        // Position Page
        $page = ($opt['value'] > 1) ? $opt['value'] : $opt['offset'];
        if ($opt['value'] > 1) {
            $offset = ($opt['value'] - 1) * $limit;
        } else {
            $offset = $opt['offset'];
        }

        // Offset
        $this->ci->session->set_userdata(array('voffset_' . $prefix => $opt['value'],
                                               'xoffset_' . $prefix => $offset));

        // Search & Sort By
        $xfield = $this->ci->session->userdata('xfield_' . $prefix);
        $xsearch = $this->ci->session->userdata('xsearch_' . $prefix);

        if ($this->ci->session->userdata('sortDir_' . $prefix) == 'asc' OR
            $this->ci->session->userdata('sortDir_' . $prefix) == 'desc'
        ) {
            $query = array(
                $xfield => $xsearch,
                'sortby' => $this->ci->session->userdata('sortBy_' . $prefix),
                'sortdir' => $this->ci->session->userdata('sortDir_' . $prefix),
                'page' => $page,
                'limit' => $limit
            );
        } else {
            $query = array(
                $xfield => $xsearch,
                'page' => $page,
                'limit' => $limit
            );
        }

        $count = array($xfield => $xsearch, 'count' => true);

        return array('query' => $query, 'count' => $count, 'offset' => $offset);
    }
}
