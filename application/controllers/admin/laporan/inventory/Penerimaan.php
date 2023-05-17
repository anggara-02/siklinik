<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/extend/controller_admin.php';
class penerimaan extends controller_admin
{
    protected $st, $access, $class;

    public function __construct()
    {
        parent::__construct();
        $_model = __class__ . '_model';
        $this->load->model($this->module . '/laporan/inventory/' . $_model);
        $this->access = "akses_setting_user";
        $this->class = "Laporan Inventory Penerimaan";
    }

    public function index()
    {
        redirect(base_url('admin/laporan/inventory/' . __CLASS__ . '/data'));
    }

    public function data()
    {

        common_lib::hak_akses($this->access, __function__, 'controller');
        $this->session->set_userdata("last_url", __class__ . '/' . __function__);
        $common = common_lib::getState($this);
        $common['title'] = ucfirst($this->class);
        $st = new Stencil();

        $st->slice('head_login');
        $common['class'] = __class__;
        $common['js_files'] = '';
        $common['css_files'] = '';
        $common['access'] = $this->access;
        $common['role_arr'] = '';

        $st->paint($this->template . '/' . $this->module, '/laporan/inventory/' . __function__ . '_' . __class__, $common);
    }
}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */