	<? if(Defined('GID')){ ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `gifts` WHERE `sid` = '".intval(SID)."' AND `gid` = '".intval(GID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $GIFT = mysqli_fetch_array($SQL); ?>
	<?
		# Участники
		$obj = json_decode($GIFT['users'], true);
		# Количество
		$count = count($obj);
		# Победитель не розыгран
		if($GIFT['winner'] == "" && $GIFT['time'] < time()){
			# Вызначим победителя
			$winner = $obj[rand(1, $count)];
			# Победитель
			mysqli_query($this->connectMainBD, "UPDATE `gifts` SET `winner` = '".mysqli_real_escape_string($this->connectMainBD, $winner)."' WHERE `sid` = '".intval(SID)."' AND `gid` = '".intval($GIFT['gid'])."'");
		}
		# Пришли с ulogin
		if(isset($_POST['token'])){
			# Запросы к uLogin
			$s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
			$user = json_decode($s, true);
			$found = false;
			foreach($obj as $id => $a){
				if($a == $user['identity']){
					$found = true;
				}
			}				
			# Поиск пользователя в массиве
			if($found == false){
				# Новый учасник
				$obj[] = $user['identity'];
				# Обновим в базе
				mysqli_query($this->connectMainBD, "UPDATE `gifts` SET `users` = '".json_encode($obj)."' WHERE `gid` = '".intval($GIFT['gid'])."'");
			}
		}
	?>
	<style>
		.main-tabs {
			background: #282424 none repeat scroll 0% 0%;
			float: left;
			display: table;
			position: relative;
			width: 784px;
			height: 32px;
		}
		.op {
			background-color: #00A9FF;
			text-align: center;
			color: #FFF;
			text-decoration: none;
			font-weight: bold;
			font-size: 11px;
			text-transform: uppercase;
			font-family: "Open Sans",sans-serif;
			width: 150px;
			padding: 10px;
		}
		.info {
			font-size: 12px;
			clear: both;
			padding: 15px;
			background: #F2F2F2 none repeat scroll 0% 0%;
			color: #383838;
		}
		.buy-block {
			width: 292px;
			height: 169px;
			margin-top: -271px;
			margin-left: 495px;
		}
		.gallery {
			position: relative;
			overflow: auto;
		}
		.gallery-block-one {
			margin-bottom: 10px;
			width: 475px;
			height: 267px;
		}
		.inf-left {
			margin-top: 10px;
			width: 475px;
			margin-right: 17px;
			float: left;
		}
		#sharebutton {
			font: bold 15px/40px arial;
			background: #5B7FA6 none repeat scroll 0% 0%;
			border: 1px solid #5B7FA6;
			color: #FFF;
			width: 233px;
			border-radius: 4px;
			text-align: center;
			margin-top: 45px;
			text-transform: uppercase;
			cursor: pointer;
		}
		#sharebutton:hover {
			background: #688CB3 none repeat scroll 0% 0%;
		}
		.gift_enter {
			font: bold 15px/40px arial;
			background: #00A9FF none repeat scroll 0% 0%;
			border: 1px solid #00A9FF;
			color: #FFF;
			width: 233px;
			border-radius: 4px;
			text-align: center;
			margin-top: 10px;
			text-transform: uppercase;
			cursor: pointer;
		}
	</style>
	<div class="big-info" style="width: 800px; margin: 0 auto; height: 600px;">
		<div class="inf-left">
			<div class="gallery-block-one">
				<div class="gallery" style="overflow: hidden; width: 475px; height: 272px;">
					<img src="<?=$GIFT['image'];?>" style="display:inline;height:267px;width:475px;">
				</div>
				<div style="width: 275px; height: 267px; padding:20px; background: #333333;" class="buy-block">
					<? if($GIFT['winner'] != ""){ ?>
					<div style="padding: 10px 20px;">
						<div style="color: #B0B0B0; text-align: center; padding-bottom: 30px; font-size: 16px; margin-top: 30px;"><b>Раздача завершена!</b></div>
						<a style="text-decoration: none;" href="<?=$GIFT['winner'];?>" target="_blank">
							<? $uid = explode("http://vk.com/", $GIFT['winner']); ?>
							<? $obj = json_decode(file_get_contents("http://api.vkontakte.ru/method/users.get?uids=".$uid[1]."&fields=photo"), true); ?>
							<div style="border-radius: 3px; padding: 5px; background: rgba(255, 255, 255, 0.09); height: 60px;">
								<img style="border-radius: 3px;" class="avavk" src="<?=$obj['response'][0]['photo'];?>" />
								<div style="margin-left: 65px; margin-top: -42px; color: #fff; font-weight: bold; text-decoration: none; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?=$obj['response'][0]['first_name'].' '.$obj['response'][0]['last_name'];?></div>
							</div>
						</a>
					</div>
					<? } else { ?>
					<div style="margin-top: 15px;">                           
						<span style="text-transform: uppercase;color: #999;">Осталось: <b><span style="color:#fff;" id="countdown"></span></b></span><br />				   
						<span style="text-transform: uppercase;color: #999;"> Участников:  <b style="color:#fff;"><?=intval($count);?></b></span>
					</div> 
					<div style="margin-top: 15px;">  
						<button class="clicked" id="sharebutton">Поделиться</button>
						<button style="display: none;" id="confirmbutton" onclick="confirmgift();">Участвовать</button>
					</div>
					<script src="//ulogin.ru/js/ulogin.js"></script>
					<div data-ulogin-inited="1452475801162" style="" id="uLogin" data-ulogin="display=buttons;fields=first_name,last_name,photo;providers=vkontakte;hidden=;redirect_uri=http://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>">
						<button class="gift_enter" id="confirmbuttongifts" data-uloginbutton="vkontakte">Участвовать</button>
					</div>
					<? } ?>
				</div>
			</div>
			<div id="goods">
				<nav class="main-tabs" style="width: 770px; margin-top: 10px;">
					<div class="op" style="float: left;">Описание раздачи</div>
					<div onclick="location.href='/gifts/'" class="op" style="float: right;background-color: #3E3F3F;cursor:pointer;">История раздач</div>
					<div class="info">
						<b>Приз:</b> <?=$GIFT['gift'];?><br />
						<b>Итоги:</b> <?=Date('d.m.Y H:i', $GIFT['time']);?><br /><br />
						<?=$GIFT['desc'];?><br />
						<b>Как участвовать:</b><br /><br />
						1. Поделиться данной страницей с друзьями ВКонтакте.<br />
						2. Подтвердить участие, нажатием кнопки “Участвовать”.<br />
						3. Ждать результатов раздачи.<br /><br />
						Нажимая на кнопку “Участвовать”, вы соглашаетесь предоставить нашему сайту свои имя, фамилию, аватарку и ссылку от профиля ВК.<br /><br />
						<b>Требования:</b><br /><br />
						1. Состоять в нашей группе ВКонтакте. <a target="_blank" href="<?=$GIFT['vk'];?>">Подписаться!</a><br />
						2. 15 суток с момента регистрации вашего ВК профиля.<br />
						3. Минимум 15 друзей в вашем профиле ВК. Не должно быть скрытых друзей.<br />
						4. Страница ВК должна быть открыта "для всех" (Настройки &gt; Приватность: Кому в интернете видна моя страница - ВСЕМ).<br />
						5. Обязательное нажатие кнопок “Поделиться” и “Участвовать” соответственно.<br />
						6. Браузер не должен блокировать всплывающие окна репоста из ВК на нашем сайте (adblock может быть тому причиной).<br />
						7. Одна раздача – один победитель. Наша честная система выбора победителя определяет счастливчика случайным образом (рандомно) среди участников, которые соответствуют требованиям раздачи. Это значит, что у всех есть равные шансы на победу!<br /><hr />
						<b>Как получить приз:</b><br /><br />
						Если вы станете победителем в раздаче, то мы свяжемся с вами через ВК в течении 24 часов. <br />
						Не нужно нам писать самостоятельно, это не ускорит процесс получения приза.<p></p><br />
					</div>
				</nav>
			</div>
		</div>
	</div>
	<script>
		var sharedbutton;
		function callbackFunc(result){
			var link_id=result.response[0].id;
			var first_name=result.response[0].first_name;
			var last_name=result.response[0].last_name;
			var link_photo=result.response[0].photo_50;
			$.post('?do=gifts', { action: 'add', link_id: link_id, first_name: first_name, last_name: last_name, link_photo: link_photo }, function(data){
				alert(data);
				$('#sharelink').hide();
				$('#confirmlink').hide();
			});
		} 
		function link_get(){
			var link_url = $('#confirmurl').val();
			link_url = link_url.replace("http:\/\/vk.com\/","");
			link_url = link_url.replace("https:\/\/vk.com\/","");
			var script = document.createElement('SCRIPT');
			script.src = "https://api.vk.com/method/users.get?user_ids="+link_url+"&fields=photo_50&v=5.28&callback=callbackFunc&test_mode=1";
			document.getElementsByTagName("head")[0].appendChild(script);
		}
		$(document).ready(function(){
			$("#sharebutton").click(function() {
				$(this).addClass("clicked");
				$("#confirmbutton").prop("disabled", false);
				window.open("http://vk.com/share.php?url=http%3A%2F%2F012.bxpay.ru%2F%3Fdo%3Dgifts&title=%D0%A0%D0%B0%D0%B7%D0%B4%D0%B0%D1%87%D0%B0+%D0%A2%D0%B5%D1%81%D1%82%D0%BE%D0%B2%D1%8B%D0%B9+%D1%82%D0%BE%D0%B2%D0%B0%D1%80&description=Box+Pay+%28012%29+-+%D0%BF%D1%80%D0%B8%D0%BC%D0%B5%D1%80+%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%D0%B0&image=http://010.bxpay.ru/img/mine.png&noparse=true", "_blank", "scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=500, toolbar=0, status=0");
				sharedbutton = 1;
				$('#confirmbutton').hide();
				$('#confirmbuttongifts').show();
				return false;
			});
		});
		function confirmgift(){
			if(sharedbutton){
				$('#confirmbutton').hide();
				$('#confirmbuttongifts').show();
			} else {
				alert('Сначала поделитесь записью на стене!');
			}
		}
	</script>
	<script>
		StartCountDown("countdown","<?=Date("Y-m-d\TH:i:s+03:00", $GIFT['time']);?>") 
		function StartCountDown(myDiv,myTargetDate){
			var dthen = new Date(myTargetDate);
			var dnow = new Date("<?=Date("Y-m-d\TH:i:s+03:00", time());?>");
			ddiff  = new Date(dthen-dnow);
			gsecs  = Math.floor(ddiff.valueOf()/1000);
			CountBack(myDiv,gsecs);
		}
		function Calcage(secs, num1, num2){
			s = ((Math.floor(secs/num1))%num2).toString();
			if(s.length < 2){
				s = "0" + s;
			}
			return (s);
		}
		function CountBack(myDiv, secs){
			var DisplayStr;
			if(secs > 3600 * 24){
				var DisplayFormat = "%%D%% дн. %%H%%:%%M%%:%%S%%";
			} else {
				var DisplayFormat = "%%H%%:%%M%%:%%S%%";
			}
			DisplayStr = DisplayFormat.replace(/%%D%%/g, Calcage(secs,86400,365));
			DisplayStr = DisplayStr.replace(/%%H%%/g,  Calcage(secs,3600,24));
			DisplayStr = DisplayStr.replace(/%%M%%/g,  Calcage(secs,60,60));
			DisplayStr = DisplayStr.replace(/%%S%%/g,  Calcage(secs,1,60));
			if(secs > 0){ 
				document.getElementById(myDiv).innerHTML = DisplayStr;
				setTimeout("CountBack('" + myDiv + "'," + (secs-1) + ");", 990);
			} else {
				document.getElementById(myDiv).innerHTML = "00:00:00";  
			}
		}
	</script>
	<? } else { ?>
	<div class="panel-heading">
		<center>
			<br /><font color="white">Раздача отсутствует в базе данных.</font>
		</center>
	</div>
	<? } ?>
	<? } else { ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `gifts` WHERE `sid` = '".intval(SID)."' AND `winner` != '' ORDER BY gid DESC LIMIT 3"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? while($row = mysqli_fetch_array($SQL)){ ?>
	<div class="panel">
		<div class="panel-heading">
			<h3 class="panel-title"> <a href="/gifts/<?=$row['gid'];?>"><?=$row['gift'];?></a></h3>
		</div>
		<div class="panel-body">
			<? $uid = explode("http://vk.com/", $row['winner']); ?>
			<? $obj = json_decode(file_get_contents("http://api.vkontakte.ru/method/users.get?uids=".$uid[1]."&fields=photo"), true); ?>
			<div class="left" style="width:30%;">
				<img src="<?=$row['image']?>" style="width:150px;" />
				<img style="cursor:pointer; position: relative; top: 17px; left: -152px;" src="<?=$obj['response'][0]['photo'];?>" onclick="location.href='<?=$row['winner'];?>';" />
			</div>
			<div class="right" style="left: 23%; float: left; top: -86px; position: relative;">
				<font><?=$row['desc'];?></font>
			</div>
		</div>
	</div>
	<? } ?>
	<? } else { ?>
	<div class="panel-heading">
		<center>
			<br /><font color="white">Раздачи отсутствуют в базе данных.</font>
		</center>
	</div>
	<? } ?>
	<? } ?>