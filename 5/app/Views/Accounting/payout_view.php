<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết phiếu chi - Quản lý Bảo hiểm Xe</title>
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
        <h1>Chi tiết Phiếu Chi</h1>
    </div>
    
    <div class="card">
        <h3>Thông tin phiếu chi</h3>
        <div class="info-row">
            <div class="info-label">Mã Phiếu:</div>
            <div class="info-value"><?php echo htmlspecialchars($payout['MaPC']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Mã Yêu Cầu:</div>
            <div class="info-value"><?php echo htmlspecialchars($payout['MaYC']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Ngày Chi Tiền:</div>
            <div class="info-value"><?php echo htmlspecialchars($payout['NgayChiTien']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Số Tiền Chi (VNĐ):</div>
            <div class="info-value"><strong><?php echo number_format($payout['SoTienChi'], 0, ',', '.'); ?></strong></div>
        </div>
        <div class="info-row">
            <div class="info-label">Nhân Viên:</div>
            <div class="info-value"><?php echo htmlspecialchars($payout['MaNV']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Ghi Chú:</div>
            <div class="info-value">
                <div class="info-field"><?php echo htmlspecialchars($payout['GhiChu'] ?? 'Không có'); ?></div>
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Ngày Tạo:</div>
            <div class="info-value"><?php echo htmlspecialchars($payout['NgayTao'] ?? ''); ?></div>
        </div>
    </div>
    
    <?php if (!empty($claim)): ?>
    <div class="card">
        <h3>Thông tin yêu cầu bồi thường</h3>
        <div class="info-row">
            <div class="info-label">Mã Yêu Cầu:</div>
            <div class="info-value"><?php echo htmlspecialchars($claim['MaYC']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Ngày Yêu Cầu:</div>
            <div class="info-value"><?php echo htmlspecialchars($claim['NgayYeuCau']); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Trạng Thái:</div>
            <div class="info-value">
                <span style="background-color: #28a745; color: white; padding: 5px 10px; border-radius: 3px;">
                    <?php echo htmlspecialchars($claim['TrangThai']); ?>
                </span>
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Số Tiền Duyệt (VNĐ):</div>
            <div class="info-value"><?php echo number_format($claim['SoTienDuyet'] ?? 0, 0, ',', '.'); ?></div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="button-group">
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=payoutEdit&id=<?php echo htmlspecialchars($payout['MaPC']); ?>" class="btn">Sửa</a>
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=payoutIndex" class="btn btn-secondary">Quay lại</a>
    </div>
</div>
</body>
</html>
