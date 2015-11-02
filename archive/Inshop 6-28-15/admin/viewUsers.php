<?php
	session_start();
	
	if ( isset($_SESSION['val_username']) && $_SESSION['val_username'] != "" &&
		 isset($_SESSION['val_digest']) && $_SESSION['val_digest'] != "" ) {
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
		<?php include ('http://auzarius.com/scales/inshop/headerB.php'); ?>
		<?php include ('http://auzarius.com/scales/inshop/framework.php') ?>
		
		<h2>Registered Users</h2>
		<?php
			
			@ $db = new mysqli('localhost', 'root', '', 'brechbuhler');
			
			if (mysqli_connect_error()) {
				$errnum = mysqli_connect_errno();
				echo "Error($errnum): Could not connect to database. Please try again later.";
				exit;
			}
			
			$query;
			
			if ( $_SESSION['is_admin'] || $_SESSION['is_superadmin'] ) {
				$query = "select * from users";
			} else 	{
				die();
			}

			$result = $db->query($query);
			
			if ( $result ) {
				$num_results = $result->num_rows;
				$fw = new framework;
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
			
			$db->close();
		?>
	</body>
</html>

<?php
	 } else {
		echo "You must be logged in to view this page.";
		header( "Location: http://auzarius.com/scales/inshop/login.php" );
	 }
?>