<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

require_once "../../config.php";
header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nome = trim($_POST["nome"] ?? "");
  $crm = trim($_POST["crm"] ?? "");
  $especialidade = trim($_POST["especialidade"] ?? "");
  
  if (!empty($nome) && !empty($crm)) {
    $stmt = $conn->prepare("INSERT INTO tbmedicos (nome, CRM, especialidade_FK, data_cadastro) VALUES (:nome, :crm, :especialidade, NOW())");
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":crm", $crm);
    $stmt->bindParam(":especialidade", $especialidade);
    if ($stmt->execute()) {
      $response = ["success" => true];
    } else {
      $response = ["success" => false, "message" => "Erro ao inserir no banco."];
    }
  } else {
    $response = ["success" => false, "message" => "Preencha todos os campos obrigatórios."];
  }
} else {
  $response = ["success" => false, "message" => "Método inválido."];
}

$output = json_encode($response);
ob_end_clean(); 
echo $output;
exit;
?>
