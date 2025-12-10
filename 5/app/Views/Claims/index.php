<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách yêu cầu bồi thường - Quản lý Bảo hiểm Xe</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background-color: #333; color: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        .btn { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; border: none; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
        .btn-secondary { background-color: #6c757d; }
        .btn-secondary:hover { background-color: #545b62; }
        .table-wrapper { background: white; border-radius: 5px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #f8f9fa; padding: 15px; text-align: left; border-bottom: 2px solid #dee2e6; }
        td { padding: 15px; border-bottom: 1px solid #dee2e6; }
        tr:hover { background-color: #f5f5f5; }
        .actions { white-space: nowrap; }
        .actions a { margin-right: 5px; padding: 5px 10px; font-size: 12px; }
        .no-data { text-align: center; padding: 40px; color: #999; }
        .status-badge { display: inline-block; padding: 5px 10px; border-radius: 3px; font-size: 12px; font-weight: bold; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-approved { background-color: #d4edda; color: #155724; }
        .status-rejected { background-color: #f8d7da; color: #721c24; }
        .filters { margin: 20px 0; }
        .filters a { margin-right: 10px; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; display: inline-block; }
        .filters a:hover { background-color: #0056b3; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Danh sách Yêu cầu Bồi thường</h1>
    </div>
    
    <div style="margin-bottom: 20px;">
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=create" class="btn">+ Tạo yêu cầu mới</a>
    </div>
    
    <div class="filters">
        <span>Lọc theo trạng thái:</span>
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=index">Tất cả</a>
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=index&status=Chờ%20duyệt">Chờ duyệt</a>
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=index&status=Thẩm%20định%20xong">Thẩm định xong</a>
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=index&status=Đã%20duyệt">Đã duyệt</a>
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=index&status=Từ%20chối">Từ chối</a>
    </div>
    
    <?php if (!empty($claims) && is_array($claims)): ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Mã YC</th>
                    <th>Mã HĐ</th>
                    <th>Ngày yêu cầu</th>
                    <th>Ngày sự cố</th>
                    <th>Số tiền đề xuất</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($claims as $claim): ?>
                <tr>
                    <td><?php echo htmlspecialchars($claim['MaYC']); ?></td>
                    <td><?php echo htmlspecialchars($claim['MaHD']); ?></td>
                    <td><?php echo htmlspecialchars($claim['NgayYeuCau']); ?></td>
                    <td><?php echo htmlspecialchars($claim['NgaySuCo']); ?></td>
                    <td><?php echo number_format($claim['SoTienDeXuat'], 0, ',', '.'); ?> VNĐ</td>
                    <td>
                        <span class="status-badge status-<?php 
                            echo $claim['TrangThai'] === 'Chờ duyệt' ? 'pending' : 
                                ($claim['TrangThai'] === 'Đã duyệt' ? 'approved' : 'rejected'); 
                        ?>">
                            <?php echo htmlspecialchars($claim['TrangThai']); ?>
                        </span>
                    </td>
                    <td class="actions">
                        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Claims&m=view&id=<?php echo $claim['MaYC']; ?>" class="btn btn-secondary">Xem</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="table-wrapper">
        <div class="no-data">Không có yêu cầu nào</div>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
