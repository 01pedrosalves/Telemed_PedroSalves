<?php
require_once dirname(__DIR__, 2) . '/config.php';

$stmt = $conn->prepare("SELECT m.medico, m.nome, m.CRM, m.data_cadastro, e.descricao AS especialidade_nome
                        FROM tbmedicos m
                        LEFT JOIN tbespecialidades e ON m.especialidade_FK = e.especialidade");
$stmt->execute();
$medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>CRM</th>
      <th>Especialidade</th>
      <th>Data de Cadastro</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($medicos as $medico): ?>
    <tr>
      <td><?php echo $medico["medico"]; ?></td>
      <td><?php echo $medico["nome"]; ?></td>
      <td><?php echo $medico["CRM"]; ?></td>
      <td><?php echo $medico["especialidade_nome"]; ?></td>
      <td><?php echo $medico["data_cadastro"]; ?></td>
      <td>
        <a href="editar_medico.php?id=<?php echo $medico["medico"]; ?>" class="btn-icon"><i class="fa-solid fa-edit"></i></a>
        <a href="excluir_medico.php?id=<?php echo $medico["medico"]; ?>" class="btn-icon" onclick="return confirm('Deseja realmente excluir este médico?');"><i class="fa-solid fa-trash"></i></a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
