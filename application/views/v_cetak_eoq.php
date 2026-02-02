<style>
    #customers {
      font-family: Verdana, Geneva, sans-serif;
      border-collapse: collapse;
      width: 100%;
  }

  #customers td, #customers th {
      border: 1px solid #ddd;
      padding: 8px;
      font-size:10px;
  }

  #customers tr:nth-child(even){background-color: #f2f2f2;}

  #customers tr:hover {background-color: #ddd;}

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
        header("Content-Disposition: attachment; filename=Laporan Economic Order Quantity & Reorder Poin.xls");
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
                        <th>Nama Barang</th>
                        <th>Harga Barang</th>
                        <th>Demand (/Thn)</th>
                        <th>Lead Time (Hari)</th>
                        <th>Biaya Pesan</th>
                        <th>Biaya Simpan</th>
                        <th>EOQ</th>
                        <th>Reorder Poin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach ($barang as $brg): ?>
                        <tr>
                            <td align="center"><?= $i++; ?></td>
                            <td align="center"><?= $brg->nama_barang; ?></td>
                            <td align="center"><?= number_format($brg->harga_barang); ?></td>
                            <td align="center"><?= (@$brg->eoq->jumlah_total_pesanan ? $brg->eoq->jumlah_total_pesanan : 0)." ".$brg->satuan; ?></td>
                            <td align="center"><?= $brg->leadtime; ?></td>
                            <td align="center"><?= @$brg->eoq->biaya_pesan ? number_format($brg->eoq->biaya_pesan) : 0; ?></td>
                            <td align="center"><?= @$brg->eoq->biaya_simpan ? number_format($brg->eoq->biaya_simpan) : 0; ?></td>
                            <td align="center"><?= @$brg->eoq->frequensi_pesan ? $brg->eoq->frequensi_pesan : 0; ?> <?= $brg->satuan ?></td>
                            <td align="center"><?= @$brg->eoq->reorder_poin ? $brg->eoq->reorder_poin : 0; ?> <?= $brg->satuan ?></td>
                        </tr>
                    <?php endforeach ?>
            </tbody>
        </table>

    </div>
</div>
</div> <!-- end col -->
