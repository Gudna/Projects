<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo phiếu chi - Quản lý Bảo hiểm Xe</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background-color: #333; color: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        .btn { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; border: none; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
        .btn-secondary { background-color: #6c757d; }
        .btn-secondary:hover { background-color: #545b62; }
        .card { background: white; border-radius: 5px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 3px; font-family: Arial, sans-serif; }
        input:focus, textarea:focus { outline: none; border-color: #007bff; }
        .error-box { color: red; padding: 10px; background-color: #ffebee; border-radius: 3px; margin-bottom: 15px; }
        .button-group { margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Tạo Phiếu Chi</h1>
    </div>
    
    <div class="card">
        <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $field => $error): ?>
                <div><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=payoutCreate">
            <div class="form-group">
                <label for="MaYC">Mã Yêu Cầu:</label>
                <input type="text" id="MaYC" name="MaYC" value="<?php echo htmlspecialchars($data['MaYC'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="NgayChiTien">Ngày Chi Tiền:</label>
                <input type="date" id="NgayChiTien" name="NgayChiTien" value="<?php echo htmlspecialchars($data['NgayChiTien'] ?? date('Y-m-d')); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="SoTienChi">Số Tiền Chi (VNĐ):</label>
                <input type="number" id="SoTienChi" name="SoTienChi" value="<?php echo htmlspecialchars($data['SoTienChi'] ?? ''); ?>" min="0" step="0.01" required>
            </div>
            
            <div class="form-group">
                <label for="GhiChu">Ghi Chú:</label>
                <textarea id="GhiChu" name="GhiChu" rows="4"><?php echo htmlspecialchars($data['GhiChu'] ?? ''); ?></textarea>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn">Tạo Phiếu Chi</button>
                <a href="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=payoutIndex" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
