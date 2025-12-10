<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết yêu cầu bồi thường - Quản lý Bảo hiểm Xe</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        .header { background-color: #333; color: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        .btn { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; border: none; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
        .btn-secondary { background-color: #6c757d; }
        .btn-secondary:hover { background-color: #545b62; }
        .btn-success { background-color: #28a745; }
        .btn-success:hover { background-color: #218838; }
        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }
        .card { background: white; border-radius: 5px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card h2 { margin-bottom: 15px; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .field { margin: 10px 0; }
        .field label { font-weight: bold; display: block; margin-bottom: 5px; }
        .field-value { padding: 10px; background-color: #f8f9fa; border-radius: 3px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 10px; border-bottom: 1px solid #dee2e6; }
        .actions { margin-top: 20px; }
        .status-badge { display: inline-block; padding: 8px 15px; border-radius: 3px; font-size: 14px; font-weight: bold; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-approved { background-color: #d4edda; color: #155724; }
        .status-rejected { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Chi tiết Yêu cầu Bồi thường</h1>
    </div>
    
    <div class="card">
        <h2>Thông tin yêu cầu</h2>
        <div class="field">
            <label>Mã YC:</label>
            <div class="field-value"><?php echo htmlspecialchars($claim['MaYC']); ?></div>
        </div>
        <div class="field">
            <label>Ngày yêu cầu:</label>
            <div class="field-value"><?php echo htmlspecialchars($claim['NgayYeuCau']); ?></div>
        </div>
        <div class="field">
            <label>Ngày sự cố:</label>
            <div class="field-value"><?php echo htmlspecialchars($claim['NgaySuCo']); ?></div>
        </div>
        <div class="field">
            <label>Địa điểm sự cố:</label>
            <div class="field-value"><?php echo htmlspecialchars($claim['DiaDiemSuCo']); ?></div>
        </div>
        <div class="field">
            <label>Mô tả sự cố:</label>
            <div class="field-value"><?php echo htmlspecialchars($claim['MoTaSuCo']); ?></div>
        </div>
        <div class="field">
            <label>Số tiền đề xuất:</label>
            <div class="field-value"><?php echo number_format($claim['SoTienDeXuat'], 0, ',', '.'); ?> VNĐ</div>
        </div>
        <div class="field">
            <label>Số tiền duyệt:</label>
            <div class="field-value"><?php echo $claim['SoTienDuyet'] ? number_format($claim['SoTienDuyet'], 0, ',', '.') . ' VNĐ' : '---'; ?></div>
        </div>
        <div class="field">
            <label>Trạng thái:</label>
            <div class="field-value">
                <span class="status-badge status-<?php 
                    echo $claim['TrangThai'] === 'Chờ duyệt' ? 'pending' : 
                        ($claim['TrangThai'] === 'Đã duyệt' ? 'approved' : 'rejected'); 
                ?>">
                    <?php echo htmlspecialchars($claim['TrangThai']); ?>
                </span>
            </div>
        </div>
        <?php if ($claim['LyDoTuChoi']): ?>
        <div class="field">
            <label>Lý do từ chối:</label>
            <div class="field-value"><?php echo htmlspecialchars($claim['LyDoTuChoi']); ?></div>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <h2>Thông tin hợp đồng</h2>
        <div class="field">
            <label>Mã HĐ:</label>
            <div class="field-value"><?php echo htmlspecialchars($contract['MaHD']); ?></div>
        </div>
        <div class="field">
            <label>Ngày lập:</label>
            <div class="field-value"><?php echo htmlspecialchars($contract['NgayLap']); ?></div>
        </div>
        <div class="field">
            <label>Ngày hết hạn:</label>
            <div class="field-value"><?php echo htmlspecialchars($contract['NgayHetHan']); ?></div>
        </div>
        <div class="field">
            <label>Phí bảo hiểm:</label>
            <div class="field-value"><?php echo number_format($contract['PhiBaoHiem'], 0, ',', '.'); ?> VNĐ</div>
        </div>
    </div>
    
    <div class="card">
        <h2>Thông tin khách hàng</h2>
        <?php if ($customer): ?>
        <div class="field">
            <label>Mã KH:</label>
            <div class="field-value"><?php echo htmlspecialchars($customer['MaKH']); ?></div>
        </div>
        <div class="field">
            <label>Tên:</label>
            <div class="field-value"><?php echo htmlspecialchars($customer['HoTen']); ?></div>
        </div>
        <div class="field">
            <label>Số điện thoại:</label>
            <div class="field-value"><?php echo htmlspecialchars($customer['SoDienThoai']); ?></div>
        </div>
        <div class="field">
            <label>Địa chỉ:</label>
            <div class="field-value"><?php echo htmlspecialchars($customer['DiaChi']); ?></div>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <h2>Thông tin phương tiện</h2>
        <?php if ($vehicle): ?>
        <div class="field">
            <label>Biển số:</label>
            <div class="field-value"><?php echo htmlspecialchars($vehicle['BienSo']); ?></div>
        </div>
        <div class="field">
            <label>Hãng xe:</label>
            <div class="field-value"><?php echo htmlspecialchars($vehicle['HangXe']); ?></div>
        </div>
        <div class="field">
            <label>Năm sản xuất:</label>
            <div class="field-value"><?php echo htmlspecialchars($vehicle['NamSanXuat']); ?></div>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="actions">
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=index" class="btn btn-secondary">← Quay lại</a>
        <?php if ($claim['TrangThai'] === 'Chờ duyệt'): ?>
            <a href="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=assess&id=<?php echo $claim['MaYC']; ?>" class="btn">Thẩm định</a>
        <?php endif; ?>
        <?php if ($claim['TrangThai'] === 'Thẩm định xong'): ?>
            <a href="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=approve&id=<?php echo $claim['MaYC']; ?>" class="btn btn-success">Phê duyệt</a>
            <a href="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=reject&id=<?php echo $claim['MaYC']; ?>" class="btn btn-danger">Từ chối</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
