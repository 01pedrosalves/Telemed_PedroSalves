<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "config.php";
try {
    $stmt = $conn->query("SELECT 1");
    if($stmt) {
      echo "Conexão bem-sucedida!";
    } else {
      echo "Houve um problema na consulta.";
    }
} catch(PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>

