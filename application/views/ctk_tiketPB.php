<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tiket</title>
	<script>
        window.print();
        window.onafterprint = window.close;
    </script>
</head>
<body>
	<div style="width: 227px; margin-left: 10px;
    margin-right: 10px;
    padding-left: 0px;
    padding-right: 0px;
    margin-top: 10px;
    margin-bottom: 5px;">
		<h5 align="center" style="font-size: 25px; margin-bottom: 0px; margin-top: 0px;">
			<?php echo post($tiket['post']); ?><br>
			<?php echo mediumdate_indo(date('Y-m-d')); ?><br>
			Nomor Antrian
		</h5>

		<h2 align="center" style="font-size: 65px; margin-bottom: 0px; margin-top: 0px;">
			<b><?php echo $tiket['numberprefix']; ?> <?php echo $tiket['number'] ?></b>
		</h2>

		<h5 align="center" style="font-size: 20px; margin-bottom: 0px; margin-top: 0px;">
			<b>RM. <?php echo $PB['no_rkm_medis']; ?> Poli - <?php echo $PB['no_antri_poli'] ?></b>
		</h5>

		<h5 align="center" style="font-size: 25px; margin-bottom: 0px; margin-top: 0px;">RSIA ACEH</h5>
	</div>
</body>
</html>