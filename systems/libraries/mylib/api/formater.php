<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    
class Formater {
    
    function number($val, $opt = 0, $set = 0, $spr = 0)
    {
        $fm = isset($opt->currency_format) ? json_decode($opt->currency_format) : '';
        $currency = (isset($opt->currency_code)) ? $opt->currency_code : 'Rp';
        $separator = (isset($fm[0])) ? $fm[0] : '.';
        
        $decimal_separator = (isset($fm[1])) ? $fm[1] : ',';
        $decimal = (isset($fm[2])) ? $fm[2] : 0;
        
        if($spr > 0)
        {
            $format = ($set > 0) ? number_format($val,0,$decimal_separator,'') : $currency." ".number_format($val,$decimal,$decimal_separator,'');
        } else {
            $format = ($set > 0) ? number_format($val,0,$decimal_separator,$separator) : $currency." ".number_format($val,$decimal,$decimal_separator,$separator);
        }        
        
        return $format;
    }
    
    function money()
    {
        
    }
    
    function datefo($date, $global = 'id')
    {
        $d = substr($date,8,2);
        $m = $this->monthfo(substr($date,5,2), $global);
        $y = substr($date,0,4);
        return $d.' '.$m.' '.$y;		 
    }	

    function monthfo($month, $global)
    {
        switch($month)
        {
            case 1: 
                return ($global != 'id') ? "January" : "Januari";
                break;
            case 2:
                return ($global != 'id') ? "February" : "Februari";
                break;
            case 3:
                return ($global != 'id') ? "March" : "Maret";
                break;
            case 4:
                return ($global != 'id') ? "April" : "April";
                break;
            case 5:
                return ($global != 'id') ? "May" : "Mei";
                break;
            case 6:
                return ($global != 'id') ? "June" : "Juni";
                break;
            case 7:
                return ($global != 'id') ? "July" : "Juli";
                break;
            case 8:
                return ($global != 'id') ? "August" : "Agustus";
                break;
            case 9:
                return ($global != 'id') ? "September" : "September";
                break;
            case 10:
                return ($global != 'id') ? "October" : "Oktober";
                break;
            case 11:
                return ($global != 'id') ? "November" : "November";
                break;
            case 12:
                return ($global != 'id') ? "Desember" : "Desember";
                break;
        }
    }
}

?>
