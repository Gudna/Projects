<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách khách hàng - Quản lý Bảo hiểm Xe</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background-color: #333; color: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        .header h1 { margin: 0; }
        .btn { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; border: none; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }
        .btn-secondary { background-color: #6c757d; }
        .btn-secondary:hover { background-color: #545b62; }
        .search-box { margin: 20px 0; }
        .search-box input { padding: 10px; width: 300px; }
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
        <h1>Danh sách Khách hàng</h1>
    </div>
    
    <div style="margin-bottom: 20px;">
        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Customer&m=create" class="btn">+ Thêm khách hàng</a>
    </div>
    
    <div class="search-box">
        <form method="GET" action="<?php echo $baseUrl; ?>/public/index.php">
            <input type="hidden" name="c" value="Customer">
            <input type="hidden" name="m" value="index">
            <input type="text" name="search" placeholder="Tìm kiếm theo tên..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
            <button type="submit" class="btn">Tìm kiếm</button>
        </form>
    </div>
    
    <?php if (!empty($customers)): ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Mã KH</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($customer['MaKH']); ?></td>
                    <td><?php echo htmlspecialchars($customer['HoTen']); ?></td>
                    <td><?php echo htmlspecialchars($customer['SoDienThoai']); ?></td>
                    <td><?php echo htmlspecialchars($customer['Email'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($customer['DiaChi'] ?? ''); ?></td>
                    <td class="actions">
                        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Customer&m=view&id=<?php echo $customer['MaKH']; ?>" class="btn btn-secondary">Xem</a>
                        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Customer&m=edit&id=<?php echo $customer['MaKH']; ?>" class="btn">Sửa</a>
                        <a href="<?php echo $baseUrl; ?>/public/index.php?c=Customer&m=delete&id=<?php echo $customer['MaKH']; ?>" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?');">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="table-wrapper">
        <div class="no-data">Không có khách hàng nào</div>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
