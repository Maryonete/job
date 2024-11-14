<?php

namespace App;

use App\Entity\Database;
use Exception;
use PDO;

class QueryBuilder
{
    public $from;
    public $orderBy = null;
    public $limit;
    public $offset;
    public $where;
    public $fields = ["*"];
    public $params = [];
    private ?PDO $pdo = null;

    public function __construct()
    {
        $this->pdo = Database::getPDO();
    }

    public function from(string $table, ?string $alias = null): self
    {
        $this->from = "FROM $table";
        $this->from .= !empty($alias) ? " $alias" : '';
        return $this;
    }
    public function orderBy(string $champ, ?string $order = null): self
    {
        if (!empty($this->orderBy)) {
            $this->orderBy .= ', ';
        }

        $this->orderBy .= $champ;

        $this->orderBy .= in_array($order, ['ASC', 'DESC']) ? " $order" : '';

        return $this;
    }
    public function limit(int $limit): self
    {
        $this->limit =  $limit;
        return $this;
    }
    public function offset(int $offset): self
    {
        if ($this->limit === null) {
            throw new Exception("impossible de définir un offset sans limite");
        }
        $this->offset = " OFFSET " . $offset;
        return $this;
    }
    public function page(int $page): self
    {
        $this->offset = " OFFSET " . ($page - 1) * $this->limit;
        return $this;
    }
    public function where(string $condition): self
    {
        $this->where = $condition;
        return $this;
    }
    public function setParam(string $key, string $value): self
    {
        $this->params[$key] = $value;
        return $this;
    }
    public function select(...$field): self
    {
        if (is_array($field[0])) {
            $field = $field[0];
        }
        if ($this->fields === ['*'] || $this->fields === "*") {
            $this->fields = $field;
        } else {
            $this->fields = array_merge($this->fields, $field);
        }
        return $this;
    }
    public function fetch(string $field): ?string
    {
        $statement = $this->pdo->prepare($this->toSQL());
        $statement->execute($this->params);
        $result = $statement->fetch();
        if ($result === false) {
            return null;
        }
        return $result[$field] ?? null;
    }
    public function fetchAll(): array
    {
        try {
            $statement = $this->pdo->prepare($this->toSQL());
            $statement->execute($this->params);
            return $statement->fetchAll();
        } catch (Exception $e) {
            return "Error " . $e->getMessage();
        }
    }
    public function count(): int
    {
        $statement = $this->pdo->query($this->toSQL());
        $statement->execute($this->params);
        return count($statement->fetchAll());
    }
    public function toSQL(): string
    {
        $return = "SELECT ";
        if (!empty($this->fields)) {
            if (is_array($this->fields)) {
                $this->fields = implode(', ', $this->fields);
            }
            $return .=  $this->fields;
        }
        $return .= " " . $this->from;
        if (!empty($this->where)) {
            $return .= " WHERE " . $this->where;
        }
        if (!empty($this->orderBy)) {
            $return .= " ORDER BY " . $this->orderBy;
        }
        if (!empty($this->limit)) {
            $return .= " LIMIT " . $this->limit;
        }
        if (!empty($this->offset)) {
            $return .=  $this->offset;
        }

        $return = trim($return);
        return $return;
    }
}
