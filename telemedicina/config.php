<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host     = "sql302.infinityfree.com"; 
$dbname   = "if0_38369390_pedro_telemed"; 
$username = "if0_38369390"; 
$password = "j3tgNHDuec"; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>