<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title><?php echo $title; ?></title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="<?php echo base_url()?>assets/images/log/logo_dark.png">

    

        <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url()?>assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url()?>assets/css/style.css" rel="stylesheet" type="text/css">

          <!-- DataTables -->
        <link href="<?php echo base_url()?>assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="<?php echo base_url()?>assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        
        <link href="<?php echo base_url()?>assets/plugins/select2/css/select2-bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    </head>


    <body class="fixed-left ">

        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </div>
        </div>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <?php $this->load->view('incl/v_left_menu'); ?>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                    <?php $this->load->view('incl/v_top_bar'); ?>
                    <!-- Top Bar End -->

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h4 class="page-title m-0"><?php echo $title; ?></h4>
                                            </div>
                                           
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <!-- end page-title-box -->
                                </div>
                            </div> 
                            <!-- end page title -->

                            <div class="row">
                                
                                <?php if(!empty($content)){
                                    $this->load->view($content);
                                    }else{ ?>
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <?php $this->load->view("incl/v_404");?>
                                                </div>
                                            </div>
                                        </div>
                                   <?php }?>
                            </div>  
                            <!-- end row -->
   
                        </div><!-- container fluid -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                <?php $this->load->view('incl/v_footer')?>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        
        <script src="<?php echo base_url()?>assets/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/modernizr.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/detect.js"></script>
        <script src="<?php echo base_url()?>assets/js/fastclick.js"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo base_url()?>assets/js/waves.js"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.scrollTo.min.js"></script>

        
         <!-- Required datatable js -->
        <script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/jszip.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/pdfmake.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

        <script src="<?php echo base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>

        <script src="<?php echo base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Datatable init js -->
        <script src="<?php echo base_url() ?>assets/pages/datatables.init.js"></script>

        <!-- dashboard js -->
        <script src="<?php echo base_url()?>assets/pages/dashboard.int.js"></script>        

        <!-- App js -->
        <script src="<?php echo base_url()?>assets/js/app.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    theme: 'bootstrap4',
                    tags: true,
                    allowClear: true,
                });
            });
        </script>
                                        
    </body>
</html>