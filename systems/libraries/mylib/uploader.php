<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Uploader
{

    function __construct()
    {
        $this->ci = &get_instance();
    }

    public function single_upload($conf = array(), $field = 'uploadfile', $path, $files = '', $newname = '')
    {
        $filename = '';
        $random = rand(1, 999);
        if (isset($_FILES[$field]['name']) && $_FILES[$field]['name'] != '') {
            $str = $this->ci->library->seo_title($_FILES[$field]['name']);
            $split = explode("-", $str, -1);
            $sfile = implode("-", $split);
            $ext = substr($str, strrpos($str, '-') + 1);
            $filename = $sfile . "." . $ext;

            $exts = $this->__reext($ext);
            if ($this->__allowed($exts, $conf) > 0) $config['quality'] = 70;

            $filename = ($newname) ? $newname . '_' . date('m') . $random . '_' . $filename : date('m') . $random . '_' . $filename;
        }

        // Already Picture
        if ($filename != '') {
            $data = $filename;
        } else {
            if (isset($files)) {
                $data = $files;
            } else {
                $data = '';
            }
        }

        $config['upload_path'] = $path;
        $config['allowed_types'] = $conf['allowed_types'];
        $config['max_size'] = $conf['max_size'];
        $config['file_name'] = 'ori_' . $filename;

        $this->ci->load->library('upload', $config);
        $this->ci->upload->initialize($config);

        if ($filename != '') {
            // Upload Image
            if (!$this->ci->upload->do_upload($field)) {
                $this->single_unlink($conf, $field, $path, $data);

                $error = $this->ci->upload->display_errors();
                if (isset($conf['api'])) {
                    $message = $this->ci->restapi->__getstatus($error, 403);
                    $this->ci->restapi->__response($message, 403);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(array('xState' => false,
                        'xCss' => 'boxfailed',
                        'xMsg' => $error));
                    exit;
                }
            } else {
                if (isset($conf['resize'])) {
                    $ori = (isset($conf['original'])) ? true : false;
                    $this->__resize($path, $filename, $ori);
                }
            }
        }

        return array('data' => $data);
    }

    public function single_unlink($conf = array(), $field = 'uploadfile', $path, $files)
    {
        if (isset($files) AND isset($_FILES[$field])) {
            $filename = str_replace(' ', '_', $_FILES[$field]['name']);

            // Already Picture
            if ($filename != '' AND $files != '') {
                if (isset($conf['resize'])) {
                    if (isset($conf['resize'])) {
                        $resize = array('medium', 'small', 'thumb');
                        foreach ($resize as $size) {
                            if (is_file($path . $size . '_' . $files)) {
                                unlink($path . $size . '_' . $files);
                            }
                        }
                    }
                    if (is_file($path . 'ori_' . $files)) {
                        unlink($path . 'ori_' . $files);
                    }
                } else {
                    if (is_file($path . 'ori_' . $files)) {
                        unlink($path . 'ori_' . $files);
                    }
                }
            }
        }
    }

    public function multi_upload($conf = array(), $field = 'uploadfile', $path, $files = '', $newname = '')
    {
        if (empty($_FILES[$field])) {
            return array('field_name' => '', 'data' => '');
        }

        // looping $_FILES & New Array
        $x = 1;
        foreach ($_FILES[$field] as $key => $val) {
            $i = 1;
            foreach ($val as $v) {
                if ($x == 1) {
                    $field_name[] = "file_" . $i;
                }

                if (is_array($v)) {
                    foreach ($v as $s) {
                        $_FILES["file_" . $i][$key] = $s;
                    }
                } else {
                    $_FILES["file_" . $i][$key] = $v;
                }
                $i++;
            }
            $x++;
        }

        // Delete First Array
        unset($_FILES[$field]);

        $i = 0;
        $data = '';
        foreach ($field_name as $file) {
            $filename = '';
            $random = rand(1, 999);
            if (isset($_FILES[$file]['name']) && $_FILES[$file]['name'] != '') {
                $str = $this->ci->library->seo_title($_FILES[$file]['name']);
                $split = explode("-", $str, -1);
                $sfile = implode("-", $split);
                $ext = substr($str, strrpos($str, '-') + 1);
                $filename = $sfile . "." . $ext;

                $exts = $this->__reext($ext);
                if ($this->__allowed($exts, $conf) > 0) $config['quality'] = 70;

                $filename = ($newname) ? $newname . '_' . date('m') . $random . '_' . $filename : date('m') . $random . '_' . $filename;
            }

            // Already Picture
            if ($filename != '') {
                $data[] = $filename;
            } else {
                if (isset($files[$i])) {
                    $data[] = $files[$i];
                } else {
                    $data[] = '';
                }
            }

            $i++;

            $config['upload_path'] = $path;
            $config['allowed_types'] = $conf['allowed_types'];
            $config['max_size'] = $conf['max_size'];
            $config['file_name'] = 'ori_' . $filename;

            $this->ci->load->library('upload', $config);
            $this->ci->upload->initialize($config);

            if ($filename != '') {
                // Upload Image
                if (!$this->ci->upload->do_upload($file)) {
                    $this->multi_unlink($conf, $field, $path, $data);

                    $error = $this->ci->upload->display_errors();
                    if (isset($conf['api'])) {
                        $message = $this->ci->restapi->__getstatus($error, 403);
                        $this->ci->restapi->__response($message, 403);
                    } else {
                        header('Content-Type: application/json');
                        echo json_encode(array('xState' => false,
                            'xCss' => 'boxfailed',
                            'xMsg' => $error));
                        exit;
                    }
                } else {
                    if (isset($conf['resize'])) {
                        $ori = (isset($conf['original'])) ? true : false;
                        $this->__resize($path, $filename, $ori);
                    }
                }
            }
        }

        return array('field_name' => $field_name, 'data' => $data);
    }

    public function multi_unlink($conf = array(), $field_name, $path, $files)
    {
        $i = 0;
        $x = 0;
        foreach ($_FILES as $field_name => $file) {
            $x = $x + 1;
            if ($field_name == 'file_' . $x) {
                if (isset($files[$i])) {
                    $filename = str_replace(' ', '_', $file['name']);

                    // Already Picture
                    if ($filename != '' AND $files[$i] != '') {
                        if (isset($conf['resize'])) {
                            if (isset($conf['resize'])) {
                                $resize = array('medium', 'small', 'thumb');
                                foreach ($resize as $size) {
                                    if (is_file($path . $size . '_' . $files[$i])) {
                                        unlink($path . $size . '_' . $files[$i]);
                                    }
                                }
                            }
                            if (is_file($path . 'ori_' . $files[$i])) {
                                unlink($path . 'ori_' . $files[$i]);
                            }
                        } else {
                            if (is_file($path . 'ori_' . $files[$i])) {
                                unlink($path . 'ori_' . $files[$i]);
                            }
                        }
                    }
                }

                $i++;
            } else {
                $x = $x - 1;
            }
        }
    }

    function __reext($ext = '')
    {
        switch ($ext) {
            case 'jpeg':
                $ext = 'jpg';
                break;
        }

        return $ext;
    }

    function __resize($path = '', $filename = '', $ori = false, $res = '')
    {
        $source = $path . 'ori_' . $filename;
        list($width, $height) = getimagesize($source);
        if ($ori == false) {
            if ($width > 1280) {
                //chown($source, 'admin');
                $this->__imagine($path, 'ori', $filename, 1280, 1280);
            } else {
                //$xwidth = $width - 10;
                //$xheight = ($height/$width) * $xwidth;
                //$this->__imagine($path, 'ori', $filename, $xwidth, $xheight);
            }
        }

        $slice = 2;
        $part = 3;
        list($width, $height) = getimagesize($source);
        $resize = array('medium' => 720, 'small' => 480, 'thumb' => 240);
        foreach ($resize as $size => $val) {
            if ($res AND $size == $res) {
                $xwidth = ceil($width / $slice) + ceil($width / $part);
                $xheight = ($height / $width) * $xwidth;

                if ($xwidth < $val) {
                    $xwidth = $xwidth + ceil(($width - $xwidth) / $slice);
                    $xheight = $xheight + ceil(($height - $xheight) / $slice);
                    $this->__imagine($path, $size, $filename, $xwidth, $xheight);
                } else {
                    $this->__imagine($path, $size, $filename, $xwidth, $xheight);
                }

                break;
            } else {
                if (empty($res)) {
                    $xwidth = ceil($width / $slice) + ceil($width / $part);
                    $xheight = ($height / $width) * $xwidth;

                    if ($xwidth < $val) {
                        $xwidth = $xwidth + ceil(($width - $xwidth) / $slice);
                        $xheight = $xheight + ceil(($height - $xheight) / $slice);
                        $this->__imagine($path, $size, $filename, $xwidth, $xheight);
                    } else {
                        $this->__imagine($path, $size, $filename, $xwidth, $xheight);
                    }
                }
            }

            $slice = $slice * 2;
            $part = $part + 3;
        }
    }

    function __imagine($path = '', $size = '', $filename = '', $width = '', $height = '')
    {
        $this->ci->load->library('image_lib');
        $config = array(
            'source_image' => $path . 'ori_' . $filename,
            'new_image' => $path . $size . '_' . $filename,
            'maintain_ration' => true,
            'width' => $width,
            'height' => $height
        );

        $ql = 0;
        $ext = substr($filename, strrpos($filename, '.') + 1);
        switch ($ext) {
            case 'jpg':
                $ql = 1;
                break;
            case 'jpeg':
                $ql = 1;
                break;
            case 'gif':
                $ql = 1;
                break;
            case 'png':
                $ql = 1;
                break;
        }

        if ($ql > 0) {
            if ($width == 1280 AND $height == 1280) {
                $config = array_merge($config, array('quality' => 80));
            } else {
                $config = array_merge($config, array('quality' => 70));
            }

            $this->ci->image_lib->initialize($config);
            $this->ci->image_lib->resize();
            $this->ci->image_lib->clear();
        }
    }

    function __filestore($updata = '', $conf = '', $newname = '')
    {
        $filestore = $this->ci->input->post('filestore');
        $config = $conf['config'];
        $movepath = $conf['path'];
        $files = [];

        foreach (json_decode($filestore) as $fs) {
            $files[] = $this->__filebase($fs, $conf, $newname, $updata, $files);
        }

        return $files;
    }

    function __filestore_data($id = '', $updata = '', $path = '', $catalog = '', $type = '')
    {
        // Delete Picture Not In View
        if ($this->ci->input->post('idx') != '') {
            $pic = $this->ci->catalog->{$catalog['func']}(array('data_id' => $id, 'data_type' => $type, 'row' => true));
            if ($pic) {
                $dtpic = [];
                foreach (json_decode($pic->picture_pic) as $p1) {
                    $i = 0;
                    if ($this->ci->input->post('picture_data')) {
                        foreach ($this->ci->input->post('picture_data') as $p2) {
                            if ($p1 == $p2) {
                                $dtpic[] = $p1;
                                $i = 1;
                                break;
                            }
                        }
                    }

                    if ($i == 0 AND $p1) {
                        $this->__unlink($path, $p1);
                    }
                }

                $option = $this->ci->action->update(array('table' => $catalog['table'], 'update' => array('picture_pic' => json_encode($dtpic)),
                    'where' => array('data_id' => $id, 'data_type' => $type)));
            }
        }

        if ($updata['filestore']) {
            foreach ($updata['filestore'] as $u) {
                $dtpic[] = $u['name'];
            }

            $dt = array('picture_pic' => json_encode($dtpic), 'data_id' => $id, 'data_type' => $type,
                'picture_default' => ($this->ci->input->post('is_default') != '') ? $this->ci->input->post('is_default') : 0);
        } else {
            $dt = array('picture_default' => ($this->ci->input->post('is_default') != '') ? $this->ci->input->post('is_default') : 0);
        }

        if ($this->ci->input->post('idx') == '') {
            $option = $this->ci->action->insert(array('table' => $catalog['table'], 'insert' => $dt));
        } else {
            if ($pic) {
                $option = $this->ci->action->update(array('table' => $catalog['table'], 'update' => $dt,
                    'where' => array('data_id' => $id, 'data_type' => $type)));
            } else {
                $option = $this->ci->action->insert(array('table' => $catalog['table'], 'insert' => $dt));
            }
        }

        if ($option['state'] == 0) {
            $this->single_unlink($path['config'], 'uploadfile', $path['path'], $updata['default']);
            $this->__filestore_unlink($updata['filestore']);

            $this->ci->validation->error_message($option);
            return false;
        }

        //return $option;
    }

    function __filestore_unlink($files = array(), $conf = '')
    {
        if (is_array($files)) {
            if (isset($files['name']) AND isset($files['path'])) {
                if (is_file($files['path'])) {
                    unlink($files['path']);
                }

                $this->__unlink($conf, $files['name']);
            } else {
                foreach ($files as $f) {
                    if (is_file($f['path'])) {
                        unlink($f['path']);
                    }

                    $this->__unlink($conf, $f['name']);
                }
            }
        }
    }

    function __filebase($file = '', $conf = '', $newname = '', $updata = '', $multi = '')
    {
        if (empty($file)) {
            return array('name' => '', 'path' => '');
        }

        $files = '';
        $config = $conf['config'];
        $movepath = $conf['path'];
        $randname = $this->ci->library->random_code();

        $basefile = '';
        $http = explode('://', $file);
        if ($http[0] == 'http' OR $http[0] == 'https') {
            $ext = strtolower(substr(strrchr($file, "."), 1));
        } else {
            $basefile = explode(";", $file);
            $ext = strtolower(substr(strrchr($basefile[0], "/"), 1));
        }

        if (empty($ext)) {
            return array('name' => '', 'path' => '');
        }

        $random = rand(1, 999);
        $exts = $this->__reext($ext);
        $sfile = strtolower($randname);
        $newname = $this->ci->library->seo_title($newname);
        $filename = ($newname) ? $newname . "_" . date('m') . $random . "_" . $sfile . "." . $exts : date('m') . $random . "_" . $sfile . "." . $exts;
        $imglocation = $movepath . '/ori_' . $filename;

        if ($this->__allowed($exts, $conf['config']) == 0) {
            $this->single_unlink($conf['config'], 'uploadfile', $conf['path'], $updata);
            $this->__filestore_unlink(($multi) ? $multi : $files, $conf);

            if (isset($conf['api'])) {
                $message = $this->ci->restapi->__getstatus('The filetype you are attempting to upload is not allowed.', 403);
                $this->ci->restapi->__response($message, 403);
            } else {
                header('Content-Type: application/json');
                echo json_encode(array('xState' => false,
                    'xCss' => 'boxfailed',
                    'xMsg' => 'The filetype you are attempting to upload is not allowed.'));
                exit;
            }
        }

        $files = array('name' => $filename, 'path' => $imglocation);
        if ($basefile == '') {
            file_put_contents($imglocation, file_get_contents($file));
        } else {
            $base64file = str_replace($basefile[0] . ';base64,', '', $file);
            file_put_contents($imglocation, base64_decode($base64file));
        }
        $filesize = ceil(filesize($imglocation) * 0.001);

        if ($filesize > $config['max_size']) {
            $this->single_unlink($conf['config'], 'uploadfile', $conf['path'], $updata);
            if ($multi) {
                $this->__filestore_unlink($files, $conf);
                $this->__filestore_unlink($multi, $conf);
            } else {
                $this->__filestore_unlink($files, $conf);
            }

            if (isset($conf['api'])) {
                $message = $this->ci->restapi->__getstatus('The file you are attempting to upload is larger than the permitted size.', 403);
                $this->ci->restapi->__response($message, 403);
            } else {
                header('Content-Type: application/json');
                echo json_encode(array('xState' => false,
                    'xCss' => 'boxfailed',
                    'xMsg' => 'The file you are attempting to upload is larger than the permitted size.'));
                exit;
            }
        }

        if (isset($conf['resize'])) {
            $ori = (isset($conf['original'])) ? true : false;
            $this->__resize($movepath, $filename, $ori);
        }

        return $files;
    }

    function __allowed($ext = '', $conf = '')
    {
        $allow = explode("|", $conf['allowed_types']);
        $ql = 0;
        foreach ($allow as $al) {
            if ($al == $ext) {
                $ql = 1;
                break;
            }
        }

        return $ql;
    }

    function __unlink($path = '', $files = '')
    {
        $resize = array('medium', 'small', 'thumb');
        foreach ($resize as $size) {
            if (is_file($path['path'] . $size . '_' . $files)) {
                unlink($path['path'] . $size . '_' . $files);
            }
        }

        if (is_file($path['path'] . 'ori_' . $files)) {
            unlink($path['path'] . 'ori_' . $files);
        }
    }

}
