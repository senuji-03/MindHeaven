<?php

require_once __DIR__ . '/../../core/Database.php';

class Keyword
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM flag_keywords ORDER BY keyword ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($keyword)
    {
        $stmt = $this->pdo->prepare("INSERT INTO flag_keywords (keyword) VALUES (?)");
        return $stmt->execute([$keyword]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM flag_keywords WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function exists($keyword)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM flag_keywords WHERE keyword = ?");
        $stmt->execute([$keyword]);
        return $stmt->fetchColumn() !== false;
    }
}
