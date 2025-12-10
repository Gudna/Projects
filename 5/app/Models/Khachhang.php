<?php

namespace App\Models;

class Khachhang extends \Model {
    protected $table = 'khachhang';
    protected $primaryKey = 'MaKH';
    protected $fillable = ['MaKH', 'HoTen', 'NgaySinh', 'GioiTinh', 'DiaChi', 'SoDienThoai', 'Email', 'CCCD', 'TrangThai'];
    
    public function findByCCCD($cccd) {
        $sql = "SELECT * FROM {$this->table} WHERE CCCD = ? AND TrangThai != 'DaXoa'";
        return $this->db->queryOne($sql, [$cccd]);
    }
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE Email = ? AND TrangThai != 'DaXoa'";
        return $this->db->queryOne($sql, [$email]);
    }
    
    public function checkCCCDExists($cccd, $excludeMaKH = null) {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE CCCD = ? AND TrangThai != 'DaXoa'";
        $params = [$cccd];
        if ($excludeMaKH) {
            $sql .= " AND MaKH != ?";
            $params[] = $excludeMaKH;
        }
        return (int)$this->db->queryValue($sql, $params) > 0;
    }
    
    public function searchByName($name) {
        $sql = "SELECT * FROM {$this->table} WHERE HoTen LIKE ? AND TrangThai != 'DaXoa' ORDER BY HoTen";
        return $this->db->query($sql, ['%' . $name . '%']);
    }
    
    public function getVehicles($maKH) {
        $sql = "SELECT * FROM xeoto WHERE MaKH = ? AND TrangThai != 'DaXoa'";
        return $this->db->query($sql, [$maKH]);
    }
    
    public function getContracts($maKH) {
        $sql = "SELECT * FROM hopdong WHERE MaKH = ? AND TrangThai != 'DaXoa'";
        return $this->db->query($sql, [$maKH]);
    }
}
