<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo tài chính - Quản lý Bảo hiểm Xe</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background-color: #333; color: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        .filter { background: white; border-radius: 5px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .filter-group { display: flex; gap: 10px; align-items: flex-end; }
        .filter-item { flex: 1; }
        .filter-item label { display: block; margin-bottom: 5px; font-weight: bold; }
        .filter-item input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 3px; }
        .btn { display: inline-block; padding: 8px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
        .summary { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .summary-card { background: white; border-radius: 5px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .summary-label { font-size: 12px; color: #666; margin-bottom: 10px; }
        .summary-value { font-size: 24px; font-weight: bold; color: #333; }
        .summary-value.positive { color: #28a745; }
        .summary-value.negative { color: #dc3545; }
        .card { background: white; border-radius: 5px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; font-weight: bold; }
        tr:hover { background-color: #f5f5f5; }
        .no-data { text-align: center; padding: 20px; color: #666; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Báo Cáo Tài Chính</h1>
    </div>
    
    <div class="filter">
        <form method="GET" action="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=reports">
            <div class="filter-group">
                <div class="filter-item">
                    <label for="month">Chọn Tháng:</label>
                    <input type="month" id="month" name="month" value="<?php echo htmlspecialchars($monthYear); ?>">
                </div>
                <button type="submit" class="btn">Xem Báo Cáo</button>
                <a href="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=receiptIndex" class="btn" style="background-color: #6c757d;">Phiếu Thu</a>
                <a href="<?php echo $baseUrl; ?>/public/index.php?c=Accounting&m=payoutIndex" class="btn" style="background-color: #6c757d;">Phiếu Chi</a>
            </div>
        </form>
    </div>
    
    <div class="summary">
        <div class="summary-card">
            <div class="summary-label">Tổng Thu Tiền</div>
            <div class="summary-value positive"><?php echo number_format($receiptsTotal, 0, ',', '.'); ?> VNĐ</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Tổng Chi Tiền</div>
            <div class="summary-value negative"><?php echo number_format($payoutsTotal, 0, ',', '.'); ?> VNĐ</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Chênh Lệch (Lợi/Lỗ)</div>
            <div class="summary-value <?php echo $balance >= 0 ? 'positive' : 'negative'; ?>">
                <?php echo number_format($balance, 0, ',', '.'); ?> VNĐ
            </div>
        </div>
    </div>
    
    <div class="card">
        <h3>Chi Tiết Phiếu Thu - Tháng <?php echo htmlspecialchars($monthYear); ?></h3>
        <?php if (empty($receipts)): ?>
        <div class="no-data">Không có phiếu thu trong tháng này.</div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Mã Phiếu</th>
                    <th>Mã HĐ</th>
                    <th>Ngày Thu</th>
                    <th>Số Tiền (VNĐ)</th>
                    <th>Nhân Viên</th>
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
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <h3>Chi Tiết Phiếu Chi - Tháng <?php echo htmlspecialchars($monthYear); ?></h3>
        <?php if (empty($payouts)): ?>
        <div class="no-data">Không có phiếu chi trong tháng này.</div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Mã Phiếu</th>
                    <th>Mã Yêu Cầu</th>
                    <th>Ngày Chi</th>
                    <th>Số Tiền (VNĐ)</th>
                    <th>Nhân Viên</th>
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
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
