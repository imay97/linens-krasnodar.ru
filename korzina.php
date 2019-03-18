<!DOCTYPE html>
<html>
	<head>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/script.js"></script>
		<script src="js/jquery.cookies.js"></script>
		<link rel="stylesheet" href="css/style.css">
			<?php session_start(); ?>
		<title>Корзина</title>
	</head>
	<body>
		<div id="window" onclick="close_window_reg()">
			
		</div>
		<div id="log_in"></div>
		<div id="header">
			<?php include_once('header.php'); ?>
		</div>
		<div id="boder">
			<div id="prise">
			<?php
			$db = new MyDB();
			$html = '';
			$session = session_id();
			$comm = $db->query("SELECT * FROM comm WHERE session = '$session'");
			while ($row = $comm->fetchArray()) {
				$ware = $row['ware'];
				$prise = $db->query("SELECT * FROM prise WHERE id = '$ware'");
				while ($r = $prise->fetchArray()) {
					$id = $r['id'];
					$name = $r['name'];
					$sort = $r['sort'];
					$cost = $r['cost'];
					$html.= "<div class=".$sort." id='$id' onclick="."'remove_korz($id)'"."><img src='img/".$sort.$id."_1.jpg'><p>$name</p><div id='cost'>$cost р</div></div>";
				}
			}
			echo $html;
			?>
			</div>
			<div id="sum">
				<p>Итого: </p>
				<?php
				$result = $db->query("SELECT ware FROM comm WHERE session = '$session'");
				while ($row = $result->fetchArray()) {
					$ware = $row['ware'];
					$sum = $sum + $db->querySingle("SELECT cost FROM prise WHERE id = '$ware'");
				}
				if($sum == null)$sum = 0;
				echo $sum.' руб';
				?>
			</div>
		</div>
		<div id="footer">
			&#169; iMay
		</div>
	</body>
</html>