<div class="col-lg-12">
    <div class="card m-b-30">
        <div class="card-body">

            <h4 class="mt-0 header-title">Data Transaksi Pembelian</h4>

            <table id="datatable1" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Tr Pembelian</th>
                        <th>Tgl Tr Pembelian</th>
                        <th>Ket</th>
                        <th>Input Oleh</th>
                        <th>Action</th>
                    </tr>
                </thead>


                <tbody>
                <?php $no = 1; foreach ($get_tr as $val) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $val->id_tr_m;?></td>
                        <td><?php echo $val->tgl_tr_m; ?></td>
                        <td><?php echo $val->ket_tr_m; ?></td>
                        <td><?php echo $val->username;?></td>
                        <td>
                            <button type="button" class="btn-edit btn btn-info btn-sm" data-id="<?php echo $val->id_tr_m ?>" data-toggle="modal" data-target=".m-trm-detail" >Detail</button>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>

        </div>
    </div>
</div> <!-- end col -->

<!--  Modal content for the above example -->
<div class="modal fade m-trm-detail" tabindex="-1" role="dialog" aria-labelledby="title" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="tbldetail">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>ID Transaksi Masuk</th>
                            <th>KD Barang</th>
                            <th>Jumlah Masuk</th>
                            <th>Tanggal Masuk</th>
                        </tr>
                        </thead>
                        <tbody id="data">

                        </tbody>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>


<script>
$(document).ready(function() {
    $('#datatable1').DataTable();
} );   

$('.btn-edit').on('click',function () {
    var id = $(this).data('id');
    $.ajax({
        type: 'GET',
        url: "<?php echo base_url()?>C_barang/get_data_tr/"+id,
        async : true,
        dataType : "JSON",
        beforeSend: function() {
            // setting a timeout
            
        },
        success: function(data) {
            //var hasil = JSON.parse(data);
            var title = $('#title').text('NO Transaksi : '+id);
            var html = '';
            var i;
            for(i=0; i<data.length; i++){
                var no = i + 1;
                html += '<tr>'+
                            '<td>'+no+'</td>'+
                            '<td>'+data[i].id_tr_m+'</td>'+
                            '<td>'+data[i].kd_barang+' - '+data[i].nama_barang+'</td>'+
                            '<td>'+data[i].jumlah_masuk+'</td>'+
                            '<td>'+data[i].tgl_masuk+'</td>'+
                        '</tr>';
            }
            $('#data').html(html);
        },
        error: function(xhr) { // if error occured
            
        },
        complete: function() {
            
        }
    });
})

</script>