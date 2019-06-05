<?php

//autoload classes
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

//path to the file
$fileName = 'image.jpg';

//db connection parameters
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'test';

//get mysql connection
$mysqli = new mysqli($dbHost, $dbUser, $dbPassword, $dbName, 3306);

if (!$mysqli->connect_errno) {
    //save data
    $stat = new Stat($mysqli);
    $stat->saveStat(new User());
}

//close mysql connection
$mysqli->close();

//render file
$file = new File($fileName);
$file->printFile();
