<?php 
	session_start();
	
	if ( isset($_SESSION['val_username']) && $_SESSION['val_username'] != "" &&
		 isset($_SESSION['val_digest']) && $_SESSION['val_digest'] != "" ) {
?>
<?php include ('header.php'); ?>
		<section>
			<form action="_changePassword.php" method="post">
				<table>
					<thead>
						<tr>
							<td colspan="2"><h2>User Password Change</h2></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								Old Password: 
							</td>
							<td>
								<input name="oldPass" type="password" size="15" maxlength="25" required />
							</td>
						</tr>
						<tr>
							<td>
								New Password: 
							</td>
							<td>
								<input name="newPass1" type="password" size="15" maxlength="25" required />
							</td>
						</tr>
						<tr>
							<td>
								New Password: 
							</td>
							<td>
								<input name="newPass2" type="password" size="15" maxlength="25" required />
							</td>
						</tr>
						</tr>
							<td>
								
							</td>
							<td> 
								<input type="submit" name="submit" style="width: 138px;" value="Change Password" required />
							</td>
						</tr>								
					</tbody>
				</table>
		</section>
		<?php
	$result = "";
	
	if ( isset( $_SESSION['password_status'] ) && isset( $_SESSION['password_id'] ) ) {
				
				if ( $_SESSION['password_status'] == "true" ) {
					echo "<p><strong>Your password was changed successfully!</strong></p>\n\n";
				}
				elseif ( $_SESSION['password_status'] == "false" ) {
					echo "<p><strong>There was a mismatch with your provided information, please try again.</strong></p>\n\n";
				} else {
					echo "<p><strong>Something happened.  You may want to try logging out and then logging back in.</strong></p>\n\n";
				}
				
				unset( $_SESSION['password_status'] );
				unset( $_SESSION['password_id'] );
			}
?>
	<section>
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
