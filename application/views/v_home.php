<div class="col-xl-3 col-md-6">
    <div class="card bg-warning mini-stat text-white cursor-pointer" onclick="showModal('modalSupplier')">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h6 class="text-uppercase mt-0 float-left text-white-50">Supplier</h6>
                
            </div>
            <div>
                 <h4 class="mb-3 mt-0 float-left">
                 <?= $count_supplier ?>
                </h4>
            </div>
            
        </div>
        <div class="p-3">
            <div class="float-right">
                <a href="#" class="text-white-50"><i class="mdi mdi-cube-outline h5"></i></a>
            </div>
            <!-- <p class="font-14 m-0">Last : 1447</p> -->
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="card bg-pink mini-stat text-white cursor-pointer" onclick="showModal('modalBarang')">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h6 class="text-uppercase mt-0 float-left text-white-50">Total Barang</h6>
                
            </div>
            <div>
                <h4 class="mb-3 mt-0 float-left">
                <?php 
                    foreach ($count_barang as $val_brg) {
                        echo $val_brg->kd_barang;
                    }
                ?>
                </h4>
            </div>
        </div>
        <div class="p-3">
            <div class="float-right">
                <a href="#" class="text-white-50"><i class="mdi mdi-buffer h5"></i></a>
            </div>
            <!-- <p class="font-14 m-0">Last : $47,596</p> -->
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6">
    <div class="card bg-info mini-stat text-white cursor-pointer" onclick="showModal('modalPembelian')">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h6 class="text-uppercase mt-0 float-left text-white-50">Data Pembelian</h6>
                
            </div>
            <div>
                <h4 class="mb-3 mt-0 float-left">
                <?php 
                    foreach ($count_barang_masuk as $val_brg_masuk) {
                        echo $val_brg_masuk->id_tr_m;
                    }
                ?>
                </h4>
            </div>
        </div>
        <div class="p-3">
            <div class="float-right">
                <a href="#" class="text-white-50"><i class="mdi mdi-tag-text-outline h5"></i></a>
            </div>
            <!-- <p class="font-14 m-0">Last : 15.8</p> -->
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="card bg-primary mini-stat text-white cursor-pointer" onclick="showModal('modalPenjualan')">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h6 class="text-uppercase mt-0 float-left text-white-50">Data Penjualan</h6>
            </div>
            <div>
                <h4 class="mb-3 mt-0 float-left">
                <?php 
                    foreach ($count_barang_keluar as $val_brg_keluar) {
                        echo $val_brg_keluar->id_tr_k;
                    }
                ?>
                </h4>
            </div>
        </div>
        <div class="p-3">
            <div class="float-right">
                <a href="#" class="text-white-50"><i class="mdi mdi-briefcase-check h5"></i></a>
            </div>
            <!-- <p class="font-14 m-0">Last : 1776</p> -->
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="card m-b-30 card-body">
        <h3 class="card-title font-16 mt-0">Stok Barang Yang Sudah Mau Habis</h3>
        <table class="table table-bordered">
            
            <thead>
            <tr>
                <th>No</th>
                <th>KD Barang</th>
                <th>Nama Barang</th>
                <th>Harga Barang</th>
                <th>Stok</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; foreach ($get_barang as $val) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $val->kd_barang ?></td>
                    <td><?php echo $val->nama_barang ?></td>
                    <td><?php echo number_format($val->harga_barang);?></td>
                    <td><?php echo number_format($val->stok_awal,0,',','.')?> <?= $val->satuan ?></td>
                    <td>
                        Stok kurang dari batas aman minimum (<?= $val->eoq->reorder_poin ?> <?= $val->satuan ?>)
                    </td>
                    <td>
                        <a href="<?php echo base_url('barang')?>" class="btn btn-sm btn-info">Tambah Stok Barang</a>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Supplier -->
<div class="modal fade" id="modalSupplier" tabindex="-1" role="dialog" aria-labelledby="modalSupplierLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSupplierLabel">Daftar Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Supplier</th>
                            <th>Nama Supplier</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data_supplier as $val) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $val->kd_supplier ?></td>
                                <td><?= $val->nama_supplier ?></td>
                                <td><?= $val->alamat_supplier ?></td>
                                <td><?= $val->no_hp ?></td>
                                <td><?= $val->email ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Barang -->
<div class="modal fade" id="modalBarang" tabindex="-1" role="dialog" aria-labelledby="modalBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBarangLabel">Daftar Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Harga Barang</th>
                            <th>Stok Awal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data_barang as $val) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $val->kd_barang ?></td>
                                <td><?= $val->nama_barang ?></td>
                                <td><?= $val->satuan ?></td>
                                <td><?= number_format($val->harga_barang) ?></td>
                                <td><?= number_format($val->stok_awal) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pembelian -->
<div class="modal fade" id="modalPembelian" tabindex="-1" role="dialog" aria-labelledby="modalPembelianLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPembelianLabel">Data Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data_pembelian as $val) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $val->id_tr_m ?></td>
                                <td><?= date('d/m/Y', strtotime($val->tgl_tr_m)) ?></td>
                                <td><?= $val->nama_supplier ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Penjualan -->
<div class="modal fade" id="modalPenjualan" tabindex="-1" role="dialog" aria-labelledby="modalPenjualanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPenjualanLabel">Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Nama Penginput</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data_penjualan as $val) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $val->id_tr_k ?></td>
                                <td><?= date('d/m/Y', strtotime($val->tgl_tr_k)) ?></td>
                                <td><?= $val->nama_user ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal(modalId) {
        $('#' + modalId).modal('show');
    }

    $(document).ready(function() {
        // Initialize DataTables for modal tables
        $('.modal table').DataTable({
            "pageLength": 5,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    });
</script>

<style>
    .cursor-pointer {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .cursor-pointer:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>