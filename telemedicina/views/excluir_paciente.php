<?php
session_start();

require_once "../config.php";

if (!isset($_GET["id"])) {
    header("Location: cadastro_pacientes.php");
    exit;
}

$id = $_GET["id"];
$stmt = $conn->prepare("DELETE FROM tbpacientes WHERE paciente = :id");
$stmt->bindParam(":id", $id);
$stmt->execute();

header("Location: cadastro_pacientes.php");
exit;
?>
