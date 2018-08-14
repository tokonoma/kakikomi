<?php

try{
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //post actions
    if(isset($_POST['post-action'])){
	    $postAction = $_POST['post-action'];
	    switch ($postAction){
	        case 'delete':
	        	if(isset($_POST['delete-uid'])){
					$deleteUID = $_POST['delete-uid'];
					$deletepost = $db->prepare("DELETE FROM posts WHERE uid = ?");
					$deletearray = array($deleteUID);
					$deletepost->execute($deletearray);
					
					$_SESSION['sessionalert'] = "postdeleted";
					header("Location: ".$_SERVER['REQUEST_URI']);
					exit();
				}
				else{
					$_SESSION['sessionalert'] = "generalerror";
					header("Location: ".$_SERVER['REQUEST_URI']);
					exit();
				}
	            break;
	    }
	}

    $posts = $db->query("SELECT * FROM posts ORDER BY date DESC");

	$postsArray = [];
	foreach($posts as $post){
		$postArray = [];
		$tagsArray = [];

		$postArray['uid'] = $post['uid'];
		$postArray['date'] = $post['date'];
		$postArray['title'] = $post['title'];
		$postArray['published'] = $post['published'];

		$getTags = $db->prepare("SELECT * FROM tags WHERE puid = ?");
		$getTagsArray = array($post['uid']);
		$getTags->execute($getTagsArray);
		foreach($getTags as $tag){
			$tagsArray[] = $tag['name'];
		}
		$postArray['tags'] = $tagsArray;

		$postsArray[] = $postArray;
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

<main class="kakikomi-posts">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-8 offset-sm-2">
				<?php include('views/alerts.php');?>
			</div>

			<?php foreach($postsArray as $postArray): ?>
				<div class="col-12 col-sm-8 offset-sm-2 post-item mb-4">
					<h4>
						<a href="<?php echo $baseurl; ?>?mode=write&post=<?php echo $postArray['uid']; ?>"><?php echo $postArray['title']; ?></a>
					</h4>
					<span class="post-date"><?php echo $postArray['date']; ?></span>
					<p><?php echo $postArray['body']; ?></p>
					<ul class="list-inline">
						<?php if($postArray['published']): ?>
							<li class="badge badge--fill">PUBLISHED</li>
						<?php else: ?>
							<li class="badge">DRAFT</li>
						<?php endif; ?>
						<?php foreach($postArray['tags'] as $tag): ?>
							<li class="list-inline-item badge"><?php echo $tag; ?></li>
						<?php endforeach; ?>
					</ul>
					<button type="button" class="btn btn-secondary delete-post-btn mb-4" data-toggle="modal" data-target="#delete-post-modal" data-uid="<?php echo $postArray['uid']?>" data-title="<?php echo $post['title']?>">delete</button>
				</div>
			<?php endforeach; ?>

		</div>
	</div>
</main>

<?php include('views/menu.php'); ?>

<!--BOTTOM-->

<?php include('views/footer.php'); ?>

<?php include('views/modals.php'); ?>

<?php include('views/commonjs.php'); ?>

<?php include('views/ender.php'); ?>