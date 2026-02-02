<div class="col-lg-12">
    <div class="card m-b-30">
        <div class="card-body">

            <h4 class="mt-0 header-title">Data Transaksi Penjualan</h4>
            

            <table id="datatable1" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                <tr>
                    <th>No</th>
                    <th>ID Tr Penjualan</th>
                    <th>Tgl Tr Penjualan</th>
                    <th>Ket</th>
                    <th>Input Oleh</th>
                    <th>Action</th>
                </tr>
                </thead>


                <tbody>
                <?php $no = 1; foreach ($get_penjualan as $val) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $val->id_tr_k;?></td>
                        <td><?php echo $val->tgl_tr_k; ?></td>
                        <td><?php echo $val->ket_tr_k; ?></td>
                        <td><?php echo $val->username;?></td>
                        <td>
                            <button type="button" class="btn-edit btn btn-info btn-sm" data-id="<?php echo $val->id_tr_k ?>" data-toggle="modal" data-target=".m-trm-detail">Detail</button>
                            <a href="<?php echo base_url('C_barang/cetak_penjualan/').$val->id_tr_k;?>" class="btn btn-sm btn-primary" title="Cetak Invoice" target="_blank"><i class="dripicons-print"></i></a>
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
                    <table class="table table-bordered table-hover" id="tbldetail" >
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>ID Transaksi Keluar</th>
                            <th>KD Barang - Nama Barang</th>
                            <th>Qty</th>
                        </tr>
                        <!-- <tr class="accordion-toggle"  data-toggle="collapse" data-target="#collapseOne">
                            <td>1</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr id="collapseOne" class="collapse in">
                            <td></td>
                            <td colspan="3">
                                <div id="collapseOne" class="collapse in">
                                    Details 1 <br/>
                                    Details 2 <br/>
                                    Details 3 <br/>
                                </div>
                            </td>
                        </tr> -->
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
        url: "<?php echo base_url()?>C_barang/get_data_tr_jual/"+id,
        async : true,
        dataType : "JSON",
        beforeSend: function() {
            // setting a timeout
            
        },
        success: function(data) {
            //var hasil = JSON.parse(data);
            var title = $('#title').text('NO Transaksi Jual : '+id);
            var html = '';
            var i;
            var x;
            var total;
            for(i=0; i<data.length; i++){
                
                var no = i + 1;
                html += '<tr class="accordion-toggle"  style="cursor:pointer;" title="Klik Untuk Lihat Detail" data-toggle="collapse" data-target="#cl'+data[i].kd_barang+'">'+
                            '<td>'+no+'</td>'+
                            '<td>'+data[i].id_tr_k+'</td>'+
                            '<td>'+data[i].kd_barang+' - '+data[i].nama_barang+'</td>'+
                            '<td>'+data[i].jumlah_beli+'</td>'+
                        '</tr>';
                html += '<tr id="cl'+data[i].kd_barang+'" class="collapse in" >'+
                            '<td></td>'+
                            '<td colspan="3">'+
                                '<div id="cl'+data[i].kd_barang+'" class="collapse in">';
                                for(x=0; x<data[i].detail.length; x++){
                                        var jumlah_awal = data[i].detail[x].jumlah_awal;
                                        var jumlah_keluar = data[i].detail[x].jumlah_keluar;
                                        total = jumlah_awal - jumlah_keluar;
                                        html += '<ul><li><p>Id Transaksi Masuk : '+data[i].detail[x].id_tr_m+'<br>'+ 
                                        'Kode Barang/nama barang = '+data[i].detail[x].kd_barang+' '+ data[i].nama_barang+' <br>Qty Dipakai= '+total+'</p></li></ul>';    
                                };
                html +=        '<ul><p>Total : '+data[i].jumlah_beli+'</p></ul></div>'+
                            '</td>'+
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