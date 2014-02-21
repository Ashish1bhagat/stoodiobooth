<?php include_once 'layouts/common.php';
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
				<div class="instagram active">
					<a href="<?php echo BASEURL.'/event.php?event='.$eid; ?>"><span>
						<?php $hashtag = (strlen($event['hashtag']) > 19) ? substr($event['hashtag'],0,17).'...' : $event['hashtag'];
						echo $hashtag; ?>
					</span></a>
				</div>
				<?php if($event['get_tweets']){?>
				<div class="twitter">
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
						<?php
							$eid = $event['id'];
							if ($pstmt = $mysqli->prepare("SELECT * FROM event_photos WHERE eid = $eid")){
								$pstmt->execute();
								$res = $pstmt->get_result();
								if(!$res->num_rows){ ?>
									<div class="no-images">
										<h2>You dont have any photos rght now, Click below button to fetch images from instagram</h2>
										<a href="<?php echo BASEURL; ?>/instagram.php?type=gettag&tag=<?php echo $event['hashtag']; ?>&eid=<?php echo $eid; ?>" class="button primary large" id="instafetch">Fetch Images from Instagram</a>
									</div>
								<?php }else{ ?>
									<ul class="instafeed cf">
									<?php while($photo = $res->fetch_assoc()){ ?>
										<li>
											<div class="image">
												<a class="fancy" href="<?php echo BASEURL.'/images/events/'.$eid.'/'.$photo['photo']; ?>" rel="gal_<?php echo $eid; ?>">
													<img class="media" src="<?php echo BASEURL.'/images/events/'.$eid.'/'.$photo['photo']; ?>"/>
												</a>
												<div class="content">
													<div class="comment"><?php echo $photo['caption']; ?></div>
												</div>
											</div>
										</li>
									<?php } ?>
									</ul>
									<a href="<?php echo BASEURL; ?>/instagram.php?type=gettag&tag=<?php echo $event['hashtag']; ?>&eid=<?php echo $eid; ?>" class="button primary large" id="instafetch">Fetch Images from Instagram</a>
								<?php }
							}
						?>
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