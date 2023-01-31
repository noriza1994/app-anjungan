<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $this->config->item('namaapp'); ?></title>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/app.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/package/swiper/swiper-bundle.min.css" />
</head>
<style>
	body {
		background: url('assets/dist/img/bgpage.png') no-repeat center center fixed;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		background-size: cover;
		-o-background-size: cover;
	}

</style>

<body class="container mx-auto h-screen">
	<div class="flex flex-col gap-5 justify-center h-full items-center">
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
			<div class="w-3/5 bg-white rounded-3xl flex overflow-hidden">
				<div class="swiper mySwiper">
					<div class="swiper-wrapper h-96">
						<div class="swiper-slide ">
							<img class="object-cover w-full h-full" src="<?php echo base_url(); ?>assets/dist/img/slide1.jpg"
								alt="image" />
						</div>
						<div class="swiper-slide">
							<img class="object-cover w-full h-full" src="<?php echo base_url(); ?>assets/dist/img/slide1.jpg"
								alt="image" />
						</div>
						<div class="swiper-slide">
							<img class="object-cover w-full h-full" src="<?php echo base_url(); ?>assets/dist/img/slide1.jpg"
								alt="image" />
						</div>
					</div>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				</div>
			</div>

			<div class="flex flex-col w-2/5  py-5 gap-10 justify-center items-center">
				<a href="<?php echo site_url('jkn_online/antrian'); ?>" class="w-full ">
					<div class="flex justify-center flex-col gap-4 items-center font-bold text-4xl  bg-[#D7FFA4] hover:bg-[#B0FF4D] border-8 border-gray-700 rounded-3xl text-center" style="padding-top: 50px; padding-bottom: 50px;">
            <div>DAFTAR</div>  
            <div>MANDIRI</div>
          </div>
				</a>
				<a href="<?php echo site_url('jkn_online/antrian'); ?>" class="w-full">
          <div class="flex justify-center flex-col gap-4 items-center font-bold text-4xl  bg-[#88F8F6] hover:bg-[#26f3ef] border-8 border-gray-700 rounded-3xl text-center" style="padding-top: 50px; padding-bottom: 50px;">
            <div>KONFIRMASI</div>  
            <div>KEHADIRAN (CHECK-IN)</div>
          </div>
				</a>
			</div>
		</div>
		<div class="text-white">
			<?php echo $this->config->item('copyright'); ?>
		</div>
	</div>
	<!-- Swiper JS -->
	<script src="<?php echo base_url(); ?>assets/package/swiper/swiper-bundle.min.js"></script>
	<script>
		var swiper = new Swiper('.mySwiper', {
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
		});

	</script>
</body>

</html>
