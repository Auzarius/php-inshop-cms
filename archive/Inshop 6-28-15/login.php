<?php 
	session_start();
	
	if ( isset( $_SESSION['val_username'] ) ) {
		header("Location: index.php");
		die( "<p>You are logged in and do not need to login again!</p>" );
	} else {
?>
<?php include ('header.php'); ?>
		<section>
			<form action="_startSession.php"method="post">
				<table>
					<thead>
						<tr>
							<td colspan="2"><h2>User Login</h2></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								Username: 
							</td>
							<td>
								<input name="username" type="text" size="15" maxlength="25" required />
							</td>
						</tr>
						<tr>
							<td>
								Password: 
							</td>
							<td>
								<input name="password" type="password" size="15" maxlength="25" required />
							</td>
						</tr>
						</tr>
							<td>
								
							</td>
							<td> 
								<input type="submit" name="submit" style="width: 100px;" value="Login"/>
							</td>
						</tr>								
					</tbody>
				</table>
		</section>
		<?php
	$result = "";
	if (isset($_GET['result'])) $linkchoice=$_GET['result']; 
	else $linkchoice = '';
	
	if ($linkchoice && $linkchoice != "") {
		
		switch($linkchoice) {
			
			case '1' :
				$result = "<p><strong>Incorrect username and/or password</strong></p><br />\n";
				break;
			case '2' :
				$result = "<p><strong>Unable to log you in at this time, please try again later.</strong></p><br />\n";
				break;
			default :
				$result = "<p></p>";
				break;
		}
	}
?>
	<section>
		<?php echo $result; ?>
	</section>
	</body>
</html>
<?php
	}
?>
