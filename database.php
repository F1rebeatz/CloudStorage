<?php


function getPDO() {
    $config = include('config.php');
    $dsn = 'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'];
    $pdo = new PDO(
        $dsn,
        $config['db_user'],
        $config['db_pass']
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}