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
            <form class="" action="#" id="frm_data_user">
                <input type="hidden" name="status" id="s" value="baru">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" required placeholder="Ex : John Leon" id="username" name="username"/>
                    <input type="hidden" class="form-control" id="id_login" name="id_login"/>
                </div>
                <div class="form-group view-pass">
                    <label>Password</label>
                    <input type="password" class="form-control text-pass" required placeholder="Ex : password" id="password" name="password"/>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" required placeholder="Ex : John Leon" id="nama" name="nama"/>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <select class="form-control" required="" name="level" id="level">
                        <option value="">-- Silahkan Pilih --</option>
                        <option value="Pemilik">Pemilik</option>
                        <option value="Admin">Admin</option>
                        <!-- <option value="Barista">Barista</option> -->
                    </select>
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

            <h4 class="mt-0 header-title">Data User</h4>

            <table id="datatable" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;font-size:12px;">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1; foreach ($get_user as $val) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $val->username ?></td>
                        <td><?php echo $val->nama ?></td>
                        <td><?php echo $val->level ?></td>
                        <td>
                            <button type="button" class="btn-edit btn btn-info btn-sm" data-id="<?php echo $val->id_login ?>" >Edit</button>
                            <a href="<?php echo base_url()?>C_user/hapus/<?php echo $val->id_login?>" class="btn btn-danger btn-sm" onClick="return confirm('Apakah Anda Ingin Menghapusnya ?')">Hapus</a>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>

        </div>
    </div>
</div> <!-- end col -->
            
<script>
    $( document ).ready(function() {

    });
                
    $('#title').text('Tambah User');
    
    var status,url;
    status = "";
    //var status_text = $('#status').val('baru');
    function clear_form() {
        $('#s').val('baru');
        $('#password').val('');
        $('#nama').val('');
        $('#username').val('').attr('readonly', false);
        $('#id_login').val('');
        $('#level').val('');
        $('#txt-proses').text('Tambah');
        $('#title').text('Tambah User');
        $('.view-pass').show();
        $('.text-pass').show().attr('required',true);
    }

    

    $('#btn-reset').on('click',function() {
       clear_form(); 
    });

    $('#btn-simpan').on('click',function(){
        var form_data = $('#frm_data_user').serialize();
        if($('#s').val() == "baru"){
            proses("baru",form_data);
            //console.log('status : baru => '+form_data);
        }else if($('#s').val() == "update"){
            proses("update",form_data);
            //console.log('status : update => '+form_data);
        }
    });

    $('.btn-edit').on('click',function () {
       var id_login = $(this).attr("data-id");
       //alert(username);
       $('#title').text('Edit User');
       $('#s').val('update');
       $('#txt-proses').text('Rubah');
       $('#username').attr('readonly',true);
       //console.log(username);
       $.ajax({
            type: 'GET',
            url: "<?php echo base_url()?>C_user/get_data/"+id_login,
            dataType : "JSON",
            beforeSend: function() {
                // setting a timeout
               
            },
            success: function(data) {
                //var hasil = JSON.parse(data);
                $('.view-pass').hide();
                $('.text-pass').hide().attr('required',false);
                $.each(data,function(id_login, username, level, nama){
                    $('#id_login').val(data.id_login);
                    $('#username').val(data.username);
                    $('#level').val(data.level);
                    $('#nama').val(data.nama);
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
            url = "<?php echo base_url()?>C_user/simpan";
            console.log(url+" ads"+form_data);
        }else if(status == "update"){
            url = "<?php echo base_url()?>C_user/rubah";
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