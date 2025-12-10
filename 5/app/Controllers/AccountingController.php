<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\PhieuThu;
use App\Models\PhieuChi;
use App\Models\Hopdong;
use App\Models\YeuCau;

class AccountingController extends Controller
{
    private $phieuThu;
    private $phieuChi;
    private $hopdong;
    private $yeuCau;
    
    public function __construct()
    {
        parent::__construct();
        $this->phieuThu = new PhieuThu();
        $this->phieuChi = new PhieuChi();
        $this->hopdong = new Hopdong();
        $this->yeuCau = new YeuCau();
    }
    
    // Receipt methods
    public function receiptIndex()
    {
        $receipts = $this->phieuThu->all();
        $this->render('Accounting/receipt_index', [
            'receipts' => $receipts,
            'baseUrl' => BASE_URL
        ]);
    }
    
    public function receiptView()
    {
        $id = $this->get('id');
        if (!$id) $this->redirect(BASE_URL . '/public/index.php?c=Accounting&m=receiptIndex');
        
        $receipt = $this->phieuThu->find($id);
        if (!$receipt) {
            $this->redirect(BASE_URL . '/public/index.php?c=Accounting&m=receiptIndex');
        }
        
        $contract = $this->hopdong->find($receipt['MaHD']);
        
        $this->render('Accounting/receipt_view', [
            'receipt' => $receipt,
            'contract' => $contract,
            'baseUrl' => BASE_URL
        ]);
    }
    
    public function receiptCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->postAll();
            
            // Validation
            $errors = [];
            if (empty($data['MaHD'])) $errors['MaHD'] = 'Mã hợp đồng là bắt buộc';
            if (empty($data['NgayThuTien'])) $errors['NgayThuTien'] = 'Ngày thu tiền là bắt buộc';
            if (empty($data['SoTienThu']) || $data['SoTienThu'] <= 0) $errors['SoTienThu'] = 'Số tiền thu phải lớn hơn 0';
            
            // Check if contract exists
            if (!empty($data['MaHD'])) {
                $contract = $this->hopdong->find($data['MaHD']);
                if (!$contract) {
                    $errors['MaHD'] = 'Hợp đồng không tồn tại';
                }
            }
            
            if (count($errors) > 0) {
                $this->render('Accounting/receipt_create', [
                    'data' => $data,
                    'errors' => $errors,
                    'baseUrl' => BASE_URL
                ]);
                return;
            }
            
            // Create receipt
            $createData = [
                'MaHD' => $data['MaHD'],
                'NgayThuTien' => $data['NgayThuTien'],
                'SoTienThu' => $data['SoTienThu'],
                'GhiChu' => $data['GhiChu'] ?? '',
                'MaNV' => $this->userId
            ];
            
            $this->phieuThu->create($createData, $this->userId);
            $this->redirect(BASE_URL . '/public/index.php?c=Accounting&m=receiptIndex');
        } else {
            $this->render('Accounting/receipt_create', [
                'data' => [],
                'baseUrl' => BASE_URL
            ]);
        }
    }
    
    public function receiptEdit()
    {
        $id = $this->get('id');
        if (!$id) $this->redirect(BASE_URL . '/public/index.php?c=Accounting&m=receiptIndex');
        
        $receipt = $this->phieuThu->find($id);
        if (!$receipt) {
            $this->redirect(BASE_URL . '/public/index.php?c=Accounting&m=receiptIndex');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->postAll();
            
            // Validation
            $errors = [];
            if (empty($data['NgayThuTien'])) $errors['NgayThuTien'] = 'Ngày thu tiền là bắt buộc';
            if (empty($data['SoTienThu']) || $data['SoTienThu'] <= 0) $errors['SoTienThu'] = 'Số tiền thu phải lớn hơn 0';
            
            if (count($errors) > 0) {
                $receipt['NgayThuTien'] = $data['NgayThuTien'];
                $receipt['SoTienThu'] = $data['SoTienThu'];
                $receipt['GhiChu'] = $data['GhiChu'] ?? '';
                
                $this->render('Accounting/receipt_edit', [
                    'data' => $receipt,
                    'errors' => $errors,
                    'baseUrl' => BASE_URL
                ]);
                return;
            }
            
            // Update receipt
            $updateData = [
                'NgayThuTien' => $data['NgayThuTien'],
                'SoTienThu' => $data['SoTienThu'],
                'GhiChu' => $data['GhiChu'] ?? ''
            ];
            
            $this->phieuThu->update($id, $updateData, $this->userId);
            $this->redirect(BASE_URL . '/public/index.php?c=Accounting&m=receiptView&id=' . $id);
        } else {
            $this->render('Accounting/receipt_edit', [
                'data' => $receipt,
                'baseUrl' => BASE_URL
            ]);
        }
    }
    
    // Payout methods
    public function payoutIndex()
    {
        $payouts = $this->phieuChi->all();
        $this->render('Accounting/payout_index', [
            'payouts' => $payouts,
            'baseUrl' => BASE_URL
        ]);
    }
    
    public function payoutView()
    {
        $id = $this->get('id');
        if (!$id) $this->redirect(BASE_URL . '/public/index.php?c=Accounting&m=payoutIndex');
        
        $payout = $this->phieuChi->find($id);
        if (!$payout) {
            $this->redirect(BASE_URL . '/public/index.php?c=Accounting&m=payoutIndex');
        }
        
        $claim = $this->yeuCau->find($payout['MaYC']);
        
        $this->render('Accounting/payout_view', [
            'payout' => $payout,
            'claim' => $claim,
            'baseUrl' => BASE_URL
        ]);
    }
    
    public function payoutCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->postAll();
            
            // Validation
            $errors = [];
            if (empty($data['MaYC'])) $errors['MaYC'] = 'Mã yêu cầu là bắt buộc';
            if (empty($data['NgayChiTien'])) $errors['NgayChiTien'] = 'Ngày chi tiền là bắt buộc';
            if (empty($data['SoTienChi']) || $data['SoTienChi'] <= 0) $errors['SoTienChi'] = 'Số tiền chi phải lớn hơn 0';
            
            // Check if claim exists and is approved
            if (!empty($data['MaYC'])) {
                $claim = $this->yeuCau->find($data['MaYC']);
                if (!$claim) {
                    $errors['MaYC'] = 'Yêu cầu không tồn tại';
                } elseif ($claim['TrangThai'] !== 'Đã duyệt') {
                    $errors['MaYC'] = 'Chỉ có thể chi tiền cho yêu cầu đã duyệt';
                }
            }
            
            if (count($errors) > 0) {
                $this->render('Accounting/payout_create', [
                    'data' => $data,
                    'errors' => $errors,
                    'baseUrl' => BASE_URL
                ]);
                return;
            }
            
            // Create payout
            $createData = [
                'MaYC' => $data['MaYC'],
                'NgayChiTien' => $data['NgayChiTien'],
                'SoTienChi' => $data['SoTienChi'],
                'GhiChu' => $data['GhiChu'] ?? '',
                'MaNV' => $this->userId
            ];
            
            $this->phieuChi->create($createData, $this->userId);
            $this->redirect(BASE_URL . '/public/index.php?c=Accounting&m=payoutIndex');
        } else {
            $this->render('Accounting/payout_create', [
                'data' => [],
                'baseUrl' => BASE_URL
            ]);
        }
    }
    
    public function payoutEdit()
    {
        $id = $this->get('id');
        if (!$id) $this->redirect(BASE_URL . '/public/index.php?c=Accounting&m=payoutIndex');
        
        $payout = $this->phieuChi->find($id);
        if (!$payout) {
            $this->redirect(BASE_URL . '/public/index.php?c=Accounting&m=payoutIndex');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->postAll();
            
            // Validation
            $errors = [];
            if (empty($data['NgayChiTien'])) $errors['NgayChiTien'] = 'Ngày chi tiền là bắt buộc';
            if (empty($data['SoTienChi']) || $data['SoTienChi'] <= 0) $errors['SoTienChi'] = 'Số tiền chi phải lớn hơn 0';
            
            if (count($errors) > 0) {
                $payout['NgayChiTien'] = $data['NgayChiTien'];
                $payout['SoTienChi'] = $data['SoTienChi'];
                $payout['GhiChu'] = $data['GhiChu'] ?? '';
                
                $this->render('Accounting/payout_edit', [
                    'data' => $payout,
                    'errors' => $errors,
                    'baseUrl' => BASE_URL
                ]);
                return;
            }
            
            // Update payout
            $updateData = [
                'NgayChiTien' => $data['NgayChiTien'],
                'SoTienChi' => $data['SoTienChi'],
                'GhiChu' => $data['GhiChu'] ?? ''
            ];
            
            $this->phieuChi->update($id, $updateData, $this->userId);
            $this->redirect(BASE_URL . '/public/index.php?c=Accounting&m=payoutView&id=' . $id);
        } else {
            $this->render('Accounting/payout_edit', [
                'data' => $payout,
                'baseUrl' => BASE_URL
            ]);
        }
    }
    
    // Reports
    public function reports()
    {
        $monthYear = $this->get('month', date('Y-m'));
        
        // Parse month string (YYYY-MM)
        $dateFrom = $monthYear . '-01';
        $dateParts = explode('-', $monthYear);
        $year = $dateParts[0];
        $month = $dateParts[1];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $dateTo = $monthYear . '-' . $daysInMonth;
        
        // Get totals
        $receiptsTotal = $this->phieuThu->getTotalByPeriod($dateFrom, $dateTo);
        $payoutsTotal = $this->phieuChi->getTotalByPeriod($dateFrom, $dateTo);
        
        // Get receipts and payouts for the period
        $receipts = $this->phieuThu->findByPeriod($dateFrom, $dateTo);
        $payouts = $this->phieuChi->findByPeriod($dateFrom, $dateTo);
        
        $this->render('Accounting/reports', [
            'monthYear' => $monthYear,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'receiptsTotal' => $receiptsTotal,
            'payoutsTotal' => $payoutsTotal,
            'receipts' => $receipts,
            'payouts' => $payouts,
            'balance' => $receiptsTotal - $payoutsTotal,
            'baseUrl' => BASE_URL
        ]);
    }
}
