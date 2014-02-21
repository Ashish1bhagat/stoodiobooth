<?php include_once 'layouts/common.php';
$error_msg = "";
 
if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    } 
    $prep_stmt = "SELECT id FROM users WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
        }
    } else {
        $error_msg .= '<p class="error">Database error</p>';
    } 
    if (empty($error_msg)) {
        // Create a random salt
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
 
        // Insert the new user into the database 
        if ($insert_stmt = $mysqli->prepare("INSERT INTO users (username, email, password, salt) VALUES (?, ?, ?, ?)")) {
            $insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt);
            // Execute the prepared query.
            if (!$insert_stmt->execute()) {
                header('Location: ./register.php?err=Registration failure: INSERT');
            }
        }
		flash( 'msg', 'User Created Successfully', 'success' );
        header('Location: ./index.php');
    }
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>StudioBoothLogin</title>
	<?php include_once 'layouts/head.php';  ?>
	<script type="text/JavaScript" src="<?php echo BASEURL; ?>/js/sha512.js"></script> 
	<script type="text/JavaScript" src="<?php echo BASEURL; ?>/js/forms.js"></script>
</head>
<body>
<?php include_once 'layouts/header.php';  ?>
	
	<div class="login">
        <h1>Register with us</h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <ul>
            <li>Usernames may contain only digits, upper and lower case letters and underscores</li>
            <li>Emails must have a valid email format</li>
            <li>Passwords must be at least 6 characters long</li>
            <li>Passwords must contain
				<ul>
					<li>At least one upper case letter (A..Z)</li>
					<li>At least one lower case letter (a..z)</li>
					<li>At least one number (0..9)</li>
				</ul>
            </li>
            <li>Your password and confirmation must match exactly</li>
        </ul>
        <form action="<?php echo $curPage; ?>" method="post" name="registration_form">
			<fieldset>
				<div class="field">
					<label for=="username">Username:</label>
					<input type='text' name='username' id='username' />
				</div>
				<div class="field">
					<label for=="email">Email:</label>
					<input type="text" name="email" id="email" />
				</div>
				<div class="field">
					<label for=="password">Password:</label>
					<input type="password" name="password" id="password"/>
				</div>
				<div class="field">
					<label for=="confirmpwd">Confirm password:</label>
					<input type="password" name="confirmpwd" id="confirmpwd" />
				</div>
				<div class="action">
					<input type="button" value="Register" onclick="return regformhash(this.form, this.form.username, this.form.email, this.form.password, this.form.confirmpwd);" /> 
				</div>
			</fieldset>
        </form>
        <p>Return to the <a href="index.php">login page</a>.</p>
	</div>
	
<?php include_once 'layouts/footer.php';  ?>
<body>
</html>