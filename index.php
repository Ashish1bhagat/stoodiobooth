<?php include_once 'layouts/common.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>StudioBooth Login</title>
	<?php include_once 'layouts/head.php';  ?>
	<script type="text/JavaScript" src="<?php echo BASEURL; ?>/js/sha512.js"></script> 
	<script type="text/JavaScript" src="<?php echo BASEURL; ?>/js/forms.js"></script>
</head>
<body>
<?php include_once 'layouts/header.php';  ?>
	
	<div class="login">
		<?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 
        <form action="login.php" method="post" name="login_form">
			<fieldset>
				<legend>Login to Admin Panel</legend>
				<div class="field">
					<label for=="email">Email:</label>
					<input type="email" id="email" name="email" />
				</div>
				<div class="field">
					<label for=="password">Password:</label>
					<input type="password" name="password" id="password"/>
				</div>
				<div class="action">
					<input type="button" value="Login" onclick="formhash(this.form, this.form.password);" />
				</div>
			</fieldset>
		</form>
	</div>
	
<?php include_once 'layouts/footer.php';  ?>
<body>
</html>