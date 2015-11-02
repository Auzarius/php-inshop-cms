<?php
	session_start();
	date_default_timezone_set('EST');
	
	if ( isset($_SESSION['val_username']) && $_SESSION['val_username'] != "" &&
		 isset($_SESSION['val_digest']) && $_SESSION['val_digest'] != "" ) {
		include ('framework.php');
		
		$fw = new framework;
		
		$techname = $_SESSION['val_fullname'];
		$username = $_SESSION['val_username'];
		
		$oldpass = $fw->clean_input($_POST['oldPass']);
		$newpass1 = $fw->clean_input($_POST['newPass1']);
		$newpass2 = $fw->clean_input($_POST['newPass2']);
		
		$date = date('m/d/Y') . " @ " . date('h:i:s A');
					
		@ $db = new mysqli('localhost', 'root', '', 'brechbuhler');
				
		if (mysqli_connect_error()) {
			$errnum = mysqli_connect_errno();
			echo "Error($errnum): Could not connect to database. Please try again later.";
			exit;
		}
		
		#Check if the scale still exists in the database
		$query_user = "select * from users where username = '". $username ."'";
		$result_user = $db->query( $query_user );
		
		if ( $query_user ) {
			
			while ( $row = $result_user->fetch_assoc() ) {
				$db_pass = $row['password'];
				$db_name = $row['fullname'];
				$db_user = $row['username'];
			}
			
			
			if (  $db_pass == sha1( $oldpass ) ) {
				if ( $db_name == $_SESSION['val_fullname'] && $db_user == $_SESSION['val_username'] ) {
					if ( $newpass1 == $newpass2 && $newpass1 != $oldpass ) {
						$final_pass = sha1( $newpass1 );
						$query_db = "update users set password = '". $final_pass ."' where username = '". $username ."'";
						$result_db = $db->query( $query_db );
						
						if ( $result_db ) {
							$_SESSION['password_status'] = "true";
							$_SESSION['password_id'] = md5( $final_pass );
							
							header("Location: changePassword.php");
							die();
						}
					}
				}
			} else {
				$_SESSION['password_status'] = "false";
				$_SESSION['password_id'] = md5( sha1( $newpass1 ) );
				
				header("Location: changePassword.php");
				die();
			}
		} else {
			die( "An error occurred, please contact an admin." );
		}
	} else {
		
		header("Location: login.php");
		die();
	}
 
 exit();
?>