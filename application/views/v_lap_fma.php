<div class="col-lg-12">
    <div class="card m-b-30">
        <div class="card-header bg-primary text-white">Masukan Data Forecasting</div>
        <div class="card-body">
            <form id="hitungFma">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="kd_barang">Nama Barang</label>
                            <select type="text" class="form-control" id="kd_barang" name="kd_barang" required>
                                <?php foreach ($barang as $no => $bar) :?>
                                    <option value="" selected disabled>Nama Barang</option>
                                    <option value="<?= $bar->kd_barang ?>"><?= $bar->nama_barang ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Periode</label>
                            <input type="number" min="2" value="3" class="form-control" name="periode" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="btn-tambah">
                                    <span id="txt-proses">Hitung</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- <a href="<?php echo base_url() ?>C_laporan/cetak_eoq" target="_blank" class="btn btn-info btn-md"><i class="fa fa-print"></i> Cetak Laporan</a>
            <a href="<?php echo base_url() ?>C_laporan/export_excel_eoq" target="_blank" class="btn btn-danger btn-md"><i class="fa fa-clipboard" aria-hidden="true"></i> Export Laporan</a><br> -->
        </div>
    </div>
    <div class="card m-b-30">
        <div class="card-header bg-primary text-white">Nama Barang</div>
        <div id="hasilFma">
            <table class="table table-bordered">
                <tr>
                    <th>Bulan</th>
                    <th>Data Aktual</th>
                    <th>Hasil Peramalan</th>
                    <th>Y1</th>
                    <th>MAD</th>
                    <th>MSE</th>
                    <th>MAPE</th>
                </tr>
            </table>
        </div>
    </div>
</div> <!-- end col -->

<script>
    $('#hitungFma').on('submit', function(e) {
        e.preventDefault()

        $.ajax({
            url: '<?= base_url('lap/forecasting-moving-average/hitung') ?>',
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('#hasilFma').html(`<div style="height: 200px;display:flex;align-items: center;justify-content: center;" class="text-center"><div class="spinner-border" role="status">
                </div></div>`);
            },
            success: function(data) {
                $('#hasilFma').html(data);
            },
            error: function() {
                $('#load-data').html(
                    '<div class="alert alert-danger">Gagal memuat data.</div>');
            }
        });
    });
</script>
