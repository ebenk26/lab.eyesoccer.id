<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Library
{

    var $query_string = '';
    var $command = '';

    function __construct()
    {
        $this->ci = &get_instance();
    }

    function role_access($menu_url)
    {
        $roles = '';
        if ($this->ci->session->userdata('user_level') != 'admin') {
            $roles = $this->ci->catalog->get_menu_access(array('user_level' => $this->ci->session->userdata('user_level'),
                'menu_url' => $menu_url, 'row' => true));

            if ($roles && $roles->menu_access == 0) {
                if ($this->ci->input->post('val') == true) {
                    $this->role_failed();
                } else {
                    $xdirect = ($menu_url == 'dashboard') ? 'login' : 'dashboard';
                    redirect($xdirect);
                }
            } else {
                if (empty($roles)) {
                    if ($this->ci->input->post('val') == true) {
                        $this->role_failed();
                    } else {
                        $xdirect = ($menu_url == 'dashboard') ? 'login' : 'dashboard';
                        redirect($xdirect);
                    }
                }
            }
        }

        if ($this->ci->session->userdata('user_level') == 'admin') {
            $roles = array('menu_created' => 1, 'menu_updated' => 1, 'menu_deleted' => 1);
            $roles = (object)$roles;
        }

        return $roles;
    }

    function role_failed()
    {
        header('Content-Type: application/json');
        echo json_encode(array('xState' => false, 'xCss' => 'boxfailed', 'xMsg' => "You don't have access"));

        exit;
    }

    function clear_sym($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', ' ', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        //$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('/[^-\w]+/', ' ', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    function seo_title($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        //$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('/[^-\w]+/', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    function seo_link($opt = array())
    {
        //Generate Link SEO
        $link_seo = $this->seo_title($opt['title']);
        $lang_code = $opt['lgcode'];

        if (isset($opt['trans'])) {
            $cek_link = $this->ci->catalog->get_translation(array('element_type' => $opt['element_type'],
                'link_seo' => $link_seo, //text_title_seo
                'lang_code' => $lang_code,
                'is_count' => true,
                'row' => true));
        } else {
            $dt = array('link_seo' => $link_seo, 'lang_code' => $lang_code, 'is_count' => true, 'row' => true);
            $ulevel = $this->user_check();
            if ($ulevel->ff > 0) {
                $dt = array_merge($dt, array('is_check' => true));
            }

            $cek_link = $this->ci->catalog->{$opt['function']}($dt);
        }

        $new_link = $link_seo;
        if ($cek_link) {
            $rcode = $this->random_code();
            $rmd5 = md5($cek_link->cc . '' . $rcode);

            $cl = ($cek_link->cc > 0) ? $cek_link->cc : '';
            //$rmd5 = ($cl > 1) ? $cl+1 : $cl;
            $rmd5 = substr($rmd5, 4, 8);

            $new_link = ($cl > 0) ? $link_seo . "-" . $rmd5 : $link_seo;
        }

        return $new_link;
    }

    function load_lang()
    {
        // Default Language
        $lang = $this->ci->catalog->get_language(array('is_default' => 'yes', 'row' => true));
        $lg = $lang;
        $numlang = count($lang);

        if (isset($_GET['lang'])) {
            $lang = $_GET['lang'];
        } else {
            $lang = (COUNTRY != '') ? COUNTRY : $lg->lang_code;
        }

        //$this->loadLang($this->__theme()->folder.'/'.$lang);

        return array($lang, $lg->lang_code, $numlang);
    }

    function user_check($field = 'id_admin')
    {
        $ff = 0;
        $fu = '';
        if ($this->ci->session->userdata('user_level') != '') {
            switch ($this->ci->session->userdata('user_level')) {
                default:
                    $ff = 1;
                    $fu = $field;
                    break;
                case 'admin':
                case 'eyenews-admin':
                case 'eyetube-admin':
                case 'eyeprofile-admin':
                case 'eyeevent-admin':
                    $ff = 0;
                    $fu = '';
                    break;
            }
        }

        return (object)array('ff' => $ff, 'fu' => $fu);
    }

    function user_links($data = array(), $type = '', $link = '')
    {
        if (isset($data['data_id']) AND isset($data['data_value'])) {
            $ulevel = $this->user_check();
            $valid = ($type == 'insert') ? Validation::insert : Validation::update;
            $option = $this->ci->validation->return_message($valid, TRUE, array('xcss' => 'boxsuccess'));
            if (is_array($data)) {
                if ($link != '' OR $ulevel->ff > 0 AND $this->ci->session->userdata('user_id') != '' OR $this->ci->input->post('user_id') != '') {
                    $go = 0;
                    $insert = array($data['data_id'] => $data['data_value']);
                    $dtlink = array('data_id' => $data['data_id'], 'data_table' => $data['data_table'], 'data_value' => $data['data_value']);
                    if ($link != '' AND $this->ci->input->post('user_type') != '' AND $this->ci->input->post('user_id') != '') {
                        $go = 1;
                        $utype = ($this->ci->input->post('user_type') == 'member') ? 'member_id' : 'merchant_id';
                        $insert = array_merge($insert, array($utype => $this->ci->input->post('user_id')));
                        $dtlink = array_merge($dtlink, array($utype => $this->ci->input->post('user_id')));
                    } else {
                        if ($ulevel->fu > 0) {
                            $go = 1;
                            $insert = array_merge($insert, array($ulevel->fu => $this->ci->session->userdata('user_id')));
                            $dtlink = array_merge($dtlink, array($ulevel->fu => $this->ci->session->userdata('user_id')));
                        }
                    }

                    if ($go > 0) {
                        $check = $this->ci->catalog->get_pr_links($dtlink);
                        if (empty($check)) {
                            $option = $this->ci->action->insert(array('table' => $data['data_table'], 'insert' => $insert));
                            if ($option['state'] == 0) {
                                $this->ci->validation->error_message($option);
                                return false;
                            }
                        }
                    }
                }

                if ($go > 0) {
                    $dt = $data['check'];
                    $lvl = ($ulevel->ff > 0) ? 0 : 1;
                    $open = (isset($dt->is_level) AND $dt->is_level == 0) ? 1 : 0;
                    $open = (empty($dt) AND $ulevel->ff > 0) ? 1 : $open;

                    if ($open > 0) {
                        $option = $this->ci->action->update(array('table' => str_replace('_user', '', $data['data_table']), 'update' => array('is_level' => $lvl),
                            'where' => array($data['data_id'] => $data['data_value'])));
                        if ($option['state'] == 0) {
                            $this->ci->validation->error_message($option);
                            return false;
                        }
                    }
                }
            }

            return $option;
        }
    }

    function user_links_remove($data = array())
    {
        $ulevel = $this->user_check();
        $where = array($data['data_id'] => $data['data_value']);
        if ($ulevel->fu != '') {
            $where = array_merge($where, array($ulevel->fu => $this->ci->session->userdata('user_id')));
        }

        $option = $this->ci->action->delete(array('table' => $data['data_table'], 'where' => $where));
        if ($option['state'] == 0) {
            $this->ci->validation->error_message($option);
            return false;
        }

        return $option;
    }

    function sub_view()
    {
        $idstay = '';
        $idback = '';
        $idsub = '';
        if (isset($_GET['id'])) {
            $idstay = '/?id=' . $_GET['id'];
            $idsub = '&hs=' . $_GET['id'];
            if (isset($_GET['hs'])) {
                $idstay .= '&hs=' . $_GET['hs'];
                $idsub = '&hs=' . $_GET['hs'] . '-' . $_GET['id'];

                $split = explode("-", $_GET['hs']);
                if (count($split) > 1) {
                    $idh = substr($_GET['hs'], strrpos($_GET['hs'], '-') + 1);
                    $hss = str_replace('-' . $idh, '', $_GET['hs']);

                    $idback = '/?id=' . $idh . '&hs=' . $hss;
                } else {
                    $idback = '/?id=' . $_GET['hs'];
                }
            } else {
                $idback = '';
            }
        }

        return (object)array('idstay' => $idstay, 'idback' => $idback, 'idsub' => $idsub);
    }

    function app_key()
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $str = '';
        for ($i = 0; $i < 40; $i++) {
            $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
        }

        return $str;
    }

    function group_key()
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $str = '';
        for ($i = 0; $i < 25; $i++) {
            $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
        }

        return $str;
    }

    function random_code()
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $str = '';
        for ($i = 0; $i < 8; $i++) {
            $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
        }

        $day = date('d');
        $month = date('m');
        $year = date('y');
        $str = $month . '' . $str . '' . $day . '' . $year;

        return strtoupper($str);
    }

    function strip_tags($str)
    {
        $t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
        $t = htmlentities($t, ENT_QUOTES, "UTF-8");
        return $this->sql_injection($t);
    }

    function sql_injection($value)
    {
        //$filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($value,ENT_QUOTES))));
        //return $filter_sql;

        $magic_quotes_active = get_magic_quotes_gpc();
        $new_enough_php = function_exists("mysql_real_escape_string(unescaped_string)"); //i.e. PHP >= v4.3.0

        if ($new_enough_php) { //PHP v4.3.0 or higher
            //undo any magic quote effect so mysql_real_escape_string can do the work

            if ($magic_quotes_active) {
                $value = stripslashes($value);
            }

            $value = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($value, ENT_QUOTES))));

        } else { //before PHP v4.3.0

            if (!$magic_quotes_active) {
                $value = addslashes($value);
            }
        }
        return $value;
    }

    function config_email($host, $port, $user, $pass)
    {
        $config['mailpath'] = '/usr/bin/sendmail';
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = $host; //Yahoo | ssl://smtp.mail.yahoo.com, Gmail | ssl://smtp.gmail.com
        $config['smtp_port'] = $port; //Port 25 | Yahoo/Gmail 465/587
        $config['smtp_user'] = $user;
        $config['smtp_pass'] = $pass;
        $config['smtp_timeout'] = 5;
        $config['priority'] = 3; //Email Priority. 1 = highest. 5 = lowest. 3 = normal.
        $config['mailtype'] = 'html'; //text or html
        $config['charset'] = 'iso-8859-1'; //utf-8 or iso-8859-1
        $config['newline'] = "\r\n";
        $config['crlf'] = "\r\n";
        $config['wordwrap'] = TRUE;
        $this->ci->email->initialize($config);
    }

    function page_table($opt = array())
    {
        // Limit Page
        $limit = $opt['limit'];

        // Position Page
        if ($opt['value'] > 1) {
            $offset = ($opt['value'] - 1) * $limit;
        } else {
            $offset = $opt['offset'];
        }

        $query = array(
            'offset' => $offset,
            'limit' => $limit
        );

        return array('query' => $query);
    }

    function navigation($opt = array())
    {
        $link_page = "";
        $page = "";

        // Link First & Prev
        if ($opt['active_page'] > 1) {
            $prev = $opt['active_page'] - 1;
            $link_page .= "<a href='$opt[base_url]/1'>First</a><a href='$opt[base_url]/$prev'>Prev</a>";
        }

        // Link Page Number
        //$page.= ($opt['active_page'] > 3 ? " ... " : " ");
        for ($i = $opt['active_page'] - 2; $i < $opt['active_page']; $i++) {
            if ($i < 1)
                continue;
            $page .= "<a href='$opt[base_url]/$i'>$i</a>";
        }

        $page .= "<b>$opt[active_page]</b>";
        for ($i = $opt['active_page'] + 1; $i < ($opt['active_page'] + 3); $i++) {
            if ($i > $opt['count_page'])
                break;
            $page .= "<a href='$opt[base_url]/$i'>$i</a>";
        }

        //$page.= ($opt['active_page']+2 < $opt['count_page'] ? "<a href='$opt[base_url]/$opt[count_page]'>$opt[count_page]</a>" : " ");

        $link_page .= $page;

        // Link Next & Last
        if ($opt['active_page'] < $opt['count_page']) {
            $next = $opt['active_page'] + 1;
            $link_page .= "<a href='$opt[base_url]/$next'>Next</a><a href='$opt[base_url]/$opt[count_page]'>Last</a> ";
        }

        return $link_page;
    }

    function page_category($opt = array())
    {
        // Limit Page
        if ($this->ci->session->userdata('limit') > 0) {
            $limit = $this->ci->session->userdata('limit');
        } else {
            $limit = $opt['limit'];
        }

        // Position Page
        if ($opt['value'] > 1) {
            $offset = ($opt['value'] - 1) * $limit;
        } else {
            $offset = $opt['offset'];
        }

        // Search & Sort By
        $xfield = $this->ci->session->userdata('xfield');
        $xsearch = $this->ci->session->userdata('xsearch');

        if ($this->ci->session->userdata('sortDir') == 'asc' OR
            $this->ci->session->userdata('sortDir') == 'desc'
        ) {
            $query = array(
                $xfield => $xsearch,
                'sortBy' => $this->ci->session->userdata('sortBy'),
                'sortDir' => $this->ci->session->userdata('sortDir'),
                'offset' => $offset,
                'limit' => $limit
            );
        } else {
            $query = array(
                $xfield => $xsearch,
                'offset' => $offset,
                'limit' => $limit
            );
        }

        $count = array($xfield => $xsearch, 'count' => true);

        return array('query' => $query, 'count' => $count);
    }

    function checkprice($dt = '')
    {
        $price_nm = $dt->product_price;
        if ($dt->product_special > 0) {
            $stats = 2;
            $price = $dt->product_special;
            isset($dt->product_qty) ? $subtotal = $dt->product_special * $dt->product_qty : $subtotal = '';
            if (isset($dt->product_merchant) AND $dt->product_special < $dt->product_merchant) {
                $price = $dt->product_merchant;
                isset($dt->product_qty) ? $subtotal = $dt->product_merchant * $dt->product_qty : $subtotal = '';
            }
        } else if ($dt->product_disc > 0) {
            $stats = 1;
            $disc = ($dt->product_disc / 100) * $dt->product_price;
            $price = $dt->product_price - $disc;
            isset($dt->product_qty) ? $subtotal = ($dt->product_price - $disc) * $dt->product_qty : $subtotal = '';
            if (isset($dt->product_merchant) AND $price < $dt->product_merchant) {
                if ($dt->product_merchant < $dt->product_price) {
                    $stats = 2;
                }

                if ($dt->product_merchant == $dt->product_price) {
                    $stats = 0;
                    $price_nm = '';
                }

                $price = $dt->product_merchant;
                isset($dt->product_qty) ? $subtotal = $dt->product_merchant * $dt->product_qty : $subtotal = '';
            }
        } else {
            $stats = 0;
            $price = $dt->product_price;
            $price_nm = '';
            isset($dt->product_qty) ? $subtotal = $dt->product_price * $dt->product_qty : $subtotal = '';
        }

        return (object)array('price_normal' => $price_nm, 'price_update' => $price, 'subtotal' => $subtotal, 'stats' => $stats);
    }

    function jsonflush($dt)
    {
        $js = [];
        if ($dt) {
            foreach ($dt as $r) {
                $js[] = $r;
            }
        }

        return json_encode($js);
    }

    function textflush($dt)
    {
        return str_replace("'", "~", $dt);
    }

    function descflush($dt)
    {
        return str_replace("~", "'", $dt);
    }

    function textcode($dt, $lang)
    {
        $check = $this->ci->catalog->get_language(array('lang_code' => $lang, 'is_active' => 'yes', 'row' => true));
        if (empty($check)) {
            // Default Language
            $lg = $this->ci->catalog->get_language(array('is_default' => 'yes', 'row' => true));
            $lang = $lg->lang_code;
        }

        $data = ($lang == '') ? $dt : '';
        $i = 0;
        foreach ($dt as $r) {
            if ($r->lang_id == $lang) {
                $tcode = $r->text_code;
                if ($i > 0) {
                    $data = array_merge($data, array($r->text_code => $this->descflush($r->$tcode)));
                    $i++;
                } else {
                    $data = array($r->text_code => $this->descflush($r->$tcode));
                    $i++;
                }
            }
        }

        return (object)$data;
    }

    function textnotif($dt, $lang)
    {
        $check = $this->ci->catalog->get_language(array('lang_code' => $lang, 'is_active' => 'yes', 'row' => true));
        if (empty($check)) {
            // Default Language
            $lg = $this->ci->catalog->get_language(array('is_default' => 'yes', 'row' => true));
            $lang = $lg->lang_code;
        }

        $data = ($lang == '') ? $dt : '';
        $i = 0;
        foreach ($dt as $r) {
            if ($r->lang_id == $lang) {
                $tcode = $r->notif_code;
                if ($i > 0) {
                    $data = array_merge($data, array($r->notif_code => $this->descflush($r->$tcode)));
                    $i++;
                } else {
                    $data = array($r->notif_code => $this->descflush($r->$tcode));
                    $i++;
                }
            }
        }

        return (object)$data;
    }

    function tcode($dt, $set = 0)
    {
        $pattern = "/%%([a-z0-9A-Z.]+(?(?=[\/])(.*)).[a-z0-9A-Z.]+(?(?=[\/])(.*)))%%/";
        $m = preg_match_all($pattern, $dt, $matches);

        if ($set > 0) {
            return array('count' => $m, 'data' => $matches);
        } else {
            return (isset($matches[1][0])) ? $matches[1][0] : '';
        }
    }

    function postdata($data)
    {
        foreach ($data as $name => $val) {
            if (is_object($val)) {
                foreach ($val as $n1 => $v1) {
                    $_POST[$name][$n1] = $v1;
                }
            } else {
                $_POST[$name] = $val;
            }
        }
    }

    function importcsv($filename, $set = '')
    {
        $row = 0;
        $col = 0;

        $handle = @fopen($filename, "r");
        if ($handle) {
            $i = 0;
            $time = 30;
            while (($row = fgetcsv($handle, 0, $_POST['delimiter'])) !== false) {
                if ($i == 350) {
                    $time = $time + 30;
                    $i = 0;
                }

                if (empty($fields)) {
                    $fields = $row;
                    continue;
                }

                foreach ($row as $k => $value) {
                    $results[$col][$fields[$k]] = $value;
                }
                $col++;
                unset($row);

                $i++;
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() failn";
            }
            fclose($handle);
        }

        if ($set > 0) {
            return array('data' => $results, 'time' => $time);
        } else {
            return $fields;
        }
    }

    function worldmonth($month)
    {
        switch ($month) {
            case 1:
                return "January";
                break;
            case 2:
                return "February";
                break;
            case 3:
                return "March";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "May";
                break;
            case 6:
                return "June";
                break;
            case 7:
                return "July";
                break;
            case 8:
                return "August";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "October";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "December";
                break;
        }
    }

    function mapsDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // Convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) + pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }

    function picUrl($pic = '', $url = '', $path = '', $resize = '')
    {
        $pathurl = $this->ci->config->item('base_static');
        if ($_SERVER['SERVER_NAME'] == 'localhost') {
            if (is_file(UPLOAD . "$path/ori_$pic")) {
                $path = str_replace('eyesoccer', '', $path);
                return $pathurl . "/$path/$pic/$resize";
            } else {
                return str_replace(' ', '%20', $url . "/$resize");
            }
        } else {
            return str_replace(' ', '%20', $url . "/$resize");
        }
    }

}
