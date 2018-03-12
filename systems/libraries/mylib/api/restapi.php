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
            if ($_SERVER['PHP_AUTH_USER'] != 'eyeback' AND $_SERVER['PHP_AUTH_PW'] != 'superb4cksm4rt3r') {
                $data = $this->__getstatus('Authentication Failed', 401);
                $this->__response($data, '401');
            }
        } else {
            $data = $this->__getstatus('Authentication Failed', 401);
            $this->__response($data, '401');
        }
    }

    function __haccess($data)
    {
        $dt = array('table' => 'es_haccess',
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
