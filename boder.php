<div id="sort">
	<div>Фильтры</div>
	<select>
		<option onclick="sort(0)" >Весь товар</option>
		<option onclick="sort(1)" >Простыни</option>
		<option onclick="sort(2)" >Наволочки</option>
		<option onclick="sort(3)" >Пододеяльники</option>
	</select>
</div>
<div id="prise">
<?php
	$db = new MyDB();
	$prise = '';
	try {
		$results = $db->query("SELECT * FROM prise");
		while ($row = $results->fetchArray()) {
			$id = $row['id'];
			$name = $row['name'];
			$sort = $row['sort'];
			$cost = $row['cost'];
			$prise.= "<div class=".$sort."><a href='product.php?id=".$id."&sort=".$sort."'><img src='img/".$sort.$id."_1.jpg'><p>$name</p><div id='cost'>$cost р</div></a></div>";
		}
		echo $prise;
	}
	catch (Exception $ex){
	}
	$db->close();
	?>
</div>