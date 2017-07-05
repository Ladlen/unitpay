<?
	# Авторизация
	if($_POST){
		# Почту ввели
		if(isset($_POST['email'])){
			# Пароль ввели
			if(isset($_POST['password'])){
				# Капчу ввели
				if(isset($_POST['captcha'])){
					# Пустая капча
					if(isset($_SESSION['captcha'])){
						# Капча верная
						if($_SESSION['captcha'] == $_POST['captcha']){
							# Запросы
							$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `users` WHERE `email` = '".mysqli_real_escape_string($this->connectMainBD, $_POST['email'])."' AND `sid` = '".intval(SID)."'");
							# Аккаунт существует
							if(mysqli_num_rows($SQL) > 0){
								# Запросы
								$USER = mysqli_fetch_array($SQL);
								$LOG = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `logs` WHERE `sid` = '".intval(SID)."' ORDER BY lid DESC LIMIT 1"));
								# Следующий лог
								$LID = ($LOG['lid'] + 1);
								# Пароль совпал
								if(md5($_POST['password']) == $USER['password']){
									# Параметры
									$_SESSION['id'] = $USER['uid'];
									$_SESSION['login'] = $USER['login'];
									# Запишем в успешные логи
									mysqli_query($this->connectMainBD, "INSERT INTO `logs` (`lid`, `sid`, `ip`, `login`, `status`) VALUES ('".intval($LID)."', '".intval(SID)."', '".mysqli_real_escape_string($this->connectMainBD, $_SERVER['REMOTE_ADDR'])."', '".mysqli_real_escape_string($this->connectMainBD, $USER['login'])."', '1')");
									# Редирект
									$this->redirect('/admin');
								# Неверный пароль
								} else {
									# Запишем в неудачные логи
									mysqli_query($this->connectMainBD, "INSERT INTO `logs` (`lid`, `sid`, `ip`, `login`, `status`) VALUES ('".intval($LID)."', '".intval(SID)."', '".mysqli_real_escape_string($this->connectMainBD, $_SERVER['REMOTE_ADDR'])."', '".mysqli_real_escape_string($this->connectMainBD, $USER['login'])."', '0')");
									# Ошибка
									$err = 'Неверный пароль, повторите попытку.';
								}
							# В базе не нашли
							} else $err = 'Аккаунт отсутствует в базе данных.';
						# Ошибка ввода капчи
						} else $err = 'Защитный код был указан не верно.';
					# Капчи не существует
					} else $err = 'Капча не была создана.';
				# Пустая капча
				} else $err = 'Поле Защита обязательно к заполнению.';
			# Пустой пароль
			} else $err = 'Поле Пароль обязательно к заполнению.';
		# Пустая почта
		} else $err = 'Поле Почта обязательно к заполнению.';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?=TITLE;?> - Авторизация</title>
		<link href="../assets/css/bootstrap.css" rel="stylesheet">
		<script type="text/javascript" src="../assets/css/jquery.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<style>
			body {
				background: url(http://s.shopsu.ru/assets/admin/img/bg-login.jpg) !important;
			}
			.form {
				background: white;
				width: 500px;
				height: 330px;
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
			<div class="form polaroid" style="margin-top: 12%;    height: 360px;">
				<legend style="text-align:center;"><?=TITLE;?> :: Авторизация</legend>
				<form class="form-horizontal" method="POST" action="/admin/login">
					<div class="control-group">
						<label class="control-label" for="inputEmail">Почта</label>
						<div class="controls">
							<div class="input-prepend input-append">
								<input type="email" id="inputEmail" name="email" value="<?=(isset($_POST['email']) ? $_POST['email'] : "");?>" />
								<span class="add-on">
									<i class="icon-envelope"></i>
								</span>
							</div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputPassword">Пароль</label>
						<div class="controls">
							<div class="input-prepend input-append">
								<input type="password" id="inputPassword" name="password" value="<?=(isset($_POST['password']) ? $_POST['password'] : "");?>" />
								<span class="add-on">
									<i class="icon-lock"></i>
								</span>
							</div>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<div class="img-polaroid" style="width: 210px; text-align: center;">
								<img src="/captcha" class="captcha" />
								<div style="float: right; position: relative; top: 2px; left: -6px;" onclick="captcha();">
									<i class="icon-refresh"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputCaptcha">Защита</label>
						<div class="controls">
							<div class="input-prepend input-append">
								<input type="text" id="inputCaptcha" name="captcha" />
								<span class="add-on">
									<i class="icon-lock"></i>
								</span>
							</div>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<input class="btn btn-primary" type="submit" value="Войти" />
							<button type="button" class="btn btn-primary"onclick="location.href = 'http://bill.shopsu.ru/login';">Забыли пароль?</button>
						</div>
					</div>
				</form>
			</div>
			<? if(isset($err)){ ?>
			<center>
				<div class="alert alert-error" style="width: 459px; position:relative; top:10px;"><?=$err;?></div>
			</center>
			<? } ?>
		</div>
		<script>
			function captcha(){
				$('.icon-refresh').addClass('active');
				$(".captcha").attr('src', '/captcha/?rnd='+Math.random());
				setTimeout(function(){
					$('.icon-refresh').removeClass('active');
				}, 1500);
			};
		</script>
	</body>
</html>