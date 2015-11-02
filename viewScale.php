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

	include ('header.php'); 

	if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
		
		if ( isset( $_POST['submit'] ) ) {
			
			if ( $_POST['submit'] == "Edit Scale" &&
			 $fw->isAdmin( $_SESSION )
			) { ?>
				
				<h2>Scale Edit</h2>
			<?php
				$id = "";
				$username = $_SESSION['USER']['username'];
				
				if ( isset( $_GET['id'] ) ) { $id = $_GET['id']; } else { die( "Could not get the scale ID from the form, please notify an admin" ); }
				
				if ( !$scale_information = $fw->getScale( $id ) ) die();
				
				if ( is_array( $scale_information ) ) {
					
					if ( $ismobi->CheckMobile() ) {
						$output = "".
						"			<form action=\"updateTicket.php?id=". $id ."\" method=\"post\">\n".
						"				<table class=\"mobile-table\">\n".
						"					<tbody>\n".
						"						<tr>\n".
						"							<th>\n".
						"								ID:\n".
						"							</th>\n".
						"							<td>\n".
						"								". $scale_information['scale_id'] ."\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Status:\n".
						"							</th>\n".
						"							<td>\n".
						"								". $scale_information['status'] ."\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Created: \n".
						"							</th>\n".
						"							<td>\n".
						"								". $scale_information['date'] ."\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Updated: \n".
						"							</th>\n".
						"							<td>\n".
						"								". $scale_information['updated'] ."\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Created by:\n".
						"							</th>\n".
						"							<td>\n".
						"								" . $scale_information['tech_id'] . "\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Customer Name:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"companyname\" type=\"text\" size=\"25\" maxlength=\"25\" placeholder=\"". $scale_information['companyname'] ."\" value=\"" . $scale_information['companyname'] . "\" required/>\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Street:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"street\" type=\"text\" size=\"25\" maxlength=\"25\" placeholder=\"". $scale_information['street'] ."\" value=\"" . $scale_information['street'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								City:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"city\" type=\"text\" size=\"25\" maxlength=\"25\" placeholder=\"". $scale_information['city'] ."\" value=\"" . $scale_information['city'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								State:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"state\" type=\"text\" size=\"2\" maxlength=\"2\" placeholder=\"". $scale_information['state'] ."\" value=\"" . $scale_information['state'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Zipcode:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"zipcode\" type=\"text\" size=\"8\" maxlength=\"5\" placeholder=\"". $scale_information['zipcode'] ."\" value=\"" . $scale_information['zipcode'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Tag:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"indicator_tag\" type=\"text\" size=\"25\" maxlength=\"25\" placeholder=\"". $scale_information['indicator_tag'] ."\" value=\"" . $scale_information['indicator_tag'] ."\" required />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Indicator Manufacturer:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"indicator_manu\" type=\"text\" size=\"25\" maxlength=\"25\" placeholder=\"". $scale_information['indicator_manu'] ."\" value=\"" . $scale_information['indicator_manu'] . "\" required />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Indicator Model:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"indicator_model\" type=\"text\" size=\"25\" maxlength=\"25\" placeholder=\"". $scale_information['indicator_model'] ."\" value=\"" . $scale_information['indicator_model'] . "\" required />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Indicator Serial:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"indicator_serial\" type=\"text\" size=\"25\" maxlength=\"20\" placeholder=\"". $scale_information['indicator_serial'] ."\"  value=\"" . $scale_information['indicator_serial'] . "\" required />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Scale Manufacturer:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"scale_manu\" type=\"text\" size=\"25\" maxlength=\"25\" placeholder=\"". $scale_information['scale_manu'] ."\"  value=\"" . $scale_information['scale_manu'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Scale Model:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"scale_model\" type=\"text\" size=\"25\" maxlength=\"25\" placeholder=\"". $scale_information['scale_model'] ."\"  value=\"" . $scale_information['scale_model'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Scale Serial:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"scale_serial\" type=\"text\" size=\"25\" maxlength=\"20\" placeholder=\"". $scale_information['scale_serial'] ."\"  value=\"" . $scale_information['scale_serial'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Scale Capacity\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"scale_capacity\" type=\"text\" size=\"10\" maxlength=\"10\" placeholder=\"". $scale_information['scale_capacity'] ."\"  value=\"" . $scale_information['scale_capacity'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Scale Divisions:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"scale_divisions\" type=\"text\" size=\"6\" maxlength=\"10\" placeholder=\"". $scale_information['scale_divisions'] ."\"  value=\"" . $scale_information['scale_divisions'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Units:\n".
						"							</th>\n".
						"							<td>\n".
						"								<input name=\"units\" type=\"radio\" value=\"lb\" checked>lb</input>\n".
						"								<input name=\"units\" type=\"radio\" value=\"kg\">kg</input>\n".
						"								<input name=\"units\" type=\"radio\" value=\"g\">g</input>\n".
						"								<input name=\"units\" type=\"radio\" value=\"oz\">oz</input>\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<th>\n".
						"								Time Spent (minutes):\n".
						"							</th>\n".
						"							<td>\n".
						"								". $fw->getTotalTime( $scale_information['scale_id'] ) ."\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td colspan=\"2\">\n".
						"								<input type=\"submit\" name=\"submit\" value=\"Save Changes\" onClick='return confirm(\"Are you sure you want to make these changes?\")' />\n".
						"							</td>\n".
						"						</tr>\n".
						"					</tbody>\n".
						"				</table>\n".
						"			</form>\n";
						
					} else {
						
						$output = "".
						"			<form action=\"updateTicket.php?id=". $id ."\" method=\"post\">\n".
						"				<table class=\"table-striped table-style\">\n".
						"					<tbody>\n".
						"						<tr>\n".
						"							<td>\n".
						"								ID:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"scale_id\" type=\"text\" size=\"25\" maxlength=\"40\" value=\"" . $scale_information['scale_id'] . "\" hidden/>". $scale_information['scale_id'] ."\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Status:\n".
						"							</td>\n".
						"							<td>\n".
						"								". $scale_information['status'] ."\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Created: \n".
						"							</td>\n".
						"							<td>\n".
						"								". $scale_information['date'] ."\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Updated: \n".
						"							</td>\n".
						"							<td>\n".
						"								". $scale_information['updated'] ."\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Created by:\n".
						"							</td>\n".
						"							<td>\n".
						"								" . $scale_information['tech_id'] . "\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Customer Name:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"companyname\" type=\"text\" size=\"25\" maxlength=\"40\" placeholder=\"". $scale_information['companyname'] ."\" value=\"" . $scale_information['companyname'] . "\" required />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Street:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"street\" type=\"text\" size=\"25\" maxlength=\"25\" placeholder=\"". $scale_information['street'] ."\" value=\"" . $scale_information['street'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								City:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"city\" type=\"text\" size=\"25\" maxlength=\"15\" placeholder=\"". $scale_information['city'] ."\" value=\"" . $scale_information['city'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								State:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"state\" type=\"text\" size=\"2\" maxlength=\"2\" placeholder=\"". $scale_information['state'] ."\" value=\"" . $scale_information['state'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Zipcode:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"zipcode\" type=\"text\" size=\"8\" maxlength=\"15\" placeholder=\"". $scale_information['zipcode'] ."\" value=\"" . $scale_information['zipcode'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Tag:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"indicator_tag\" type=\"text\" size=\"25\" maxlength=\"15\" placeholder=\"". $scale_information['indicator_tag'] ."\" value=\"" . $scale_information['indicator_tag'] ."\" required />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Indicator Manufacturer:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"indicator_manu\" type=\"text\" size=\"25\" maxlength=\"25\" placeholder=\"". $scale_information['indicator_manu'] ."\" value=\"" . $scale_information['indicator_manu'] . "\" required />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Indicator Model:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"indicator_model\" type=\"text\" size=\"25\" maxlength=\"25\" placeholder=\"". $scale_information['indicator_model'] ."\" value=\"" . $scale_information['indicator_model'] . "\" required />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Indicator Serial:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"indicator_serial\" type=\"text\" size=\"25\" maxlength=\"20\" placeholder=\"". $scale_information['indicator_serial'] ."\"  value=\"" . $scale_information['indicator_serial'] . "\" required />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Scale Manufacturer:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"scale_manu\" type=\"text\" size=\"25\" maxlength=\"25\" placeholder=\"". $scale_information['scale_manu'] ."\"  value=\"" . $scale_information['scale_manu'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Scale Model:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"scale_model\" type=\"text\" size=\"25\" maxlength=\"25\" placeholder=\"". $scale_information['scale_model'] ."\"  value=\"" . $scale_information['scale_model'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Scale Serial:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"scale_serial\" type=\"text\" size=\"25\" maxlength=\"20\" placeholder=\"". $scale_information['scale_serial'] ."\"  value=\"" . $scale_information['scale_serial'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Scale Capacity\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"scale_capacity\" type=\"text\" size=\"10\" maxlength=\"10\" placeholder=\"". $scale_information['scale_capacity'] ."\"  value=\"" . $scale_information['scale_capacity'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Scale Divisions:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"scale_divisions\" type=\"text\" size=\"6\" maxlength=\"10\" placeholder=\"". $scale_information['scale_divisions'] ."\"  value=\"" . $scale_information['scale_divisions'] . "\" />\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Units:\n".
						"							</td>\n".
						"							<td>\n".
						"								<input name=\"units\" type=\"radio\" value=\"lb\" checked>lb</input>\n".
						"								<input name=\"units\" type=\"radio\" value=\"kg\">kg</input>\n".
						"								<input name=\"units\" type=\"radio\" value=\"g\">g</input>\n".
						"								<input name=\"units\" type=\"radio\" value=\"oz\">oz</input>\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td>\n".
						"								Time Spent (minutes):\n".
						"							</td>\n".
						"							<td>\n".
						"								". $fw->getTotalTime( $scale_information['scale_id'] ) ."\n".
						"							</td>\n".
						"						</tr>\n".
						"						<tr>\n".
						"							<td></td>\n".
						"							<td>\n".
						"								<input type=\"submit\" name=\"submit\" value=\"Save Changes\" onClick='return confirm(\"Are you sure you want to make these changes?\")' />\n".
						"							</td>\n".
						"						</tr>\n".
						"					</tbody>\n".
						"				</table>\n".
						"			</form>\n";
					}
					
					echo $output;
					die();	
				} else {
					$_SESSION['viewScale']['error'] = "The scale information was not returned as an array, please report this to an admin.";
				}
			} else {
				echo "No valid POST was captured.\n";
				foreach ( $_POST as $key => $value ) {
					echo "KEY: ". $key . ", VALUE: ". $value ."\n";
				}
			}
		} else {
			echo "No valid POST was captured.\n";
			foreach ( $_POST as $key => $value ) {
				echo "KEY: ". $key . ", VALUE: ". $value ."\n";
			}
		}
	# END OF POST code, default page loads below	
	} 
			
	if ( isset( $_SESSION['viewScale']['error'] ) ) { 
		echo "<div class=\"error\">". $_SESSION['viewScale']['error'] ."</div>";
		unset( $_SESSION['viewScale'] );
	} elseif ( isset( $_SESSION['viewScale']['result'] ) ) { 
		echo "<div class=\"result\">". $_SESSION['viewScale']['result'] ."</div>";
		unset( $_SESSION['viewScale'] );
	}

	$id = "";
	if ( isset( $_GET['id'] ) ) { $id = $_GET['id']; } else { exit(); }

	$scale_information = $fw->getScale( $id );
	
	if ( is_array( $scale_information ) ) {
		
		?>	<h2>Scale Information</h2> <?php
		
		if ( $fw->isAdmin( $_SESSION ) ) {
			if ( $ismobi->CheckMobile() ) {
				$output = '
		<ul class="inline-list clearfix no-print">';
			
				/*$output .= '
			<li>
				<form action="viewScale.php?id='. $scale_information['scale_id'] .'" method="post">
					<button type="submit" name="submit" class="ui-btn ui-btn-inline ui-icon-edit ui-btn-icon-left" value="Edit Scale">Edit</button>	
				</form>
			</li>
				';*/
			
				if ( $fw->isSuperAdmin( $_SESSION ) ) {
					$output .= '
			<li>
				<form action="updateTicket.php?id='. $scale_information['scale_id'] .'" method="post">	
					<button type="submit" name="submit" class="ui-btn ui-btn-inline ui-icon-delete ui-btn-icon-left" value="Delete Scale" onClick=\'return confirm("Are you sure you want to delete this scale?")\'>Delete</button>
				</form>
			</li>
				';
				}
				
				$output .= '				
		</ul>';
				
			} else {
				$output = '
		<ul class="inline-list clearfix no-print">';
			
				$output .= '
			<li>
				<form action="viewScale.php?id='. $scale_information['scale_id'] .'" method="post">
					<input type="submit" name="submit" value="Edit Scale"/>			
				</form>
			</li>';
			
				if ( $fw->isSuperAdmin( $_SESSION ) ) {
					$output .= '
			<li>
				<form action="updateTicket.php?id='. $scale_information['scale_id'] .'" method="post">	
					<input type="submit" name="submit" value="Delete Scale" onClick=\'return confirm("Are you sure you want to delete this scale?")\' />
				</form>
			</li>';
				}
		
				$output .= '				
		</ul>';
		
			}
		} else { $output = ""; }
		
		if ( $ismobi->CheckMobile() ) {
			$output .= "".
			"				<table class=\"mobile-table\">\n".
			"					<tbody>\n".
			"						<tr>\n".
			"							<th>\n".
			"								ID:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['scale_id'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Status:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['status'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Created: \n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['date'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Updated: \n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['updated'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Created by:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['tech_id'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Customer Name:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['companyname'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Street:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['street'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								City:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['city'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								State:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['state'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Zipcode:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['zipcode'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Tag:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['indicator_tag'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Indicator Manufacturer:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['indicator_manu'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Indicator Model:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['indicator_model'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Indicator Serial:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['indicator_serial'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Scale Manufacturer:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['scale_manu'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Scale Model:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['scale_model'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Scale Serial:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['scale_serial'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Scale Capacity\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['scale_capacity'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Scale Divisions:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['scale_divisions'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Units:\n".
			"							</th>\n".
			"							<td>\n".
			"								" . $scale_information['units'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<th>\n".
			"								Time Spent (minutes):\n".
			"							</th>\n".
			"							<td>\n".
			"								". $fw->getTotalTime( $scale_information['scale_id'] ) ."\n".
			"							</td>\n".
			"						</tr>\n".
			"					</tbody>\n".
			"				</table>\n\n";
		} else {	
			$output .= "".
			"				<table class=\"table-style table-striped\">\n".
			"					<tbody>\n".
			"						<tr>\n".
			"							<td>\n".
			"								ID:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['scale_id'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Status:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['status'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Created: \n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['date'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Updated: \n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['updated'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Created by:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['tech_id'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Customer Name:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['companyname'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Street:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['street'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								City:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['city'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								State:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['state'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Zipcode:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['zipcode'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Tag:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['indicator_tag'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Indicator Manufacturer:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['indicator_manu'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Indicator Model:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['indicator_model'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Indicator Serial:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['indicator_serial'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Scale Manufacturer:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['scale_manu'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Scale Model:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['scale_model'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Scale Serial:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['scale_serial'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Scale Capacity\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['scale_capacity'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Scale Divisions:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['scale_divisions'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Units:\n".
			"							</td>\n".
			"							<td>\n".
			"								" . $scale_information['units'] . "\n".
			"							</td>\n".
			"						</tr>\n".
			"						<tr>\n".
			"							<td>\n".
			"								Time Spent (minutes):\n".
			"							</td>\n".
			"							<td>\n".
			"								". $fw->getTotalTime( $scale_information['scale_id'] ) ."\n".
			"							</td>\n".
			"						</tr>\n".
			"					</tbody>\n".
			"				</table>\n\n";
		}
			
			
		echo $output;
		
		$query = "select * from events where scale_id = ".$scale_information['scale_id']."";
		$result = $fw->query($query);
	
		if ( $result && !$ismobi->CheckMobile()) {
			$output = "<h3 style=\"margin-left: 2px;\" class=\"no-print\">History<h3>\n".
					  "				<div id=\"accordion\" class=\"no-print\">\n";
					  
			$outputB = "			<div id=\"accordion\" class=\"print-only\">\n";
					  
			while ( $row = $result->fetch_assoc() ) {
				$output .= "".
				"					<h3>". $row['date'] ." - ". $row['tech'] ." - ". $row['event'] ."</h3>\n".
				"					<div>\n".
				"						<p>\n". 
				"							". $fw->clean_output( $row['comments'] ) ."\n";
				
				if ( $row['event'] == "Diagnosed" || 
					$row['event'] == "Repaired" ||
					$row['event'] == "Added Additional Notes" ||
					$row['event'] == "Tested OK"
					) {
					$output .= "".
					"							<br /><br /><strong>Time spent: ". $row['timespent'] ." minutes</strong>\n";
				}
				
				$output .= "".
				"						</p>\n".
				"					</div>\n";
				
				$outputB .= "".
				"					<h3>". $row['date'] ." - ". $row['tech'] ." - ". $row['event'] ."</h3>\n".
				"					<div>\n".
				"						<p>". $fw->clean_output( $row['comments'] )."</p>\n".
				"					</div>\n";
			}
			
			$output .= "				</div>\n\n";
			$outputB .= "				</div>\n\n";
			
			echo $output;
			echo $outputB;
		} 
		elseif ( $result && $ismobi->CheckMobile()) {
			$output = "<h3 style=\"margin-left: 2px;\">History<h3>\n";
					  
			while ( $row = $result->fetch_assoc() ) {
				$output .= "				<div data-role=\"collapsible\" data-collapsed-icon=\"carat-d\" data-expanded-icon=\"carat-u\">\n".
				"					<h4>". substr( $row['date'], 0, 10 ) ." - ". $row['event'] ." - ". $row['tech'] ."</h3>\n".
				"					<p>". $fw->clean_output( $row['comments'] )."</p>\n".
				"				</div>\n\n";
			}
			
			echo $output;
		}
		
		$eventform = "".
		"<br />\n".
		"<form action=\"updateTicket.php?id=". $id ."\" method=\"post\" class=\"no-print\">\n".
		"\n".
		"	<table class=\"table-striped table-style\">\n".
		"		<tbody>\n".
		"			<tr>\n".
		"				<td>\n".
		"					<label for=\"stage\">New Status:</label>\n".
		"				</td>\n".
		"				<td>\n".
		"					<select name=\"stage\" id=\"stage\">\n".
		"						<option value=\"Added Additional Notes\">Additional Notes</option>\n".
		"						<option value=\"Delivered\">Delivered</option>\n".
		"						<option value=\"Diagnosed\" selected>Diagnosed</option>\n".
		"						<option value=\"Repaired\">Repaired</option>\n".
		"						<option value=\"Tested OK\">Tested OK</option>\n";
		
		if ( $fw->isAdmin( $_SESSION ) ) { 
			$eventform .= "".
			"						<option value=\"Complete\">Complete</option>\n".
			"						<option value=\"Non-repairable\">Non-repairable</option>\n".
			"						<option value=\"Replaced the Scale\">Replaced</option>\n".
			"						<option value=\"Waiting for Parts\">Waiting for Parts</option>\n".
			"						<option value=\"Waiting for Customer\">Waiting for Customer</option>\n";
		}
		
		$eventform .= "".
		"					</select>\n".
		"				</td>\n".
		"			</tr>\n".
		"			<tr>\n".
		"				<td>\n".
		"					<label for=\"timespent\">Time Spent (minutes):</label>\n".
		"				</td>\n".
		"				<td>\n".
		"					<input name=\"timespent\" type=\"text\" pattern=\"[0-9]{1,3}\" title=\"Numeric values only\" maxlength=\"3\" placeholder=\"45\" required />\n".
		"				</td>\n".
		"			</tr>\n".
		"			<tr>\n".
		"				<td>\n".
		"					Comments:\n".
		"				</td>\n".
		"				<td></td>\n".
		"			</tr>\n".
		"			<tr>\n".
		"				<td colspan=\"2\">\n".
		"					<textarea class=\"fixed\" name=\"comments\" type=\"text\" maxlength=\"1000\" required ></textarea>\n".
		"			</tr>\n".
		"			<tr>\n".
		"				<td></td>\n".
		"				<td>\n".
		"					<input type=\"submit\" name=\"submit\" value=\"Submit\"/>\n".
		"				</td>\n".
		"			</tr>\n".
		"		</tbody>\n".
		"	</table>\n".			
		"</form>\n";
		
		if ( $fw->isAdmin( $_SESSION ) ) {
			echo $eventform;
		} 
		elseif ( $scale_information['status'] && $scale_information['status'] != "Complete"  && 
				$scale_information['status'] != "Delivered" && 
				$scale_information['status'] != "Non-repairable" ) {
			echo $eventform;
		}
		?>
		
		<script>
			$(document).ready( function() {
				$("#stage").change( function() {
					var stage = $("#stage").val();
					var input = $("input[name='timespent']");
					
					if ( stage == "Diagnosed" || stage == "Repaired" || 
						 stage == "Added Additional Notes" || stage == "Tested OK" )
					{
						input.attr('required', 'required');
						input.closest("tr").show( 600 );
					} else {
						input.closest("tr").hide( 600 );
						input.val( '' );
						input.removeAttr('required');
					}
				});
			});
		</script>		
	</body>
</html>

<?php
		}
    } else {
		echo "You must be logged in to view this page.";
		header( "Location: login.php" );
	}
	
	$fw->close();
?>