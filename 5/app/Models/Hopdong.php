<?php

namespace App\Models;

class Hopdong extends \Model {
    protected $table = 'hopdong';
    protected $primaryKey = 'MaHD';
    protected $fillable = ['MaHD', 'MaKH', 'MaXe', 'MaGoi', 'NgayLap', 'NgayHetHan', 'PhiBaoHiem', 'TrangThai', 'MaNV'];
    
    public function findByCustomer($maKH) {
        $sql = "SELECT * FROM {$this->table} WHERE MaKH = ? AND TrangThai != 'DaXoa'";
        return $this->db->query($sql, [$maKH]);
    }
    
    public function findByVehicle($maXe) {
        $sql = "SELECT * FROM {$this->table} WHERE MaXe = ? AND TrangThai != 'DaXoa'";
        return $this->db->query($sql, [$maXe]);
    }
    
    public function getDetail($maHD) {
        $contract = $this->find($maHD);
        if (!$contract) return null;
        
        $customer = $this->db->queryOne("SELECT * FROM khachhang WHERE MaKH = ? AND TrangThai != 'DaXoa'", [$contract['MaKH']]);
        $vehicle = $this->db->queryOne("SELECT * FROM xeoto WHERE MaXe = ? AND TrangThai != 'DaXoa'", [$contract['MaXe']]);
        $package = $this->db->queryOne("SELECT * FROM goibaohiem WHERE MaGoi = ?", [$contract['MaGoi']]);
        
        return ['contract' => $contract, 'customer' => $customer, 'vehicle' => $vehicle, 'package' => $package];
    }
    
    public function isActive($maHD) {
        $contract = $this->find($maHD);
        if (!$contract) return false;
        return strtotime($contract['NgayHetHan']) > time();
    }
}
