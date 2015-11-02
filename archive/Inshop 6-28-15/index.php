<?php
	session_start();
	
	if ( isset($_SESSION['val_username']) && $_SESSION['val_username'] != "" &&
		 isset($_SESSION['val_digest']) && $_SESSION['val_digest'] != "" ) {
			?>

<?php include ('header.php'); ?>
		<section>
<?php
	$result = "
			<p>Welcome to the in-shop repair database!<br /><br />
			<ul style=\"list-style: none; line-height: 25px; \">
				<li>
					<a href=\"changePassword.php\">Change Password</a><br />
				</li>
				<li>
					<a href=\"logout.php\">Logout</a></p>
				</li>
			</ul>
			";
	if (isset($_GET['result'])) $linkchoice=$_GET['result']; 
	else $linkchoice = '';
	
	if ($linkchoice && $linkchoice != "") {
		
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
				$result = "
			<p>Welcome to the in-shop repair database!<br /><br />
			<ul style=\"list-style: none;\">
				<li>
					<a href=\"changePassword.php\">Change Password</a><br />
				</li>
				<li>
					<a href=\"logout.php\">Logout</a></p>
				</li>
			</ul>
			";
				break;
		}
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
	
	/*echo $_SESSION['val_username'] . "<br>\n";
	echo $_SESSION['val_digest'] . "<br>\n";
	echo $_SESSION['val_fullname'] . "<br>\n";
	echo $_SESSION['is_user'] . "<br>\n";
	echo $_SESSION['is_admin'] . "<br>\n";
	echo $_SESSION['is_superadmin'] . "<br>\n";
	*/
?>