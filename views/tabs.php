<nav class="tabs">
	<div class="container">
		<div class="row">
			<div class="col-6 col-sm-4 offset-sm-2">
				<a href="<?php echo $baseurl; ?>" class="tab text-center <?php echo ($mode != 'write'?'active':''); ?>">posts</a>
			</div>
			<div class="col-6 col-sm-4">
				<a href="<?php echo $baseurl; ?>?mode=write" class="tab text-center <?php echo ($mode == 'write'?'active':''); ?>">write</a>
			</div>
		</div>
	</div>
</nav>