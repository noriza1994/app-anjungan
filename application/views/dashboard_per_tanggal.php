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
      <div class="content-wrapper">
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
          <div class="container-fluid">

            <div class="card">
              <div class="card-header bg-info color-palette">
                <h3 class="card-title">
                  Dashboard Antrian Online JKN Tanggal <?php echo $periode['tanggal'] ?> Waktu <?php echo $periode['waktu'] ?>
                </h3>

                <div class="card-tools">
                  <form method="post" action="<?php echo site_url('jkn_online/filter_dashboard_tanggal'); ?>">
                    <div class="input-group input-group-sm" style="width: 300px;">
                      <input type="date" name="tanggal" class="form-control float-right" value="<?php echo $periode['tanggal']; ?>">
                      <select name="waktu" class="form-control float-right">
                        <option value="server">Server</option>
                        <option value="rs">RS</option>
                      </select>
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
                        <th class="text-center">Poliklinik</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Task 1</th>
                        <th class="text-center">AVG Taks 1</th>
                        <th class="text-center">Taks 2</th>
                        <th class="text-center">AVG Taks 2</th>
                        <th class="text-center">Taks 3</th>
                        <th class="text-center">AVG Taks 3</th>
                        <th class="text-center">Taks 4</th>
                        <th class="text-center">AVG Task 4</th>
                        <th class="text-center">Taks 5</th>
                        <th class="text-center">AVG Taks 5</th>
                        <th class="text-center">Taks 6</th>
                        <th class="text-center">AVG Taks 6</th>
                        <th class="text-center">Tgl Insert</th>
                        <th class="text-center">Tanggal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($dashboard as $data) { ?>                   
                      <tr>
                        <td><?php echo $data->kodepoli; ?> - <?php echo $data->namapoli; ?></td>
                        <td class="text-center"><?php echo $data->jumlah_antrean; ?></td>
                        <td class="text-center"><?php echo gmdate("H:i:s", $data->waktu_task1); ?></td>
                        <td class="text-center"><?php echo gmdate("H:i:s", $data->avg_waktu_task1); ?></td>
                        <td class="text-center"><?php echo gmdate("H:i:s", $data->waktu_task2); ?></td>
                        <td class="text-center"><?php echo gmdate("H:i:s", $data->avg_waktu_task2); ?></td>
                        <td class="text-center"><?php echo gmdate("H:i:s", $data->waktu_task3); ?></td>
                        <td class="text-center"><?php echo gmdate("H:i:s", $data->avg_waktu_task3); ?></td>
                        <td class="text-center"><?php echo gmdate("H:i:s", $data->waktu_task4); ?></td>
                        <td class="text-center"><?php echo gmdate("H:i:s", $data->avg_waktu_task4); ?></td>
                        <td class="text-center"><?php echo gmdate("H:i:s", $data->waktu_task5); ?></td>
                        <td class="text-center"><?php echo gmdate("H:i:s", $data->avg_waktu_task5); ?></td>
                        <td class="text-center"><?php echo gmdate("H:i:s", $data->waktu_task6); ?></td>
                        <td class="text-center"><?php echo gmdate("H:i:s", $data->avg_waktu_task6); ?></td>
                        <td><?php echo date("Y-m-d H:i:s", $data->insertdate / 1000); ?></td>
                        <td><?php echo $data->tanggal; ?></td>
                      </tr>
                    <?php } ?>
                    </tbody>
                  </table>
              </div>
              <hr>
              <div class="col-lg-12">
                <p><b>Catatan:</b></p>
                <p>
                  a)  Waktu Task 1 = Waktu tunggu admisi dalam detik <br>
                  b)  Waktu Task 2 = Waktu layan admisi dalam detik <br>
                  c)  Waktu Task 3 =  Waktu tunggu poli dalam detik <br>
                  d)  Waktu Task 4 = Waktu layan poli dalam detik <br>
                  e)  Waktu Task 5 = Waktu tunggu farmasi dalam detik <br>
                  f)  Waktu Task 6 = Waktu layan farmasi dalam detik <br>
                  g)  Insertdate = Waktu pengambilan data, timestamp dalam milisecond <br>
                  h)  Waktu server adalah data waktu (task 1-6) yang dicatat oleh server BPJS Kesehatan setelah RS mengimkan data, sedangkan waktu rs adalah data waktu (task 1-6) yang dikirimkan oleh RS 
                </p>
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
  </body>
</html>