<?php

namespace App\Models;


use app\Helpers\Session;
use mysqli;
use stdClass;


class BaseModel extends stdClass
{
    protected mysqli $mysqli;

    protected string $table;

    protected array $fillable = [];

    protected array $properties = [];

    protected string $sql = '';

    protected array $binding = [];

    function __construct()
    {
        require 'config/database.php';

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $mysqli = new mysqli(...$connection);

        if ($mysqli->connect_error) {
            echo "Failed to connect database : (" . $mysqli->connect_error . ")";
        }

        $this->mysqli = $mysqli;
    }

    public function fill(array $properties = [])
    {
        foreach ($properties as $property => $value) {
            if (in_array($property, $this->fillable)) {
                $this->properties[$property] = $value;
            }
        }
        return $this;
    }

    public function find($id, $columns = ['*'])
    {
        $sql = "SELECT" . implode(',', $columns) . " FROM {$this->table} WHERE id= ? ORDER BY id DESC LIMIT 1";
        $statement = $this->mysqli->prepare($sql);
        $statement->execute([$id]);
        $result = $statement->get_result()->fetch_array(MYSQLI_ASSOC);
        if (!$result) {
            http_response_code(404);
            require 'views/errors/404.php';
            die();
        }
        $this->fill($result);
        return $this;
    }

    public function save(): bool
    {
        $columns = array_keys($this->properties);
        $values = array_values($this->properties);
        if ($hasId = in_array('id', $columns)) {
            $sql = "UPDATE {$this->table} SET ";
            $values = [];
            foreach ($this->properties as $key => $value) {
                if ($key != 'id') {
                    $sql .= "{$key} = ?";
                    $values[] = $value;
                    if ($key != end($columns)) {
                        $sql .= ', ';
                    }
                }
            }
            $sql .= ' WHERE id = ?';
            $values[] = $this->properties['id'];
        } else {
            $sql = "INSERT INTO {$this->table} (" . implode(',', $columns) . ")
                VALUES (" . implode(',', array_fill(0, count($this->properties), '?')) . ")";
        }
        $statement = $this->mysqli->prepare($sql);
        if ($statement->execute($values)) {
            if (!$hasId) {
                $this->fill(['id' => $statement->insert_id]);
            }
            return true;
        }
        return false;
    }

    public function delete()
    {
        if (!isset($this->properties['id'])) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $statement = $this->mysqli->prepare($sql);
        if ($statement->execute([$this->properties['id']])) {
            return true;
        }
        echo $this->mysqli->affected_rows;
        return false;
    }

    public function query($sql)
    {
        $this->sql = $sql;
        return $this;
    }

    public function where($key, $operator, $value, $boolean = 'and')
    {
        $this->binding['where'][] = compact('key', 'operator', 'value', 'boolean');
        return $this;
    }

    public function get($orderByColumn = 'id', $orderByDirection = 'asc', $limit = null)
    {
        $sql = $this->sql;
        if (!$sql) {
            $sql = "SELECT * FROM {$this->table}";
        }
        $params = null;
        if (array_key_exists('where', $this->binding) && count($this->binding['where']) > 0) {
            $sql .= ' WHERE';
            for ($i = 0; $i < count($this->binding['where']); $i++) {
                $where = $this->binding['where'][$i];
                $prefix = " {$where['boolean']} ";
                if ($i === 0) {
                    $prefix = ' ';
                }
                $sql .= $prefix . "{$where['key']} {$where['operator']} ?";
                $params[] = $where['value'];
            }
        }
        $sql .= " ORDER BY {$orderByColumn} {$orderByDirection}";
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        $statement = $this->mysqli->prepare($sql);
        $statement->execute($params);
        $result = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        if ($result && $limit === 1) {
            return $result[0];
        }
        return $result;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->properties)) {
            return $this->properties[$key];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $key .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    public function __set($key, $value)
    {
        $this->properties[$key] = $value;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

    public function toArray() {
        return $this->properties;
    }
}