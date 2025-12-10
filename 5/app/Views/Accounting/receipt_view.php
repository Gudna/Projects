<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết phiếu thu - Quản lý Bảo hiểm Xe</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; padding: 20px; }
        .header { background-color: #333; color: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        .btn { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; border: none; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
        .btn-secondary { background-color: #6c757d; }
        .btn-secondary:hover { background-color: #545b62; }
        .card { background: white; border-radius: 5px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .info-row { display: flex; margin-bottom: 15px; }
        .info-label { flex: 0 0 200px; font-weight: bold; }
        .info-value { flex: 1; }
        .info-field { padding: 10px; background-color: #f9f9f9; border-radius: 3px; }
        .button-group { margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Chi tiết Phiếu Thu</h1>
    </div>
    
    <div class="card">
        <h3>Thông tin phiếu thu</h3>
        <div class="info-row">
            <div class="info-label">Mã Phiếu:</div>
            <div class="info-value"><?php echo htmlspecialchars($receipt['MaPT']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Mã Hợp Đồng:</div>
            <div class="info-value"><?php echo htmlspecialchars($receipt['MaHD']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Ngày Thu Tiền:</div>
            <div class="info-value"><?php echo htmlspecialchars($receipt['NgayThuTien']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Số Tiền Thu (VNĐ):</div>
            <div class="info-value"><strong><?php echo number_format($receipt['SoTienThu'], 0, ',', '.'); ?></strong></div>
        </div>
        <div class="info-row">
            <div class="info-label">Nhân Viên:</div>
            <div class="info-value"><?php echo htmlspecialchars($receipt['MaNV']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Ghi Chú:</div>
            <div class="info-value">
                <div class="info-field"><?php echo htmlspecialchars($receipt['GhiChu'] ?? 'Không có'); ?></div>
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Ngày Tạo:</div>
            <div class="info-value"><?php echo htmlspecialchars($receipt['NgayTao'] ?? ''); ?></div>
        </div>
    </div>
    
    <?php if (!empty($contract)): ?>
    <div class="card">
        <h3>Thông tin hợp đồng</h3>
        <div class="info-row">
            <div class="info-label">Mã HĐ:</div>
            <div class="info-value"><?php echo htmlspecialchars($contract['MaHD']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Ngày Lập:</div>
            <div class="info-value"><?php echo htmlspecialchars($contract['NgayLap']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Ngày Hết Hạn:</div>
            <div class="info-value"><?php echo htmlspecialchars($contract['NgayHetHan']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Phí Bảo Hiểm (VNĐ):</div>
            <div class="info-value"><?php echo number_format($contract['PhiBaoHiem'], 0, ',', '.'); ?></div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="button-group">
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=receiptEdit&id=<?php echo htmlspecialchars($receipt['MaPT']); ?>" class="btn">Sửa</a>
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=receiptIndex" class="btn btn-secondary">Quay lại</a>
    </div>
</div>
</body>
</html>
