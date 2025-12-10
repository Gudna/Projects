# Hệ thống Quản lý Bảo hiểm Xe - Hoàn Thành

## Tóm tắt

Hệ thống Quản lý Bảo hiểm Xe (Vehicle Insurance Management System) đã được phát triển hoàn toàn theo yêu cầu SRS với kiến trúc OOP nhẹ và mô hình Base Model.

## Cấu trúc Dự Án

```
FProjects/5/
├── config/
│   └── config.php (Cấu hình, autoloader, hằng số)
├── core/
│   ├── Database.php (PDO singleton)
│   ├── Logger.php (Tự động logging hoạt động)
│   ├── Model.php (Lớp cơ sở cho các model)
│   └── Controller.php (Lớp cơ sở cho các controller)
├── app/
│   ├── Models/
│   │   ├── Khachhang.php (Quản lý khách hàng)
│   │   ├── Xe.php (Quản lý phương tiện)
│   │   ├── Hopdong.php (Quản lý hợp đồng)
│   │   ├── YeuCau.php (Quản lý yêu cầu bồi thường)
│   │   ├── PhieuThu.php (Quản lý phiếu thu)
│   │   └── PhieuChi.php (Quản lý phiếu chi)
│   ├── Controllers/
│   │   ├── CustomerController.php (Xử lý khách hàng)
│   │   ├── VehicleController.php (Xử lý phương tiện)
│   │   ├── ClaimsController.php (Xử lý yêu cầu bồi thường)
│   │   └── AccountingController.php (Xử lý tài chính)
│   └── Views/
│       ├── Customer/ (4 views: index, view, create, edit)
│       ├── Vehicle/ (4 views: index, view, create, edit)
│       ├── Claims/ (6 views: index, view, create, assess, approve, reject)
│       └── Accounting/ (7 views: receipt_index, receipt_view, receipt_create, receipt_edit, payout_index, payout_view, payout_create, payout_edit, reports)
├── public/
│   └── index.php (Entry point - Router)
├── assets/ (CSS, JS, hình ảnh)
└── uploads/ (Thư mục tải lên tập tin)
```

## 4 Mô-đun Chính

### Module-1: Khách hàng (Customer)

**Hoàn thành 100%**

- **Controller**: `CustomerController.php`

  - `index()` - Danh sách khách hàng (có tìm kiếm)
  - `view($id)` - Xem chi tiết khách hàng + phương tiện + hợp đồng
  - `create()` - Tạo khách hàng mới
  - `edit($id)` - Cập nhật thông tin khách hàng
  - `delete($id)` - Xóa mềm khách hàng

- **Views**: 4 file HTML

  - `index.php` - Bảng danh sách với tìm kiếm
  - `view.php` - Chi tiết khách hàng + danh sách xe + hợp đồng
  - `create.php` - Form tạo mới
  - `edit.php` - Form cập nhật

- **Kiểm tra**:
  - CCCD không trùng lặp
  - Email hợp lệ
  - Không xóa nếu có xe hoặc hợp đồng

### Module-2: Yêu cầu Bồi thường (Claims) - Phiếu yêu cầu bồi thường

**Hoàn thành 100%**

- **Controller**: `ClaimsController.php`

  - `index()` - Danh sách yêu cầu (lọc theo trạng thái)
  - `view($id)` - Chi tiết yêu cầu + hợp đồng + khách hàng + phương tiện
  - `create()` - Tạo yêu cầu bồi thường mới
  - `assess($id)` - Thẩm định yêu cầu
  - `approve($id)` - Phê duyệt yêu cầu
  - `reject($id)` - Từ chối yêu cầu

- **Views**: 6 file HTML

  - `index.php` - Danh sách với bộ lọc trạng thái
  - `view.php` - Chi tiết yêu cầu + các nút hành động có điều kiện
  - `create.php` - Form tạo yêu cầu mới
  - `assess.php` - Form thẩm định (nhập kết quả thẩm định)
  - `approve.php` - Form phê duyệt (nhập số tiền duyệt)
  - `reject.php` - Form từ chối (nhập lý do từ chối)

- **Quy trình Workflow**:

  - "Chờ duyệt" → "Thẩm định xong" → ("Đã duyệt" hoặc "Từ chối")

- **Tính năng**:
  - Bộ lọc trạng thái với các badge màu
  - Nút hành động có điều kiện dựa vào trạng thái
  - Hiển thị thông tin liên quan (hợp đồng, khách hàng, phương tiện)

### Module-3: Phương tiện (Vehicle)

**Hoàn thành 100%**

- **Controller**: `VehicleController.php`

  - `index()` - Danh sách phương tiện
  - `view($id)` - Chi tiết phương tiện + chủ sở hữu + hợp đồng
  - `create()` - Tạo phương tiện mới
  - `edit($id)` - Cập nhật thông tin phương tiện
  - `delete($id)` - Xóa mềm phương tiện

- **Views**: 4 file HTML

  - `index.php` - Bảng danh sách phương tiện
  - `view.php` - Chi tiết phương tiện + thông tin chủ sở hữu + hợp đồng
  - `create.php` - Form tạo mới
  - `edit.php` - Form cập nhật

- **Kiểm tra**:
  - Biển số không trùng lặp
  - Số khung không trùng lặp
  - Số máy không trùng lặp
  - Không xóa nếu có hợp đồng hoạt động

### Module-4: Kế toán (Accounting) - Phiếu thu chi & Báo cáo

**Hoàn thành 100%**

- **Controller**: `AccountingController.php`

  - **Phiếu Thu (Receipt)**:

    - `receiptIndex()` - Danh sách phiếu thu
    - `receiptView($id)` - Chi tiết phiếu thu
    - `receiptCreate()` - Tạo phiếu thu
    - `receiptEdit($id)` - Cập nhật phiếu thu

  - **Phiếu Chi (Payout)**:

    - `payoutIndex()` - Danh sách phiếu chi
    - `payoutView($id)` - Chi tiết phiếu chi
    - `payoutCreate()` - Tạo phiếu chi (chỉ cho yêu cầu đã duyệt)
    - `payoutEdit($id)` - Cập nhật phiếu chi

  - **Báo cáo**:
    - `reports()` - Báo cáo tài chính theo tháng

- **Views**: 10 file HTML

  - `receipt_index.php` - Bảng phiếu thu
  - `receipt_view.php` - Chi tiết phiếu thu
  - `receipt_create.php` - Form tạo phiếu thu
  - `receipt_edit.php` - Form cập nhật phiếu thu
  - `payout_index.php` - Bảng phiếu chi
  - `payout_view.php` - Chi tiết phiếu chi
  - `payout_create.php` - Form tạo phiếu chi
  - `payout_edit.php` - Form cập nhật phiếu chi
  - `reports.php` - Báo cáo tài chính (tổng thu, tổng chi, chênh lệch)

- **Tính năng**:
  - Phiếu chi chỉ được tạo cho yêu cầu đã duyệt
  - Báo cáo tính toán tổng cộng theo tháng
  - Hiển thị chênh lệch (lợi/lỗ)

## Các Tính năng Chính

### 1. Cơ chế Xóa Mềm (Soft Delete)

- Tất cả bảng có cột `TrangThai`
- Xóa: Đặt `TrangThai = 'DaXoa'` thay vì xóa vật lý
- Truy vấn: Lọc `WHERE TrangThai != 'DaXoa'`

### 2. Tự động Logging

- Lớp `Logger.php` ghi mọi thao tác CREATE/UPDATE/DELETE
- Bảng `qlbh_lichsu`:
  - BangDuLieu (tên bảng)
  - MaBanGhi (ID bản ghi)
  - HanhDong (INSERT/UPDATE/DELETE)
  - DuLieuCu (JSON)
  - DuLieuMoi (JSON)
  - MaNV (ID nhân viên)
  - IP (IP địa chỉ)
  - ThoiGian (thời gian thao tác)

### 3. Kiểm chứng Dữ liệu

- Kiểm tra độc đáo (CCCD, BienSo, SoKhung, SoMay)
- Kiểm tra toàn vẹn tham chiếu (không xóa nếu có quan hệ)
- Kiểm tra quy trình (phiếu chi chỉ cho yêu cầu đã duyệt)

### 4. Kiến trúc OOP

- Base Model: Cung cấp CRUD chuẩn
- Base Controller: Xử lý yêu cầu/phản hồi
- Các model con kế thừa Base Model
- Các controller con kế thừa Base Controller

### 5. Router

- URL: `?c=ControllerName&m=methodName`
- Ví dụ: `?c=Customer&m=index`
- Tự động tải lớp và gọi phương thức

### 6. PDO + Prepared Statements

- Tất cả truy vấn sử dụng prepared statements
- Ngăn chặn SQL injection
- Tham số hóa tất cả giá trị người dùng

## Base Model API

```php
// Đọc
$model->all($where = [])                    // Tất cả bản ghi
$model->find($id)                           // Theo ID chính
$model->findBy($column, $value)            // Theo một cột
$model->findAll($column, $value)           // Tất cả theo một cột
$model->count($where = [])                 // Đếm bản ghi

// Viết
$model->create($data, $userId)             // Tạo mới
$model->update($id, $data, $userId)        // Cập nhật
$model->softDelete($id, $userId)           // Xóa mềm

// Tiện ích
$model->filterFillable($data)               // Lọc dữ liệu
$model->buildWhere($conditions)             // Xây dựng WHERE clause
```

## Cấu hình Cơ sở Dữ liệu

```php
DB_HOST = 'localhost'
DB_USER = 'root'
DB_PASS = ''
DB_NAME = 'qlbh_xe'
```

## Hằng số Vai trò (Roles)

```php
ROLE_CUSTOMER_STAFF = 'CustomerStaff'      // Quản lý khách hàng
ROLE_VEHICLE_STAFF = 'VehicleStaff'        // Quản lý phương tiện
ROLE_CLAIMS_STAFF = 'ClaimsStaff'          // Xử lý yêu cầu bồi thường
ROLE_ACCOUNTING_STAFF = 'AccountingStaff'  // Xử lý tài chính
```

## Quy tắc Kiểm chứng

### Khách hàng

- HoTen bắt buộc
- CCCD không trùng lặp
- Email hợp lệ (tùy chọn)

### Phương tiện

- MaXe, BienSo bắt buộc
- BienSo, SoKhung, SoMay không trùng lặp
- Không xóa nếu có hợp đồng

### Yêu cầu Bồi thường

- MaHD, NgayYeuCau, NgaySuCo bắt buộc
- Chỉ create() từ hợp đồng hoạt động
- Quy trình: Chờ duyệt → Thẩm định → Duyệt/Từ chối

### Phiếu Thu/Chi

- MaHD/MaYC bắt buộc
- Ngày và số tiền bắt buộc
- Phiếu chi chỉ cho yêu cầu TrangThai='Đã duyệt'

## Cách sử dụng

### 1. Cấu hình Cơ sở Dữ liệu

```sql
-- Nhập file SQL từ FProjects/2/qlbh_xe.sql
mysql -u root < qlbh_xe.sql
```

### 2. Truy cập Ứng dụng

```
http://localhost/FProjects/5/public/index.php
```

### 3. Ví dụ URL

```
http://localhost/FProjects/5/public/index.php?c=Customer&m=index
http://localhost/FProjects/5/public/index.php?c=Vehicle&m=create
http://localhost/FProjects/5/public/index.php?c=Claims&m=view&id=YC001
http://localhost/FProjects/5/public/index.php?c=Accounting&m=reports
```

## Các File Được Tạo Tổng Cộng

- **Core**: 5 file (Database, Logger, Model, Controller, config)
- **Models**: 6 file (Khachhang, Xe, Hopdong, YeuCau, PhieuThu, PhieuChi)
- **Controllers**: 4 file (Customer, Vehicle, Claims, Accounting)
- **Views**: 25 file (4+4+6+11)
- **Entry Point**: 1 file (index.php)

**Tổng cộng: 41 file PHP/HTML**

## Tiêu chí Hoàn thành

✅ Kiến trúc OOP nhẹ với Base Model
✅ 4 mô-đun đầy đủ (Customer, Claims, Vehicle, Accounting)
✅ CRUD hoàn toàn cho tất cả mô-đun
✅ Xóa mềm và tự động logging
✅ PDO + prepared statements
✅ Bảo vệ toàn vẹn dữ liệu
✅ Giao diện HTML/CSS được bảo toàn
✅ Router động
✅ Kiểm chứng dữ liệu
✅ Quy trình công việc (workflow)

---

**Ngày hoàn thành**: 2024
**Trạng thái**: HOÀN THÀNH
