<?
	# Двухфакторная авторизация
	if($_POST){
		# Токен передан
		if(isset($_POST['token'])){
			# Поищем по токену юзера
			$a = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
			$obj = json_decode($a, true);			
			# Запросы
			$USER = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `users` WHERE `sid` = '".intval(SID)."' AND `uid` = '".intval($_SESSION['id'])."'"));
			# Профили
			$profiles = json_decode($USER['ulogin'], true);
			# Поиск юзера в массиве
			$AUTH = array_search($obj['identity'], $profiles);			
			# Такой есть
			if($USER['ulogin'] != "" && $AUTH !== FALSE){
				# Такой есть, авторизуем
				$_SESSION['ulogin'] = true;
				# Редирект в админку
				$this->redirect('/admin/');
			# Не привязан
			} else $err = 'Данный метод не привязан.';
		# uLogin ошибка
		} else $err = 'Токен авторизации не передан.';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?=TITLE;?> - uLogin</title>
		<link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css" rel="stylesheet">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	</head>
	<body>
		<style>
			body {
				background: url(http://s.shopsu.ru/assets/admin/img/bg-login.jpg) !important;
			}
			.form {
				background: white;
				width: 500px;
				height: 230px;
				margin: 0 auto;
			}
			.polaroid {
				padding: 4px;
				border-radius: 6px;
				border: 1px solid rgba(0, 0, 0, 0.2);
				box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
			}
			input {
				width: 179px;
			}
			.img-polaroid {
				padding: 4px;
				background-color: #FFF;
				border: 1px solid rgba(0, 0, 0, 0.2);
				box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
			}
			.active {
				-webkit-transform: rotate(720deg);
				-moz-transform: rotate(720deg);
				-o-transform: rotate(720deg);
			}
			.icon-refresh {
				cursor: pointer;
				-moz-transition: all 1s 0.1s ease-in;
				-o-transition: all 1s 0.1s ease-in;
				-webkit-transition: all 1s 0.1s ease-in;
			}
		</style>
		<div class="content">
			<div class="form polaroid" style="margin-top: 12%;">
				<legend style="text-align:center;"><?=TITLE;?> :: uLogin</legend>
				<form class="form-horizontal" method="POST" action="/admin/two">
					<div class="control-group">
						<script src="http://ulogin.ru/js/ulogin.js"></script>
						<center>
							<br />Второй этап авторизации.<br /><br />
							<div id="uLogin" data-ulogin="display=panel;fields=first_name,last_name;providers=vkontakte,mailru,odnoklassniki,yandex;redirect_uri=<?='//'.$_SERVER['HTTP_HOST'].'/admin/two';?>"></div>
						</center>
					</div>
				</form>
			</div>
			<? if(isset($err)){ ?>
			<center>
				<div class="alert alert-error" style="width: 459px; position:relative; top:10px;"><?=$err;?></div>
			</center>
			<? } ?>
		</div>
	</body>
</html>