<?php

class Restapi
{

    var $query_string = '';
    var $command = '';

    function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->library('mylib/array2xml');
    }

    function __postdata($data)
    {
        foreach ($data as $name => $val) {
            if (is_object($val)) {
                foreach ($val as $n1 => $v1) {
                    $_POST[$name][$n1] = $v1;
                }
            } else {
                if (is_array($val)) {
                    foreach ($val as $n1 => $v1) {
                        if (is_object($v1)) {
                            foreach ($v1 as $n2 => $v2) {
                                $_POST[$name][$n1][$n2] = $v2;
                            }
                        } else {
                            $_POST[$name][$n1] = $v1;
                        }
                    }
                } else {
                    $_POST[$name] = $val;
                }
            }
        }
    }

    function __decodedata($data)
    {
        $lang = $this->ci->library->load_lang();

        $decode = [];
        foreach ($data as $n => $v) {
            $dd = $v;
            if (is_array($v) OR is_object($v)) {
                $dd = $this->__decodedata($v);
                $decode[$n] = $dd;
            } else {
                $dec = json_decode($dd);
                $decode[$n] = (is_array($dec) OR is_object($dec)) ? $dec : $dd;

                switch ($n) {
                    case 'category_id':
                        $catdata = $decode[$n];
                        if (is_array($decode[$n]) OR is_object($decode[$n])) {
                            $catdata = [];
                            foreach ($decode[$n] as $r) {
                                $category = $this->ci->catalog->get_post_category(array('is_multi' => true, 'category_id' => implode(",", $r), 'lang_code' => $lang[0]));
                                if ($category) {
                                    $catdata[] = $category;
                                }
                            }
                        }

                        $decode['category_id'] = $catdata;
                        break;

                    case 'tag_id':
                        $tag = $decode[$n];
                        if (is_array($decode[$n]) OR is_object($decode[$n])) {
                            $tag = $this->ci->catalog->get_post_tag(array('is_multi' => true, 'tag_id' => implode(",", $decode[$n]), 'lang_code' => $lang[0]));
                        }

                        $decode['tag_id'] = $tag;
                        break;

                    case 'brand_data':
                        $brand = $decode[$n];
                        if ($decode[$n] > 0) {
                            $brand = $this->ci->catalog->get_pr_brands(array('is_multi' => true, 'brand_id' => $decode[$n], 'limit' => 1, 'row' => true));
                        }

                        $decode['brand_data'] = $brand;
                        break;

                    case 'category_data':
                        $catdata = $decode[$n];
                        if ($decode[$n] != 'false') {
                            $catdata = [];
                            if (is_array($decode[$n]) OR is_object($decode[$n])) {
                                foreach ($decode[$n] as $r) {
                                    $category = $this->ci->catalog->get_pr_categories(array('is_multi' => true, 'category_id' => implode(",", $r), 'lang_code' => $lang[0]));
                                    if ($category) {
                                        $catdata[] = $category;
                                    }
                                }
                            }
                        }

                        $decode['category_data'] = $catdata;
                        break;

                    case 'tag_data':
                        $tag = $decode[$n];
                        if ($decode[$n] != 'false') {
                            if (is_array($decode[$n])) {
                                $tag = $this->ci->catalog->get_pr_tags(array('is_multi' => true, 'tag_id' => implode(",", $decode[$n]), 'lang_code' => $lang[0]));
                            }
                        }

                        $decode['tag_data'] = $tag;
                        break;

                    case 'feature_data':
                        $feature = $decode[$n];
                        if ($decode[$n] != 'false') {
                            if (is_array($decode[$n])) {
                                $feature = $this->ci->catalog->get_pr_features(array('is_multi' => true, 'feature_id' => implode(",", $decode[$n]), 'lang_code' => $lang[0]));
                            }
                        }

                        $decode['feature_data'] = $feature;
                        break;

                    case 'add_data':
                        $adds = $decode[$n];
                        if ($decode[$n] != 'false') {
                            if (is_array($decode[$n])) {
                                $adds = $this->ci->catalog->get_pr_additional(array('is_multi' => true, 'add_id' => implode(",", $decode[$n]), 'lang_code' => $lang[0]));
                            }
                        }

                        $decode['add_data'] = $adds;
                        break;

                    case 'picture_pic':
                        $uri = explode('/', $_SERVER['REDIRECT_QUERY_STRING']);
                        $url = $this->ci->config->item('base_static');
                        if ($uri) {
                            switch ($uri[2]) {
                                case 'post':
                                    $url .= '/post/';
                                    break;

                                case 'product':
                                    $url .= '/product/';
                                    break;
                            }

                            switch ($uri[3]) {
                                case 'postlist':
                                    $url .= '/post/';
                                    break;

                                case 'productlist':
                                    $url .= '/product/';
                                    break;
                            }
                        }

                        $imgs = [];
                        if (is_array($decode[$n]) OR is_object($decode[$n])) {
                            foreach ($decode[$n] as $img) {
                                $imgs[] = $url . $img;
                            }
                        }

                        $decode['picture_pic'] = $imgs;
                        break;

                    case 'picture_default':
                        $i = 0;
                        $default = '';
                        foreach ($imgs as $img) {
                            if ($i == $decode[$n]) {
                                $default = $img;
                                break;
                            }

                            $i++;
                        }

                        $decode['picture_default'] = $default;
                        break;

                    case 'post_pic':
                        $url = $this->ci->config->item('base_static') . '/post/';
                        $decode[$n] = $url . $decode[$n];
                        break;

                    case 'user_pic':
                    case 'merchant_pic':
                        $url = $this->ci->config->item('base_static') . '/user/';
                        $decode[$n] = $url . $decode[$n];
                        break;

                    case 'page_pic':
                    case 'gallery_pic':
                    case 'sidebar_pic':
                    case 'payment_pic':
                    case 'web_logo':
                    case 'web_favicon':
                        $url = $this->ci->config->item('base_static') . '/images/';
                        $decode[$n] = $url . $decode[$n];
                        break;

                    case 'iso_code':
                        $iso = '';
                        if ($decode[$n] != '') {
                            $iso = $this->ci->catalog->get_country(array('iso_code_2' => $decode[$n], 'limit' => 1, 'row' => true));
                        }

                        $decode['iso_name'] = ($decode[$n] != '' AND $iso) ? $iso->country_name : '';
                        break;

                    case 'zone_id':
                        $zone = '';
                        if ($decode[$n] != '') {
                            if ($iso->iso_code_2 == 'ID') {
                                $zone = $this->ci->catalog->get_pr_regions(array('region_id' => $decode[$n], 'limit' => 1, 'row' => true));
                                $zone = ($zone) ? $zone->region_name : '';
                            } else {
                                $zone = $this->ci->catalog->get_zone(array('zone_id' => $decode[$n], 'limit' => 1, 'row' => true));
                                $zone = ($zone) ? $zone->zone_name : '';
                            }
                        }

                        $decode['zone_name'] = ($decode[$n] != '' AND $zone) ? $zone : '';
                        break;

                    case 'city_id':
                        $city = '';
                        if ($decode[$n] != '') {
                            $city = $this->ci->catalog->get_pr_regions(array('region_id' => $decode[$n], 'limit' => 1, 'row' => true));
                        }

                        $decode['city_name'] = ($decode[$n] != '' AND $city) ? $city->region_name : '';
                        break;

                    case 'region_type':
                        $decode['region_type_string'] = $this->ci->enum->region_string($decode[$n]);
                        break;

                    case 'bill_status':
                        $decode['bill_status_string'] = $this->ci->enum->crstatus_string($decode[$n]);
                        break;

                    case 'order_status':
                        $decode['order_status_string'] = $this->ci->enum->orstatus_string($decode[$n]);
                        break;
                }
            }
        }

        return $decode;
    }

    function __getdata($data, $options = '')
    {
        $data = array('data' => $this->__decodedata($data));
        if (isset($options['msg'])) {
            $data = array_merge($data, $this->__getstatus($options['msg'], isset($options['http_code']) ? $options['http_code'] : 200));
        } else {
            $data = array_merge($data, $this->__getstatus());
        }

        return $data;
    }

    function __getstatus($msg = '', $http_code = 200)
    {
        //if($http_code == 200)
        //{
        //    $data = array('success' => array('message' => ($msg) ? $msg : 'Success',
        //				     'status_code' => 200));
        //} else {
        //    $data = array('error' => array('message' => $msg,
        //				   'status_code' => $http_code));
        //}

        if ($msg == '' AND $http_code == '403') {
            $msg = ($msg) ? $msg : 'Error';
        } else {
            $msg = ($msg) ? $msg : 'Success';
        }

        $data = array('status' => array('message' => $msg, 'http_code' => $http_code));

        return $data;
    }

    function __response($data, $http_code = 200)
    {
        (isset($_GET['type'])) ? $type = $_GET['type'] : $type = 'json';

        switch ($type) {
            default:
                header('Content-Type: application/json');
                $dt = json_encode($data);
                break;

            case 'xml':
                $this->array2xml->init('1.0', 'UTF-8');
                $xml = $this->array2xml->createXML('node', $data);
                $dt = $xml->saveXML();
                break;
        }

        http_response_code($http_code);
        print $dt;
        exit;
    }

    function __auth()
    {
        if (isset($_SERVER['PHP_AUTH_USER']) AND isset($_SERVER['PHP_AUTH_PW'])) {
            if ($_SERVER['PHP_AUTH_USER'] != 'tzirtkaos' AND $_SERVER['PHP_AUTH_PW'] != 'tzk0001^!%@$#') {
                $data = $this->__getstatus('Authentication Failed', 401);
                $status = $data['error']['status_code'];
                $this->__response($data, $status);
            }
        } else {
            $data = $this->__getstatus('Authentication Failed', 401);
            $status = $data['error']['status_code'];
            $this->__response($data, $status);
        }
    }

    function __haccess($data)
    {
        $dt = array('table' => 'tb_haccess',
            'insert' => array('haccess_uri' => $_SERVER['REQUEST_URI'],
                'haccess_data' => str_replace("'", '~', $data),
                'created_date' => date('Y-m-d H:i:s'),
                'app_id' => isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '',
                'ip_address' => $_SERVER['REMOTE_ADDR']));
        $option = $this->ci->action->insert($dt);
    }

    function __error($msg = '', $data = '')
    {
        $message = $this->__getstatus($msg, 403);
        if ($data != '') {
            $message = $this->__getdata($data, array('msg' => $msg, 'http_code' => 403));
        }
        $this->__haccess(json_encode($message));
        $this->__response($message, 403);
    }

    function __success($data = '')
    {
        $message = $this->__getdata($data);
        $this->__haccess(json_encode($message));
        $this->__response($message);
    }

    function __expired()
    {
        if (empty($_COOKIE['user_uid'])) {
            $this->__error('Your account has been expired');
        } else {
            setcookie('user_uid', $_COOKIE['user_uid'], time() + (86400 * 30), "/");
        }
    }

    function __clearchar($string)
    {
        return preg_replace("/[^0-9]/", '', $string);
    }

    function __clearnumber($string)
    {
        return preg_replace("/[^A-Za-z]/", '', $string);
    }

}

?>
