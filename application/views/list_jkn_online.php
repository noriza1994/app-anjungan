<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->config->item('namaapp'); ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/JsBarcode.all.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/qrcode.js"></script>
    <script src="<?php echo base_url(); ?>assets/qrcode.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/select2.min.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>assets/select2.min.js"></script>
  </head>

  <body class="hold-transition sidebar-collapse layout-top-nav" onload="setFocusToTextBox()">
    <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand-md navbar-light navbar-primary">
        <div class="container">
          <a href="<?php echo base_url(); ?>assets/index3.html" class="navbar-brand">
            <img src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light"><?php echo $this->config->item('namaapp'); ?></span>
          </a>

          

          <!-- Right navbar links -->
          <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <h4><?php echo $this->config->item('namars'); ?></h4>
          </ul>
        </div>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="<?php echo base_url(); ?>assets/index3.html" class="brand-link">
          <img src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" id="updater">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0"> <?php echo $this->config->item('heder'); ?></h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <a href="<?php echo site_url('beranda'); ?>" class="btn btn-warning">Kembali</a>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
          <div class="container">
            <?php if ($this->session->flashdata('notifikasi')){ ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><?php echo $this->session->flashdata('notifikasi'); ?></h4>
              </div>
            <?php } ?>
            <div class="card">
              <div class="card-header bg-info color-palette">
                <h3 class="card-title">
                  Dashboard Antrian Online JKN Periode Bulan <?php echo $periode['tanggal'] ?>
                </h3>

                <div class="card-tools">
                  <form method="post" action="<?php echo site_url('jkn_online/filter_list_jkn_online'); ?>">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="date" name="tanggal" class="form-control float-right" value="<?php echo date('Y-m-d'); ?>">
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode Booking</th>
                        <th class="text-center">Nama Pasien</th>
                        <th class="text-center">Poliklinik</th>
                        <th class="text-center">Jenis Kunjungan</th>
                        <th class="text-center"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no=1; foreach ($jkn as $data) { ?>                   
                      <tr>
                        <td class="text-center"><?php echo $no; ?></td>
                        <td class="text-center"><?php echo $data['nobooking'] ?></td>
                        <td class="text-left"><?php echo $data['nm_pasien'] ?></td>
                        <td class="text-left"><?php echo $data['nm_poli_bpjs'] ?></td>
                        <td class="text-left"><?php echo $data['jeniskunjungan'] ?></td>
                        <td class="text-center">
                          <div class="btn-group">
                      <button class="btn btn-inverse dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="fa fa-user-md"></i> Tindak Lanjut
                      </button>
                      <ul class="dropdown-menu stay-open pull-right" role="menu" style="padding: 15px; min-width: 300px;">
                        <li>
                          <a href="<?php echo site_url('jkn_online/taksid/'.str_replace('/','--', $data['nobooking']).'/1');?>">Taks ID 1</a>
                        </li>
                        <li>
                          <a href="<?php echo site_url('jkn_online/taksid/'.str_replace('/','--', $data['nobooking']).'/2');?>">Taks ID 2</a>
                        </li>
                        <li>
                          <a href="<?php echo site_url('jkn_online/taksid/'.str_replace('/','--', $data['nobooking']).'/3');?>">Taks ID 3</a>
                        </li>
                        <li>
                          <a href="<?php echo site_url('jkn_online/taksid/'.str_replace('/','--', $data['nobooking']).'/4');?>">Taks ID 4</a>
                        </li>
                        <li>
                          <a href="<?php echo site_url('jkn_online/taksid/'.str_replace('/','--', $data['nobooking']).'/5');?>">Taks ID 5</a>
                        </li>
                        <li>
                          <a href="<?php echo site_url('jkn_online/taksid/'.str_replace('/','--', $data['nobooking']).'/6');?>">Taks ID 6</a>
                        </li>
                        <li>
                          <a href="<?php echo site_url('jkn_online/taksid/'.str_replace('/','--', $data['nobooking']).'/7');?>">Taks ID 7</a>
                        </li>
                        <li>
                          <a href="<?php echo site_url('jkn_online/taksid/'.str_replace('/','--', $data['nobooking']).'/99');?>">Taks ID 99</a>
                        </li>
                      </ul>
                    </div>
                        </td>
                      </tr>
                    <?php $no++; } ?>
                    </tbody>
                  </table>
              </div>

              <div class="card-footer bg-info color-palette">

              </div>

            </div>

          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer" style="background-color: #007bff;">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
          <?php echo $this->config->item('namars'); ?>
        </div>
        <!-- Default to the left -->
        <?php echo $this->config->item('copyright'); ?>
      </footer>
    </div>
    <!-- ./wrapper -->

    
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE App -->
    <script type="text/javascript"> 
        var auto_refresh = setInterval( function() { 
            $('#updater').load('<?php echo site_url('beranda/updater'); ?>').fadeIn("slow"); }, 90000); 
    </script>
  </body>
</html>