<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $this->config->item('namaapp'); ?></title>

	<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
	<link href="<?php echo base_url(); ?>assets/select2.min.css" rel="stylesheet" />
	<script src="<?php echo base_url(); ?>assets/select2.min.js"></script>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/app.css">
</head>
<style>
	body {
		background: no-repeat center center fixed;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		background-size: cover;
		-o-background-size: cover;
	}

</style>

<body class="container mx-auto h-screen bg-[url('../../dist/img/bgpage.png')]">
	<div class="flex  flex-col gap-5 justify-center h-full items-center ">
		<div class="w-full bg-white rounded-3xl flex px-20 py-5">
			<div class="flex flex-col w-1/6 h-auto">
				<img src="<?php echo base_url(); ?>assets/dist/img/logo.png" class="w-40" alt="">
			</div>
			<div class="flex w-5/6 flex-col text-center items-center justify-center gap-3">
				<div class="font-bold text-4xl">ANJUNGAN CETAK SURAT ELIGIBILITAS PESERTA (SEP) BPJS</div>
				<div class="h-2 w-full rounded-3xl bg-gray-800"></div>
				<div class="font-bold text-4xl">RUMAH SAKIT UMUM DR.FAUZIAH</div>
			</div>
		</div>

		<div class="flex flex-row gap-10 w-full mt-10">
			<div class="w-full p-5 bg-white rounded-3xl flex flex-col overflow-hidden h-full">
        <div class="flex flex-row w-full h-auto bg-yellow-200 rounded-xl px-10 py-5">
          <div class="flex flex-row justify-center items-center"><i class="fas fa-exclamation-triangle text-4xl"></i></div>
          <div class="flex flex-col ml-6">
            <div class="text-2xl font-bold">Mohon Maaf...!</div>
            <div>Data tidak ditemukan atau belum pernah terdaftar sebagai pasien <?php echo $this->config->item('heder');?>Silahkan mendaftarkan data pasien baru secara mandiri
              </div>
          </div>
        </div>
				<form action="<?php echo base_url('jkn_online/add_antrian_jkn'); ?>" method="post" class="w-full">
					<div class="shadow overflow-hidden sm:rounded-md">
						<div class="px-4 py-5 bg-white sm:p-6 text-3xl">
							<div class="grid grid-cols-6 gap-6">
								<div class="col-span-6 sm:col-span-3 flex flex-row justify-center items-center">
									<label for="first_name" class="w-1/3 block text-lg text-gray-700 font-bold">No BPJS / No RM</label>
									<input type="text" placeholder="No BPJS / No RM" name="no_peserta" id="noka" value="<?php echo $peserta['noKartu'] ?>"
										class="w-2/3 mt-1 focus:ring-pink-500 h-9 px-2 focus:border-pink-500 block  shadow-sm text-lg border border-pink-400 rounded-md">
								</div>

								<div class="col-span-6 sm:col-span-3 flex flex-row justify-center items-center">
									<label for="first_name" class="w-1/3 block text-lg text-gray-700 font-bold">NIK</label>
									<input type="text" name="no_ktp" value="<?php echo $peserta['nik'] ?>"
										class="w-2/3 mt-1 focus:ring-pink-500 h-9 px-2 focus:border-pink-500 block  shadow-sm text-lg border border-pink-400 rounded-md">
								</div>

								<div class="col-span-6 sm:col-span-3 flex flex-row justify-center items-center">
									<label for="first_name" class="w-1/3 block text-lg text-gray-700 font-bold">Nama Pasien</label>
									<input type="text" placeholder="Nama Pasien" name="nm_pasien" value="<?php echo $peserta['nama'] ?>"
										class="w-2/3 mt-1 focus:ring-pink-500 h-9 px-2 focus:border-pink-500 block  shadow-sm text-lg border border-pink-400 rounded-md">

									<input type="hidden" name="tgl_lahir" id="tgl_lahir">
									<input type="hidden" name="hubungan_pj" id="keluarga">
									<input type="hidden" name="p_jawab" id="namakeluarga">
									<input type="hidden" name="almt_pj" id="alamatpj">
									<input type="hidden" name="kelurahanpj" id="kelurahanpj">
									<input type="hidden" name="kecamatanpj" id="kecamatanpj">
									<input type="hidden" name="kabupatenpj" id="kabupatenpj">
									<input type="hidden" name="propinsipj" id="propinsipj">
								</div>

                <div class="col-span-6 sm:col-span-3 flex flex-row justify-center items-center">
									<label for="first_name" class="w-1/3 block text-lg text-gray-700 font-bold">Tanggal Lahir</label>
									<input type="date" name="tgl_lahir" value="<?php echo $peserta['tglLahir'] ?>"
										class="w-2/3 mt-1 focus:ring-pink-500 h-9 px-2 focus:border-pink-500 block  shadow-sm text-lg border border-pink-400 rounded-md">
								</div>

								<div class="col-span-6 sm:col-span-3 flex flex-row justify-center items-center ">
									<label for="first_name" class="w-1/3 block text-lg text-gray-700 font-bold">No HP</label>
									<input type="text" placeholder="No Hp" name="no_tlp" value="<?php echo $peserta['mr']['noTelepon'] ?>"
										class="w-2/3 mt-1 focus:ring-pink-500 h-9 px-2 focus:border-pink-500 block  shadow-sm text-lg border border-pink-400 rounded-md">
								</div>

                <div class="col-span-6 sm:col-span-3 flex flex-row justify-center items-center">
									<label for="country" class="w-1/3 block font-bold text-gray-700 text-lg">Jenis Kelamin</label>
									<select name="jns_kunjungan" id="jns_kunjungan"
										class="w-2/3 mt-1 block py-2 px-3 border border-pink-400 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 text-lg">
										<?php 
                      if ($peserta['sex'] == 'L') {
                          $jeniskelamin = 'Laki-laki';
                      } else {
                          $jeniskelamin = 'Perempuan';
                      }
                    ?>
                    <option value="<?php $peserta['sex']?'L':'P'?>"><?=$jeniskelamin?></option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
									</select>
								</div>


								<div class="col-span-6 sm:col-span-3 flex flex-row justify-center items-center">
									<label for="country" class="w-1/3 block font-bold text-gray-700 text-lg">Jenis Kunjungan</label>
									<select name="jns_kunjungan" id="jns_kunjungan"
										class="w-2/3 mt-1 block py-2 px-3 border border-pink-400 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 text-lg">
										<option value="">Jenis Kunjungan</option>
										<option value="1">Rujukan FKTP</option>
										<option value="2">Rujukan Internal</option>
										<option value="3">Kontrol</option>
										<option value="4">Rujukan Antar RS</option>
									</select>
								</div>

								<div class="col-span-6 sm:col-span-3 flex flex-row justify-center items-center">
									<label for="first_name" class="w-1/3 block font-bold text-gray-700 text-lg">No Referensi /
										Rujukan</label>
									<select name="no_referensi" id="no_referensi"
										class="w-2/3 no_referensi mt-1 block  py-2 px-3 border border-pink-400 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 text-lg">
										<option value="0">No Referensi / Rujukan</option>
									</select>
								</div>


								<div class="col-span-6 sm:col-span-3 flex flex-row justify-center items-center">
									<label for="country" class="w-1/3 block text-lg font-bold text-gray-700">Poliklinik Tujuan</label>
									<select name="kd_poli" id="poli"
										class="w-2/3 poli mt-1 block  py-2 px-3 border border-pink-400 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
										<option value="0">Pilih Poliklinik</option>
									</select>
								</div>

                <div class="col-span-6 sm:col-span-3 flex flex-row justify-center items-center">
									<label for="first_name" class="w-1/3 block font-bold text-gray-700 text-lg">Pilih Dokter</label>
									<select name="kd_dokter" id="dokter"
										class="dokter w-2/3 no_referensi mt-1 block  py-2 px-3 border border-pink-400 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 text-lg">
										<option value="0">Pilih Dokter</option>
									</select>
								</div>

								<!-- <div class="col-span-6  flex flex-row ">
									<label for="country" class="block text-sm font-bold text-gray-700">Pilih Dokter</label>
									<select name="kd_dokter" id="dokter"
										class="dokter mt-1 block w-full py-2 px-3 border border-pink-400 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
										<option value="0">Pilih Dokter</option>
									</select>
								</div> -->
							</div>
						</div>
						<div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
							<button type="submit"
								class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-500 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
								Lanjutkan
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="text-white">
			<?php echo $this->config->item('copyright'); ?>
		</div>
	</div>
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
</body>

</html>
