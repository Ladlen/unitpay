<?	
	# ���������
	$SETTING = json_decode(SETTINGS, true);
	$WALLET = json_decode(WALLETS, true);
	# ��������
	if($WALLET['PAYEER'] == TRUE){
		# Operation ID + ���
		if(isset($_REQUEST['m_operation_id']) && isset($_REQUEST['m_sign'])){
			# ������
			$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `oid` = '".intval($_REQUEST['m_orderid'])."'");
			# ����� ����������
			if(mysqli_num_rows($SQL) > 0){
				# �������
				$ORDER = mysqli_fetch_array($SQL);
				# ���������� Payeer
				if(in_array($_SERVER['REMOTE_ADDR'], array('185.71.65.92', '185.71.65.189', '149.202.17.210'))){
					$m_key = $SETTING['py_key'];
					
					$arHash = array(
						$_REQUEST['m_operation_id'],
						$_REQUEST['m_operation_ps'],
						$_REQUEST['m_operation_date'],
						$_REQUEST['m_operation_pay_date'],
						$_REQUEST['m_shop'],
						$_REQUEST['m_orderid'],
						$_REQUEST['m_amount'],
						$_REQUEST['m_curr'],
						$_REQUEST['m_desc'],
						$_REQUEST['m_status']
					);

					if(isset($_REQUEST['m_params'])){
						$arHash[] = $_REQUEST['m_params'];
					}

					$arHash[] = $m_key;

					$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

					if($_REQUEST['m_sign'] == $sign_hash && $_REQUEST['m_status'] == 'success'){
						
						# �������
						$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($ORDER['item_id'])."'"));
						# ������� �� �������
						if($ITEM['type'] == "text"){
							# ���� � ������
							$file = file('uploads/'.md5(SID).'/'.md5($ITEM['id']));
							# ��������� �����
							$order = implode(array_splice($file, 0, $ORDER['count']));
							$file = implode($file);
							# ������� ���� ������
							file_put_contents('uploads/'.md5(SID).'/'.md5($ITEM['id']), $file);
							# �������� ��������� �����
							file_put_contents('uploads/'.md5(SID).'/orders/'.md5($ORDER['id']), $order);
							# ������� ������ ������
							mysqli_query($this->connectMainBD, "UPDATE `orders` SET `status` = '1' WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($ORDER['id'])."'");
							# ������� ����������
							mysqli_query($this->connectMainBD, "UPDATE `items` SET `count` = count-".$ORDER['count']." WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($ITEM['id'])."'");
						# ������� �����
						} else {
							# ������� ������ ������
							mysqli_query($this->connectMainBD, "UPDATE `orders` SET `status` = '1' WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($ORDER['id'])."'");
						}
						
						echo $_REQUEST['m_orderid'].'|success';
						
						exit;
					}

					echo $_REQUEST['m_orderid'].'|error';
				} else {
					# Bill
					$bill = str_replace(Array(PREFIX."[", "]"), Array("", ""), $ORDER['bill']);
					# ������� ������
					$_SESSION['wallet'] = "PAYEER";
					# ��������
					$this->redirect('/order/'.$bill);
				}
			}
		}
	}
?>