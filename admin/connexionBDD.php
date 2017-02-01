<?php

//$servername = "localhost";
//$username = "InstaGib111";
//$password = "40euros";
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=fromage", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

require_once("function.php");

//-------- SESSION
session_start();
if (!isset($_SESSION['admin']))
	$_SESSION["admin"] = false;

$BASE_URL = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
?>
