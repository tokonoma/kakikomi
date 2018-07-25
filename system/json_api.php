<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try{
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $postsArray = [];
    $getBody = false;

    if(isset($_GET['post'])){
        $getUID = $_GET['post'];
        $posts = $db->prepare("SELECT * FROM posts WHERE uid = ? AND published = 1");
		$getPostArray = array($getUID);
		$posts->execute($getPostArray);
        $getBody = true;
    }
    elseif(isset($_GET['search'])){
        //use this for prepping search input for URL FROM frontend calling the API
        //--strip all non alphanumeric characters
        //$alphaNumOnly = preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['search']);
        //--lastly guarentee url safe with urlencode - this will auto space->plus sign +
        //$urlEncoded = urlencode($alphaNumOnly);

        $queryArray = explode(' ', $_GET['search']);

        $postsSQL="SELECT uid, date, title FROM posts WHERE ";
        $sql_and="";
        foreach($queryArray as $query){
            $wildcardQuery = "%".$query."%";
            $postsSQL .= $sql_and . "(body LIKE '$wildcardQuery' OR title LIKE '$wildcardQuery')";
            $sql_and=" AND ";
        }
        $postsSQL .= " AND published = 1 ORDER BY date DESC";
        $posts = $db->query($postsSQL);
    }
    else{
        $posts = $db->query("SELECT uid, date, title FROM posts WHERE published = 1 ORDER BY date DESC");
    }

    foreach($posts as $post){
        $postArray = [];
        $tagsArray = [];

        $postArray['uid'] = $post['uid'];
        $postArray['date'] = $post['date'];
        $postArray['title'] = $post['title'];
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