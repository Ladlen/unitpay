<?php

#$connectMainBD = mysqli_connect('localhost', 'root', 'temp123', 'wfl');

include('/home/bill.shopsu.ru/www/connectMainBD.php');
include('/home/bill.shopsu.ru/www/database.php');

$tables = mysqli_query($connectMainBD, 'show tables');
while ($tbl = mysqli_fetch_array($tables)) {
    echo "\n\n$tbl[0]\n\n ----------------------------------- \n\n";
    $fields = mysqli_query($connectMainBD, 'desc ' . $tbl[0]);
    while ($fld = mysqli_fetch_array($fields)) {
        print_r($fld);
    }

}


