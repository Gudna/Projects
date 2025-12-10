<?php

namespace App\Models;

class PhieuChi extends \Model {
    protected $table = 'phieuchi';
    protected $primaryKey = 'MaPC';
    protected $fillable = ['MaYC', 'NgayChiTien', 'SoTienChi', 'GhiChu', 'MaNV'];
    
    public function findByClaim($maYC) {
        $sql = "SELECT * FROM {$this->table} WHERE MaYC = ? AND TrangThai != 'DaXoa'";
        return $this->db->query($sql, [$maYC]);
    }
    
    public function getTotalByPeriod($dateFrom, $dateTo) {
        $sql = "SELECT COALESCE(SUM(SoTienChi), 0) as total FROM {$this->table} WHERE NgayChiTien BETWEEN ? AND ? AND TrangThai != 'DaXoa'";
        return (float)$this->db->queryValue($sql, [$dateFrom, $dateTo]);
    }
    
    public function findByPeriod($dateFrom, $dateTo) {
        $sql = "SELECT * FROM {$this->table} WHERE NgayChiTien BETWEEN ? AND ? AND TrangThai != 'DaXoa' ORDER BY NgayChiTien DESC";
        return $this->db->query($sql, [$dateFrom, $dateTo]);
    }
}
