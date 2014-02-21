<?php 
/**
 * These are the database login details
 */  
define("BASEURL", "http://localh.ost/stoodiobooth");     // The host you want to connect to.
define("BASEPATH", getenv("DOCUMENT_ROOT")."/stoodiobooth");     // The path you want to connect to.
define("HOST", "localhost");     // The host you want to connect to.
define("USER", "root");    // The database username. 
define("PASSWORD", "");    // The database password. 
define("DATABASE", "studio");    // The database name.
 
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "user");
define("SECURE", true);

$ins_cid = "836f26660d5e4ae6bb5a0d1f7cf1c263";
$ins_secret = "36370765f41145c3bc12cea618a5e343";
$ins_wurl = "http://localh.ost/stoodiobooth/";
$ins_rurl = "http://localh.ost/stoodiobooth/";
$ins_code = "3ca87e9fa6004ac3a2983aa326ac8df4";
$ins_token = "353024490.836f266.911d6df7f2ae4912a82a2ba9f476e012";

$settings =  array(
	'consumer_key' => 'WreCBBMJpbIE7ztqalsXag',
	'consumer_secret' => 'TihSKiBC6IHDn8ZHJOwthd59tBP7paF8wmEIMbVtoI8',
	'oauth_token' => '113551524-NLJmq1sqHoNnZ4Vma06Hok0GE0d8Izx9LETfPcWp',
	'oauth_token_secret' => '0jD05yvzmVWoiv64TzNd4MjCdIJwSqAEWSC6YK1AyJ5QS',
	'output_format' => 'array'
);

session_start();

/* DB CONNECTION */
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

/* COMMON FUNCTIONS */
function sec_session_start() {
    $session_name = 'sec_session_id';
    $secure = SECURE;
    $httponly = true;
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
		flash( 'msg', 'Dafe session could not be started', 'error' );
        header('Location: '. BASEURL .'/index.php');
        exit();
    }
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    session_name($session_name);
    session_start();
    session_regenerate_id();
}
function login($email, $password, $mysqli) {
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM users WHERE email = ? LIMIT 1")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            if (checkbrute($user_id, $mysqli) == true) {
                return false;
            } else {
                if ($db_password == $password) {
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                    return true;
                } else {
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time) VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
function checkbrute($user_id, $mysqli) {
    $now = time();
    $valid_attempts = $now - (2 * 60 * 60); 
    if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id); 
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}
function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT password FROM users WHERE id = ? LIMIT 1")) {
			$stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}

function check_exists($field, $val, $table) {
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    $query = "SELECT COUNT(*) AS num_rows FROM $table WHERE $field = $val";
    if ($stmt = $mysqli->query($query)) {
        return $stmt->num_rows;
    }
    return 0;
}

function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    } 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url; 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        return '';
    } else {
        return $url;
    }
}
function flash( $name = '', $message = '', $class = 'success fadeout-message', $url = '' ){
    //We can only do something if the name isn't empty
    if( !empty( $name ) )
    {
        //No message, create it
        if( !empty( $message ) && empty( $_SESSION[$name] ) )
        {
            if( !empty( $_SESSION[$name] ) )
            {
                unset( $_SESSION[$name] );
            }
            if( !empty( $_SESSION[$name.'_class'] ) )
            {
                unset( $_SESSION[$name.'_class'] );
            }
 
            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $class;
        }
        //Message exists, display it
        elseif( !empty( $_SESSION[$name] ) && empty( $message ) )
        {
            $class = !empty( $_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'success';
            echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
        }
    }
	if( !empty( $url ) || $url != '' )
    {
		header('Location: '.$url);
		exit();
	}
}

function upload_image($img, $folder = ''){
	$date = date('YmdHis');
	$newImg = $date."_". $img["name"];
	if($folder != ''){
		$udir = BASEPATH.'/images/'.$folder;
	}else{
		$udir = BASEPATH.'/images';
	}
	if (!file_exists($udir)) {
		mkdir($udir, 0777, true);
		mkdir($udir."/thumb", 0777, true);
	}

	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $img["name"]);
	$extension = end($temp);
	if ( ($img["size"] < 20000000) && in_array($extension, $allowedExts) ){
		if ($img["error"] > 0){
			return "ERROR";
		}else{
			list($width, $height) = getimagesize($img["tmp_name"]);
			// check if the file is really an image
			if ($width == null && $height == null) {
				return "ERROR";
			}
			// resize if necessary
			if ($width >= 50 && $height >= 10) {
				$image = new Imagick($img["tmp_name"]);
				$image->thumbnailImage(50, 50);
				$image->writeImage($udir.'/thumb/'.$newImg);
			}
		
			move_uploaded_file($img["tmp_name"], $udir."/".$newImg);
			return $newImg;
		}
	}else{
		return "OVERSIZE";
	}
}
function delete_image($img , $folder = ''){
	if($img !=""){
		if($folder != ''){
			$udir = BASEPATH.'/images/'.$folder;
		}else{
			$udir = BASEPATH.'/images';
		}
		if (file_exists($udir."/".$img)){
			unlink($udir."/".$img);
		}
	}
}

$allowed = array('index.php','login.php', 'exit.php');
$curPage = esc_url($_SERVER['PHP_SELF']);
$IsAllowed = 'false';
foreach($allowed as $elm){
	$pos = strpos($curPage, $elm, 1);
	if($pos){
		$IsAllowed = 'true';
	}
}
if(login_check($mysqli) != true){
	$logged = false;
	if($IsAllowed == 'false'){
		flash('msg', 'You are not authorized to access this page, please login', 'success', BASEURL .'/index.php');
	}
}else{
	$logged = true;
}