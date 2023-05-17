<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	protected $template,$st;
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct(); 
		$this->template=common_lib::getTheme();
		$this->common_lib->hasLogin();
    }

    public function index() { 
		redirect(base_url('manage'));
        /* $this->session->set_userdata("last_url", __function__);
        $common['title'] = 'Halaman Utama';
        $st = new Stencil();
		
        $st->slice('head_login');
        $common['js_files'] = '';
        $common['ThemeUrl'] =common_lib::getThemeUrl();
        $common['css_files'] = '';
		
        $st->paint($this->template.'/front',__class__.'/'.__function__, $common); */
    }

}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */