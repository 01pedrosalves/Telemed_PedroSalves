<?php
require_once dirname(__DIR__, 2) . '/config.php';
$stmt = $conn->prepare("SELECT c.consulta, c.data, c.horario, m.nome AS medico_nome, p.nome AS paciente_nome
                        FROM tbconsultas c
                        LEFT JOIN tbmedicos m ON c.medico_FK = m.medico
                        LEFT JOIN tbpacientes p ON c.paciente_FK = p.paciente
                        ORDER BY c.consulta DESC");
$stmt->execute();
$consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Médico</th>
      <th>Paciente</th>
      <th>Data</th>
      <th>Horário</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($consultas as $consulta): ?>
    <tr>
      <td><?php echo $consulta["consulta"]; ?></td>
      <td><?php echo $consulta["medico_nome"]; ?></td>
      <td><?php echo $consulta["paciente_nome"]; ?></td>
      <td><?php echo $consulta["data"]; ?></td>
      <td><?php echo $consulta["horario"]; ?></td>
      <td>
        <a href="editar_consulta.php?id=<?php echo $consulta["consulta"]; ?>" class="btn-icon"><i class="fa-solid fa-edit"></i></a>
        <a href="excluir_consulta.php?id=<?php echo $consulta["consulta"]; ?>" class="btn-icon" onclick="return confirm('Deseja realmente excluir esta consulta?');"><i class="fa-solid fa-trash"></i></a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
