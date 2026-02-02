<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_barang extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('status_login') != "login"){
            redirect(base_url('login'));
        };
        $this->load->model('M_barang');
        $this->load->model('M_supplier');
    }


    public function index()
    {
        $data['title'] = "Barang";
        $data['content'] = "v_barang";
        $data['get_barang'] = $this->M_barang->get_barang();
        $this->load->view('v_masterpage',$data);
    }

    public function simpan()
    {
        $post = $this->input->post();
        $set_data = array(
          'kd_barang' => $post['kd_barang'],
          'nama_barang' => $post['nama_barang'],
          'satuan' => $post['satuan'],
          // Add new barang field
          'harga_barang' => $post['harga_barang'],
          'ket_barang' => $post['ket_barang'],
          'leadtime' => $post['leadtime'],
          'percentage_biaya_simpan' => $post['persentasi'],
          'biaya_simpan' => (double)(($post['harga_barang']*((int)$post['persentasi']))/100)
        );

        $insert = $this->M_barang->insert_barang($set_data);

        if($insert){
            $data['status'] = "sukses";
        }else{
            $data['status'] = "gagal";
        }
        echo json_encode($data);
    }

    public function get_data($kd_barang)
    {
        $get = $this->M_barang->get_kd_barang($kd_barang);
        if($get){
            echo json_encode($get);
        }else{
            $data['data'] = "Gagal";
            echo json_encode($data);
        }
    }

    public function get_data_all()
    {
        $data=$this->M_barang->get_barang();
        echo json_encode($data);
    }

    public function rubah()
    {
        $post = $this->input->post();
        $set_data = array(
          'nama_barang' => $post['nama_barang'],
          'satuan' => $post['satuan'],
          'harga_barang' => $post['harga_barang'],
          'ket_barang' => $post['ket_barang'],
          'leadtime' => $post['leadtime'],
          'percentage_biaya_simpan' => $post['persentasi'],
          'biaya_simpan' => (double)(($post['harga_barang']*((int)$post['persentasi']))/100)
        );

        $update = $this->M_barang->update_barang($set_data,$post['kd_barang']);
        if($update){
            $data['status'] = "sukses-update";
        }else{
            $data['status'] = "gagal";
        }
        echo json_encode($data);
    }

    public function hapus($kd_barang)
    {
        $hapus = $this->M_barang->del_barang($kd_barang);
        if($hapus){
            redirect('barang');
        }else{
            redirect('barang');
        }
    }

    public function barang_masuk()
    {
        $data['title'] = "Transaksi Pembelian Barang";
        $data['content'] = "v_barang_masuk";
        $data['auto'] = $this->M_barang->get_auto_number();
        $data['get_barang'] = $this->M_barang->get_barang();
        $data['get_supplier'] = $this->M_supplier->get_supplier();
        $this->load->view('v_masterpage',$data);
    }

    public function save_masuk()
    {
        $post = $this->input->post();
        // print_r($post);
        // die;
        $result = array();
        $id_tr_m = $post['id_tr_m'];
        $id_login = $post['id_login'];

        foreach($post['kd_barang'] as $key =>$val){
            $kd_barang = $post['kd_barang'][$key];
            $qr = $this->M_barang->get_barang_kd($kd_barang);
            foreach($qr as $val1){
                $result_stok = array(
                    'stok_awal' =>  $val1->stok_awal + $post['jumlah_masuk'][$key]
                );
                $this->M_barang->update_barang_id($result_stok,$kd_barang);
            };
            $result[] = array(
                'id_tr_m' => $id_tr_m,
                'kd_barang' => $post['kd_barang'][$key],
                'jumlah_masuk' => $post['jumlah_masuk'][$key],
                'tgl_masuk' => date('Y-m-d H:m:s')
            );
        };
        $set_data_header = array(
            'id_tr_m' => $id_tr_m,
            'ket_tr_m' => $post['ket_tr_m'],
            'id_login' => $id_login,
            'id_supplier' => $post['id_supplier']
        );

        $insert_header = $this->M_barang->insert_bm_header($set_data_header);
        $insert_detail = $this->M_barang->insert_bm_detail($result);

        if($insert_header && $insert_detail){
            $this->session->set_flashdata("msg","
                        <div class='alert alert-success alert-dismissible fade show mb-0'>
                            <a href='#' class='close' data-dismiss='alert'>&times;</a>
                            <strong>Success !</strong> Berhasil Membuat Menambahkan Barang !
                        </div>");
        }else{
            $this->session->set_flashdata("msg","
            <div class='alert alert-warning alert-dismissible fade show mb-0'>
                <a href='#' class='close' data-dismiss='alert'>&times;</a>
                <strong>Failed !</strong> Terjadi Kesalahan Membuat Menambahkan Barang !
            </div>");
        };

        redirect('barang/masuk');

    }

    public function tr_barang_masuk()
    {
        $data['title'] = "Data Transaksi Pembelian";
        $data['content'] = "v_tr_barang_masuk";
        $data['get_tr'] = $this->M_barang->get_tr_barang();
        $this->load->view('v_masterpage',$data);
    }

    public function barang_penjualan()
    {
        $data['title'] = "Transaksi Penjualan Barang";
        $data['content'] = "v_barang_penjualan";
        $data['auto'] = $this->M_barang->get_auto_number_keluar();
        $data['get_barang'] = $this->M_barang->get_barang();
        $this->load->view('v_masterpage',$data);
    }

    public function save_penjualan()
    {
        $post = $this->input->post();
        // echo "<pre>";
        // print_r($post);
        // echo "</pre>";
        // die();

        $result = array();
        $result_stok = array();
        $id_tr_k = $post['id_tr_k'];
        $id_login = $post['id_login'];
        $ket_tr_k = $post['ket_tr_k'];

        //Metode Fifo
        foreach($post['kd_barang'] as $key =>$val){
            $a = "";
            $kd_barang = $post['kd_barang'][$key];
            $jumlah_beli = $post['jumlah_masuk'][$key];
            $harga_beli = $post['harga'][$key];


            $qr = $this->M_barang->get_sum_barang_kd($kd_barang);
            $qr2 = $this->M_barang->get_barang_by_kd($kd_barang);

            foreach($qr as $val1){
                    $stok_all = $val1->total;

                    //$this->M_barang->update_barang_id($result_stok,$kd_barang);
            };

            if($jumlah_beli <= $stok_all){
                foreach ($qr2 as $val) {
                    $tgl = $val->tgl_masuk;
                    $stok = $val->jumlah_masuk;
                    $id_tr_m = $val->id_tr_m;
                    $id_tr_m_detail = $val->id_tr_mdetail;

                    if($jumlah_beli > 0){
                        $temp = $jumlah_beli;

                        $jumlah_beli = $jumlah_beli - $stok;

                        if($jumlah_beli > 0){
                            $stok_update = 0;
                        }else{
                            $stok_update = $stok - $temp;

                        }

                        $set_data = array(
                            'jumlah_masuk' => $stok_update
                        );
                         $qr3 = $this->M_barang->update_barang_by_kd($kd_barang,$set_data,$tgl,$id_tr_m_detail);
                         $qr4 = $this->M_barang->insert_barang_tr_keluar_dtl($kd_barang,$stok,$stok_update,$harga_beli,$id_tr_k,$id_tr_m,$id_tr_m_detail);


                    }

                };
            }else{
                $this->session->set_flashdata("msg","
                        <div class='alert alert-danger alert-dismissible fade show mb-0'>
                            <a href='#' class='close' data-dismiss='alert'>&times;</a>
                            <strong>danger !</strong> Stok Barang Tidak Cukup, Stok = $stok_all <br><br>
                        </div>");
                        redirect('barang/trpenjualan');
                        exit();
            }

            $get_barang = $this->M_barang->get_barang_kd($kd_barang);

            foreach ($get_barang as $val_barang) {
                    $stok_awal =  $val_barang->stok_awal;
                    $pemakaian = $val_barang->pemakaian;
            }
            $set_update = array(
                'stok_awal' => $stok_awal - $post['jumlah_masuk'][$key],
                'pemakaian' => $pemakaian + $post['jumlah_masuk'][$key]
            );
            $set_insert_jual = array(
                'jumlah_beli' => $post['jumlah_masuk'][$key],
                'kd_barang' => $kd_barang,
                'id_tr_k' => $id_tr_k
            );
            $qr5 = $this->M_barang->update_barang_id($set_update,$kd_barang);
            $qr6 = $this->M_barang->insert_jual($set_insert_jual);
        };
        //Akhir Metode Fifo
        $set_data_header = array(
            'id_tr_k' => $id_tr_k,
            'ket_tr_k' => $post['ket_tr_k'],
            'id_login' => $id_login,
            'tgl_tr_k' => date('Y-m-d', strtotime($post['tgl_keluar'])). ' ' . date('H:i:s')
            // 'id_customer' => $post['id_customer']
        );

        $insert_header = $this->M_barang->insert_bkeluar_header($set_data_header);


        if($insert_header){
            $this->session->set_flashdata("msg","
                        <div class='alert alert-success alert-dismissible fade show mb-0'>
                            <a href='#' class='close' data-dismiss='alert'>&times;</a>
                            <strong>Success !</strong> Berhasil Menjual Barang !
                        </div>");
        }else{
            $this->session->set_flashdata("msg","
            <div class='alert alert-warning alert-dismissible fade show mb-0'>
                <a href='#' class='close' data-dismiss='alert'>&times;</a>
                <strong>Failed !</strong> Terjadi Kesalahan Menjual Barang !
            </div>");
        };

        redirect('barang/trpenjualan');


    }

    public function tr_barang_penjualan()
    {
        $data['title'] = "Data Transaksi Penjualan";
        $data['content'] = "v_tr_barang_penjualan";
        $data['get_penjualan'] = $this->M_barang->get_tr_jual_barang();
        $this->load->view('v_masterpage',$data);
    }

    public function get_data_tr_jual($id_tr_k)
    {
        $qr = $this->M_barang->get_detail($id_tr_k);
        foreach ($qr as $val) {
            $data[] = array(
                            'id_tr_k' => $val->id_tr_k,
                            'kd_barang' => $val->kd_barang,
                            'nama_barang' => $val->nama_barang,
                            'jumlah_beli' => $val->jumlah_beli,
                            'detail' => $this->M_barang->get_detail_jual($val->id_tr_k,$val->kd_barang)
                        );
        }
        echo json_encode($data);
    }

    public function get_data_tr($id_tr_m)
    {
        $qr = $this->M_barang->get_data_tr_m($id_tr_m);

        echo json_encode($qr);
    }

    public function cetak_penjualan($id_tr_k)
    {

        $mpdf = new \Mpdf\Mpdf();
        $data['get_header'] = $this->M_barang->get_header_by_id($id_tr_k);
        $data['barang'] = $this->M_barang->get_detail_id($id_tr_k);
        $data['sum_detail'] = $this->M_barang->get_sum_detail_id($id_tr_k);
		$html = $this->load->view('v_cetak_penjualan', $data, TRUE);
		$mpdf->WriteHTML($html);
		$mpdf->Output();
    }

    public function get_auto_kd()
    {
        if (isset($_POST['search'])) {
            $result = $this->M_barang->get_auto($_POST['search']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        "satuan"  => $row->satuan,
                        "harga_barang"   => $row->harga_barang,
                        "label" => $row->kd_barang.' - '.$row->nama_barang,
                        "stok_awal" => $row->stok_awal,
                        "value" => $row->kd_barang
                 );
                echo json_encode($arr_result);
            }
        }
    }

}

/* End of file C_barang.php */
