<?php include_once 'layouts/common.php';
if (isset($_GET)){
    $eid = filter_input(INPUT_GET, 'event', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, 'event', FILTER_SANITIZE_NUMBER_INT) : 0;
	if($eid){
		if (!$delete = $mysqli->query("DELETE FROM events WHERE id = $eid")){
			flash('msg', 'Failed to delete Event, please try again', 'error', BASEURL .'/dashboard.php');
		}
		flash( 'msg', 'Event Deleted Success fully', 'success', BASEURL .'/dashboard.php');
	}else{
		flash( 'msg', 'Event not specified', 'error', BASEURL .'/dashboard.php');
	}
} ?>