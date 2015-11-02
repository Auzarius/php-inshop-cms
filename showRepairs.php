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

	include ('header.php'); ?>

		<form action="showRepairs.php" method="post">
			<table <?php if ( $ismobi->CheckMobile() ) { echo 'class="table-style"'; } ?>>
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
								<option value="all">-- all --</option>
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
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

			$type = $fw->clean_input($_POST['search_type']);
			$criteria = $fw->clean_input($_POST['search_criteria']);
			
			if ( $type == "default" ) {
				$query = "select * from scales where status != 'Complete' AND status != 'Non-repairable' AND status != 'Replaced the Scale' AND status != 'Delivered'";
				$criteria = "Based on the default search criteria <br />";		
			} elseif ( $type == "all" ) {
				$query = "select * from scales";
				$criteria = "All scale tickets are being shown. <br />";
			} else {
				if ( $type == "id" || $type == "scale_capacity" ) {
					$query = "select * from scales where $type = '". $criteria ."'";
				} else {
					$query = "select * from scales where $type like '%". $criteria ."%'";
				}
			}	
		} else {
			$type = "default";
			$query = "select * from scales where status != 'Complete' AND status != 'Non-repairable' AND status != 'Replaced the Scale' AND status != 'Delivered'";
			$criteria = "Based on the default search criteria <br />";
		}
		
			$result = $fw->query($query);
			
			$tableclasses = "";
			
			/*if ( $ismobi->CheckMobile() ) {
				$tableclasses = "class=\"table-style table-striped\"";
			} else {
				$tableclasses = "class=\"table-style table-striped\" style=\"position: absolute; top: 80; left: 300;\"";
			}
			
			$search = "
				<table $tableclasses>
					<tbody>
						<tr>
							<td colspan=\"2\" style=\"background-color: black; color: white;\">Based on this search criteria</td>
						</tr>
						<tr>
							<td>Type</td>
							<td>$type</td>
						</tr>
						<tr>
							<td>Criteria</td>
							<td>$criteria</td>
						</tr>
					</tbody>
				</table>";*/
			$search = "";
				
			if ( $result ) {
				$num_results = $result->num_rows;
				
				echo "
				<p>Number of matches found:&nbsp;&nbsp;&nbsp;<strong>".$num_results."</strong></p>
				$search";
				
				if ( $num_results > 0 ) {
					/*
					if ( $ismobi->CheckMobile() ) {
						$output = "\n\n		<table data-role=\"table\" id=\"movie-table\" data-mode=\"reflow\" class=\"results-list\">\n".
						"			<thead>\n".
						"				<tr>\n".
						"					<th data-priority=\"1\">ID</th>\n".
						"					<th data-priority=\"2\">Status</th>\n".
						"					<th data-priority=\"3\">Date</th>\n".
						"					<th data-priority=\"persist\">Customer Name</th>\n".
						"					<th data-priority=\"4\">Tag</th>\n".
						"					<th data-priority=\"4\"><abbr title=\"Indicator Manufacturer\">Manufacturer</abbr></th>\n".
						"					<th data-priority=\"4\"><abbr title=\"Indicator Model\">Model</abbr></th>\n".
						"					<th data-priority=\"4\"><abbr title=\"Indicator Serial\">Serial</abbr></th>\n".
						"					<th data-priority=\"4\">Capacity</th>\n".
						"					<th data-priority=\"4\">Divisions</th>\n".
						"				</tr>\n".
						"			</thead>\n".
						"			<tbody>\n";
						
						for ($i = 0; $i < $num_results; $i++) {
							$row = $result->fetch_assoc();
							
							$output .= "".
							"				<tr>\n".
							"					<th>". $row['id'] ."</th>\n".
							"					<td class=\"title\"><a href=\"viewScale.php?id=". $row['id'] ." data-rel=\"internal\">". $fw->clean_output( $row['companyname'] ) ."</a></td>\n".
							"					<td>". $fw->clean_output( $row['status'] ) ."</td>\n".
							"					<td>". substr( $row['date'], 0, 10 ) ."</td>\n".
							"					<td>". $fw->clean_output( $row['indicator_tag'] ) ."</td>\n". 
							"					<td>". $fw->clean_output( $row['indicator_manu'] ) ."</td>\n".
							"					<td>". $fw->clean_output( $row['indicator_model'] ) ."</td>\n".
							"					<td>". $fw->clean_output( $row['indicator_serial'] ) ."</td>\n".
							"					<td>". $fw->clean_output( $row['scale_capacity'] ) ."</td>\n".
							"					<td>". $fw->clean_output( $row['scale_divisions'] ) ."</td>\n".
							"				</tr>\n";
						}

						$output .= "".
						"			</tbody>\n".
						"		</table>\n";
						
					} */
					if ( $ismobi->CheckMobile() ) {
						$output = "\n\n		<table class=\"mobile-table\">\n".
						"			<tbody>\n";
						
						for ($i = 0; $i < $num_results; $i++) {
							$row = $result->fetch_assoc();
							
							$output .= "".
							"				<tr>\n".
							"					<td colspan=\"2\" class=\"title\"><a href=\"viewScale.php?id=". $row['id'] ."\">". $fw->clean_output( $row['companyname'] ) ."</a></td>\n".
							"				</tr>\n".
							"				<tr>\n".
							"					<th>ID</th>\n".
							"					<td>". $row['id'] ."</td>\n".
							"				</tr>\n".
							"				<tr>\n".
							"					<th>Status</th>\n".
							"					<td>". $fw->clean_output( $row['status'] ) ."</td>\n".
							"				</tr>\n".
							"				<tr>\n".
							"					<th>Created</th>\n".
							"					<td>". substr( $row['date'], 0, 10 ) ."</td>\n".
							"				</tr>\n".
							"				<tr>\n".
							"					<th>Updated</th>\n".
							"					<td>". substr( $row['updated'], 0, 10 ) ."</td>\n".
							"				</tr>\n".
							"				<tr>\n".
							"					<th>Tag</th>\n".
							"					<td>". $fw->clean_output( $row['indicator_tag'] ) ."</td>\n".
							"				</tr>\n".
							"				<tr>\n".
							"					<th>Manufacturer</th>\n".
							"					<td>". $fw->clean_output( $row['indicator_manu'] ) ."</td>\n".
							"				</tr>\n".
							"				<tr>\n".
							"					<th>Model</th>\n".
							"					<td>". $fw->clean_output( $row['indicator_model'] ) ."</td>\n".
							"				</tr>\n".
							"				<tr>\n".
							"					<th>Serial</th>\n".
							"					<td>". $fw->clean_output( $row['indicator_serial'] ) ."</td>\n".
							"				</tr>\n".
							"				<tr>\n".
							"					<th>Capacity</th>\n".
							"					<td>". $fw->clean_output( $row['scale_capacity'] ) ."</td>\n".
							"				</tr>\n".
							"				<tr>\n".
							"					<th>Divisions</th>\n".
							"					<td>". $fw->clean_output( $row['scale_divisions'] ) ."</td>\n".
							"				</tr>\n";
						}
						
						$output .= "".
						"			</tbody>\n".
						"		</table>\n";
							
					} else {
						$output = "\n\n		<table id=\"sort\" class=\"table-striped table-hover search-results\">\n".
						"			<thead>\n".
						"				<tr>\n".
						"					<th>~</th>\n".	
						"					<th>ID</th>\n".	
						"					<th>Status</th>\n".	
						"					<th>Created</th>\n".
						"					<th>Updated</th>\n".
						"					<th>Customer Name</th>\n".
						"					<th>Tag</th>\n".
						"					<th>Manufacturer</th>\n".
						"					<th>Model</th>\n".
						"					<th>Serial</th>\n".
						"					<th>Capacity</th>\n".
						"					<th>Divisions</th>\n".
						"				</tr>\n".
						"			</thead>\n".
						"			<tbody>\n";				
						
						for ($i = 0; $i < $num_results; $i++) {
							$row = $result->fetch_assoc();
							
							$output .= "				<tr onclick=\"document.location = 'viewScale.php?id=". $row['id'] ."';\" class=\"hover-hand\">\n".
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
							$fw->clean_output( substr( $row['updated'], 0, 10 ) ).
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
					}	
						
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