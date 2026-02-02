<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors','Off');
class C_dashboard extends CI_Controller {

    
    
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('status_login') != "login"){
            redirect(base_url('login'));
        };

        $this->load->model('M_barang');
        $this->load->model('M_customer');
        $this->load->model('M_supplier','supplier');
        $this->load->model('M_Eoq', 'eoq');
        
    }
    

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['content'] = "v_home";
        // $data['count_customer'] = $this->M_customer->count_customer();
        $data['count_supplier'] = @$this->supplier->get_supplier() ? count($this->supplier->get_supplier()) : 0;

        $data['count_barang'] = $this->M_barang->count_barang();
        $data['count_barang_masuk'] = $this->M_barang->count_barang_masuk();
        $data['count_barang_keluar'] = $this->M_barang->count_barang_keluar();

        // Data detail untuk modal
        $data['data_supplier'] = $this->supplier->get_supplier();
        $data['data_barang'] = $this->M_barang->get_barang();
        $data['data_pembelian'] = $this->M_barang->get_tr_barang();
        $data['data_penjualan'] = $this->M_barang->get_tr_jual_barang();

        $resBarang = [];

        foreach ($this->M_barang->get_barang() as $res) {
            $res->eoq = $this->eoq->get_eoq($res->kd_barang);

            if ($res->stok_awal <= $res->eoq->reorder_poin) {
                $resBarang[] = $res;
            }
        }
        $data['get_barang'] = $resBarang;
        $this->load->view('v_masterpage',$data);        
    }
    

}

/* End of file C_dashboard.php */
