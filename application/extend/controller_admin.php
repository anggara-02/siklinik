<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

class controller_admin extends CI_Controller{
    
    //set property untuk template admin
    var $module,$template,$ThemeUrl;
    var $data=array(); 
    var $keyAdmin,$keyFront,$keyOther,$session_login; 
    public function __construct() { 
        parent::__construct(); 
		$this->keyAdmin=common_lib::keySession('admin');
		$this->keyFront=common_lib::keySession('front'); 
		$this->keyOther=common_lib::keySession('other'); 
		$this->module=common_lib::themeAdmin();  
		$this->template=common_lib::getTheme(); 
		$this->ThemeUrl=common_lib::getThemeUrl(); 
		common_lib::checkLogin($this->module); 
		if(isset($_SESSION[$this->keyAdmin]))
		{
			$this->session_login=$_SESSION[$this->keyAdmin];
		}
		
		
		$context = stream_context_create(array(
			'http' => array('ignore_errors' => true),
		));

		$result = file_get_contents(base_url('admin/log/execute'), false, $context);
		$result = file_get_contents(base_url('admin/rekap/init_kemasan_bertingkat'), false, $context);
    }
	
	public function angka($inp=0, $max_digit=0){
		$bil_bulat 	= floor($inp);
		$desimal	= $inp-$bil_bulat;
		$format 	= number_format($bil_bulat, 0, ',', '.');
		
		if($desimal > 0){
			$format .= ',' . substr(floatval(round($desimal,$max_digit)),2);	
		}
		return($format);
	}

	public function format_tanggal($tanggal){
		$array = explode(' ', $tanggal);
		$arraydate = explode('-', $array[0]);
		$day = $arraydate[2];

		if(count($array)==1) {
			$array[1] = '';
		} else {
			$array[1] = ' - ' . substr($array[1], 0, 8);
		}

		if(count($arraydate) == 3)
		{
			return $day . '-' . $arraydate[1] . '-' . $arraydate[0];
		} else {
			return null;
		}

	}
	
	public function angka_bulat($inp=0){
		$bil_bulat 	= floor($inp);
		return($bil_bulat);
	}

	public function day_name($day) {
        $days = ['id' => ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu']];
        return $days['id'][$day];
    }

	public function name_user($id){
		$query 	= $this->db->query("SELECT role_id, user_name, user_karyawan FROM data_user WHERE user_id = '$id'");
		$result = $query->row();
		return $result;
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