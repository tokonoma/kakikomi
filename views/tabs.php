<nav class="tabs">
	<div class="container">
		<div class="row">
			<?php if($mode != 'write'): ?>
				<div class="col-6 col-sm-4 offset-sm-2">
					<div class="tab text-center active">
						posts
					</div>
				</div>
				<div class="col-6 col-sm-4">
					<a href="<?php echo $baseurl; ?>?mode=write" class="tab text-center">
						write
					</a>
				</div>
			<?php elseif($mode == 'write'): ?>
				<div class="col-6 col-sm-4 offset-sm-2">
					<a href="<?php echo $baseurl; ?>" class="tab text-center">
						posts
					</a>
				</div>
				<div class="col-6 col-sm-4">
					<div class="tab text-center active">
						write
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</nav>