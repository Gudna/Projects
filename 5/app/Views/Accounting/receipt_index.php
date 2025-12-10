<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu thu - Quản lý Bảo hiểm Xe</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background-color: #333; color: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { margin: 0; }
        .btn { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; border: none; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
        .btn-success { background-color: #28a745; }
        .btn-success:hover { background-color: #218838; }
        .card { background: white; border-radius: 5px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; font-weight: bold; }
        tr:hover { background-color: #f5f5f5; }
        .no-data { text-align: center; padding: 40px; color: #666; }
        .action-buttons { white-space: nowrap; }
        .action-buttons a { margin-right: 5px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Phiếu Thu</h1>
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=receiptCreate" class="btn btn-success">+ Phiếu Thu Mới</a>
    </div>
    
    <div class="card">
        <?php if (empty($receipts)): ?>
        <div class="no-data">
            Chưa có phiếu thu nào.
        </div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Mã Phiếu</th>
                    <th>Mã HĐ</th>
                    <th>Ngày Thu Tiền</th>
                    <th>Số Tiền Thu (VNĐ)</th>
                    <th>Nhân Viên</th>
                    <th>Ghi Chú</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($receipts as $receipt): ?>
                <tr>
                    <td><?php echo htmlspecialchars($receipt['MaPT']); ?></td>
                    <td><?php echo htmlspecialchars($receipt['MaHD']); ?></td>
                    <td><?php echo htmlspecialchars($receipt['NgayThuTien']); ?></td>
                    <td><?php echo number_format($receipt['SoTienThu'], 0, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($receipt['MaNV']); ?></td>
                    <td><?php echo htmlspecialchars($receipt['GhiChu'] ?? ''); ?></td>
                    <td class="action-buttons">
                        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=receiptView&id=<?php echo htmlspecialchars($receipt['MaPT']); ?>" class="btn" style="padding: 5px 10px; font-size: 12px;">Xem</a>
                        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=receiptEdit&id=<?php echo htmlspecialchars($receipt['MaPT']); ?>" class="btn" style="padding: 5px 10px; font-size: 12px;">Sửa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
