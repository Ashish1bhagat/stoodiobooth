<header class="cf" id="header">
	<div class="logo">
		<a href="<?php echo BASEURL;?>/dashboard.php"><img src="<?php echo BASEURL;?>/images/studiobooth.png" /></a>
	</div>
	<?php if($logged){ ?>
	<nav id="nav">
		<ul class="menu">
			<li><a href="<?php echo BASEURL; ?>/add_event.php">Events</a></li>
			<li><a href="<?php echo BASEURL; ?>/logout.php">Logout</a></li>
		</ul>
	</nav>
	<?php } ?>
</header>
<?php flash('msg' ); ?>
<section class="wrapper">