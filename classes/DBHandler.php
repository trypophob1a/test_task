<?php

namespace classes;

use Exception;
use PDO;
use UnexpectedValueException;

class DBHandler
{
    private array $data;
    private PDO $db;

    public function __construct(string $configPath)
    {

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $configPath)) {
            throw new UnexpectedValueException("Configuration file not found.", 404);
        }
        $config = require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $configPath;
        try {
            $this->db = new PDO($config['dns'], $config['username'], $config['password']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die(json_encode(['code' => $e->getCode(), 'msg' => 'Ошибка записи в дб']));
        }
    }

    public function writeData(array $data)
    {
        $this->data = array_map(fn($value) => htmlspecialchars($value), $data);
        $sql = "INSERT INTO comments ({$this->prepareValue()}) VALUES ({$this->prepareName()})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($this->data);
    }

    public function getData(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM comments ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function prepareName(): string
    {
        return ':' . implode(', :', array_keys($this->data));
    }

    private function prepareValue(): string
    {
        return implode(', ', array_keys($this->data));
    }


}