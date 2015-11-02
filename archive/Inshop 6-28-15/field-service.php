<html>
	<head>
		<title>Scale Repair</title>
		<link rel="stylesheet" type="text/css" href="framework.css" />
		<link rel="stylesheet" type="text/css" href="in-shop.css" />
		<!--<link rel="stylesheet" type="text/css" href="quantum.css" />-->
		<!--[if lt IE9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<a hreflang="en"></a>
	</head> 
	
	<body>
		<?php include ('header.php'); ?>
		
		<h1>Field Service</h1>
		<form action="add_service.php" method="post">
			
			<table>
				<tr>
					<th colspan="2">Technician</th>
				</tr>
				<tr>
					<td>Full Name:</td>
					<td><input name="techname" type="text" size="25" maxlength="40"/></td>
				</tr>
			</table>
			<br />
			
			<table>
				<tr>
					<th colspan="2">Customer Information</th>
				</tr>
				<tr>
					<td>Company Name:</td>
					<td><input name="companyname" type="text" size="25" maxlength="40"/></td>
				</tr>
				<tr>
					<td>Street:</td>
					<td><input name="street" type="text" size="25" maxlength="25"/></td>
				</tr>
				<tr>
					<td>City:</td>
					<td><input name="city" type="city" size="25" maxlength="15"/></td>
				</tr>
				<tr>
					<td>State:</td>
					<td><input name="state" type="state" size="2" maxlength="2"/></td>
				</tr>
				<tr>
					<td>Zip Code:</td>
					<td><input name="zipcode" type="zip" size="8" maxlength="15"/></td>
				</tr>				
			</table>
			<br />
			
			<table>
				<tr>
					<th colspan="2">Indicator Information</th>
				</tr>
				<tr>
					<td>Tag Number:</td>
					<td><input name="indicator_tag" type="text" size="25" maxlength="15"/></td>
				</tr>
				<tr>
					<td>Manufacturer:</td>
					<td><input name="indicator_manu" type="text" size="25" maxlength="25"/></td>
				</tr>
				<tr>
					<td>Model:</td>
					<td><input name="indicator_model" type="text" size="25" maxlength="25"/></td>
				</tr>
				<tr>
					<td>Serial:</td>
					<td><input name="indicator_serial" type="text" size="25" maxlength="20"/></td>
				</tr>
			</table>
			<br />
			
			<table>
				<tr>
					<th colspan="2">Scale Information</th>
				</tr>
				<tr>
					<td>Manufacturer:</td>
					<td><input name="scale_manu" type="text" size="25" maxlength="25"/></td>
				</tr>
				<tr>
					<td>Model:</td>
					<td><input name="scale_model" type="text" size="25" maxlength="25"/></td>
				</tr>
				<tr>
					<td>Serial:</td>
					<td><input name="scale_serial" type="text" size="25" maxlength="20"/></td>
				</tr>
				<tr>
					<td>Capacity:</td>
					<td><input name="scale_capacity" type="text" size="10" maxlength="10"/></td>
				</tr>
				<tr>
					<td>Divisions:</td>
					<td><input name="scale_divisions" type="text" size="6" maxlength="10"/></td>
				</tr>
				<tr>
					<td>Units:</td>
					<td>
						<input name="units" type="radio" value="lb" checked>lb</input>
						<input name="units" type="radio" value="kg">kg</input>
						<input name="units" type="radio" value="g">g</input>
					</td>
				</tr>
			</table>
			<br />
			
			Service Comments:<br />
			<textarea name="comments" type="text" cols="50" rows="12" maxlength="1000"></textarea>
			<br /><br />
			
			<input type="submit" name="submit" value="Submit"/>
		</form>
	</body>
</html>