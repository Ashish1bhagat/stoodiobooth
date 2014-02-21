<?php include_once 'layouts/common.php';
if (isset($_POST['id']) && isset($_FILES['image'])){
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $hashtag = filter_input(INPUT_POST, 'hashtag', FILTER_SANITIZE_STRING);
    $get_tweets = filter_input(INPUT_POST, 'get_tweets', FILTER_SANITIZE_STRING) ? 1 : 0;
    $twitter = filter_input(INPUT_POST, 'twitter', FILTER_SANITIZE_STRING);
    $oldimage = filter_input(INPUT_POST, 'oldimage', FILTER_SANITIZE_STRING);
	if($title == ''){
		flash('msg', 'Please enter Event Title', 'error', BASEURL .'/dashboard.php');
		return false;
	}
	if($_FILES['image']['name']){
		$image = upload_image($_FILES['image'], 'events');
		if($newimage === "ERROR") flash('msg', 'Image could not be uploaded', 'error', BASEURL .'/event.php?event='.$id);
		if($newimage === "OVERSIZE") flash('msg', 'Image size should not be more than 2 MB', 'error', BASEURL .'/event.php?event='.$id);
	}
	if ($insert_stmt = $mysqli->prepare("UPDATE events SET title = ?, description = ?, hashtag = ?, image = ?, get_tweets = ?, twitter = ? WHERE id = ?")) {
		if($image != ''){
			$insert_stmt->bind_param('ssssisi', $title, $description, $hashtag, $image, $get_tweets, $twitter, $id);
		}else{
			$insert_stmt->bind_param('ssssisi', $title, $description, $hashtag, $oldimage, $get_tweets, $twitter, $id);
		}
		if (!$insert_stmt->execute()) {
			if($image != ''){
				delete_image($image, 'events');
			}
			flash('msg', 'Failed to save Event', 'error', BASEURL .'/event.php?event='.$id);
		}
	}
	flash( 'msg', 'Event Created Success fully', 'success', BASEURL .'/event.php?event='.$id);
	if($image != ''){
		delete_image($oldimage, 'events');
	}
}else{
	flash('msg', 'Failed to save Event', 'error', BASEURL .'/dashboard.php');
} ?>