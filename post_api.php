<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('system/db_connect.php');

try{
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $postsArray = [];
    $getBody = false;

    if(isset($_GET['post'])){
        $getUID = $_GET['post'];
        $posts = $db->prepare("SELECT * FROM posts WHERE uid = ?");
		$getPostArray = array($getUID);
		$posts->execute($getPostArray);
        $getBody = true;
    }
    elseif(isset($_GET['search'])){
        $getQuery = "%".$_GET['search']."%";
        $posts = $db->prepare("SELECT * FROM posts WHERE body LIKE ?");
		$getPostArray = array($getQuery);
        $posts->execute($getPostArray);
    }
    else{
        $posts = $db->query("SELECT * FROM posts ORDER BY date DESC");
    }

    foreach($posts as $post){
        $postArray = [];
        $tagsArray = [];

        $postArray['uid'] = $post['uid'];
        $postArray['date'] = $post['date'];
        $postArray['title'] = $post['title'];
        $postArray['published'] = $post['published'];
        if($getBody == true){
            $postArray['body'] = $post['body'];  
        }

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
  
if(count($postsArray)>0){
    echo json_encode($postsArray);
}
else{
    echo json_encode(array("message" => "No results found"));
}

?>