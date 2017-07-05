<?
	include('system/helpers/yad_helper.php');
	
	function index(){
		$CONFIG = json_decode(CONFIG, true);
		$SETTING = json_decode(SETTINGS, true);
		$WALLETS = json_decode(WALLETS, true);
		$clid = $SETTING['yad_client_id'];
		$token = $SETTING['yad_token'];
		if((empty($token) && !empty($clid))){
			create_cid($clid);
			return null;
		}
		if(empty($clid)){
			echo 'Установите верный Client ID в настройках скрипта! </br> <a href="/admin/settings">Вернуться в админ-панель</a>';
		}
	}
	
	function token(){
		$CONFIG = json_decode(CONFIG, true);
		$SETTING = json_decode(SETTINGS, true);
		$WALLETS = json_decode(WALLETS, true);
		$clid = $SETTING['yad_client_id'];
		$token = $SETTING['yad_token'];
		if(empty($token)){
			$code = (isset($_GET['code']) ? $_GET['code'] : "");
			if($code != ""){
				$token = create_token($clid, $code);
				if((!empty($token['token']) && !empty($token['wallet']))){
					$CONFIG['settings']['yad_token'] = $token['token'];
					$CONFIG['wallets']['YAD'] = $token['wallet'];
					file_put_contents('config.json', json_encode($CONFIG));
					echo 'Яндекс успешно настроен! </br> <a href=\'/admin\'>Вернуться в админ-панель</a>';
					return null;
				}
				echo $token['error'];
			}
		}
	}
?>