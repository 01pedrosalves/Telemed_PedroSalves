<?php
session_start();

require_once "../config.php";

if (!isset($_GET["id"])) {
    header("Location: cadastro_medicos.php");
    exit;
}

$id = $_GET["id"];
$stmt = $conn->prepare("DELETE FROM tbmedicos WHERE medico = :id");
$stmt->bindParam(":id", $id);
$stmt->execute();

header("Location: cadastro_medicos.php");
exit;
?>
