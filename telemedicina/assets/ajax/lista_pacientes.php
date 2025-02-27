<?php
require_once dirname(__DIR__, 2) . '/config.php';
$stmt = $conn->prepare("SELECT * FROM tbpacientes");
$stmt->execute();
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>CPF</th>
      <th>Plano</th>
      <th>Data de Nascimento</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($pacientes as $paciente): ?>
    <tr>
      <td><?php echo $paciente["paciente"]; ?></td>
      <td><?php echo $paciente["nome"]; ?></td>
      <td><?php echo $paciente["cpf"]; ?></td>
      <td><?php echo $paciente["plano"]; ?></td>
      <td><?php echo $paciente["data_nascimento"]; ?></td>
      <td>
        <a href="editar_paciente.php?id=<?php echo $paciente["paciente"]; ?>" class="btn-icon"><i class="fa-solid fa-edit"></i></a>
        <a href="excluir_paciente.php?id=<?php echo $paciente["paciente"]; ?>" class="btn-icon" onclick="return confirm('Deseja realmente excluir este paciente?');"><i class="fa-solid fa-trash"></i></a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
