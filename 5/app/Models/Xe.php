<?php

namespace App\Models;

class Xe extends \Model {
    protected $table = 'xeoto';
    protected $primaryKey = 'MaXe';
    protected $fillable = ['MaXe', 'MaKH', 'BienSo', 'HangXe', 'DongXe', 'NamSanXuat', 'MauSac', 'SoKhung', 'SoMay', 'TrangThai'];
    
    public function checkPlateExists($bienSo, $excludeMaXe = null) {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE BienSo = ? AND TrangThai != 'DaXoa'";
        $params = [$bienSo];
        if ($excludeMaXe) {
            $sql .= " AND MaXe != ?";
            $params[] = $excludeMaXe;
        }
        return (int)$this->db->queryValue($sql, $params) > 0;
    }
    
    public function checkChassisExists($soKhung, $excludeMaXe = null) {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE SoKhung = ? AND TrangThai != 'DaXoa'";
        $params = [$soKhung];
        if ($excludeMaXe) {
            $sql .= " AND MaXe != ?";
            $params[] = $excludeMaXe;
        }
        return (int)$this->db->queryValue($sql, $params) > 0;
    }
    
    public function checkEngineExists($soMay, $excludeMaXe = null) {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE SoMay = ? AND TrangThai != 'DaXoa'";
        $params = [$soMay];
        if ($excludeMaXe) {
            $sql .= " AND MaXe != ?";
            $params[] = $excludeMaXe;
        }
        return (int)$this->db->queryValue($sql, $params) > 0;
    }
    
    public function findByCustomer($maKH) {
        $sql = "SELECT * FROM {$this->table} WHERE MaKH = ? AND TrangThai != 'DaXoa'";
        return $this->db->query($sql, [$maKH]);
    }
    
    public function findByPlate($bienSo) {
        $sql = "SELECT * FROM {$this->table} WHERE BienSo = ? AND TrangThai != 'DaXoa'";
        return $this->db->queryOne($sql, [$bienSo]);
    }
    
    public function getCustomer($maXe) {
        $vehicle = $this->find($maXe);
        if (!$vehicle) return null;
        $sql = "SELECT * FROM khachhang WHERE MaKH = ? AND TrangThai != 'DaXoa'";
        return $this->db->queryOne($sql, [$vehicle['MaKH']]);
    }
    
    public function getContracts($maXe) {
        $sql = "SELECT * FROM hopdong WHERE MaXe = ? AND TrangThai != 'DaXoa'";
        return $this->db->query($sql, [$maXe]);
    }
}
