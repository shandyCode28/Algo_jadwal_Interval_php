<?php

function format_waktu( $waktu ){
	if ( $waktu < 10 ) {
		$waktu = "0" . $waktu;
	}

	$waktu = $waktu . ".00";
	return $waktu;
}

function jadwal_interval($waktu_buka, $waktu_tutup ){
	$data_waktu = [];

	// Jika waktu berinterval hanya dalam 1 hari 24 jam
	if ( $waktu_buka < $waktu_tutup ) {
		for ($waktu=$waktu_buka; $waktu < $waktu_tutup; $waktu++) { 
			
			$waktu_mulai = $waktu;
			$waktu_selesai = $waktu_mulai + 1;
			$interval = [ $waktu_mulai, $waktu_selesai ];
			$data_waktu[] = $interval;
		}
	}else{
		// Jika waktu berinterval lebih dari 1 hari 24 jam

		// Batas akhir jam 12 malam atau 24 atau 00
		for ($waktu = $waktu_buka; $waktu < 24; $waktu++) { 
			$waktu_mulai = $waktu;
			$waktu_selesai = $waktu_mulai + 1;
			if ( $waktu_selesai == 24 ) {
				$waktu_selesai = 0;
			}
			$interval = [ $waktu_mulai, $waktu_selesai ];
			$data_waktu[] = $interval;
		}

		// Mulai dari 0
		for ($waktu=0; $waktu < $waktu_tutup; $waktu++) { 
			$waktu_mulai = $waktu;
			$waktu_selesai = $waktu_mulai + 1;
			$interval = [ $waktu_mulai, $waktu_selesai ];
			$data_waktu[] = $interval;
		}
	}

	return $data_waktu;
}




$data_waktu = [];
if ( isset($_POST['submit_jadwal']) ) {
	$waktu_buka = $_POST['waktu_buka'];
	$waktu_tutup = $_POST['waktu_tutup'];
	$data_waktu = jadwal_interval($waktu_buka, $waktu_tutup);
}



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		
	</title>

	<style type="text/css">
	.container{
		width: 50%;
		margin: auto;
	}
	.form_group{
		width: 100%;
		height: auto;
	}
	.form_group *{
		width: 100%;
		height: auto;
		margin-bottom: 30px;
	}
	.form_group label{
		display: block;
		margin-bottom: 10px;
	}
	.form_group input, select{
		padding: 10px;
		padding-left: 10px;
		padding-right: 0;
		border: 2px solid #000;
	} 
	button{
		width: 100%;
		padding: 20px;
		font-size: 10px;
		box-shadow: none;
		border: none;
		background: green;
		color: #fff;
		border-radius: 12px;
		font-size: 17px;
	}
	table{
		width: 100%;
	}
	table td{
		text-align: center;
		padding: 20px;
	}
</style>
</head>
<body>

	<div class="container">
		<h2 style="text-align: center;"> Form Buat Jadwal Interval </h2>
		<h3> Akan membuat jadwal waktu dengan interval waktu 1 jam, yang dimulai dari waktu buka sampai waktu tutup </h3>
		<form method="post" action="">	


			<div class="form_group">
				<label> Waktu Buka : </label>
				<select name="waktu_buka" autosave="on">
					<?php for ($waktu=0; $waktu <= 23; $waktu++) { 
						?>
						<option value="<?=$waktu?>"> <?= format_waktu($waktu) ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form_group">
				<label> Waktu Tutup : </label>
				<select name="waktu_tutup" autosave="on">
					<?php for ($waktu=0; $waktu <= 23; $waktu++) { 
						?>
						<option value="<?=$waktu?>"> <?= format_waktu($waktu) ?></option>
					<?php } ?>
				</select>

			</div>

			<button name="submit_jadwal">
				Buat Jadwal
			</button>

		</form>

		<div class="box_hasil">
			<h2> Hasil Jadwal : </h2>
			<table border="1">
				<tr> 
					<td> Waktu Mulai </td>
					<td> Waktu Selesai </td>
				</tr>
				<?php foreach ($data_waktu as $row_waktu): ?>
					<tr> 
						<td> <?= format_waktu($row_waktu[0]) ?> </td>
						<td> <?= format_waktu($row_waktu[1]) ?> </td>
					</tr>
				<?php endforeach ?>

			</table>

		</div>
	</div>

</body>
</html>







