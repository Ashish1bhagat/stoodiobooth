<?php include_once 'layouts/twitter.class.php';
include_once 'layouts/common.php';
if (isset($_GET)){
    $eid = filter_input(INPUT_GET, 'event', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, 'event', FILTER_SANITIZE_NUMBER_INT) : 0;
	if($eid){
		if ($stmt = $mysqli->prepare("SELECT * FROM events WHERE id = $eid LIMIT 1")){
			$stmt->execute();
			$result = $stmt->get_result();
			if(!$result->num_rows){
				flash( 'msg', 'Event not found', 'error', BASEURL .'/dashboard.php');
			}else{
				$event = $result->fetch_assoc();
			}
		}else{
			flash( 'msg', 'Event not found', 'error', BASEURL .'/dashboard.php');
		}
	}else{
		flash( 'msg', 'Event not specified', 'error', BASEURL .'/dashboard.php');
	}
}

if(isset($_POST['tid'])){
	$tid = $_POST['tid'];
	$tweet = $mysqli->real_escape_string($_POST['tweet']);
	$user = $mysqli->real_escape_string($_POST['user']);
	$upic = $mysqli->real_escape_string($_POST['upic']);
	
	$exist = check_exists('tweet_id', $tid, 'event_tweets');
	if($exist){
		$arr = array('status' => 'error', 'msg'=>'Tweet already exist', 'redirect' => BASEURL .'/event.php?event='.$eid);
		echo json_encode($arr);
		exit;		
	}else{		
		if ($insert_stmt = $mysqli->prepare("INSERT INTO event_tweets (tweet_id, tweet, user, picture) VALUES (?, ?, ?, ?)")) {
			$insert_stmt->bind_param('isss', $tid, $tweet, $user, $upic);
			if (!$insert_stmt->execute()) {
				$arr = array('status' => 'error', 'redirect' => BASEURL .'/event.php?event='.$eid);
				echo json_encode($arr);
				exit;
			}
		}
		$arr = array('status' => 'success', 'redirect' => BASEURL .'/event.php?event='.$eid);
		echo json_encode($arr);
		exit;
	}
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>StudioBooth</title>
	<?php include_once 'layouts/head.php';  ?>
</head>
<body>
<?php include_once 'layouts/header.php'; ?>
	<div class="event">
		<div class="title-row top-bar">
			<a href="#eventForm" class="button fancy title-btn small edit">Edit Event</a>
			<a href="<?php echo BASEURL; ?>/dashboard.php" class="button title-btn small ">Back to Events</a>
			<h1 class="title"><?php echo $event['title']; ?></h1>
		</div>
		<div class="colset event-detail cf">
			<div class="col-sidebar">
				<div class="instagram">
					<a href="<?php echo BASEURL.'/event.php?event='.$eid; ?>"><span>
						<?php $hashtag = (strlen($event['hashtag']) > 19) ? substr($event['hashtag'],0,17).'...' : $event['hashtag'];
						echo $hashtag; ?>
					</span></a>
				</div>
				<?php if($event['get_tweets']){?>
				<div class="twitter active">
					<a href="<?php echo BASEURL.'/event_tweet.php?event='.$eid; ?>">
						<span><?php $twitter = (strlen($event['twitter']) > 19) ? substr($event['twitter'],0,17).'...' : $event['twitter'];
						echo $twitter; ?></span>
					</a>
				</div>
				<?php  } ?>
			</div>
			<div class="col-main">
				<div id="mainbox">
					<div class="insta-content content-area">
						<div class="twitterfeed">
							<?php
							$tw = new TwitterOAuth($settings);
							$params = array(
								'q' => '#'.$event['twitter'].' -RT',
								'count' => 15,
								'include_entities' => 'false',
								'exclude_replies' => true
							);
							$response = $tw->get('search/tweets', $params);
							foreach($response['statuses'] as $status){
								$strTweet = $status['text'];
								$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
								if(preg_match($reg_exUrl, $strTweet, $url)) {
									$strTweet = preg_replace($reg_exUrl, '<a href="'.$url[0].'">'.$url[0].'</a> ', $strTweet);
								}
								$strTweet = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1#<a href="http://twitter.com/search?q=%23\2">\2</a>', $strTweet);
								$strTweet = preg_replace('/(^|\s)@(\w*[a-zA-Z_]+\w*)/', '\1@<a href="http://twitter.com/\2">\2</a>', $strTweet);
							?>
								<div class="tweet-box cf">
									<form class="cf" method="post">
										<p class="tweet"><?php echo $strTweet; ?></p>
										<div class="tweeter left">
											<span class="profile-image">
												<img src="<?php echo $status['user']['profile_image_url']; ?>" alt="<?php echo $status['user']['name']; ?>" ?>
											</span>
											<strong><?php echo $status['user']['name']; ?></strong>
										</div>
										<input name="tid" type="hidden" value="<?php echo $status['id_str']; ?>" />
										<input name="tweet" type="hidden" value="<?php echo $status['text']; ?>" />
										<input name="user" type="hidden" value="<?php echo $status['user']['name']; ?>" />
										<input name="upic" type="hidden" value="<?php echo $status['user']['profile_image_url']; ?>" />
										<input class="button right small primary" type="submit" value="save" />
									</form>
								</div>
							<?php }; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="hidden" id="eventForm">
	<form action="<?php echo BASEURL; ?>/edit_event.php" enctype="multipart/form-data" method="post" name="create_event">
		<fieldset>
			<legend>Edit Event</legend>
			<div class="field">
				<label for="title">Event Title:</label>
				<input value="<?php echo $event['id']; ?>" name="id" type="hidden" />
				<input class="required" value="<?php echo $event['title']; ?>" type="text" id="title" name="title" />
			</div>
			<div class="field">
				<label for="description">Event Description:</label>
				<textarea class="required" name="description" id="description"><?php echo $event['description']; ?></textarea>
			</div>
			<div class="field">
				<label for="hashtag">Event Hashtag(Istagram):</label>
				<input type="text" value="<?php echo $event['hashtag']; ?>" id="hashtag" name="hashtag" class="required" />
			</div>
			<div class="field">
				<label><input type="checkbox" <?php echo $event['get_tweets'] ? "Checked" : ""; ?> id="get_tweets" name="get_tweets" /> Include Ttweets also?</label>
				
			</div>
			<div class="field">
				<label for="twitter">Twitter Hashtag:</label>
				<input type="text" id="twitter" value="<?php echo $event['twitter']; ?>" name="twitter" />
			</div>
			<div class="field">
				<input type="hidden" value="<?php echo $event['image']; ?>" name="oldimage" />
				<label for="image">Change Watermark:</label>
				<input type="file" id="image" name="image" />
			</div>
			<div class="action">
				<input type="submit" value="Update Event"/>
			</div>
		</fieldset>
	</form>
</div>
<?php include_once 'layouts/footer.php';  ?>
<body>
</html>