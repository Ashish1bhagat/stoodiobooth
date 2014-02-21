<?php include_once 'layouts/common.php';
if (isset($_POST) && isset($_FILES['image'])){
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $hashtag = filter_input(INPUT_POST, 'hashtag', FILTER_SANITIZE_STRING);
    $get_tweets = filter_input(INPUT_POST, 'get_tweets', FILTER_SANITIZE_STRING) ? 1 : 0;
    $twitter = filter_input(INPUT_POST, 'twitter', FILTER_SANITIZE_STRING);
	if($title == ''){
		flash('msg', 'Please enter Event Title', 'error', BASEURL .'/dashboard.php');
		return false;
	}
	if($_FILES['image']['name']){
		$image = upload_image($_FILES['image'], 'events');
	}else{
		$image = '';
	}
	if ($insert_stmt = $mysqli->prepare("INSERT INTO events (title, description, hashtag, image, get_tweets, twitter) VALUES (?, ?, ?, ?, ?)")) {
		$insert_stmt->bind_param('ssssis', $title, $description, $hashtag, $image, $get_tweets, $twitter);
		if (!$insert_stmt->execute()) {
			flash('msg', 'Failed to save Event', 'error', BASEURL .'/dashboard.php');
		}
	}
	flash( 'msg', 'Event Created Success fully', 'success', BASEURL .'/dashboard.php');
} ?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Events</title>
	<?php include_once 'layouts/head.php';  ?>
</head>
<body>
<?php include_once 'layouts/header.php';  ?>	
	<div class="events content-area">
		<form action="<?php echo BASEURL; ?>/add_event.php" enctype="multipart/form-data" method="post" name="create_event">
			<fieldset>
				<legend>Create new Event</legend>
				<div class="field">
					<label for="title">Event Title:</label>
					<input type="text" id="title" name="title" />
				</div>
				<div class="field">
					<label for="description">Event Description:</label>
					<textarea name="description" id="description"></textarea>
				</div>
				<div class="field">
					<label for="hashtag">Event Hashtag(Istagram):</label>
					<input type="text" id="hashtag" name="hashtag" />
				</div>
				<div class="field">
					<label><input type="checkbox" id="get_tweets" name="get_tweets" /> Include Ttweets also?</label>
				</div>
				<div class="field">
					<label for="twitter">Twitter Hashtag:</label>
					<input type="text" id="twitter" name="twitter" />
				</div>
				<div class="field">
					<label for="image">Upload Watermark:</label>
					<input type="file" id="image" name="image" />
				</div>
				<div class="action">
					<input type="submit" value="Create Event"/>
				</div>
			</fieldset>
		</form>
	</div>
	
<?php include_once 'layouts/footer.php';  ?>
<body>
</html>