<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Enum {

    public $platform = ['web','apps'];
    public $web = ['serve','help'];
    public $notif = ['admin','register','register-social','forget-password','checkout-pending','checkout-success','topup-pending','topup-success',
                     'withdraw-pending','withdraw-success','payment-confirm','message','in progress','delivery in progress','voucher'];
    
    public function __construct() {
        
    }

    public function active_string($param) {
        switch ($param) {
            case 2:
                return 'unreg';
                break;
            case 1:
                return 'yes';
                break;
            case 0:
                return 'no';
                break;
            default :
                return 'no';
        }
    }

    public function active_val($param) {
        switch (strtolower($param)) {
            case 'unreg':
                return 2;
                break;
            case 'yes':
                return 1;
                break;
            case 'no':
                return 0;
                break;
            default :
                return null;
        }
    }
    
    public function ptype_string($param) {
        switch ($param) {
            case 5:
                return 'widget 2';
                break;
            case 4:
                return 'widget 1';
                break;
            case 3:
                return 'footer 2';
                break;
            case 2:
                return 'footer 1';
                break;
            case 1:
                return 'header 2';
                break;
            case 0:
                return 'header 1';
                break;
            default :
                return 'header 1';
        }
    }

    public function ptype_val($param) {
        switch (strtolower($param)) {
            case 'widget 2':
                return 5;
                break;
            case 'widget 1':
                return 4;
                break;
            case 'footer 2':
                return 3;
                break;
            case 'footer 1':
                return 2;
                break;
            case 'header 2':
                return 1;
                break;
            case 'header 1':
                return 0;
                break;
            default :
                return null;
        }
    }
    
    public function region_string($param, $global = 'id') {
        switch ($param) {
            case 4:
                return ($global != 'id') ? 'sub district' : 'kelurahan';
                break;
            case 3:
                return ($global != 'id') ? 'district' : 'kecamatan';
                break;
            case 2:
                return ($global != 'id') ? 'city' : 'kabupaten/kota';
                break;
            case 1:
                return ($global != 'id') ? 'province' : 'provinsi';
                break;
            default :
                return null;
        }
    }

    public function region_val($param, $global = 'id') {
        switch (strtolower($param)) {
            case 'kelurahan':
            case 'sub district':
                return 4;
                break;
            case 'kecamatan':
            case 'district':
                return 3;
                break;
            case 'kabupaten/kota':
            case 'city':
                return 2;
                break;
            case 'provinsi':
            case 'province':
                return 1;
                break;
            default :
                return null;
        }
    }
    
    public function utype_string($param) {
        switch ($param) {
            case 2:
                return 'consignment';
                break;
            case 1:
                return 'dropship';
                break;
            default :
                return null;
        }
    }

    public function utype_val($param) {
        switch (strtolower($param)) {
            case 'consignment':
                return 2;
                break;
            case 'dropship':
                return 1;
                break;
            default :
                return null;
        }
    }
    
    public function ucode_string($param) {
        switch ($param) {
            case 2:
                return 'CN';
                break;
            case 1:
                return 'DS';
                break;
            default :
                return null;
        }
    }

    public function ucode_val($param) {
        switch (strtolower($param)) {
            case 'CN':
                return 2;
                break;
            case 'DS':
                return 1;
                break;
            default :
                return null;
        }
    }
    
    public function voucher_string($param) {
        switch ($param) {
            case 1:
                return 'available';
                break;
            case 0:
                return 'expired';
                break;
            default :
                return 'expired';
        }
    }

    public function voucher_val($param) {
        switch (strtolower($param)) {
            case 'available':
                return 1;
                break;
            case 'expired':
                return 0;
                break;
            default :
                return null;
        }
    }
    
    public function wlstatus_string($param) {
        switch ($param) {
            case 2:
                return 'approved';
                break;
            case 1:
                return 'waiting';
                break;
            case 0:
                return 'cancel';
                break;
            default :
                return 'cancel';
        }
    }

    public function wlstatus_val($param) {
        switch (strtolower($param)) {
            case 'approved':
                return 2;
                break;
            case 'waiting':
                return 1;
                break;
            case 'cancel':
                return 0;
                break;
            default :
                return null;
        }
    }
    
    public function crstatus_string($param) {
        switch ($param) {
            case 2:
                return 'paid';
                break;
            case 1:
                return 'unpaid';
                break;
            case 0:
                return 'cancel';
                break;
            default :
                return 'unpaid';
        }
    }

    public function crstatus_val($param) {
        switch (strtolower($param)) {
            case 'paid':
                return 2;
                break;
            case 'unpaid':
                return 1;
                break;
            case 'cancel':
                return 0;
                break;
            default :
                return null;
        }
    }
    
    public function orstatus_string($param) {
        switch ($param) {
            case 8:
                return 'declined';
                break;
            case 7:
                return 'complained';
                break;
            case 6:
                return 'completed';
                break;
            case 5:
                return 'delivered';
                break;
            case 4:
                return 'delivery on progress';
                break;
            case 3:
                return 'on progress';
                break;
            case 2:
                return 'waiting';
                break;
            case 1:
                return 'pending';
                break;
            case 0:
                return 'expired';
                break;
            default :
                return 'expired';
        }
    }

    public function orstatus_val($param) {
        switch (strtolower($param)) {
            case 'declined':
                return 8;
                break;
            case 'complained':
                return 7;
                break;
            case 'completed':
                return 6;
                break;
            case 'delivered':
                return 5;
                break;
            case 'delivery on progress':
                return 4;
                break;
            case 'on progress':
                return 3;
                break;
            case 'waiting':
                return 2;
                break;
            case 'pending':
                return 1;
                break;
            case 'expired':
                return 0;
                break;
            default :
                return null;
        }
    }
    
    public function cfstatus_string($param) {
        switch ($param) {
            case 2:
                return 'unaccepted';
                break;
            case 1:
                return 'accepted';
                break;
            case 0:
                return 'waiting';
                break;
            default :
                return 'waiting';
        }
    }

    public function cfstatus_val($param) {
        switch (strtolower($param)) {
            case 'unaccepted':
                return 2;
                break;
            case 'accepted':
                return 1;
                break;
            case 'waiting':
                return 0;
                break;
            default :
                return null;
        }
    }

}
