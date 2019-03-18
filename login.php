<?php
	function valid_user($login){
		class MyDB extends SQLite3
		{
   			function __construct()
   			{
       			$this->open('database.db');
   			}
		}
		$db = new MyDB();
		$result = $db->query("SELECT * FROM users WHERE login = '$login'");
		$row = $result->fetchArray();
		if($row['name'] == '')return 1;
		else return 0;
		$db->close();
	}
	function reg($login, $password, $name, $re_password, $session){
		if(valid_user($login)){
			if($password == $re_password){
				if($name){
					if($login){
						$db = new MyDB();
						$db->query("INSERT INTO users (session, login, password, name) VALUES ('$session', '$login', '$password', '$name')");
						$db->close();
						$data = array('valid' => 'yes', 'name' => $name, 'session_id' => $session);
						echo json_encode($data);
						exit;
					}
					else {
						$data = array('valid' => 'Введите логин');
						echo json_encode($data);
						exit;
					}
				}
				else {
					$data = array('valid' => 'Введите имя');
					echo json_encode($data);
					exit;
				}
			}
			else {
				$data = array('valid' => 'Пароли не совпадают');
				echo json_encode($data);
				exit;
			}
		}
		else {
			$data = array('valid' => 'Пользователь существует');
			echo json_encode($data);
			exit;
		}
	}
	function log_in($login, $password){
		class MyDB extends SQLite3
		{
   			function __construct()
   			{
       			$this->open('database.db');
   			}
		}
		$db = new MyDB();
		$result = $db->query("SELECT name, session FROM users WHERE login = '$login' AND password = '$password'");
		if($row = $result->fetchArray()){
			if($row['session'] == 'gp71vaghrt1e5febds6dsr1p72')
			{
				$data = array('valid' => 'admin', 'name' => $row['name'], 'session_id' => $row['session']);
				echo json_encode($data);
				exit;
			}
			$session = $row['session'];
			$count = $db->querySingle("SELECT COUNT(*) as count FROM comm WHERE session = '$session'");
			$data = array('valid' => 'yes', 'name' => $row['name'], 'session_id' => $row['session'], 'count' => $count);
			echo json_encode($data);
			exit;
		}
		else {
			$data = array('valid' => 'no');
			echo json_encode($data);
			exit;
		}
		$db->close();
	}
	function new_sess(){
		$data = array('session_id' => session_create_id());
		echo json_encode($data);
		exit;
	}
	function add($prod_id, $session_id){
		if($session_id == 'gp71vaghrt1e5febds6dsr1p72')exit;
		class MyDB extends SQLite3
		{
   			function __construct()
   			{
       			$this->open('database.db');
   			}
		}
		$db = new MyDB();
		if($db->querySingle("SELECT COUNT(*) as count FROM comm WHERE session = '$session_id' AND ware = '$prod_id'") < 1){
			$db->query("INSERT INTO comm (session, ware) VALUES ('$session_id', '$prod_id')");
			$count = $db->querySingle("SELECT COUNT(*) as count FROM comm WHERE session = '$session_id'");
			echo $count;
			$db->close();
			exit;
		}
		else {
			$count = $db->querySingle("SELECT COUNT(*) as count FROM comm WHERE session = '$session_id'");
			echo $count;
			$db->close();
		}
		$db->close();
		echo $result;
	}
	function remove_korz($prod_id, $session){
		if($session_id == 'gp71vaghrt1e5febds6dsr1p72')exit;
		class MyDB extends SQLite3
		{
   			function __construct()
   			{
       			$this->open('database.db');
   			}
		}
		$db = new MyDB();
		if($db->exec("DELETE FROM comm WHERE ware = '$prod_id' AND session = '$session'")){
			$result = $db->query("SELECT ware FROM comm WHERE session = '$session'");
				while ($row = $result->fetchArray()) {
					$ware = $row['ware'];
					$sum = $sum + $db->querySingle("SELECT cost FROM prise WHERE id = '$ware'");
				}
			if($sum == null)$sum = 0;
			$count = $db->querySingle("SELECT COUNT(*) as count FROM comm WHERE session = '$session'");
			$data = array('value' => 'yes', 'sum' => $sum, 'count' => $count);
			echo json_encode($data);
			exit;
		}
	}
	function img($files, $sort, $name, $cost, $about, $session)
	{
		if($session != 'gp71vaghrt1e5febds6dsr1p72')
		{
			echo 'Нет доступа';
			exit;
		}
		class MyDB extends SQLite3
		{
				function __construct()
				{
   				$this->open('database.db');
				}
		}
		$db = new MyDB();
		$id = $db->querySingle("SELECT COUNT(*) as count FROM prise");
		copy($files['file1']['tmp_name'], 'img/'.$sort.($id+1).'_1'.'.jpg');
		copy($files['file2']['tmp_name'], 'img/'.$sort.($id+1).'_2'.'.jpg');
		copy($files['file3']['tmp_name'], 'img/'.$sort.($id+1).'_3'.'.jpg');
		copy($files['file4']['tmp_name'], 'img/'.$sort.($id+1).'_4'.'.jpg');
		if($db->exec("INSERT INTO prise(name, sort, cost, about) VALUES ('$name', '$sort', '$cost', '$about')")){
			$db->close();
			echo 'ok';
			exit;
		}
	}
	function valid($session)
	{
		if($session == 'gp71vaghrt1e5febds6dsr1p72')echo 'yes';
		exit;
	}
	function img_edit($file, $name, $session)
	{
		if($session != 'gp71vaghrt1e5febds6dsr1p72')
		{
			echo 'Нет доступа';
			exit;
		}
		if ( 0 < $file['file']['error'] ) {
        	echo 'Error: '.$file['file']['error'].'<br>';
        	exit;
    	}
    	else {
			if(copy($file['file']['tmp_name'], $name))
			{
				$data = array('value' => 'ok');
				echo json_encode($data);
				exit;
			}
    	}
	}
	function edit_name($name, $id, $session)
	{
		if($session != 'gp71vaghrt1e5febds6dsr1p72')
		{
			echo 'Нет доступа';
			exit;
		}
		class MyDB extends SQLite3
		{
				function __construct()
				{
   					$this->open('database.db');
				}
		}
		$db = new MyDB();
		if($db->exec("UPDATE prise SET name = '$name' WHERE id = '$id'")){
			echo $name;
			exit;
		}
	}
	function edit_about($about, $id, $session)
	{
		if($session != 'gp71vaghrt1e5febds6dsr1p72')
		{
			echo 'Нет доступа';
			exit;
		}
		class MyDB extends SQLite3
		{
				function __construct()
				{
   					$this->open('database.db');
				}
		}
		$db = new MyDB();
		if($db->exec("UPDATE prise SET about = '$about' WHERE id = '$id'")){
			echo $about;
			exit;
		}
	}
	function remove($id, $session)
	{
		if($session != 'gp71vaghrt1e5febds6dsr1p72')
		{
			echo 'Нет доступа';
			exit;
		}
		class MyDB extends SQLite3
		{
				function __construct()
				{
   					$this->open('database.db');
				}
		}
		$db = new MyDB();
		$sort = $db->querySingle("SELECT sort FROM prise WHERE id = '$id'");
		if(@unlink('img/'.$sort.$id.'_1.jpg')){
			if(@unlink('img/'.$sort.$id.'_2.jpg')){
				if(@unlink('img/'.$sort.$id.'_3.jpg')){
					if(@unlink('img/'.$sort.$id.'_4.jpg')){
						if($db->exec("DELETE FROM prise WHERE id = '$id'")){
							if($db->exec("UPDATE sqlite_sequence SET seq = seq - 1 WHERE  name = 'prise'")){
								echo 'yes';
								exit;
							}
						}
					}
				}
			}
		}
	}
	if($_POST['type'] == 'login')log_in($_POST['login'], $_POST['password']);
	if($_POST['type'] == 'reg')reg($_POST['login'], $_POST['password'], $_POST['name'], $_POST['re_password'], $_POST['session_id']);
	if($_POST['type'] == 'new_sess')new_sess();
	if($_POST['type'] == 'add')add($_POST['prod_id'], $_POST['session_id']);
	if($_POST['type'] == 'remove_korz')remove_korz($_POST['prod_id'], $_POST['session']);
	if(isset($_POST['name_new']))img_edit($_FILES, $_POST['name_new'], $_POST['session']);
	else if(isset($_POST['name']) and isset($_POST['cost']))img($_FILES, $_POST['sort'], $_POST['name'], $_POST['cost'], $_POST['about'], $_POST['session']);
	if($_POST['type'] == 'valid')valid($_POST['session']);
	if($_POST['type'] == 'edit_name')edit_name($_POST['name'], $_POST['id'], $_POST['session']);
	if($_POST['type'] == 'edit_about')edit_about($_POST['about'], $_POST['id'], $_POST['session']);
	if($_POST['type'] == 'remove')remove($_POST['id'], $_POST['session']);
?>