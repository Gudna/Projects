<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo yêu cầu bồi thường - Quản lý Bảo hiểm Xe</title>
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
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 3px; font-family: Arial, sans-serif; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #007bff; }
        .error-box { color: red; padding: 10px; background-color: #ffebee; border-radius: 3px; margin-bottom: 15px; }
        .button-group { margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Tạo yêu cầu bồi thường</h1>
    </div>
    
    <div class="card">
        <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $field => $error): ?>
                <div><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=create">
            <div class="form-group">
                <label for="MaHD">Mã hợp đồng:</label>
                <input type="text" id="MaHD" name="MaHD" value="<?php echo htmlspecialchars($data['MaHD'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="NgayYeuCau">Ngày yêu cầu:</label>
                <input type="date" id="NgayYeuCau" name="NgayYeuCau" value="<?php echo htmlspecialchars($data['NgayYeuCau'] ?? date('Y-m-d')); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="NgaySuCo">Ngày sự cố:</label>
                <input type="date" id="NgaySuCo" name="NgaySuCo" value="<?php echo htmlspecialchars($data['NgaySuCo'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="DiaDiemSuCo">Địa điểm sự cố:</label>
                <input type="text" id="DiaDiemSuCo" name="DiaDiemSuCo" value="<?php echo htmlspecialchars($data['DiaDiemSuCo'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="MoTaSuCo">Mô tả sự cố:</label>
                <textarea id="MoTaSuCo" name="MoTaSuCo" rows="4" required><?php echo htmlspecialchars($data['MoTaSuCo'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="SoTienDeXuat">Số tiền đề xuất (VNĐ):</label>
                <input type="number" id="SoTienDeXuat" name="SoTienDeXuat" value="<?php echo htmlspecialchars($data['SoTienDeXuat'] ?? ''); ?>" min="0" step="0.01" required>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn">Tạo yêu cầu</button>
                <a href="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=index" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
