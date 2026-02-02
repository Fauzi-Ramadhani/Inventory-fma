<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:11px;
        }
        .spasing{
            height:50px;
        }
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
</head>
<?php
    if (@$export['excel']) {
        header("Content-Disposition: attachment; filename=Laporan Penjualan.xls");
        header("Content-Type: application/vnd.ms-excel");
    }
?>
<body>
    <?php foreach ($get_header as $val) { ?>
    <table width="100%">
        <tr>
            <td colspan="2"><h2>TB. SONY BAJA</h2></td>
            <td rowspan="2" width="200" valign="top">
                <table width="100%">
                    <tr>
                        <td>No Penjualan</td>
                        <td>: <?php echo $val->id_tr_k;?></td>
                    </tr>
                    <tr>
                        <td>Tgl Penjualan</td>
                        <td>: <?php echo $val->tgl_tr_k;?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <br>
                <b>Bill To :</b><br>

            </td>
            <td>
                <br>
                <br>
                <b>Ship To :</b><br>

            </td>
        </tr>
    </table>
    <?php } ?>
    <div class="spasing">

    </div>
    <p>Rincian Pembelian</p>
    <table id="customers">
        <tr>
            <th>#</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Qty Dibeli</th>
            <th>Harga Satuan (Rp.)</th>
            <th>Harga Total (Rp.)</th>
        </tr>
        <?php $no = 1; $total = 0; foreach ($barang as $bar) :?>
            <?php $total += $bar->harga*$bar->jumlah_beli ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $bar->kd_barang; ?></td>
            <td><?php echo $bar->nama_barang; ?></td>
            <td><?php echo $bar->jumlah_beli; ?></td>
            <td><?php echo number_format($bar->harga,0,",","."); ?></td>
            <td><?php echo number_format($bar->harga * $bar->jumlah_beli); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="5">Sub Total Harga</td>
            <td><?php
                    echo number_format($total,0,",",".");
                ?>
            </td>
        </tr>
    </table>
</body>
</html>
