<?php

try{

    //postgres for prod
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    //add row tool
    // $input_email = "email@email.com";
    // $input_password = "password";
    // $password_store = password_hash($input_password, PASSWORD_BCRYPT);
    // $input_fname = "Firsty";
    // $input_lname = "Lasterson";
    // $input_puid = 1;
    // $input_name = "test";

    //FYI $checkpass = password_verify($inputpass, $storedpass) yields t or f for pw check

    // $insert = $db->prepare("INSERT INTO tags (puid, name) VALUES (?, ?)");
    // $insertarray = array($input_puid, $input_name);
    // $insert->execute($insertarray); 

    //update row tool
    // $update = $db->prepare("UPDATE tablename SET colname = :inputbind, anothercol = :secondbind WHERE uid = $uid");
    // $update->bindParam(':inputbind', $newinput, PDO::PARAM_STR);
    // $update->bindParam(':secondbind', $secondinput, PDO::PARAM_STR);
    // $update->execute();

    // close the database connection
    $db = NULL;
}
catch(PDOException $e){
    $statusMessage = $e->getMessage();
    $statusType = "danger";
}

?>

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