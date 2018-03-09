<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validation {

    const insert_success = 'Data Successfully Inserted.. ';
    const insert_failed = 'Error Captured While Inserting Data... ';
    const update_success = 'Data Successfully Updated.. ';
    const update_failed = 'Error Captured While Updating Data... ';
    const delete_success = 'Data Successfully Deleted.. ';
    const delete_failed = 'Error Captured While Deleting Data... ';
    const required = 'Field(s) Should Be Filled..';
    const published = "Can't Delete Or Update Published Data..";
    const insert = 'insert';
    const update = 'update';
    const delete = 'delete';

    public function required_field($required, $data) {
        foreach ($required as $fields) {
            if (empty($data[$fields])) {
                return false;
            }
        }
        return true;
    }

    public function default_field_val($default, $options) {
        return array_merge($default, $options);
    }

    public function return_message($operation = self::insert, $success = TRUE, $addmessage = array()) {
        $state = FALSE;

        switch ($operation) {
            case self::insert:
                $message = self::insert_failed;
                if ($success == TRUE) {
                    $state = TRUE;
                    $message = self::insert_success;
                }
                break;
            case self::update:
                $message = self::update_failed;
                if ($success == TRUE) {
                    $state = TRUE;
                    $message = self::update_success;
                }
                break;
            case self::delete:
                $message = self::delete_failed;
                if ($success == TRUE) {
                    $state = TRUE;
                    $message = self::delete_success;
                }
                break;
        }

        return array('state' => $state, 'message' => $message, 'add_message' => $addmessage);
    }
    
    public function error_message($option = array(), $ajax = '')
    {
        if($option['add_message']['required'] != '')
        {
            $message = $option['add_message']['required'];
        } else {
            $message = $option['message'];
        }
        
        $xcss = $option['add_message']['xcss'];
        $xm = array('xState' => false, 'vHtml' => false, 'xCss' => $xcss, 'xMsg' => $message);
        if(isset($ajax))
        {
            return $xm;
        } else {
            header('Content-Type: application/json');
            echo json_encode($xm);
        }
    }
}
