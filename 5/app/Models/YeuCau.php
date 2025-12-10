<?php

namespace App\Models;

class YeuCau extends \Model {
    protected $table = 'yeucauboithuong';
    protected $primaryKey = 'MaYC';
    protected $fillable = ['MaYC', 'MaHD', 'NgayYeuCau', 'NgaySuCo', 'DiaDiemSuCo', 'MoTaSuCo', 'SoTienDeXuat', 'SoTienDuyet', 'TrangThai', 'KetQuaThamDinh', 'LyDoTuChoi', 'MaNVGiamDinh', 'NgayDuyet'];
    
    public function findByContract($maHD) {
        $sql = "SELECT * FROM {$this->table} WHERE MaHD = ? AND TrangThai != 'DaXoa'";
        return $this->db->query($sql, [$maHD]);
    }
    
    public function getPendingAssessment() {
        $sql = "SELECT * FROM {$this->table} WHERE TrangThai = 'Chờ duyệt' AND MaNVGiamDinh IS NULL AND TrangThai != 'DaXoa'";
        return $this->db->query($sql);
    }
    
    public function getPendingApproval() {
        $sql = "SELECT * FROM {$this->table} WHERE TrangThai IN ('Thẩm định xong', 'Chờ phê duyệt') AND TrangThai != 'DaXoa'";
        return $this->db->query($sql);
    }
    
    public function getDetail($maYC) {
        $claim = $this->find($maYC);
        if (!$claim) return null;
        
        $contract = $this->db->queryOne("SELECT * FROM hopdong WHERE MaHD = ?", [$claim['MaHD']]);
        if (!$contract) return null;
        
        $customer = $this->db->queryOne("SELECT * FROM khachhang WHERE MaKH = ? AND TrangThai != 'DaXoa'", [$contract['MaKH']]);
        $vehicle = $this->db->queryOne("SELECT * FROM xeoto WHERE MaXe = ? AND TrangThai != 'DaXoa'", [$contract['MaXe']]);
        
        return ['claim' => $claim, 'contract' => $contract, 'customer' => $customer, 'vehicle' => $vehicle];
    }
}
