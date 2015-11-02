<?php
	session_start();
	date_default_timezone_set('EST');
	
	$techname = trim($_POST['techname']);
	$companyname = trim($_POST['companyname']);
	$street = trim($_POST['street']);
	$city = trim($_POST['city']);
	$state = trim($_POST['state']);
	$zipcode = trim($_POST['zipcode']);
	$indicator_tag = trim($_POST['indicator_tag']);
	$indicator_manu = trim($_POST['indicator_manu']);
	$indicator_model = trim($_POST['indicator_model']);
	$indicator_serial = trim($_POST['indicator_serial']);
	$scale_manu = trim($_POST['scale_manu']);
	$scale_model = trim($_POST['scale_model']);
	$scale_serial = trim($_POST['scale_serial']);
	$scale_capacity = trim($_POST['scale_capacity']);
	$scale_divisions = trim($_POST['scale_divisions']);
	$units = trim($_POST['units']);
	$date = date('m') . "/" . date('d') . "/" . date('Y');
	$comments = trim($_POST['comments']);
	
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
		
		if ( !$techname || $techname == "" ) { $techname = "NULL"; }
		if ( !$companyname || $companyname == "" ) { $companyname = "NULL"; }
		if ( !$street || $street == "" ) { $street = "NULL"; }
		if ( !$city || $city == "" ) { $city = "NULL"; }
		if ( !$state || $state == "" ) { $state = "NULL"; }
		if ( !$zipcode || $zipcode == "" ) { $zipcode = "NULL"; }
		if ( !$indicator_tag || $indicator_tag == "" ) { $indicator_tag = "NULL"; }
		if ( !$indicator_manu || $indicator_manu == "" ) { $indicator_manu = "NULL"; }
		if ( !$indicator_model || $indicator_model == "" ) { $indicator_model = "NULL"; }
		if ( !$indicator_serial || $indicator_serial == "" ) { $indicator_serial = "NULL"; }
		if ( !$scale_manu || $scale_manu == "" ) { $scale_manu = "NULL"; }
		if ( !$scale_model || $scale_model == "" ) { $scale_model = "NULL"; }
		if ( !$scale_serial || $scale_serial == "" ) { $scale_serial = "NULL"; }
		if ( !$scale_capacity || $scale_capacity == "" ) { $scale_capacity = "NULL"; }
		if ( !$scale_divisions || $scale_divisions == "" ) { $scale_divisions = "NULL"; }
		if ( !$units || $units == "" ) { $units = "NULL"; }
		if ( !$date || $date == "" ) { $date = "NULL"; }
		if ( !$comments || $comments == "" ) { $comments = "NULL"; }
		
		if (!get_magic_quotes_gpc()){
			$techname = addslashes($techname);
			$companyname = addslashes($companyname);
			$street = addslashes($street);
			$city = addslashes($city);
			$state = addslashes($state);
			$zipcode = addslashes($zipcode);
			$indicator_tag = addslashes($indicator_tag);
			$indicator_manu = addslashes($indicator_manu);
			$indicator_model = addslashes($indicator_model);
			$indicator_serial = addslashes($indicator_serial);
			$scale_manu = addslashes($scale_manu);
			$scale_model = addslashes($scale_model);
			$scale_serial = addslashes($scale_serial);
			$scale_capacity = addslashes($scale_capacity);
			$scale_divisions = addslashes($scale_divisions);
			$units = addslashes($units);
			$date = addslashes($date);
			$comments = addslashes($comments);
		}
				
		$db = new mysqli('localhost', 'root', '', 'brechbuhler');
				
		if (mysqli_connect_error()) {
			$errnum = mysqli_connect_errno();
			echo "Error($errnum): Could not connect to database. Please try again later.";
			exit;
		}

		$query = "insert into service values\r\n" .
			"('NULL', " .
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
			"'" . $units . "', " .
			"'" . $comments . "'); ";
		
		$result = $db->query($query);
		$db->close();
		
		if ( $result ) {
			$_SESSION['digest'] = $digest;
			
			if($techname != "NULL") { $_SESSION['techname'] = $techname; } else { $_SESSION['techname'] = ""; }
			if($companyname != "NULL") { $_SESSION['companyname'] = $companyname; } else { $_SESSION['companyname'] = ""; }
			if($street != "NULL") { $_SESSION['street'] = $street; } else { $_SESSION['street'] = ""; }
			if($city != "NULL") { $_SESSION['city'] = $city; } else { $_SESSION['city'] = ""; }
			if($state != "NULL") { $_SESSION['state'] = $state; } else { $_SESSION['state'] = ""; }
			if($zipcode != "NULL") { $_SESSION['zipcode'] = $zipcode; } else { $_SESSION['zipcode'] = ""; }
			if($indicator_tag != "NULL") { $_SESSION['indicator_tag'] = $indicator_tag; } else { $_SESSION['indicator_tag'] = ""; }
			if($indicator_manu != "NULL") { $_SESSION['indicator_manu'] = $indicator_manu; } else { $_SESSION['indicator_manu'] = ""; }
			if($indicator_model != "NULL") { $_SESSION['indicator_model'] = $indicator_model; } else { $_SESSION['indicator_model'] = ""; }
			if($indicator_serial != "NULL") { $_SESSION['indicator_serial'] = $indicator_serial; } else { $_SESSION['indicator_serial'] = ""; }
			if($scale_manu != "NULL") { $_SESSION['scale_manu'] = $scale_manu; } else { $_SESSION['scale_manu'] = ""; }
			if($scale_model != "NULL") { $_SESSION['scale_model'] = $scale_model; } else { $_SESSION['scale_model'] = ""; }
			if($scale_serial != "NULL") { $_SESSION['scale_serial'] = $scale_serial; } else { $_SESSION['scale_serial'] = ""; }
			if($scale_capacity != "NULL") { $_SESSION['scale_capacity'] = $scale_capacity; } else { $_SESSION['scale_capacity'] = ""; }
			if($scale_divisions != "NULL") { $_SESSION['scale_divisions'] = $scale_divisions; } else { $_SESSION['scale_divisions'] = ""; }
			if($date != "NULL") { $_SESSION['date'] = $date; } else { $_SESSION['date'] = ""; }
			if($comments != "NULL") { $_SESSION['comments'] = $comments; } else { $_SESSION['comments'] = ""; }
			
			//$result->free();
			header("Location: index.php?result=cs1");
			
			die();
		} else {
			header("Location: index.php?result=err01");
			//echo $query;
		}
		
		
	} else {
		header("Location: index.php?result=err02");
		die();
	}
?>