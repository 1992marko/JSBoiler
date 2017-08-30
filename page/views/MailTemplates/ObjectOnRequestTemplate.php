<!-- HTML MAIL -->
<!DOCTYPE html>
<html>
<head>
	<title>Objekt na upit</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type"  content="text/html charset=UTF-8" />
</head>
<body>
	<!-- DEFINE CSS HERE -->
	<style type="text/css">
		*{
			box-sizing: border-box;
		}

		body { 
			margin: 0;
			padding: 20px;
			font-family: Helvetica, Arial, sans-serif; 
			font-size: 14px; 
			background-color: #F9F9F9;

		}

		h1 {
			margin : 0 0 15px 0;
			color: #0066A2;
		}

		ul {
			list-style: none;
			padding: 0;
			margin: 0 0 20px 0; 
		}

		ul li{
			margin: 0;
			padding: 0;
		}

		.wrapper{
			position: relative;
			width: 100%;
			padding: 20px 0;
		}

		.wrap {
			max-width: 600px;
			width: 100%;
			margin: 0 auto;
		}

		.content {
			padding: 20px;
			
			border: 1px solid #F1F1F1;
			border-radius: 8px;
			background-color: #FFF;
		}

		.footer{
			
		}

		.disclaimer{
			font-size: 12px;
			color: #8C8C8C;
		}

		table{
			width: 100%;
			border-spacing: 0;
			border-collapse: collapse;
		}

		table td {
			padding: 8px;
			border-top: 1px solid #ddd;
		}

		ul.passengers {
			margin-bottom: 20px;
			overflow: hidden;
		}

		ul.passengers li {
			
			
		}

		.logo{
			max-width: 200px;
			margin-bottom: 20px;
		}


	</style>

	<div class="wrapper">

		<div class="wrap">
			<img class="logo" src="https://b2b.goadriatica.com/assets/logo.svg" />
		</div>

		<div class="wrap content">

			<h1><?=$vars["Name"]?></h1>
			<h4>Rezervacija ili upit sa web stranice ATLAS.HR</h4>

			<hr>
			
			<h3>Putnici</h3>
			<ul class="passengers">
			<?php
				foreach ($vars["rooms"] as $key => $value){
					echo "<li>Soba ".($key+1)."</li>";

					foreach ($value["passengers"] as $key2 => $value2){
						echo '<li>'.$value2["type"].' '.$value2["title"].' '.$value2["firstname"].' '.$value2["lastname"].' '.$value2["birthDate"].'</li>';
					}
				}
			?>
			</ul>

			<h3>Detalji</h3>
			<table>
				<tr>
					<td>Ime objekta</td>
					<td><?=$vars["Name"]?></td>
				</tr>
				<tr>
					<td>Datum polaska</td>
					<td><?=$vars["Checkin"]?></td>
				</tr>
				<tr>
					<td>Datum odlaska</td>
					<td><?=$vars["Checkout"]?></td>
				</tr>
				<tr>
					<td>Booking reference</td>
					<td><?=$vars["BookingReference"]?></td>
				</tr>
			</table>

			<h3>Korisnik</h3>
			<table>
				<tr>
					<td>Ime i prezime</td>
					<td><?=$user->title?> <?=$user->ime?> <?=$user->prezime?></td>
				</tr>
				<tr>
					<td>Adresa</td>
					<td><?=$user->adresa?> <br> <?=$user->postanski?> <br> <?=$user->grad?> </td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?=$user->email?></td>
				</tr>
				<tr>
					<td>Telefon</td>
					<td><?=$user->telefon?></td>
				</tr>
				
			</table>	

			<h3>Dodatni zahtjevi</h3>

			<ul>
				<li>Prizemlje <?=$vars["GroundFloor"]?></li>
				<li>Viši katovi <?=$vars["HighFloor"]?></li>
				<li>Kasni dolazak <?=$vars["LateCheckin"]?></li>
				<li>Rani dolazak <?=$vars["EarlyCheckin"]?></li>
				<li>Kasni odlazak <?=$vars["LateCheckout"]?></li>
			</ul>

			<h3>Neki drugi zahtjev</h3>
			<?=$vars["Notes"]?>

		</div>

		<div class="wrap footer">
			<h4>Disclaimer</h4>
			<p class="disclaimer">This email is a request from www.atlas.hr, if you received this mail by accident please ignore it.</p>
		</div>
	</div>

</body>
</html>
