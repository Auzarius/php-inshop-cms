
<html lang="en">
	<head>
		<title>In-Shop Repair</title>
	<?php
	#require_once "php/ismobile.class.php";
	#require_once "framework.php";
	
	#$ismobi = new IsMobile();
	#$fw = new scaleDB('localhost', 'root', '', 'brechbuhler_test');

	if( $ismobi->CheckMobile() ) { ?>
		<link rel="stylesheet" type="text/css" href="css/framework.mobile.css" />
		<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script> <?php
	} else { ?>
		<link rel="stylesheet" type="text/css" href="css/framework.css" />
		<link rel="stylesheet" type="text/css" href="css/in-shop.css" />
		<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 
		<script src="./js/tablesorter/jquery.tablesorter.min.js"></script>
		<script src="./js/sort.js"></script>
		<script>
			$(function() {
				$( "#accordion" ).accordion({
				  collapsible: true
				});
			});
		</script> <?php	
	} ?>
		
		<!--[if lt IE9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<meta name="viewport" content="width=device-width">
	</head>
	
	<body>
	<?php
	if( $ismobi->CheckMobile() ) { ?>
		<div data-role="header" style="overflow:hidden;">
		<h1>In-shop Repairs</h1>
			<?php if ( $fw->isLoggedIn( $_SESSION ) ) { ?>
			<a href="logout.php" data-icon="gear" class="ui-btn-right">Logout</a> 
			<?php } ?>
			<div data-role="navbar">
				<ul>
					<li><a href="./" data-icon="home">Home</a></li>
					<li><a href="scaleCheckin.php" data-icon="check" >Scale Check-in</a></li>
					<li><a href="showRepairs.php" data-icon="eye" >View Repairs</a></li>
				</ul>
			</div><!-- /navbar -->
		</div><!-- /header --> <?php
	} else { ?>
	
		<header class="no-print">
			<nav>
				<span class="pl-10"></span>
				<a href="./"><img src="img/logo.png"></img></a>
				<span class="pr-10"></span>
				<ul class="nav-left">
					<li id="checkin"><a href="scaleCheckin.php">Check-in</a></li>
					<li id="scalerepair"><a href="showRepairs.php">View Repairs</a></li>
					<li id="scaleservice" hidden><a href="field-service.php">Field Service</a></li>
					<li id="search" hidden><a href="search.php">Search</a></li>
				</ul>
				<ul class="nav-right">
					<?php if ( isset( $_SESSION['USER']['username'] ) ) { echo "<li><a href=\"logout.php\">". $_SESSION['USER']['username'] ."</a></li>"; } ?>
					<li style="color: #303030;" hidden><a href="#">Sign Up</a></li>
				</ul>
			</nav>
		</header>
		
		<footer class="no-print">
			<p>
				This page and its service are provided as is and without any warranty of any kind.<br />
				If you have any questions or concerns please contact Anthony at <a href="mailto:amp050886@hotmail.com">amp050886@hotmail.com</a>
			</p>
		</footer>
		
	<?php 
		$beta = BETA;
		
		if ( $beta ) {
			require_once( 'debug.php' );	
		}
	} ?>
		