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

        <?php 
          $formatted = date("d-m-Y H:i:s", $tiket['estimasidilayani'] / 1000);
        ?>
        <!-- Main content -->
        <div class="content">
          <div class="container">

            <div class="card card-success card-outline">
              <div class="card-body bg-primary color-palette">
                <div class="row">
                  <div class="col-md-12">
                    <h1 class="text-center">Pendaftaran Dengan Nomor Antrian <?php echo $tiket['nomorantrean']; ?>  Berhasil</h1>
                    <hr>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div align="center" id="qrcode" placeholder="RSIA ACEH"></div>
                    <script type="text/javascript">
                        var qrcode = new QRCode("qrcode", {
                        text: "<?php echo $tiket['nobooking']; ?>",
                        width: 125,
                        height: 125,
                        colorDark : "#000000",
                        colorLight : "#ffffff",
                        correctLevel : QRCode.CorrectLevel.H,
                        backgroundImage: 'https://rsia.acehprov.go.id/thumbnail/0x40/media/2021.09/rsia_png1.png',
                    });
                    </script>
                    <div align="center">
                      <h2><?php echo $tiket['nomorantrean']; ?></h2>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <table class="table-borderless table-condensed table-hover">
                      <tr>
                          <td>No Boking</td>
                          <td>: <?php echo $tiket['nobooking']; ?></td>
                      </tr>
                      <tr>
                          <td>No Peserta</td>
                          <td>: <?php echo $tiket['nomorkartu']; ?></td>
                      </tr>
                      <tr>
                          <td>No RM</td>
                          <td>: <?php echo $tiket['norm']; ?></td>
                      </tr>
                      <tr>
                          <td>No Antrian</td>
                          <td>: <?php echo $tiket['nomorantrean']; ?></td>
                      </tr>
                      <tr>
                          <td>Estimasi</td>
                          <td>: <?php echo $formatted; ?></td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-4">
                    <table class="table-borderless table-condensed table-hover">
                      <tr>
                          <td>Nama Pasien</td>
                          <td>: <?php echo $tiket['nm_pasien']; ?></td>
                      </tr>
                      <tr>
                          <td>Poliklinik</td>
                          <td>: <?php echo $tiket['nm_poli_bpjs']; ?></td>
                      </tr>
                      <tr>
                          <td>Nama Dokter</td>
                          <td>: <?php echo $tiket['nm_dokter_bpjs']; ?></td>
                      </tr>
                      <tr>
                          <td>No referensi</td>
                          <td>: <?php echo $tiket['nomorreferensi']; ?></td>
                      </tr>
                      <tr>
                          <td>Tanggal Periksa</td>
                          <td>: <?php echo $tiket['tanggalperiksa']; ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <h4>Peserta harap 30 menit lebih awal guna pencatatan administrasi.</h4>
                  </div>
                </div>
              </div>

              <div class="card-footer bg-success color-palette">
                <a id="post1" href="javascript:void(0)" class="btn btn-warning" style="float:right;">Cetak</a>
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

    <script type="text/javascript">
      $(document).ready(function() {
        // proses post1 data
        $('#post1').on('click', function() {
          window.location.href = "<?php echo site_url('beranda'); ?>";
          window.open('<?php echo site_url('jkn_online/ctk_bukti_daftar/'.$tiket['nobooking'].''); ?>','popUpWindow','height=400,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
        });
      });
    </script>
    <!-- jQuery -->
    
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
  </body>
</html>