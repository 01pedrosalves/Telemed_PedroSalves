<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
require_once dirname(__DIR__, 2) . '/config.php';
header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nome = trim($_POST["nome"] ?? "");
  $cpf = trim($_POST["cpf"] ?? "");
  $plano = trim($_POST["plano"] ?? "");
  $data_nascimento = trim($_POST["data_nascimento"] ?? "");

  if (!empty($nome) && !empty($cpf)) {
    $stmt = $conn->prepare("INSERT INTO tbpacientes (nome, cpf, plano, data_nascimento) VALUES (:nome, :cpf, :plano, :data_nascimento)");
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":cpf", $cpf);
    $stmt->bindParam(":plano", $plano);
    $stmt->bindParam(":data_nascimento", $data_nascimento);
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
ob_end_clean();
echo json_encode($response);
exit;
?>
