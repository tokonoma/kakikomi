<?php

try{
    $db = new PDO($dsn);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
    //new or editing
    if(isset($_GET['post'])){
    	//set variables for date title post and published bool
		//if PUBLISHED no SAVE AS DRAFT - set variaible and do ternary to print that button
		//switch to UNPUBLISH button and saves as draft!!!!

		//GET post data
		$postUID = $_GET['post'];
		$getPost = $db->prepare("SELECT * FROM posts WHERE uid = ?");
		$postArray = array($postUID);
		$getPost->execute($postArray); 

		//update
		
    }
    else{
    	if(isset($_POST['published-input'])){
			$postTitle = $_POST['title-input'];
			$inputDate = $_POST['date-input'];
			$formattedDate = str_replace(' • ', '-', $inputDate);
			$postDate = date('Ymd',strtotime($formattedDate));
			$postBody = $_POST['post-input'];
			$publishInput = $_POST['published-input'];

			$insert = $db->prepare("INSERT INTO posts (date, title, body, published) VALUES (?, ?, ?, ?)");
			$insertarray = array($postDate, $postTitle, $postBody, $publishInput);
			$insert->execute($insertarray);

			if($publishInput){
				$_SESSION['sessionalert'] = "postpublished";
				header("Location: ".$baseurl);
			}
			else{
				$savedUID = $db->lastInsertId();
				$_SESSION['sessionalert'] = "postsaved";
				header("Location: ".$_SERVER['REQUEST_URI']."&post=".$savedUID);
			}
			exit();
		}
    }

    // close the database connection
    $db = NULL;
}
catch(PDOException $e){
    $statusMessage = $e->getMessage();
    $statusType = "danger";
}

//create blanks for new post
$thisTitle = "";
$thisDate = date("M • d • Y");
$thisBody = "";

//if getPost was successful, print contents of post
if(isset($getPost)){
	foreach($getPost as $post){
		$thisTitle = $post['title'];
		$postDate = $post['date'];
		$thisDate = date('M • d • Y',strtotime($postDate));
		$shortDate = date('m • d',strtotime($postDate));
		$thisBody = $post['body'];
		$thisPublished = $post['published'];
	}
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
				<form id="write-form" autocomplete="off" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
					<input type="text" id="title-input" name="title-input" class="title-input" aria-label="title input" value="<?php echo $thisTitle; ?>" placeholder="add a title for your post">
					<input class="invisible-input post-date" name="date-input" value="<?php echo $thisDate; ?>" placeholder="add a publish date">
					<div id="tags-btn" class="d-inline-block float-right clickable">
						<img src="assets/images/tags.svg">
					</div>
					<div class="body-container">
						<textarea id="post-input" name="post-input" class="post-input" rows="3" placeholder="write your post here"><?php echo $thisBody; ?></textarea>
						<div class="tags-container">
							<div class="tags-inner">
								<div class="form-inline d-flex">
									<input type="text" id="tag-input" class="tag-input" aria-label="tag input" value="" placeholder="Add tag">
									<button type="button" class="btn add-tag-btn">ADD TAG</button>
								</div>
								<ul class="tag-list mt-4 list-unstyled">
								</ul>
							</div>
						</div>
					</div>
					<input type="hidden" name="published-input" value="1">
					<div class="action-bar">
						<a href="" class="btn btn-link clear secondary">CLEAR</a>
						<div class="float-right">
							<?php if(isset($thisPublished) && $thisPublished == 0): ?>
								<button type="button" class="btn btn-link secondary save-draft-btn">SAVE DRAFT <span class="badge"><?php echo $shortDate; ?></span></button>
								<button type="submit" class="btn btn-link submit">PUBLISH</button>
							<?php elseif($thisPublished == 1): ?>
								<button type="button" class="btn btn-link secondary save-draft-btn">CONVERT TO DRAFT</button>
								<button type="submit" class="btn btn-link submit">UPDATE</button>
							<?php else: ?>
								<button type="button" class="btn btn-link secondary save-draft-btn">SAVE DRAFT</button>
								<button type="submit" class="btn btn-link submit">PUBLISH</button>
							<?php endif; ?>
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