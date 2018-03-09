<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Catalog
{

    var $query_string = '';
    var $command = '';
    var $vlink = '';

    function __construct()
    {
        $this->ci = &get_instance();
        $this->vlink = $this->ci->config->item('aes_vlink');
    }

    function seo_title($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    function set_search($options = array(), $query = 'AND')
    {
        if (isset($options['is_search'])) {
            $i = 0;
            $search = '';
            foreach ($options as $nm => $val) {
                $x = 1;
                switch ($nm) {
                    case 'iso_code':
                    case 'tag_id':
                    case 'tag_slug':
                    case 'tag_names':
                    case 'category_id':
                    case 'category_slug':
                    case 'category_names':
                    case 'brand_id':
                    case 'brand_slug':
                    case 'brand_names':
                    case 'feature_id':
                    case 'feature_slug':
                    case 'feature_names':
                    case 'data':
                    case 'is_profile':
                    case 'is_picture':
                    case 'is_detail':
                    case 'is_display':
                    case 'is_search':
                    case 'is_count':
                    case 'is_delete':
                    case 'is_active':
                    case 'lang_code':
                    case 'groupBy':
                    case 'sortBy':
                    case 'sortDir':
                    case 'sortHirarchy':
                    case 'limit':
                    case 'offset':
                    case 'row':
                        $x = 0;
                        break;
                }

                if ($x > 0) {
                    if ($nm != '' AND $val != '') {
                        if ($i > 0) {
                            $search .= ' OR ' . $nm . ' LIKE "%' . $val . '%"';
                        } else {
                            $search .= ' ' . $query . ' (' . $nm . ' LIKE "%' . $val . '%"';
                        }

                        $i++;
                    }
                }
            }

            if ($search != '') {
                $search .= ')';
            }

            return $search;
        }
    }

    function set_users($options = array())
    {
        $filter = ' LEFT JOIN ' . $options['data_table'] . ' ss ON ss.' . $options['data_id'] . '=a.' . $options['data_id'] . '';
        if ($this->ci->session->userdata('user_level') == 'member') {
            $filter .= ' LEFT JOIN ' . $this->vlink . '.we_users m1 ON m1.user_id=ss.member_id';
        }

        if ($this->ci->session->userdata('user_level') == 'merchant') {
            $filter .= ' LEFT JOIN ' . $this->vlink . '.we_merchant m2 ON m2.user_id=ss.merchant_id';
        }

        return $filter;
    }

    function set_users_table($options = array())
    {
        $filter = '';
        if ($this->ci->session->userdata('user_level') != '') {
            switch ($this->ci->session->userdata('user_level')) {
                case 'member':
                case 'merchant':
                    $filter = $this->set_users(array('data_table' => $options['data_table'], 'data_id' => $options['data_id']));
                    break;
            }
        }

        return $filter;
    }

    function set_users_data($as = 'ss')
    {
        $filter = '';
        if ($this->ci->session->userdata('user_level') != '') {
            switch ($this->ci->session->userdata('user_level')) {
                case 'member':
                    $filter = ' AND ' . $as . '.member_id=' . $this->ci->session->userdata('user_id');
                    break;
                case 'merchant':
                    $filter = ' AND ' . $as . '.merchant_id=' . $this->ci->session->userdata('user_id');
                    break;
            }
        }

        return $filter;
    }

    function set_users_level($as = '')
    {
        $filter = '';
        $ulevel = $this->ci->library->user_check();
        if ($ulevel->ff == 0) {
            $filter = ' AND ' . $as . '.is_level=1';
        }

        return $filter;
    }

    function set_date($options = array(), $fielddate = 'created_at', $as = 'a')
    {
        $query = '';

        if (isset($options[$fielddate])) {
            if (isset($options['set_date'])) {
                switch ($options['set_date']) {
                    default:
                        $query .= ' AND DATE(' . $as . '.' . $fielddate . ')="' . $options[$fielddate] . '"';
                        break;
                    case 'month':
                        $query .= ' AND LEFT(' . $as . '.' . $fielddate . ', 7)="' . $options[$fielddate] . '"';
                        break;
                    case 'year':
                        $query .= ' AND LEFT(' . $as . '.' . $fielddate . ', 4)="' . $options[$fielddate] . '"';
                        break;
                }
            } else {
                $query .= ' AND DATE(' . $as . '.' . $fielddate . ') BETWEEN "' . $options['start_date'] . '" AND "' . $options['end_date'] . '"';
            }
        }

        return $query;
    }

    /*-- User --*/

    function get_user($options = array())
    {
        if (isset($options['is_count'])) {
            $this->query_string = 'SELECT COUNT(user_id) as cc';
        } else {
            $this->query_string = 'SELECT user_id';
            $this->query_string .= ',user_name';
            $this->query_string .= ',user_fname';
            $this->query_string .= ',user_self';
            $this->query_string .= ',user_email';
            $this->query_string .= ',user_mobile';
            $this->query_string .= ',user_level';
            $this->query_string .= ',user_pic';
            $this->query_string .= ',is_active';
        }
        $this->query_string .= ' FROM es_users WHERE user_id IS NOT NULL';

        if (isset($options['user_id'])) {
            $this->query_string .= ' AND user_id="' . $options['user_id'] . '"';
        }

        if (isset($options['user_name'])) {
            $this->query_string .= ' AND user_name LIKE "%' . $options['user_name'] . '%"';
        }

        if (isset($options['user_fname'])) {
            $this->query_string .= ' AND user_fname LIKE "%' . $options['user_fname'] . '%"';
        }

        if (isset($options['user_email'])) {
            $this->query_string .= ' AND user_email LIKE "%' . $options['user_email'] . '%"';
        }

        if (isset($options['user_mobile'])) {
            $this->query_string .= ' AND user_mobile LIKE "%' . $options['user_mobile'] . '%"';
        }

        if (isset($options['user_level'])) {
            $this->query_string .= ' AND user_level LIKE "%' . $options['user_level'] . '%"';
        }

        if (isset($options['is_active'])) {
            $this->query_string .= ' AND is_active LIKE "%' . $options['is_active'] . '%"';
        }

        if (isset($options['sortBy']) && isset($options['sortDir'])) {
            $this->query_string .= ' ORDER BY ' . $options['sortBy'] . ' ' . $options['sortDir'];
        }

        if (isset($options['limit']) && isset($options['offset'])) {
            $this->query_string .= ' LIMIT ' . $options['offset'] . ',' . $options['limit'];
        } else if (isset($options['limit'])) {
            $this->query_string .= ' LIMIT ' . $options['limit'];
        }

        try {
            $this->command = $this->ci->db->query($this->query_string);
        } catch (Exception $e) {
            return FALSE;
        }

        if (isset($options['count'])) {
            return $this->command->num_rows();
        }

        if (isset($options['row'])) {
            return $this->command->row();
        } else {
            return $this->command->result();
        }
    }

    /*-- Language --*/

    function get_language($options = array())
    {
        if (isset($options['is_delete'])) {
            $is_delete = $options['is_delete'];
        } else {
            $is_delete = 'no';
        }

        if (isset($options['is_count'])) {
            $this->query_string = 'SELECT COUNT(language_id) as cc';
        } else {
            $this->query_string = 'SELECT language_id';
            $this->query_string .= ',language_name';
            $this->query_string .= ',lang_code';
            $this->query_string .= ',is_active';
            $this->query_string .= ',is_default';
        }
        $this->query_string .= ' FROM es_language WHERE language_id IS NOT NULL AND LCASE(is_delete)="' . $is_delete . '"';

        if (isset($options['language_id'])) {
            $this->query_string .= ' AND language_id="' . $options['language_id'] . '"';
        }

        if (isset($options['language_name'])) {
            $this->query_string .= ' AND language_name LIKE "%' . $options['language_name'] . '%"';
        }

        if (isset($options['lang_code'])) {
            $this->query_string .= ' AND lang_code LIKE "%' . $options['lang_code'] . '%"';
        }

        if (isset($options['is_active'])) {
            $this->query_string .= ' AND is_active="' . $options['is_active'] . '"';
        }

        if (isset($options['is_default'])) {
            $this->query_string .= ' AND is_default="' . $options['is_default'] . '"';
        }

        if (isset($options['sortBy']) && isset($options['sortDir'])) {
            $this->query_string .= ' ORDER BY ' . $options['sortBy'] . ' ' . $options['sortDir'];
        }

        if (isset($options['limit']) && isset($options['offset'])) {
            $this->query_string .= ' LIMIT ' . $options['offset'] . ',' . $options['limit'];
        } else if (isset($options['limit'])) {
            $this->query_string .= ' LIMIT ' . $options['limit'];
        }

        try {
            $this->command = $this->ci->db->query($this->query_string);
        } catch (Exception $e) {
            return FALSE;
        }

        if (isset($options['count'])) {
            return $this->command->num_rows();
        }

        if (isset($options['row'])) {
            return $this->command->row();
        } else {
            return $this->command->result();
        }
    }

    /*-- Translation --*/

    function get_translation($options = array())
    {
        if (isset($options['is_count'])) {
            $this->query_string = 'SELECT COUNT(translation_id) as cc';
        } else {
            $this->query_string = 'SELECT translation_id';
            $this->query_string .= ',element_type';
            $this->query_string .= ',element_id';
            $this->query_string .= ',lang_code';
            $this->query_string .= ',text_tag';
            $this->query_string .= ',REPLACE(text_title, "~", "' . "'" . '") AS text_title';
            $this->query_string .= ',text_title_seo';
            $this->query_string .= ',REPLACE(text_desc, "~", "' . "'" . '") AS text_desc';
            $this->query_string .= ',text_url';
        }
        $this->query_string .= ' FROM es_translation WHERE translation_id IS NOT NULL';

        if (isset($options['translation_id'])) {
            $this->query_string .= ' AND translation_id="' . $options['translation_id'] . '"';
        }

        if (isset($options['element_type'])) {
            $this->query_string .= ' AND element_type="' . $options['element_type'] . '"';
        }

        if (isset($options['element_id'])) {
            $this->query_string .= ' AND element_id="' . $options['element_id'] . '"';
        }

        if (isset($options['lang_code'])) {
            $this->query_string .= ' AND lang_code="' . $options['lang_code'] . '"';
        }

        if (isset($options['text_title'])) {
            $this->query_string .= ' AND text_title LIKE "%' . $options['text_title'] . '%"';
        }

        if (isset($options['link_seo'])) {
            $this->query_string .= ' AND text_title_seo="' . $options['link_seo'] . '"';
        }

        if (isset($options['text_title_seo'])) {
            $this->query_string .= ' AND text_title_seo LIKE "%' . $options['text_title_seo'] . '%"';
        }

        if (isset($options['sortBy']) && isset($options['sortDir'])) {
            $this->query_string .= ' ORDER BY ' . $options['sortBy'] . ' ' . $options['sortDir'];
        }

        if (isset($options['limit']) && isset($options['offset'])) {
            $this->query_string .= ' LIMIT ' . $options['offset'] . ',' . $options['limit'];
        } else if (isset($options['limit'])) {
            $this->query_string .= ' LIMIT ' . $options['limit'];
        }

        try {
            $this->command = $this->ci->db->query($this->query_string);
        } catch (Exception $e) {
            return FALSE;
        }

        if (isset($options['count'])) {
            return $this->command->num_rows();
        }

        if (isset($options['row'])) {
            return $this->command->row();
        } else {
            return $this->command->result();
        }
    }

    /*-- Setting Web --*/

    function get_setting($options = array())
    {
        $this->query_string = 'SELECT setting_id';
        $this->query_string .= ',web_name';
        $this->query_string .= ',web_tagline';
        $this->query_string .= ',web_keyword';
        $this->query_string .= ',web_desc';
        $this->query_string .= ',web_mail_invoice';
        $this->query_string .= ',web_mail_contact';
        $this->query_string .= ',web_mail_noreply';
        $this->query_string .= ',web_contact';
        $this->query_string .= ',web_address';
        $this->query_string .= ',web_logo';
        $this->query_string .= ',web_favicon';
        $this->query_string .= ',post_home';
        $this->query_string .= ',post_category';
        $this->query_string .= ',google_captcha';
        $this->query_string .= ',google_verify';
        $this->query_string .= ',google_analytics';
        $this->query_string .= ',google_maps';
        $this->query_string .= ',social_api';
        $this->query_string .= ',text_code';
        $this->query_string .= ',text_notif';
        $this->query_string .= ',express_set';

        if (empty($options['is_set'])) {
            $this->query_string .= ',smtp_host';
            $this->query_string .= ',smtp_port';
            $this->query_string .= ',smtp_user';
            $this->query_string .= ',smtp_pass';
        }

        $this->query_string .= ' FROM es_setting WHERE setting_id IS NOT NULL';

        if (isset($options['setting_id'])) {
            $this->query_string .= ' AND setting_id="' . $options['setting_id'] . '"';
        }

        if (isset($options['sortBy']) && isset($options['sortDir'])) {
            $this->query_string .= ' ORDER BY ' . $options['sortBy'] . ' ' . $options['sortDir'];
        }

        if (isset($options['limit']) && isset($options['offset'])) {
            $this->query_string .= ' LIMIT ' . $options['offset'] . ',' . $options['limit'];
        } else if (isset($options['limit'])) {
            $this->query_string .= ' LIMIT ' . $options['limit'];
        }

        try {
            $this->command = $this->ci->db->query($this->query_string);
        } catch (Exception $e) {
            return FALSE;
        }

        if (isset($options['count'])) {
            return $this->command->num_rows();
        }

        if (isset($options['row'])) {
            return $this->command->row();
        } else {
            return $this->command->result();
        }
    }

    /*-- Notification --*/

    function get_notif($options = array())
    {
        if (isset($options['is_count'])) {
            $this->query_string = 'SELECT COUNT(notif_id) as cc';
        } else {
            $this->query_string = 'SELECT notif_id';
            $this->query_string .= ',REPLACE(notif_name, "~", "' . "'" . '") AS notif_name';
            $this->query_string .= ',REPLACE(notif_desc, "~", "' . "'" . '") AS notif_desc';
            $this->query_string .= ',notif_type';

            if (isset($options['lang_code'])) {
                $this->query_string .= ',IF(text_title != "", REPLACE(text_title, "~", "' . "'" . '"), notif_name) AS text_title';
                $this->query_string .= ',IF(text_desc != "", REPLACE(text_desc, "~", "' . "'" . '"), notif_desc) AS text_desc';
                $this->query_string .= ',lang_code';
            }
        }
        $this->query_string .= ' FROM es_notif a';

        if (isset($options['link_seo']) OR isset($options['lang_code'])) {
            $this->query_string .= ' LEFT JOIN es_translation b ON b.element_id=a.notif_id';
            $this->query_string .= ' AND element_type="notif_notif"';
            $this->query_string .= ' AND lang_code="' . $options['lang_code'] . '"';
        }

        $this->query_string .= ' WHERE notif_id IS NOT NULL';

        if (isset($options['notif_id'])) {
            $this->query_string .= ' AND notif_id="' . $options['notif_id'] . '"';
        }

        if (isset($options['notif_name'])) {
            $this->query_string .= ' AND notif_name LIKE "%' . $options['notif_name'] . '%"';
        }

        if (isset($options['notif_type'])) {
            $this->query_string .= ' AND notif_type LIKE "%' . $options['notif_type'] . '%"';
        }

        if (isset($options['link_seo'])) {
            $this->query_string .= ' AND notif_name_seo="' . $options['link_seo'] . '"';
            $this->query_string .= ' OR text_title_seo="' . $options['link_seo'] . '"';
        }

        if (isset($options['text_title_seo'])) {
            $this->query_string .= ' AND notif_name_seo LIKE "%' . $options['text_title_seo'] . '%"';
            $this->query_string .= ' OR text_title_seo LIKE "%' . $options['text_title_seo'] . '%"';
        }

        if (isset($options['text_title'])) {
            $this->query_string .= ' AND notif_name LIKE "%' . $options['text_title'] . '%"';
            $this->query_string .= ' OR text_title LIKE "%' . $options['text_title'] . '%"';
        }

        if (isset($options['text_desc'])) {
            $this->query_string .= ' AND text_desc LIKE "%' . $options['text_desc'] . '%"';
        }

        if (isset($options['sortBy']) && isset($options['sortDir'])) {
            $this->query_string .= ' ORDER BY ' . $options['sortBy'] . ' ' . $options['sortDir'];
        }

        if (isset($options['limit']) && isset($options['offset'])) {
            $this->query_string .= ' LIMIT ' . $options['offset'] . ',' . $options['limit'];
        } else if (isset($options['limit'])) {
            $this->query_string .= ' LIMIT ' . $options['limit'];
        }

        try {
            $this->command = $this->ci->db->query($this->query_string);
        } catch (Exception $e) {
            return FALSE;
        }

        if (isset($options['count'])) {
            return $this->command->num_rows();
        }

        if (isset($options['row'])) {
            return $this->command->row();
        } else {
            return $this->command->result();
        }
    }

    /*-- Role Menus --*/

    function get_menu($options = array())
    {
        if (isset($options['is_count'])) {
            $this->query_string = 'SELECT COUNT(a.menu_id) as cc';
        } else {
            $this->query_string = 'SELECT a.menu_id';
            $this->query_string .= ',menu_name';
            $this->query_string .= ',menu_url';
            $this->query_string .= ',menu_parent';
            $this->query_string .= ',menu_order';
            $this->query_string .= ',menu_icon';
            $this->query_string .= ',is_active';
            $this->query_string .= ',IF(menu_parent=0,CONCAT(a.menu_id,".0"),CONCAT(menu_parent,".",a.menu_id)) AS parent';

            if (isset($options['menu_access'])) {
                $this->query_string .= ',menu_access';
                $this->query_string .= ',menu_created';
                $this->query_string .= ',menu_updated';
                $this->query_string .= ',menu_deleted';
            }
        }
        $this->query_string .= ' FROM es_menu a';

        if (isset($options['menu_access'])) {
            $this->query_string .= ' LEFT JOIN es_menu_access b ON b.menu_id = a.menu_id';
            if (isset($options['role_id'])) {
                $this->query_string .= ' AND b.role_id="' . $options['role_id'] . '"';
            }
        }

        if (isset($options['user_level'])) {
            $this->query_string .= ' RIGHT JOIN es_menu_access b ON b.menu_id = a.menu_id';
            $this->query_string .= ' AND b.role_id = (SELECT role_id FROM es_menu_roles WHERE role_slug="' . $options['user_level'] . '")';
            $this->query_string .= ' AND b.menu_access = 1';
        }

        $this->query_string .= ' WHERE a.menu_id IS NOT NULL';

        if (isset($options['a.menu_id'])) {
            if (isset($options['is_multi'])) {
                $this->query_string .= ' AND a.menu_id IN (' . $options['a.menu_id'] . ')';
            } else {
                $this->query_string .= ' AND a.menu_id="' . $options['a.menu_id'] . '"';
            }
        }

        if (isset($options['menu_parent'])) {
            $this->query_string .= ' AND menu_parent="' . $options['menu_parent'] . '"';
        }

        if (isset($options['is_active'])) {
            $this->query_string .= ' AND is_active="' . $options['is_active'] . '"';
        }

        if (isset($options['sortBy']) && isset($options['sortDir'])) {
            $this->query_string .= ' ORDER BY ' . $options['sortBy'] . ' ' . $options['sortDir'];
        }

        if (isset($options['limit']) && isset($options['offset'])) {
            $this->query_string .= ' LIMIT ' . $options['offset'] . ',' . $options['limit'];
        } else if (isset($options['limit'])) {
            $this->query_string .= ' LIMIT ' . $options['limit'];
        }

        try {
            $this->command = $this->ci->db->query($this->query_string);
        } catch (Exception $e) {
            return FALSE;
        }

        if (isset($options['count'])) {
            return $this->command->num_rows();
        }

        if (isset($options['row'])) {
            return $this->command->row();
        } else {
            return $this->command->result();
        }
    }

    function get_menu_access($options = array())
    {
        if (isset($options['is_count'])) {
            $this->query_string = 'SELECT COUNT(menu_id) as cc';
        } else {
            $this->query_string = 'SELECT role_id';
            $this->query_string .= ',menu_id';
            $this->query_string .= ',menu_access';
            $this->query_string .= ',menu_created';
            $this->query_string .= ',menu_updated';
            $this->query_string .= ',menu_deleted';
        }
        $this->query_string .= ' FROM es_menu_access WHERE role_id IS NOT NULL';

        if (isset($options['role_id'])) {
            $this->query_string .= ' AND role_id="' . $options['role_id'] . '"';
        }

        if (isset($options['menu_id'])) {
            $this->query_string .= ' AND menu_id="' . $options['menu_id'] . '"';
        }

        if (isset($options['user_level'])) {
            $this->query_string .= ' AND role_id = (SELECT role_id FROM es_menu_roles WHERE role_slug="' . $options['user_level'] . '")';
        }

        if (isset($options['menu_url'])) {
            $this->query_string .= ' AND menu_id = (SELECT menu_id FROM es_menu WHERE menu_url="' . $options['menu_url'] . '")';
        }

        if (isset($options['sortBy']) && isset($options['sortDir'])) {
            $this->query_string .= ' ORDER BY ' . $options['sortBy'] . ' ' . $options['sortDir'];
        }

        if (isset($options['limit']) && isset($options['offset'])) {
            $this->query_string .= ' LIMIT ' . $options['offset'] . ',' . $options['limit'];
        } else if (isset($options['limit'])) {
            $this->query_string .= ' LIMIT ' . $options['limit'];
        }

        try {
            $this->command = $this->ci->db->query($this->query_string);
        } catch (Exception $e) {
            return FALSE;
        }

        if (isset($options['count'])) {
            return $this->command->num_rows();
        }

        if (isset($options['row'])) {
            return $this->command->row();
        } else {
            return $this->command->result();
        }
    }

    function get_menu_roles($options = array())
    {
        if (isset($options['is_count'])) {
            $this->query_string = 'SELECT COUNT(role_id) as cc';
        } else {
            $this->query_string = 'SELECT role_id';
            $this->query_string .= ',role_name';
            $this->query_string .= ',role_slug';
        }
        $this->query_string .= ' FROM es_menu_roles WHERE role_id IS NOT NULL';

        if (isset($options['role_id'])) {
            if (isset($options['is_multi'])) {
                $this->query_string .= ' AND role_id IN (' . $options['role_id'] . ')';
            } else {
                $this->query_string .= ' AND role_id="' . $options['role_id'] . '"';
            }
        }

        if (isset($options['role_name'])) {
            $this->query_string .= ' AND role_name LIKE "%' . $options['role_name'] . '%"';
        }

        if (isset($options['sortBy']) && isset($options['sortDir'])) {
            $this->query_string .= ' ORDER BY ' . $options['sortBy'] . ' ' . $options['sortDir'];
        }

        if (isset($options['limit']) && isset($options['offset'])) {
            $this->query_string .= ' LIMIT ' . $options['offset'] . ',' . $options['limit'];
        } else if (isset($options['limit'])) {
            $this->query_string .= ' LIMIT ' . $options['limit'];
        }

        try {
            $this->command = $this->ci->db->query($this->query_string);
        } catch (Exception $e) {
            return FALSE;
        }

        if (isset($options['count'])) {
            return $this->command->num_rows();
        }

        if (isset($options['row'])) {
            return $this->command->row();
        } else {
            return $this->command->result();
        }
    }

    /*-- Statistic --*/

    function get_stats($options = array())
    {
        $this->query_string = 'SELECT stat_ip';
        $this->query_string .= ',stat_hits';
        $this->query_string .= ',stat_link';
        $this->query_string .= ',stat_online';
        $this->query_string .= ',stat_indate';
        $this->query_string .= ',stat_update';

        if (isset($options['visitor'])) {
            $this->query_string .= ',COUNT(stat_hits) as visitor';
        }

        if (isset($options['hits'])) {
            $this->query_string .= ',SUM(stat_hits) as hits';
        }

        $this->query_string .= ' FROM es_statistic WHERE stat_ip IS NOT NULL';

        if (isset($options['stat_ip'])) {
            $this->query_string .= ' AND stat_ip="' . $options['stat_ip'] . '"';
        }

        if (isset($options['mulai']) AND isset($options['akhir'])) {
            $this->query_string .= ' AND (DATE(stat_indate) BETWEEN "' . $options['mulai'] . '" AND "' . $options['akhir'] . '")';
        }

        if (isset($options['stat_indate'])) {
            $this->query_string .= ' AND DATE(stat_indate)="' . $options['stat_indate'] . '"';
        }

        if (isset($options['stat_hits'])) {
            switch ($options['set_date']) {
                default:
                    $this->query_string .= ' AND DATE(stat_indate)="' . $options['stat_hits'] . '"';
                    break;
                case 'month':
                    $this->query_string .= ' AND LEFT(stat_indate, 7)="' . $options['stat_hits'] . '"';
                    break;
                case 'year':
                    $this->query_string .= ' AND LEFT(stat_indate, 4)="' . $options['stat_hits'] . '"';
                    break;
            }
        }

        if (isset($options['stat_link'])) {
            if (isset($options['is_hits'])) {
                $this->query_string .= ' AND stat_link="' . $options['stat_link'] . '"';
            } else {
                $this->query_string .= ' AND stat_link LIKE "%' . $options['stat_link'] . '%"';
            }
        }

        if (isset($options['groupBy'])) {
            $this->query_string .= ' GROUP BY ' . $options['groupBy'];
        }

        if (isset($options['sortBy']) && isset($options['sortDir'])) {
            $this->query_string .= ' ORDER BY ' . $options['sortBy'] . ' ' . $options['sortDir'];
        }

        if (isset($options['limit']) && isset($options['offset'])) {
            $this->query_string .= ' LIMIT ' . $options['offset'] . ',' . $options['limit'];
        } else if (isset($options['limit'])) {
            $this->query_string .= ' LIMIT ' . $options['limit'];
        }

        try {
            $this->command = $this->ci->db->query($this->query_string);
        } catch (Exception $e) {
            return FALSE;
        }

        if (isset($options['count'])) {
            return $this->command->num_rows();
        }

        if (isset($options['row'])) {
            return $this->command->row();
        } else {
            return $this->command->result();
        }
    }

    function get_stats_keyword($options = array())
    {
        $this->query_string = 'SELECT stat_ip';
        $this->query_string .= ',stat_keyword';
        $this->query_string .= ',stat_hits';
        $this->query_string .= ',stat_indate';
        $this->query_string .= ',stat_update';

        if (isset($options['visitor'])) {
            $this->query_string .= ',COUNT(stat_hits) as visitor';
        }

        if (isset($options['hits'])) {
            $this->query_string .= ',SUM(stat_hits) as hits';
        }

        $this->query_string .= ' FROM es_statistic_keyword WHERE stat_ip IS NOT NULL';

        if (isset($options['stat_ip'])) {
            $this->query_string .= ' AND stat_ip="' . $options['stat_ip'] . '"';
        }

        if (isset($options['mulai']) AND isset($options['akhir'])) {
            $this->query_string .= ' AND (DATE(stat_indate) BETWEEN "' . $options['mulai'] . '" AND "' . $options['akhir'] . '")';
        }

        if (isset($options['stat_indate'])) {
            $this->query_string .= ' AND DATE(stat_indate)="' . $options['stat_indate'] . '"';
        }

        if (isset($options['stat_hits'])) {
            switch ($options['set_date']) {
                default:
                    $this->query_string .= ' AND DATE(stat_indate)="' . $options['stat_hits'] . '"';
                    break;
                case 'month':
                    $this->query_string .= ' AND LEFT(stat_indate, 7)="' . $options['stat_hits'] . '"';
                    break;
                case 'year':
                    $this->query_string .= ' AND LEFT(stat_indate, 4)="' . $options['stat_hits'] . '"';
                    break;
            }
        }

        if (isset($options['groupBy'])) {
            $this->query_string .= ' GROUP BY ' . $options['groupBy'];
        }

        if (isset($options['sortBy']) && isset($options['sortDir'])) {
            $this->query_string .= ' ORDER BY ' . $options['sortBy'] . ' ' . $options['sortDir'];
        }

        if (isset($options['limit']) && isset($options['offset'])) {
            $this->query_string .= ' LIMIT ' . $options['offset'] . ',' . $options['limit'];
        } else if (isset($options['limit'])) {
            $this->query_string .= ' LIMIT ' . $options['limit'];
        }

        try {
            $this->command = $this->ci->db->query($this->query_string);
        } catch (Exception $e) {
            return FALSE;
        }

        if (isset($options['count'])) {
            return $this->command->num_rows();
        }

        if (isset($options['row'])) {
            return $this->command->row();
        } else {
            return $this->command->result();
        }
    }

    /*-- Concat --*/

    function set_concat($options = array(), $dt = '', $line = '')
    {
        $query = '';
        if (is_array($dt)) {
            if ($line == '') {
                if (isset($options['is_array'])) {
                    $query = ',CONCAT("array(",';
                    $query .= "GROUP_CONCAT(CONCAT('array(',";
                } else {
                    $query = ',CONCAT("[",';
                    $query .= "GROUP_CONCAT(CONCAT('{',";
                }
            } else {
                $query = ',CONCAT("{",';
            }

            $gx = 0;
            foreach ($dt as $n1 => $v1) {
                $quote = '"';
                $array = isset($options['is_array']) ? '=>' : ':';

                $open = is_array($v1) ? "[" : "[";
                $opgroup = is_array($v1) ? "" : '"';

                $close = is_array($v1) ? "]" : "]";
                $clgroup = is_array($v1) ? "" : '"';

                $v1 = is_array($v1) ? $v1[0] : $v1;

                if ($line == '') {
                    if ($gx > 0) {
                        $query .= ",CONCAT('," . $quote . "$n1" . $quote . $array . "', '$opgroup', $v1, '$clgroup')";
                    } else {
                        $query .= "CONCAT('" . $quote . "$n1" . $quote . $array . "', '$opgroup', $v1, '$clgroup')";
                    }
                } else {
                    if ($gx > 0) {
                        $query .= ",CONCAT('," . $quote . "$n1" . $quote . ":$open', GROUP_CONCAT(CONCAT('$opgroup', $v1, '$clgroup')), '$close')";
                    } else {
                        $query .= "CONCAT('" . $quote . "$n1" . $quote . ":$open', GROUP_CONCAT(CONCAT('$opgroup', $v1, '$clgroup')), '$close')";
                    }
                }

                $gx++;
            }

            if ($line == '') {
                if (isset($options['is_array'])) {
                    $query .= ", ')'))";
                    $query .= ', ")")';
                } else {
                    $query .= ", '}'))";
                    $query .= ', "]")';
                }
            } else {
                $query .= ', "}")';
            }
            $query .= ' AS order_multi';
        }

        return $query;
    }

}
