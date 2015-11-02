<?php	
	session_start();
	require_once ('config.php');
	require_once ('framework.php');
	require_once ( 'php/ismobile.class.php' );
	
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Pragma: no-cache"); // HTTP/1.0
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	
	@ $fw = new scaleDB( SQL_HOST, SQL_USER, SQL_PASS, SQL_DB );
	@ $ismobi = new IsMobile();

	if ( $fw->isLoggedIn( $_SESSION ) && $fw->isValidUser( $_SESSION ) ) {
			?>

<html lang="en">
	<head>
		<title>In-Shop Repair</title>
		<link rel="stylesheet" type="text/css" href="http://auzarius.com/scales/inshop/framework.css" />
		<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="http://auzarius.com/scales/inshop/in-shop.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script>
			$(function() {
				$( "#accordion" ).accordion({
				  collapsible: true
				});
			});
		</script>
		<!--<link rel="stylesheet" type="text/css" href="quantum.css" />-->
		<!--[if lt IE9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=0.62">
	</head>
	
	<body>
		<?php include ('header.php'); ?>
		
		<h2>Registered Users</h2>
		<?php
			
			if ( $fw->isAdmin( $_SESSION ) || $fw->isSuperAdmin( $_SESSION ) ) {
				$query = "select * from users";
			} else 	{
				die();
			}

			$result = $fw->query($query);
			
			if ( $result ) {
				$num_results = $result->num_rows;
				echo "<p>Number of matches found: ".$num_results."</p>";
				
				if ( $num_results > 0 ) {
					$output = "\n\n		<table class=\"table-striped table-style table-hover search-results\">\n".
					"			<thead>\n".
					"				<tr>\n".
					"					<th>ID</th>\n".	
					"					<th>Username</th>\n".	
					"					<th>Full Name</th>\n".
					"					<th>Email</th>\n".
					"					<th>is_user</th>\n".
					"					<th>is_admin</th>\n".
					"					<th>is_super</th>\n".
					"				</tr>\n".
					"			</thead>\n".
					"			<tbody>\n";				
					
					for ($i = 0; $i < $num_results; $i++) {
						$row = $result->fetch_assoc();
						
						$output .= "				<tr>\n".
						"					<td>".
						$fw->clean_output( $row['id'] ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['username'] ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['fullname'] ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['email'] ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['is_user'] ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['is_admin'] ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['is_superadmin'] ).
						"</td>\n".
						"				</tr>\n";				
						
					}
					
					$output .= "			</tbody>\n".
						"		</table>\n";
					echo $output;
				
					$result->free();
				}
			} else {
				echo "An error occured while trying to perform your search.  Please try again.";
			}
			
			$fw->close();
		?>
	</body>
</html>

<?php
	} else {
		echo "You must be logged in to view this page.";
		header( "Location: login.php" );
	}
?>