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
			?>

<?php include ('header.php'); ?>
		<section>
<?php
	
	if (isset($_GET['result'])) $linkchoice=$_GET['result']; 
	else $linkchoice = '';
		
	switch($linkchoice) {
		
		case '1' :
			$result = "<p>Your new ticket was successfully added!</p><br />\n";
			break;
			
		case '2' :
			$result = "<p>Something went wrong when submitting your ticket to the database.  Please go back and try again.</p><br />";
			break;
			
		case '3' :
			$result = "<p>This information has already been submitted.  There is no need to re-submit this ticket information.</p><br />";
			break;
		case '4' :
			$result = "<p>Only part of your data was submitted.  An error must have occured when communicating with the database.</p><br />";
			break;
		case '5' :
			$result = "<p>The ticket was successfully updated!</p><br />";
			break;
		case '21' :
			$result = "<p>The scale has been successfully updated in the database!</p><br />";
			break;
		case '22' :
			$result = "<p>An error occured when trying to update the scale, please notify an admin!</p><br />";
			break;
		case '23' :
			$result = "<p>Either the scale does not exist or an error has occurred, please notify an admin!</p><br />";
			break;
		case '31' :
			$result = "<p>The scale has been successfully deleted from the database!</p><br />";
			break;
		case '32' :
			$result = "<p>An error occured when trying to delete the scale, please notify an admin!</p><br />";
			break;
		case '99' :
			$result = "<p>You must have superadmin privelages to perform that action!</p><br />";
			break;
		default :
			if ( $ismobi->CheckMobile() ) {
				$result = "			<p>Welcome to the in-shop repair database!<br /><br /></p>
			<a href=\"changePassword.php\" class=\"ui-btn ui-corner-all\">Change Password</a>
			<a href=\"logout.php\" class=\"ui-btn ui-corner-all\">Logout</a>
			";
			} else {
				$result = "
		<div class='comet-notice'>Feel free to provide feedback on the new inshop system as it is being developed.  You can check it out <a href='http://auzarius.com:1337'>here!</a></div>
		<p>Welcome to the in-shop repair database!<br /><br />
		<ul style=\"list-style: none; line-height: 1.5em;\">
			<li>
				<a class=\"button\" href=\"changePassword.php\">Change Password</a><br />
			</li>
			<li>
				<a class=\"button\" href=\"logout.php\">Logout</a>
			</li>
		</ul>
			";
			}
			break;
	}
?>
			<?php echo $result; ?>
		</section>
	</body>
</html>

<?php
	} else {
		echo "You must be logged in to view this page.";
		header( "Location: login.php" );
	}
?>