<?php

namespace App\Controllers;

use App\Models\Khachhang;
use App\Models\Xe;
use App\Models\Hopdong;

class CustomerController extends \Controller {
    private $khachhang;
    private $xe;
    private $hopdong;
    
    public function __construct() {
        parent::__construct();
        $this->khachhang = new Khachhang();
        $this->xe = new Xe();
        $this->hopdong = new Hopdong();
    }
    
    public function index() {
        $page = $this->get('page', 1);
        $search = $this->get('search', '');
        
        if (!empty($search)) {
            $customers = $this->khachhang->searchByName($search);
        } else {
            $customers = $this->khachhang->all();
        }
        
        $this->render('Customer/index', [
            'customers' => $customers,
            'search' => $search,
            'baseUrl' => BASE_URL
        ]);
    }
    
    public function view() {
        $maKH = $this->get('id');
        if (!$maKH) {
            $this->redirect(BASE_URL . '/public/index.php?c=Customer&m=index');
        }
        
        $customer = $this->khachhang->find($maKH);
        if (!$customer) {
            $this->redirect(BASE_URL . '/public/index.php?c=Customer&m=index');
        }
        
        $vehicles = $this->xe->findByCustomer($maKH);
        $contracts = $this->hopdong->findByCustomer($maKH);
        
        $this->render('Customer/view', [
            'customer' => $customer,
            'vehicles' => $vehicles,
            'contracts' => $contracts,
            'baseUrl' => BASE_URL
        ]);
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->postAll();
            
            $errors = [];
            if (empty($data['HoTen'])) $errors['HoTen'] = 'Tên khách hàng không được trống';
            if (empty($data['SoDienThoai'])) $errors['SoDienThoai'] = 'Số điện thoại không được trống';
            
            if ($this->khachhang->checkCCCDExists($data['CCCD'] ?? '')) {
                $errors['CCCD'] = 'CCCD đã tồn tại';
            }
            
            if (!empty($errors)) {
                $this->render('Customer/create', ['errors' => $errors, 'data' => $data, 'baseUrl' => BASE_URL]);
                return;
            }
            
            $this->khachhang->create($data, $this->userId);
            $this->redirect(BASE_URL . '/public/index.php?c=Customer&m=index');
        } else {
            $this->render('Customer/create', ['errors' => [], 'data' => [], 'baseUrl' => BASE_URL]);
        }
    }
    
    public function edit() {
        $maKH = $this->get('id');
        if (!$maKH) {
            $this->redirect(BASE_URL . '/public/index.php?c=Customer&m=index');
        }
        
        $customer = $this->khachhang->find($maKH);
        if (!$customer) {
            $this->redirect(BASE_URL . '/public/index.php?c=Customer&m=index');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->postAll();
            
            $errors = [];
            if (empty($data['HoTen'])) $errors['HoTen'] = 'Tên khách hàng không được trống';
            
            if ($this->khachhang->checkCCCDExists($data['CCCD'] ?? '', $maKH)) {
                $errors['CCCD'] = 'CCCD đã tồn tại';
            }
            
            if (!empty($errors)) {
                $this->render('Customer/edit', ['errors' => $errors, 'customer' => $customer, 'data' => $data, 'baseUrl' => BASE_URL]);
                return;
            }
            
            $this->khachhang->update($maKH, $data, $this->userId);
            $this->redirect(BASE_URL . '/public/index.php?c=Customer&m=view&id=' . $maKH);
        } else {
            $this->render('Customer/edit', ['errors' => [], 'customer' => $customer, 'data' => $customer, 'baseUrl' => BASE_URL]);
        }
    }
    
    public function delete() {
        $maKH = $this->get('id');
        if (!$maKH) {
            $this->redirect(BASE_URL . '/public/index.php?c=Customer&m=index');
        }
        
        $vehicleCount = count($this->xe->findByCustomer($maKH));
        $contractCount = count($this->hopdong->findByCustomer($maKH));
        
        if ($vehicleCount > 0 || $contractCount > 0) {
            $_SESSION['error'] = 'Không thể xóa khách hàng có xe hoặc hợp đồng';
            $this->redirect(BASE_URL . '/public/index.php?c=Customer&m=view&id=' . $maKH);
        }
        
        $this->khachhang->softDelete($maKH, $this->userId);
        $this->redirect(BASE_URL . '/public/index.php?c=Customer&m=index');
    }
}
