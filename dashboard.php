<?php include_once 'layouts/common.php';
if ($stmt = $mysqli->prepare("SELECT * FROM events")){
	$stmt->execute();
	$result = $stmt->get_result();
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
	<div class="dashboard">
		<div class="title-row">
			<a href="#eventForm" class="button fancy title-btn primary">Create New Event</a>
			<h1 class="title">Events</h1>
		</div>
		<?php if(!$result->num_rows){ ?>
		<div class="note">
			<p>No events created yet. <strong><a class="fancy" href="#eventForm">Create your first Event</a></strong></p>
		</div>
		<?php }else{ ?>
			<div class="data-table">
				<table class="dtable">
					<thead>
						<tr>
							<th width="200" colspan="2">Title</th>
							<th>Description</th>
							<th width="150">#Hashtag</th>
							<th width="150"></th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = $result->fetch_assoc()){ ?>
						<tr>
							<td width="50"><a href="#"><span class="thumb"><img src="<?php echo BASEURL."/images/events/thumb/".$row['image']; ?>" /></span></a></td>
							<td><a href="#"><strong><?php echo $row['title']; ?></a><strong></td>
							<td><?php echo $row['description']; ?></td>
							<td><?php echo $row['hashtag']; ?></td>
							<td>
								<a href="<?php echo BASEURL; ?>/event.php?event=<?php echo $row['id']; ?>" class="view">View</a>
								<a href="<?php echo BASEURL; ?>/delete_event.php?event=<?php echo $row['id']; ?>" class="delete">Delete</a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		<?php } ?>
	</div>
<?php include_once 'layouts/footer.php';  ?>
<div class="hidden" id="eventForm">
	<form action="<?php echo BASEURL; ?>/add_event.php" enctype="multipart/form-data" method="post" name="create_event">
		<fieldset>
			<legend>Create new Event</legend>
			<div class="field">
				<label for="title">Event Title:</label>
				<input class="required" type="text" id="title" name="title" />
			</div>
			<div class="field">
				<label for="description">Event Description:</label>
				<textarea class="required" name="description" id="description"></textarea>
			</div>
			<div class="field">
				<label for="hashtag">Event Hashtag(Istagram):</label>
				<input type="text" id="hashtag" name="hashtag" class="required" />
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
<body>
</html>