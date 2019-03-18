function window_reg(type)
{
	if(type == 0){
		$('#log_in').html('<label for="login">Логин</label><br>\
							<input type="text" id="login"><br>\
							<label for="password">Пароль</label><br>\
							<input type="password" id="password"><br>\
							<input type="submit" value="Войти" onclick="login()">\
							<input type="submit" value="Регистрация" onclick="reg()">')
		$('#window').css('display', 'block');
		$('#log_in').css('display', 'block');
	}
	if(type == 1){
		reg()
		$('#window').css('display', 'block');
		$('#log_in').css('display', 'block');
	}
}
function close_window_reg(){
	$('#window').css('display', 'none');
	$('#log_in').css('display', 'none');
}
function remove_korz(id)
{
	$.ajax({
		url: 'login.php',
		type: 'POST',
		data: 'type=remove_korz'+'&prod_id='+id+'&session='+$.cookie('PHPSESSID'),
		success: function(data)
		{
			result = jQuery.parseJSON(data);
			if(result['value'] == 'yes')
				{
					$('#'+id).remove();
					if(result['sum'] == null)$('#sum').html('<p>Итого: </p>' + '0 руб');
					else $('#sum').html('<p>Итого: </p>'+result['sum'] + 'руб');
					$('#count_korzina').html(result['count']);
				}
		}
	});
}
function login()
{
	$.ajax({
		url: 'login.php',
		type: 'POST',
		data: 'login='+$('#login').val()+'&password='+$('#password').val()+'&type=login',
		success: function(data)
		{
			result = jQuery.parseJSON(data);
			if(result['valid'] == 'admin')
			{
				alert('Здравствуйте, Снежана Алексеевна\nЗдесь вы можете отредактировать товары')
				$('#window').css('display', 'none');
				$('#log_in').css('display', 'none');
				$('#in_korzina').css('display', 'none');
				$('#delete_content').css('display', 'block');
				$('#mark_img').css('display', 'block');
				$('#mark_text').css('display', 'block');
				$('#mark_name').css('display', 'block');
				$('#log').html(result['name']+'   '+'<div onclick="exit()">Выйти</div>')
				$('#korzina').html('<div id="admin" onclick="admin_panel()">Добавить товар</div>')
				$.cookie('PHPSESSID', result['session_id'], {expires: 365});
			}
			if(result['valid'] == 'yes'){
				$('#window').css('display', 'none');
				$('#log_in').css('display', 'none');
				$('#log').html(result['name']+'   '+'<div onclick="exit()">Выйти</div>')
				$('#count_korzina').html(result['count'])
				$.cookie('PHPSESSID', result['session_id'], {expires: 365});
			}
				else $('#log_in').html('Неверный логин или пароль<br>\
											<label for="login">Логин</label><br>\
											<input type="text" id="login"><br>\
											<label for="password">Пароль</label><br>\
											<input type="password" id="password"><br>\
											<input type="submit" value="Войти" onclick="login()">\
											<input type="submit" value="Регистрация" onclick="reg()">')
		}
	});
}
function reg()
{
	$('#log_in').html('<label for="name">Имя</label><br>\
						<input type="text" id="name"><br>\
						<label for="login">Логин</label><br>\
						<input type="text" id="login"><br>\
						<label for="password">Пароль</label><br>\
						<input type="password" id="password"><br>\
						<label for="re_password">Повторите пароль</label><br>\
						<input type="password" id="re_password"><br>\
						<input type="submit" value="Войти" onclick="back()">\
						<input type="submit" value="Регистрация" onclick="registration()">')
}
function back()
{
	$('#log_in').html('<label for="login">Логин</label><br>\
						<input type="text" id="login"><br>\
						<label for="password">Пароль</label><br>\
						<input type="password" id="password"><br>\
						<input type="submit" value="Войти" onclick="login()">\
						<input type="submit" value="Регистрация" onclick="reg()">')
}
function registration()
{
	$.ajax({
		url: 'login.php',
		type: 'POST',
		data: 'login='+$('#login').val()+'&password='+$('#password').val()+'&type=reg'+'&re_password='+$('#re_password').val()+'&name='+$('#name').val()+'&session_id='+$.cookie('PHPSESSID'),
		success: function(data)
		{
			result = jQuery.parseJSON(data);
			if(result['valid'] == 'yes'){
				$.cookie('PHPSESSID', result['session_id'], {expires: 365})
				alert('Вы успешно зарегистрировались')
				$('#window').css('display', 'none');
				$('#log_in').css('display', 'none');
				$('#log').html(result['name']+'   '+'<div onclick="exit()">Выйти</div>')
			}
				else $('#log_in').html(result['valid']+'<br><label for="name">Имя</label><br>\
														<input type="text" id="name"><br>\
														<label for="login">Логин</label><br>\
														<input type="text" id="login"><br>\
														<label for="password">Пароль</label><br>\
														<input type="password" id="password"><br>\
														<label for="re_password">Повторите пароль</label><br>\
														<input type="password" id="re_password"><br>\
														<input type="submit" value="Войти" onclick="back()">\
														<input type="submit" value="Регистрация" onclick="registration()">')

		}
	});
}
function exit()
{
	$('#in_korzina').css('display', 'block');
	$('#delete_content').css('display', 'none');
	$('#mark_img').css('display', 'none');
	$('#mark_text').css('display', 'none');
	$('#mark_name').css('display', 'none');
	$.ajax({
		url: 'login.php',
		type: 'POST',
		data: 'type=new_sess',
		success: function(data)
		{
			result = jQuery.parseJSON(data);
			$.cookie('PHPSESSID', result['session_id'], {expires: 365})
		}
	})
	$('#log_in').html('<label for="login">Логин</label><br>\
						<input type="text" id="login"><br>\
						<label for="password">Пароль</label><br>\
						<input type="password" id="password"><br>\
						<input type="submit" value="Войти" onclick="login()">\
						<input type="submit" value="Регистрация" onclick="reg()">')
	$('#log').html("<div onclick='window_reg(0)'>Войти</div><div onclick='window_reg(1)'>Регистрация</div>")
	$('#count_korzina').html(0)
	$('#admin').remove()
	$('#korzina').html("<a href='korzina.php'><img src='img/korzina.png'><div id='count_korzina'></div></a>")
}
function add(id)
{
	$.ajax({
		url: 'login.php',
		type: 'POST',
		data: '&session_id='+$.cookie('PHPSESSID')+'&prod_id='+id+'&type=add',
		success: function(data)
		{
			$('#count_korzina').html(data)
		}
	})
}
function admin_panel()
{
	$('#log_in').html('<label for="name_prod">Наименование товара</label><br>\
							<input type="text" id="name_prod"><br>\
							<label for="cost_prod">Цена</label><br>\
							<input type="text" id="cost_prod"><br>\
							<label for="type_prod">Тип товара</label><br>\
							<select id="type_prod">\
								<option value="p">Простыни</option>\
								<option value="n">Наволочки</option>\
								<option value="pd">Пододеяльники</option>\
							</select><br>\
							<label for="about_prod">О товаре</label><br>\
							<textarea id="about_prod"></textarea><br>\
							<input id="img_upload1" type="file" multiple="true" accept=".jpg">\
							<input id="img_upload2" type="file" multiple="true" accept=".jpg">\
							<input id="img_upload3" type="file" multiple="true" accept=".jpg">\
							<input id="img_upload4" type="file" multiple="true" accept=".jpg">\
							<input type="submit" value="Отправить" onclick="upload()">')
	$('#window').css('display', 'block');
	$('#log_in').css('display', 'block');
}
function upload()
{
	var file1 = $('#img_upload1').prop('files')[0];
	var file2 = $('#img_upload2').prop('files')[0];
	var file3 = $('#img_upload3').prop('files')[0];
	var file4 = $('#img_upload4').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file1', file1);
    form_data.append('file2', file2);
    form_data.append('file3', file3);
    form_data.append('file4', file4);
    form_data.append('sort', $('#type_prod').val())
    form_data.append('name', $('#name_prod').val())
    form_data.append('cost', $('#cost_prod').val())
    form_data.append('about', $('#about_prod').val())
    form_data.append('session', $.cookie('PHPSESSID'))
    $.ajax({
                url: 'login.php',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(data){
                    if(data == 'ok')
                    {
                    	alert('Товар добавлен\nстраница обновиться');
                    	$('#window').css('display', 'none');
						$('#log_in').css('display', 'none');
						location.reload();
                    }
                }
     });
}
function sort(type)
{
	if(type == 0)
	{
		$('.p').css('display', 'block');
		$('.n').css('display', 'block');
		$('.pd').css('display', 'block');
	}
	if(type == 1)
	{
		$('.p').css('display', 'block');
		$('.n').css('display', 'none');
		$('.pd').css('display', 'none');
	}
	if(type == 2)
	{
		$('.p').css('display', 'none');
		$('.n').css('display', 'block');
		$('.pd').css('display', 'none');
	}
	if(type == 3)
	{
		$('.p').css('display', 'none');
		$('.n').css('display', 'none');
		$('.pd').css('display', 'block');
	}
}

function valid()
{
	$.ajax({
        url: 'login.php',
        data: 'type=valid'+'&session='+$.cookie('PHPSESSID'),
        type: 'POST',
        success: function(data)
        {
        	if(data == 'yes')
        	{
        		$('#in_korzina').css('display', 'none');
				$('#delete_content').css('display', 'block');
				$('#mark_img').css('display', 'block');
				$('#mark_text').css('display', 'block');
				$('#mark_name').css('display', 'block');
        	}
        }
     });
}
function mark_img()
{
	$('#log_in').html('<input id="img_upload" type="file" enctype="multipart/form-data" accept=".jpg">\
						<input type="submit" value="Отправить" onclick="upload_img()">');
	$('#window').css('display', 'block');
	$('#log_in').css('display', 'block');
}
function upload_img()
{
	name = $('#main_img').attr('src');
	var file_data = $('#img_upload').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('name_new', name);
    form_data.append('session', $.cookie('PHPSESSID'));
    $.ajax({
                url: 'login.php',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'post',
                success: function(data){
                    result = jQuery.parseJSON(data);
                    if(result['value'] == 'ok')
                    {
                    	alert('Страница обновиться,\n что бы увидеть результат');
                    	location.reload();
                    	$('#window').css('display', 'none');
						$('#log_in').css('display', 'none');
                    }
                }
     });
}

function show_img(id)
{
	src = $('#'+id).attr('src');
	$('#main_img').attr('src', src);
}

function mark_name(id)
{
	$('#title_content b').html('<input type="text" id="new_name"><input type="submit" value="Заменить" onclick="edit_name('+id+')">');
}
function mark_text(id)
{
	$('#about_content p').html('<textarea id="new_about"></textarea><input type="submit" value="Заменить" onclick="edit_about('+id+')">');
}
function edit_name(id)
{
	new_name = $('#new_name').val();
	$.ajax({
		url: 'login.php',
		type: 'POST',
		data: 'type=edit_name'+'&name='+new_name+'&id='+id+'&session='+$.cookie('PHPSESSID'),
		success: function(data)
		{
			$('#title_content b').html(data);
		}
	});
}
function edit_about(id)
{
	new_about = $('#new_about').val();
	$.ajax({
		url: 'login.php',
		type: 'POST',
		data: 'type=edit_about'+'&about='+new_about+'&id='+id+'&session='+$.cookie('PHPSESSID'),
		success: function(data)
		{
			$('#about_content p').html(data);
		}
	});
}
function remove(id)
{
	$.ajax({
		url: 'login.php',
		type: 'POST',
		data: 'type=remove'+'&id='+id+'&session='+$.cookie('PHPSESSID'),
		success: function(data)
		{
			if(data == 'yes'){
				alert('Товар удалён');
				location.href = "index.php";
			}
		}
	});
}