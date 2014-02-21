<?php include_once 'layouts/instagram.class.php';
include_once 'layouts/common.php';
if(!empty($_POST['image'])){
	$image = $_POST['image'];
	$comment = isset($_POST['comment']) ? $_POST['comment'] : '';
	$comment = $mysqli->real_escape_string($comment);
	$eid = $_POST['eid'];
	$udir = BASEPATH.'/images/events/'.$eid;
	if (!file_exists($udir)) {
		mkdir($udir, 0777, true);
	}
	$fileParts = pathinfo($image);
	$image_name = $fileParts['basename'];
			
	$content = file_get_contents($image);
	file_put_contents($udir.'/'.$image_name, $content);
			
	if ($insert_stmt = $mysqli->prepare("INSERT INTO event_photos (eid, photo, caption) VALUES (?, ?, ?)")) {
		$insert_stmt->bind_param('iss', $eid, $image_name, $comment);
		if (!$insert_stmt->execute()) {
			$arr = array('passed'=>$i, 'status' => 'error', 'redirect' => BASEURL .'/event.php?event='.$eid);
			echo json_encode($arr);
			exit;
		}
	}
	$arr = array('status' => 'success', 'redirect' => BASEURL .'/event.php?event='.$eid);
	echo json_encode($arr);
	exit;
}



if(isset($_REQUEST['tag']) && isset($_REQUEST['eid'])){
$name = $_REQUEST['tag'];
$eid = $_REQUEST['eid'];

$instagram = new Instagram(array(
  'apiKey'      => $ins_cid,
  'apiSecret'   => $ins_secret,
  'apiCallback' => $ins_rurl // must point to success.php
));
$instagram->setAccessToken($ins_token);

if(isset($_REQUEST['maxid'])){
	$maxid = $_REQUEST['maxid'];
	$result = $instagram->getTagMedia($name, array('max_id'=>$maxid));
}else{
	$result = $instagram->getTagMedia($name);
}
if(empty($_REQUEST['maxid'])){
echo '<form class="hform" id="photoForm" action="'.$curPage.'" method="post"><input type="hidden" name="eid" value="'.$eid.'" /><ul class="instafeed cf">';
}
$i = 0;
if(isset($_REQUEST['ilt'])){
	$i = $_REQUEST['ilt'];
}
foreach ($result->data as $media) {
	$i++;
	// output media
	if ($media->type === 'video') {
	 /* // video
	  $poster = $media->images->low_resolution->url;
	  $source = $media->videos->standard_resolution->url;
	  $content .= "<video class=\"media video-js vjs-default-skin\" width=\"250\" height=\"250\" poster=\"{$poster}\"
				   data-setup='{\"controls\":true, \"preload\": \"auto\"}'>
					 <source src=\"{$source}\" type=\"video/mp4\" />
				   </video>";*/
	} else {
	$content = "<li>";
	  // image
	$id = $media->id;
	$image = $media->images->low_resolution->url;
	$simage = $media->images->standard_resolution->url;
	$avatar = $media->user->profile_picture;
	$username = $media->user->username;
	$comment = $media->caption ? $media->caption->text : "";
	
	$content .= "<label class=\"image-check\">&nbsp;</label>
				<input type=\"checkbox\" name=\"inta_image[{$i}][image]\" value=\"{$simage}\"/>
				<input type=\"checkbox\" name=\"inta_image[{$i}][comment]\" value=\"{$comment}\"/>
				<div class=\"image\"><img class=\"media\" src=\"{$image}\"/>";
	
	// create meta section
	$content .= "<div class=\"content\">
				   <div class=\"avatar\" style=\"background-image: url({$avatar})\"></div>
				   <p>{$username}</p>				  
				   <div class=\"comment\">{$comment}</div>
				 </div></div>";
	echo $content . "</li>";
	
	}
	// output media
}
$paging = $result->pagination->next_max_id;
echo '<li><a href="'.BASEURL.'/instagram.php?tag='.$name.'&eid='.$eid.'&maxid='.$paging.'&ilt='.$i.'" class="" id="paging"><img src="'.BASEURL.'/images/plus.png" /></a></li>';
if(empty($_REQUEST['maxid'])){
echo '</ul>';
echo '<div class="action"><input type="submit" class="button left primary" value="Save Photos" /><div class="status"></div></div></form>';
}
}
 ?>