<?php

namespace App\Models;

class PhieuThu extends \Model {
    protected $table = 'phieuthu';
    protected $primaryKey = 'MaPT';
    protected $fillable = ['MaHD', 'NgayThuTien', 'SoTienThu', 'GhiChu', 'MaNV'];
    
    public function findByContract($maHD) {
        $sql = "SELECT * FROM {$this->table} WHERE MaHD = ? AND TrangThai != 'DaXoa'";
        return $this->db->query($sql, [$maHD]);
    }
    
    public function getTotalByPeriod($dateFrom, $dateTo) {
        $sql = "SELECT COALESCE(SUM(SoTienThu), 0) as total FROM {$this->table} WHERE NgayThuTien BETWEEN ? AND ? AND TrangThai != 'DaXoa'";
        return (float)$this->db->queryValue($sql, [$dateFrom, $dateTo]);
    }
    
    public function findByPeriod($dateFrom, $dateTo) {
        $sql = "SELECT * FROM {$this->table} WHERE NgayThuTien BETWEEN ? AND ? AND TrangThai != 'DaXoa' ORDER BY NgayThuTien DESC";
        return $this->db->query($sql, [$dateFrom, $dateTo]);
    }
}
