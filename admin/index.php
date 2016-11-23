<?php
include_once '../template/_header.php';

if (!isset($_SESSION['id'])) {
    header('location:'.siteurl.'login.php');
}else {
    if ($_SESSION['type']!=1) {
        header('location:'.siteurl.'template/permission.php');
    }
}
include '../Model/Database.php';
$objDb=new Database();
$objDb->connect();
$pdf=$objDb->count('pdf');
$monhoc=$objDb->count('monhoc');
$user=$objDb->count('user');
?>
<div class="container" style="padding-top: 20px;padding-bottom: 20px;">
	<ol class="breadcrumb">
		<li class="active">Control Panel</li>
	</ol>
	<div class="row">
		<div class="col-md-3">
			<div class="widget red text-center">
				<i class="fa fa-file-pdf-o"></i>
				<div class="wcontent cwhite">
					<a href="uploadpdf.php"><strong><h2><?php echo $pdf; ?></h2></strong>
					PDF</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="widget green text-center">
				<i class="fa fa-user"></i>
				<div class="wcontent cwhite">
					<a href="usermn.php"><strong><h2><?php echo $user; ?></h2></strong>
					Người dùng</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="widget violet text-center">
				<i class="fa fa-book"></i>
				<div class="wcontent cwhite">
					<a href="import.php"><strong><h2><?php echo $monhoc; ?></h2></strong>
					Môn Học</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="widget orange text-center">
				<i class="fa fa-cog"></i>
				<div class="wcontent cwhite">
					Cấu hình hệ thống
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include '../template/_footer.php';
?>