<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm phương tiện - Quản lý Bảo hiểm Xe</title>
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
        .error { color: red; font-size: 12px; margin-top: 3px; }
        .error-box { color: red; padding: 10px; background-color: #ffebee; border-radius: 3px; margin-bottom: 15px; }
        .button-group { margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Thêm phương tiện mới</h1>
    </div>
    
    <div class="card">
        <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $error): ?>
                <div><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo $baseUrl; ?>/public/index.php?c=Vehicle&m=create">
            <div class="form-group">
                <label for="MaXe">Mã xe:</label>
                <input type="text" id="MaXe" name="MaXe" value="<?php echo htmlspecialchars($data['MaXe'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="MaKH">Mã khách hàng:</label>
                <input type="text" id="MaKH" name="MaKH" value="<?php echo htmlspecialchars($data['MaKH'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="BienSo">Biển số:</label>
                <input type="text" id="BienSo" name="BienSo" value="<?php echo htmlspecialchars($data['BienSo'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="HangXe">Hãng xe:</label>
                <input type="text" id="HangXe" name="HangXe" value="<?php echo htmlspecialchars($data['HangXe'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="DongXe">Dòng xe:</label>
                <input type="text" id="DongXe" name="DongXe" value="<?php echo htmlspecialchars($data['DongXe'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="NamSanXuat">Năm sản xuất:</label>
                <input type="number" id="NamSanXuat" name="NamSanXuat" value="<?php echo htmlspecialchars($data['NamSanXuat'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="MauSac">Màu sắc:</label>
                <input type="text" id="MauSac" name="MauSac" value="<?php echo htmlspecialchars($data['MauSac'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="SoKhung">Số khung:</label>
                <input type="text" id="SoKhung" name="SoKhung" value="<?php echo htmlspecialchars($data['SoKhung'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="SoMay">Số máy:</label>
                <input type="text" id="SoMay" name="SoMay" value="<?php echo htmlspecialchars($data['SoMay'] ?? ''); ?>" required>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn">Lưu</button>
                <a href="<?php echo $baseUrl; ?>/public/index.php?c=Vehicle&m=index" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
