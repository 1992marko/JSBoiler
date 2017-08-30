<!-- HTML MAIL -->
<!DOCTYPE html>
<html>
<head>
	<title>Upit za turu</title>
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


	</style>

	<div class="wrapper">

		<div class="wrap">
			<img class="logo" src="https://b2b.goadriatica.com/assets/logo.svg" />
		</div>

		<div class="wrap">
			<h1>Upit za turu</h1>
			<h4>Upit sa web stranica www.atlas.hr</h4>
		</div>

		<div class="wrap content">
			
			<h3>Putnici</h3>
			<ul class="passengers">
			<?php
				foreach ($vars["passengers"] as $key => $value){
					echo "<li>".$key.' : '.$value."</li>";
				}
			?>
			</ul>

			<h3>Detalji</h3>
			<table>
				<tr>
					<td>Tour Name</td>
					<td><?=$vars["tourName"]?></td>
				</tr>
				<tr>
					<td>Tour start date</td>
					<td><?=$vars["tourStartDate"]?></td>
				</tr>
				<tr>
					<td>Name</td>
					<td><?=$vars["name"]?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?=$vars["email"]?></td>
				</tr>
				<tr>
					<td>Message</td>
					<td><?=$vars["message"]?></td>
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
