	<ul class="breadcrumb">
		<li><a href="/admin/">Главная</a> <span class="divider">/</span></li>
		<? if(Defined('EID') || Defined('UID')){ ?>
		<li><a href="/admin/users">Пользователи</a> <span class="divider">/</span></li>
		<li class="active"><?=Defined('EID') ? 'Редактирование' : 'Добавление';?> пользователя</li>
		<? } else { ?>
		<li class="active">Пользователи</li>
		<? } ?>
	</ul>
	<?		
		# Access Denied
		if($_SESSION['admPrivilege']['users'] == false){
			echo '<div class="alert alert-danger">У <b>Вас</b> отсутствуют права для данного раздела.</div>';
		} else {
			# Добавление и Редактирование пользователя
			if(Defined('EID') || Defined('UID')){
				# Редактирование
				if(Defined('EID')){
					# Запросы
					$USER = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `users` WHERE `sid` = '".intval(SID)."' AND `uid` = '".intval(EID)."'"));
					# Превилегии
					if($USER['privilege'] == ""){
						# Превилегии пользователя
						$privilege = Array();
						$array = Array("items", "orders", "pages", "categories", "statistics", "secure", "logs", "users", "settings", "codes", "gifts", "templates");
						# Массив с превилегиями
						foreach($array as $id => $name){
							$privilege[$name] = 1;
						}
					# Парсим
					} else {
						# Превилегии пользователя
						$privilege = json_decode($USER['privilege'], true);
					}
					# Аккаунты
					$ULOGIN = json_decode($USER['ulogin'], true);
				} else {
					$USER = false;
				}
	?>
	<script src="//ulogin.ru/js/ulogin.js"></script>
	<?
			if(Defined('EID')){
	?>
	<div id="uLogin" data-ulogin="display=panel;fields=first_name,last_name;providers=vkontakte,odnoklassniki,mailru,yandex;redirect_uri=http://<?=$_SERVER['HTTP_HOST'];?>/admin/users/edit/<?=EID;?>" style="display:none;"></div>
	<?
			}
	?>
	<form action="/admin/users/<?=(Defined('EID') ? 'edit/'.EID : 'add');?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<table class="table">
			<tbody>
				<tr>
					<td>Логин</td>
					<td>
						<input name="login" value="<?=(isset($_POST['login']) ? $_POST['login'] : $USER['login']);?>" class="form-control" type="text">
						<? if(isset($_POST['token'])){ ?>
						<?=(isset($_POST['login']) ? ($_POST['login'] == "" ? "<br/><font color=\"red\">Заполните поле Логин.</font>" : "") : "");?>
						<? } ?>
					</td>
				</tr>
				<tr>
					<td>Почта</td>
					<td>
						<input name="email" value="<?=(isset($_POST['email']) ? $_POST['email'] : $USER['email']);?>" class="form-control" type="email">
						<? if(isset($_POST['token'])){ ?>
						<?=(isset($_POST['email']) ? ($_POST['email'] == "" ? "<br/><font color=\"red\">Заполните поле Почта.</font>" : "") : "");?>
						<? } ?>
					</td>
				</tr>
				<tr>
					<td>Пароль</td>
					<td>
						<input name="password" value="<?=(isset($_POST['password']) ? $_POST['password'] : "");?>" class="form-control" type="password">
						<? if(isset($_POST['token'])){ ?>
						<?=(isset($_POST['password']) ? ($_POST['password'] == "" ? "<br/><font color=\"red\">Заполните поле Пароль.</font>" : "") : "");?>
						<? } ?>
					</td>
				</tr>
				<? if(Defined('EID')){ ?>
				<tr>
					<td>Вконтакте</td>
					<td>
						<? $vkontakte = (isset($ULOGIN[0]) ? $ULOGIN[0] : ""); ?>
						<? if($vkontakte == ""){ ?>
							<input value="Привязать ВКонтакте" class="btn" onclick="$('.ulogin-button-vkontakte').click();" type="button">
						<? } else { ?>
						<input value="Отвязать ВКонтакте" class="btn btn-danger" onclick="$('.ulogin-button-vkontakte').click();" type="button">
						<? } ?>
					</td>
				</tr>
				<tr>
					<td>MailRu</td>
					<td>
						<? $mailru = (isset($ULOGIN[1]) ? $ULOGIN[1] : ""); ?>
						<? if($mailru == ""){ ?>
							<input value="Привязать MailRu" class="btn" onclick="$('.ulogin-button-mailru').click();" type="button">
						<? } else { ?>
						<input value="Отвязать MailRu" class="btn btn-danger" onclick="$('.ulogin-button-mailru').click();" type="button">
						<? } ?>
					</td>
				</tr>
				<tr>
					<td>Одноклассники</td>
					<td>
						<? $odnoklassniki = (isset($ULOGIN[2]) ? $ULOGIN[2] : ""); ?>
						<? if($odnoklassniki == ""){ ?>
							<input value="Привязать Одноклассники" class="btn" onclick="$('.ulogin-button-odnoklassniki').click();" type="button">
						<? } else { ?>
						<input value="Отвязать Одноклассники" class="btn btn-danger" onclick="$('.ulogin-button-odnoklassniki').click();" type="button">
						<? } ?>
					</td>
				</tr>
				<tr>
					<td>Яндекс</td>
					<td>
						<? $yandex = (isset($ULOGIN[3]) ? $ULOGIN[3] : ""); ?>
						<? if($yandex == ""){ ?>
							<input value="Привязать Яндекс" class="btn" onclick="$('.ulogin-button-yandex').click();" type="button">
						<? } else { ?>
						<input value="Отвязать Яндекс" class="btn btn-danger" onclick="$('.ulogin-button-yandex').click();" type="button">
						<? } ?>
					</td>
				</tr>
				<? } ?>
				<tr>
					<td>Доступ к Товарам</td>
					<td>
						<select name="privilege[items]">
							<option value="1" <?=(Defined('EID') ? ($privilege['items'] == 1 ? "selected" : "") : "");?>>Разрешен</option>
							<option value="0" <?=(Defined('EID') ? ($privilege['items'] == 0 ? "selected" : "") : "");?>>Запрещен</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Доступ к Заказам</td>
					<td>
						<select name="privilege[orders]">
							<option value="1" <?=(Defined('EID') ? ($privilege['orders'] == 1 ? "selected" : "") : "");?>>Разрешен</option>
							<option value="0" <?=(Defined('EID') ? ($privilege['orders'] == 0 ? "selected" : "") : "");?>>Запрещен</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Доступ к Страницам</td>
					<td>
						<select name="privilege[pages]">
							<option value="1" <?=(Defined('EID') ? ($privilege['pages'] == 1 ? "selected" : "") : "");?>>Разрешен</option>
							<option value="0" <?=(Defined('EID') ? ($privilege['pages'] == 0 ? "selected" : "") : "");?>>Запрещен</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Доступ к Категориям</td>
					<td>
						<select name="privilege[categories]">
							<option value="1" <?=(Defined('EID') ? ($privilege['categories'] == 1 ? "selected" : "") : "");?>>Разрешен</option>
							<option value="0" <?=(Defined('EID') ? ($privilege['categories'] == 0 ? "selected" : "") : "");?>>Запрещен</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Доступ к Статистике</td>
					<td>
						<select name="privilege[statistics]">
							<option value="1" <?=(Defined('EID') ? ($privilege['statistics'] == 1 ? "selected" : "") : "");?>>Разрешен</option>
							<option value="0" <?=(Defined('EID') ? ($privilege['statistics'] == 0 ? "selected" : "") : "");?>>Запрещен</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Доступ к Безопасности</td>
					<td>
						<select name="privilege[secure]">
							<option value="1" <?=(Defined('EID') ? ($privilege['secure'] == 1 ? "selected" : "") : "");?>>Разрешен</option>
							<option value="0" <?=(Defined('EID') ? ($privilege['secure'] == 0 ? "selected" : "") : "");?>>Запрещен</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Доступ к Логам Авторизации</td>
					<td>
						<select name="privilege[logs]">
							<option value="1" <?=(Defined('EID') ? ($privilege['logs'] == 1 ? "selected" : "") : "");?>>Разрешен</option>
							<option value="0" <?=(Defined('EID') ? ($privilege['logs'] == 0 ? "selected" : "") : "");?>>Запрещен</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Доступ к Пользователям</td>
					<td>
						<select name="privilege[users]">
							<option value="1" <?=(Defined('EID') ? ($privilege['users'] == 1 ? "selected" : "") : "");?>>Разрешен</option>
							<option value="0" <?=(Defined('EID') ? ($privilege['users'] == 0 ? "selected" : "") : "");?>>Запрещен</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Доступ к Настройкам</td>
					<td>
						<select name="privilege[settings]">
							<option value="1" <?=(Defined('EID') ? ($privilege['settings'] == 1 ? "selected" : "") : "");?>>Разрешен</option>
							<option value="0" <?=(Defined('EID') ? ($privilege['settings'] == 0 ? "selected" : "") : "");?>>Запрещен</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Доступ к Купонам</td>
					<td>
						<select name="privilege[codes]">
							<option value="1" <?=(Defined('EID') ? ($privilege['codes'] == 1 ? "selected" : "") : "");?>>Разрешен</option>
							<option value="0" <?=(Defined('EID') ? ($privilege['codes'] == 0 ? "selected" : "") : "");?>>Запрещен</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Доступ к Раздачам</td>
					<td>
						<select name="privilege[gifts]">
							<option value="1" <?=(Defined('EID') ? ($privilege['gifts'] == 1 ? "selected" : "") : "");?>>Разрешен</option>
							<option value="0" <?=(Defined('EID') ? ($privilege['gifts'] == 0 ? "selected" : "") : "");?>>Запрещен</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Доступ к Шаблонам</td>
					<td>
						<select name="privilege[templates]">
							<option value="1" <?=(Defined('EID') ? ($privilege['templates'] == 1 ? "selected" : "") : "");?>>Разрешен</option>
							<option value="0" <?=(Defined('EID') ? ($privilege['templates'] == 0 ? "selected" : "") : "");?>>Запрещен</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input name="submit" value="Сохранить" class="btn btn-primary" type="submit"></td>
				</tr>
			</tbody>
		</table>
	</form>
	<? } else { ?>
	<button class="btn" style="float:left; margin-top:-14px; margin-bottom: 5px;" onclick="location.href = '/admin/users/add';">Новый пользователь</button>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `users` WHERE `sid` = '".intval(SID)."' ORDER BY uid ASC"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<table class="table tblsort table-bordered table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Логин</th>
				<th>Почта</th>
				<th>Редактирование</th>
				<th>Удаление</th>
			</tr>
		</thead>
		<tbody class="ui-sortable">
			<? while($row = mysqli_fetch_array($SQL)){ ?>
			<tr id="user-<?=$row['id'];?>">
				<td><?=$row['uid'];?></td>
				<td><?=$row['login'];?></td>
				<td><?=$row['email'];?></td>
				<td>
					<a href="/admin/users/edit/<?=$row['uid'];?>">
						<i class="icon-pencil"></i>
					</a>
				</td>
				<td>
					<a href="/admin/users/delete/<?=$row['uid'];?>">
						<i class="icon-remove"></i>
					</a>
				</td>
			</tr>
			<? } ?>
		</tbody>
	</table>
	<script>
		$(document).ready(function(){
			var fixHelper = function(e, ui){
				ui.children().each(function(){
					$(this).width($(this).width());
				});
				return ui;
			};
			$(".tblsort tbody").sortable({
				helper: fixHelper,
				opacity: 0.8, 
				cursor: 'move', 
				tolerance: 'pointer',  
				items:'tr',
				placeholder: 'state', 
				forcePlaceholderSize: true,
				update: function(event, ui){
					$.ajax({
						url: "/admin/users/sort",
						type: 'POST',
						data: $(this).sortable("serialize"), 
					});
				}
			});
			$(".tblsort tbody").disableSelection();
		});  
	</script>
	<? } ?>
	<? } ?>
	<?
		}
	?>