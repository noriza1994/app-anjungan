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
              <div class="card-body bg-primary color-palette">
                <div class="row">
                  <div class="col-md-6">
                    <h1 class="text-center">PESERTA BPJS</h1>
                    <h5>Syarat Peserta BPJS FKTL</h5>
                    <ul>
                      <li>Sudah Terdaftar Sebagai Pasien BPJS</li>
                      <li>Sudah Mendapatkan Rujukan Di Faskes Tingkat Pertama</li>
                      <li>Pastikan sudah membawa kartu identitas seperti kartu pasien / kartu BPJS atau KTP</li>
                      <li>Jika ada yang belum dipahami, maka bisa ditanyakan lebih lanjut pada petugas</li>
                    </ul>
                  </div>

                  <div class="col-md-6">
                    <form class="form-horizontal" action="<?php echo base_url('jkn_online/add_antrian_jkn'); ?>" method="post">
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">No BPJS / No RM</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="noka" placeholder="No BPJS / No RM" id="noka" onchange="return autofill();">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Pasien</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="nm_pasien" placeholder="Nama Pasien" id="nm_pasien" readonly>
                          <input type="hidden" name="tgl_lahir" id="tgl_lahir">
                          <input type="hidden" name="hubungan_pj" id="keluarga">
                          <input type="hidden" name="p_jawab" id="namakeluarga">
                          <input type="hidden" name="almt_pj" id="alamatpj">
                          <input type="hidden" name="kelurahanpj" id="kelurahanpj">
                          <input type="hidden" name="kecamatanpj" id="kecamatanpj">
                          <input type="hidden" name="kabupatenpj" id="kabupatenpj">
                          <input type="hidden" name="propinsipj" id="propinsipj">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">NIK</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="nik" placeholder="NIK" id="nik" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">No Rekam Medik</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="no_rkm_medis" placeholder="No Rekam Medik" id="norm" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">No Hp</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="no_hp" placeholder="No Hp" id="no_hp" readonly>
                        </div>
                      </div>
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
                    </form>
                  </div>
                </div>
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

    <!-- REQUIRED SCRIPTS -->
    <script type="text/javascript">
      function autofill(){
            var noka =document.getElementById('noka').value;
            $.ajax({
            url:"<?php echo site_url('jkn_online/referensi_peserta');?>",
            data:'&noka='+noka,
            success:function(data){
              var pasien = JSON.parse(data);  
                if (pasien == null) {
                  window.location.href = "<?php echo base_url('jkn_online/pasien_baru/'); ?>"+noka;
                }else{
                  $.each(pasien, function(key,val){ 
                   document.getElementById('noka').value=pasien.no_peserta;
                   document.getElementById('nm_pasien').value=pasien.nm_pasien; 
                   document.getElementById('nik').value=pasien.no_ktp;
                   document.getElementById('norm').value=pasien.no_rkm_medis;
                   document.getElementById('no_hp').value=pasien.no_tlp;
                   document.getElementById('tgl_lahir').value=pasien.tgl_lahir;
                   document.getElementById('keluarga').value=pasien.keluarga;
                   document.getElementById('namakeluarga').value=pasien.namakeluarga;
                   document.getElementById('alamatpj').value=pasien.alamatpj;
                   document.getElementById('kelurahanpj').value=pasien.kelurahanpj;
                   document.getElementById('kecamatanpj').value=pasien.kecamatanpj;
                   document.getElementById('kabupatenpj').value=pasien.kabupatenpj;
                   document.getElementById('propinsipj').value=pasien.propinsipj;
                  });
                }
            }
          });              
        }
    </script>

    <script types="text/javascript">
      function setFocusToTextBox(){
          document.getElementById("noka").focus();
      }  
    </script>

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

    <!-- jQuery -->
    
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
  </body>
</html>