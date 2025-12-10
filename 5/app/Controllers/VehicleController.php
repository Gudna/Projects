<?php

namespace App\Controllers;

use App\Models\Xe;
use App\Models\Khachhang;
use App\Models\Hopdong;

class VehicleController extends \Controller {
    private $xe;
    private $khachhang;
    private $hopdong;
    
    public function __construct() {
        parent::__construct();
        $this->xe = new Xe();
        $this->khachhang = new Khachhang();
        $this->hopdong = new Hopdong();
    }
    
    public function index() {
        $vehicles = $this->xe->all();
        $this->render('Vehicle/index', [
            'vehicles' => $vehicles,
            'baseUrl' => BASE_URL
        ]);
    }
    
    public function view() {
        $maXe = $this->get('id');
        if (!$maXe) {
            $this->redirect(BASE_URL . '/public/index.php?c=Vehicle&m=index');
        }
        
        $vehicle = $this->xe->find($maXe);
        if (!$vehicle) {
            $this->redirect(BASE_URL . '/public/index.php?c=Vehicle&m=index');
        }
        
        $customer = $this->xe->getCustomer($maXe);
        $contracts = $this->xe->getContracts($maXe);
        
        $this->render('Vehicle/view', [
            'vehicle' => $vehicle,
            'customer' => $customer,
            'contracts' => $contracts,
            'baseUrl' => BASE_URL
        ]);
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->postAll();
            
            $errors = [];
            if (empty($data['MaXe'])) $errors['MaXe'] = 'Mã xe không được trống';
            if (empty($data['BienSo'])) $errors['BienSo'] = 'Biển số không được trống';
            
            if ($this->xe->checkPlateExists($data['BienSo'] ?? '')) {
                $errors['BienSo'] = 'Biển số đã tồn tại';
            }
            if ($this->xe->checkChassisExists($data['SoKhung'] ?? '')) {
                $errors['SoKhung'] = 'Số khung đã tồn tại';
            }
            if ($this->xe->checkEngineExists($data['SoMay'] ?? '')) {
                $errors['SoMay'] = 'Số máy đã tồn tại';
            }
            
            if (!empty($errors)) {
                $this->render('Vehicle/create', ['errors' => $errors, 'data' => $data, 'baseUrl' => BASE_URL]);
                return;
            }
            
            $this->xe->create($data, $this->userId);
            $this->redirect(BASE_URL . '/public/index.php?c=Vehicle&m=index');
        } else {
            $this->render('Vehicle/create', ['errors' => [], 'data' => [], 'baseUrl' => BASE_URL]);
        }
    }
    
    public function edit() {
        $maXe = $this->get('id');
        if (!$maXe) {
            $this->redirect(BASE_URL . '/public/index.php?c=Vehicle&m=index');
        }
        
        $vehicle = $this->xe->find($maXe);
        if (!$vehicle) {
            $this->redirect(BASE_URL . '/public/index.php?c=Vehicle&m=index');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->postAll();
            
            $errors = [];
            if ($this->xe->checkPlateExists($data['BienSo'] ?? '', $maXe)) {
                $errors['BienSo'] = 'Biển số đã tồn tại';
            }
            
            if (!empty($errors)) {
                $this->render('Vehicle/edit', ['errors' => $errors, 'vehicle' => $vehicle, 'data' => $data, 'baseUrl' => BASE_URL]);
                return;
            }
            
            $this->xe->update($maXe, $data, $this->userId);
            $this->redirect(BASE_URL . '/public/index.php?c=Vehicle&m=view&id=' . $maXe);
        } else {
            $this->render('Vehicle/edit', ['errors' => [], 'vehicle' => $vehicle, 'data' => $vehicle, 'baseUrl' => BASE_URL]);
        }
    }
    
    public function delete() {
        $maXe = $this->get('id');
        if (!$maXe) {
            $this->redirect(BASE_URL . '/public/index.php?c=Vehicle&m=index');
        }
        
        $contractCount = count($this->xe->getContracts($maXe));
        
        if ($contractCount > 0) {
            $_SESSION['error'] = 'Không thể xóa xe có hợp đồng';
            $this->redirect(BASE_URL . '/public/index.php?c=Vehicle&m=view&id=' . $maXe);
        }
        
        $this->xe->softDelete($maXe, $this->userId);
        $this->redirect(BASE_URL . '/public/index.php?c=Vehicle&m=index');
    }
}
