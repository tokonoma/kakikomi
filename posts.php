<!--HTML INCLUDES-->

<?php include('views/header.php'); ?>

<header>
	<div class="container">
		<div class="row">
			<div class="col-12 text-center position-relative">
				<h1 id="test">kakikomi</h1>
			</div>
		</div>
	</div>
	<div id="kaki-logo" class="kaki-logo clickable">
		<img src="assets/images/kaki-logo.svg">
	</div>
</header>

<nav class="tabs">
	<div class="container">
		<div class="row">
			<div class="col-6 col-sm-4 offset-sm-2">
				<a href="posts.php" class="tab text-center active">posts</a>
			</div>
			<div class="col-6 col-sm-4">
				<a href="write.php" class="tab text-center">write</a>
			</div>
		</div>
	</div>
</nav>

<main class="kakikomi-posts">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-8 offset-sm-2">
				<!-- item -->
			</div>
		</div>
	</div>
</main>

<div id="kakikomi-menu">
	<div class="menu-inner">
		<img class="menu-logo clickable" src="assets/images/kaki-logo-wht.svg">
		MENU
	</div>
</div>



<div id="click-away"></div>


<!--BOTTOM-->

<?php include('views/footer.php'); ?>

<?php include('views/commonjs.php'); ?>

<?php include('views/ender.php'); ?>