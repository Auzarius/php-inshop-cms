<?php
	session_start();
	
	if ( isset($_SESSION['val_username']) && $_SESSION['val_username'] != "" &&
		 isset($_SESSION['val_digest']) && $_SESSION['val_digest'] != "" ) {
			?>

<?php include ('header.php'); ?>
		<?php include ('framework.php') ?>
		
		<h2>Scale Information</h2>
		<?php
			
			@ $db = new mysqli('localhost', 'root', '', 'brechbuhler');
			
			if (mysqli_connect_error()) {
				$errnum = mysqli_connect_errno();
				echo "Error($errnum): Could not connect to database. Please try again later.";
				exit;
			}
			
			$id = "";
			if ( isset( $_GET['id'] ) ) { $id = $_GET['id']; } else { exit(); }
			
			if ( isset( $_SESSION['update_status'] ) && isset( $_SESSION['update_id'] ) &&
				$_SESSION['update_id'] == $id ) {
				
				if ( $_SESSION['update_status'] == "true" ) {
					echo "<p><strong>The scale has been successfully updated!</strong></p>\n\n";
				}
				elseif ( $_SESSION['update_status'] == "false" ) {
					echo "<p><strong>No information was changed.  The scale was not updated.</strong></p>\n\n";
				} else {
					echo "<p><strong>Something happened.  You may want to try logging out and then logging back in.</strong></p>\n\n";
				}
				
				unset( $_SESSION['update_status'] );
				unset( $_SESSION['update_id'] );
			}
			
			$fw = new scaleDB;
			$scale_information = $fw->getScale( $id );
			
			if ( is_array( $scale_information ) ) {
				#array_key_exists( 'scale_id', $scale_information ) ) {
				
				if ( $_SESSION['is_admin'] ) {
					$output = '
				<ul class="inline-list clearfix no-print">';
					
					$output .= '
					<li>
						<form action="editScale.php?id='. $scale_information['scale_id'] .'" method="post">
							<input type="submit" name="submit" value="Edit Scale"/>			
						</form>
					</li>';
					
					if ( $_SESSION['is_superadmin'] ) {
						$output .= '
					<li>
						<form action="_deleteScale.php" method="post">
							<input name="scale_id" type="text" size="25" maxlength="40" value="'. $scale_information['scale_id'] .'" hidden />
							<input name="status" type="text" size="25" maxlength="40" value="'. $scale_information['status'] .'" hidden />
								
							<input type="submit" name="delete" value="Delete Scale" onClick=\'return confirm("Are you sure you want to delete this scale?")\' />
						</form>
					</li>';
					}
				
					$output .= '				
				</ul>';
				
				} else { $output = ""; }
				
				$output .= "
				<table class=\"table-striped table-style\">
					<tbody>
						<tr>
							<td>
								ID:
							</td>
							<td>
								" . $scale_information['scale_id'] . "
							</td>
						</tr>
						<tr>
							<td>
								Status:
							</td>
							<td>
								" . $scale_information['status'] . "
							</td>
						</tr>
						<tr>
							<td>
								Date: 
							</td>
							<td>
								" . $scale_information['date'] . "
							</td>
						</tr>
						<tr>
							<td>
								Technician:
							</td>
							<td>
								" . $scale_information['tech_id'] . "
							</td>
						</tr>
						<tr>
							<td>
								Customer Name:
							</td>
							<td>
								" . $scale_information['companyname'] . "
							</td>
						</tr>
						<tr>
							<td>
								Street:
							</td>
							<td>
								" . $scale_information['street'] . "
							</td>
						</tr>
						<tr>
							<td>
								City:
							</td>
							<td>
								" . $scale_information['city'] . "
							</td>
						</tr>
						<tr>
							<td>
								State:
							</td>
							<td>
								" . $scale_information['state'] . "
							</td>
						</tr>
						<tr>
							<td>
								Zipcode:
							</td>
							<td>
								" . $scale_information['zipcode'] . "
							</td>
						</tr>
						<tr>
							<td>
								Tag:
							</td>
							<td>
								" . $scale_information['indicator_tag'] . "
							</td>
						</tr>
						<tr>
							<td>
								Indicator Manufacturer:
							</td>
							<td>
								" . $scale_information['indicator_manu'] . "
							</td>
						</tr>
						<tr>
							<td>
								Indicator Model:
							</td>
							<td>
								" . $scale_information['indicator_model'] . "
							</td>
						</tr>
						<tr>
							<td>
								Indicator Serial:
							</td>
							<td>
								" . $scale_information['indicator_serial'] . "
							</td>
						</tr>
						<tr>
							<td>
								Scale Manufacturer:
							</td>
							<td>
								" . $scale_information['scale_manu'] . "
							</td>
						</tr>
						<tr>
							<td>
								Scale Model:
							</td>
							<td>
								" . $scale_information['scale_model'] . "
							</td>
						</tr>
						<tr>
							<td>
								Scale Serial:
							</td>
							<td>
								" . $scale_information['scale_serial'] . "
							</td>
						</tr>
						<tr>
							<td>
								Scale Capacity
							</td>
							<td>
								" . $scale_information['scale_capacity'] . "
							</td>
						</tr>
						<tr>
							<td>
								Scale Divisions:
							</td>
							<td>
								" . $scale_information['scale_divisions'] . "
							</td>
						</tr>
						<tr>
							<td>
								Units:
							</td>
							<td>
								" . $scale_information['units'] . "
							</td>
						</tr>
					</tbody>	
				</table>\n\n
				";
				
				echo $output;
				
				$query = "select * from events where scale_id like '%".$scale_information['scale_id']."%'";
				$result = $db->query($query);
			
				if ( $result ) {
					$output = "<h3 style=\"margin-left: 2px;\">History<h3>\n".
							  "				<div id=\"accordion\" class=\"no-print\">\n";
							  
					$outputB = "			<div id=\"accordion\" class=\"print-only\">\n";
							  
					while ( $row = $result->fetch_assoc() ) {
						$output .= "".
						"					<h3>". $row['date'] ." - ". $row['tech'] ." - ". $row['event'] ."</h3>\n".
						"					<div>\n".
						"						<p>". $row['comments'] ."</p>\n".
						"					</div>\n";
						
						$outputB .= "".
						"					<h3>". $row['date'] ." - ". $row['tech'] ." - ". $row['event'] ."</h3>\n".
						"					<div>\n".
						"						<p>". $row['comments'] ."</p>\n".
						"					</div>\n";
					}
					
					$output .= "				</div>\n\n";
					$outputB .= "				</div>\n\n";
					
					echo $output;
					echo $outputB;
				}
				
				if ( $_SESSION['is_admin'] ) {
include ('eventForm.php');
				} 
				elseif ( $scale_information['status'] && $scale_information['status'] != "Complete"  && 
						$scale_information['status'] != "Delivered" ) {
include ('eventForm.php');
				}
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