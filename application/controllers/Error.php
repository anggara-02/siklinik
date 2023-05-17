<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends CI_Controller {

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
    private $st = NULL;

    public function __construct() {
        parent::__construct();
        /* $this->st = new Stencil();
        $this->st->layout('404_layout');
        // $this->mylib->set_session_lang('') */;
    }

    public function index() {
		show_error(404,404);
        /* $common['folder'] = $this->mylib->load_theme();
        $common['title'] = 'Page Not Found | SMS Assessment Portal';
        $this->session->set_userdata("last_url", "error");
        $this->st->slice('head');
        $this->st->paint('404_view', $common); */
    }

}
