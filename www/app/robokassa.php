<?
	# Настройки
	$WALLET = json_decode(WALLETS, true);
	# Проверка
	if($WALLET['ROBOKASSA'] == TRUE){
		# Заглушка для Робокассы
		if(isset($_POST['inv_id']) && isset($_POST['InvId']) && isset($_POST['out_summ']) && isset($_POST['OutSum']) && isset($_POST['Culture'])){
			# Запрос
			$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `oid` = '".intval($_POST['inv_id'])."'");
			# Заказ существует
			if(mysqli_num_rows($SQL) > 0){
				# Запросы
				$ORDER = mysqli_fetch_array($SQL);
				# Bill
				$bill = str_replace(Array(PREFIX."[", "]"), Array("", ""), $ORDER['bill']);
				# Система оплаты
				$_SESSION['wallet'] = "ROBOKASSA";
				# Редирект
				$this->redirect('/order/'.$bill);
			}
		}
	}
?>