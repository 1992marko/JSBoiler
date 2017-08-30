<!-- HTML MAIL -->
<!DOCTYPE html>
<html>
<head>
	<title>Putovanja po mjeri</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type"  content="text/html charset=UTF-8" />
</head>
<body>
	<!-- DEFINE CSS HERE -->
	<style type="text/css">
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

		.title{
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
			float: left;
			margin-right: 10px;
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

		<div class="wrap">
			<h1 class="title">Putovanja po mjeri</h1>
			<h4>Upit sa web stranice www.atlas.hr</h4>
		</div>

		<div class="wrap content">
			
			<h3>Osobne informacije</h3>
			<table>
				<tr>
					<td>Ime i prezime</td>
					<td><?=$vars["firstname"]?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?=$vars["email"]?></td>
				</tr>
				<tr>
					<td>Telefon</td>
					<td><?=$vars["telephone"]?></td>
				</tr>
				
				<tr>
					<td>Preferirani kontakt putem</td>
					<td><?=$vars["prefKontakt"]?></td>
				</tr>
				<tr>
					<td>Najbolje vrijeme za kontakriranje</td>
					<td><?=$vars["vrijemeZaKontakt"]?></td>
				</tr>
				
			</table>

			<h3>Detalji</h3>
			<table>
				<tr>
					<td>Odrasli</td>
					<td><?=$vars["odrasli"]?></td>
				</tr>
				<tr>
					<td>Djeca</td>
					<td><?=$vars["djeca"]?></td>
				</tr>
				<tr>
					<td>Planirani budžet (po osobi)</td>
					<td><?=$vars["planBudjet"]?></td>
				</tr>
				
				<tr>
					<td>Polazno mjesto</td>
					<td><?=$vars["polaznoMjesto"]?></td>
				</tr>
				<tr>
					<td>Željeni datum polaska</td>
					<td><?=$vars["datumPolaska"]?></td>
				</tr>
				<tr>
					<td>Moji datumi su fleksibilni</td>
					<td><?=$vars["datumiFlex"]?></td>
				</tr>
				<tr>
					<td>Vrijeme trajanja boravka</td>
					<td><?=$vars["trajanjeBoravka"]?></td>
				</tr>
				<tr>
					<td>Destinacija</td>
					<td><?=$vars["destinacija"]?></td>
				</tr>
				<tr>
					<td>Osnovna usluga u smještaju</td>
					<td><?=$vars["uslugaSmjestaj"]?></td>
				</tr>
				
			</table>

			<h3>Kategorija smještaja</h3>
			<table>
				<tr>
					<td>*</td>
					<td><?=$vars["katSmjestaja1"]?></td>
				</tr>
				<tr>
					<td>**</td>
					<td><?=$vars["katSmjestaja2"]?></td>
				</tr>
				<tr>
					<td>***</td>
					<td><?=$vars["katSmjestaja3"]?></td>
				</tr>
				<tr>
					<td>****</td>
					<td><?=$vars["katSmjestaja4"]?></td>
				</tr>
				<tr>
					<td>*****</td>
					<td><?=$vars["katSmjestaja5"]?></td>
				</tr>
			</table>

			<h3>Prijevoz</h3>
			<table>
				<tr>
					<td>Vlastiti auto</td>
					<td><?=$vars["vlastitiAuto"]?></td>
				</tr>
				<tr>
					<td>Rent-a-car</td>
					<td><?=$vars["rentACar"]?></td>
				</tr>
				<tr>
					<td>Avion</td>
					<td><?=$vars["avion"]?></td>
				</tr>
				<tr>
					<td>Brod</td>
					<td><?=$vars["brod"]?></td>
				</tr>
			</table>

			<h3>Temperatura</h3>
			<table>
				<tr>
					<td>Hladno (<6°C)</td>
					<td><?=$vars["hladno"]?></td>
				</tr>
				<tr>
					<td>Prosječno (6-15°C)</td>
					<td><?=$vars["prosjecno"]?></td>
				</tr>
				<tr>
					<td>Toplo (16-25°C)</td>
					<td><?=$vars["toplo"]?></td>
				</tr>
				<tr>
					<td>Vruće (>25°C)</td>
					<td><?=$vars["vruce"]?></td>
				</tr>
			</table>

			<h3>Posebnosti položaja smještaja</h3>
			<table>
				<tr>
					<td>Blizu aerodroma</td>
					<td><?=$vars["blizuAerodroma"]?></td>
				</tr>
				<tr>
					<td>Blizu grada</td>
					<td><?=$vars["blizuGrada"]?></td>
				</tr>
				<tr>
					<td>Prvi red do mora</td>
					<td><?=$vars["prviRed"]?></td>
				</tr>
				<tr>
					<td>Povijesni centar</td>
					<td><?=$vars["povijesniCentar"]?></td>
				</tr>
				<tr>
					<td>Pješčana plaža</td>
					<td><?=$vars["pjescanaPlaza"]?></td>
				</tr>
				<tr>
					<td>Muzeji u blizini</td>
					<td><?=$vars["muzejiuBlizini"]?></td>
				</tr>
				<tr>
					<td>Shopping centar u blizini</td>
					<td><?=$vars["shopping"]?></td>
				</tr>
			</table>

			<h3>Posebnost sadržaja u smještaju</h3>
			<table>
				<tr>
					<td>Dječja animacija</td>
					<td><?=$vars["djecijaAnimacija"]?></td>
				</tr>
				<tr>
					<td>Wellness</td>
					<td><?=$vars["wellness"]?></td>
				</tr>
				<tr>
					<td>Bazen</td>
					<td><?=$vars["bazen"]?></td>
				</tr>
				<tr>
					<td>Vodeni sportovi</td>
					<td><?=$vars["vodeniSportovi"]?></td>
				</tr>
				<tr>
					<td>Golf</td>
					<td><?=$vars["golf"]?></td>
				</tr>
			</table>

			<h3>Smještaj prilagođen</h3>
			<table>
				<tr>
					<td>Obiteljima</td>
					<td><?=$vars["obiteljima"]?></td>
				</tr>
				<tr>
					<td>Mladencima</td>
					<td><?=$vars["mladencima"]?></td>
				</tr>
				<tr>
					<td>Za tulumarenje</td>
					<td><?=$vars["tulumarenje"]?></td>
				</tr>
				<tr>
					<td>Za meditaciju</td>
					<td><?=$vars["meditaciju"]?></td>
				</tr>
				<tr>
					<td>Za invalide</td>
					<td><?=$vars["invalide"]?></td>
				</tr>
			</table>

		</div>

		<div class="wrap footer">
			<h4>Disclaimer</h4>
			<p class="disclaimer">This email is a request from www.atlas.hr, if you received this mail by accident please ignore it.</p>
		</div>
	</div>

</body>
</html>
