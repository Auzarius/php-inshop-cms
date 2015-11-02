<?php
	session_start();
	
	if ( isset($_SESSION['val_username']) && $_SESSION['val_username'] != "" &&
		 isset($_SESSION['val_digest']) && $_SESSION['val_digest'] != "" ) {
			?>

<?php include ('header.php'); ?>
		
		<h2>Scale Check-in</h2>
		<form action="_addScale.php" method="post">
			<input name="status" type="text" size="25" maxlength="40" value="Pending" hidden />
			<table hidden>
				<tr>
					<th colspan="2">Technician</th>
				</tr>
				<tr>
					<td>Full Name:</td>
					<td><input name="techname" type="text" size="25" maxlength="40" value="<?php echo $_SESSION['val_fullname']; ?>" /></td>
				</tr>
			</table>
			
			<table>
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
					<td><input name="city" pattern="[A-Za-z0-9 ]{1,}" type="city" size="25" maxlength="15" placeholder="Bluffton"/></td>
				</tr>
				<tr>
					<td>State:</td>
					<td><input name="state" pattern="[A-Z]{2}" type="state" size="2" maxlength="2" placeholder="IN"/></td>
				</tr>
				<tr>
					<td>Zip Code:</td>
					<td><input name="zipcode" pattern="[0-9]{5,}" type="zip" size="8" maxlength="15" placeholder="46714"/></td>
				</tr>				
			</table>
			<br />
			
			<table>
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
					<td><input name="scale_capacity" pattern="[0-9]{1,10}" size="10" maxlength="10" placeholder="5000" title="Numbers only" /></td>
				</tr>
				<tr>
					<td>Divisions:</td>
					<td><input name="scale_divisions" pattern="(0.)?[0-9]{1,}"type="text" size="6" maxlength="10" placeholder="0.5" title="Example: 1 or 0.01" /></td>
				</tr>
				<tr>
					<td>Units:</td>
					<td>
						<input name="units" type="radio" value="lb" checked>lb</input>
						<input name="units" type="radio" value="kg">kg</input>
						<input name="units" type="radio" value="g">g</input>
					</td>
				</tr>
			</table>
			<br />
			
			<table>
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
			</table>
			<br />
			
			Scale Comments:<br />
			<textarea name="comments" type="text" cols="50" rows="12" maxlength="1000" placeholder="Enter repair comments here" required ></textarea>
			<br /><br />
			
			<input type="submit" name="submit" value="Submit"/>
		</form>
	</body>
</html>

<?php
	 } else {
		echo "You must be logged in to view this page.";
		header( "Location: login.php" );
	 }
?>
