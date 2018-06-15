<?php

try{

    //postgres for prod
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    

    // close the database connection
    $db = NULL;
}
catch(PDOException $e){
    $statusMessage = $e->getMessage();
    $statusType = "danger";
}

?>

<!--HTML INCLUDES-->

<?php include('views/head.php'); ?>

<?php include('views/header.php'); ?>

<?php include('views/tabs.php'); ?>

<main class="kakikomi-write">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-8 offset-sm-2">
				<input type="text" id="title-input" class="title-input" aria-label="title input" placeholder="add a title for your post">
				<input class="invisible-input post-date" value="<?php echo date("M • d • Y"); ?>" placeholder="add a publish date">
				<div class="tags-icon d-inline-block float-right clickable"><img src="assets/images/tags.svg"></div>
				<textarea id="post-input" class="post-input" rows="3" placeholder="write your post here"></textarea>
				<div class="action-bar">
					<a href="" class="btn btn-link clear secondary">CLEAR</a>
					<div class="float-right">
						<button type="button" class="btn btn-link secondary">SAVE DRAFT <span class="badge">5 • 24</span></button>
						<button type="button" class="btn btn-link submit">PUBLISH</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>


<?php include('views/menu.php'); ?>

<!--BOTTOM-->

<?php include('views/footer.php'); ?>

<?php include('views/commonjs.php'); ?>

<?php include('views/ender.php'); ?>