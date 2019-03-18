<!DOCTYPE html>
<html>
	<head>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/script.js"></script>
		<script src="js/jquery.cookies.js"></script>
		<link rel="stylesheet" href="css/style.css">
			<?php
				session_start();
				$id = $_GET['id'];
				$sort = $_GET['sort'];
			?>
		<title>Постельное бельё</title>
	</head>
	<body>
		<script>valid()</script>
		<div id="window" onclick="close_window_reg()">
			
		</div>
		<div id="log_in">
			
		</div>
		<div id="header">
			<?php include_once('header.php'); ?>
		</div>
		<div id="boder_content">
			<div id="img_product">
				<img id="main_img" src="img/<?php echo $sort.$id; ?>_1.jpg">
				<img src="img/mark.jpg" width="30px" id="mark_img" onclick="mark_img()">
				<div id="low_img">
					<img id="img1" src="img/<?php echo $sort.$id; ?>_1.jpg" onclick="show_img('img1')">
					<img id="img2" src="img/<?php echo $sort.$id; ?>_2.jpg" onclick="show_img('img2')">
					<img id="img3" src="img/<?php echo $sort.$id; ?>_3.jpg" onclick="show_img('img3')">
					<img id="img4" src="img/<?php echo $sort.$id; ?>_4.jpg" onclick="show_img('img4')">
				</div>
			</div>
			<?php
				
				try {
					$db = new MyDB();
					$results = $db->query("SELECT * FROM prise WHERE id = '$id'");
					while ($row = $results->fetchArray()) {
						$about = $row['about'];
						$name = $row['name'];
						$sort = $row['sort'];
						$cost = $row['cost'];
					}
				} catch (Exception $e) {
					echo $e;
				}
			?>
			<div id="content">
				<div id="title_content"><b><?php echo $name; ?></b><img src="img/mark.jpg" width="30px" id="mark_name" onclick="mark_name(<?php echo $id; ?>)"></div>
				<div id="about_content"><br><p><?php echo $about; ?></p><img src="img/mark.jpg" width="30px" onclick="mark_text(<?php echo $id; ?>)" id="mark_text"></div>
				<br>
				<div id="in_korzina" onclick="add(<?php echo $id; ?>)">В корзину</div>
				<div id="delete_content" onclick="remove(<?php echo $id; ?>)">Удалить</div>
			</div> 
		</div>
		<div id="footer">
			&#169; iMay
		</div>
	</body>
</html>