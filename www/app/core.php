<?
	# Запустим класс
	$Core = new Core;
	# Активируем парсер
	$Core->parser();
	# Класс маршрутизатора
	class Core {
		# Конструктор
		public function __construct(){
			# Куки включены?
			$cookies = file_get_contents('/backup/testCookie');			
			# Проверка на бота
			$testBot = false;
			# Включены
			if($cookies == true){
				# Зададим куку для юзверя
				if(!isset($_SESSION['cookie'])){
					$_SESSION['cookie'] = $this->cookie();
				}
				# Проверка на бота
				$testBot = (isset($_COOKIE['cookie']) ? ($_COOKIE['cookie'] == $_SESSION['cookie'] ? true : false) : false);				
				# Проверку не прошел
				if($testBot == false){
					die('<script>document.cookie = "cookie='.$_SESSION['cookie'].'"; location.href = location.href;</script>');
				}
			}
			# Куки выключены, либо не бот
			if($cookies == false || $testBot == true){
				# Подключим основную базу
				include('/home/bill.shopsu.ru/www/connectMainBD.php');
				include('/home/bill.shopsu.ru/www/database.php');
				# Переменная баз данных
				$this->connectMainBD = $connectMainBD;
				$this->connect = $connect;
				$this->connectMainBD = mysqli_connect('localhost', 'root', 'temp123', 'unitpay');
				$this->connect = mysqli_connect('localhost', 'root', 'temp123', 'unitpay');
			}
		}
		# Случайный текст
		public function cookie(){
			# Из чего генерируем
			$arr = Array(false, "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9");
			# Печенька
			$cookie = '';
			# От 6 символов до 10
			for($i = 0; $i < 8; $i++){
				$cookie .= $arr[rand(1, count($arr))];
			}
			# Вернём печеньку
			return $cookie;
		}
		# Маршрутизатор
		public function parser(){
			# Узнаем адрес страницы
			$address = $_SERVER['REQUEST_URI'];
			# Парсим страницу
			$split = explode("/", $address);
			# Адрес страницы
			Define("ADDRESS", $address);
			
			# Payeer
			if(preg_match('/payeer/', $address, $match) == true){
				$this->page('payeer', $split);
			# Все остальное
			} else {
				# Маршрутизатор
				switch($split[1]){
					# Фрикасса
					case "freekassa": $this->page('freekassa'); break;
					# Робокасса
					case "robokassa": $this->page('robokassa'); break;
					# PrimeArea
					case "primearea": $this->page('primearea'); break;
					# Яндекс
					case "yandex": $this->page('yandex', $split); break;
					# Мерчанты
					case "merchant": $this->page('merchant', $split); break;
					# Главная страница
					case "": $this->page('main'); break;
					# Новости
					case "page": $this->page('page', $split); break;
					# Поиск
					case "search": $this->page('search', $split); break;
					# Страница оплаты товара
					case "order": $this->page('order', $split); break;
					# Страница товара
					case "item": $this->page('item', $split); break;
					# Админка магазина
					case "admin": $this->page('admin', $split); break;
					# Раздачи
					case "gifts": $this->page('gifts', $split); break;
					# Раздачи
					case "myorders": $this->page('myorders', $split); break;
					# Капча
					case "captcha": $this->page('captcha'); break;
					# Проверка
					case "encode": $this->encode($_GET['text']); break;
					case "decode": $this->decode($_GET['text']); break;
					# По умолчанию, страница ошибки
					default: $this->page('404');
				}
			}
		}
		# Конфигурация магазина
		public function config(){
			# Прочитаем конфигурацию
			$a = file_get_contents('config.json');
			# Проверка на пустоту
			if($a != ""){
				# Разбираем массив
				$obj = json_decode($a, true);
				# Название магазина
				Define("TITLE", $obj['title']);
				# Верхнее меню
				Define("MENU", json_encode($obj['menu']));
				# Конфигурация
				Define("CONFIG", $a);
				# Настройки
				Define("SETTINGS", json_encode($obj['settings']));
				# Зададим шаблон
				Define("TEMPLATE", $obj['template']);
				# Методы оплаты
				Define("WALLETS", json_encode($obj['wallets']));
				# ID Магазина
				Define("SID", intval($obj['sid']));
				# Ключ
				Define("KEY", json_encode($obj['key']));
				# Блок Контакты
				Define("CONTACTS", $obj['contacts']);
				# Блок Инфрормация
				Define("INFORMATION", $obj['information']);
				# Favicon
				Define("FAVICON", $obj['favicon']);
				# Логотип
				Define("LOGOTYPE", $obj['logotype']);
				# Задний фон
				Define("BACKGROUND", $obj['background']);
				# Цвет верха default
				Define("COLORDEFAULT", $obj['colordefault']);
				# Цвет верха default
				Define("COLORDEFAULTPK", $obj['colordefaultpk']);
				# Цвет верха default
				Define("COLORBOXYVERX", $obj['colorboxyverx']);
				# Цвет верха default
				Define("COLORBOXYPAY", $obj['colorboxypay']);
				# Цвет верха default
				Define("COLORBOXYOPL", $obj['colorboxyopl']);
				# Цвет верха default
				Define("COLORELEGANTMN", $obj['colorelegantmn']);
								# Цвет верха default
				Define("COLORELEGANTOP", $obj['colorelegantop']);
								# Цвет верха default
				Define("COLORGAMEFON", $obj['colorgamefon']);
								# Цвет верха default
				Define("COLORGAMEVERX", $obj['colorgameverx']);
								# Цвет верха default
				Define("COLORGAMEOPL", $obj['colorgameopl']);
								# Цвет верха default
				Define("COLORLIBERTYVERX", $obj['colorlibertyverx']);
								# Цвет верха default
				Define("COLORLIBERTYBLOCK", $obj['colorlibertyblock']);
								# Цвет верха default
				Define("COLORLIBERTYITEM", $obj['colorlibertyitem']);
												# Цвет верха default
				Define("COLORLIBERTYFON", $obj['colorlibertyfon']);
							# Цвет верха default
				Define("COLORLITEBLOCK", $obj['colorliteblock']);
					# Цвет верха default
				Define("COLORLITEVERX", $obj['colorliteverx']);
					# Цвет верха default
				Define("COLORLITEITEM", $obj['colorliteitem']);
									# Цвет верха default
				Define("COLORLITENAZV", $obj['colorlitenazv']);
									# Цвет верха default
				Define("COLORLOLIPOPBLOCK", $obj['colorlolipopblock']);
									# Цвет верха default
				Define("COLORLOLIPOPKLICK", $obj['colorlolipopklick']);
													# Цвет верха default
				Define("COLORLOLIPOPKLICKFN", $obj['colorlolipopklickfn']);
							# Цвет верха default
				Define("COLORPERFECTBLOCK", $obj['colorperfectblock']);
						# Цвет верха default
				Define("COLORPERFECTVERX", $obj['colorperfectverx']);
				# Цвет верха default
				Define("COLORDEERCATEG", $obj['colordeercateg']);
				# Цвет верха default
				Define("COLORDEERTOVAR", $obj['colordeertovar']);
				# Цвет верха default
				Define("COLORDEERITEM", $obj['colordeeritem']);
				# Цвет верха default
				Define("COLORDEERPRT", $obj['colordeerprt']);
				# Цвет верха default
				Define("COLORELEGANTPAY", $obj['colorelegantpay']);
				# Цвет фона названия default
				Define("COLORDEFAULTFON", $obj['colordefaultfon']);
				# Цвет кнопок default
				Define("COLORDEFAULTBUTTON", $obj['colordefaultbutton']);
				# Цвет текста default
				Define("COLORDEFAULTTEXT", $obj['colordefaulttext']);
				# Цвет панели под логотипом AQUA
				Define("COLORAQUABG", $obj['coloraquabg']);
				# Цвет панели под логотипом AQUA
				Define("COLORAQUAPK", $obj['coloraquapk']);
				# Цвет панели под логотипом AQUA
				Define("COLORSHOPNEWVERX", $obj['colorshopnewverx']);
				# Цвет панели под логотипом AQUA
				Define("COLORSHOPNEWNUZ", $obj['colorshopnewnuz']);
				# Цвет панели под логотипом AQUA
				Define("COLORSHOPNEWPAY", $obj['colorshopnewpay']);
				# Цвет панели под логотипом AQUA
				Define("COLORWHITEBSOK", $obj['colorwhitebsok']);
				# Цвет панели под логотипом AQUA
				Define("COLORWHITEBSTEXT", $obj['colorwhitebstext']);
				# Цвет панели под логотипом AQUA
				Define("COLORWHITEBSPAY", $obj['colorwhitebspay']);
				# Цвет панели под логотипом AQUA
				Define("COLORWHITEBSFON", $obj['colorwhitebsfon']);
				# Цвет панели под логотипом AQUA
				Define("COLORLILACPAY", $obj['colorlilacpay']);
				# Цвет панели под логотипом AQUA
				Define("COLORLILACCN", $obj['colorlilaccn']);
				# Цвет панели под логотипом AQUA
				Define("COLORLILACFON", $obj['colorlilacfon']);
				# Цвет панели под логотипом AQUA
				Define("COLORLUCKYVERX", $obj['colorluckyverx']);
				# Цвет панели под логотипом AQUA
				Define("COLORLUCKYNUZ", $obj['colorluckynuz']);
				# Цвет панели под логотипом AQUA
				Define("COLORLUCKYFON", $obj['colorluckyfon']);
								# Цвет панели под логотипом AQUA
				Define("COLORGAMESFON", $obj['colorgamesfon']);
								# Цвет панели под логотипом AQUA
				Define("COLORGAMESVERX", $obj['colorgamesverx']);
								# Цвет панели под логотипом AQUA
				Define("COLORGAMESTVR", $obj['colorgamestvr']);
								# Цвет панели под логотипом AQUA
				Define("COLORKEYSNUZ", $obj['colorkeysnuz']);
								# Цвет панели под логотипом AQUA
				Define("COLORKEYSFON", $obj['colorkeysfon']);
								# Цвет панели под логотипом AQUA
				Define("COLORKEYSFONN", $obj['colorkeysfonn']);
								# Цвет панели под логотипом AQUA
				Define("COLORWFPANEL", $obj['colorwfpanel']);
				Define("COLORWFFONP", $obj['colorwffonp']);
				Define("COLORWFFON", $obj['colorwffon']);
				Define("COLORLQSHOPFON", $obj['colorlqshopfon']);
				Define("COLORLQSHOPVERX", $obj['colorlqshopverx']);
				Define("COLORLQSHOPPAY", $obj['colorlqshoppay']);
				Define("COLORLQSHOPPAYN", $obj['colorlqshoppayn']);
				Define("COLORLQSHOPPAYK", $obj['colorlqshoppayk']);
				Define("COLORLQSHOPPAYOPL", $obj['colorlqshoppayopl']);
				Define("COLORLQSHOPBORDER", $obj['colorlqshopborder']);
				Define("COLORLQSHOPCOLOR", $obj['colorlqshopcolor']);
				
								# Цвет панели под логотипом AQUA
				Define("COLORGAMESPAY", $obj['colorgamespay']);
				# Цвет панели под логотипом AQUA
				Define("COLORSHOPNEWFON", $obj['colorshopnewfon']);
				# Цвет верх панели AQUA
				Define("COLORAQUA", $obj['coloraqua']);
				# Видимост копирайта
				Define("COPYRIGHT", (isset($obj['copyright']) ? ($obj['copyright'] == "none" ? false : true) : true));
				# Скрипты перед </body>
				Define("SCRIPTS", (isset($obj['scripts']) ? ($obj['scripts'] == "" ? "" : "<script>".$obj['scripts']."</script>") : ""));
				# Префикс
				Define("PREFIX", (isset($obj['settings']['prefix']) ? $obj['settings']['prefix'] : "bill"));
				# keywords
				Define("KEYWORDS", (isset($obj['settings']['keywords']) ? $obj['settings']['keywords'] : "bill"));
				# Префикс
				Define("DESCRIPTION", (isset($obj['settings']['description']) ? $obj['settings']['description'] : "bill"));
				# Подключим биллинг
				#$this->billing();
			# Ошибка
			} else die('Файла конфигурации не существует.');
		}
		# Биллинг
		public function billing(){
			# Запросы
			$SHOP = mysqli_fetch_array(mysqli_query($this->connect, "SELECT * FROM `shops` WHERE `id` = '".intval(SID)."'"));
			# Магазин просрочен
			if($SHOP['expired'] < time()){
				include('errors/expired.php'); die;
			# Магазин заблокирован
			} else if($SHOP['status'] == "2"){
				include('errors/blocked.php'); die;
			# Сколько дней осталось
			} else {
				Define("DAYS", round(($SHOP['expired'] - time()) / 86400));
			}
			# Ищем IP В базе
			$this->block();
		}
		# Блокировка IP адрера
		public function block(){
			# Поищем IP в базе
			$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `block_ip` WHERE `sid` = '".intval(SID)."' AND `ip` = '".mysqli_real_escape_string($this->connectMainBD, $_SERVER['REMOTE_ADDR'])."'");
			# IP Заблокирован
			if(mysqli_num_rows($SQL) > 0){
				include('errors/block_ip.php'); die;
			}
		}
		# Шифрование
		public function encode($string){
			# Base64
			$a = base64_encode($string);
			# Исходный массив
			$b = Array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9","+","/","=");
			# Выходной массив
			$c = json_decode(KEY, true);
			$aa = "";
			for($i = 0; $i < strlen($a); $i++){
				for($ii = 0; $ii < count($b); $ii++){
					if($a[$i] == $b[$ii]){
						$aa .= $c[$ii];
					}
				}
			}
			return $aa;
		}
		# Дешифровка
		public function decode($string){
			# Строка
			$a = $string;
			# Выходной массив
			$b = Array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9","+","/","=");
			# Исходный массив
			$c = json_decode(KEY, true);
			$aa = "";
			for($i = 0; $i < strlen($a); $i++){
				for($ii = 0; $ii < count($c); $ii++){
					if($a[$i] == $c[$ii]){
						$aa .= $b[$ii];
					}
				}
			}
			return base64_decode($aa);
		}
		# Редирект
		public function redirect($to){
			Header('Location: '.$to);
		}
		# Генератор примечаний платежа
		public function bill($a){
			# Массив
			$arr = Array('a','b','c','d','e','f',
						 'g','h','i','j','k','l',
						 'm','n','o','p','r','s',
						 't','u','v','x','y','z',
						 'A','B','C','D','E','F',
						 'G','H','I','J','K','L',
						 'M','N','O','P','R','S',
						 'T','U','V','X','Y','Z',
						 '1','2','3','4','5','6',
						 '7','8','9','0');
			# Генерируем примечание
			$bill = "";
			# Собираем массивом
			for($i = 0; $i < $a; $i++){
				$index = rand(0, count($arr) - 1);
				$bill .= $arr[$index];
			}
			return $bill;
		}
		# Подгружаем страницу
		public function load($page){
			# Start
			$start = microtime(true);
			# Подключим вверх шаблона
			include('templates/'.TEMPLATE.'/header.php');
			# Подгрузим контент
			include('templates/'.TEMPLATE.'/'.$page.'.php');
			# Подключим низ шаблона
			include('templates/'.TEMPLATE.'/footer.php');
			# Stop
			echo '<!-- Page load '.(microtime(true) - $start).'. -->';
		}
		# Подгружаем страницу
		public function loadAdmin($page){
			# Подключим вверх шаблона
			include('templates/admin/header.php');
			# Подгрузим контент
			include('templates/admin/'.$page.'.php');
			# Подключим низ шаблона
			include('templates/admin/footer.php');
		}
		# Шаблон с содержимым
		public function page($name, $params = false){
			# Не подгружаем
			if($name != "404"){
				# Страница
				Define("PAGE", $name);
				# Подключим конфиг
				$this->config();
			}
			# Фрикасса
			if($name == "freekassa"){
				# Подключим Фрикассу
				include('freekassa.php');
			# Робокасса
			} else if($name == "robokassa"){
				# Подключим Робокассу
				include('robokassa.php');
			# Primearea
			} else if($name == "primearea"){
				# Подключим PrimeArea
				include('primearea.php');
			# Payeer
			} else if($name == "payeer"){
				# Подключим PrimeArea
				include('payeer.php');
			# Яндекс
			} else if($name == "yandex"){
				# Подключим Яндекс
				include('yandex.php');
				# Match
				preg_match('/token/', $_SERVER['REQUEST_URI'], $match);
				# Token
				if(isset($match[0])){
					token();
				# Index
				} else {
					index();
				}
			# Мерчанты
			} else if($name == "merchant"){				
				# Система передана
				if(isset($_POST['system'])){
					# Заказ передан
					if(isset($_POST['order'])){
						# Киви
						if($_POST['system'] == "YAD"){
							include('yandexMerchant.php');
						# Яндекс Деньги
						} else if($_POST['system'] == "QIWI"){
							include('qiwiMerchant.php');
						# Вебмани
						} else if($_POST['system'] == "WMR" || $_POST['system'] == "WMU" || $_POST['system'] == "WMZ" || $_POST['system'] == "WME"){
							include('webmoneyMerchant.php');
						}
					}
				}
			# Главная страница
			} else if($name == "main"){
				# Подгрузим страницу
				$this->load($name);
			# Новости
			} else if($name == "page"){
				# Two paramets
				if(isset($params[2])){
					# Определенная новость
					if($params[2] > 0){
						# ID Новости
						Define("PID", $params[2]);
						# Запросы
						$PAGE = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"));
						# Имя страницы
						Define("MENU_PAGE_NAME", ($PAGE == true ? $PAGE['title'] : "Страница ошибки"));
						Define("NAME_PAGE", ($PAGE == true ? $PAGE['title'] : "Страница ошибки"));
					# Не передан ID
					} else if($params[2] == "p"){
						# Страница передана
						if($params[3] > 0){
							# ID Страницы
							Define("PID", $params[3]);
							# Категория
							Define("CAT", "p");
							Define("CAT_NAME", "Публикации");
							Define("NAME_PAGE", "Публикации");
						# Страница не передана, Редирект
						} else $this->redirect('/page/p/1');
					# Параметры не переданы, Редирект
					} else $this->redirect('/page/p/1');
				}
				# Подгрузим страницу
				$this->load($name);
			# Поиск по магазину
			} else if($name == "search"){
				# Поисковой запрос
				Define("SEARCH", urldecode($params[2]));				
				# Подгрузим страницу
				$this->load('main');
			# Страница оплаты товара
			} else if($name == "order"){
				# Проверка оплаты товара
				if(strlen($params[2]) != ""){
					# Название заказа
					Define("ORDER", $params[2]);
				# Создание нового заказа
				} else {
					# Запросы
					$ORDER = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' ORDER BY oid DESC LIMIT 1"));
					# Следующий заказ
					Define("OID", ($ORDER['oid'] + 1));
				}
				# Подгрузим файл
				include('system/'.$name.'.php');
			# Страница с описанием товара
			} else if($name == "item"){
				# Параметр передан
				if($params[2] > 0){
					# Название товара
					Define("ITEM_ID", $params[2]);
					# Запросы
					$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `item_id` = '".intval(ITEM_ID)."' AND `sid` = '".intval(SID)."'"));
					# Категория
					if($ITEM['cid'] != NULL){
						# Запросы
						$CAT = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `id` = '".intval($ITEM['cid'])."' AND `sid` = '".intval(SID)."'"));
						# Категория
						Define("CAT", $CAT['name']);
						Define("CAT_NAME", $CAT['category']);
					}
					# Имя страницы
					Define("NAME_PAGE", ($ITEM['item'] != "" ? $ITEM['item'] : "Страница ошибки"));
					Define("MENU_PAGE_NAME", ($ITEM['item'] != "" ? $ITEM['item'] : "Страница ошибки"));
					# Подгрузим страницу
					$this->load('item');
				# Сортировка товаров по категориям
				} else if($params[2] != ""){
					# Название категории
					Define("CAT", $params[2]);
					# Запросы
					$CAT = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `name` = '".mysqli_real_escape_string($this->connectMainBD, CAT)."' AND `sid` = '".intval(SID)."'"));
					# Имя страницы
					Define("CAT_NAME", ($CAT['category'] != "" ? $CAT['category'] : "Страница ошибки"));
					Define("NAME_PAGE", ($CAT['category'] != "" ? $CAT['category'] : "Страница ошибки"));
					Define("CID", ($CAT['id'] != "" ? $CAT['id'] : "CID"));
					# Подгрузим страницу
					$this->load('main');
				# Параметры не переданы, Редирект
				} else $this->redirect('/');
			# Раздачи
			} else if($name == "gifts"){
				# Раздача
				if(isset($params[2])){
					# ID Раздачи
					Define("GID", intval($params[2]));
					# Запросы
					$GIFT = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `gifts` WHERE `sid` = '".intval(SID)."' AND `gid` = '".intval(GID)."'"));
					# Имя страницы
					Define("NAME_PAGE", ($GIFT['gift'] != "" ? $GIFT['gift'] : "Страница ошибки"));
					Define("MENU_PAGE_NAME", ($GIFT['gift'] != "" ? $GIFT['gift'] : "Страница ошибки"));
				} else {
					# Страница
					Define("CAT", "all");
					# Имя страницы
					Define("NAME_PAGE", "Раздачи");
				}
				# Подгрузим страницу
				$this->load('gifts');
			# Мои покупки
			} else if($name == "myorders"){
				# POST Запрос
				if($_POST){
					# Массив
					$obj = Array();
					# Лимит на отправку
					$_SESSION['time'] = (isset($_SESSION['time']) ? $_SESSION['time'] : (time() - 1));
					# Поиск покупок по email
					$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' AND `email` = '".mysqli_real_escape_string($this->connectMainBD, $_POST['email'])."'");
					# Покупки найдены
					if(mysqli_num_rows($SQL) > 0){
						# Задержка
						if($_SESSION['time'] < time()){
							# Подключим класс
							include('/home/engine/app/system/libmail.php');
							# Кодировка письма
							$m= new Mail("utf-8");
							# Отправитель
							$m->From("Shopsn.su;seller@shopsn.su"); 
							# Получатель
							$m->To($_POST['email']);
							# Тема письма
							$m->Subject('['.$_SERVER['HTTP_HOST'].'] Ваши покупки');
							# Контень письма
							$m->Body("Ваши покупки во вложении к письму");
							# Приоретет
							$m->Priority(4);
							# Прогоним циклом заказы
							while($row = mysqli_fetch_array($SQL)){
								# Запросы
								$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"));
								# Продажа по строкам
								if($ITEM['type'] == "text"){
									# Вложение файла
									$m->Attach('uploads/'.md5(SID).'/orders/'.md5($row['id']), " ".$ITEM['item'].".txt", "", "attachment");
								# Товар файл
								} else {
									# Вложение файла
									$m->Attach('uploads/'.md5(SID).'/'.md5($ITEM['id']), " ".$ITEM['item'].".txt", "", "attachment");
								}
							}
							# Установка соединения по SMTP
							$m->smtp_on("ssl://smtp.yandex.ru", "seller@shopsn.su", "S99sd89Yql", 465, 10);
							# Включаем логи
							$m->log_on(true);
							# Отправляем
							$m->Send();
							
							$obj = json_decode(json_encode($m), true);
							
							if($obj['status_mail']['status'] == false){
								
								# Кодировка письма
								$m= new Mail("utf-8");
								# Отправитель
								$m->From("Shopsn.su;seller-one@shopsn.su"); 
								# Получатель
								$m->To($_POST['email']);
								# Тема письма
								$m->Subject('['.$_SERVER['HTTP_HOST'].'] Ваши покупки');
								# Контень письма
								$m->Body("Ваши покупки во вложении к письму");
								# Приоретет
								$m->Priority(4);
								# Прогоним циклом заказы
								while($row = mysqli_fetch_array($SQL)){
									# Запросы
									$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"));
									# Продажа по строкам
									if($ITEM['type'] == "text"){
										# Вложение файла
										$m->Attach('uploads/'.md5(SID).'/orders/'.md5($row['id']), " ".$ITEM['item'].".txt", "", "attachment");
									# Товар файл
									} else {
										# Вложение файла
										$m->Attach('uploads/'.md5(SID).'/'.md5($ITEM['id']), " ".$ITEM['item'].".txt", "", "attachment");
									}
								}
								# Установка соединения по SMTP
								$m->smtp_on("ssl://smtp.yandex.ru", "seller-one@shopsn.su", "S99sd89Yql", 465, 10);
								# Включаем логи
								$m->log_on(true);
								# Отправляем
								$m->Send();
								
								$obj = json_decode(json_encode($m), true);
								
								if($obj['status_mail']['status'] == false){
									
									# Кодировка письма
									$m= new Mail("utf-8");
									# Отправитель
									$m->From("Shopsn.su;seller-two@shopsn.su"); 
									# Получатель
									$m->To($_POST['email']);
									# Тема письма
									$m->Subject('['.$_SERVER['HTTP_HOST'].'] Ваши покупки');
									# Контень письма
									$m->Body("Ваши покупки во вложении к письму");
									# Приоретет
									$m->Priority(4);
									# Прогоним циклом заказы
									while($row = mysqli_fetch_array($SQL)){
										# Запросы
										$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"));
										# Продажа по строкам
										if($ITEM['type'] == "text"){
											# Вложение файла
											$m->Attach('uploads/'.md5(SID).'/orders/'.md5($row['id']), " ".$ITEM['item'].".txt", "", "attachment");
										# Товар файл
										} else {
											# Вложение файла
											$m->Attach('uploads/'.md5(SID).'/'.md5($ITEM['id']), " ".$ITEM['item'].".txt", "", "attachment");
										}
									}
									# Установка соединения по SMTP
									$m->smtp_on("ssl://smtp.yandex.ru", "seller-two@shopsn.su", "S99sd89Yql", 465, 10);
									# Включаем логи
									$m->log_on(true);
									# Отправляем
									$m->Send();
									
								}
								
							}
							
							# Успешно
							$obj['status'] = true;
							$obj['message'] = 'Проверьте свою почту';
							# Зададим задержку
							$_SESSION['time'] = time() + 120;
						# Задержка
						} else {
							$obj['status'] = false;
							$obj['message'] = 'Лимит отправки один раз в 2 минуты';
						}
					# Покупки не найдены
					} else {
						$obj['status'] = false;
						$obj['message'] = 'Покупки не найдены';
					}
					# Соберём json
					die(json_encode($obj));
				# GET Запрос
				} else {
					# Подгрузим страницу
					$this->load('myorders');
				}
			# Админка Магазина
			} else if($name == "admin"){
				# Подключим маршрутизатор
				include('system/'.$name.'.php');
			} else if($name == "captcha"){
				# Подключим капчу
				include('system/'.$name.'.php');
			# Страницы не существует
			} else if($name == "404"){
				# Заголовок
				Header("HTTP/1.0 404 Not Found");
				# Подгрузим контент
				include('errors/'.$name.'.php');
			}
		}
	}
?>