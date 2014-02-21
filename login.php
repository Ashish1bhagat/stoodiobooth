<?php include_once 'layouts/common.php';
if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // The hashed password.
 
    if (login($email, $password, $mysqli) == true) {
		flash( 'msg', 'Welcome to Admin Panel', 'success', BASEURL .'/dashboard.php');
    } else {
		flash( 'msg', 'Login failed', 'error', BASEURL .'/index.php');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}