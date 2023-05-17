<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */
	
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'/extend/controller_admin.php';
class dashboard extends controller_admin {
	protected $st; 
	
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
		$this->load->model($this->module.'/'.__class__.'/'.__class__.'_model'); 
		$this->mainModel=new $_model();
		$this->class="Dashboard";
    }

    public function tes_koneksi() {   
		echo json_encode(
			array(
				'status'=>200,
				'message'=>'ok',
			)
		);
	}
	
    public function test_print() {  
		phpinfo();
		/* contoh text */  
		$text = 'Eh, ini adalah pesan text yang akan tercetak di printer...!';     
		/* tulis dan buka koneksi ke printer */    
		$printer = printer_open("POS58 Printer(2)");  
		/* write the text to the print job */  
		printer_write($printer, $text);   
		/* close the connection */ 
		printer_close($printer);
		
	}
	
    public function index() {  
	 
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);  
		
        $common['session_login'] = $this->session_login; 
        $common['title'] = ucfirst(__class__);
        $st = new Stencil(); 
		  
		  
        $breadcrumbs_arr = array();
         $breadcrumbs_arr[] = array(
            'name' =>  $common['title'],
            'class' => "fa fa-home",
            'link' => base_url().$this->module.'/'.__class__.'/'.__function__,
            'current' => true, //boolean
        );
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_arr,$this->template,$this->module);
		 
        $st->slice('head_login');
        $common['ThemeUrl'] =$this->ThemeUrl;
        $common['module'] =$this->module; 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }

}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */