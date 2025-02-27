<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
require_once dirname(__DIR__, 2) . '/config.php';
header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $medico = trim($_POST["medico"] ?? "");
  $paciente = trim($_POST["paciente"] ?? "");
  $data = trim($_POST["data"] ?? "");
  $horario = trim($_POST["horario"] ?? "");
  
  if (!empty($medico) && !empty($paciente) && !empty($data) && !empty($horario)) {
    $stmt = $conn->prepare("INSERT INTO tbconsultas (medico_FK, paciente_FK, data, horario) VALUES (:medico, :paciente, :data, :horario)");
    $stmt->bindParam(":medico", $medico);
    $stmt->bindParam(":paciente", $paciente);
    $stmt->bindParam(":data", $data);
    $stmt->bindParam(":horario", $horario);
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
