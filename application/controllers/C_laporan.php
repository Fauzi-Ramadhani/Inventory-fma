<?php
error_reporting(0);
defined('BASEPATH') or exit('No direct script access allowed');

class C_laporan extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') != "login") {
            redirect(base_url('login'));
        };
        $this->load->model('M_barang');
        $this->load->model('M_Eoq', 'eoq');

    }


    public function lap_customer()
    {
        $data['title'] = "Laporan Customer";
        $data['content'] = "v_lap_customer";
        $data['get_customer'] = $this->M_barang->get_customer();
        $this->load->view('v_masterpage', $data);
    }

    public function lap_barang()
    {
        $data['title'] = "Laporan Master Barang";
        $data['content'] = "v_lap_barang";
        $data['get_barang'] = $this->M_barang->get_barang();
        $this->load->view('v_masterpage', $data);
    }

    public function lap_tr_barang_masuk()
    {
        $data['title'] = "Laporan Transaksi Barang Masuk";
        $data['content'] = "v_lap_tr_barang_masuk";
        $tgl_awal = null;
        $tgl_akhir = null;
        if (isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) {
            $tgl_awal = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
        }
        $data['get_tr'] = $this->M_barang->get_tr_barang($tgl_awal, $tgl_akhir);
        $this->load->view('v_masterpage', $data);
    }

    public function lap_tr_barang_keluar()
    {
        $data['title'] = "Laporan Transaksi Barang Keluar";
        $data['content'] = "v_lap_tr_barang_keluar";
        $tgl_awal = null;
        $tgl_akhir = null;
        if (isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) {
            $tgl_awal = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
        }
        $result = $this->M_barang->get_tr_jual_barang($tgl_awal, $tgl_akhir);
        $resq;
        foreach ($result as $res) {
            $resCount = $this->M_barang->get_detail_b_keluar($res->id_tr_k)->row();
            $res->jumlah_beli = $resCount->jumlah_beli;
            $resq[] = $res;
        }

        $data['get_penjualan'] = $resq;
        $this->load->view('v_masterpage', $data);
    }

    public function forecasting_moving_average()
    {
        $data['title'] = "Forecasting Moving Average";
        $data['content'] = "v_lap_fma";

        $data['barang'] = $this->M_barang->get_barang();
        $this->load->view('v_masterpage', $data);
    }

   public function hitung_fma() {
    $kd_barang = $this->input->post('kd_barang');
    $periode = (int) $this->input->post('periode');
    if ($periode <= 0) $periode = 3;

    // Ambil data dari database
    $this->db->select([
        'SUM(tr_barang_keluar_beli.jumlah_beli) as jumlah_beli',
        "DATE_FORMAT(tr_barang_keluar.tgl_tr_k, '%Y-%m') as tanggal"
    ]);
    $this->db->from('tr_barang_keluar_beli');
    $this->db->join('tr_barang_keluar', 'tr_barang_keluar.id_tr_k = tr_barang_keluar_beli.id_tr_k', 'left');
    $this->db->where('tr_barang_keluar_beli.kd_barang', $kd_barang);
    $this->db->group_by("DATE_FORMAT(tr_barang_keluar.tgl_tr_k, '%Y-%m')");
    $this->db->order_by("tanggal", "ASC");

    $rows = $this->db->get()->result();

    if (count($rows) < $periode) {
        show_error('Data tidak cukup untuk dihitung (minimal ' . $periode . ' data)');
    }

    // Inisialisasi array hasil
    $hasil = [];
    foreach ($rows as $row) {
        $hasil[] = [
            'bulan' => $row->tanggal,
            'aktual' => (float)$row->jumlah_beli,
            'hasil_peramalan' => null,
            'selisih' => null,
            'mad' => null,
            'mse' => null,
            'mape' => null,
        ];
    }

    // Variabel total error
    $total_mad = $total_mse = $total_mape = 0;
    $jumlah_peramalan = 0;

    // Hitung moving average & error (mulai dari bulan sesuai periode yang dipilih)
    for ($i = $periode - 1; $i < count($hasil); $i++) {
        $sum = 0;
        // Ambil rata-rata dari "periode" bulan terakhir termasuk bulan ini
        for ($j = $i - ($periode - 1); $j <= $i; $j++) {
            $sum += $hasil[$j]['aktual'];
        }

        $f = $sum / $periode; // tanpa pembulatan
        $hasil[$i]['hasil_peramalan'] = $f;

        $aktual = $hasil[$i]['aktual'];
        $selisih = $aktual - $f;

        $mad = abs($selisih);
        $mse = pow($selisih, 2);
        $mape = $aktual != 0 ? ($mad / $aktual) * 100 : 0;

        $hasil[$i]['selisih'] = $selisih;
        $hasil[$i]['mad'] = $mad;
        $hasil[$i]['mse'] = $mse;
        $hasil[$i]['mape'] = $mape;

        $total_mad += $mad;
        $total_mse += $mse;
        $total_mape += $mape;
        $jumlah_peramalan++;
    }

    // Ringkasan total error
    $mad = $jumlah_peramalan ? $total_mad / $jumlah_peramalan : 0;
    $mse = $jumlah_peramalan ? $total_mse / $jumlah_peramalan : 0;
    $mape = $jumlah_peramalan ? $total_mape / $jumlah_peramalan : 0;

    // Prediksi 6 bulan ke depan
    $last_periode = array_slice($hasil, -$periode);
    $last_bulan = end($hasil)['bulan'];

    for ($i = 1; $i <= 2; $i++) {
        $next_bulan = date('Y-m', strtotime("{$last_bulan} +{$i} month"));
        $sum = array_sum(array_column($last_periode, 'aktual'));
        $f = $sum / $periode;

        $hasil[] = [
            'bulan' => $next_bulan,
            'aktual' => null,
            'hasil_peramalan' => $f,
            'selisih' => null,
            'mad' => null,
            'mse' => null,
            'mape' => null,
        ];

        $last_periode[] = ['aktual' => $f];
        if (count($last_periode) > $periode) {
            array_shift($last_periode);
        }
    }

    $data = [
        'hasil' => $hasil,
        'mad' => $mad,
        'mse' => $mse,
        'mape' => $mape,
    ];

    $this->load->view('v_lap_fma_hasil', $data);
}



    public function cetak_barang()
    {
        $url = base_url();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader('Laporan Barang||');
        $mpdf->SetFooter('Halaman||{PAGENO}');

        $mpdf->defaultfooterfontsize=9;
        $mpdf->defaultfooterfontstyle='serif';
        $mpdf->defaultfooterline=2;

        $data['get_barang'] = $this->M_barang->get_barang();
        $html = $this->load->view('v_cetak_barang', $data, true);
        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }

    public function export_excel_barang()
    {
        $url = base_url();
        $data['get_barang'] = $this->M_barang->get_barang();
        $data['export'] = [
            'excel' => 1
        ];
        $this->load->view('v_cetak_barang', $data, false);
    }

    public function cetak_eoq()
    {
        $url = base_url();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader('Laporan Barang||');
        $mpdf->SetFooter('Halaman||{PAGENO}');

        $mpdf->defaultfooterfontsize=9;
        $mpdf->defaultfooterfontstyle='serif';
        $mpdf->defaultfooterline=2;

        $tglBarang = [
            'tgl_tr_k >=' => date('Y-01-1', strtotime('-1 years')),
            'tgl_tr_k <=' => date('Y-12-t', strtotime('-1 years')),
        ];
        $tglBarangMasuk = [
            'tgl_masuk >=' => date('Y-01-1', strtotime('-1 years')),
            'tgl_masuk <=' => date('Y-12-t', strtotime('-1 years')),
        ];
        if (isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) {
            $tglBarang = [
                'tgl_tr_k >=' => date('Y-m-d', strtotime($this->input->get('tgl_awal'))),
                'tgl_tr_k <=' => date('Y-m-d', strtotime($this->input->get('tgl_akhir'))),
            ];

            $tglBarangMasuk = [
                'tgl_masuk >=' => date('Y-m-d', strtotime($this->input->get('tgl_awal'))),
                'tgl_masuk <=' => date('Y-m-d', strtotime($this->input->get('tgl_akhir'))),
            ];
        }

        $barang = $this->M_barang->get_barang();

        $resBarang;
        foreach ($barang as $res) {
            $res->total = $this->M_barang->get_sum_barang_kd1($res->kd_barang, $tglBarang);
            $res->totalMasuk = $this->M_barang->get_sum_barang_kd2($res->kd_barang, $tglBarangMasuk);
            $res->eoq = $this->eoq->get_eoq($res->kd_barang);

            $resBarang[] = $res;
        }

        $data['barang'] = $resBarang;

        $html = $this->load->view('v_cetak_eoq', $data, true);
        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }

    public function export_excel_eoq()
    {
        $tglBarang = [
            'tgl_tr_k >=' => date('Y-01-1', strtotime('-1 years')),
            'tgl_tr_k <=' => date('Y-12-t', strtotime('-1 years')),
        ];
        $tglBarangMasuk = [
            'tgl_masuk >=' => date('Y-01-1', strtotime('-1 years')),
            'tgl_masuk <=' => date('Y-12-t', strtotime('-1 years')),
        ];
        if (isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) {
            $tglBarang = [
                'tgl_tr_k >=' => date('Y-m-d', strtotime($this->input->get('tgl_awal'))),
                'tgl_tr_k <=' => date('Y-m-d', strtotime($this->input->get('tgl_akhir'))),
            ];

            $tglBarangMasuk = [
                'tgl_masuk >=' => date('Y-m-d', strtotime($this->input->get('tgl_awal'))),
                'tgl_masuk <=' => date('Y-m-d', strtotime($this->input->get('tgl_akhir'))),
            ];
        }

        $barang = $this->M_barang->get_barang();

        $resBarang;
        foreach ($barang as $res) {
            $res->total = $this->M_barang->get_sum_barang_kd1($res->kd_barang, $tglBarang);
            $res->totalMasuk = $this->M_barang->get_sum_barang_kd2($res->kd_barang, $tglBarangMasuk);
            $res->eoq = $this->eoq->get_eoq($res->kd_barang);

            $resBarang[] = $res;
        }

        $data['barang'] = $resBarang;
        $data['export'] = [
            'excel' => 1
        ];
        $this->load->view('v_cetak_eoq', $data, false);
    }

    public function export_excel_trmasuk()
    {
        $url = base_url();

        $tgl_awal = null;
        $tgl_akhir = null;
        if (isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) {
            $tgl_awal = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
        }
        $data['export'] = [
            'excel' => 1
        ];
        $data['get_tr'] = $this->M_barang->get_tr_barang($tgl_awal, $tgl_akhir);
        $this->load->view('v_cetak_trmasuk', $data, false);
    }

    public function cetak_trmasuk()
    {
        $url = base_url();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader('Laporan Transaksi Barang Masuk||');
        $mpdf->SetFooter('Halaman||{PAGENO}');

        $mpdf->defaultfooterfontsize=9;
        $mpdf->defaultfooterfontstyle='serif';
        $mpdf->defaultfooterline=2;
        $tgl_awal = null;
        $tgl_akhir = null;
        if (isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) {
            $tgl_awal = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
        }
        $data['get_tr'] = $this->M_barang->get_tr_barang($tgl_awal, $tgl_akhir);
        $html = $this->load->view('v_cetak_trmasuk', $data, true);
        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }

    public function export_excel_trkeluar()
    {
        $url = base_url();

        $tgl_awal = null;
        $tgl_akhir = null;
        if (isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) {
            $tgl_awal = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
        }
        $result = $this->M_barang->get_tr_jual_barang($tgl_awal, $tgl_akhir);
        $resq;
        foreach ($result as $res) {
            $resCount = $this->M_barang->get_detail_b_keluar($res->id_tr_k)->row();
            $res->jumlah_beli = $resCount->jumlah_beli;
            $resq[] = $res;
        }
        $data['export'] = [
            'excel' => 1
        ];
        $data['get_penjualan'] = $resq;
        $this->load->view('v_cetak_trkeluar', $data, false);
    }

    public function cetak_trkeluar()
    {
        $url = base_url();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader('Laporan Transaksi Barang Keluar||');
        $mpdf->SetFooter('Halaman||{PAGENO}');

        $mpdf->defaultfooterfontsize=9;
        $mpdf->defaultfooterfontstyle='serif';
        $mpdf->defaultfooterline=2;
        $tgl_awal = null;
        $tgl_akhir = null;
        if (isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) {
            $tgl_awal = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
        }
        $result = $this->M_barang->get_tr_jual_barang($tgl_awal, $tgl_akhir);
        $resq;
        foreach ($result as $res) {
            $resCount = $this->M_barang->get_detail_b_keluar($res->id_tr_k)->row();
            $res->jumlah_beli = $resCount->jumlah_beli;
            $resq[] = $res;
        }

        $data['get_penjualan'] = $resq;
        $html = $this->load->view('v_cetak_trkeluar', $data, true);
        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }



}

/* End of file C_laporan.php */
