<style>
    #customers {
        font-family: Verdana, Geneva, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 10px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4bbbce;
        color: white;
    }
</style>

<?php
if (@$export['excel']) {
    header("Content-Disposition: attachment; filename=Laporan Stok Barang.xls");
    header("Content-Type: application/vnd.ms-excel");
}
?>

<div class="col-lg-12">
    <div class="card m-b-30">
        <div class="card-body">
            <?php if (@$export['excel']): ?>
                <table align="left" border="1">
                    <thead>
                        <tr>
                            <th>
                                TB. SONY BAJA
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Cetak pada Tgl : <?php echo date('Y-m-d') ?>
                            </th>
                        </tr>
                    </thead>
                </table>
                <br>
            <?php else: ?>
                <p>TB. SONY BAJA<br>Cetak pada Tgl : <?php echo date('Y-m-d') ?></p>
            <?php endif; ?>
            <table border="1" align="center" id="customers" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;font-size:12px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>KD Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Harga Barang</th>
                        <th>Stok Awal</th>
                        <th>Stok</th>
                        <th>Pemakaian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($get_barang as $val) { ?>
                        <tr>
                            <td align="center"><?php echo $no++; ?></td>
                            <td align="center"><?php echo $val->kd_barang ?></td>
                            <td align="center"><?php echo $val->nama_barang ?></td>
                            <td align="center"><?php echo $val->satuan ?></td>
                            <td align="center"><?php echo number_format($val->harga_barang); ?></td>
                            <td align="center"><?php echo $val->stok_awal + $val->pemakaian; ?></td>
                            <td align="center"><?php echo $val->stok_awal ?></td>
                            <td align="center"><?php echo $val->pemakaian ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div> <!-- end col -->
