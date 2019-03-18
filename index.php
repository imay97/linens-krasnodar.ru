<!DOCTYPE html>
<html>
	<head>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/script.js"></script>
		<script src="js/jquery.cookies.js"></script>
		<link rel="stylesheet" href="css/style.css">
			<?php
				$user = ''; 
				session_start(); 
			?>
		<title>Постельное бельё</title>
	</head>
	<body>
		<div id="window" onclick="close_window_reg()">
			
		</div>
		<div id="log_in"></div>
		<div id="header">
			<?php include_once('header.php'); ?>
		</div>
		<div id="boder">
			<?php include_once('boder.php'); ?>
		</div>
		<div id="footer">
			&#169; iMay
		</div>
	</body>
</html>