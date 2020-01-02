<?php
/*
==========================================
+++> PDO FILE : CONNECT TO DATABAE(s) <+++
==========================================
*/

$host          = 'localhost';
$database_name = 'market';
$username      = 'root';
$password      = '';
$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);

// query to connect
$dsn = "mysql:host=$host;dbname=$database_name";

// connect to mySql with catching errors
try {
	$connect = new PDO($dsn, $username, $password, $options);
	$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
	echo "<b>X</b> connect failed : ". $e->getMessage();
}