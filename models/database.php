<?php
class Database {
    private $db;

    public function __construct() {
        $this->db = new PDO('sqlite:' . __DIR__ . '/../autorizacoes.db');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->createTable();
    }

    private function createTable() {
        $this->db->exec("CREATE TABLE IF NOT EXISTS autorizacoes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            numero_demanda TEXT NOT NULL UNIQUE,
            status TEXT NOT NULL,
            observacao TEXT,
            data_hora TEXT NOT NULL
        )");
    }

    public function insertAuthorization($numero_demanda, $status, $observacao) {
        $stmt = $this->db->prepare("INSERT INTO autorizacoes (numero_demanda, status, observacao, data_hora) VALUES (?, ?, ?, ?)");
        $stmt->execute([$numero_demanda, $status, $observacao, date('Y-m-d H:i:s')]);
    }

    public function getAuthorizations($status = null) {
        if ($status) {
            $stmt = $this->db->prepare("SELECT * FROM autorizacoes WHERE status = ?");
            $stmt->execute([$status]);
        } else {
            $stmt = $this->db->query("SELECT * FROM autorizacoes ORDER BY data_hora DESC");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
