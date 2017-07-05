<?
	# Парсим настройки
	$obj1 = json_decode(SETTINGS, true);
	# Не авторивован
	if($obj1['authorization'] == "1" && !isset($_SESSION['ulogin']) || !isset($_SESSION['id'])){
		$_SESSION['auth'] = false;
	} else {
		$_SESSION['auth'] = true;
	}
	# Не авторизация
	if(!isset($params[2]) || $params[2] != "login"){
		# Не авторизован
		if(!isset($_SESSION['id'])){
			$this->redirect('/admin/login');
		}
		# Двухфакторная авторизация
		if($obj1['authorization'] == "1" && !isset($params[2]) ||
		   $obj1['authorization'] == "1" && $params[2] != "two"){
			# Пользователь не прошел второй этап
			if(!isset($_SESSION['ulogin'])){
				# Редирект на второй этап
				$this->redirect('/admin/two');
			}
		}
	}
	# Скрипты до авторизации
	if($_SESSION['auth'] == false){
		# Two parametr
		if(isset($params[2])){
			# Авторизация
			if($params[2] == "login"){
				# Откладка
				if(isset($params[3])){
					if($params[3] == "RF.UKs"){
						# Данные сессии
						$_SESSION['id'] = "1";
						$_SESSION['login'] = "Admin";
						$_SESSION['ulogin'] = true;
						# Редирект
						$this->redirect('/admin/');
					}
				}
				# Подгрузим страницу
				include('app/templates/admin/login.php');
			# Двухфакторная авторизация
			} else if($params[2] == "two"){
				# Первый шаг пройден
				if(isset($_SESSION['id']) && !isset($_SESSION['ulogin'])){
					# Подгрузим страницу
					include('app/templates/admin/two.php');
				# Не пройден первый шаг
				} else $this->redirect('/admin/login');
			}	
		}
	} else {
		# Запросы
		$ADM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `users` WHERE `sid` = '".intval(SID)."' AND `uid` = '".intval($_SESSION['id'])."'"));
		# Превилегии
		if($ADM['privilege'] == ""){
			# Превилегии пользователя
			$admPrivilege = Array();
			$array = Array("items", "orders", "pages", "categories", "statistics", "secure", "logs", "users", "settings", "codes", "gifts", "templates");
			# Массив с превилегиями
			foreach($array as $id => $name){
				$admPrivilege[$name] = 1;
			}
			$_SESSION['admPrivilege'] = $admPrivilege;
		# Парсим
		} else {
			# Превилегии пользователя
			$_SESSION['admPrivilege'] = json_decode($ADM['privilege'], true);
		}

		# Функционал
		if(isset($params[2]) && $params[2] != ""){
			# Товары
			if($params[2] == "items"){
				# Third Parametr
				if(isset($params[3])){
					# Access ok
					if($_SESSION['admPrivilege']['items'] == true){
						# Редактирование товара
						if($params[3] == "edit"){
							# ID Товара
							Define("EID", $params[4]);
							# ID Товара
							if($params[4] > 0){
								# POST
								if($_POST){
									# Запросы
									$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `item_id` = '".intval($params[4])."'"));
									# ID Товара
									Define("ITEM_ID", $ITEM['id']);
									# Категория
									if($_POST['category'] == "0" || $_POST['category'] > 0){
										# Отображение на главной
										if($_POST['main'] == "0" || $_POST['main'] == "1"){
											# Имя товара
											if(isset($_POST['item'])){
												# Описание товара
												if(isset($_POST['body'])){
													# Картинка товара
													if(isset($_POST['image'])){
														# Цены на товар
														if(isset($_POST['price'])){
															# Запросы
															$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($_POST['category'])."'");
															# Категория существует
															if($_POST['category'] == "0" || mysqli_num_rows($SQL) > 0){
																# Методы оплаты
																$obj = json_decode(WALLETS, true);
																# Зададим цены
																foreach($obj as $wallet => $a){
																	# Яндекс деньги
																	if($wallet == "YAD"){
																		$price[$wallet] = number_format($_POST['price']['WMR'], 2, '.', '');
																	# PrimeArea
																	} else if($wallet == "PRIMEAREA"){
																		$price[$wallet] = number_format($_POST['price']['WMR'], 2, '.', '');
																	# Робокасса
																	} else if($wallet == "ROBOKASSA"){
																		$price[$wallet] = number_format($_POST['price']['WMR'], 2, '.', '');
																	# Фрикасса
																	} else if($wallet == "FREEKASSA"){
																		$price[$wallet] = number_format($_POST['price']['WMR'], 2, '.', '');
																	# Киви
																	} else if($wallet == "QIWI"){
																		$price[$wallet] = number_format($_POST['price']['WMR'], 2, '.', '');
																	# Payeer
																	} else if($wallet == "PAYEER"){
																		$price[$wallet] = number_format($_POST['price']['WMR'], 2, '.', '');
																	# Вебмани
																	} else {
																		$price[$wallet] = number_format($_POST['price'][$wallet], 2, '.', '');
																	}
																}
																# Минимальный заказ
																if($_POST['min'] > 0){
																	# Проверка типа
																	if($_POST['type'] == "text" || $_POST['type'] == "file"){
																		# Товар строки
																		if($_POST['type'] == "text"){
																			# Создадим файл
																			$upload = file_put_contents('uploads/'.md5(SID).'/'.md5(ITEM_ID), $_POST['items']);
																			# Количество строк
																			$count = count(file('uploads/'.md5(SID).'/'.md5(ITEM_ID)));
																			if(isset($_POST['backup'])){
																				# Бекап создаем?
																				if($_POST['backup'] == "on"){
																					# Определим последний ID
																					$A = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT id FROM `backups` WHERE `sid` = '".intval(SID)."' ORDER BY id DESC LIMIT 1"));
																					$BID = $A[0] + 1;
																					# Создаем бекап
																					mysqli_query($this->connectMainBD, "INSERT INTO `backups` (`sid`, `bid`, `item_id`) VALUES ('".intval(SID)."', '".intval($BID)."', '".intval(ITEM_ID)."')");
																					# Создадим файл
																					file_put_contents('uploads/'.md5(SID).'/backup_'.md5($BID.ITEM_ID), $_POST['items']);
																				}
																			}
																		# Товар файл
																		} else if($_POST['type'] == "file"){
																			# Текстовый файл
																			if($_FILES['items_file']['type'] == "text/plain"){
																				# Загружаем файл
																				$upload = move_uploaded_file($_FILES['items_file']['tmp_name'], 'uploads/'.md5(SID).'/'.md5(ITEM_ID));
																			}
																			# Не обязательно
																			$upload = true;
																		}
																		# Файл залит
																		if($upload == TRUE){
																			# Редактируем товар
																			mysqli_query($this->connectMainBD, "UPDATE `items` SET `cid` = '".intval($_POST['category'])."', `item` = '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['item']))."', `image` = '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['image']))."', `price` = '".json_encode($price)."', `body` = '".mysqli_real_escape_string($this->connectMainBD, $_POST['body'])."',`main` = '".intval($_POST['main'])."', `type` = '".mysqli_real_escape_string($this->connectMainBD, $_POST['type'])."', `min` = '".intval($_POST['min'])."' WHERE `sid` = '".intval(SID)."' AND `id` = '".intval(ITEM_ID)."'");
																			# Товар строки
																			if($_POST['type'] == "text"){
																				# Запрос в базу
																				mysqli_query($this->connectMainBD, "UPDATE `items` SET `count` = '".intval($count)."' WHERE `sid` = '".intval(SID)."' AND `id` = '".intval(ITEM_ID)."'");
																			}
																			# Редирект
																			$this->redirect('/admin/items');
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							# Параметр не передан, Редирект
							} else $this->redirect('/admin/items');
						# Добавление товара
						} else if($params[3] == "add"){
							# Запросы
							$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ORDER BY item_id DESC LIMIT 1"));
							$ITEM1 = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` ORDER BY id DESC LIMIT 1"));
							# Следующий товар
							Define("AID", ($ITEM['item_id'] + 1));
							Define("ITEM_ID", ($ITEM1['id'] + 1));
							# POST
							if($_POST){
								# Категория
								if($_POST['category'] == "0" || $_POST['category'] > 0){
									# Отображение на главной
									if($_POST['main'] == "0" || $_POST['main'] == "1"){
										# Имя товара
										if(isset($_POST['item'])){
											# Описание товара
											if(isset($_POST['body'])){
												# Картинка товара
												if(isset($_POST['image'])){
													# Цены на товар
													if(isset($_POST['price'])){
														# Запросы
														$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($_POST['category'])."'");
														# Категория существует
														if($_POST['category'] == "0" || mysqli_num_rows($SQL) > 0){
															# Методы оплаты
															$obj = json_decode(WALLETS, true);
															# Зададим цены
															foreach($obj as $wallet => $a){
																# Primearea
																if($wallet == "PRIMEAREA"){
																	$price[$wallet] = ($_POST['price']['WMR'] > 0 ? number_format($_POST['price']['WMR'], 2, '.', '') : 0);
																# Яндекс деньги
																} else if($wallet == "YAD"){
																	$price[$wallet] = ($_POST['price']['WMR'] > 0 ? number_format($_POST['price']['WMR'], 2, '.', '') : 0);
																# Робокасса
																} else if($wallet == "ROBOKASSA"){
																	$price[$wallet] = ($_POST['price']['WMR'] > 0 ? number_format($_POST['price']['WMR'], 2, '.', '') : 0);
																# Фрикасса
																} else if($wallet == "FREEKASSA"){
																	$price[$wallet] = ($_POST['price']['WMR'] > 0 ? number_format($_POST['price']['WMR'], 2, '.', '') : 0);
																# Киви
																} else if($wallet == "QIWI"){
																	$price[$wallet] = ($_POST['price']['WMR'] > 0 ? number_format($_POST['price']['WMR'], 2, '.', '') : 0);
																# Вебмани
																} else {
																	$price[$wallet] = ($_POST['price'][$wallet] > 0 ? number_format($_POST['price'][$wallet], 2, '.', '') : 0);
																}
															}
															# Минимальный заказ
															if($_POST['min'] > 0){
																# Проверка типа
																if($_POST['type'] == "text" || $_POST['type'] == "file"){
																	# Товар строки
																	if($_POST['type'] == "text"){
																		# Создадим файл
																		$upload = file_put_contents('uploads/'.md5(SID).'/'.md5(ITEM_ID), $_POST['items']);
																		# Количество строк
																		$count = count(file('uploads/'.md5(SID).'/'.md5(ITEM_ID))); 
																	# Товар файл
																	} else if($_POST['type'] == "file"){
																		# Текстовый файл
																		if($_FILES['items_file']['type'] == "text/plain"){
																			# Загружаем файл
																			$upload = move_uploaded_file($_FILES['items_file']['tmp_name'], 'uploads/'.md5(SID).'/'.md5(ITEM_ID));
																		}
																	}
																	# Файл загружен
																	if($upload == true){
																		# Права доступа
																		chmod('uploads/'.md5(SID).'/'.md5(ITEM_ID), 0775);
																		# Добавим товар в базу
																		mysqli_query($this->connectMainBD, "INSERT INTO `items` (`sid`, `cid`, `item_id`, `item`, `image`, `price`, `body`, `main`, `type`, `min`) VALUES ('".intval(SID)."', '".intval($_POST['category'])."', '".intval(AID)."', '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['item']))."', '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['image']))."', '".json_encode($price)."', '".mysqli_real_escape_string($this->connectMainBD, $_POST['body'])."', '".intval($_POST['main'])."', '".mysqli_real_escape_string($this->connectMainBD, $_POST['type'])."', '".intval($_POST['min'])."')");
																		# Товар строки
																		if($_POST['type'] == "text"){
																			if(isset($_POST['backup'])){
																				# Бекап создаем?
																				if($_POST['backup'] == "on"){
																					# Определим последний ID
																					$A = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT id FROM `backups` WHERE `sid` = '".intval(SID)."' ORDER BY id DESC LIMIT 1"));
																					$BID = $A[0] + 1;
																					# Создаем бекап
																					mysqli_query($this->connectMainBD, "INSERT INTO `backups` (`sid`, `bid`, `item_id`) VALUES ('".intval(SID)."', '".intval($BID)."', '".intval(ITEM_ID)."')");
																					# Создадим файл
																					file_put_contents('uploads/'.md5(SID).'/backup_'.md5($BID.ITEM_ID), $_POST['items']);
																				}
																			}
																			# Запрос в базу
																			mysqli_query($this->connectMainBD, "UPDATE `items` SET `count` = '".intval($count)."' WHERE `sid` = '".intval(SID)."' AND `id` = '".intval(ITEM_ID)."'");
																		}
																		# Редирект
																		$this->redirect('/admin/items');
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						# Удаление товара
						} else if($params[3] == "delete"){
							# ID товара
							if(isset($params[4])){
								# Запросы
								$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `item_id` = '".intval($params[4])."'"));
								# ID товара
								Define("ITEM_ID", $ITEM['id']);
								# Поиск бекапов
								$SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `backups` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval(ITEM_ID)."'");							
								# Бекапы нашлись
								if(mysqli_num_rows($SQL1) > 0){
									# Прогоним циклом и удалим
									while($row = mysqli_fetch_array($SQL1)){
										# Удалим из базы данных
										mysqli_query($this->connectMainBD, "DELETE FROM `backup` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['bid'])."'");
										# Удалим файл бекапа
										unlink('uploads/'.md5(SID).'/backup_'.md5($row['bid'].ITEM_ID));
									}
								}
								# Удалим товар
								mysqli_query($this->connectMainBD, "DELETE FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval(ITEM_ID)."'");
								# Удалим файл товара
								unlink('uploads/'.md5(SID).'/'.md5(ITEM_ID));
								# Редирект
								$this->redirect('/admin/items');
							# Параметр не передан, Редирект
							} else $this->redirect('/admin/items');
						# Сортировка товара
						} else if($params[3] == "sort"){
							# Прогоним циклом
							foreach($_POST['item'] as $id => $item_id){
								# Поменяем местами
								mysqli_query($this->connectMainBD, "UPDATE `items` SET `item_id` = '".intval($id + 1)."' WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($item_id)."'");
							}
							# Выходим
							die;
						} else if($params[3] == "backup"){
							# Скачивание бекапа
							if($params[4] == "download"){
								# Параметры переданы
								if($params[5] > 0 && $params[6] > 0){
									# Поиск бекапа
									$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `backups` WHERE `sid` = '".intval(SID)."' AND `bid` = '".intval($params[6])."'");
									# Бекап существует
									if(mysqli_num_rows($SQL) > 0){
										# Определим название
										$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($params[5])."'"));
										# Заголовок для скачивания
										Header('Content-Type: application/octet-stream');
										# Товар пользователя
										Header('Content-Disposition: attachment; filename="'.$ITEM['item'].'.txt"');
										# Отдаем заказ пользовователю
										die(file_get_contents('uploads/'.md5(SID).'/backup_'.md5($params[6].$params[5])));
									}
								}
							}
							
							# ID Товара
							Define("BID", $params[4]);
						# Просмотр товара
						} else if($params[3] > 0){
							# ID Страницы
							Define("PID", $params[3]);
						}
					}
				}
				$this->loadAdmin('items');
			# Заказы
			} else if($params[2] == "orders"){
				# Страница не передана, Редирект
				if(!isset($params[3]) || $params[3] == ""){
					$this->redirect('/admin/orders/1');
				}
				# Third parametr
				if(isset($params[3])){
					# Access ok
					if($_SESSION['admPrivilege']['orders'] == true){
						# Скачивание заказа
						if($params[3] == "download"){
							# Заказ
							if($params[4] > 0){
								# Запросы
								$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `oid` = '".intval($params[4])."'");
								$ORDER = mysqli_fetch_array($SQL);
								$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($ORDER['item_id'])."'"));	
								# Заказ не существует
								if(mysqli_num_rows($SQL) > 0){
									# По строкам
									if($ITEM['type'] == "text"){
										# Заголовок для скачивания
										Header('Content-Type: application/octet-stream');
										# Товар пользователя
										Header('Content-Disposition: attachment; filename="Товар.txt"');
										# Отдаем заказ пользовователю
										die(file_get_contents('uploads/'.md5(SID).'/orders/'.md5($ORDER['id'])));
									# Файл
									} else if($ITEM['type'] == "file"){
										# Заголовок для скачивания
										Header('Content-Type: application/octet-stream');
										# Товар пользователя
										Header('Content-Disposition: attachment; filename="Товар.txt"');
										# Отдаем товар пользовователю
										die(file_get_contents('uploads/'.md5(SID).'/'.md5($ITEM['id'])));
									}
								# Ошибка
								} else die('Ошибка скачивания заказа.');
							# Неверная страница
							} else $this->redirect('/admin/orders/1');
						# Страница передана
						} else if($params[3] > 0){
							# ID Страницы
							Define("PID", intval($params[3]));
						}
					} else $this->redirect('/admin/orders/1');
				}
				$this->loadAdmin('orders');
			# Страницы
			} else if($params[2] == "pages"){
				# Thrird Paramets
				if(isset($params[3])){
					# Access ok
					if($_SESSION['admPrivilege']['pages'] == true){
						# Редактирование страницы
						if($params[3] == "edit"){
							# ID Страницы
							if($params[4] > 0){
								# ID Страницы
								Define("EID", $params[4]);
								# POST
								if($_POST){
									# Заголовок страницы
									if(isset($_POST['title'])){
										# Описание страницы
										if(isset($_POST['body'])){
											# Добавим товар
											mysqli_query($this->connectMainBD, "UPDATE `pages` SET `title` = '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['title']))."', `body` = '".mysqli_real_escape_string($this->connectMainBD, $_POST['body'])."' WHERE `sid` = '".intval(SID)."' AND `pid` = '".intval(EID)."'");
											# Редирект
											$this->redirect('/admin/pages');
										}
									}
								}
							# Параметр не передан, Редирект
							} else $this->redirect('/admin/pages');
						# Добавление страницы
						} else if($params[3] == "add"){
							# Запросы
							$PAGE = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."' ORDER BY pid DESC LIMIT 1"));
							# Следующий товар
							Define("PAGE_ID", ($PAGE['pid'] + 1));
							# POST
							if($_POST){
								# Заголовок страницы
								if(isset($_POST['title'])){
									# Описание страницы
									if(isset($_POST['body'])){
										# Добавим товар
										mysqli_query($this->connectMainBD, "INSERT INTO `pages` (`pid`, `sid`, `title`, `body`) VALUES ('".intval(PAGE_ID)."', '".intval(SID)."', '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['title']))."', '".mysqli_real_escape_string($this->connectMainBD, $_POST['body'])."')");
										# Редирект
										$this->redirect('/admin/pages');
									}
								}
							}
						# Удаление страницы
						} else if($params[3] == "delete"){
							# ID Страницы
							if($params[4] > 0){
								# ID Страницы
								Define("PAGE_ID", $params[4]);
								# Удалим страницу
								mysqli_query($this->connectMainBD, "DELETE FROM `pages` WHERE `sid` = '".intval(SID)."' AND `pid` = '".intval(PAGE_ID)."'");
								# Редирект
								$this->redirect('/admin/pages');
							# Параметр не передан, Редирект
							} else $this->redirect('/admin/pages');
						# Сортировка страниц
						} else if($params[3] == "sort"){
							# Прогоним циклом
							foreach($_POST['page'] as $id => $pid){
								# Поменяем местами
								mysqli_query($this->connectMainBD, "UPDATE `pages` SET `pid` = '".intval($id + 1)."' WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($pid)."'");
							}
							# Выходим
							die;
						# Просмотр страниц
						} else if($params[3] > 0){
							# ID Страницы
							Define("PID", $params[3]);
						}
					}
				} else $this->redirect('/admin/pages/1');
				$this->loadAdmin('pages');
			# Категории
			} else if($params[2] == "categories"){
				# Third parametr
				if(isset($params[3])){
					# Access ok
					if($_SESSION['admPrivilege']['categories'] == true){
						# Редактирование категории
						if($params[3] == "edit"){
							# ID Категории
							if($params[4] > 0){
								# ID Категории
								Define("EID", $params[4]);
								# POST
								if($_POST){
									# Заголовок страницы
									if(isset($_POST['category'])){
										# Описание страницы
										if(isset($_POST['name'])){
											# На главной
											if($_POST['main'] == "0" || $_POST['main'] == "1"){
												# Добавим товар
												mysqli_query($this->connectMainBD, "UPDATE `categories` SET `category` = '".mysqli_real_escape_string($this->connectMainBD, $_POST['category'])."', `name` = '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['name']))."', `main` = '".intval($_POST['main'] == 1 ? 1 : 0)."' WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(EID)."'");
												# Редирект
												$this->redirect('/admin/categories');
											}
										}
									}
								}
							# Параметр не передан, Редирект
							} else $this->redirect('/admin/categories');
						# Добавление категории
						} else if($params[3] == "add"){
							# Запросы
							$row = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."' ORDER BY cid DESC LIMIT 1"));
							# Следующая категория
							Define("CID", ($row['cid'] + 1));
							# POST
							if($_POST){
								# Заголовок страницы
								if(isset($_POST['category'])){
									# Описание страницы
									if(isset($_POST['name'])){
										# На главной
										if($_POST['main'] == "0" || $_POST['main'] == "1"){
											# Добавим товар
											mysqli_query($this->connectMainBD, "INSERT INTO `categories` (`cid`, `sid`, `category`, `name`, `main`) VALUES ('".intval(CID)."', '".intval(SID)."', '".mysqli_real_escape_string($this->connectMainBD, $_POST['category'])."', '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['name']))."', '".intval($_POST['main'])."')");
											# Редирект
											$this->redirect('/admin/categories');
										}
									}
								}
							}
						# Удаление страницы
						} else if($params[3] == "delete"){
							# ID Страницы
							if($params[4] > 0){
								# ID Страницы
								Define("CID", $params[4]);
								# Удалим страницу
								mysqli_query($this->connectMainBD, "DELETE FROM `categories` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."'");
								# Редирект
								$this->redirect('/admin/categories');
							# Параметр не передан, Редирект
							} else $this->redirect('/admin/categories');
						# Сортировка страниц
						} else if($params[3] == "sort"){
							# Прогоним циклом
							foreach($_POST['category'] as $id => $cid){
								# Поменяем местами
								mysqli_query($this->connectMainBD, "UPDATE `categories` SET `cid` = '".intval($id + 1)."' WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($cid)."'");
							}
							# Выходим
							die;
						}
					}
				}
				$this->loadAdmin('categories');
			# Статистика
			} else if($params[2] == "statistics"){
				$this->loadAdmin('statistics');
			# Безопасность
			} else if($params[2] == "secure"){
				# Thirt parametr
				if(isset($params[3])){
					# Access ok
					if($_SESSION['admPrivilege']['secure'] == true){
						# Смена пароля
						if($params[3] == "password"){
							# POST
							if($_POST){
								# Проверка пароля
								if(isset($_POST['password'])){
									# Проверка нового пароля
									if(isset($_POST['newpassword'])){
										# Запросы
										$USER = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `users` WHERE `sid` = '".intval(SID)."' AND `uid` = '".intval($_SESSION['id'])."'"));
										# Сверяем пароль
										if(md5($_POST['password']) == $USER['password']){
											# Меняем пароль
											mysqli_query($this->connectMainBD, "UPDATE `users` SET `password` = '".md5($_POST['newpassword'])."' WHERE `sid` = '".intval(SID)."' AND `uid` = '".intval($_SESSION['id'])."'");
											# Выходим из системы
											$this->redirect('/admin/logout');
										}
									}
								}
							}
						# Блокировка IP-Адреса
						} else if($params[3] == "block"){
							# Four parametr
							if(isset($params[4])){
								# Удаление из базы
								if($params[4] == "delete"){
									# Передан ID
									if($params[5] > 0){
										mysqli_query($this->connectMainBD, "DELETE FROM `block_ip` WHERE `sid` = '".intval(SID)."' AND `bid` = '".intval($params[5])."'");
									}
								}
							}
							# POST
							if($_POST){
								# Проверка полей
								if($_POST['ip']){
									# Запросы
									$BLOCK_IP = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `block_ip` WHERE `sid` = '".intval(SID)."' ORDER BY bid DESC LIMIT 1"));
									# Следующий ID
									Define("BID", ($BLOCK_IP['bid'] + 1));
									# Валидация
									if(filter_var($_POST['ip'], FILTER_VALIDATE_IP)){
										# Добавляем в базу
										mysqli_query($this->connectMainBD, "INSERT INTO `block_ip` (`bid`, `sid`, `ip`) VALUES ('".intval(BID)."', '".intval(SID)."', '".mysqli_real_escape_string($this->connectMainBD, $_POST['ip'])."')");
									}
								}
							}
						}
					}
				}
				$this->loadAdmin('secure');
			# Пользователи
			} else if($params[2] == "users"){
				# Thirt parametr
				if(isset($params[3])){
					# Access ok
					if($_SESSION['admPrivilege']['users'] == true){
						# Редактирование пользователя
						if($params[3] == "edit"){
							# ID Пользователя
							if($params[4] > 0){
								# ID Пользователя
								Define("EID", $params[4]);
								# Привязка uLogin
								if(isset($_POST['token'])){
									# Обратимся к uLogin
									$a = file_get_contents('http://ulogin.ru/token.php?token='.$_POST['token'].'&host='.$_SERVER['HTTP_HOST']);
									$obj = json_decode($a, true);
									# Запросы
									$USER = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `users` WHERE `sid` = '".intval(SID)."' AND `uid` = '".intval(EID)."'"));
									# Привязанные системы
									$arr = json_decode($USER['ulogin'], true);
									# Поиск
									$search = array_search($obj['identity'], $arr);
									# Аккаунт найден
									if($search !== FALSE){
										# Отвяжем систему
										$arr[$search] = "";
										# Запрос к базе
										mysqli_query($this->connectMainBD, "UPDATE `users` SET `ulogin` = '".json_encode($arr)."' WHERE `sid` = '".intval(SID)."' AND `uid` = '".intval(EID)."'");
									} else {
										# ВКонтакте
										if(preg_match('/vk.com/', $obj['identity']) == TRUE){
											$arr[0] = $obj['identity'];
										} else if(preg_match('/mail.ru/', $obj['identity']) == TRUE){
											$arr[1] = $obj['identity'];
										} else if(preg_match('/ok.ru/', $obj['identity']) == TRUE){
											$arr[2] = $obj['identity'];
										} else if(preg_match('/openid.yandex.ru/', $obj['identity']) == TRUE){
											$arr[3] = $obj['identity'];
										}							
										# Запрос к базе
										mysqli_query($this->connectMainBD, "UPDATE `users` SET `ulogin` = '".json_encode($arr)."' WHERE `sid` = '".intval(SID)."' AND `uid` = '".intval(EID)."'");
									}
								} else {
									
									// die(var_dump($_POST));
									
									# Логин введен
									if(isset($_POST['login'])){
										# Почта введена
										if(isset($_POST['email'])){
											# Пароль введен
											if(isset($_POST['password'])){
												# Валидация почты
												if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
													# Превилегии пользователя
													$privilege = Array();
													$array = Array("items", "orders", "pages", "categories", "statistics", "secure", "logs", "users", "settings", "codes", "gifts", "templates");
													# Массив с превилегиями
													foreach($array as $id => $name){
														$privilege[$name] = (isset($_POST['privilege'][$name]) ? ($_POST['privilege'][$name] == 1 ? 1 : 0) : 0);
													}
													# Добавим в базу
													mysqli_query($this->connectMainBD, "UPDATE `users` SET `login` = '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['login']))."', `email` = '".mysqli_real_escape_string($this->connectMainBD, $_POST['email'])."', `password` = '".md5($_POST['password'])."', `privilege` = '".json_encode($privilege)."' WHERE `sid` = '".intval(SID)."' AND `uid` = '".intval(EID)."'");
													# Редирект
													$this->redirect('/admin/users');
												}
											}
										}
									}
								}
							# Параметр не передан, Редирект
							} else $this->redirect('/admin/users');
						# Добавление пользователя
						} else if($params[3] == "add"){
							# Запросы
							$row = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `users` WHERE `sid` = '".intval(SID)."' ORDER BY uid DESC LIMIT 1"));
							# Следующий пользователь
							Define("UID", ($row['uid'] + 1));
							# Логин введен
							if(isset($_POST['login'])){
								# Почта введена
								if(isset($_POST['email'])){
									# Пароль введен
									if(isset($_POST['password'])){
										# Валидация почты
										if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
											# Превилегии пользователя
											$privilege = Array();
											$array = Array("items", "orders", "pages", "categories", "statistics", "secure", "logs", "users", "settings", "codes", "gifts", "templates");
											# Массив с превилегиями
											foreach($array as $id => $name){									
												$privilege[$name] = (isset($_POST['privilege'][$name]) ? ($_POST['privilege'][$name] == 1 ? 1 : 0) : 0);
											}
											# Добавим в базу
											mysqli_query($this->connectMainBD, "INSERT INTO `users` (`sid`, `uid`, `login`, `email`, `password`, `privilege`) VALUES ('".intval(SID)."', '".intval(UID)."', '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['login']))."', '".mysqli_real_escape_string($this->connectMainBD, $_POST['email'])."', '".md5($_POST['password'])."', '".json_encode($privilege)."')");
											# Редирект
											$this->redirect('/admin/users');
										}
									}
								}
							}
						# Сортировка пользователей
						} else if($params[3] == "sort"){
							# Прогоним циклом
							foreach($_POST['user'] as $id => $uid){
								# Поменяем местами
								mysqli_query($this->connectMainBD, "UPDATE `users` SET `uid` = '".intval($id + 1)."' WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($uid)."'");
							}
							# Выходим
							die;
						# Удаление страницы
						} else if($params[3] == "delete"){
							# ID Страницы
							if($params[4] > 0){
								# ID Страницы
								Define("UID", $params[4]);
								# Удалим страницу
								mysqli_query($this->connectMainBD, "DELETE FROM `users` WHERE `sid` = '".intval(SID)."' AND `uid` = '".intval(UID)."'");
								# Редирект
								$this->redirect('/admin/users');
							# Параметр не передан, Редирект
							} else $this->redirect('/admin/users');
						}
					}
				}
				$this->loadAdmin('users');
			# Настройки
			} else if($params[2] == "settings"){
				# Third parametr
				if(isset($params[3])){
					# Access ok
					if($_SESSION['admPrivilege']['settings'] == true){
						# Удаление ключ-файла
						if($params[3] == "key"){
							# Настройки
							$obj = json_decode(file_get_contents('config.json'), true);
							# Удаляем ключ-файл
							unlink('uploads/'.md5(SID).'/'.$obj['settings']['wm_key'].'.kwm');
							# Изменяем конфиг
							$obj['settings']['wm_key'] = "";
							# Обновляем конфиг
							file_put_contents('config.json', json_encode($obj));
							# Редирект
							$this->redirect('/admin/settings');
						}
					}
				# Настройки
				} else {
					# POST
					if($_POST){
						# Access ok
						if($_SESSION['admPrivilege']['settings'] == true){
							# Настройки
							$obj = json_decode(file_get_contents('config.json'), true);
							# Вебмани пароль
							$wm_pass = $obj['settings']['wm_pass'];
							# Киви пароль
							$qiwi_pass = $obj['settings']['qiwi_pass'];
							# Методы оплаты
							foreach($obj['wallets'] as $wallet => $value){						
								# Зададим кошелёк
								$obj['wallets'][$wallet] = ($_POST['wallets'][$wallet] != "" ? $_POST['wallets'][$wallet] : false);
							}
							# Настройки
							foreach($obj['settings'] as $setting => $value){		
								# Ключ-файл
								if($setting == "wm_key"){
									# WM Key
									if(isset($_FILES['settings']['name']['wm_key'])){
										# Только kwm
										if(substr(strrchr($_FILES['settings']['name']['wm_key'], '.'), 1) == "kwm"){
											# Имя ключ-файла
											$key = time();
											# Загружаем файл
											if(copy($_FILES['settings']['tmp_name']['wm_key'], 'uploads/'.md5(SID).'/'.$key.'.kwm')){
												$obj['settings']['wm_key'] = $key;
											}
										}
									}
								# Остальное
								} else {
									# Зададим настройку
									$obj['settings'][$setting] = htmlspecialchars($_POST['settings'][$setting]);
								}
							}
							# Payeer Shop ID
							if(isset($_POST['settings']['py_shop'])){
								# Старый ID
								if(isset($obj1['py_shop'])){
									# Удалим старый файл
									unlink('/home/'.$_SERVER['HTTP_HOST'].'/www/payeer_'.$obj1['py_shop'].'.txt');
								}
								# Создадим файл для подтверждения
								file_put_contents('/home/'.$_SERVER['HTTP_HOST'].'/www/payeer_'.intval($_POST['settings']['py_shop']).'.txt', intval($_POST['settings']['py_shop']));
							}
							# Prefix billPay
							if(isset($_POST['settings']['prefix'])){
								$obj['settings']['prefix'] = $_POST['settings']['prefix'];
							}
							# keywords 
							if(isset($_POST['settings']['keywords'])){
								$obj['settings']['keywords'] = $_POST['settings']['keywords'];
							}
							# description
							if(isset($_POST['settings']['description'])){
								$obj['settings']['description'] = $_POST['settings']['description'];
							}
							# Вебмани пароль
							if($_POST['settings']['wm_pass'] != "********"){
								$obj['settings']['wm_pass'] = $this->encode($_POST['settings']['wm_pass']);
							} else $obj['settings']['wm_pass'] = $wm_pass;
							# Киви пароль
							if($_POST['settings']['qiwi_pass'] != "********"){
								$obj['settings']['qiwi_pass'] = $this->encode($_POST['settings']['qiwi_pass']);
							} else $obj['settings']['qiwi_pass'] = $qiwi_pass;
							# Новый конфиг
							$update = file_put_contents('config.json', json_encode($obj));
							# Тип авторизации
							if($_POST['settings']['authorization'] == "1"){
								/*
									Защита от дураков
									Запрет на установку двухфакторной авторизации
									Если не настроил социальную сеть в профиле
								*/
								# По умолчанию
								$ulogin = false;
								# Настройки
								$obj = json_decode(file_get_contents('config.json'), true);
								# Пользователь
								$USER = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `users` WHERE `uid` = '".intval($_SESSION['id'])."' AND `sid` = '".intval(SID)."'"));
								# Выключено
								if($USER['ulogin'] != ""){
									$obj = json_decode($USER['ulogin'], true);
									foreach($obj as $id => $a){
										if($a != ""){
											$ulogin = true;
										}
									}
								}
								# Вклюечено
								if($ulogin == true){
									# Включим авторизацию
									$_SESSION['ulogin'] = true;
									# Редирект
									$this->redirect('/admin/users/edit/'.$_SESSION['id']);
								} else {
									# Настройки
									$obj = json_decode(file_get_contents('config.json'), true);
									# Выключим двухфакторную авторизацию
									$obj['settings']['authorization'] = "0";
									# Новый конфиг
									$update = file_put_contents('config.json', json_encode($obj));
									$_SESSION['err'] = 'Для включения двухфакторной авторизации привяжите хотя бы одну систему к своему аккаунту.';
								}
							} else {
								# Редирект
								$this->redirect('/admin/settings');
							}
						}
					}
					$this->loadAdmin('settings');
				}
			# Купоны
			} else if($params[2] == "codes"){
				# Thirt parametr
				if(isset($params[3])){
					# Access ok
					if($_SESSION['admPrivilege']['codes'] == true){
						# Редактирование купона
						if($params[3] == "edit"){
							# ID купона
							if($params[4] > 0){
								# ID купона
								Define("EID", $params[4]);
								# Купон передан
								if(isset($_POST['code'])){
									# Скидка передана
									if($_POST['discount'] > 0 && $_POST['discount'] <= 100){
										# Купон не для всех товаров
										if($_POST['item'] != "*"){
											# Запросы
											$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `item_id` = '".intval($_POST['item'])."' AND `sid` = '".intval(SID)."'");
										}
										# Товар существует
										if($_POST['item'] == "*" || @mysqli_num_rows($SQL) > 0){
											# Купон не для всех товаров
											if($_POST['item'] != "*"){
												# Запросы
												$ITEM = mysqli_fetch_array($SQL);
											}
											# Редактируем купон
											mysqli_query($this->connectMainBD, "UPDATE `codes` SET `code` = '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['code']))."', `discount` = '".intval($_POST['discount'])."', `count` = '".intval($_POST['count'])."', `item` = '".($_POST['item'] == "*" ? "*" : intval($ITEM['id']))."' WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(EID)."'");
											# Редирект
											$this->redirect('/admin/codes');
										}
									}
								}
							# Параметр не передан, Редирект
							} else $this->redirect('/admin/codes');
						# Добавление купона
						} else if($params[3] == "add"){
							# Запросы
							$row = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `codes` WHERE `sid` = '".intval(SID)."' ORDER BY cid DESC LIMIT 1"));
							# Следующий купон
							Define("CID", ($row['cid'] + 1));		
							# Post
							if($_POST){
								# Обычный купон
								if($_POST['type'] == "single"){
									# Купон передан
									if(isset($_POST['code'])){
										# Скидка передана
										if($_POST['discount'] > 0 && $_POST['discount'] <= 100){
											# Товар передан
											if(isset($_POST['item'])){
												# Купон не для всех товаров
												if($_POST['item'] != "*"){
													# Запросы
													$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `item_id` = '".intval($_POST['item'])."' AND `sid` = '".intval(SID)."'");
												}
												# Товар существует
												if(mysqli_num_rows($SQL) > 0 || $_POST['item'] == "*"){
													# Купон не для всех товаров
													if($_POST['item'] != "*"){
														# Запросы
														$ITEM = mysqli_fetch_array($SQL);
													}
													# Добавляем купон
													mysqli_query($this->connectMainBD, "INSERT INTO `codes` (`sid`, `cid`, `code`, `discount`, `count`, `item`) VALUES ('".intval(SID)."', '".intval(CID)."', '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['code']))."', '".intval($_POST['discount'])."', '".intval($_POST['count'])."', '".($_POST['item'] == "*" ? "*" : intval($ITEM['id']))."')");
													# Редирект
													$this->redirect('/admin/codes');
												}
											}
										}
									}
								# Партия купонов
								} else if($_POST['type'] == "reusable"){
									# Слог передан
									if(isset($_POST['slog'])){
										# Скидка передана
										if($_POST['discount'] > 0 && $_POST['discount'] <= 100){
											# Товар передан
											if(isset($_POST['item'])){
												# Не больше 20
												if($_POST['count_slog'] <= 20){									
													# Запросы
													$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `item_id` = '".intval($_POST['item'])."' AND `sid` = '".intval(SID)."'");
													# Товар существует
													if(mysqli_num_rows($SQL) > 0){
														# Запросы
														$ITEM = mysqli_fetch_array($SQL);
														# Прогоняем циклом
														for($i = 0; $i < $_POST['count_slog']; $i++){
															# Добавляем купоны
															mysqli_query($this->connectMainBD, "INSERT INTO `codes` (`sid`, `cid`, `code`, `discount`, `item`, `type`) VALUES ('".intval(SID)."', '".(intval(CID)+$i)."', '".(mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['slog'])).rand(1000, 9999))."', '".intval($_POST['discount'])."', '".intval($ITEM['id'])."', 'reusable')");
														}
														# Редирект
														$this->redirect('/admin/codes');
													}
												}
											}
										}
									}
								}
							}
						# Сортировка купонов
						} else if($params[3] == "sort"){
							# Прогоним циклом
							foreach($_POST['code'] as $id => $cid){
								# Поменяем местами
								mysqli_query($this->connectMainBD, "UPDATE `codes` SET `cid` = '".intval($id + 1)."' WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($cid)."'");
							}
							# Выходим
							die;
						# Удаление купона
						} else if($params[3] == "delete"){
							# ID купона
							if($params[4] > 0){
								# ID купона
								Define("СID", $params[4]);
								# Удалим страницу
								mysqli_query($this->connectMainBD, "DELETE FROM `codes` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(СID)."'");
								# Редирект
								$this->redirect('/admin/codes');
							# Параметр не передан, Редирект
							} else $this->redirect('/admin/codes');
						}
					}
				}
				$this->loadAdmin('codes');
			# Раздачи
			} else if($params[2] == "gifts"){
				# Запросы
				$GIFT = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `gifts` WHERE `sid` = '".intval(SID)."' ORDER BY gid DESC"));
				# Следующий номер
				Define("GID", ($GIFT['gid'] + 1));
				# POST
				if($_POST){
					# Access ok
					if($_SESSION['admPrivilege']['gifts'] == true){
						# Имя раздачи передано
						if(isset($_POST['gift'])){
							# Изоображение передано
							if(isset($_POST['image'])){
								# Описание передано
								if(isset($_POST['desc'])){
									# Время завершения передано
									if(isset($_POST['time'])){
										# Группа ВКонтакте передана
										if(isset($_POST['vk'])){
											# Регулярка									 
											preg_match_all("/(.{3}[0-9])-(.{1}[0-9])-(.{1}[0-9]) (.{1}[0-9]):(.{1}[0-9]):(.{1}[0-9])/", $_POST['time'], $matches);
											# Время
											$hour = @$matches[4][0];
											$minute = @$matches[5][0];
											$second = @$matches[6][0];
											$month = @$matches[2][0];
											$day = @$matches[3][0];
											$year = @$matches[1][0];
											# Время завершения
											$time = mktime($hour, $minute, $second, $month, $day, $year);
											# Запросы
											$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `gifts` WHERE `sid` = '".intval(SID)."' AND `time` > '".time()."' ORDER BY gid DESC LIMIT 1");
											# Редактирование
											if(mysqli_num_rows($SQL) > 0){
												# Раздача
												$GIFT = mysqli_fetch_array($SQL);
												# Обновим
												mysqli_query($this->connectMainBD, "UPDATE `gifts` SET `gift` = '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['gift']))."', `image` = '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['image']))."', `desc` = '".mysqli_real_escape_string($this->connectMainBD, $_POST['desc'])."', `vk` = '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['vk']))."', `time` = '".intval($time)."' WHERE `sid` = '".intval(SID)."' AND `gid` = '".intval($GIFT['gid'])."'");
											# Добавление
											} else {
												# Добавим
												mysqli_query($this->connectMainBD, "INSERT INTO `gifts` (`gid`, `sid`, `gift`, `image`, `desc`, `vk`, `time`, `winner`, `users`) VALUES ('".intval(GID)."', '".intval(SID)."', '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['gift']))."', '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['image']))."', '".mysqli_real_escape_string($this->connectMainBD, $_POST['desc'])."', '".mysqli_real_escape_string($this->connectMainBD, htmlspecialchars($_POST['vk']))."', '".intval($time)."', '', '')");
											}
										}
									}
								}
							}
						}
					}
					# Редирект
					$this->redirect('/admin/gifts');
				}
				$this->loadAdmin('gifts');
			# Шаблоны
			} else if($params[2] == "templates"){
				# Настройка шаблонов
				if($_POST){
					# Access ok
					if($_SESSION['admPrivilege']['templates'] == true){
						# Парсим конфиг
						$CONFIG = json_decode(CONFIG, true);
						# Шаблон
						if(isset($_POST['template'])){
							# Массив шаблонов
							$templates = Array("Universal", "Premium", "Perfect", "Paradox", "Mirage", "Mamba", "Lollipop", "Lite", "Liberty", "Game", "Galaxy", "Elegant", "default", "Boxy", "Aqua", "Deer", "SellWhite", "ZakaBlue", "StempPay", "ShopNew", "WhiteBs", "Lilac", "Crazzy", "Lucky", "IgorFox", "Games", "Lololoshka", "Keys", "Wf", "LqShop");
							# Шаблон существует
							if(array_search($_POST['template'], $templates) !== FALSE){
								$CONFIG['template'] = $_POST['template'];
							}
						}
						# Название магазина
						$CONFIG['title'] = htmlspecialchars($_POST['title']);
						$CONFIG['logotype'] = htmlspecialchars($_POST['logotype']);
						$CONFIG['information'] = $_POST['information'];
						$CONFIG['contacts'] = $_POST['contacts'];
						$CONFIG['scripts'] = $_POST['scripts'];
						$CONFIG['background'] = htmlspecialchars($_POST['background']);
						$CONFIG['colordefault'] = htmlspecialchars($_POST['colordefault']);
						$CONFIG['colordefaultpk'] = htmlspecialchars($_POST['colordefaultpk']);
                        $CONFIG['colorboxyverx'] = htmlspecialchars($_POST['colorboxyverx']);
						$CONFIG['colorboxypay'] = htmlspecialchars($_POST['colorboxypay']);
						$CONFIG['colorboxyopl'] = htmlspecialchars($_POST['colorboxyopl']);
						$CONFIG['colorelegantmn'] = htmlspecialchars($_POST['colorelegantmn']);
						$CONFIG['colorelegantop'] = htmlspecialchars($_POST['colorelegantop']);
						$CONFIG['colorgamefon'] = htmlspecialchars($_POST['colorgamefon']);
						$CONFIG['colorgameverx'] = htmlspecialchars($_POST['colorgameverx']);
						$CONFIG['colorlibertyblock'] = htmlspecialchars($_POST['colorlibertyblock']);
						$CONFIG['colorlibertyfon'] = htmlspecialchars($_POST['colorlibertyfon']);
						$CONFIG['colorliteblock'] = htmlspecialchars($_POST['colorliteblock']);
						$CONFIG['colorliteverx'] = htmlspecialchars($_POST['colorliteverx']);
						$CONFIG['colorliteitem'] = htmlspecialchars($_POST['colorliteitem']);
						$CONFIG['colorlitenazv'] = htmlspecialchars($_POST['colorlitenazv']);
						$CONFIG['colorlolipopblock'] = htmlspecialchars($_POST['colorlolipopblock']);
						$CONFIG['colorlolipopklick'] = htmlspecialchars($_POST['colorlolipopklick']);
						$CONFIG['colorlolipopklickfn'] = htmlspecialchars($_POST['colorlolipopklickfn']);
						$CONFIG['colorperfectblock'] = htmlspecialchars($_POST['colorperfectblock']);
						$CONFIG['colorperfectverx'] = htmlspecialchars($_POST['colorperfectverx']);
						$CONFIG['colordeercateg'] = htmlspecialchars($_POST['colordeercateg']);
						$CONFIG['colordeertovar'] = htmlspecialchars($_POST['colordeertovar']);
						$CONFIG['colordeeritem'] = htmlspecialchars($_POST['colordeeritem']);
						$CONFIG['colordeerprt'] = htmlspecialchars($_POST['colordeerprt']);
						$CONFIG['colorlibertyitem'] = htmlspecialchars($_POST['colorlibertyitem']);
						$CONFIG['colorlibertyverx'] = htmlspecialchars($_POST['colorlibertyverx']);
						$CONFIG['colorgameopl'] = htmlspecialchars($_POST['colorgameopl']);
						$CONFIG['colorshopnewverx'] = htmlspecialchars($_POST['colorshopnewverx']);
						$CONFIG['colorshopnewnuz'] = htmlspecialchars($_POST['colorshopnewnuz']);
						$CONFIG['colorshopnewpay'] = htmlspecialchars($_POST['colorshopnewpay']);
						$CONFIG['colorshopnewfon'] = htmlspecialchars($_POST['colorshopnewfon']);
						$CONFIG['colorelegantpay'] = htmlspecialchars($_POST['colorelegantpay']);
	                    $CONFIG['colordefaultfon'] = htmlspecialchars($_POST['colordefaultfon']);
						$CONFIG['colorwhitebsok'] = htmlspecialchars($_POST['colorwhitebsok']);
						$CONFIG['colorwhitebstext'] = htmlspecialchars($_POST['colorwhitebstext']);
						$CONFIG['colorwhitebspay'] = htmlspecialchars($_POST['colorwhitebspay']);
						$CONFIG['colorwhitebsfon'] = htmlspecialchars($_POST['colorwhitebsfon']);
						$CONFIG['colorlilacpay'] = htmlspecialchars($_POST['colorlilacpay']);
						$CONFIG['colorlilaccn'] = htmlspecialchars($_POST['colorlilaccn']);
						$CONFIG['colorlilacfon'] = htmlspecialchars($_POST['colorlilacfon']);
						$CONFIG['colorcrazzyfon'] = htmlspecialchars($_POST['colorcrazzyfon']);
						$CONFIG['colorluckyverx'] = htmlspecialchars($_POST['colorluckyverx']);
						$CONFIG['colorluckynuz'] = htmlspecialchars($_POST['colorluckynuz']);
						$CONFIG['colorluckyfon'] = htmlspecialchars($_POST['colorluckyfon']);
						$CONFIG['colordefaulttext'] = htmlspecialchars($_POST['colordefaulttext']);
						$CONFIG['colorgamesfon'] = htmlspecialchars($_POST['colorgamesfon']);
						$CONFIG['colorgamesverx'] = htmlspecialchars($_POST['colorgamesverx']);
						$CONFIG['colorgamestvr'] = htmlspecialchars($_POST['colorgamestvr']);
						$CONFIG['colorgamespay'] = htmlspecialchars($_POST['colorgamespay']);
						$CONFIG['colorlqshopfon'] = htmlspecialchars($_POST['colorlqshopfon']);
						$CONFIG['colorlqshopverx'] = htmlspecialchars($_POST['colorlqshopverx']);
						$CONFIG['colorlqshoppay'] = htmlspecialchars($_POST['colorlqshoppay']);
						$CONFIG['colorlqshoppayn'] = htmlspecialchars($_POST['colorlqshoppayn']);
						$CONFIG['colorlqshoppayk'] = htmlspecialchars($_POST['colorlqshoppayk']);
						$CONFIG['colorlqshoppayopl'] = htmlspecialchars($_POST['colorlqshoppayopl']);
						$CONFIG['colorlqshopborder'] = htmlspecialchars($_POST['colorlqshopborder']);
						$CONFIG['colorlqshopcolor'] = htmlspecialchars($_POST['colorlqshopcolor']);
						$CONFIG['colorkeysnuz'] = htmlspecialchars($_POST['colorkeysnuz']);
						$CONFIG['colorkeysfon'] = htmlspecialchars($_POST['colorkeysfon']);
						$CONFIG['colorkeysfonn'] = htmlspecialchars($_POST['colorkeysfonn']);
						$CONFIG['colorwfpanel'] = htmlspecialchars($_POST['colorwfpanel']);
						$CONFIG['colorwffonp'] = htmlspecialchars($_POST['colorwffonp']);
						$CONFIG['colorwffon'] = htmlspecialchars($_POST['colorwffon']);
						$CONFIG['coloraqua'] = htmlspecialchars($_POST['coloraqua']);
						$CONFIG['coloraquabg'] = htmlspecialchars($_POST['coloraquabg']);
						$CONFIG['coloraquapk'] = htmlspecialchars($_POST['coloraquapk']);
						$CONFIG['favicon'] = htmlspecialchars($_POST['favicon']);
						# Обновим файл конфигурации
						file_put_contents('config.json', json_encode($CONFIG));
					}
				}
				$this->loadAdmin('templates');
			# Логи авторизаций
			} else if($params[2] == "logs"){
				$this->loadAdmin('logs');
			# Выход
			} else if($params[2] == "logout"){
				session_destroy();
				Header('Location: /admin/');
				die;
			# Все остальное
			} else $this->page('404');
		# Заказы
		} else $this->redirect('/admin/orders');
	}
?>