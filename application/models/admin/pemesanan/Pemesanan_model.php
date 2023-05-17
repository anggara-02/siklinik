<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . '/extend/controller_model.php';

class Pemesanan_model extends controller_model
{
    protected $role_arr, $keyAdmin;

    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        $this->keyAdmin = common_lib::keySession('admin');
    }

    public function get_alkes($barcode)
    {
        $params['table'] = 'data_alkes';
        $params['select'] = "data_alkes.*";
        $where = "is_delete=0 AND alkes_barcode = '$barcode'";

        $params['where'] = $where;
        $params['order_by'] = "alkes_id DESC";

        $query = $this->CI->common_lib->get_query($params);
        print_r($query);die();

        return $query->result();
    }

    public function get_obat($barcode)
    {
        $params['table'] = 'data_obat';
        $params['select'] = "*";
        $where = "is_delete=0 AND obat_barcode = '$barcode'";

        $params['where'] = $where;
        $params['order_by'] = "obat_id DESC";

        $query = $this->CI->common_lib->get_query($params);

        return $query->result();
    }

    public function trx_save($no_sp, $jenis_sp, $tanggal, $supplier, $detail_barang, $pemesanan_id){
        $result = array();
        $status = false;
        $items = array();
        $data = array();
        
        $user_karyawan = $_SESSION[$this->keyAdmin]['user_id'];

        $date = date("Y-m-d H:i:s");
        $null = "0000-00-00 00:00:00";
        
        try {
            if ($pemesanan_id == 'save') {   

                //insert ke data_pemesanan
                $input_pemesanan = array();
                $input_pemesanan['pemesanan_no_sp'] = $no_sp;
                $input_pemesanan['pemesanan_jenis_sp'] = $jenis_sp;
                $input_pemesanan['pemesanan_tanggal'] = $tanggal;
                $input_pemesanan['pemesanan_supplier_id'] = $supplier;
                $input_pemesanan['is_delete'] = 0;
                $input_pemesanan['is_permanent'] = 0;
                $input_pemesanan['user_karyawan'] = $user_karyawan;
                
                $this->CI->db->insert('data_pemesanan', $input_pemesanan);
                $pemesanan_id = $this->CI->db->insert_id();         
                        
                //input ke detail_pemesanan
                $input_detail = array();
                $arr_api = array();
                if (!empty($detail_barang)) {
                    foreach ($detail_barang as $key => $value) {
                        $input_detail[$key]['detail_pemesanan_pemesanan_id'] = $pemesanan_id;
                        $input_detail[$key]['detail_pemesanan_barcode'] = $value['barcode'];
                        $input_detail[$key]['detail_pemesanan_nama_barang'] = $value['nama_barang'];
                        $input_detail[$key]['detail_pemesanan_kemasan'] = $value['kemasan'];
                        $input_detail[$key]['detail_pemesanan_qty'] = $value['qty'];
                        $input_detail[$key]['is_obat'] = $value['is_obat'];
                    }
                }
                $this->CI->db->insert_batch('data_detail_pemesanan', $input_detail);

                $data['status']=200;
                $message = "Data berhasil ditambah";
                $status = true;
            }else{

                //Update WHERE id ke pemesanan
                $input_pemesanan = array();
                $input_pemesanan['pemesanan_no_sp'] = $no_sp;
                $input_pemesanan['pemesanan_jenis_sp'] = $jenis_sp;
                $input_pemesanan['pemesanan_tanggal'] = $tanggal;
                $input_pemesanan['pemesanan_supplier_id'] = $supplier;
                $input_pemesanan['is_delete'] = 0;
                $input_pemesanan['is_permanent'] = 0;
                $input_pemesanan['user_karyawan'] = $user_karyawan; 
                
                $this->CI->db->where('pemesanan_id', $pemesanan_id);
                $this->CI->db->update('data_pemesanan', $input_pemesanan);
                
                //Update WHERE id ke detail pemesanan
                $input_detail = array();
                $arr_ = array();
                if (!empty($detail_barang)) {
                    $this->CI->db->query("DELETE FROM data_detail_pemesanan WHERE detail_pemesanan_pemesanan_id = '$pemesanan_id'");
                    foreach ($detail_barang as $key => $value) {
                        $input_detail[$key]['detail_pemesanan_pemesanan_id'] = $pemesanan_id;
                        $input_detail[$key]['detail_pemesanan_barcode'] = $value['barcode'];
                        $input_detail[$key]['detail_pemesanan_nama_barang'] = $value['nama_barang'];
                        $input_detail[$key]['detail_pemesanan_kemasan'] = $value['kemasan'];
                        $input_detail[$key]['detail_pemesanan_qty'] = $value['qty'];
                        $input_detail[$key]['is_obat'] = $value['is_obat'];
                    }
                }
                
                $this->CI->db->insert_batch('data_detail_pemesanan', $input_detail);
                $data['status']=200;
                $message = "Data berhasil diupdate";
                $status = true;
            }
        } catch (Exception $e) {
            $status =false;
        }
        
        if ($status == false) {
            $data['status']=500;
            $data['message'] = "Data gagal disimpan";
        } else {
            $data['status']=200;
            $data['message'] = $message;
        }

        return $data;
    }

    function get_data($id = 0)
	{ 
        $json_data = array();

        if ($id == 0) {
            
        /*=========== Get data parrent ============*/
            $params = isset($_POST) ? $_POST : array();
            $params['table'] = "data_pemesanan";
            $params['select'] = "data_pemesanan.*, s.supplier_id, s.supplier_name";
            $where=" is_delete= '0' AND is_penerimaan ='0'";
            $join =" LEFT JOIN data_supplier s ON pemesanan_supplier_id = s.supplier_id ";
           

            if(trim($this->CI->input->get('no_sp'))!='')
            {
                $where.=" AND pemesanan_no_sp LIKE '%{$this->CI->input->get('no_sp')}%'";
            }

            if(trim($this->CI->input->get('supplier'))!='')
            {
                $where.=" AND pemesanan_supplier_id = '{$this->CI->input->get('supplier')}'";
            }
            
            if(trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir'))!='')
            {
                $where.=" AND pemesanan_tanggal BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
            }
            
            $params['join'] =$join;
            $params['where'] =$where;
            $params['order_by'] = "pemesanan_id DESC";
            
            $query_parrent = $this->CI->common_lib->get_query($params);
            $total_parrent = $this->CI->common_lib->get_query($params, true);
            $json_data['parrentData'] =$query_parrent->result();
            $json_data['total'] =$total_parrent;
            
        /*=========== Get detail ============*/
            $params1 = isset($_POST) ? $_POST : array();
            $sql_where = '';

            $sql_where .= "AND data_pemesanan.is_penerimaan ='0' AND data_pemesanan.is_delete = '0'";
            
            // $params1['table'] = 'data_pemesanan';
            // $params1['select'] = "data_pemesanan.*, d.*, s.supplier_id, s.supplier_name";
            // $join1 =' LEFT JOIN data_supplier s ON pemesanan_supplier_id = s.supplier_id';
            // $join1 .=' LEFT JOIN data_detail_pemesanan d on pemesanan_id = d.detail_pemesanan_pemesanan_id';
            // $where1=" is_penerimaan ='0' AND is_delete = '0'";

            
            if(trim($this->CI->input->get('no_sp'))!='')
            {
                $sql_where .=" AND pemesanan_no_sp LIKE '%{$this->CI->input->get('no_sp')}%'";
            }
            
            if(trim($this->CI->input->get('supplier'))!='')
            {
                $sql_where .=" AND pemesanan_supplier_id = '{$this->CI->input->get('supplier')}'";
            }
            
            if(trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir'))!='')
            {
                $sql_where .=" AND pemesanan_tanggal BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
            }
            
            
            // $params1['join'] = $join1;
            // $params1['where'] = $where1;
            // $params1['order_by'] = "pemesanan_id DESC";

            $sql = "
                SELECT data_pemesanan.*, d.*, s.supplier_id, s.supplier_name 
                FROM data_pemesanan
                LEFT JOIN data_supplier s ON pemesanan_supplier_id = s.supplier_id
                LEFT JOIN data_detail_pemesanan d ON pemesanan_id = d.detail_pemesanan_pemesanan_id
                WHERE 1 $sql_where
                ORDER BY pemesanan_id DESC;
            ";
            
            // $query_detailData = $this->CI->common_lib->get_query($params1);
            $query_detailData = $this->CI->db->query($sql);
            $json_data['detailData'] =$query_detailData->result();
            $json_data['tes'] = 'ID NO';

            return $json_data;
        }else{
            //Get Data by ID
            $result = $this->get_data_by_id($id);

            return $result;
        }
	}


    public function alkes($pemesanan_id)
	{
       $sql = "
        SELECT d.detail_pemesanan_pemesanan_id, d.detail_pemesanan_barcode, d.detail_pemesanan_nama_barang, d.detail_pemesanan_kemasan, d.detail_pemesanan_qty
        FROM data_pemesanan p 
        LEFT JOIN data_detail_pemesanan d 
        ON p.pemesanan_id = d.detail_pemesanan_pemesanan_id
        WHERE d.is_obat = 0 AND d.detail_pemesanan_pemesanan_id = '$pemesanan_id'
        ORDER BY p.pemesanan_id";

        $query = $this->CI->db->query($sql);
        
        return $query;
	}
	
	public function obat($pemesanan_id)
	{
        $sql = "
        SELECT d.detail_pemesanan_pemesanan_id, d.detail_pemesanan_barcode, d.detail_pemesanan_nama_barang, d.detail_pemesanan_kemasan, d.detail_pemesanan_qty
        FROM data_pemesanan p 
        LEFT JOIN data_detail_pemesanan d 
        ON p.pemesanan_id = d.detail_pemesanan_pemesanan_id
        WHERE d.is_obat = 1 AND d.detail_pemesanan_pemesanan_id = '$pemesanan_id'
        ORDER BY p.pemesanan_id";

        $query = $this->CI->db->query($sql);
        
        return $query;
	}

    function get_data_by_id($id){
        $parrentData = array();

        /*=========== Get data parrent by id ============*/
        $params['table'] = "data_pemesanan";
        $params['select'] = "data_pemesanan.*, s.supplier_id, s.supplier_name";
        $where=" is_delete=0 AND pemesanan_id = '{$id}' AND is_penerimaan='0'";
        $join =" LEFT JOIN data_supplier s ON pemesanan_supplier_id = s.supplier_id ";
        
        $params['join'] =$join;
        $params['where'] =$where;
        $params['order_by'] = "pemesanan_id DESC";

        $query_parrent = $this->CI->common_lib->get_query($params);
        $total_parrent = $this->CI->common_lib->get_query($params, true);
        
        $json_data['parrentData'] =$query_parrent->result();
        $json_data['total'] =$total_parrent;
        
        /*=========== Get detail by id ============*/
        $params1['table'] = 'data_pemesanan';
        $params1['select'] = "data_pemesanan.*, d.*, s.supplier_id, s.supplier_name";
        $where1="is_delete=0 AND pemesanan_id = '{$id}'";
        
        $join =' LEFT JOIN data_supplier s ON pemesanan_supplier_id = s.supplier_id';
        $join .=' LEFT JOIN data_detail_pemesanan d on pemesanan_id = d.detail_pemesanan_pemesanan_id';
        
        $params1['join'] = $join;
        $params1['where'] =$where1;
        $params1['order_by'] = "pemesanan_id DESC";

        $query_detailData = $this->CI->common_lib->get_query($params1);
        $json_data['detailData'] =$query_detailData->result();

        foreach ($json_data['detailData'] as $val) {
            $id = $val->detail_pemesanan_pemesanan_id;
            if (!isset($data[$id])) {
                $data[$id] = array();
            }

            $data[$id][] = array(
                'id'           => $id,
                'barcode'      => $val->detail_pemesanan_barcode,
                'nama_barang'  => $val->detail_pemesanan_nama_barang,
                'kemasan'      => $val->detail_pemesanan_kemasan,
                'qty'          => $val->detail_pemesanan_qty,
                'is_obat'      => $val->is_obat,
                'terbilang'    => $this->terbilang($val->detail_pemesanan_qty),
            );
        };

        foreach ($json_data['parrentData'] as $value) {
            if (isset($data[$value->pemesanan_id])) {
                $detail = $data[$value->pemesanan_id];
            } else {
                $detail = '';
            }
            $parrentData['data'][] = array(
                'id'        => $value->pemesanan_id,
                'no_sp'     => $value->pemesanan_no_sp,
                'jenis_sp'  => $value->pemesanan_jenis_sp,
                'tanggal'   => $value->pemesanan_tanggal,
                'supplier'  => $value->supplier_id,
                'detail'    => $detail,
            );
        };
        $parrentData['tes'] = 'ID YES';


        return $parrentData;
    }
}