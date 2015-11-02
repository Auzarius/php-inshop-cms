<html lang="en">
	<head>
		<title>In-Shop Repair</title>
		<link rel="stylesheet" type="text/css" href="framework.css" />
		<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="in-shop.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script>
			$(function() {
			$( "#accordion" ).accordion({
			  collapsible: true
			});
			});
		</script>
		<!--<link rel="stylesheet" type="text/css" href="quantum.css" />-->
		<!--[if lt IE9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<meta name="viewport" content="width=device-width">
	</head>
	
	<body>
		<header class="no-print">
			<nav>
				<span class="pl-10"></span>
				<a href="http://auzarius.com/scales/inshop"><img src="logo.png"></img></a>
				<span class="pr-10"></span>
				<ul class="nav-left">
					<li id="checkin"><a href="scaleCheckin.php">Check-in</a></li>
					<li id="scalerepair"><a href="showRepairs.php">View Repairs</a></li>
					<li id="scaleservice" hidden><a href="field-service.php">Field Service</a></li>
					<li id="search" hidden><a href="search.php">Search</a></li>
				</ul>
				<ul class="nav-right">
					<?php if ( isset( $_SESSION['val_username'] ) ) { echo "<li><a href=\"logout.php\">". $_SESSION['val_username'] ."</a></li>"; } ?>
					<li style="color: #303030;" hidden><a href="#">Sign Up</a></li>
				</ul>
			</nav>
		</header>
		
		<footer class="no-print">
			<p>
				This page is provided as is and without any warranty of any kind.<br />
				If you have any issues please contact Anthony at <a href=\"mailto:amp050886@hotmail.com\">amp050886@hotmail.com</a>
			</p>
		</footer>
		