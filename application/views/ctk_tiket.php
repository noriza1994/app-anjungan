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
		<h4 align="center" style="font-size: 25px; margin-bottom: 0px; margin-top: 0px;"><?php echo post($tiket['post']); ?><br><?php echo longdate_indo(date('Y-m-d')); ?><br>Nomor Antrian</h4>

		<h1 align="center" style="font-size: 75px; margin-bottom: 0px; margin-top: 0px;">
			<b><?php echo $tiket['numberprefix']; ?> <?php echo $tiket['number'] ?></b>
		</h1>

		<h5 align="center" style="font-size: 25px; margin-bottom: 0px; margin-top: 0px;">RSIA ACEH</h5>
	</div>
</body>
</html>