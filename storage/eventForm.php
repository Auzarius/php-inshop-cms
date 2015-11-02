		
		<br />
		<form action="viewScale.php" method="post" class="no-print">

			<table class="table-striped table-style">
				<tbody>
					<tr>
						<td>
							<label for="stage">New Status:</label>
						</td>
						<td>
							<select name="stage" id="stage">
								<option value="Added Additional Notes">Additional Notes</option>
								<option value="Delivered">Delivered</option>
								<option value="Diagnosed" selected>Diagnosed</option>
								<option value="Repaired">Repaired</option>
								<option value="Tested OK">Tested OK</option>
								<?php if ( $_SESSION['is_admin'] ) { ?>
								<option value="Complete">Complete</option>
								<option value="Non-repairable">Non-repairable</option>
								<option value="Replaced the Scale">Replaced</option>
								<option value="Waiting for Parts">Waiting for Parts</option>
								<option value="Waiting for Customer">Waiting for Customer</option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							Comments:
						</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2">
							<textarea class="fixed" name="comments" type="text" maxlength="1000" required ></textarea>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" name="submit" value="Submit"/>
						</td>
					</tr>
				</tbody>
			</table>			
		</form>
		