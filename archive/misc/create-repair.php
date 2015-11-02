<?php
	session_start();
	date_default_timezone_set('EST');
	
	$techname = trim($_POST['techname']);
	$companyname = trim($_POST['companyname']);
	$street = trim($_POST['street']);
	$city = trim($_POST['city']);
	$state = trim($_POST['state']);
	$zipcode = trim($_POST['zipcode']);
	$tag = trim($_POST['tag']);
	$manufacturer = trim($_POST['manufacturer']);
	$model = trim($_POST['model']);
	$serial = trim($_POST['serial']);
	$capacity = trim($_POST['capacity']);
	$divisions = trim($_POST['divisions']);
	$units = trim($_POST['divisions']);
	$date = date('m') . "/" . date('d') . "/" . date('Y');
	$comments = trim($_POST['comments']);
	
	$digest = md5(	$_POST['techname'] .
					$_POST['companyname'] .
					$_POST['street'] .
					$_POST['city'] .
					$_POST['state'] .
					$_POST['manufacturer'] .
					$_POST['model'] .
					$_POST['serial']
					$_POST['capacity'] .
					$_POST['divisions'] .
					date('m') . "/" . date('d') . "/" . date('Y')
				);
	
	$sessionDigest = isset($_SESSION['digest'])?$_SESSION['digest']:'';
	
	//echo "Digest: " . $digest . "<br />";
	//echo "Session: " . $sessionDigest . "<br />";
	
	if( $digest != $sessionDigest ) {
		$_SESSION['digest'] = $digest;
		
		if ( !$techname || $techname == "" ) { $techname = "NULL"; }
		if ( !$companyname || $companyname == "" ) { $companyname = "NULL"; }
		if ( !$street || $street == "" ) { $street = "NULL"; }
		if ( !$city || $city == "" ) { $city = "NULL"; }
		if ( !$state || $state == "" ) { $state = "NULL"; }
		if ( !$zipcode || $zipcode == "" ) { $zipcode = "NULL"; }
		if ( !$tag || $tag == "" ) { $tag = "NULL"; }
		if ( !$manufacturer || $manufacturer == "" ) { $manufacturer = "NULL"; }
		if ( !$model || $model == "" ) { $model = "NULL"; }
		if ( !$serial || $serial == "" ) { $serial = "NULL"; }
		if ( !$capacity || $capacity == "" ) { $capacity = "NULL"; }
		if ( !$divisions || $divisions == "" ) { $divisions = "NULL"; }
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
			$tag = addslashes($tag);
			$manufacturer = addslashes($manufacturer);
			$model = addslashes($model);
			$serial = addslashes($serial);
			$capacity = addslashes($capacity);
			$divisions = addslashes($divisions);
			$units = addslashes($divisions);
			$date = addslashes($date);
			$comments = addslashes($comments);
		}
				
		$db = new mysqli('localhost', 'root', '', 'brechbuhler');
				
		if (mysqli_connect_error()) {
			$errnum = mysqli_connect_errno();
			echo "Error($errnum): Could not connect to database. Please try again later.";
			exit;
		}

		$query = "insert into repairs values\r\n" .
			"('NULL', " .
			"'" . $techname . "', " .
			"'" . $companyname . "', " .
			"'" . $street . "', " .
			"'" . $city . "', " .
			"'" . $state . "', " .
			"'" . $zipcode . "', " .
			"'" . $tag . "', " .
			"'" . $manufacturer . "', " .
			"'" . $model . "', " .
			"'" . $serial . "', " .
			"'" . $capacity . "', " .
			"'" . $divisions . "', " .
			"'" . $date . "', " .
			"'" . $comments . "'); ";
		
		$result = $db->query($query);
		$db->close();
		
		if ( $result ) {
			if($techname != "NULL") { $_SESSION['techname'] = $techname; } else { $_SESSION['techname'] = ""; }
			if($companyname != "NULL") { $_SESSION['companyname'] = $companyname; } else { $_SESSION['companyname'] = ""; }
			if($street != "NULL") { $_SESSION['street'] = $street; } else { $_SESSION['street'] = ""; }
			if($city != "NULL") { $_SESSION['city'] = $city; } else { $_SESSION['city'] = ""; }
			if($state != "NULL") { $_SESSION['state'] = $state; } else { $_SESSION['state'] = ""; }
			if($zipcode != "NULL") { $_SESSION['zipcode'] = $zipcode; } else { $_SESSION['zipcode'] = ""; }
			if($tag != "NULL") { $_SESSION['tag'] = $tag; } else { $_SESSION['tag'] = ""; }
			if($manufacturer != "NULL") { $_SESSION['manufacturer'] = $manufacturer; } else { $_SESSION['manufacturer'] = ""; }
			if($model != "NULL") { $_SESSION['model'] = $model; } else { $_SESSION['model'] = ""; }
			if($serial != "NULL") { $_SESSION['serial'] = $serial; } else { $_SESSION['serial'] = ""; }
			if($capacity != "NULL") { $_SESSION['capacity'] = $capacity; } else { $_SESSION['capacity'] = ""; }
			if($divisions != "NULL") { $_SESSION['divisions'] = $divisions; } else { $_SESSION['divisions'] = ""; }
			if($date != "NULL") { $_SESSION['date'] = $date; } else { $_SESSION['date'] = ""; }
			if($comments != "NULL") { $_SESSION['comments'] = $comments; } else { $_SESSION['comments'] = ""; }

			header("Location: index.php?result=err01");
			//$result->free();
			die();
		} else {
			header("Location: index.php?result=nr0");
			//echo $query;
		}
		
		
	} else {
		header("Location: index.php?result=err02");
		die();
	}
?>