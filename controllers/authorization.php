<?php
require_once '../models/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_demanda = $_POST['numero_demanda'];
    $status = $_POST['status'];
    $observacao = $_POST['observacao'];

    if (strlen($numero_demanda) < 6 || strlen($numero_demanda) > 16) {
        die('Número da demanda deve ter entre 6 e 16 dígitos.');
    }

    $db = new Database();
    $db->insertAuthorization($numero_demanda, $status, $observacao);
    header('Location: ../views/index.php');
}
?>
