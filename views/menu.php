<div id="kakikomi-menu">
	<div class="menu-inner">
		<img class="menu-logo clickable" src="assets/images/kaki-logo-wht.svg">
		<h5 class="mb-4">MENU</h5>
		<div class="mb-4 menu-hello">
			Hi <?php if(!empty($_SESSION['firstname'])): ?> <?php echo $_SESSION['firstname'] ?> <?php else: ?> There <?php endif ?>
		</div>
		<a href="<?php echo $baseurl; ?>?mode=settings" class="menu-link">Settings</a>
		<hr>
		<form id="login-form" method="POST" action="<?php echo $baseurl; ?>">
			<input type="hidden" name="action" value="logout">
			<button type="submit" name="submit" class="btn btn-link menu-link">
				Logout
			</button>
		</form>
	</div>
</div>

<div id="click-away"></div>