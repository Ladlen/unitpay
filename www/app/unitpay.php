<?php

$WALLET = json_decode(WALLETS, true);
if ($WALLET['UNITPAY'] != true) {
    die('Метод не поддерживается');
}

class UnitPay
{
    protected $get;

    protected $method;
    protected $params;

    protected $core;

    public function __construct($params, $core)
    {
        $this->get = $params;
        #$this->method = $params['method'];
        #$this->params = $params['params'];
        $this->core = $core;
    }

    protected function getIP()
    {
        return isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : $_SERVER['REMOTE_ADDR'];
    }

    protected function checkIp()
    {
        if (!in_array($this->getIP(), ['31.186.100.49', '178.132.203.105', '52.29.152.23', '52.19.56.234'])) {
            // Не понятно от кого запрос
            //die($this->getResponseError('Неизвестный IP'));

            $ORDER = mysqli_fetch_array(mysqli_query($this->core->connectMainBD,
                "SELECT * FROM `orders` WHERE `sid` = '" . intval(SID) . "' AND `oid` = '" . intval($this->get['account']) . "'"));
            # Bill
            $bill = str_replace([PREFIX . "[", "]"], ["", ""], $ORDER['bill']);
            # Система оплаты
            $_SESSION['wallet'] = "UNITPAY";
            $_SESSION['unitpay_paymentId'] = $this->get['paymentId'];
            # Редирект
            $this->core->redirect('/order/' . $bill);
        }
    }

    protected function checkParameters()
    {
        $SQL = mysqli_query($this->core->connectMainBD,
            "SELECT * FROM `orders` WHERE `sid` = '" . intval(SID) . "' AND `oid` = '" . intval($this->params['account']) . "'");
        if (!mysqli_num_rows($SQL)) {
            die($this->getResponseError('Не найден заказ ' . $this->params['account']));
        }

        $ORDER = mysqli_fetch_array($SQL);
        if ($ORDER['status'] != 0) {
            die($this->getResponseSuccess('Платеж уже существует'));
        }

        if ((float)$ORDER['price'] > (float)$this->params['orderSum']) {
            die($this->getResponseError('Суммы ' . $this->params['orderSum'] . ' руб. не достаточно для оплаты товара ' .
                'стоимостью ' . $ORDER['price'] . ' руб.'));
        }

        if ($this->params['orderCurrency'] != 'RUB') {
            die($this->getResponseError('Валюта платежа - рубли, а не ' . $this->params['orderCurrency']));
        }

        if ($this->getSignature($this->params, $this->method) != $this->params['signature']) {
            die($this->getResponseError('Не правильная сигнатура!'));
        }
    }

    protected function getResponseSuccess($message)
    {
        return json_encode([
            "result" => [
                "message" => $message,
            ],
        ]);
    }

    protected function getResponseError($message)
    {
        return json_encode([
            "error" => [
                "message" => $message,
            ],
        ]);
    }

    protected function getSignature(array $params, $method = null)
    {
        $SETTING = json_decode(SETTINGS, true);

        ksort($params);
        unset($params['sign']);
        unset($params['signature']);
        array_push($params, $SETTING['unitpay_secret_key']);  //d659beee8847b09f876e0f1c5e44f4d1
        if ($method) {
            array_unshift($params, $method);
        }

        return hash('sha256', join('{up}', $params));
    }

    protected function pay()
    {
        /*$ORDER = mysqli_fetch_array(mysqli_query($this->core->connectMainBD,
            "SELECT * FROM `orders` WHERE `sid` = '" . intval(SID) . "' AND `oid` = '" . intval($this->params['account']) . "'"));

        # Запросы
        $ITEM = mysqli_fetch_array(mysqli_query($this->core->connectMainBD,
            "SELECT * FROM `items` WHERE `sid` = '" . intval(SID) . "' AND `id` = '" . intval($ORDER['item_id']) . "'"));

        # Обновим статус заказа
        mysqli_query($this->core->connectMainBD, "UPDATE `orders` SET `status` = '1' WHERE `sid` = '" . intval(SID) . "' AND `id` = '" . intval($ORDER['id']) . "'");
        # Обновим количество
        mysqli_query($this->core->connectMainBD, "UPDATE `items` SET `count` = count-" . $ORDER['count'] . " WHERE `sid` = '" . intval(SID) . "' AND `id` = '" . intval($ITEM['id']) . "'");*/

        die($this->getResponseSuccess('Успешная покупка'));
    }

    public function run()
    {
        $this->checkIp();

        $this->method = $this->get['method'];
        $this->params = $this->get['params'];

        $this->checkParameters();

        switch ($this->method) {
            case 'check': {
                die($this->getResponseSuccess('Команда CHECK прошла успешно!'));
                break;
            }
            case 'pay': {
                $this->pay();
                break;
            }
            /*case 'error': {
                break;
            }*/
            default: {
                die($this->getResponseError('Метод ' . $this->method . ' не поддерживается'));
                break;
            }
        }
    }
}

(new UnitPay($_GET, $this))->run();
