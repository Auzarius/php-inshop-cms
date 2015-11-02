
	<table class="table-style table-striped" style="position: fixed; top: 60px; right: 0;">
		<tbody>
			<tr>
				<td>USERID</td>
				<td><?php echo @ $_SESSION['USER']['userid']; ?></td>
			</tr>
			<tr>
				<td>USERNAME</td>
				<td><?php echo @ $_SESSION['USER']['username']; ?></td>
			</tr>
			<tr>
				<td>FULLNAME</td>
				<td><?php echo @ $_SESSION['USER']['fullname']; ?></td>
			</tr>
			<tr>
				<td>DIGEST</td>
				<td><?php echo @ $_SESSION['USER']['digest']; ?></td>
			</tr>
			<tr>
				<td>IS_USER</td>
				<td><?php echo @ $_SESSION['USER']['is_user']; ?></td>
			</tr>
			<tr>
				<td>IS_ADMIN</td>
				<td><?php echo @ $_SESSION['USER']['is_admin']; ?></td>
			</tr>
			<tr>
				<td>IS_SADMIN</td>
				<td><?php echo @ $_SESSION['USER']['is_superadmin']; ?></td>
			</tr>
			<tr>
				<td>isLoggedIn</td>
				<td><?php echo @ $fw->isLoggedIn( $_SESSION ); ?></td>
			</tr>
			<tr>
				<td>isValidUser</td>
				<td><?php echo @ $fw->isValidUser( $_SESSION ); ?></td>
			</tr>
			<tr>
				<td>isMobile</td>
				<td><?php echo $ismobi->CheckMobile(); ?></td>
			</tr>
			<tr>
				<td>Server Name</td>
				<td><?php echo $_SERVER['SERVER_NAME']; ?></td>
			</tr>
			<tr>
				<td>Request Method</td>
				<td><?php echo $_SERVER['REQUEST_METHOD']; ?></td>
			</tr>
			<?php if ( $_SERVER['REQUEST_METHOD'] == "POST" ) { ?>
			<tr>
				<td>Submit Value</td>
				<td><?php echo $_POST['submit']; ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td>Digest</td>
				<td><?php echo @ $_SESSION['digest']; ?></td>
			</tr>
		</tbody>
	</table>
