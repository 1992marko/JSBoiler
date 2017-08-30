<!-- HTML MAIL -->
<!DOCTYPE html>
<html>
<head>
	<title>Group inquiry form</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type"  content="text/html charset=UTF-8" />
</head>
<body>
	<!-- DEFINE CSS HERE -->
	<style type="text/css">
		body { 
			margin: 0;
			padding: 0;
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
			<h1>Group inquiry form</h1>
			<h4>Group request from B2B.GOADRIATICA.COM</h4>
		</div>

		<div class="wrap content">
			
			<h3>Group Request Form</h3>
			<table>
				<tr>
					<td>Group Name</td>
					<td><?=$vars["groupname"]?></td>
				</tr>
				<tr>
					<td>Nationality</td>
					<td><?=$vars["nationality"]?></td>
				</tr>
			</table>

			<h3>Contact person</h3>
			<table>
				<tr>
					<td>Person</td>
					<td><?=$vars["title"]?> <?=$vars["firstname"]?> <?=$vars["lastname"]?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?=$vars["email"]?></td>
				</tr>
				<tr>
					<td>Telephone</td>
					<td><?=$vars["telephone"]?></td>
				</tr>
			</table>

			<h3>Reservation details</h3>
			<table>
				<tr>
					<td>Destination city</td>
					<td><?=$vars["destinationCity"]?></td>
				</tr>
				<tr>
					<td>Hotel Stars/Category</td>
					<td><?=$vars["hotelStars"]?></td>
				</tr>
				<tr>
					<td>Arrival date</td>
					<td><?=$vars["arrivalDate"]?></td>
				</tr>
				<tr>
					<td>Nights</td>
					<td><?=$vars["nights"]?></td>
				</tr>
				<tr>
					<td>No. of passenger</td>
					<td><?=$vars["passengers"]?></td>
				</tr>
				<tr>
					<td>Aprox. budget</td>
					<td><?=$vars["aproxBudget"]?></td>
				</tr>
			</table>

			<h3>Room types</h3>
			<table>
				<tr>
					<td>Single</td>
					<td>Double</td>
					<td>Twin</td>
					<td>Tripple</td>
				</tr>

				<tr>
					<td><?=$vars["singleRoom"]?></td>
					<td><?=$vars["doubleRoom"]?></td>
					<td><?=$vars["twinRoom"]?></td>
					<td><?=$vars["trippleRoom"]?></td>
				</tr>
			</table>	

			<div>
				<b>Meal plan : </b><?=$vars["mealPlan"]?>
			</div>

			<div>
				<h3>Comments</h3>
				<div><?=$vars["comments"]?></div>
			</div>

		</div>

		<div class="wrap footer">
			<h4>Disclaimer</h4>
			<p class="disclaimer">This email is a request from b2b.goadriatica.com, if you received this mail by accident please ignore it.</p>
		</div>
	</div>

</body>
</html>
