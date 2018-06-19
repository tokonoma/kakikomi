<?php

try{
    $db = new PDO($dsn);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
    //EDITING EXISTING
    if(isset($_GET['post'])){
		//GET post data
		$postUID = $_GET['post'];
		$getPost = $db->prepare("SELECT * FROM posts WHERE uid = ?");
		$getPostArray = array($postUID);
		$getPost->execute($getPostArray);

		//GET tags data
		$getTags = $db->prepare("SELECT * FROM tags WHERE puid = ?");
		$getTags->execute($getPostArray);

		//update
		if(isset($_POST['published-input'])){
			$postTitle = $_POST['title-input'];
			$inputDate = $_POST['date-input'];
			$formattedDate = str_replace(' • ', '-', $inputDate);
			$postDate = date('Ymd',strtotime($formattedDate));
			$postBody = $_POST['post-input'];
			$publishInput = $_POST['published-input'];

			//update post
			$updatePost = $db->prepare("UPDATE posts SET date = :dateBind, title = :titleBind, body = :bodyBind, published = :publishedBind WHERE uid = $postUID");
			$updatePost->bindParam(':dateBind', $postDate, PDO::PARAM_STR);
			$updatePost->bindParam(':titleBind', $postTitle, PDO::PARAM_STR);
			$updatePost->bindParam(':bodyBind', $postBody, PDO::PARAM_STR);
			$updatePost->bindParam(':publishedBind', $publishInput, PDO::PARAM_STR);
			$updatePost->execute();

			//delete all tags
			$wipeTags = $db->prepare("DELETE FROM tags WHERE puid = ?");
			$wipeTagsArray = array($postUID);
			$wipeTags->execute($wipeTagsArray);

			//rewrite tags
			$tagInputJson = $_POST['tag-array-input'];
			$tagInputArray = json_decode($tagInputJson, true);

			foreach($tagInputArray as $inputTag){
				$insertTag = $db->prepare("INSERT INTO tags (puid, name) VALUES (?, ?)");
				$insertTagArray = array($postUID, $inputTag);
				$insertTag->execute($insertTagArray);
			}

			//IF PUBLISHED
			if($publishInput){
				$_SESSION['sessionalert'] = "postpublished";
				header("Location: ".$baseurl);
			}
			//IF SAVED
			else{
				$_SESSION['sessionalert'] = "postsaved";
				header("Location: ".$_SERVER['REQUEST_URI']."&post=".$postUID);
			}
			exit();
		}
	}
	//IF NEW
    else{
		//if SUBMITED
    	if(isset($_POST['published-input'])){
			$postTitle = $_POST['title-input'];
			$inputDate = $_POST['date-input'];
			$formattedDate = str_replace(' • ', '-', $inputDate);
			$postDate = date('Ymd',strtotime($formattedDate));
			$postBody = $_POST['post-input'];
			$publishInput = $_POST['published-input'];

			$insertpost = $db->prepare("INSERT INTO posts (date, title, body, published) VALUES (?, ?, ?, ?)");
			$insertpostarray = array($postDate, $postTitle, $postBody, $publishInput);
			$insertpost->execute($insertpostarray);

			//this post UID
			$savedUID = $db->lastInsertId();
			
			//tags
			$tagInputJson = $_POST['tag-array-input'];
			$tagInputArray = json_decode($tagInputJson, true);

			foreach($tagInputArray as $inputTag){
				$insertTag = $db->prepare("INSERT INTO tags (puid, name) VALUES (?, ?)");
				$insertTagArray = array($savedUID, $inputTag);
				$insertTag->execute($insertTagArray);
			}

			//IF PUBLISHED
			if($publishInput){
				$_SESSION['sessionalert'] = "postpublished";
				header("Location: ".$baseurl);
			}
			//IF SAVED
			else{
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
								<ul id="tag-list" class="mt-4 list-unstyled">
									<?php
										if(isset($getTags)){
											$tagArray = [];
											foreach($getTags as $i=>$tag){
												$i++;
												$tagArray[] = $tag['name'];
												echo "<li>";
												echo $tag['name'];
												echo "<span class='tag-delete clickable' data-tag='".$i."'>&times;</span>";
												echo "</li>";
											}
											$tagJson = json_encode($tagArray);
										}
									?>
								</ul>
							</div>
						</div>
					</div>
					<input type="hidden" name="published-input" value="1">
					<input type="hidden" name="tag-array-input" value='<?php echo $tagJson; ?>'>
					<div class="action-bar">
						<a href="<?php echo $baseurl; ?>?mode=write" class="btn btn-link clear secondary">CLEAR</a>
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

<script>
	<?php if(isset($tagJson)): ?>
		var tagsArray = <?php echo $tagJson; ?>;
	<?php else: ?>
		var tagsArray = [];
	<?php endif ?>
</script>

<?php include('views/commonjs.php'); ?>

<?php include('views/ender.php'); ?>