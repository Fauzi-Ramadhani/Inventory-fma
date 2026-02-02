<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_barang extends CI_Model
{

    public function insert_barang($set_data)
    {
        return $this->db->insert('ms_barang', $set_data);
    }

    public function update_barang($set_data, $kd_barang)
    {
        return $this->db->update('ms_barang', $set_data, array('kd_barang' => $kd_barang));
    }

    public function update_barang_id($set_data, $kd_barang)
    {
        $this->db->update('ms_barang', $set_data, array('kd_barang' => $kd_barang));
    }


    public function del_barang($kd_barang)
    {
        return $this->db->delete('ms_barang', array('kd_barang' => $kd_barang));
    }

    public function get_barang($where = null)
    {
        $this->db->select('*');
        $this->db->from('ms_barang');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $qr = $this->db->get();
        return $qr->result();
    }

    public function get_kd_barang($kd_barang)
    {
        $cek = $this->db->get_where('ms_barang', array('kd_barang' => $kd_barang));
        if ($cek) {
            foreach ($cek->result() as $data) {
                $hasil=array(
                    'kd_barang' => $data->kd_barang,
                    'nama_barang' => $data->nama_barang,
                    'satuan' => $data->satuan,
                    'harga_barang' => $data->harga_barang,
                    'ket_barang' => $data->ket_barang,
                    'leadtime' => $data->leadtime,
                    'percentage_biaya_simpan' => $data->percentage_biaya_simpan
                );
            }
            return $hasil;
        } else {
            return false;
        }
    }

    public function get_auto($kd_barang)
    {
        $this->db->like('kd_barang', $kd_barang, 'both');
        $this->db->or_like('nama_barang', $kd_barang, 'both');
        $this->db->order_by('kd_barang', 'ASC');
        $this->db->limit(10);
        return $this->db->get('ms_barang')->result();
    }

    public function get_auto_number()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_tr_m,4)) AS kd_max FROM tr_barang_masuk WHERE DATE(tgl_tr_m)=CURDATE()");
        $kd = "";
        if ($q->num_rows()>0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return "BRM".date('dmys').$kd;
    }

    public function get_auto_number_keluar()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_tr_k,4)) AS kd_max FROM tr_barang_keluar WHERE DATE(tgl_tr_k)=CURDATE()");
        $kd = "";
        if ($q->num_rows()>0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return "TRP".date('dmys').$kd;
    }

    public function insert_bm_header($data)
    {
        return $this->db->insert('tr_barang_masuk', $data);
    }

    public function insert_bm_detail($data)
    {
        $this->db->insert_batch('tr_barang_masuk_dtl_pakai', $data);
        return $this->db->insert_batch('tr_barang_masuk_dtl', $data);
    }

    public function get_barang_kd($kd_barang)
    {
        $r =  $this->db->get_where('ms_barang', array('kd_barang' => $kd_barang));
        return $r->result();

    }

    public function get_tr_barang($tgl_awal = null, $tgl_akhir = null)
    {
        $this->db->select('a.*, b.nama as nama_user, c.nama_supplier');
        $this->db->from('tr_barang_masuk a');
        $this->db->join('tb_login b', 'a.id_login=b.id_login');
        $this->db->join('ms_supplier c', 'a.id_supplier=c.id_supplier', 'left');
        if (!empty($tgl_awal) && !empty($tgl_akhir)) {
            $this->db->where('tgl_tr_m BETWEEN "'. date('Y-m-d', strtotime($tgl_awal)). '" and "'. date('Y-m-d', strtotime($tgl_akhir)).'"');
        }
        $this->db->order_by('tgl_tr_m', 'asc');
        $qr = $this->db->get();
        return $qr->result();
    }

    public function get_sum_barang_kd($kd_barang)
    {
        $this->db->select('SUM(jumlah_masuk) AS total');
        $this->db->from('tr_barang_masuk_dtl');
        $this->db->where('kd_barang', $kd_barang);
        $qr = $this->db->get();
        return $qr->result();
    }

    public function get_sum_barang_kd2($kd_barang, $tgl)
    {
        $this->db->select('SUM(jumlah_masuk) AS total');
        $this->db->from('tr_barang_masuk_dtl');
        $this->db->where('kd_barang', $kd_barang);
        if (count($tgl) > 0) {
            $this->db->where($tgl);
        }
        return $qr = $this->db->get()->row()->total;
    }

    public function get_sum_barang_kd1($kd_barang, $tgl)
    {
        $this->db->select('SUM(jumlah_keluar) AS total');
        $this->db->from('v_dtl_keluar');
        $this->db->where('kd_barang', $kd_barang);
        if (count($tgl) > 0) {
            $this->db->where($tgl);
        }
        return $qr = $this->db->get()->row()->total;
    }

    public function get_avg_pengeluaran($kd_barang)
    {
        $this->db->select('avg(jumlah_keluar) AS total');
        $this->db->from('v_dtl_keluar');
        $this->db->where('kd_barang', $kd_barang);
        return $qr = $this->db->get()->row()->total;
    }

    public function get_barang_by_kd($kd_barang)
    {
        $qr = $this->db->query("SELECT * FROM tr_barang_masuk_dtl_pakai WHERE kd_barang='$kd_barang' AND jumlah_masuk > 0 ORDER BY tgl_masuk,id_tr_mdetail ASC");
        return $qr->result();
    }

    public function update_barang_by_kd($kd_barang, $set_data, $tgl, $id_tr_m_detail)
    {
        return $this->db->update('tr_barang_masuk_dtl_pakai', $set_data, array('kd_barang' => $kd_barang, 'tgl_masuk' => $tgl,'id_tr_mdetail' => $id_tr_m_detail));
    }

    public function insert_barang_tr_keluar_dtl($kd_barang, $stok, $set_data, $harga_beli, $id_tr, $id_tr_m, $id_tr_m_detail)
    {
        $set = array(
            'kd_barang' => $kd_barang,
            'jumlah_keluar' => $set_data,
            'harga' => $harga_beli,
            'id_tr_k' => $id_tr,
            'id_tr_m' => $id_tr_m,
            'id_tr_mdetail' => $id_tr_m_detail,
            'jumlah_awal' => $stok
        );
        return $this->db->insert('tr_barang_keluar_dtl', $set);
    }

    public function insert_bkeluar_header($set_data)
    {
        return $this->db->insert('tr_barang_keluar', $set_data);
    }

    public function get_data_tr_m($id_tr_m)
    {
        $this->db->select('a.*,b.nama_barang');
        $this->db->from('tr_barang_masuk_dtl a');
        $this->db->join('ms_barang b', 'a.kd_barang=b.kd_barang');
        $this->db->where('a.id_tr_m', $id_tr_m);
        $get = $this->db->get();
        return $get->result();
    }

    public function insert_jual($set_data)
    {
        return $this->db->insert('tr_barang_keluar_beli', $set_data);
    }

    public function get_tr_jual_barang($tgl_awal = null, $tgl_akhir = null)
    {
        $this->db->select('a.*, b.nama as nama_user');
        $this->db->from('tr_barang_keluar a');
        $this->db->join('tb_login b', 'a.id_login=b.id_login');
        if (!empty($tgl_awal) && !empty($tgl_akhir)) {
            $this->db->where('tgl_tr_k BETWEEN "'. date('Y-m-d', strtotime($tgl_awal)). '" and "'. date('Y-m-d', strtotime($tgl_akhir)).'"');
        }
        $this->db->order_by('tgl_tr_k', 'desc');
        $qr = $this->db->get();
        return $qr->result();
    }

    public function get_detail($id_tr_k)
    {
        $this->db->select('*');
        $this->db->from('tr_barang_keluar_beli a');
        $this->db->join('ms_barang b', 'a.kd_barang=b.kd_barang');
        $this->db->where('a.id_tr_k', $id_tr_k);
        $get = $this->db->get();
        return $get->result();
    }

    public function get_detail_b_keluar($id_tr_k)
    {
        $this->db->select('*');
        $this->db->from('tr_barang_keluar_beli a');
        $this->db->join('ms_barang b', 'a.kd_barang=b.kd_barang');
        $this->db->where('a.id_tr_k', $id_tr_k);
        return $get = $this->db->get();
    }

    public function get_detail_jual($id_tr_k, $kd_barang)
    {
        $qr = $this->db->get_where('tr_barang_keluar_dtl', array('id_tr_k' => $id_tr_k,'kd_barang' => $kd_barang));
        return $qr->result();
    }

    public function get_customer()
    {
        $this->db->select('*');
        $this->db->from('ms_customer');
        $qr = $this->db->get();
        return $qr->result();
    }

    public function get_header_by_id($id_tr_k)
    {
        $this->db->select('*');
        $this->db->from('tr_barang_keluar a');
        $this->db->join('tb_login b', 'a.id_login=b.id_login');
        // $this->db->join('ms_customer c','a.id_customer=c.id_customer');
        $this->db->where('a.id_tr_k', $id_tr_k);
        $qr = $this->db->get();
        return $qr->result();
    }

    public function get_detail_id($id_tr_k)
    {
        $this->db->select('a.id_tr_k,a.kd_barang,a.jumlah_beli,b.nama_barang,b.harga_barang as harga');
        $this->db->from('tr_barang_keluar_beli a');
        $this->db->join('ms_barang b', 'b.kd_barang = a.kd_barang', 'left');
        $this->db->where('a.id_tr_k', $id_tr_k);
        $get = $this->db->get();
        return $get->result();
    }

    public function get_sum_detail_id($id_tr_k)
    {
        $this->db->select('sum(harga)');
        $this->db->from('tr_barang_keluar_dtl a');
        $this->db->where('a.id_tr_k', $id_tr_k);
        $get = $this->db->get();
        return $get->result();
    }

    public function count_barang()
    {
        $this->db->select("count('kd_barang') AS kd_barang");
        $this->db->from('ms_barang');
        $get = $this->db->get();
        return $get->result();
    }

    public function count_barang_keluar()
    {
        $this->db->select("count('id_tr_k') AS id_tr_k");
        $this->db->from('tr_barang_keluar');
        $get = $this->db->get();
        return $get->result();
    }

    public function count_barang_masuk()
    {
        $this->db->select("count('id_tr_m') AS id_tr_m");
        $this->db->from('tr_barang_masuk');
        $get = $this->db->get();
        return $get->result();
    }

}

/* End of file M_barang.php */
