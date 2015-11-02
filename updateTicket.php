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
	
	if ( $ismobi->CheckMobile() ) {
		header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header("Pragma: no-cache"); // HTTP/1.0
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	}
	
	if ( $fw->isLoggedIn( $_SESSION ) && $fw->isValidUser( $_SESSION ) ) {

		if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
		
			if ( isset( $_POST['submit'] ) ) {		
				
				if ( $_POST['submit'] == "Submit" ) {
				$id;
				
					if ( isset( $_GET['id'] ) ) { 
				
						$scale_id = $_GET['id']; 				
						$tech = $fw->clean_input( $_SESSION['USER']['fullname'] );
						#$status = $fw->clean_input( $_POST['status'] );
						$timespent = isset( $_POST['timespent'] )? $fw->clean_input( $_POST['timespent'] ): 0;
						$stage = $fw->clean_input( $_POST['stage'] );
						$date = $fw->getDate();
						$comments = $fw->clean_input( $_POST['comments'] );
						
						$digest = md5( $stage . $comments );
					
						$sessionDigest = isset( $_SESSION['digest'] ) ? $_SESSION['digest']: '';
					
						if( $digest != $sessionDigest ) {
							$query = "insert into events values\r\n" .
							"(NULL, ".
							"'" . $date . "', ".
							"'" . $scale_id . "', ".
							"'" . $tech . "', ".
							"'" . $stage . "', ".
							"'" . $timespent . "', ".
							"'" . $comments . "'); ";
						
							$result = $fw->query($query);
							
							if ( $stage != "Added Additional Notes" ) {
							
								$query_two = "update scales set status ='". $stage ."', updated = '". $date ."' where id='". $scale_id ."';";
								$result_two = $fw->query($query_two);
								
								if ( $result && $result_two ) {
									$_SESSION['viewScale']['result'] = "The ticket was successfully updated!";
									$_SESSION['digest'] = $digest;
									header( "Location: viewScale.php?id=$scale_id" );
								} elseif ( $result || $result_two ) {
									$_SESSION['viewScale']['error'] = "Only part of your data was submitted.  An error must have occured when communicating with the database.";
									header( "Location: viewScale.php?id=$scale_id" );
								} else {
									$_SESSION['viewScale']['error'] = "Something went wrong when submitting your ticket to the database.  Please try again.";
									header( "Location: viewScale.php?id=$scale_id" );
								}
							} elseif ( $stage == "Added Additional Notes" && $result ) {
								$_SESSION['viewScale']['result'] = "The ticket was successfully updated!";
								$_SESSION['digest'] = $digest;
								header( "Location: viewScale.php?id=$scale_id" );
							} else {
								$_SESSION['viewScale']['error'] = "Something went wrong when submitting your ticket to the database.  Please try again.";
								header( "Location: viewScale.php?id=$scale_id" );
							}
						
						} else {
							$_SESSION['viewScale']['error'] = "That information has already been submitted, no changes were made.";
							header( "Location: viewScale.php?id=$scale_id" );
						}
					
					} else { 
						$_SESSION['viewScale']['error'] = "No ticket id was associated with this action, please try again.";
						header( "Location: viewScale.php?id=$scale_id" );
					}
				
				} elseif ( $_POST['submit'] == "Save Changes" &&
				$fw->isAdmin( $_SESSION ) 
				) {
					$techname = $_SESSION['USER']['fullname'];
					$scale_id = $fw->clean_input($_POST['scale_id']);
					$companyname = $fw->clean_input($_POST['companyname']);
					$street = $fw->clean_input($_POST['street']);
					$city = $fw->clean_input($_POST['city']);
					$state = $fw->clean_input($_POST['state']);
					$zipcode = $fw->clean_input($_POST['zipcode']);
					$indicator_tag = $fw->clean_input($_POST['indicator_tag']);
					$indicator_manu = $fw->clean_input($_POST['indicator_manu']);
					$indicator_model = $fw->clean_input($_POST['indicator_model']);
					$indicator_serial = $fw->clean_input($_POST['indicator_serial']);
					$scale_manu = $fw->clean_input($_POST['scale_manu']);
					$scale_model = $fw->clean_input($_POST['scale_model']);
					$scale_serial = $fw->clean_input($_POST['scale_serial']);
					$scale_capacity = $fw->clean_input($_POST['scale_capacity']);
					$scale_divisions = $fw->clean_input($_POST['scale_divisions']);
					$units = $fw->clean_input($_POST['units']);
					$date = $fw->getDate();
					
					$old = $fw->getScalePure( $scale_id );
					$comments = "";
					
					if ( $old ) {
						if ( stripslashes( $companyname ) != $old['companyname'] ) { $comments .= "Changed customer name from ". $old['companyname'] ." to ". $companyname ." <br />\n"; }
						if ( stripslashes( $street ) != $old['street'] ) { $comments .= "Changed customer street from ". $old['street'] ." to ". $street ." <br />\n"; }
						if ( stripslashes( $city ) != $old['city'] ) { $comments .= "Changed customer city from ". $old['city'] ." to ". $city ." <br />\n"; }
						if ( stripslashes( $state ) != $old['state'] ) { $comments .= "Changed customer state from ". $old['state'] ." to ". $state ." <br />\n"; }
						if ( stripslashes( $zipcode ) != $old['zipcode'] ) { $comments .= "Changed customer zipcode from ". $old['zipcode'] ." to ". $zipcode ." <br />\n"; }
						if ( stripslashes( $indicator_tag ) != $old['indicator_tag'] ) { $comments .= "Changed indicator tag from ". $old['indicator_tag'] ." to ". $indicator_tag ." <br />\n"; }
						if ( stripslashes( $indicator_manu ) != $old['indicator_manu'] ) { $comments .= "Changed indicator manufacturer from ". $old['indicator_manu'] ." to ". $indicator_manu ." <br />\n"; }
						if ( stripslashes( $indicator_model ) != $old['indicator_model'] ) { $comments .= "Changed indicator model from ". $old['indicator_model'] ." to ". $indicator_model ." <br />\n"; }
						if ( stripslashes( $indicator_serial ) != $old['indicator_serial'] ) { $comments .= "Changed indicator serial from ". $old['indicator_serial'] ." to ". $indicator_serial ." <br />\n"; }
						if ( stripslashes( $scale_manu ) != $old['scale_manu'] ) { $comments .= "Changed scale manufacturer from ". $old['scale_manu'] ." to ". $scale_manu ." <br />\n"; }
						if ( stripslashes( $scale_model ) != $old['scale_model'] ) { $comments .= "Changed scale model from ". $old['scale_model'] ." to ". $scale_model ." <br />\n"; }
						if ( stripslashes( $scale_serial ) != $old['scale_serial'] ) { $comments .= "Changed scale serial from ". $old['scale_serial'] ." to ". $scale_serial ." <br />\n"; }
						if ( stripslashes( $scale_capacity ) != $old['scale_capacity'] ) { $comments .= "Changed scale capacity from ". $old['scale_capacity'] ." to ". $scale_capacity ." <br />\n"; }
						if ( stripslashes( $scale_divisions ) != $old['scale_divisions'] ) { $comments .= "Changed scale divisions from ". $old['scale_divisions'] ." to ". $scale_divisions ." <br />\n"; }
					}
					
					$digest = md5(	
									$_POST['companyname'] .
									$_POST['street'] .
									$_POST['city'] .
									$_POST['state'] .
									$_POST['indicator_manu'] .
									$_POST['indicator_model'] .
									$_POST['indicator_serial'] .
									$_POST['scale_manu'] .
									$_POST['scale_model'] .
									$_POST['scale_serial'] .
									$_POST['scale_capacity'] .
									$_POST['scale_divisions']
								);
					
					$sessionDigest = isset($_SESSION['digest'])?$_SESSION['digest']:'';
					
					if( $digest != $sessionDigest && $comments != "" ) {
						
						#Check if the scale still exists in the database
						$query_check = "select * from scales where id = '%". $scale_id ."%'";
						$result_check = $fw->query( $query_check );
						
						if ( $query_check ) {
							
							#Update the scale database
							$query_update = "update scales set companyname='". $companyname ."', street='". $street ."', city='". $city ."', state='". $state ."', zipcode='". $zipcode ."', indicator_tag='". $indicator_tag ."', indicator_manu='". $indicator_manu ."', indicator_model='". $indicator_model ."', indicator_serial='". $indicator_serial ."', scale_manu='". $scale_manu ."', scale_model='". $scale_model ."', scale_serial='". $scale_serial ."', scale_capacity='". $scale_capacity ."', scale_divisions='". $scale_divisions ."', units='". $units ."' where id = '". $scale_id ."'";
							
							
							$result_update = $fw->query($query_update);
							#END first query
							
							if ( $result_update ) {
								$_SESSION['digest'] = $digest;
								
								$query_event = "insert into events values\r\n" .
									"(NULL, " .
									"'" . $date . "', " .
									"'" . $scale_id . "', " .
									"'" . $techname . "', " .
									"'Updated the scale information', " .
									"'". NULL ."', ".
									"'". $comments ."'); ";
									
								$query_two = "update scales set updated = '". $date ."' where id='". $scale_id ."';";
								$result_two = $fw->query($query_two);
									
								$result_event = $fw->query( $query_event );
								
								if ( $result_event ) {
									$_SESSION['viewScale']['result'] = "The ticket information has been successfully updated!";
									header( "Location: viewScale.php?id=$scale_id" );
								} else {
									$_SESSION['viewScale']['result'] = "The ticket information has been successfully updated, but its event was not created!";
									header( "Location: viewScale.php?id=$scale_id" );
								}
							} else {
								$_SESSION['viewScale']['error'] = "Something went wrong when submitting your update to the database.  Please try again.";
								header( "Location: viewScale.php?id=$scale_id" );
							}
						} else {
							$_SESSION['viewScale']['error'] = "Either the ticket does not exist or an error has occurred, please notify an admin!";
							header( "Location: viewScale.php?id=$scale_id" );
						}
					} elseif ( $comments == "" ) {
						$_SESSION['digest'] = $digest;
						$_SESSION['viewScale']['error'] = "No information was changed, no changes have been made to the ticket information.";
						header( "Location: viewScale.php?id=$scale_id" );
					} else {
						$_SESSION['viewScale']['error'] = "This information has already been submitted.  There is no need to re-submit this ticket information.";
						header( "Location: viewScale.php?id=$scale_id" );
					}
				} elseif ( $_POST['submit'] == "Delete Scale" ) {
					if ( isset( $_GET['id'] ) ) { 
						$scale_id = $fw->clean_input($_GET['id']);
					} else {
						include_once( 'header.php' );
						die ( "<div class=\"error\">No scale was defined in the delete request.</div>");
					}
					
					$query_exists = "select * from scales where id = '". $scale_id ."'";
					$result_exists = $fw->query($query_exists);
					$exists = $result_exists->num_rows;
					
					if ( !$exists ) {
						include_once( 'header.php' );
						die ( "<div class=\"error\">The scale you are trying to delete does not exist.</div>");
					}
					
					#echo $scale_id . "<br />";
					$query_scales = "delete from scales where id = '". $scale_id ."'";
					#echo $query_scales . "<br />";
					$result_scales = $fw->query($query_scales);
					
					if ( !$result_scales ) {
						$_SESSION['viewScale']['error'] = "Something happened.  The scale could not be removed from the database at this time.  Please try again later.";
						header( "Location: viewScale.php?id=$scale_id" );
					}
					
					$query_events = "delete from events where scale_id = '". $scale_id ."'";
					$result_events = $fw->query($query_events);
					
					if ( !$result_events ) {
						$_SESSION['viewScale']['error'] = "Something happened.  The events could not be removed from the database at this time.  Please notify an admin.";
						header( "Location: viewScale.php?id=$scale_id" );
					}
		
					$_SESSION['viewScale']['result'] = "The scale was successfully removed from the database.";
					header( "Location: viewScale.php?id=$scale_id" );
				} else {
					header( "Location: viewScale.php?id=$scale_id" );
				}
			} else {
				header( "Location: viewScale.php?id=$scale_id" );
			}
		}
	} else {
		echo "You must be logged in to view this page.";
		header( "Location: login.php" );
	}
?>