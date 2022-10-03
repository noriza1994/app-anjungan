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
          <div class="container">

            <div class="card card-success card-outline">
              <div class="card-heder bg-primary">
                  <div class="callout callout-warning" style="color: black;">
                    <h5>Mohon Maaf...!</h5>
                    <p>Data tidak ditemukan atau belum pernah terdaftar sebagai pasien <?php echo $this->config->item('heder'); ?>.<br>
                        Apakah anda ingin mendaftarkan data pasien baru secara mandiri?</p>
                  </div>
                  <div class="row col-md-12">
                    <div class="form-group row">
                        <label class="col-md-12 col-form-label">&nbsp; &nbsp; &nbsp;Input Data Pasien Baru :</label>
                    </div>
                  </div>
                  <hr>
                </div>
              <div class="card-body bg-primary color-palette">
                <form method="post" action="<?php echo site_url('jkn_online/save_pasien_baru') ?>">
                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">No Kartu BPJS</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="no_peserta" id="noka" value="<?php echo $peserta['noKartu'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">NIK</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="no_ktp" value="<?php echo $peserta['nik'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Nama Pasien</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="nm_pasien" value="<?php echo $peserta['nama'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">No Hp</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="no_tlp" value="<?php echo $peserta['mr']['noTelepon'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                      <div class="col-sm-8">
                        <?php 
                          if ($peserta['sex'] == 'L') {
                             $jeniskelamin = 'Laki-laki';
                          } else {
                             $jeniskelamin = 'Perempuan';
                          }
                          
                        ?>
                        <input type="text" class="form-control" value="<?php echo $jeniskelamin ?>" readonly>
                        <input type="hidden" name="jk" value="<?php echo $peserta['sex'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="tgl_lahir" value="<?php echo $peserta['tglLahir'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <!-- <label class="col-sm-4 col-form-label">Tempat Lahir</label> -->
                      <div class="col-sm-8">
                        <input type="hidden" class="form-control" name="t_lahir">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <!-- Provinsi -->
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Jenis Kunjungan</label>
                        <div class="col-sm-8">
                          <select class="form-control" name="jns_kunjungan" id="jns_kunjungan">
                            <option value="">Jenis Kunjungan</option>
                            <option value="1">Rujukan FKTP</option>
                            <option value="2">Rujukan Internal</option>
                            <option value="3">Kontrol</option>
                            <option value="4">Rujukan Antar RS</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">No Referensi / Rujukan</label>
                        <div class="col-sm-8">
                          <select name="no_referensi" id="no_referensi" class="no_referensi form-control">
                              <option value="0">No Referensi / Rujukan</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Poliklinik Rujukan</label>
                        <div class="col-sm-8">
                          <select name="kd_poli" id="poli" class="poli form-control">
                              <option value="0">Pilih Poliklinik</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Pilih Dokter</label>
                        <div class="col-sm-8">
                          <select name="kd_dokter" id="dokter" class="dokter form-control">
                              <option value="0">Pilih Dokter</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                          <button type="submit" class="btn btn-warning btn-block">Lanjutkan</button>
                        </div>
                      </div>
                  </div>

                </div>
                </form>
              </div>

              <div class="card-footer bg-success color-palette">
                Pastikan Data Sudah Benar
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
        $(document).ready(function(){
            $('#jns_kunjungan').change(function(){
              var jns_kunjungan=$(this).val();
              var noka = document.getElementById('noka').value;
                $.ajax({
                  url : "<?php echo site_url('jkn_online/referensi_nomor_daftar'); ?>",
                  method : "POST",
                  data : {jns_kunjungan: jns_kunjungan, noka: noka},
                  async : false,
                  dataType : 'json',
                  success: function(data){
                      var html = '';
                      var i;
                      for(i=0; i<data.length; i++){
                          html += '<option value="'+data[i].noKunjungan+'">'+data[i].noKunjungan+' - '+data[i].poliRujukan.nama+'</option>';
                      }
                      $('.no_referensi').html(html);
                  }
              });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
          var id = $(this).val();
          $.ajax({
                    url : "<?php echo site_url('jkn_online/referensi_poli');?>",
                    method : "POST",
                    data : {id: id},
                    async : false,
                    dataType : 'json',
                    success: function(data){
                        var html = '';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value="'+data[i].kd_poli_bpjs+'">'+data[i].nm_poli_bpjs+'</option>';
                        }
                        $('.poli').html(html);
                         
                    }
                });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#poli').change(function(){
                var poli = document.getElementById('poli').value; 
                $.ajax({
                    url : "<?php echo site_url('jkn_online/referensi_dokter');?>",
                    method : "POST",
                    data : {poli: poli},
                    async : false,
                    dataType : 'json',
                    success: function(data){
                        var html = '';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value="'+data[i].kd_dokter_bpjs+'">'+data[i].nm_dokter_bpjs+'</option>';
                        }
                        $('.dokter').html(html);
                         
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#provinsi').change(function(){
                var provinsi = document.getElementById('provinsi').value; 
                $.ajax({
                    url : "<?php echo site_url('jkn_online/referensi_kabupaten');?>",
                    method : "POST",
                    data : {provinsi: provinsi},
                    async : false,
                    dataType : 'json',
                    success: function(data){
                        var html = '';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value="'+data[i].kode+'">'+data[i].nama+'</option>';
                        }
                        $('.kab').html(html);  
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#kabupaten').change(function(){
                var kabupaten= document.getElementById('kabupaten').value; 
                $.ajax({
                    url : "<?php echo site_url('jkn_online/referensi_kecamatan');?>",
                    method : "POST",
                    data : {kabupaten: kabupaten},
                    async : false,
                    dataType : 'json',
                    success: function(data){
                        var html = '';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value="'+data[i].kode+'">'+data[i].nama+'</option>';
                        }
                        $('.kec').html(html);  
                    }
                });
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