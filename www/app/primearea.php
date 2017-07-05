<?
	# Настройки
	$SETTINGS = json_decode(SETTINGS, true);
	$WALLET = json_decode(WALLETS, true);
	# Проверка
	if($WALLET['PRIMEAREA'] == TRUE){
		/*
			Проверка платежа
		*/
		parse_str(file_get_contents('php://input'), $post);
		/*
			PrimeArea обратилась
		*/
		if(isset($post['via'])){
			# Запрос
			$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `oid` = '".intval($post['payno'])."'");
			# Заказ существует
			if(mysqli_num_rows($SQL) > 0){
				/*
					Только PrimeArea IP
				*/			
				if($_SERVER["REMOTE_ADDR"] == '109.120.152.109'){
					/*
						Конфигурация
					*/
					$pa_secret = $SETTINGS['pa_secret'];
					/*
						Хэш авторизации
					*/
					$sign = $post['sign'];
					/*
						Удалим его из @post
					*/
					unset($post['sign']);
					/*
						Сортировка @post
					*/
					ksort($post, SORT_STRING);
					/*
						Новый хэш авторизации
					*/
					$signi = hash('sha256', implode(':', $post).':'.$pa_secret);
					/*
						Валидация пройдена
					*/
					if($signi == $sign){
						/*
							Поиск платежа
						*/
						$ORDER = mysqli_fetch_array($SQL);
						/*
							Статус ноль
						*/
						if($ORDER['status'] == FALSE){
							/*
								Обновим статус платежа
							*/
							mysqli_query($this->connectMainBD, "UPDATE `orders` SET `status` = '2' WHERE `sid` = '".intval(SID)."' AND `oid` = '".intval($post['payno'])."'");
						}
					}
				/*
					Обращение клиента
				*/
				} else {
					# Запросы
					$ORDER = mysqli_fetch_array($SQL);
					# Bill
					$bill = str_replace(Array(PREFIX."[", "]"), Array("", ""), $ORDER['bill']);
					# Система оплаты
					$_SESSION['wallet'] = "PRIMEAREA";
					# Редирект
					$this->redirect('/order/'.$bill);
				}
			}
		}
	}
?>