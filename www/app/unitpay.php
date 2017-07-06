<?php

$WALLET = json_decode(WALLETS, true);
if ($WALLET['UNITPAY'] != true) {
    die('Метод не поддерживается');
}

class UnitPay
{
    protected $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    protected function getIP()
    {
        return isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : $_SERVER['REMOTE_ADDR'];
    }

    protected function checkIp()
    {
        if (!in_array(getIP(), ['31.186.100.49', '178.132.203.105', '52.29.152.23', '52.19.56.234'])) {
            // Не понятно от кого запрос
            die($this->getResponseError('Неизвестный IP'));
        }
    }

    protected function getResponseSuccess($message)
    {
        return json_encode(array(
            "jsonrpc" => "2.0",
            "result" => array(
                "message" => $message
            ),
            'id' => 1,
        ));
    }

    protected function getResponseError($message)
    {
        return json_encode(array(
            "jsonrpc" => "2.0",
            "error" => array(
                "code" => -32000,
                "message" => $message
            ),
            'id' => 1
        ));
    }

    public function run()
    {
        $this->checkIp();

        switch ($this->params['method']) {
            case 'check': {
                break;
            }
            case 'pay': {
                break;
            }
            /*case 'error': {
                break;
            }*/
            default: {
                break;
            }
        }
    }
}

(new UnitPay($_GET))->run();
