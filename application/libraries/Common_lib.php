<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

defined('BASEPATH') or exit('No direct script access allowed');

class common_lib
{

	var $CI;

	public function calculate_age($dateOfBirth = '')
	{
		$age = '- Tahun';
		if ($dateOfBirth != '') {
			$today = date("Y-m-d");
			$diff = date_diff(date_create($dateOfBirth), date_create($today));

			$age = $diff->format('%y') . ' Tahun';
		}

		return $age;
	}
	public static function currenShift()
	{
		$lib = new common_lib;
		$now = date('H:i:s');
		$data_shift = $lib->select_row('data_shift', 'shift_is_active=1 AND is_delete=0 AND shift_hour_start<="' . $now . '" AND shift_hour_end>="' . $now . '"');
		return isset($data_shift['shift_id']) ? $data_shift['shift_id'] : 0;
	}

	public static function currenShiftName()
	{
		$lib = new common_lib;
		$now = date('H:i:s');
		$data_shift = $lib->select_row('data_shift', 'shift_is_active=1 AND is_delete=0 AND shift_hour_start<="' . $now . '" AND shift_hour_end>="' . $now . '"');
		return isset($data_shift['shift_name']) ? $data_shift['shift_name'] : '-';
	}

	public static function convertdate($format = 'd-m-Y', $date = "")
	{
		return date($format, strtotime($date));
	}

	/**
	 * handle upload
	 */
	public function do_upload($filesName, $path = "assets/images/static", $allowed_types = "jpg|png|jpeg|pdf|doc")
	{
		$CI = &get_instance();
		$status = 200;
		$message = 'Files is success saved';

		$fileUpload = (isset($_FILES[$filesName]['name']) and trim($_FILES[$filesName]['name']) != '') ? $_FILES[$filesName] : array();
		$file = "";
		if (!empty($fileUpload)) {

			$pathImage = $path;
			$config = array();
			$config['upload_path'] = FCPATH . '/' . $pathImage;
			$config['allowed_types'] = $allowed_types;
			$config['max_size'] = '1024'; //KB
			$config['file_name'] = $filesName . uniqid();

			// echo '<pre>';print_r($filesName);exit;
			$CI->load->library('upload', $config);


			// Alternately you can set preferences by calling the initialize function. Useful if you auto-load the class:
			$CI->upload->initialize($config);

			$isComplete = $CI->upload->do_upload($filesName);
			if ($isComplete) {
				$dataImage = $CI->upload->data();

				$file = $pathImage . $dataImage['file_name'];
				$status = 200;
				$message = 'File berhasil disimpan';
			} else {
				$status = 500;
				$message = $CI->upload->display_errors('<p>', '</p>');;
			}
		}

		return array(
			'file' => $file,
			'status' => $status,
			'message' => $message,
		);
	}

	public static function isSuperuser()
	{
		$lib = new common_lib;
		$keyAdmin = common_lib::keySession("admin");
		$sesi = $_SESSION[$keyAdmin];
		$akses = 0;
		if ($sesi['grup']['role_type'] == "superuser") {
			return true;
		}

		return false;
	}

	public static function hak_akses($column_akses = "", $fungsi = "data", $source = "menu")
	{
		$lib = new common_lib;
		$keyAdmin = common_lib::keySession("admin");
		$sesi = $_SESSION[$keyAdmin];
		$akses = 0;
		if ($sesi['grup']['role_type'] == "superuser") {
			$akses = 1;
		}
		if ($sesi['grup']['role_type'] == "administrator") {
			$index = 0;
			switch (strtolower($fungsi)) {
				case 'data':
					$index = 0;
					break;
				case 'add':
					$index = 1;
					break;
				case 'edit':
					$index = 2;
					break;
				case 'delete':
					$index = 3;
					break;
				case 'access':
					$index = 4;
					break;
				case 'detail':
					$index = 5;
					break;
			}
			$sesi['akses'][$column_akses] = isset($sesi['akses'][$column_akses]) ? $sesi['akses'][$column_akses] : '';
			$arr = explode('~', $sesi['akses'][$column_akses]);
			if (isset($sesi['akses'][$column_akses][$index]) && isset($arr[$index]) && $arr[$index] == '1') {
				$akses = 1;
			}
		}
		if ($source == "menu") {
			return $akses;
		} else {
			if (!$akses) {
				die('Maaf anda tidak memiliki akses.');
			}
		}
	}

	public static function pembulatan($value)
	{
		$config = common_lib::getConfig();
		if ($config['config_app_pembulatan'] == 1000) {
			return floor(round(intval($value), -3));
		} else if ($config['config_app_pembulatan'] == 100) {
			return floor(round(intval($value), -2));
		} else if ($config['config_app_pembulatan'] == 50) {
			$value = ceil($value);
			$puluhan = substr(($value), -2);
			$puluhan = ($puluhan <= 50) ? ($puluhan > 0 ? (50 - $puluhan) : $puluhan) : (100 - $puluhan);
			return ($value + $puluhan);
		}

		return ($value);
	}

	public static function admin_user_id()
	{
		$keyAdmin = common_lib::keySession("admin");
		return ($_SESSION[$keyAdmin]['user_id']) ? $_SESSION[$keyAdmin]['user_id'] : '0';
	}

	public static function admin_shift_name()
	{
		$keyAdmin = common_lib::keySession("admin");
		return ($_SESSION[$keyAdmin]['shift']['shift_name']) ? $_SESSION[$keyAdmin]['shift']['shift_name'] : '-';
	}

	public static function admin_shift()
	{
		$keyAdmin = common_lib::keySession("admin");
		return ($_SESSION[$keyAdmin]['shift']) ? $_SESSION[$keyAdmin]['shift'] : array();
	}

	public static function admin_user_name()
	{
		$keyAdmin = common_lib::keySession("admin");
		return ($_SESSION[$keyAdmin]['user_name']) ? $_SESSION[$keyAdmin]['user_name'] : '0';
	}

	public static function remove_currency_format($value)
	{
		$result = str_replace(array('.', ','), array('', '.'), $value);
		return $result;
	}

	public static function currency_format($value, $format = 0)
	{
		$value = ($value == "") ? 0 : $value;
		$result = number_format($value, $format, ',', '.');

		return $result;
	}

	/* 
		standart store form for all
		jika custom maka ada di model masih2 module
	*/
	function store_form($table = "", $form = array(), $where_update = array(), $is_new = true)
	{
		$CI = &get_instance();
		unset($form['save']); //unset save
		$db = (isset($_SESSION['custom_db'])) ? $_SESSION['custom_db'] : 'default';
		$db2 = $CI->load->database($db, TRUE);

		if (trim($table) == "" || empty($form)) {
			return array(
				'primary_key' => 0,
				'status' => 500,
				'message' => 'Aksi yang dilakukan gagal. Cek kembali parameter inputan anda.',
			);
		}
		if (empty($where_update)) {
			$db2->insert($table, $form);

			return array(
				'primary_key' => $db2->insert_id(),
				'status' => 200,
				'message' => 'Simpan data berhasil dilakukan.',
			);
		} else {
			if ($is_new) {
				$form['last_update'] = date('Y-m-d H:i:s');
				$form['last_user_id'] = isset($_SESSION[$_SESSION['temp_for_action']]['user_id']) ? $_SESSION[$_SESSION['temp_for_action']]['user_id'] : '0';
			}
			$db2->update($table, $form, $where_update);
			unset($_SESSION['temp_for_action']);
			return array(
				'primary_key' => 0,
				'status' => 200,
				'message' => 'Ubah data berhasil dilakukan.',
			);
		}



		return array(
			'primary_key' => 0,
			'status' => 500,
			'message' => 'Aksi yang dilakukan gagal. Cek kembali parameter inputan anda.',
		);
	}

	function delete_semu($table = "", $where_delete = array(), $kolom = 'is_delete')
	{
		$CI = &get_instance();

		if (trim($table) == "" || empty($where_delete)) {
			return array(
				'primary_key' => 0,
				'status' => 500,
				'message' => 'Aksi yang dilakukan gagal. Cek kembali parameter inputan anda.',
			);
		}
		if (!empty($where_delete)) {
			$db = (isset($_SESSION['custom_db'])) ? $_SESSION['custom_db'] : 'default';
			$db2 = $CI->load->database($db, TRUE);
			// $where_delete['is_permanent']=0;
			$data = array($kolom => 1);
			$db2->update($table, $data, $where_delete);

			return array(
				'primary_key' => 0,
				'status' => 200,
				'message' => 'Hapus data berhasil dilakukan.',
			);
		}

		return array(
			'primary_key' => 0,
			'status' => 500,
			'message' => 'Aksi yang dilakukan gagal. Cek kembali parameter inputan anda.',
		);
		//$data_form=array();
	}

	function delete_permanent($table = "", $where_delete = array())
	{
		$CI = &get_instance();

		if (trim($table) == "" || empty($where_delete)) {
			return array(
				'primary_key' => 0,
				'status' => 500,
				'message' => 'Aksi yang dilakukan gagal. Cek kembali parameter inputan anda.',
			);
		}
		if (!empty($where_delete)) {
			// $where_delete['is_permanent']=0;
			$CI->db->delete($table, $where_delete);

			return array(
				'primary_key' => 0,
				'status' => 200,
				'message' => 'Hapus data berhasil dilakukan.',
			);
		}

		return array(
			'primary_key' => 0,
			'status' => 500,
			'message' => 'Aksi yang dilakukan gagal. Cek kembali parameter inputan anda.',
		);
		//$data_form=array();
	}

	public function create_breadcrumbs($breadcrumbs_array, $module)
	{
		ob_start();
		$result = '';
		$template = $this->getTheme();
		switch ($module) {
			case 'admin':
				switch ($template) {
					case 'free':
?>
<div class="section-header-breadcrumb">
    <!-- start: PAGE TITLE & BREADCRUMB -->
    <?php
							if (!empty($breadcrumbs_array)) {

								foreach ($breadcrumbs_array as $rowArr) {
									foreach ($rowArr as $variable => $value) {
										${$variable} = $value;
									}

							?>
    <div class="breadcrumb-item"><?php echo isset($name) ? $name : '' ?></div>
    <?php
								}
							}
							?>

</div>
<?php
						break;
				}
				break;
		}


		$breadcrumbs = ob_get_contents();
		ob_end_clean();

		return $breadcrumbs;
	}

	public static function keySession($source = "front")
	{
		$CI = &get_instance();
		switch (strtolower($source)) {
			case 'admin':
				return md5($source . __function__);
				break;
			case 'front':
				return md5($source . __function__);
				break;
		}

		return md5('other' . __function__);
	}

	public function select_result($table, $where = 1, $field = "*", $limit = 'no_limit', $offset = 'no_offset', $orderBy = '')
	{
		$CI = &get_instance();
		$db = (isset($_SESSION['custom_db'])) ? $_SESSION['custom_db'] : 'default';
		$db2 = $CI->load->database($db, TRUE);
		$sql = 'SELECT ' . $field . ' FROM ' . $table . '
              WHERE ' . $where . ' 
              ';
		if (trim($orderBy) != '') {
			$sql .= ' ORDER BY ' . $orderBy;
		}
		if (is_numeric($limit) and is_numeric($offset)) {
			$sql .= ' LIMIT ' . $offset . ', ' . $limit;
		}
		$exec = $db2->query($sql);
		return $exec->result_array();
	}

	function select_one($field = '', $table = '', $where = '1')
	{
		$CI = &get_instance();
		$db = (isset($_SESSION['custom_db'])) ? $_SESSION['custom_db'] : 'default';
		$db2 = $CI->load->database($db, TRUE);
		$result = $db2->query("SELECT " . $field . " FROM " . $table . " WHERE " . $where . " LIMIT 1");
		if ($result->num_rows() > 0) {
			$row = $result->row_array();
			return $row[$field];
		} else return "";
	}

	function select_row($table = '', $where = '1', $field = '*')
	{
		$CI = &get_instance();

		$db = (isset($_SESSION['custom_db'])) ? $_SESSION['custom_db'] : 'default';
		$db2 = $CI->load->database($db, TRUE);
		$result = $db2->query("SELECT " . $field . " FROM " . $table . " WHERE " . $where . " LIMIT 1");
		if ($result->num_rows() > 0) {
			$row = $result->row_array();
			return $row;
		} else return array();
	}

	public static function getState($params)
	{
		$CI = &get_instance();
		$data = array();

		$data['status'] = (isset($_GET['status']) and trim($_GET['status']) != '') ? $_GET['status'] : 200;
		$data['message'] = (isset($_GET['flag']) and trim($_GET['flag']) != '') ? base64_decode($_GET['flag']) : '';
		$data['keyAdmin'] = isset($params->keyAdmin) ? $params->keyAdmin : '';
		$data['module'] = isset($params->module) ? $params->module : '';
		$data['class'] = __class__;
		$common['config'] = common_lib::getConfig();

		return $data;
	}

	public static function setState($_data)
	{
		$CI = &get_instance();
		$data = array();

		$data['status'] = (isset($_data['status']) and trim($_data['status']) != '') ? $_data['status'] : 200;
		$data['message'] = (isset($_data['flag']) and trim($_data['flag']) != '') ? base64_encode($_data['flag']) : '';

		return $data;
	}

	public static function hasLogin($module = "front")
	{
		$CI = &get_instance();
		/* echo common_lib::keySession($module).'<pre>'; print_r($_SESSION); EXIT; */
		return (isset($_SESSION[common_lib::keySession($module)])) ? redirect($module . '/dashboard') : '';
	}

	public static function checkLogin($module = "front")
	{
		$CI = &get_instance();

		$referer = rawurlencode("http://" . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', $_SERVER['REQUEST_URI']) . '/');
		$origin = isset($_SERVER['HTTP_REFERER']) ? rawurlencode($_SERVER['HTTP_REFERER']) : $referer;
		/* redirect(base_url() . 'login?url=' . $origin); */
		if (!isset($_SESSION[common_lib::keySession($module)])) {
			$url_login = ($module == "front") ? redirect('login?goto=' . $origin) : redirect('manage?goto=' . $origin);
		}

		return true;
	}

	public static function themeAdmin()
	{
		$CI = &get_instance();
		return "admin";
	}

	public static function themeFront()
	{
		$CI = &get_instance();
		return "front";
	}

	public static function getSliceUrl()
	{
		$CI = &get_instance();
		$lib = new common_lib;
		return APPPATH . 'views/' . $lib->getTheme() . '/admin/slices';
	}


	public static function getTheme()
	{
		$CI = &get_instance();
		return $CI->config->item('template');
	}

	public static function getThemeUrl()
	{
		$CI = &get_instance();
		$lib = new common_lib;
		return base_url() . 'assets/' . $lib->getTheme() . '/';
	}
	public static function getConfig()
	{
		$CI = &get_instance();
		$lib = new common_lib;
		$config = $lib->select_row('setting_config', '1');
		// $config=array();
		$config_app = array(
			"config_app_name" => "SI Klinik",
			"config_app_keywords" => "Sistem Informasi Klinik",
			"config_app_description" => "Sistem Informasi Klinik by Megistra Tim",
			"config_app_footer" => "Megistra &copy; 2021" . ((date('Y') != '2021') ? '-' . date('Y') : '') . ". All rights reserved.",
			"config_app_copyright" => "Supported by megistra.com",
			"config_app_favicon" => "assets/images/static/simrmfavicon.ico",
			"config_app_logo" => "assets/images/static/logo.png",
			"config_app_version" => "1.0.0",
		);

		return array_merge($config, $config_app);
	}

	/**
      menghilangkan tag php
	 */
	static function removeHtmlTag($content)
	{
		$data = '';
		$content = explode("\n", $content);
		for ($i = 0; $i < count($content); $i++) {
			$line = rtrim($content[$i]);
			while (isset($content[$i + 1]) && strlen($content[$i + 1]) > 0 && ($content[$i + 1]{
			0} == ' ' || $content[$i + 1]{
			0} == "\t")) {
				$line .= rtrim(substr($content[++$i], 1));
			}
			$data .= $line;
		}
		return $data;
	}


	function get_query($params, $count = false, $db = 'default')
	{
		$CI = &get_instance();
		$db2 = $CI->load->database($db, TRUE);
		extract($this->get_query_condition($params, $count));
		$sql = "
            SELECT $parent_select  
            FROM 
            (
                SELECT $select 
                FROM $table 
                $join 
                $where_detail 
                $group_by_detail
            ) result 
            $where 
            $group_by 
            $sort 
            $limit
        ";
		//$sort

		//echo $sql;
		//exit;

		// $query = ($db=='default')?$CI->db->query($sql):$db2->query($sql);
		$query = $db2->query($sql);

		if ($count) {
			$row = $query->row();
			return isset($row->row_count) ? $row->row_count : 0;
		} else {
			return $query;
		}
	}

	function get_query_condition($params, $count = false)
	{
		$arr_condition = array();

		$arr_condition['parent_select'] = "*";
		if ($count) {
			$arr_condition['parent_select'] = "COUNT(*) AS row_count";
		}

		$arr_condition['table'] = "";
		if (isset($params['table'])) {
			$arr_condition['table'] = $params['table'];
		}

		$arr_condition['select'] = "*";
		if (isset($params['select'])) {
			$arr_condition['select'] = $params['select'];
		}

		$arr_condition['join'] = "";
		if (isset($params['join'])) {
			$arr_condition['join'] = $params['join'];
		}

		$arr_condition['where_detail'] = " WHERE 1 ";
		if (isset($params['where_detail'])) {
			$arr_condition['where_detail'] .= "AND " . $params['where_detail'];
		}

		$arr_condition['group_by_detail'] = "";
		if (isset($params['group_by_detail'])) {
			$arr_condition['group_by_detail'] = "GROUP BY " . $params['group_by_detail'];
		}

		$arr_condition['where'] = " WHERE 1 ";
		if (isset($params['query']) && $params['query'] != false && $params['query'] != '') {
			$arr_condition['where'] .= "AND " . $params['qtype'] . " LIKE '%" . mysql_real_escape_string($params['query']) . "%' ";
		} elseif (isset($params['optionused']) && $params['optionused'] == 'true') {
			$arr_condition['where'] .= "AND " . $params['qtype'] . " = '" . $params['option'] . "' ";
		} elseif ((isset($params['date_start']) && $params['date_start'] != false) && (isset($params['date_end'])) && $params['date_end'] != false) {
			$arr_condition['where'] .= "AND DATE(" . $params['qtype'] . ") BETWEEN '" . mysql_real_escape_string($params['date_start']) . "' AND '" . mysql_real_escape_string($params['date_end']) . "' ";
		} elseif ((isset($params['num_start']) && $params['num_start'] != false) && (isset($params['num_end'])) && $params['num_end'] != false) {
			$arr_condition['where'] .= "AND " . $params['qtype'] . " BETWEEN '" . mysql_real_escape_string($params['num_start']) . "' AND '" . mysql_real_escape_string($params['num_end']) . "' ";
		}

		if (isset($params['where'])) {
			$arr_condition['where'] .= "AND " . $params['where'];
		}

		$arr_condition['group_by'] = "";
		if (isset($params['group_by'])) {
			$arr_condition['group_by'] = "GROUP BY " . $params['group_by'];
		}


		$arr_condition['sort'] = "";
		if (isset($params['order_by']) && $count == false and trim($params['order_by']) != '') {
			$arr_condition['sort'] = "ORDER BY " . $params['order_by'];
		} elseif (isset($params['sortname']) && isset($params['sortorder']) && $count == false and trim($params['sortname']) != '') {
			$arr_condition['sort'] = "ORDER BY " . $params['sortname'] . " " . $params['sortorder'];
		}

		$arr_condition['limit'] = "";
		if (isset($params['rp']) && $count == false) {
			$offset = (($params['page'] - 1) * $params['rp']);
			$arr_condition['limit'] = "LIMIT $offset, " . $params['rp'];
		}


		if (isset($params['length']) && ($params['length'] >= 0) && $count == false) {
			//$offset = (($params['start']) * $params['length']);
			$offset = $params['start'];
			$arr_condition['limit'] = "LIMIT $offset, " . $params['length'];
		}

		return $arr_condition;
	}
}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */