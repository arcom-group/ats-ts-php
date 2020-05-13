# Библиотека для подключения к ATS TS Api

Библиотека позволяет интегрироваться с системой ATS. 

Данное решение основано на технологиях компании [Arcom Group](https://arcom.group).

## Установка

Установка с помощью Composer

        composer require arcom-group/ats-ts-php

## Пример использования

```php
<?php
use ATS\TS\Client;

$params = [
    'username' => null,
    'key' => null,
    'server' => null,
];

/**
* Token expiration 1 month
*/
$token = Client::token($params);

$client = new Client($token, $params);

$response = $client->get('/session', [
    'fields' => 'id,performance.name',
    'expand' => 'performance',
]);

print_r($response);
```


# Дополнительная информация

Вопросы/советы/замечания отправляйте на support@arcom.group
Также вы можете обратиться через форму обратной связи на сайте [Arcom Group](https://arcom.group).

Если вы обнаружили какие-то ошибки или опечатки, вы можете написать о них на почту либо сделать пулл-реквест с исправлением. Заранее спасибо!

* [Сайт компании Arcom Group](https://arcom.group)
* [Сайт 24guru в Беларуси](https://24guru.by)

<p align="center"><img src="https://arcom.group/img/logo.svg" width="10%"></p>
