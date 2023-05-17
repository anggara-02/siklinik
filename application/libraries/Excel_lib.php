<?php

/*
 * Excel Libraries
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once FCPATH.'assets/phpexcel/PHPExcel.php';
require_once  FCPATH.'assets/phpexcel/PHPExcel/IOFactory.php';

class Excel_lib extends PHPExcel {

    function __construct() {
        parent::__construct();
    }

}

?>
