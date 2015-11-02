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
			
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		
			$techname = $_SESSION['USER']['fullname'];
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
			$date = date('m/d/Y') . " @ " . date('h:i:s A');
			$comments = $fw->clean_input($_POST['comments']);
			$status = "Pending";
			
			if ( $state == "NULL" ) { 
				$state == "IN"; 
			} else {
				$state = strtoupper( $state );
			}
			
			$digest = md5(	$_SESSION['USER']['fullname'] .
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
			
			$sessionDigest = isset($_SESSION['digest']) ? $_SESSION['digest']: '';
			
			if( $digest != $sessionDigest ) {
				
				#First database query to insert the user submitted data into the scales table
				$query1 = "insert into scales values\r\n" .
					"('NULL', " .
					"'" . $status . "', " .
					"'" . $date . "', " .
					"'" . $date . "', " .
					"'" . $techname . "', " .
					"'" . $companyname . "', " .
					"'" . $street . "', " .
					"'" . $city . "', " .
					"'" . $state . "', " .
					"'" . $zipcode . "', " .
					"'" . $indicator_tag . "', " .
					"'" . $indicator_manu . "', " .
					"'" . $indicator_model . "', " .
					"'" . $indicator_serial . "', " .
					"'" . $scale_manu . "', " .
					"'" . $scale_model . "', " .
					"'" . $scale_serial . "', " .
					"'" . $scale_capacity . "', " .
					"'" . $scale_divisions . "', " .
					"'" . $units . "'); ";
					
				
				$result = $fw->query($query1);
				#END first query
				
				#Second Database query to get the new scale ID that was just set
				$query2 = "select id from scales where date like '" . $date . "'";
				$result2 = $fw->query($query2);
				
				$ID = 0;
				while($row = $result2->fetch_assoc()) {
					$ID = $row['id'];
				}
				#END second query

				#Third database query to set the comments into its own table
				$query3 = "insert into events values\r\n" .
				"('NULL', " .
				"'" . $date . "', " .
				"'" . $ID . "', " .
				"'" . $techname . "', " .
				"'Created the scale entry', " .
				"'" . NULL . "', ".
				"'" . $comments . "'); ";
				
				$result3 = $fw->query($query3);
				#END third query
				
				if ( $result ) {
					$_SESSION['digest'] = $digest;
					$_SESSION['scaleCheckin']['result'] = "Your new ticket was successfully added!<br>You can view the new ticket <a href=\"viewScale.php?id=$ID\">here</a>.";
					#$result = "Your new ticket was successfully added!";
					unset( $_POST );
				} else {
					$_SESSION['scaleCheckin']['error'] = "Something went wrong when submitting your ticket to the database.  Please try again.";
					#$result = "Something went wrong when submitting your ticket to the database.  Please try again.";
				}
		
			} else {
				$_SESSION['digest'] = $digest;
				$_SESSION['scaleCheckin']['error'] = "This information has already been submitted.  There is no need to re-submit this ticket information.";
				#$result = "This information has already been submitted.  There is no need to re-submit this ticket information.";
				unset( $_POST );
			}
		}
			?>

<?php include ('header.php');
		if ( isset( $_SESSION['scaleCheckin']['error'] ) ) { 
			echo "<div class=\"error\">". $_SESSION['scaleCheckin']['error'] ."</div>";
			unset( $_SESSION['scaleCheckin'] );
		} elseif ( isset( $_SESSION['scaleCheckin']['result'] ) ) { 
			echo "<div class=\"result\">". $_SESSION['scaleCheckin']['result'] ."</div>";
			unset( $_SESSION['scaleCheckin'] );
		}
		
		?>
		
		<h2>&nbsp;Scale Check-in</h2>
		<form action="scaleCheckin.php" method="post">
			<!--<input class="hidden" name="status" type="text" size="25" maxlength="40" value="Pending" hidden />
			<table hidden>
				<tr>
					<th colspan="2">Technician</th>
				</tr>
				<tr>
					<td>Full Name:</td>
					<td><input name="techname" type="text" size="25" maxlength="40" value="<?php #echo $_SESSION['val_fullname']; ?>" /></td>
				</tr>
			</table>
			This needs to be built in and using the session var -->
			
			<table class="table-style">
				<tr>
					<th colspan="2">Customer Information</th>
				</tr>
				<tr>
					<td>Company Name:</td>
					<td><input name="companyname" pattern="[A-Za-z0-9 ]{1,}" type="text" size="25" maxlength="40" placeholder="Pretzels" required /></td>
				</tr>
				<tr>
					<td>Street:</td>
					<td><input name="street" pattern="[A-Za-z0-9 ]{1,}" type="text" size="25" maxlength="25" placeholder="123 Harvest Rd"/></td>
				</tr>
				<tr>
					<td>City:</td>
					<td><input name="city" pattern="[A-Za-z0-9 ]{1,}" type="text" size="25" maxlength="15" placeholder="Bluffton"/></td>
				</tr>
				<tr>
					<td>State:</td>
					<td><input name="state" pattern="[A-Za-z]{2}" type="text" size="2" maxlength="2" placeholder="IN"/></td>
				</tr>
				<tr>
					<td>Zip Code:</td>
					<td><input name="zipcode" pattern="[0-9]{5,}" type="text" size="8" maxlength="15" placeholder="46714"/></td>
				</tr>				
			</table>
			<br />
			
			<table class="table-style">
				<tr>
					<th colspan="2">Indicator Information</th>
				</tr>
				<tr>
					<td>Tag Number:</td>
					<td><input name="indicator_tag" type="text" size="25" maxlength="15" placeholder="23" required /></td>
				</tr>
				<tr>
					<td>Manufacturer:</td>
					<td><input name="indicator_manu" type="text" size="25" maxlength="25" placeholder="GSE" required /></td>
				</tr>
				<tr>
					<td>Model:</td>
					<td><input name="indicator_model" type="text" size="25" maxlength="25" placeholder="465" required /></td>
				</tr>
				<tr>
					<td>Serial:</td>
					<td><input name="indicator_serial" type="text" size="25" maxlength="20" placeholder="016748" required /></td>
				</tr>
				<tr>
					<td>Capacity:</td>
					<td><input name="scale_capacity" pattern="[0-9]{1,10}" type="text" size="10" maxlength="10" placeholder="5000" title="Numbers only" /></td>
				</tr>
				<tr>
					<td>Divisions:</td>
					<td><input name="scale_divisions" pattern="(0.)?[0-9]{1,}" type="text" size="6" maxlength="10" placeholder="0.5" title="Example: 1 or 0.01" /></td>
				</tr>
				<?php if ( $ismobi->CheckMobile() ) { ?>
			</table>
				<fieldset data-role="controlgroup">
					<legend>&nbsp;&nbsp;Units:</legend>
					<input type="radio" name="units" id="radio-choice-v-2a" value="lb" checked="checked" />
					<label for="radio-choice-v-2a">Pounds</label>
					<input type="radio" name="units" id="radio-choice-v-2b" value="kg" />
					<label for="radio-choice-v-2b">Kilograms</label>
					<input type="radio" name="units" id="radio-choice-v-2c" value="g" />
					<label for="radio-choice-v-2c">Grams</label>
					<input type="radio" name="units" id="radio-choice-v-2d" value="oz" />
					<label for="radio-choice-v-2d">Ounces</label>
				</fieldset>
				<?php } else { ?>
				<tr>
					<td>Units:</td>
					<td>
						<input name="units" type="radio" value="lb" checked>lb</input>
						<input name="units" type="radio" value="kg">kg</input>
						<input name="units" type="radio" value="g">g</input>
						<input name="units" type="radio" value="oz">oz</input>
					</td>
				</tr>
			</table>
			<?php } ?>
			<br />
			
			<table class="table-style">
				<tr>
					<th colspan="2">Scale Information</th>
				</tr>
				<tr>
					<td>Manufacturer:</td>
					<td><input name="scale_manu" type="text" size="25" maxlength="25" placeholder="BTEK" /></td>
				</tr>
				<tr>
					<td>Model:</td>
					<td><input name="scale_model" type="text" size="25" maxlength="25" placeholder="BT-4848-CS-SB" /></td>
				</tr>
				<tr>
					<td>Serial:</td>
					<td><input name="scale_serial" type="text" size="25" maxlength="20" placeholder="serial" /></td>
				</tr>
				<tr>
					<td>Scale Comments: </td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2"><textarea class="fixed" name="comments" type="text" id="comments" maxlength="1000" placeholder="Enter repair comments here" required ></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="submit" value="Submit" /></td>
				</tr>
			</table>
			<br />
			
			<?php #if ( $ismobi->CheckMobile() ) { echo '<label for="comments">&nbsp;&nbsp;Scale Comments:</label>'; }
				  #else { echo 'Scale Comments: <br />'; } ?>	
		</form>
	</body>
</html>

<?php
	} else {
		echo "You must be logged in to view this page.";
		header( "Location: login.php" );
	}
?>
