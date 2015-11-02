<?php
	session_start();
	include ('framework.php');
	@ $fw = new scaleDB('localhost', 'root', '', 'brechbuhler');
	
	if ( $fw->isLoggedIn( $_SESSION ) && $fw->isValidUser( $_SESSION ) && $fw->isAdmin( $_SESSION ) ) {
			?>

<?php include ('header.php'); ?>
		
		<h2>Scale Edit</h2>
		<?php
			$id = "";
			$username = $_SESSION['user_validation']['username'];
			
			if ( isset( $_GET['id'] ) ) { $id = $_GET['id']; } else { die("Could not get the scale ID from the form, please notify an admin"); }
			
			$scale_information = $fw->getScale( $id );
			
			if ( is_array( $scale_information ) ) {
					
					$output = '
			<form action="_updateScale.php" method="post">
				<table class="table-striped table-style">
					<tbody>
						<tr>
							<td>
								ID:
							</td>
							<td>
								<input name="scale_id" type="text" size="25" maxlength="40" value="' . $scale_information['scale_id'] . '" hidden/>'. $scale_information['scale_id'] .'
							</td>
						</tr>
						<tr>
							<td>
								Status:
							</td>
							<td>
								' . $scale_information['status'] . '
							</td>
						</tr>
						<tr>
							<td>
								Date: 
							</td>
							<td>
								' . $scale_information['date'] . '
							</td>
						</tr>
						<tr>
							<td>
								Technician:
							</td>
							<td>
								' . $scale_information['tech_id'] . '
							</td>
						</tr>
						<tr>
							<td>
								Customer Name:
							</td>
							<td>
								<input name="old_companyname" type="text" size="25" maxlength="40" placeholder="'. $scale_information['companyname'] .'" value="' . $scale_information['companyname'] . '" hidden />
								<input name="companyname" type="text" size="25" maxlength="40" placeholder="'. $scale_information['companyname'] .'" value="' . $scale_information['companyname'] . '" />
							</td>
						</tr>
						<tr>
							<td>
								Street:
							</td>
							<td>
								<input name="old_street" type="text" size="25" maxlength="25" placeholder="'. $scale_information['street'] .'" value="' . $scale_information['street'] . '" hidden />
								<input name="street" type="text" size="25" maxlength="25" placeholder="'. $scale_information['street'] .'" value="' . $scale_information['street'] . '" />
							</td>
						</tr>
						<tr>
							<td>
								City:
							</td>
							<td>
								<input name="old_city" type="text" size="25" maxlength="15" placeholder="'. $scale_information['city'] .'" value="' . $scale_information['city'] . '" hidden />
								<input name="city" type="text" size="25" maxlength="15" placeholder="'. $scale_information['city'] .'" value="' . $scale_information['city'] . '" />
							</td>
						</tr>
						<tr>
							<td>
								State:
							</td>
							<td>
								<input name="old_state" type="text" size="2" maxlength="2" placeholder="'. $scale_information['state'] .'" value="' . $scale_information['state'] . '" hidden />
								<input name="state" type="text" size="2" maxlength="2" placeholder="'. $scale_information['state'] .'" value="' . $scale_information['state'] . '" />
							</td>
						</tr>
						<tr>
							<td>
								Zipcode:
							</td>
							<td>
								<input name="old_zipcode" type="text" size="8" maxlength="15" placeholder="'. $scale_information['zipcode'] .'" value="' . $scale_information['zipcode'] . '" hidden />
								<input name="zipcode" type="text" size="8" maxlength="15" placeholder="'. $scale_information['zipcode'] .'" value="' . $scale_information['zipcode'] . '" />
							</td>
						</tr>
						<tr>
							<td>
								Tag:
							</td>
							<td>
								<input name="old_indicator_tag" type="text" size="25" maxlength="15" placeholder="'. $scale_information['indicator_tag'] .'" value="' . $scale_information['indicator_tag'] .'" hidden />
								<input name="indicator_tag" type="text" size="25" maxlength="15" placeholder="'. $scale_information['indicator_tag'] .'" value="' . $scale_information['indicator_tag'] .'" />
							</td>
						</tr>
						<tr>
							<td>
								Indicator Manufacturer:
							</td>
							<td>
								<input name="old_indicator_manu" type="text" size="25" maxlength="25" placeholder="'. $scale_information['indicator_manu'] .'" value="' . $scale_information['indicator_manu'] . '" hidden />
								<input name="indicator_manu" type="text" size="25" maxlength="25" placeholder="'. $scale_information['indicator_manu'] .'" value="' . $scale_information['indicator_manu'] . '" />
							</td>
						</tr>
						<tr>
							<td>
								Indicator Model:
							</td>
							<td>
								<input name="old_indicator_model" type="text" size="25" maxlength="25" placeholder="'. $scale_information['indicator_model'] .'" value="' . $scale_information['indicator_model'] . '" hidden />
								<input name="indicator_model" type="text" size="25" maxlength="25" placeholder="'. $scale_information['indicator_model'] .'" value="' . $scale_information['indicator_model'] . '" />
							</td>
						</tr>
						<tr>
							<td>
								Indicator Serial:
							</td>
							<td>
								<input name="old_indicator_serial" type="text" size="25" maxlength="20" placeholder="'. $scale_information['indicator_serial'] .'"  value="' . $scale_information['indicator_serial'] . '" hidden />
								<input name="indicator_serial" type="text" size="25" maxlength="20" placeholder="'. $scale_information['indicator_serial'] .'"  value="' . $scale_information['indicator_serial'] . '" />
							</td>
						</tr>
						<tr>
							<td>
								Scale Manufacturer:
							</td>
							<td>
								<input name="old_scale_manu" type="text" size="25" maxlength="25" placeholder="'. $scale_information['scale_manu'] .'"  value="' . $scale_information['scale_manu'] . '" hidden />
								<input name="scale_manu" type="text" size="25" maxlength="25" placeholder="'. $scale_information['scale_manu'] .'"  value="' . $scale_information['scale_manu'] . '" />
							</td>
						</tr>
						<tr>
							<td>
								Scale Model:
							</td>
							<td>
								<input name="old_scale_model" type="text" size="25" maxlength="25" placeholder="'. $scale_information['scale_model'] .'"  value="' . $scale_information['scale_model'] . '" hidden />
								<input name="scale_model" type="text" size="25" maxlength="25" placeholder="'. $scale_information['scale_model'] .'"  value="' . $scale_information['scale_model'] . '" />
							</td>
						</tr>
						<tr>
							<td>
								Scale Serial:
							</td>
							<td>
								<input name="old_scale_serial" type="text" size="25" maxlength="20" placeholder="'. $scale_information['scale_serial'] .'"  value=" ' . $scale_information['scale_serial'] . '" hidden />
								<input name="scale_serial" type="text" size="25" maxlength="20" placeholder="'. $scale_information['scale_serial'] .'"  value=" ' . $scale_information['scale_serial'] . '" />
							</td>
						</tr>
						<tr>
							<td>
								Scale Capacity
							</td>
							<td>
								<input name="old_scale_capacity" type="text" size="10" maxlength="10" placeholder="'. $scale_information['scale_capacity'] .'"  value="' . $scale_information['scale_capacity'] . '" hidden />
								<input name="scale_capacity" type="text" size="10" maxlength="10" placeholder="'. $scale_information['scale_capacity'] .'"  value="' . $scale_information['scale_capacity'] . '" />
							</td>
						</tr>
						<tr>
							<td>
								Scale Divisions:
							</td>
							<td>
								<input name="old_scale_divisions" type="text" size="6" maxlength="10" placeholder="'. $scale_information['scale_divisions'] .'"  value="' . $scale_information['scale_divisions'] . '" hidden />
								<input name="scale_divisions" type="text" size="6" maxlength="10" placeholder="'. $scale_information['scale_divisions'] .'"  value="' . $scale_information['scale_divisions'] . '" />
							</td>
						</tr>
						<tr>
							<td>
								Units:
							</td>
							<td>
								<input name="units" type="radio" value="lb" checked>lb</input>
								<input name="units" type="radio" value="kg">kg</input>
								<input name="units" type="radio" value="g">g</input>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="submit" name="edit" value="Save Changes" onClick=\'return confirm("Are you sure you want to make these changes?")\' />
							</td>
						</tr>
					</tbody>	
				</table>
			</form>
				';
				
					echo $output;
					
			} else {
				die( "The scale information was not returned as an array, please report this to an admin." );
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