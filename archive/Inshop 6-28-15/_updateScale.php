<?php
	session_start();
	date_default_timezone_set('EST');
	
	if ( isset($_SESSION['val_username']) && $_SESSION['val_username'] != "" &&
		 isset($_SESSION['val_digest']) && $_SESSION['val_digest'] != "" ) {
		include ('framework.php');
		
		$fw = new framework;
		
		$techname = $_SESSION['val_fullname'];
		$scale_id = $fw->clean_input($_POST['scale_id']);
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
		
		$old = array(
			'companyname' 		=> 	$fw->clean_input($_POST['old_companyname']),
			'street' 			=> 	$fw->clean_input($_POST['old_street']),
			'city' 				=>	$fw->clean_input($_POST['old_city']),
			'state' 			=>	$fw->clean_input($_POST['old_state']),
			'zipcode' 			=>	$fw->clean_input($_POST['old_zipcode']),
			'indicator_tag' 	=>	$fw->clean_input($_POST['old_indicator_tag']),
			'indicator_manu' 	=>	$fw->clean_input($_POST['old_indicator_manu']),
			'indicator_model' 	=>	$fw->clean_input($_POST['old_indicator_model']),
			'indicator_serial' 	=>	$fw->clean_input($_POST['old_indicator_serial']),
			'scale_manu' 		=>	$fw->clean_input($_POST['old_scale_manu']),
			'scale_model' 		=>	$fw->clean_input($_POST['old_scale_model']),
			'scale_serial'		=>	$fw->clean_input($_POST['old_scale_serial']),
			'scale_capacity'	=>	$fw->clean_input($_POST['old_scale_capacity']),
			'scale_divisions' 	=>	$fw->clean_input($_POST['old_scale_divisions'])
		);
		
		$comments = "";
		
		if ( $old ) {
			if ( $companyname != $old['companyname'] ) { $comments .= "Changed customer name from ". $old['companyname'] ." to ". $companyname ." <br />\n"; }
			if ( $street != $old['street'] ) { $comments .= "Changed customer street from ". $old['street'] ." to ". $street ." <br />\n"; }
			if ( $city != $old['city'] ) { $comments .= "Changed customer city from ". $old['city'] ." to ". $city ." <br />\n"; }
			if ( $state != $old['state'] ) { $comments .= "Changed customer state from ". $old['state'] ." to ". $state ." <br />\n"; }
			if ( $zipcode != $old['zipcode'] ) { $comments .= "Changed customer zipcode from ". $old['zipcode'] ." to ". $zipcode ." <br />\n"; }
			if ( $indicator_tag != $old['indicator_tag'] ) { $comments .= "Changed indicator tag from ". $old['indicator_tag'] ." to ". $indicator_tag ." <br />\n"; }
			if ( $indicator_manu != $old['indicator_manu'] ) { $comments .= "Changed indicator manufacturer from ". $old['indicator_manu'] ." to ". $indicator_manu ." <br />\n"; }
			if ( $indicator_model != $old['indicator_model'] ) { $comments .= "Changed indicator model from ". $old['indicator_model'] ." to ". $indicator_model ." <br />\n"; }
			if ( $indicator_serial != $old['indicator_serial'] ) { $comments .= "Changed indicator serial from ". $old['indicator_serial'] ." to ". $indicator_serial ." <br />\n"; }
			if ( $scale_manu != $old['scale_manu'] ) { $comments .= "Changed scale manufacturer from ". $old['scale_manu'] ." to ". $scale_manu ." <br />\n"; }
			if ( $scale_model != $old['scale_model'] ) { $comments .= "Changed scale model from ". $old['scale_model'] ." to ". $scale_model ." <br />\n"; }
			if ( $scale_serial != $old['scale_serial'] ) { $comments .= "Changed scale serial from ". $old['scale_serial'] ." to ". $scale_serial ." <br />\n"; }
			if ( $scale_capacity != $old['scale_capacity'] ) { $comments .= "Changed scale capacity from ". $old['scale_capacity'] ." to ". $scale_capacity ." <br />\n"; }
			if ( $scale_divisions != $old['scale_divisions'] ) { $comments .= "Changed scale divisions from ". $old['scale_divisions'] ." to ". $scale_divisions ." <br />\n"; }
		}
		
		$digest = md5(	
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
						$_POST['scale_divisions']
					);
		
		$sessionDigest = isset($_SESSION['digest'])?$_SESSION['digest']:'';
		
		if ( $comments == "" ) {
			$_SESSION['digest'] = $digest;
			$_SESSION['update_status'] = "false";
			$_SESSION['update_id'] = $scale_id;
			
			header("Location: viewScale.php?id=$scale_id");
			die();
		}
		//echo "Digest: " . $digest . "<br />";
		//echo "Session: " . $sessionDigest . "<br />";
		
		if( $digest != $sessionDigest ) {
					
			@ $db = new mysqli('localhost', 'root', '', 'brechbuhler');
					
			if (mysqli_connect_error()) {
				$errnum = mysqli_connect_errno();
				echo "Error($errnum): Could not connect to database. Please try again later.";
				exit;
			}
			
			#Check if the scale still exists in the database
			$query_check = "select * from scales where id like '%". $scale_id ."%'";
			$result_check = $db->query( $query_check );
			
			if ( $query_check ) {
				
				#Update the scale database
				$query_update = "update scales set companyname='". $companyname ."', street='". $street ."', city='". $city ."', state='". $state ."', zipcode='". $zipcode ."', indicator_tag='". $indicator_tag ."', indicator_manu='". $indicator_manu ."', indicator_model='". $indicator_model ."', indicator_serial='". $indicator_serial ."', scale_manu='". $scale_manu ."', scale_model='". $scale_model ."', scale_serial='". $scale_serial ."', scale_capacity='". $scale_capacity ."', scale_divisions='". $scale_divisions ."', units='". $units ."' where id = '". $scale_id ."'";
				
				
				$result_update = $db->query($query_update);
				#END first query
				
				if ( $result_update ) {
					$_SESSION['digest'] = $digest;
					$_SESSION['update_status'] = "true";
					$_SESSION['update_id'] = $scale_id;
					
					$query_event = "insert into events values\r\n" .
						"('NULL', " .
						"'" . $date . "', " .
						"'" . $scale_id . "', " .
						"'" . $techname . "', " .
						"'Updated the scale information', " .
						"'". $comments ."'); ";
					$result_event = $db->query( $query_event );
					//$result->free();
					header("Location: viewScale.php?id=$scale_id");
					
					die();
				} else {
					#header("Location: index.php?result=22");
					echo $query_update;
					//echo $query;
					die();
				}
				
				
			} else {
				header("Location: index.php?result=23");
				die();
			}
		} else {
			header("Location: index.php?result=3");
			die();
		}
	 } else {
		header("Location: login.php");
		die();
	 }
	 exit();
?>