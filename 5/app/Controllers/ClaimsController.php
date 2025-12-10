<?php

namespace App\Controllers;

use App\Models\YeuCau;
use App\Models\Hopdong;
use App\Models\PhieuChi;

class ClaimsController extends \Controller {
    private $yeuCau;
    private $hopdong;
    private $phieuChi;
    
    public function __construct() {
        parent::__construct();
        $this->yeuCau = new YeuCau();
        $this->hopdong = new Hopdong();
        $this->phieuChi = new PhieuChi();
    }
    
    public function index() {
        $status = $this->get('status', '');
        
        if (!empty($status)) {
            $claims = $this->yeuCau->findBy('TrangThai', $status);
            if (!is_array($claims)) {
                $claims = [];
            }
        } else {
            $claims = $this->yeuCau->all();
        }
        
        $this->render('Claims/index', [
            'claims' => $claims,
            'status' => $status,
            'baseUrl' => BASE_URL
        ]);
    }
    
    public function view() {
        $maYC = $this->get('id');
        if (!$maYC) {
            $this->redirect(BASE_URL . '/public/index.php?c=Claims&m=index');
        }
        
        $detail = $this->yeuCau->getDetail($maYC);
        if (!$detail) {
            $this->redirect(BASE_URL . '/public/index.php?c=Claims&m=index');
        }
        
        $this->render('Claims/view', [
            'claim' => $detail['claim'],
            'contract' => $detail['contract'],
            'customer' => $detail['customer'],
            'vehicle' => $detail['vehicle'],
            'baseUrl' => BASE_URL
        ]);
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->postAll();
            
            $errors = [];
            if (empty($data['MaHD'])) $errors['MaHD'] = 'Mã hợp đồng không được trống';
            if (empty($data['NgayYeuCau'])) $errors['NgayYeuCau'] = 'Ngày yêu cầu không được trống';
            
            if (!empty($errors)) {
                $this->render('Claims/create', ['errors' => $errors, 'data' => $data, 'baseUrl' => BASE_URL]);
                return;
            }
            
            $data['TrangThai'] = 'Chờ duyệt';
            $this->yeuCau->create($data, $this->userId);
            $this->redirect(BASE_URL . '/public/index.php?c=Claims&m=index');
        } else {
            $this->render('Claims/create', ['errors' => [], 'data' => [], 'baseUrl' => BASE_URL]);
        }
    }
    
    public function assess() {
        $maYC = $this->get('id');
        if (!$maYC) {
            $this->redirect(BASE_URL . '/public/index.php?c=Claims&m=index');
        }
        
        $claim = $this->yeuCau->find($maYC);
        if (!$claim) {
            $this->redirect(BASE_URL . '/public/index.php?c=Claims&m=index');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TrangThai' => 'Thẩm định xong',
                'KetQuaThamDinh' => $this->post('KetQuaThamDinh', ''),
                'MaNVGiamDinh' => $this->userId
            ];
            
            $this->yeuCau->update($maYC, $data, $this->userId);
            $this->redirect(BASE_URL . '/public/index.php?c=Claims&m=view&id=' . $maYC);
        } else {
            $this->render('Claims/assess', ['claim' => $claim, 'baseUrl' => BASE_URL]);
        }
    }
    
    public function approve() {
        $maYC = $this->get('id');
        if (!$maYC) {
            $this->redirect(BASE_URL . '/public/index.php?c=Claims&m=index');
        }
        
        $claim = $this->yeuCau->find($maYC);
        if (!$claim) {
            $this->redirect(BASE_URL . '/public/index.php?c=Claims&m=index');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $soTienDuyet = $this->post('SoTienDuyet', 0);
            
            $data = [
                'TrangThai' => 'Đã duyệt',
                'SoTienDuyet' => $soTienDuyet,
                'NgayDuyet' => date('Y-m-d')
            ];
            
            $this->yeuCau->update($maYC, $data, $this->userId);
            $this->redirect(BASE_URL . '/public/index.php?c=Claims&m=view&id=' . $maYC);
        } else {
            $this->render('Claims/approve', ['claim' => $claim, 'baseUrl' => BASE_URL]);
        }
    }
    
    public function reject() {
        $maYC = $this->get('id');
        if (!$maYC) {
            $this->redirect(BASE_URL . '/public/index.php?c=Claims&m=index');
        }
        
        $claim = $this->yeuCau->find($maYC);
        if (!$claim) {
            $this->redirect(BASE_URL . '/public/index.php?c=Claims&m=index');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lyDoTuChoi = $this->post('LyDoTuChoi', '');
            
            $data = [
                'TrangThai' => 'Từ chối',
                'LyDoTuChoi' => $lyDoTuChoi,
                'NgayDuyet' => date('Y-m-d')
            ];
            
            $this->yeuCau->update($maYC, $data, $this->userId);
            $this->redirect(BASE_URL . '/public/index.php?c=Claims&m=view&id=' . $maYC);
        } else {
            $this->render('Claims/reject', ['claim' => $claim, 'baseUrl' => BASE_URL]);
        }
    }
}
