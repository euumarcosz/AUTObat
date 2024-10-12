<?php
require_once '../models/database.php';
$db = new Database();
$authorizations = $db->getAuthorizations();
$status_filter = isset($_GET['status']) ? $_GET['status'] : null;
$search_query = isset($_GET['search']) ? $_GET['search'] : null;

if ($status_filter) {
    $authorizations = $db->getAuthorizations($status_filter);
} elseif ($search_query) {
    $stmt = $db->getAuthorizations();
    $authorizations = array_filter($stmt, function($auth) use ($search_query) {
        return strpos($auth['numero_demanda'], $search_query) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Contabilizador de Autorizações Digitais</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Contabilizador de Autorizações</h1>

    <form action="../controllers/authorization.php" method="POST">
        <input type="text" name="numero_demanda" placeholder="Número da Demanda" required>
        <select name="status" required>
            <option value="concluido">Concluído</option>
            <option value="auditoria">Auditoria</option>
            <option value="a definir">A Definir</option>
            <option value="nao visualizado">Não Visualizado</option>
        </select>
        <input type="text" name="observacao" placeholder="Observação">
        <button type="submit">Adicionar Demanda</button>
    </form>

    <h2>Filtrar por Status</h2>
    <form method="GET">
        <select name="status">
            <option value="">Todos</option>
            <option value="concluido">Concluído</option>
            <option value="auditoria">Auditoria</option>
            <option value="a definir">A Definir</option>
            <option value="nao visualizado">Não Visualizado</option>
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <h2>Pesquisar por Número da Demanda</h2>
    <form method="GET">
        <input type="text" name="search" placeholder="Número da Demanda">
        <button type="submit">Pesquisar</button>
    </form>

    <h2>Lista de Demandas</h2>
    <table>
        <tr>
            <th>#</th>
            <th>Número da Demanda</th>
            <th>Status</th>
            <th>Observação</th>
            <th>Data/Hora</th>
        </tr>
        <?php foreach ($authorizations as $auth): ?>
        <tr>
            <td><?php echo $auth['id']; ?></td>
            <td><?php echo $auth['numero_demanda']; ?></td>
            <td style="color: <?php echo getStatusColor($auth['status']); ?>;"><?php echo $auth['status']; ?></td>
            <td><?php echo $auth['observacao']; ?></td>
            <td><?php echo date('d/m/Y H:i:s', strtotime($auth['data_hora'])); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h3>Subtotal por Status:</h3>
    <ul>
        <li>Concluído: <?php echo count($db->getAuthorizations('concluido')); ?></li>
        <li>Auditoria: <?php echo count($db->getAuthorizations('auditoria')); ?></li>
        <li>A Definir: <?php echo count($db->getAuthorizations('a definir')); ?></li>
        <li>Não Visualizado: <?php echo count($db->getAuthorizations('nao visualizado')); ?></li>
    </ul>
</body>
</html>

<?php
function getStatusColor($status) {
    switch ($status) {
        case 'concluido': return 'green';
        case 'auditoria': return 'red';
        case 'a definir': return 'orange';
        case 'nao visualizado': return 'gray';
        default: return 'black';
    }
}
?>
