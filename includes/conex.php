<?php
try { 
    $dbname = 'wallet_generator';
    $user = 'root';
    $password = 'root';
    $conex = "mysql:host=localhost;dbname=".$dbname.";";
    $params = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    $pdo = new PDO($conex, $user, $password, $params);
} catch (PDOException $e) {
    echo "Error! : " .$e->getMessage(). "\n";
}
