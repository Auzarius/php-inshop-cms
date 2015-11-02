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
	
	unset( $_SESSION['USER'] );
	session_destroy();
	header( "Location: login.php" );
	exit();
?>