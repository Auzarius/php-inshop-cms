<?php
	session_start();
	require_once ('config.php');
	require_once ('framework.php');
	require_once ( 'php/ismobile.class.php' );
	
	/*header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Pragma: no-cache"); // HTTP/1.0
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");*/
	
	@ $fw = new scaleDB( SQL_HOST, SQL_USER, SQL_PASS, SQL_DB );
	@ $ismobi = new IsMobile();

	if ( $fw->isLoggedIn( $_SESSION ) && $fw->isValidUser( $_SESSION ) ) {
		
		$techname = $_SESSION['USER']['fullname'];
		$username = $_SESSION['USER']['username'];
		
		$oldpass = $fw->clean_input($_POST['oldPass']);
		$newpass1 = $fw->clean_input($_POST['newPass1']);
		$newpass2 = $fw->clean_input($_POST['newPass2']);
		
		$date = $fw->getDate();
		
		#Check if the scale still exists in the database
		$query_user = "select * from users where username = '". $username ."'";
		$result_user = $fw->query( $query_user );
		
		if ( $query_user ) {
			
			while ( $row = $result_user->fetch_assoc() ) {
				$db_pass = $row['password'];
				$db_name = $row['fullname'];
				$db_user = $row['username'];
			}
			
			
			if (  $db_pass == sha1( $oldpass ) ) {
				if ( $db_name == $_SESSION['USER']['fullname'] && $db_user == $_SESSION['USER']['username'] ) {
					if ( $newpass1 == $newpass2 && $newpass1 != $oldpass ) {
						$final_pass = sha1( $newpass1 );
						$query_db = "update users set password = '". $final_pass ."' where username = '". $username ."'";
						$result_db = $fw->query( $query_db );
						
						if ( $result_db ) {
							$query = "select * from users where username = '". $username ."'";
							$result = $fw->query($query);
							
							if ( $result ) {
								while($row = $result->fetch_assoc()) {
										$db_id = $row['id'];
										$db_username = $row['username'];
										$db_pass = $row['password'];
										$db_fullname = $row['fullname'];
										$db_email = $row['email'];
										$db_user = $row['is_user'];
										$db_admin = $row['is_admin'];
										$db_superadmin = $row['is_superadmin'];	
									}
									
									$digest = md5( 
										$db_id .
										$db_username .
										$db_fullname .
										$db_pass .
										$db_email .
										$db_user .
										$db_admin .
										$db_superadmin
									);
									
									$_SESSION['USER'] = array(
									'userid'		=>		$db_id,
									'username'		=>		$db_username,
									'fullname'		=>		$db_fullname,
									'digest'		=>		$digest,
									'is_user'		=>		$db_user,
									'is_admin'		=>		$db_admin,
									'is_superadmin'	=>		$db_superadmin,
									);
									
									$_SESSION['password_status'] = "true";
									$_SESSION['password_id'] = md5( $final_pass );
							
									header("Location: changePassword.php");
									die();
							} else {
								$_SESSION['password_status'] = "false";
								$_SESSION['password_id'] = md5( sha1( $newpass1 ) );
								header("Location: changePassword.php");
								die();
							}
						} else {
							$_SESSION['password_status'] = "false";
							$_SESSION['password_id'] = md5( sha1( $newpass1 ) );
							
							header("Location: changePassword.php");
							die();
						}
					} else {
						$_SESSION['password_status'] = "false";
						$_SESSION['password_id'] = md5( sha1( $newpass1 ) );
						
						header("Location: logout.php");
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
		
		header("Location: login.php");
		die();
	}
?>