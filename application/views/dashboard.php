<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->config->item('namaapp'); ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
  </head>

  <body class="hold-transition sidebar-collapse layout-top-nav">
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
                  <button class="btn btn-warning lg">Kembali</button>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <a id="post1" href="javascript:void(0)">
                  <div class="card card-primary card-outline">
                    <div class="card-body bg-orange color-palette">
                      <p class="card-text">
                        <h1 class="text-center"><b>PASIEN LAMA</b></h1>
                      </p>
                    </div>
                  </div>
                </a>

                <a id="post2" href="javascript:void(0)">
                  <div class="card card-primary card-outline">
                    <div class="card-body bg-orange color-palette">
                      <p class="card-text">
                        <h1 class="text-center"><b>PASIEN BARU</b></h1>
                      </p>
                    </div>
                  </div><!-- /.card -->
                </a>

                <a id="post3" href="javascript:void(0)">
                  <div class="card card-primary card-outline">
                    <div class="card-body bg-orange color-palette">
                      <p class="card-text">
                        <h1 class="text-center"><b>RAWAT INAP</b></h1>
                      </p>

                    </div>
                  </div>
                </a>

              </div>
              <!-- /.col-md-6 -->
              <div class="col-lg-6">

                <a id="post4" href="javascript:void(0)">
                  <div class="card card-primary card-outline">
                    <div class="card-body bg-orange color-palette">
                      <p class="card-text">
                        <h1 class="text-center"><b>PRIORITAS</b></h1>
                      </p>

                    </div>
                  </div><!-- /.card -->
                </a>

                <a id="post5" href="javascript:void(0)">
                  <div class="card card-primary card-outline">
                    <div class="card-body bg-orange color-palette">
                      <p class="card-text">
                        <h1 class="text-center"><b>UMUM</b></h1>
                      </p>
                      
                    </div>
                  </div><!-- /.card -->
                </a>

                <a id="post6" href="javascript:void(0)">
                  <div class="card card-primary card-outline">
                    <div class="card-body bg-orange color-palette">
                      <p class="card-text">
                        <h1 class="text-center"><b>APOTEK</b></h1>
                      </p>
                      
                    </div>
                  </div><!-- /.card -->
                </a>

              </div>
              <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-lg-12">
                <a href="<?php echo site_url('jkn_online/antrian'); ?>">
                  <div class="card card-success card-outline">
                    <div class="card-body bg-primary color-palette">
                      <p class="card-text">
                        <h1 class="text-center"><b>JKN ONLINE</b></h1>
                      </p>
                    </div>
                  </div><!-- /.card -->
                </a>
              </div>  
            </div>

          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
          <?php echo $this->config->item('namars'); ?>
        </div>
        <!-- Default to the left -->
        <?php echo $this->config->item('copyright'); ?>
      </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <script type="text/javascript">
      $(document).ready(function() {
        // proses post1 data
        $('#post1').on('click', function() {
          var post    = 'POST0';
          var source  = 'TICKET#0';
          $.ajax({
            type: 'POST', // mengirim data dengan method POST
            url: '<?php echo site_url('beranda/add_antrian'); ?>', // url file proses insert data
            data : {post:post, source:source},
            success: function(result) {       // ketika proses insert data selesai
              window.open('<?php echo site_url('beranda/ctk_antrian/POST0'); ?>','popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');

            },
          });
        });
      });
    </script>

    <script type="text/javascript">
      $(document).ready(function() {
        // proses post1 data
        $('#post2').on('click', function() {
          var post    = 'POST1';
          var source  = 'TICKET#1';
          $.ajax({
            type: 'POST', // mengirim data dengan method POST
            url: '<?php echo site_url('beranda/add_antrian'); ?>', // url file proses insert data
            data : {post:post, source:source},
            success: function(result) {       // ketika proses insert data selesai
              window.open('<?php echo site_url('beranda/ctk_antrian/POST1'); ?>','popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');

            },
          });
        });
      });
    </script>

    <script type="text/javascript">
      $(document).ready(function() {
        // proses post1 data
        $('#post3').on('click', function() {
          var post    = 'POST2';
          var source  = 'TICKET#2';
          $.ajax({
            type: 'POST', // mengirim data dengan method POST
            url: '<?php echo site_url('beranda/add_antrian'); ?>', // url file proses insert data
            data : {post:post, source:source},
            success: function(result) {       // ketika proses insert data selesai
              window.open('<?php echo site_url('beranda/ctk_antrian/POST2'); ?>','popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');

            },
          });
        });
      });
    </script>


    <script type="text/javascript">
      $(document).ready(function() {
        // proses post1 data
        $('#post4').on('click', function() {
          var post    = 'POST3';
          var source  = 'TICKET#3';
          $.ajax({
            type: 'POST', // mengirim data dengan method POST
            url: '<?php echo site_url('beranda/add_antrian'); ?>', // url file proses insert data
            data : {post:post, source:source},
            success: function(result) {       // ketika proses insert data selesai
              window.open('<?php echo site_url('beranda/ctk_antrian/POST3'); ?>','popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');

            },
          });
        });
      });
    </script>


    <script type="text/javascript">
      $(document).ready(function() {
        // proses post1 data
        $('#post5').on('click', function() {
          var post    = 'POST6';
          var source  = 'TICKET#6';
          $.ajax({
            type: 'POST', // mengirim data dengan method POST
            url: '<?php echo site_url('beranda/add_antrian'); ?>', // url file proses insert data
            data : {post:post, source:source},
            success: function(result) {       // ketika proses insert data selesai
              window.open('<?php echo site_url('beranda/ctk_antrian/POST6'); ?>','popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');

            },
          });
        });
      });
    </script>

    <script type="text/javascript">
      $(document).ready(function() {
        // proses post1 data
        $('#post6').on('click', function() {
          var post    = 'POST7';
          var source  = 'TICKET#7';
          $.ajax({
            type: 'POST', // mengirim data dengan method POST
            url: '<?php echo site_url('beranda/add_antrian'); ?>', // url file proses insert data
            data : {post:post, source:source},
            success: function(result) {       // ketika proses insert data selesai
              window.open('<?php echo site_url('beranda/ctk_antrian/POST7'); ?>','popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');

            },
          });
        });
      });
    </script>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
  </body>
</html>
