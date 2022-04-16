<?php

define("DBConected", array(
    "USERNAME" => "root", // Usuairio de conexao
    "PASSWORD" => "", // senha de acesso ao banco de dado MySql
    "HOST" => "localhost", // HOST do banco de dado
    "DBNAME" => "chat_cloud" // Nome do banco de dado
));

try {
    $conn = new PDO("mysql:host=". DBConected["HOST"] .";dbname=". DBConected["DBNAME"] .";charset=UTF8", DBConected["USERNAME"], DBConected["PASSWORD"]);
} catch(PDOException $e) {
    echo "<p>Erro ao se conectar com o banco de dados</p>";
    echo $e->getMessage();
    die();
}
