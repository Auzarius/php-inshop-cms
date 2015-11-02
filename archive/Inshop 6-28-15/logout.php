<?php
	session_start();
	if ( isset( $_SESSION['val_username'] ) ) {
		unset( $_SESSION['val_username'] );
		unset( $_SESSION['val_digest'] );
		session_destroy();
		
	}
	
	header( "Location: login.php" );
?>