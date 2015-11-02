<html>
	<head>
		<title>In-Shop Repair</title>
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
		
		<h1>In Shop Repair - Search</h1>
		<form action="results.php" method="post">
			Choose Search Type:<br />
			
			<select name="searchtype">
				<option value="scale_capacity">Capacity</option>
				<option value="city">City</option>
				<option value="companyname" selected>Customer</option>
				<option value="date">Date</option>
				<option value="scale_manu">Manufacturer</option>
				<option value="scale_serial">Serial Number</option>
				<option value="street">Street</option>
				<option value="tech_id">Tech</option>
			</select>
			<br /><br />
			
			Enter Search Term:<br />
			<input name="searchterm" type="text" size="40"/>
			<br /><br />
			
			<input class="button" type="submit" name="submit" value="Search"/>
		</form>
	</body>
</html>