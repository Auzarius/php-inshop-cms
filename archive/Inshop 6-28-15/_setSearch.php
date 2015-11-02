<?php
	session_start();
	include ('framework.php');
	
	$fw = new framework;
	
	$type = $fw->clean_input($_POST['search_type']);
	$criteria = $fw->clean_input($_POST['search_criteria']);
	
	if ( $type == "default" ) {
		$_SESSION['search_go'] = 1;
		$_SESSION['search_query'] = "select * from scales where status != 'Complete' AND status != 'Non-repairable' AND status != 'Replaced the Scale' AND status != 'Delivered'";
		$_SESSION['search_criteria'] = "Based on the default search criteria <br />";
		header("Location: showRepairs.php");
		
		die();
	} else {
		
		$db = new mysqli('localhost', 'root', '', 'brechbuhler');
				
		if (mysqli_connect_error()) {
			$errnum = mysqli_connect_errno();
			echo "Error($errnum): Could not connect to database. Please try again later.";
			exit;
		}
		
		if ( $type == "id" || $type == "scale_capacity" ) {
			$query = "select * from scales where $type = '". $criteria ."'";
		} else {
			$query = "select * from scales where $type like '%". $criteria ."%'";
		}
		
		$result = $db->query($query);
		
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
			
			die();
		} else {
			$_SESSION['search_go'] = 0;
			$_SESSION['search_query'] = "Something went wrong with your search, please try again.";
			header("Location: showRepairs.php");
			//echo $query;
			die();
		}
	}
	
	die();
?>