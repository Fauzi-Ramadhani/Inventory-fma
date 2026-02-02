<div class="col-lg-3">
    <div class="card m-b-30">
        <div class="card-body">

            <h4 class="mt-0 header-title" id="title"></h4>
            <div class="alert alert-success alert-dismissible fade show mb-0" role="alert" id="alert-simpan-berhasil" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Berhasil !</strong> Data Berhasil Disimpan
            </div>
            <div class="alert alert-success alert-dismissible fade show mb-0" role="alert" id="alert-update-berhasil" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Berhasil !</strong> Data Berhasil Dirubah
            </div>
            <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert" id="salah" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Gagal !</strong> Data Gagal Disimpan
            </div>
            
            <!-- <button id="tombol-edit">Klik</button>
            <button id="tombol-balikin">Balikin</button> -->
            <form class="" action="#" id="frm_data_barang">
                <input type="hidden" name="status" id="s" value="baru">
                <div class="form-group">
                    <label>KD Barang</label>
                    <input type="text" class="form-control" required placeholder="KD-xxxx" id="kd_barang" name="kd_barang"/>
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" class="form-control" required placeholder="Ex : nama" id="nama_barang" name="nama_barang"/>
                </div>
                <div class="form-group">
                    <label>Satuan</label>
                    <input type="text" class="form-control" required placeholder="PCS" id="satuan" name="satuan"/>
                </div>
                <div class="form-group">
                    <label>Waktu Re Stok (Dalam Hari)</label>
                    <input type="number" class="form-control" required placeholder="1" id="leadtime" name="leadtime"/>
                </div>
                <div class="form-group">
                    <label>Harga Barang</label>
                    <input type="text" class="form-control" required placeholder="130000" id="harga_barang" name="harga_barang"/>
                </div>

                <div class="form-group">
                    <label>Persentasi Biaya Simpan (dalam %)</label>
                    <input type="number" class="form-control" required placeholder="5" id="persentasi" name="persentasi"/>
                </div>
                <div class="form-group">
                    <label>Ket Dan Jenis Barang</label>
                    <textarea class="form-control" required placeholder="Terbuat Dari Bahan Bagus" id="ket_barang" name="ket_barang"></textarea>
                </div>
            
                <div class="form-group">
                    <div>
                        <button type="button" class="btn btn-primary waves-effect waves-light" id="btn-simpan">
                            <span id="txt-proses">Tambah</span>
                        </button>
                        <button type="reset" class="btn btn-secondary waves-effect m-l-5" id="btn-reset">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div> <!-- end col -->

<div class="col-lg-9">
    <div class="card m-b-30">
        <div class="card-body">

            <h4 class="mt-0 header-title">Data Barang</h4>

            <table id="datatable" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;font-size:12px;">
                <thead>
                <tr>
                    <th>No</th>
                    <th>KD Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Harga Barang</th>
                    <th>Stok Awal</th>
                    <th>Sisa Stok</th>
                    <th>Pemakaian</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1; foreach ($get_barang as $val) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $val->kd_barang ?></td>
                        <td><?php echo $val->nama_barang ?></td>
                        <td><?php echo $val->satuan ?></td>
                        <td><?php echo @$val->harga_barang ? number_format($val->harga_barang,0,',','.') : 0; ?></td>
                        <td><?php echo $val->stok_awal+$val->pemakaian;?></td>
                        <td><?php echo @$val->stok_awal ? number_format($val->stok_awal,0,',','.') : 0; ?></td>
                        <td><?php echo "- ".$val->pemakaian?></td>
                        <td>
                            <button type="button" class="btn-edit btn btn-info btn-sm" data-id="<?php echo $val->kd_barang ?>" >Edit</button>
                            <?php if($val->stok_awal == 0 || $val->stok_awal == null){ ?>
                            <a href="<?php echo base_url()?>C_barang/hapus/<?php echo $val->kd_barang?>" class="btn btn-danger btn-sm" onClick="return confirm('Apakah Anda Ingin Menghapusnya ?')">Hapus</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>

        </div>
    </div>
</div> <!-- end col -->
            
<script>
    $('#title').text('Tambah Barang');
    
    var status,url;
    status = "";
    //var status_text = $('#status').val('baru');
    function clear_form() {
        $('#s').val('baru');
        $('#kd_barang').val('').attr('readonly',false);
        $('#nama_barang').val('');
        $('#satuan').val('');
        $('#leadtime').val('');
        $('#persentasi').val('');
        $('#harga_barang').val('');
        $('#ket_barang').val('');
        $('#txt-proses').text('Tambah');
        $('#title').text('Tambah Barang');
    }

    

    $('#btn-reset').on('click',function() {
       clear_form(); 
    });

    $('#btn-simpan').on('click',function(){
        var form_data = $('#frm_data_barang').serialize();
        if($('#s').val() == "baru"){
            proses("baru",form_data);
            //console.log('status : baru => '+form_data);
        }else if($('#s').val() == "update"){
            proses("update",form_data);
            //console.log('status : update => '+form_data);
        }
    });

    $('.btn-edit').on('click',function () {
       var kd_barang = $(this).attr("data-id");
       //alert(kd_barang);
       $('#title').text('Edit Barang');
       $('#s').val('update');
       $('#txt-proses').text('Rubah');
       $('#kd_barang').attr('readonly',true);
       //console.log(kd_barang);
       $.ajax({
            type: 'GET',
            url: "<?php echo base_url()?>C_barang/get_data/"+kd_barang,
            dataType : "JSON",
            beforeSend: function() {
                // setting a timeout
            },
            success: function(data) {
                //var hasil = JSON.parse(data);
                
                $.each(data, function(kd_barang, nama_barang, satuan, harga_barang, ket_barang, leadtime, percentage_biaya_simpan){
                    console.log(data)
                    $('#kd_barang').val(data.kd_barang);
                    $('#nama_barang').val(data.nama_barang);
                    $('#satuan').val(data.satuan);
                    $('#harga_barang').val(data.harga_barang);
                    $('#ket_barang').val(data.ket_barang);
                    $('#leadtime').val(parseInt(data.leadtime));
                    $('#persentasi').val(parseInt(data.percentage_biaya_simpan));
                });
            },
            error: function(xhr) { // if error occured
               
            },
            complete: function() {
                
            }
        });
    });


    function proses(status,form_data) {
    //    alert(form_data);
        if(status == "baru"){
            url = "<?php echo base_url()?>C_barang/simpan";
            console.log(url+" ads"+form_data);
        }else if(status == "update"){
            url = "<?php echo base_url()?>C_barang/rubah";
            console.log(url+" ads"+form_data);
        }
        $.ajax({
            type: 'POST',
            url: url,
            data: form_data,
            beforeSend: function() {
                // setting a timeout
               
            },
            success: function(data) {
                console.log(data);
                var hasil = JSON.parse(data);
                if(hasil.status == "sukses"){
                    $('#alert-simpan-berhasil').show();
                    clear_form(); 
                    setTimeout(function() {
                        window.location.reload();
                    },0);
                }else if(hasil.status == "sukses-update"){
                    $('#alert-update-berhasil').show();
                    clear_form(); 
                    setTimeout(function() {
                        window.location.reload();
                    },0);
                }else if(hasil.status == "gagal"){
                    $('#salah').show();
                    clear_form();
                }
            },
            error: function(xhr) { // if error occured
               
            },
            complete: function() {
                
            }
        });
    }

    

</script>