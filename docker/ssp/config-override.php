<?php
$config['module.enable']['exampleauth'] = true;
$config = [
    'secretsalt' => 'testsalt',
    'database.dsn' => 'sqlite:/var/simplesamlphp/data/mydb.sq3',
    'database.username' => 'user',
    'database.password' => 'password',
] + $config;