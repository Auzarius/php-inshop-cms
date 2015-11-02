<?php
	session_start();
	date_default_timezone_set('EST');
	include ('framework.php');
	
	$fw = new framework;
	
	$techname = $fw->clean_input($_POST['techname']);
	$companyname = $fw->clean_input($_POST['companyname']);
	$street = $fw->clean_input($_POST['street']);
	$city = $fw->clean_input($_POST['city']);
	$state = $fw->clean_input($_POST['state']);
	$zipcode = $fw->clean_input($_POST['zipcode']);
	$indicator_tag = $fw->clean_input($_POST['indicator_tag']);
	$indicator_manu = $fw->clean_input($_POST['indicator_manu']);
	$indicator_model = $fw->clean_input($_POST['indicator_model']);
	$indicator_serial = $fw->clean_input($_POST['indicator_serial']);
	$scale_manu = $fw->clean_input($_POST['scale_manu']);
	$scale_model = $fw->clean_input($_POST['scale_model']);
	$scale_serial = $fw->clean_input($_POST['scale_serial']);
	$scale_capacity = $fw->clean_input($_POST['scale_capacity']);
	$scale_divisions = $fw->clean_input($_POST['scale_divisions']);
	$units = $fw->clean_input($_POST['units']);
	$date = date('m/d/Y') . " @ " . date('h:i:s A');
	$comments = $fw->clean_input($_POST['comments']);
	$status = $fw->clean_input($_POST['status']);
	
	if ( $state == "NU" ) { $state == "IN"; }
	
	$digest = md5(	$_POST['techname'] .
					$_POST['companyname'] .
					$_POST['street'] .
					$_POST['city'] .
					$_POST['state'] .
					$_POST['indicator_manu'] .
					$_POST['indicator_model'] .
					$_POST['indicator_serial'] .
					$_POST['scale_manu'] .
					$_POST['scale_model'] .
					$_POST['scale_serial'] .
					$_POST['scale_capacity'] .
					$_POST['scale_divisions'] .
					date('m') . "/" . date('d') . "/" . date('Y')
				);
	
	$sessionDigest = isset($_SESSION['digest'])?$_SESSION['digest']:'';
	
	//echo "Digest: " . $digest . "<br />";
	//echo "Session: " . $sessionDigest . "<br />";
	
	if( $digest != $sessionDigest ) {
				
		$db = new mysqli('localhost', 'root', '', 'brechbuhler');
				
		if (mysqli_connect_error()) {
			$errnum = mysqli_connect_errno();
			echo "Error($errnum): Could not connect to database. Please try again later.";
			exit;
		}
		
		#First database query to insert the user submitted data into the scales table
		$query1 = "insert into scales values\r\n" .
			"('NULL', " .
			"'" . $status . "', " .
			"'" . $date . "', " .
			"'" . $techname . "', " .
			"'" . $companyname . "', " .
			"'" . $street . "', " .
			"'" . $city . "', " .
			"'" . $state . "', " .
			"'" . $zipcode . "', " .
			"'" . $indicator_tag . "', " .
			"'" . $indicator_manu . "', " .
			"'" . $indicator_model . "', " .
			"'" . $indicator_serial . "', " .
			"'" . $scale_manu . "', " .
			"'" . $scale_model . "', " .
			"'" . $scale_serial . "', " .
			"'" . $scale_capacity . "', " .
			"'" . $scale_divisions . "', " .
			"'" . $units . "'); ";
			
		
		$result = $db->query($query1);
		#END first query
		
		#Second Database query to get the new scale ID that was just set
		$query2 = "select id from scales where date like '" . $date . "'";
		$result2 = $db->query($query2);
		
		$ID = 0;
		while($row = $result2->fetch_assoc()) {
			$ID = $row['id'];
		}
		#END second query

		#Third database query to set the comments into its own table
		$query3 = "insert into events values\r\n" .
		"('NULL', " .
		"'" . $date . "', " .
		"'" . $ID . "', " .
		"'" . $techname . "', " .
		"'Created the scale entry', " .
		"'" . $comments . "'); ";
		
		$result3 = $db->query($query3);
		#END third query
		$db->close();
		
		if ( $result ) {
			$_SESSION['digest'] = $digest;
			
			//$result->free();
			header("Location: index.php?result=1");
			
			die();
		} else {
			header("Location: index.php?result=2");
			//echo $query;
			die();
		}
		
		
	} else {
		header("Location: index.php?result=3");
		die();
	}
?>