<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('SECRET_KEY', 'd659beee8847b09f876e0f1c5e44f4d1');

function getSignature(array $params, $method = null)
{
    ksort($params);
    unset($params['sign']);
    unset($params['signature']);
    array_push($params, SECRET_KEY);
    if ($method) {
        array_unshift($params, $method);
    }

    return hash('sha256', join('{up}', $params));
}

$url = 'http://unitpay.local/unitpay/?';
//$url .= 'method=check&';
//$url .= 'params[account]=userId';
//$url .= 'params[date]=2017-07-01 12:32:00';
//$url .= 'params[operator]=beeline';
//$url .= 'params[paymentType]=mc';
//$url .= 'params[projectId]=1';
//$url .= 'params[phone]=923487922';
//$url .= 'params[payerSum]=10.00';
//$url .= 'params[payerCurrency]=RUB';
//$url .= 'params[signature]=9bdf52a4830779a1383ac24f1b3ed054';
//$url .= 'params[orderSum]=10.00';
//$url .= 'params[orderCurrency]=RUB';
//$url .= 'params[unitpayId]=1234567';
//$url .= 'params[test]=0';

// Константы (не важно что в них)
$params['date'] = '2017-07-01 12:32:00';
$params['operator'] = 'beeline';
$params['paymentType'] = 'mc';
$params['projectId'] = 123;   // ID проекта в Unitpay
$params['phone'] = '923487922';
$params['payerSum'] = '10.10';  // Сумма списания с лицевого счета абонента
$params['payerCurrency'] = 'RUB';   // Валюта списания с лицевого счета абонента
$params['unitpayId'] = 1234556;     // Внутренний номер платежа в Unitpay
$params['test'] = 0;    // Признак тестового режима

// Изменяются для баг-тестинга
$params['orderCurrency'] = 'RUB';   // Валюта заказа

// Изменяются
$method = 'pay';
$params['orderSum'] = '2';  // Сумма заказа
$params['account'] = 2;

// Вычисляется
/*ksort($params);
unset($params['sign']);
unset($params['signature']);
array_push($params, SECRET_KEY);
if ($method) {
    array_unshift($params, $method);
}
$params['signature'] = hash('sha256', join('{up}', $params));*/

$params['signature'] = getSignature($params, $method);

$url .= http_build_query(['method' => $method, 'params' => $params]);

die(htmlspecialchars($url));
echo file_get_contents($url);
