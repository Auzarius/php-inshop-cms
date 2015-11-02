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
		header("Location: index.php");
		die( "<p>You are logged in and do not need to login again!</p>" );
	} else {
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
		
			if ( isset( $_POST['submit'] ) ) {
				
				if ( $_POST['submit'] == "Login" ) {
					
					$username = isset( $_POST['username'] )? strtolower( $fw->clean_input( $_POST['username'] ) ): NULL;
					$password = $_POST['password'];
					
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
							
						if ( sha1( $password ) == @$db_pass && @$db_user == 1 ) {
							
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
							
							$date = $fw->getDate();
							$query2 = "update users set last_login = '". $date ."' where id = ". $_SESSION['USER']['userid'] ."";
							$result2 = $fw->query($query2);
							
							header("Location: index.php");
						} elseif ( sha1( $password ) == @$db_pass && @$db_user == 0 ) {
							$_SESSION['login']['error'] = "The username and password were correct but access has been revoked. Please contact an admin if you feel this is an error.";
						} else {
							$_SESSION['login']['error'] = "The username or password that you entered is not correct.";
						}
					} else {
						$_SESSION['login']['error'] = "The username or password that you entered is not correct or an error occured.<br />Please try logging in again.";
					}
				}
			}
		}
?>
<?php 
	include_once ('header.php'); 
	
	if ( isset( $_SESSION['login']['error'] ) ) { 
		echo "<div class=\"error\">". $_SESSION['login']['error'] ."</div><br/>";
		$_SESSION['login']['error'] = NULL;
		unset( $_SESSION['login'] );
	} elseif ( isset( $_SESSION['login']['result'] ) ) { 
		echo "<div class=\"result\">". $_SESSION['login']['result'] ."</div><br/>";
		unset( $_SESSION['login'] );
	}
?>
		<section>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>"method="post">
				<table <?php if ( $ismobi->CheckMobile() ) { echo ' class="table-style"'; } ?>>
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
	</body>
</html>
<?php
	}
?>
