		<header class="no-print">
			<nav>
				<span class="pl-10"></span>
				<a href="http://auzarius.com/scales/inshop"><img src="http://auzarius.com/scales/inshop/logo.png"></img></a>
				<span class="pr-10"></span>
				<ul class="nav-left">
					<li id="checkin"><a href="scaleCheckin.php">Check-in</a></li>
					<li id="scalerepair"><a href="showRepairs.php">View Repairs</a></li>
					<li id="scaleservice" hidden><a href="field-service.php">Field Service</a></li>
					<li id="search" hidden><a href="search.php">Search</a></li>
				</ul>
				<ul class="nav-right">
					<?php if ( isset( $_SESSION['val_username'] ) ) { echo "<li><a href=\"logout.php\">". $_SESSION['val_username'] ."</a></li>"; } ?>
					<li style="color: #303030;" hidden><a href="#">Sign Up</a></li>
				</ul>
			</nav>
		</header>