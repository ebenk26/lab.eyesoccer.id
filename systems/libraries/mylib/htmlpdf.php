<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/html2pdf/html2pdf.class.php';
//require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

//class PDF extends TCPDF
class Htmlpdf extends HTML2PDF
{
    function __construct()
    {
        parent::__construct();
    }
}

?>
