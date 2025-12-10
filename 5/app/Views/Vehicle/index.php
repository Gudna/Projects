<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phương tiện - Quản lý Bảo hiểm Xe</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background-color: #333; color: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        .btn { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; border: none; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }
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
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Danh sách Phương tiện</h1>
    </div>
    
    <div style="margin-bottom: 20px;">
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Vehicle&m=create" class="btn">+ Thêm phương tiện</a>
    </div>
    
    <?php if (!empty($vehicles)): ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Mã XE</th>
                    <th>Biển số</th>
                    <th>Hãng xe</th>
                    <th>Năm sản xuất</th>
                    <th>Số khung</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $vehicle): ?>
                <tr>
                    <td><?php echo htmlspecialchars($vehicle['MaXe']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['BienSo']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['HangXe']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['NamSanXuat']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['SoKhung']); ?></td>
                    <td class="actions">
                        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Vehicle&m=view&id=<?php echo $vehicle['MaXe']; ?>" class="btn btn-secondary">Xem</a>
                        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Vehicle&m=edit&id=<?php echo $vehicle['MaXe']; ?>" class="btn">Sửa</a>
                        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Vehicle&m=delete&id=<?php echo $vehicle['MaXe']; ?>" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?');">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="table-wrapper">
        <div class="no-data">Không có phương tiện nào</div>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
