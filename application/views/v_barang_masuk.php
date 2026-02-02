<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<div class="col-lg-12">
    <div class="card m-b-30">
        <div class="card-body">
            <h4 class="mt-0 header-title" id="title"></h4>

            <?php
                if (@$this->session->flashdata('msg')) {
                    echo $this->session->flashdata('msg');
                    $this->session->unset_userdata('msg');
                }
            ?>
            <form class="" action="<?php echo base_url()?>C_barang/save_masuk" method="post" id="frm_data_barang">
                <div class="row">
                    <input type="hidden" name="status" id="s" value="baru">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>KD Transaksi</label>
                            <input type="text" class="form-control" required placeholder="" id="id_tr_m" name="id_tr_m" value="<?php echo $auto?>" readonly/>
                        </div>
                        <div class="form-group">
                            <label>Nama Penginput</label>
                            <input type="text" class="form-control" value="<?php echo $this->session->userdata('nama');?>" disabled>
                            <input type="hidden" class="form-control" required placeholder="Ex : nama" id="id_login" name="id_login" value="<?php echo $this->session->userdata('id_login');?>"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" class="form-control" required placeholder="" id="ket_tr_m" name="ket_tr_m"/>
                        </div>
                        <div class="form-group">
                            <label>Supplier</label>
                            <select name="id_supplier" class="form-control select2">
                                <option value="">-- Silahkan Pilih --</option>
                                <?php foreach ($get_supplier as $val) { ?>
                                    <option value="<?php echo $val->id_supplier ?>"><?php echo $val->nama_supplier.' - '.$val->pic_supplier ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div>
                                <button type="button" class="btn btn-primary waves-effect waves-light" id="btn-tambah">
                                    <span id="txt-proses">Tambah</span>
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect m-l-5" id="btn-reset">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="rows" value="0">
                <table id="data-barang" class="table table-bordered">
                    <tr>
                        <td>KD BARANG</td>
                        <td>SATUAN</td>
                        <td>HARGA</td>
                        <td>JUMLAH MASUK</td>
                        <td>Aksi</td>
                    </tr>
                </table>
                <button class="btn btn-info" type="submit">
                        Simpan <span class="badge badge-primary"></span>
                </button>
            </form>


            <!-- <button id="tombol-edit">Klik</button>
            <button id="tombol-balikin">Balikin</button> -->


        </div>
    </div>
</div> <!-- end col -->



<script>

    $(document).ready(function() {
        $('#id_supplier').select2();
        // function renderSelect2(){
        //         $('.select2').select2({
        //         theme: 'bootstrap4',
        //         tags: true,
        //         allowClear: true,
        //     });
        // };
        (function($) {
          $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
              if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
              } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
              } else {
                this.value = "";
              }
            });
          };
        }(jQuery));

        $("#btn-tambah").click(function(){
            var count = parseInt($("#rows").val());
            var count_next = count + 1;

            $("#data-barang").append(
              "<tr>"+
                "<td>"+
                "<input type='text' class='form-control' id='kd_barang_label_"+count_next+"'> <small><i>Masukan Nama Barang</i></small>"+
                "<input type='hidden' name='kd_barang[]' class='form-control' id='kd_barang_"+count_next+"'>"+
                // "<select name='kd_barang[]' class='form-control select2' id='kd_barang_"+count_next+"' onchange='test(this)'>"+
                //     "<option value=''>--Silahkan Pilih--</option>"+
                //     <?php foreach($get_barang as $val) { ?>
                //       "<option value='<?php echo $val->kd_barang?>' data-satuan='<?php echo $val->satuan?>' data-harga='<?php echo $val->harga_barang; ?>' data-count='"+count_next+"'><?php echo $val->kd_barang." - ".$val->nama_barang;?></option>"+
                //     <?php } ?>
                //   "</select>"+
                "</td>"+
                "<td><input type='text' name='satuan[]' id='satuan_"+count_next+"' class='form-control' readonly></td>"+
                "<td><input type='text' name='harga[]' id='harga_"+count_next+"' class='form-control' readonly></td>"+
                "<td><input type='text' name='jumlah_masuk[]' id='jumlah_masuk_"+count_next+"' class='form-control'></td>"+
                "<td><button type='button' class='btn btn-sm btn-danger del'>Del</button></td>"+
              "</tr>"
            );
            $("#jumlah_masuk_"+count_next).inputFilter(function(value) {
            return /^-?\d*$/.test(value); });
            $("#rows").val(count_next);

             $('#kd_barang_label_'+count_next).autocomplete({
                    // source: ["ActionScript", "AppleScript", "Asp", "BASIC", "C", "C++", "Clojure", "COBOL", "ColdFusion", "Erlang", "Fortran", "Groovy", "Haskell", "Java", "JavaScript", "Lisp", "Perl", "PHP", "Python", "Ruby", "Scala", "Scheme"],
                    // minLength: 1,
                    // change: function(event, ui) {
                    //     if (ui.item) {
                    //         console.log("ui.item.value: " + ui.item.value);
                    //     } else {
                    //         console.log("ui.item.value is null");
                    //     }
                    //     console.log("this.value: " + this.value);
                    // }
                    // source: "<?php echo base_url('C_barang/get_auto_kd/?');?>",
                    // select: function (event, ui) {
                    //     $('#kd_barang_'+count_next).val(ui.item.kd_barang);
                    //     $('#satuan_'+count_next).val(ui.item.satuan);
                    //     $('#harga_'+count_next).val(ui.item.harga_barang);
                    //}

                    source: function( request, response ) {
                      // Fetch data
                      $.ajax({
                        url: "<?=base_url()?>C_barang/get_auto_kd/",
                        type: 'post',
                        dataType: "json",
                        data: {
                          search: request.term
                        },
                        success: function( data ) {
                            console.log(data);
                          response( data );
                        }
                      });
                    },
                    select: function (event, ui) {

                        if (ui.item) {
                            console.log("ui.item.value: " + ui.item);
                        } else {
                            console.log("ui.item.value is null");
                        }
                        console.log("this.value: " + this.value);
                        //Set selection
                         $('#kd_barang_'+count_next).val(ui.item.value);
                         $('#satuan_'+count_next).val(ui.item.satuan).attr('readonly',true);
                         $('#harga_'+count_next).val(ui.item.harga_barang).attr('readonly',false);
                         $('#kd_barang_label_'+count_next).val(ui.item.label);

                      return false;
                    }
             });

      });



      $("#data-barang").on('click','.del',function(){
          $(this).parent().parent().remove();
      });

      // function test(sel){
      //   var satuan = $(sel).find(':selected').data('satuan');
      //   var harga = $(sel).find(':selected').data('harga');
      //   var count = $(sel).find(':selected').data('count');
      //   $("#satuan_"+count).val(satuan).attr('readonly',true);
      //   $("#harga_"+count).val(harga).attr('readonly',true);
      // }
  });
</script>
