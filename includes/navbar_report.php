<style>
	.fa,
	.far,
	.fas {
		font-family: "Font Awesome 5 Free" !important;
	}
</style>
<nav >
	<input type="checkbox" id="check">
	<label for="check" class="checkbtn">
		<i class="fas fa-bars"></i>
		
	</label>

	<ul style="text-align: center;width: 100%;">
		<li><a href="<?php echo SITE_URL ?>records.php">Home</a></li>
		<li><a href="<?php echo SITE_URL ?>admin/user">Employee</a></li>
		<li><a href="<?php echo SITE_URL ?>admin/project/">Project</a></li>
		<li><a href="<?php echo SITE_URL ?>admin/drone/">Drones</a></li>
		<li><a href="<?php echo SITE_URL ?>admin/battery/">Battery</a></li>
		<li><a href="<?php echo SITE_URL ?>report.php">Battery Reports</a></li>
		<li><a href="<?php echo SITE_URL ?>auth.php?action=logout" style="text-decoration:none; width:fit-content; ">↩️Logout</a></li>

	</ul>
</nav>