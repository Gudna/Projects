<?php

abstract class Model {
    protected $db = null;
    protected $table = '';
    protected $primaryKey = 'id';
    protected $fillable = [];
    
    public function __construct() {
        $this->db = Database::getInstance();
        Logger::init();
    }
    
    public function all($where = []) {
        $sql = "SELECT * FROM {$this->table} WHERE TrangThai != 'DaXoa'";
        $params = [];
        
        if (!empty($where)) {
            foreach ($where as $col => $val) {
                $sql .= " AND {$col} = ?";
                $params[] = $val;
            }
        }
        
        return $this->db->query($sql, $params);
    }
    
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? AND TrangThai != 'DaXoa'";
        return $this->db->queryOne($sql, [$id]);
    }
    
    public function findBy($col, $val) {
        $sql = "SELECT * FROM {$this->table} WHERE {$col} = ? AND TrangThai != 'DaXoa'";
        return $this->db->queryOne($sql, [$val]);
    }
    
    public function findAll($col, $val) {
        $sql = "SELECT * FROM {$this->table} WHERE {$col} = ? AND TrangThai != 'DaXoa'";
        return $this->db->query($sql, [$val]);
    }
    
    public function count($where = []) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE TrangThai != 'DaXoa'";
        $params = [];
        
        if (!empty($where)) {
            foreach ($where as $col => $val) {
                $sql .= " AND {$col} = ?";
                $params[] = $val;
            }
        }
        
        $result = $this->db->queryValue($sql, $params);
        return (int)$result;
    }
    
    public function create($data, $userId = null) {
        $data = $this->filterFillable($data);
        $data['TrangThai'] = $data['TrangThai'] ?? 'Hoat dong';
        $data['NgayTao'] = date('Y-m-d H:i:s');
        
        $cols = implode(', ', array_keys($data));
        $placeholders = str_repeat('?, ', count($data) - 1) . '?';
        $sql = "INSERT INTO {$this->table} ({$cols}) VALUES ({$placeholders})";
        
        $this->db->execute($sql, array_values($data));
        $id = $this->db->lastInsertId();
        
        Logger::log($this->table, $id, 'INSERT', null, $data, $userId);
        
        return $id;
    }
    
    public function update($id, $data, $userId = null) {
        $oldData = $this->find($id);
        if (!$oldData) return false;
        
        $data = $this->filterFillable($data);
        $data['NgayCapNhat'] = date('Y-m-d H:i:s');
        
        $sets = [];
        foreach ($data as $col => $val) {
            $sets[] = "{$col} = ?";
        }
        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE {$this->primaryKey} = ?";
        
        $params = array_values($data);
        $params[] = $id;
        
        $this->db->execute($sql, $params);
        
        Logger::log($this->table, $id, 'UPDATE', $oldData, $data, $userId);
        
        return true;
    }
    
    public function softDelete($id, $userId = null) {
        $oldData = $this->find($id);
        if (!$oldData) return false;
        
        $sql = "UPDATE {$this->table} SET TrangThai = 'DaXoa', NgayCapNhat = ? WHERE {$this->primaryKey} = ?";
        $this->db->execute($sql, [date('Y-m-d H:i:s'), $id]);
        
        Logger::log($this->table, $id, 'DELETE', $oldData, ['TrangThai' => 'DaXoa'], $userId);
        
        return true;
    }
    
    protected function filterFillable($data) {
        if (empty($this->fillable)) {
            return $data;
        }
        return array_intersect_key($data, array_flip($this->fillable));
    }
    
    protected function buildWhere($conditions = []) {
        if (empty($conditions)) return '';
        
        $sql = '';
        foreach ($conditions as $col => $val) {
            if ($val === null) {
                $sql .= " AND {$col} IS NULL";
            } else {
                $sql .= " AND {$col} = '{$val}'";
            }
        }
        return $sql;
    }
}
