<?php
	session_start();
	if (isset($_SESSION['id'])) {
		session_destroy();
	}else {
		header('location:login.php');
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Đăng xuất</title>
</head>
<body>
<script>
	var count=3;
	setInterval(function() {
		var second=document.getElementById('second');
		second.innerHTML=count;
		count--;
		if (count==0) {
			window.location = "login.php";
		}
	}, 1000);


</script>
	<?php
	echo "Đăng xuất thành công. Chuyển hướng trong ";
	?>
	<span id="second"></span>	
</body>
</html>
