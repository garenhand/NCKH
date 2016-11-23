<?php 
session_start();
define("siteurl", "http://localhost/khaosat.nuce.edu.vn/");

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8">
	<title>NCKH</title>
	<!-- Latest compiled and minified CSS & JS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo siteurl; ?>style.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<link href="<?php echo siteurl ?>css/bootstrap-editable.css" rel="stylesheet">
        <script src="<?php echo siteurl ?>js/bootstrap-editable.min.js"></script>
        <script type="text/javascript" src="<?php echo siteurl; ?>js/bootstrap-filestyle.min.js"></script>
        <script type="text/javascript" src="<?php echo siteurl; ?>js/jquery-3.1.0.min.js"></script>
    

    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" sizes="32x32" href="<?php echo siteurl ?>favicon.ico">
</head>
<body>
	<div id="wrapper">
		<div class="container" id="header">
		<img src="<?php echo siteurl; ?>img/header.jpg" class="img-responsive" alt="Image">
		
	</div>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container" id="navbar">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
	
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav" id="navmenu">
			        <li><a href="#"><i style="font-size: 20px;" class="fa fa-home" aria-hidden="true"></i></a> </li>
			        <li><a href="#">Giới thiệu</a> </li>
			        <li><a href="#">Dành cho sinh viên</a>
			        </li>

			        <li><a href="#">Dành cho cán bộ</a>
			        </li>
			        <li><a href="#">Dành cho giảng viên</a>
			        </li>
			        <li><a href="#">Thành viên</a>
			        </li>
			        <li><a href="#">Liên hệ</a> </li>
				</ul>
				<div class="pull-right">
					<?php if (isset($_SESSION['name'])) {
					?>


						<div class="dropdown">
						  <button class="btn btn-link dropdown-toggle" style="color: white" type="button" data-toggle="dropdown"><?php echo $_SESSION['name'] ?>
						  <span class="caret"></span></button>
						  <ul class="dropdown-menu">
						    <?php
						    	if ($_SESSION['type']==1) {
						    		?>
									<li><a href="<?php echo siteurl ?>admin">Admin Panel</a></li>
						    		<?php
						    	}

						    ?>
						    <li><a href="<?php echo siteurl ?>user">Hồ sơ</a></li>
						    <li><a href="<?php echo siteurl; ?>logout.php">Đăng xuất</a></li>
						  </ul>
						</div>
					<?php
					}
					 ?>

				</div>
				
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>