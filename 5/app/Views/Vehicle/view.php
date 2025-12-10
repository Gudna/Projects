<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết phương tiện - Quản lý Bảo hiểm Xe</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        .header { background-color: #333; color: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        .btn { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; border: none; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
        .btn-secondary { background-color: #6c757d; }
        .btn-secondary:hover { background-color: #545b62; }
        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }
        .card { background: white; border-radius: 5px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card h2 { margin-bottom: 15px; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .field { margin: 10px 0; }
        .field label { font-weight: bold; display: block; margin-bottom: 5px; }
        .field-value { padding: 10px; background-color: #f8f9fa; border-radius: 3px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 10px; border-bottom: 1px solid #dee2e6; }
        tr:hover { background-color: #f5f5f5; }
        .actions { margin-top: 20px; }
        .error { color: red; padding: 10px; background-color: #ffebee; border-radius: 3px; margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Chi tiết Phương tiện</h1>
    </div>
    
    <?php if (isset($_SESSION['error'])): ?>
    <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <div class="card">
        <h2>Thông tin phương tiện</h2>
        <div class="field">
            <label>Mã xe:</label>
            <div class="field-value"><?php echo htmlspecialchars($vehicle['MaXe']); ?></div>
        </div>
        <div class="field">
            <label>Biển số:</label>
            <div class="field-value"><?php echo htmlspecialchars($vehicle['BienSo']); ?></div>
        </div>
        <div class="field">
            <label>Hãng xe:</label>
            <div class="field-value"><?php echo htmlspecialchars($vehicle['HangXe']); ?></div>
        </div>
        <div class="field">
            <label>Dòng xe:</label>
            <div class="field-value"><?php echo htmlspecialchars($vehicle['DongXe'] ?? ''); ?></div>
        </div>
        <div class="field">
            <label>Năm sản xuất:</label>
            <div class="field-value"><?php echo htmlspecialchars($vehicle['NamSanXuat']); ?></div>
        </div>
        <div class="field">
            <label>Màu sắc:</label>
            <div class="field-value"><?php echo htmlspecialchars($vehicle['MauSac'] ?? ''); ?></div>
        </div>
        <div class="field">
            <label>Số khung:</label>
            <div class="field-value"><?php echo htmlspecialchars($vehicle['SoKhung']); ?></div>
        </div>
        <div class="field">
            <label>Số máy:</label>
            <div class="field-value"><?php echo htmlspecialchars($vehicle['SoMay']); ?></div>
        </div>
    </div>
    
    <div class="card">
        <h2>Chủ sở hữu</h2>
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
        <?php else: ?>
        <p>Không có thông tin chủ sở hữu</p>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <h2>Hợp đồng (<?php echo is_array($contracts) ? count($contracts) : 0; ?>)</h2>
        <?php if (!empty($contracts) && is_array($contracts)): ?>
        <table>
            <thead><tr><th>Mã HĐ</th><th>Ngày lập</th><th>Ngày hết hạn</th><th>Phí</th></tr></thead>
            <tbody>
                <?php foreach ($contracts as $contract): ?>
                <tr>
                    <td><?php echo htmlspecialchars($contract['MaHD']); ?></td>
                    <td><?php echo htmlspecialchars($contract['NgayLap']); ?></td>
                    <td><?php echo htmlspecialchars($contract['NgayHetHan']); ?></td>
                    <td><?php echo number_format($contract['PhiBaoHiem'], 0, ',', '.'); ?> VNĐ</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Không có hợp đồng nào</p>
        <?php endif; ?>
    </div>
    
    <div class="actions">
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Vehicle&m=index" class="btn btn-secondary">← Quay lại</a>
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Vehicle&m=edit&id=<?php echo $vehicle['MaXe']; ?>" class="btn">Sửa</a>
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Vehicle&m=delete&id=<?php echo $vehicle['MaXe']; ?>" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?');">Xóa</a>
    </div>
</div>
</body>
</html>
