<?php
	session_start();
	include ('framework.php');
	
	$fw = new scaleDB('localhost', 'root', '', 'brechbuhler_test');
	
	if ( $fw ) {
		$type = $fw->clean_input($_POST['search_type']);
		$criteria = $fw->clean_input($_POST['search_criteria']);
		
		if ( $type == "default" ) {
			$_SESSION['search_go'] = 1;
			$_SESSION['search_query'] = "select * from scales where status != 'Complete' AND status != 'Non-repairable' AND status != 'Replaced the Scale'";
			$_SESSION['search_criteria'] = "Based on the default search criteria <br />";
			
			header("Location: showRepairs.php");
			die( "You must have page redirection turned off, please turn it on and try again." );
			
		} elseif ( $type == "all" ) {
			$_SESSION['search_go'] = 1;
			$_SESSION['search_query'] = "select * from scales";
			$_SESSION['search_criteria'] = "All scale tickets are being shown. <br />";
			
			header("Location: showRepairs.php");
			die( "You must have page redirection turned off, please turn it on and try again." );
			
		} else {
			
			if ( $type == "id" || $type == "scale_capacity" ) {
				$query = "select * from scales where $type = '". $criteria ."'";
			} else {
				$query = "select * from scales where $type like '%". $criteria ."%'";
			}
			
			$result = $fw->query($query);
			
			$_SESSION['search_criteria'] = "
				<table class=\"table-striped\" style=\"max-width: 250px;\">
					<thead style=\"background-color: black; color: white;\">
						<tr>
							<td colspan=\"2\">Based on this search criteria</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Type</td>
							<td>$type</td>
						</tr>
						<tr>
							<td>Criteria</td>
							<td>$criteria</td>
						</tr>
					</tbody>
				</table>";
				
			if ( $result ) {
				$_SESSION['search_go'] = 1;
				$_SESSION['search_query'] = $query;
				
				//$result->free();
				header("Location: showRepairs.php");
				
				die( "You must have page redirection turned off, please turn it on and try again." );
			} else {
				$_SESSION['search_go'] = 0;
				$_SESSION['search_query'] = "Something went wrong with your search, please try again.";
				header("Location: showRepairs.php");
				//echo $query;
				die( "You must have page redirection turned off, please turn it on and try again." );
			}
		}
		
		die();
	} else {
		header( 'Location: showRepairs.php' );
		die( "You must have page redirection turned off, please turn it on and try again." );
	}
		
?>