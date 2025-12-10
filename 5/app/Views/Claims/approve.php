<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phê duyệt yêu cầu - Quản lý Bảo hiểm Xe</title>
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
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 3px; font-family: Arial, sans-serif; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #007bff; }
        .error-box { color: red; padding: 10px; background-color: #ffebee; border-radius: 3px; margin-bottom: 15px; }
        .button-group { margin-top: 20px; }
        .info-field { padding: 10px; background-color: #f9f9f9; border-radius: 3px; }
        .amount-row { display: flex; gap: 30px; }
        .amount-col { flex: 1; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Phê duyệt yêu cầu bồi thường</h1>
    </div>
    
    <div class="card">
        <h3>Thông tin yêu cầu</h3>
        <div class="info-row">
            <div class="info-label">Mã yêu cầu:</div>
            <div class="info-value"><?php echo htmlspecialchars($data['MaYC'] ?? ''); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Mã hợp đồng:</div>
            <div class="info-value"><?php echo htmlspecialchars($data['MaHD'] ?? ''); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Ngày yêu cầu:</div>
            <div class="info-value"><?php echo htmlspecialchars($data['NgayYeuCau'] ?? ''); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Trạng thái:</div>
            <div class="info-value">
                <span style="background-color: #ffc107; padding: 5px 10px; border-radius: 3px;">
                    <?php echo htmlspecialchars($data['TrangThai'] ?? ''); ?>
                </span>
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Kết quả thẩm định:</div>
            <div class="info-value">
                <div class="info-field"><?php echo htmlspecialchars($data['KetQuaThamDinh'] ?? ''); ?></div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <h3>Số tiền</h3>
        <div class="amount-row">
            <div class="amount-col">
                <div class="info-label">Số tiền đề xuất:</div>
                <div class="info-value"><?php echo number_format($data['SoTienDeXuat'] ?? 0, 0, ',', '.'); ?> VNĐ</div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $field => $error): ?>
                <div><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=approve">
            <input type="hidden" name="MaYC" value="<?php echo htmlspecialchars($data['MaYC'] ?? ''); ?>">
            
            <div class="form-group">
                <label for="SoTienDuyet">Số tiền duyệt (VNĐ):</label>
                <input type="number" id="SoTienDuyet" name="SoTienDuyet" value="<?php echo htmlspecialchars($data['SoTienDuyet'] ?? $data['SoTienDeXuat'] ?? ''); ?>" min="0" step="0.01" required>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn">Phê duyệt</button>
                <a href="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=view&id=<?php echo htmlspecialchars($data['MaYC'] ?? ''); ?>" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
