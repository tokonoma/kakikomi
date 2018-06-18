<?php

try{
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //new or editing
    if(isset($_GET['postuid'])){
    	//set variables for date title post and published bool
    	//if PUBLISHED no SAVE AS DRAFT - set variaible and do ternary to print that button

    	//update
    }
    else{
    	//date is todays date

    	if(isset($_POST['published-input'])){

    	}
    	// $input_title = "second post";
	    // $input_date = "20180613";
	    // $input_body = "#second post this is for delete function testing";

	    //FYI $checkpass = password_verify($inputpass, $storedpass) yields t or f for pw check

	    // $insert = $db->prepare("INSERT INTO posts (title, body, date) VALUES (?, ?, ?)");
	    // $insertarray = array($input_title, $input_body, $input_date);
	    // $insert->execute($insertarray);
    }


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
				<form id="js-submit-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
					<input type="text" id="title-input" class="title-input" aria-label="title input" placeholder="add a title for your post">
					<input class="invisible-input post-date" value="<?php echo date("M • d • Y"); ?>" placeholder="add a publish date">
					<div class="tags-icon d-inline-block float-right clickable"><img src="assets/images/tags.svg"></div>
					<textarea id="post-input" class="post-input" rows="3" placeholder="write your post here"></textarea>
					<input type="hidden" name="published-input" value="1">
					<div class="action-bar">
						<a href="" class="btn btn-link clear secondary">CLEAR</a>
						<div class="float-right">
							<button type="button" class="btn btn-link secondary save-draft-btn">SAVE DRAFT <span class="badge">5 • 24</span></button>
							<button type="submit" class="btn btn-link submit">PUBLISH</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</main>


<?php include('views/menu.php'); ?>

<!--BOTTOM-->

<?php include('views/footer.php'); ?>

<?php include('views/commonjs.php'); ?>

<?php include('views/ender.php'); ?>