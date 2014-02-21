<?php include_once 'layouts/common.php';
flash( 'msg', 'You have successfully logged out', 'success' );
header('Location: '. BASEURL .'/index.php');