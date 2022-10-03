<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RSUD GAYO LUES</title>

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
                  Dashboard Antrian Online JKN Periode Bulan <?php echo $periode['bulan'] ?> Tahun <?php echo $periode['tahun'] ?> Waktu <?php echo $periode['waktu'] ?>
                </h3>

                <div class="card-tools">
                  <form method="post" action="<?php echo site_url('jkn_online/filter_dashboard_bulan'); ?>">
                    <div class="input-group input-group-sm" style="width: 300px;">
                      <select name="bulan" class="form-control float-right">
                        <option value="01" <?php if(date('m') == '01'){echo 'selected';} ?>>01</option>
                        <option value="02" <?php if(date('m') == '02'){echo 'selected';} ?>>02</option>
                        <option value="03" <?php if(date('m') == '03'){echo 'selected';} ?>>03</option>
                        <option value="04" <?php if(date('m') == '04'){echo 'selected';} ?>>04</option>
                        <option value="05" <?php if(date('m') == '05'){echo 'selected';} ?>>05</option>
                        <option value="06" <?php if(date('m') == '06'){echo 'selected';} ?>>06</option>
                        <option value="07" <?php if(date('m') == '07'){echo 'selected';} ?>>07</option>
                        <option value="08" <?php if(date('m') == '08'){echo 'selected';} ?>>08</option>
                        <option value="09" <?php if(date('m') == '09'){echo 'selected';} ?>>09</option>
                        <option value="10" <?php if(date('m') == '10'){echo 'selected';} ?>>10</option>
                        <option value="11" <?php if(date('m') == '11'){echo 'selected';} ?>>11</option>
                        <option value="12" <?php if(date('m') == '12'){echo 'selected';} ?>>12</option>
                      </select>
                      <select name="tahun" class="form-control float-right">
                        <?php
                          $thn_skr = date('Y');
                          for ($x = $thn_skr; $x >= 2010; $x--) {
                          ?>
                              <option value="<?php echo $x ?>"><?php echo $x ?></option>
                          <?php
                          }
                        ?>
                      </select>
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
                        <td class="text-center"><?php echo $data->waktu_task1; ?></td>
                        <td class="text-center"><?php echo $data->avg_waktu_task1; ?></td>
                        <td class="text-center"><?php echo $data->waktu_task2; ?></td>
                        <td class="text-center"><?php echo $data->avg_waktu_task2; ?></td>
                        <td class="text-center"><?php echo $data->waktu_task3; ?></td>
                        <td class="text-center"><?php echo $data->avg_waktu_task3; ?></td>
                        <td class="text-center"><?php echo $data->waktu_task4; ?></td>
                        <td class="text-center"><?php echo $data->avg_waktu_task4; ?></td>
                        <td class="text-center"><?php echo $data->waktu_task5; ?></td>
                        <td class="text-center"><?php echo $data->avg_waktu_task5; ?></td>
                        <td class="text-center"><?php echo $data->waktu_task6; ?></td>
                        <td class="text-center"><?php echo $data->avg_waktu_task6; ?></td>
                        <td><?php echo date("Y-m-d H:i:s", $data->insertdate / 1000 + 7); ?></td>
                        <td><?php echo $data->tanggal; ?></td>
                      </tr>
                    <?php } ?>
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
  </body>
</html>