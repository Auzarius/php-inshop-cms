<?php
	session_start();
	
	if ( isset($_SESSION['val_username']) && $_SESSION['val_username'] != "" &&
		 isset($_SESSION['val_digest']) && $_SESSION['val_digest'] != "" ) {
			?>

<html lang="en">
	<head>
		<title>In-Shop Repair</title>
		<link rel="stylesheet" type="text/css" href="framework.css" />
		<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="in-shop.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="http://auzarius.com/scales/inshop/js/tablesorter/jquery-latest.js"></script>
		<script src="http://auzarius.com/scales/inshop/js/tablesorter/jquery.tablesorter.min.js"></script>
		<script src="http://auzarius.com/scales/inshop/js/sort.js"></script>
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
		<?php include ('headerB.php'); ?>
		<?php include ('framework.php') ?>
		
		<form action="_setSearch.php" method="post">
			<table>
				<thead>
					<tr>
						<td>
							<h3 style="margin-bottom: 0;">Perform a search</h3>
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<select name="search_type" id="search" maxlength="25" required>
								<option value="default">-- default --</option>
								<option value="id">ID</option>
								<option value="status">Status</option>
								<option value="date">Date</option>
								<option value="tech_id">Technician</option>
								<option value="companyname">Customer Name</option>
								<option value="street">Customer Street</option>
								<option value="city">Customer City</option>
								<option value="state">Customer State</option>
								<option value="zipcode">Customer Zipcode</option>
								<option value="indicator_tag">Indicator Tag</option>
								<option value="indicator_manu">Indicator Manufacturer</option>
								<option value="indicator_model">Indicator Model</option>
								<option value="indicator_serial">Indicator Serial</option>
								<option value="scale_manu">Scale Manufacturer</option>
								<option value="scale_model">Scale Model</option>
								<option value="scale_serial">Scale Serial</option>
								<option value="scale_capacity">Scale Capacity</option>
								<option value="scale_divisions">Scale Divisions</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="search_criteria" maxlength="25" size="18" placeholder="search..." />
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" name="submit" value="Search" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<?php
			
			@ $db = new mysqli('localhost', 'root', '', 'brechbuhler');
			
			if (mysqli_connect_error()) {
				$errnum = mysqli_connect_errno();
				echo "Error($errnum): Could not connect to database. Please try again later.";
				exit;
			}
			
			if ( isset( $_SESSION['search_query'] ) && isset( $_SESSION['search_go'] ) ) {
				$query = $_SESSION['search_query'];
				$search = $_SESSION['search_criteria'];
				unset( $_SESSION['search_query'] );
				unset( $_SESSION['search_criteria'] );
				unset( $_SESSION['search_go'] );
			}
			elseif ( isset( $_SESSION['search_query'] ) && !$_SESSION['search_go'] ) {
				$search = "
				<p>". $_SESSION['search_query'] ."</p><br />";
				unset( $_SESSION['search_query'] );
				unset( $_SESSION['search_criteria'] );
				unset( $_SESSION['search_go'] );
				exit();
			} else {
				$search = "Based on the default search criteria <br />";
				$query = "select * from scales where status != 'Complete' AND status != 'Delivered' AND status != 'Non-repairable' AND status != 'Replaced the Scale'";
			}

			$result = $db->query($query);
			
			if ( $result ) {
				$num_results = $result->num_rows;
				$fw = new framework;
				echo "
				<p>Number of matches found: ".$num_results."</p>
				$search";
				
				if ( $num_results > 0 ) {
					$output = "\n\n		<table id=\"sort\" class=\"table-striped table-style table-hover search-results\">\n".
					"			<thead>\n".
					"				<tr>\n".
					"					<th>~</th>\n".	
					"					<th>ID</th>\n".	
					"					<th>Status</th>\n".	
					"					<th>Date</th>\n".
					"					<th>Customer Name</th>\n".
					"					<th>Tag</th>\n".
					"					<th>Indicator Manufact</th>\n".
					"					<th>Indicator Model</th>\n".
					"					<th>Indicator Serial</th>\n".
					"					<th>Capacity</th>\n".
					"					<th>Divisions</th>\n".
					"				</tr>\n".
					"			</thead>\n".
					"			<tbody>\n";				
					
					for ($i = 0; $i < $num_results; $i++) {
						$row = $result->fetch_assoc();
						
						$output .= "				<tr>\n".
						"					<td>".
						"<a href=\"viewScale.php?id=" . $row['id'] . "\" class=\"button\">View</a>".
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['id'] ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['status'] ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( substr( $row['date'], 0, 10 ) ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['companyname'] ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['indicator_tag'] ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['indicator_manu'] ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['indicator_model'] ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['indicator_serial'] ).
						"</td>\n".						
						"					<td>".
						$fw->clean_output( $row['scale_capacity'] ).
						"</td>\n".
						"					<td>".
						$fw->clean_output( $row['scale_divisions'] ).
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
		header( "Location: login.php" );
	 }
?>