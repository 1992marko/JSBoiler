<!-- HTML MAIL -->
<!DOCTYPE html>
<html>
<head>
	<title>Sign up form</title>
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
			
			<h3>Company details</h3>
			<table>
				<tr>
					<td>Company Name</td>
					<td><?=$vars["companyName"]?></td>
				</tr>
				<tr>
					<td>Company Address</td>
					<td><?=$vars["companyAddr"]?></td>
				</tr>
				<tr>
					<td>Zip/Postal Code</td>
					<td><?=$vars["zipCode"]?></td>
				</tr>
				<tr>
					<td>Country</td>
					<td><?=$vars["country"]?></td>
				</tr>
				<tr>
					<td>City</td>
					<td><?=$vars["city"]?></td>
				</tr>
				<tr>
					<td>Preferred Payment Method</td>
					<td><?=$vars["payMethod"]?></td>
				</tr>
				<tr>
					<td>Preferred Currency</td>
					<td><?=$vars["currency"]?></td>
				</tr>

				<tr>
					<td>Telephone</td>
					<td><?=$vars["telephone"]?></td>
				</tr>

				<tr>
					<td>Fax</td>
					<td><?=$vars["fax"]?></td>
				</tr>

				<tr>
					<td>Website</td>
					<td><?=$vars["website"]?></td>
				</tr>
			</table>

			<h3>Main user details</h3>
			<table>
				<tr>
					<td>Title</td>
					<td><?=$vars["salutation"]?></td>
				</tr>
				<tr>
					<td>First Name</td>
					<td><?=$vars["firstName"]?></td>
				</tr>
				<tr>
					<td>Last Name</td>
					<td><?=$vars["lastName"]?></td>
				</tr>
				<tr>
					<td>Position/Designation</td>
					<td><?=$vars["position"]?></td>
				</tr>
				<tr>
					<td>Email Address</td>
					<td><?=$vars["email"]?></td>
				</tr>
				<tr>
					<td>Login ID</td>
					<td><?=$vars["loginId"]?></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><?=$vars["password"]?></td>
				</tr>
			</table>

		</div>

		<div class="wrap footer">
			<h4>Disclaimer</h4>
			<p class="disclaimer">This email is a request from b2b.goadriatica.com, if you received this mail by accident please ignore it.</p>
		</div>
	</div>

</body>
</html>
