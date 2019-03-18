<a href="#"><img id="ava" src="img/ava.png"></a>
<ul id="list">
	<li><a href="index.php">Главная</a></li>
	<li>Контакты</li>
	<li>Акции</li>
	<li>Доставка и оплата</li>
	<li>О нас</li>
	<li id="log"><?php
		class MyDB extends SQLite3
		{
			function __construct()
			{
				$this->open('database.db');
			}
		}
		$db = new MyDB();
		$session = session_id();
		if($session == 'gp71vaghrt1e5febds6dsr1p72')
		{
			$user = 'admin';
		}
		try {
			$result = $db->query("SELECT name FROM users WHERE session = '$session'");
			$row = $result->fetchArray();
			if($row['name'] != null)echo "<div>".$row['name']."    "."</div><div onclick='exit()'>Выйти</div>";
			else{
				echo '<div onclick="window_reg(0)">Войти</div><div onclick="window_reg(1)">Регистрация</div>';
			}
		}
		catch (Exception $ex){
		}
		$db->close();
	?>
	</li>
	<li id="korzina">
		<?php
			if($user == 'admin')
			{
				echo "<div id='admin' onclick='admin_panel()'>Добавить товар</div>";
			}
			else{
				echo "<a href='korzina.php'>
					<img src='img/korzina.png'>
					<div id='count_korzina'>";
					$db = new MyDB();
					$session = session_id();
					try {
						$count = $db->querySingle("SELECT COUNT(*) as count FROM comm WHERE session = '$session'");
						echo $count;
					}
					catch (Exception $ex){
						}
					$db->close();
					echo "</div></a>";
			}
		?>
	</li>
</ul>