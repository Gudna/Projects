<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu chi - Quản lý Bảo hiểm Xe</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background-color: #333; color: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { margin: 0; }
        .btn { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; border: none; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }
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
        <h1>Phiếu Chi</h1>
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=payoutCreate" class="btn btn-danger">+ Phiếu Chi Mới</a>
    </div>
    
    <div class="card">
        <?php if (empty($payouts)): ?>
        <div class="no-data">
            Chưa có phiếu chi nào.
        </div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Mã Phiếu</th>
                    <th>Mã Yêu Cầu</th>
                    <th>Ngày Chi Tiền</th>
                    <th>Số Tiền Chi (VNĐ)</th>
                    <th>Nhân Viên</th>
                    <th>Ghi Chú</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payouts as $payout): ?>
                <tr>
                    <td><?php echo htmlspecialchars($payout['MaPC']); ?></td>
                    <td><?php echo htmlspecialchars($payout['MaYC']); ?></td>
                    <td><?php echo htmlspecialchars($payout['NgayChiTien']); ?></td>
                    <td><?php echo number_format($payout['SoTienChi'], 0, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($payout['MaNV']); ?></td>
                    <td><?php echo htmlspecialchars($payout['GhiChu'] ?? ''); ?></td>
                    <td class="action-buttons">
                        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=payoutView&id=<?php echo htmlspecialchars($payout['MaPC']); ?>" class="btn" style="padding: 5px 10px; font-size: 12px;">Xem</a>
                        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=payoutEdit&id=<?php echo htmlspecialchars($payout['MaPC']); ?>" class="btn" style="padding: 5px 10px; font-size: 12px;">Sửa</a>
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
