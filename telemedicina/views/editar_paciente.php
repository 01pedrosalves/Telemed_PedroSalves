<?php
session_start();
require_once "../config.php";

if (!isset($_GET["id"])) {
  header("Location: cadastro_pacientes.php");
  exit;
}

$id = trim($_GET["id"]);
$stmt = $conn->prepare("SELECT * FROM tbpacientes WHERE paciente = :id");
$stmt->bindParam(":id", $id);
$stmt->execute();
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paciente) {
  echo "Paciente não encontrado.";
  exit;
}

$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = trim($_POST["nome"] ?? "");
  $cpf = trim($_POST["cpf"] ?? "");
  $plano = trim($_POST["plano"] ?? "");
  $data_nascimento = trim($_POST["data_nascimento"] ?? "");

  if (!empty($nome) && !empty($cpf)) {
    $stmtUpdate = $conn->prepare("UPDATE tbpacientes SET nome = :nome, cpf = :cpf, plano = :plano, data_nascimento = :data_nascimento WHERE paciente = :id");
    $stmtUpdate->bindParam(":nome", $nome);
    $stmtUpdate->bindParam(":cpf", $cpf);
    $stmtUpdate->bindParam(":plano", $plano);
    $stmtUpdate->bindParam(":data_nascimento", $data_nascimento);
    $stmtUpdate->bindParam(":id", $id);
    if ($stmtUpdate->execute()) {
      $mensagem = "Paciente atualizado com sucesso!";
    } else {
      $mensagem = "Erro ao atualizar paciente.";
    }
  } else {
    $mensagem = "Preencha os campos obrigatórios.";
  }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Editar Paciente - Salves Health</title>
  <link rel="stylesheet" href="../assets/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
</head>
<body>
  <div class="wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="main-content">
      <header class="main-header">
        <h1>Editar Paciente</h1>
      </header>
      <section class="content">
        <?php if (!empty($mensagem)) echo "<div class='alert alert-info'>$mensagem</div>"; ?>
        <form method="POST" class="mb-4">
          <div class="mb-3">
            <input type="text" name="nome" class="form-control" placeholder="Nome do Paciente" value="<?php echo htmlspecialchars($paciente['nome']); ?>" required>
          </div>
          <div class="mb-3">
            <input type="text" name="cpf" class="form-control" placeholder="CPF do Paciente" value="<?php echo htmlspecialchars($paciente['cpf']); ?>" required>
          </div>
          <div class="mb-3">
            <select name="plano" class="form-select" required>
              <option value="">Selecione o Plano</option>
              <option value="0" <?php if($paciente['plano'] == "0") echo "selected"; ?>>0</option>
              <option value="1" <?php if($paciente['plano'] == "1") echo "selected"; ?>>1</option>
            </select>
          </div>
          <div class="mb-3">
            <input type="date" name="data_nascimento" class="form-control" value="<?php echo $paciente['data_nascimento']; ?>">
          </div>
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Atualizar Paciente</button>
          <a href="cadastro_pacientes.php" class="btn btn-secondary ms-2"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
        </form>
      </section>
    </main>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
