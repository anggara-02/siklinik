<?php 

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

class controller_front extends CI_Controller{
    
    //set property untuk template admin
    protected $themeId='front',$module,$template,$ThemeUrl;
    protected $data=array(); 
    protected $keyAdmin,$keyFront,$keyOther,$moduleAdmin; 
    public function __construct() { 
        parent::__construct(); 
		$this->keyAdmin=common_lib::keySession('admin');
		$this->keyFront=common_lib::keySession('front'); 
		$this->keyOther=common_lib::keySession('other'); 
		$this->module=common_lib::themeFront(); 
		$this->moduleAdmin=common_lib::themeAdmin(); 
		$this->template=common_lib::getTheme(); 
		$this->ThemeUrl=common_lib::getThemeUrl(); 
    }
	 
	
}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */
?>