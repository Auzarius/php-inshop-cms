<html>
	<head>
		<title>In-Shop Repair</title>
		<link rel="stylesheet" type="text/css" href="framework.css" />
		<link rel="stylesheet" type="text/css" href="in-shop.css" />
		<!--<link rel="stylesheet" type="text/css" href="quantum.css" />-->
		<!--[if lt IE9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<a hreflang="en"></a>
	</head>
	
	<body>
		<?php include ('header.php'); ?>
		
		<h1>In Shop Repair - Search Results</h1>
		<?php
			// create short variable names
			$searchtype = $_POST['searchtype'];
			$searchterm = trim($_POST['searchterm']);
			
			if (!$searchtype || !$searchterm) {
				echo 'You have not entered search details. Please go back and try again.';
				exit;
			}
			
			if (!get_magic_quotes_gpc()){
				$searchtype = addslashes($searchtype);
				$searchterm = addslashes($searchterm);
			}
			
			@ $db = new mysqli('localhost', 'root', '', 'brechbuhler');
			
			if (mysqli_connect_error()) {
				$errnum = mysqli_connect_errno();
				echo "Error($errnum): Could not connect to database. Please try again later.";
				exit;
			}
			
			$query = "select * from service where ".$searchtype." like '%".$searchterm."%'";
			$result = $db->query($query);
			
			if ( $result ) {
				$num_results = $result->num_rows;
				echo "<p>Number of matches found: ".$num_results."</p>";
				
				for ($i = 0; $i < $num_results; $i++) {
					$row = $result->fetch_assoc();
					
					$output = "<table>\n".
					"	<tr>\n".
					"		<td>Tech Name: </td>\n".
					"		<td>\n".
					stripslashes($row['tech_id'])."\n".
					"		</td>\n".
					"	</tr>\n".
					"	<tr>\n".
					"		<td>Date: </td>\n".
					"		<td>\n".
					stripslashes($row['date'])."\n".
					"		</td>\n".
					"	</tr>\n".
					"	<tr>\n".
					"		<td>Compant Name: </td>".
					"		<td>".
					stripslashes($row['companyname'])."\n".
					"		</td>\n".
					"	</tr>\n".
					"	<tr>\n".
					"		<td>Street: </td>\n".
					"		<td>\n".
					stripslashes($row['street'])."\n".
					"		</td>\n".
					"	</tr>\n".
					"	<tr>\n".
					"		<td>City: </td>\n".
					"		<td>\n".
					stripslashes($row['city'])."\n".
					"		</td>\n".
					"	</tr>\n".
					"	<tr>\n".
					"		<td>State: </td>\n".
					"		<td>\n".
					stripslashes($row['state'])."\n".
					"		</td>\n".
					"	</tr>\n".
					"	<tr>\n".
					"		<td>Zip Code: </td>\n".
					"		<td>\n".
					stripslashes($row['zipcode'])."\n".
					"		</td>\n".
					"	</tr>\n".
					"	<tr>\n".
					"		<td>Tag: </td>".
					"		<td>".
					stripslashes($row['indicator_tag'])."\n".
					"		</td>\n".
					"	</tr>\n".
					"	<tr>\n".
					"		<td>Manufacturer: </td>\n".
					"		<td>\n".
					stripslashes($row['indicator_manu'])."\n".
					"		</td>\n".
					"	</tr>\n".
					"	<tr>\n".
					"		<td>Model: </td>\n".
					"		<td>\n".
					stripslashes($row['indicator_model'])."\n".
					"		</td>\n".
					"	</tr>\n".
					"	<tr>\n".
					"		<td>Serial: </td>\n".
					"		<td>\n".
					stripslashes($row['indicator_serial'])."\n".
					"		</td>\n".
					"	</tr>\n".
					"	<tr>\n".
					"		<td>Comments: </td>\n".
					"		<td>\n".
					stripslashes($row['comments'])."\n".
					"		</td>\n".
					"	</tr>".
					"</table>\n".
					"<hr>\n\n";
					
					echo $output;
				}
			
				$result->free();
			} else {
				echo "An error occured while trying to perform your search.  Please try again.";
			}
			
			$db->close();
		?>
	</body>
</html>