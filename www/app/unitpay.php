<?php

$WALLET = json_decode(WALLETS, true);
if ($WALLET['UNITPAY'] != true) {
    die('Метод не поддерживается');
}

class UnitPay
{
    protected $method;
    protected $params;
    protected $core;

    public function __construct($params, $core)
    {
        $this->method = $params['method'];
        $this->params = $params['params'];
        $this->core = $core;
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

        if ($this->getSignature($this->params) != $this->params['signature']) {
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
        ksort($params);
        unset($params['sign']);
        unset($params['signature']);
        array_push($params, $this->secretKey);
        if ($method) {
            array_unshift($params, $method);
        }

        return hash('sha256', join('{up}', $params));
    }

    protected function pay()
    {
        $ORDER = mysqli_fetch_array(mysqli_query($this->core->connectMainBD,
            "SELECT * FROM `orders` WHERE `sid` = '" . intval(SID) . "' AND `oid` = '" . intval($this->params['account']) . "'"));

        # Запросы
        $ITEM = mysqli_fetch_array(mysqli_query($this->core->connectMainBD,
            "SELECT * FROM `items` WHERE `sid` = '" . intval(SID) . "' AND `id` = '" . intval($ORDER['item_id']) . "'"));

        # Продажа по строкам
        if ($ITEM['type'] == "text") {
            # Путь к товару
            $file = file('uploads/' . md5(SID) . '/' . md5($ITEM['id']));
            # Купленный товар
            $order = implode(array_splice($file, 0, $ORDER['count']));
            $file = implode($file);
            # Обновим файл товара
            file_put_contents('uploads/' . md5(SID) . '/' . md5($ITEM['id']), $file);
            # Создадим купленный заказ
            file_put_contents('uploads/' . md5(SID) . '/orders/' . md5($ORDER['id']), $order);
            # Обновим статус заказа
            mysqli_query($this->core->connectMainBD, "UPDATE `orders` SET `status` = '1' WHERE `sid` = '" . intval(SID) . "' AND `id` = '" . intval($ORDER['id']) . "'");
            # Обновим количество
            mysqli_query($this->core->connectMainBD, "UPDATE `items` SET `count` = count-" . $ORDER['count'] . " WHERE `sid` = '" . intval(SID) . "' AND `id` = '" . intval($ITEM['id']) . "'");

            # Подключим класс
            include("/home/engine/app/system/libmail.php");

            # Кодировка письма
            $m = new Mail("utf-8");
            # Отправитель
            $m->From("Shopsn.su;botshopsu@gmail.com");
            # Получатель
            $m->To($ORDER['email']);
            # Тема письма
            $m->Subject($ITEM['item']);
            # Контень письма
            $m->Body("Покупка во вложении к письму");
            # Приоретет
            $m->Priority(4);
            # Вложение файла
            $m->Attach('uploads/' . md5(SID) . '/orders/' . md5($ORDER['id']), "Tovar.txt", "", "attachment");
            # Установка соединения по SMTP
            $m->smtp_on("ssl://smtp.gmail.com", "botshopsu", "GbV1WSEN2D1", 465, 10);
            # Включаем логи
            $m->log_on(true);
            # Отправляем
            $m->Send();

            $obj = json_decode(json_encode($m), true);

            if ($obj['status_mail']['status'] == false) {

                # Кодировка письма
                $m = new Mail("utf-8");
                # Отправитель
                $m->From("Shopsn.su;botshopsu1@gmail.com");
                # Получатель
                $m->To($ORDER['email']);
                # Тема письма
                $m->Subject($ITEM['item']);
                # Контень письма
                $m->Body("Покупка во вложении к письму");
                # Приоретет
                $m->Priority(4);
                # Вложение файла
                $m->Attach('uploads/' . md5(SID) . '/orders/' . md5($ORDER['id']), "Tovar.txt", "", "attachment");
                # Установка соединения по SMTP
                $m->smtp_on("ssl://smtp.yandex.ru", "seller-tovar@shopsn.su", "GbV1WSEN2D11", 465, 10);
                # Включаем логи
                $m->log_on(true);
                # Отправляем
                $m->Send();

                $obj = json_decode(json_encode($m), true);

                if ($obj['status_mail']['status'] == false) {

                    # Кодировка письма
                    $m = new Mail("utf-8");
                    # Отправитель
                    $m->From("Shopsn.su;botshopsu2@gmail.com");
                    # Получатель
                    $m->To($ORDER['email']);
                    # Тема письма
                    $m->Subject($ITEM['item']);
                    # Контень письма
                    $m->Body("Покупка во вложении к письму");
                    # Приоретет
                    $m->Priority(4);
                    # Вложение файла
                    $m->Attach('uploads/' . md5(SID) . '/orders/' . md5($ORDER['id']), "Tovar.txt", "", "attachment");
                    # Установка соединения по SMTP
                    $m->smtp_on("ssl://smtp.gmail.com", "botshopsu2", "GbV1WSEN2D1", 465, 10);
                    # Включаем логи
                    $m->log_on(true);
                    # Отправляем
                    $m->Send();

                }

            }

            # YES
            die($this->getResponseSuccess('Успешная покупка'));
            # Продажа файла
        } else {
            # Обновим статус заказа
            mysqli_query($this->core->connectMainBD,
                "UPDATE `orders` SET `status` = '1' WHERE `sid` = '" . intval(SID) . "' AND `id` = '" . intval($ORDER['id']) . "'");

            # Подключим класс
            include("/home/engine/app/system/libmail.php");

            # Кодировка письма
            $m = new Mail("utf-8");
            # Отправитель
            $m->From("Shopsn.su;botshopsu@gmail.com");
            # Получатель
            $m->To($ORDER['email']);
            # Тема письма
            $m->Subject($ITEM['item']);
            # Контень письма
            $m->Body("Покупка во вложении к письму");
            # Приоретет
            $m->Priority(4);
            # Вложение файла
            $m->Attach('uploads/' . md5(SID) . '/' . md5($ITEM['id']), "Tovar.txt", "", "attachment");
            # Установка соединения по SMTP
            $m->smtp_on("ssl://smtp.gmail.com", "botshopsu", "GbV1WSEN2D1", 465, 10);
            # Включаем логи
            $m->log_on(true);
            # Отправляем
            $m->Send();

            $obj = json_decode(json_encode($m), true);

            if ($obj['status_mail']['status'] == false) {

                # Кодировка письма
                $m = new Mail("utf-8");
                # Отправитель
                $m->From("Shopsn.su;botshopsu1@gmail.com");
                # Получатель
                $m->To($ORDER['email']);
                # Тема письма
                $m->Subject($ITEM['item']);
                # Контень письма
                $m->Body("Покупка во вложении к письму");
                # Приоретет
                $m->Priority(4);
                # Вложение файла
                $m->Attach('uploads/' . md5(SID) . '/' . md5($ITEM['id']), "Tovar.txt", "", "attachment");
                # Установка соединения по SMTP
                $m->smtp_on("ssl://smtp.gmail.com", "botshopsu1", "GbV1WSEN2D1", 465, 10);
                # Включаем логи
                $m->log_on(true);
                # Отправляем
                $m->Send();

                $obj = json_decode(json_encode($m), true);

                if ($obj['status_mail']['status'] == false) {

                    # Кодировка письма
                    $m = new Mail("utf-8");
                    # Отправитель
                    $m->From("Shopsn.su;botshopsu2@gmail.com");
                    # Получатель
                    $m->To($ORDER['email']);
                    # Тема письма
                    $m->Subject($ITEM['item']);
                    # Контень письма
                    $m->Body("Покупка во вложении к письму");
                    # Приоретет
                    $m->Priority(4);
                    # Вложение файла
                    $m->Attach('uploads/' . md5(SID) . '/' . md5($ITEM['id']), "Tovar.txt", "", "attachment");
                    # Установка соединения по SMTP
                    $m->smtp_on("ssl://smtp.gmail.com", "botshopsu2", "GbV1WSEN2D1", 465, 10);
                    # Включаем логи
                    $m->log_on(true);
                    # Отправляем
                    $m->Send();

                }

            }

            # YES
            die($this->getResponseSuccess('Успешная покупка'));
        }
    }

    public function run()
    {
        $this->checkIp();
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
                die($this->getResponseError($this->method . ' не поддерживается'));
                break;
            }
        }
    }
}

(new UnitPay($_GET, $this))->run();
