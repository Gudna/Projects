# 🔐 Tài Khoản Hệ Thống Quản Lý Bảo Hiểm Xe

## 📋 Tài Khoản Đăng Nhập

### 1. **Admin (Quản Trị Viên)**

```
Username: admin
Password: 123456
Role: admin
Password Hash: $2y$10$AFEB1njwte0dkYVzv4/c3OGVr4YCtFe9MqmLI52urXBe2TLLEe1.i
```

### 2. **Quản Lý Khách Hàng (Customer Staff)**

```
Username: staff_kh
Password: 123456
Role: customer_staff
Password Hash: $2y$10$0sDMk0e653hFTFK2pYCdLe6trPOO8Oxaa0BVsHY2ZyLX7LmjR6my2
```

### 3. **Quản Lý Yêu Cầu/Tuyên Bố Bảo Hiểm (Claims Staff)**

```
Username: staff_yc
Password: 123456
Role: claims_staff
Password Hash: $2y$10$9/uCf5OKneZCmfHscQRG4eUKJmjChu/5l64Gi0SzYg/fW/oUcA8eO
```

### 4. **Quản Lý Kế Toán (Accounting Staff)**

```
Username: staff_kt
Password: 123456
Role: accounting_staff
Password Hash: $2y$10$rguP2Oa0yr.pLE6kR1JZ5OO/ZPc.ST7kMWnkZ4.PjtswJyabtl7aK
```

---

## 🔗 Link Truy Cập

### Trang Đăng Nhập:

```
http://localhost/Projects_/mvc/public/index.php?c=Auth&m=login
```

### Danh Sách Khách Hàng (sau đăng nhập):

```
http://localhost/Projects_/mvc/public/index.php?c=Customer&m=list
```

---

## 📊 Dữ Liệu Test

### Khách Hàng:

| ID    | Tên          | CCCD         | Điện thoại | Email       |
| ----- | ------------ | ------------ | ---------- | ----------- |
| KH001 | Nguyễn Văn A | 123456789012 | 0901234567 | a@email.com |
| KH002 | Trần Thị B   | 234567890123 | 0912345678 | b@email.com |
| KH003 | Phạm Văn C   | 345678901234 | 0923456789 | c@email.com |

### Xe:

| ID    | Biển Số   | Brand  | Năm  | Chủ Sở Hữu |
| ----- | --------- | ------ | ---- | ---------- |
| XE001 | 59A-12345 | Toyota | 2020 | KH001      |
| XE002 | 59B-67890 | Honda  | 2021 | KH001      |
| XE003 | 30C-11111 | BMW    | 2022 | KH002      |

### Hợp Đồng:

| ID    | Khách Hàng | Xe    | Từ Ngày    | Đến Ngày   | Phí Bảo Hiểm  |
| ----- | ---------- | ----- | ---------- | ---------- | ------------- |
| HD001 | KH001      | XE001 | 2023-01-01 | 2024-12-31 | 5,000,000 VND |
| HD002 | KH001      | XE002 | 2023-06-01 | 2025-05-31 | 6,000,000 VND |
| HD003 | KH002      | XE003 | 2023-03-01 | 2024-02-29 | 7,000,000 VND |

---

## 🛠️ SQL Hashes (đã được cập nhật vào database)

Mỗi tài khoản sử dụng `bcrypt` hashing (password_hash với cost=10 trong PHP):

```sql
-- Admin
UPDATE qlbh_taikhoan
SET MatKhau = '$2y$10$AFEB1njwte0dkYVzv4/c3OGVr4YCtFe9MqmLI52urXBe2TLLEe1.i'
WHERE TenTK = 'admin';

-- Customer Staff
UPDATE qlbh_taikhoan
SET MatKhau = '$2y$10$0sDMk0e653hFTFK2pYCdLe6trPOO8Oxaa0BVsHY2ZyLX7LmjR6my2'
WHERE TenTK = 'staff_kh';

-- Claims Staff
UPDATE qlbh_taikhoan
SET MatKhau = '$2y$10$9/uCf5OKneZCmfHscQRG4eUKJmjChu/5l64Gi0SzYg/fW/oUcA8eO'
WHERE TenTK = 'staff_yc';

-- Accounting Staff
UPDATE qlbh_taikhoan
SET MatKhau = '$2y$10$rguP2Oa0yr.pLE6kR1JZ5OO/ZPc.ST7kMWnkZ4.PjtswJyabtl7aK'
WHERE TenTK = 'staff_kt';
```

---

## ✅ Trạng Thái Module

| Module | Phân Hệ               | Trạng Thái  |
| ------ | --------------------- | ----------- |
| 0A     | Base Scaffold         | ✅ Complete |
| 0B     | Database Schema       | ✅ Complete |
| 0C     | Auth, Layout, Logging | ✅ Complete |
| 1A     | Customer Model        | ✅ Complete |
| 1B     | Customer Controller   | ✅ Complete |
| 1C     | Customer Views        | ✅ Complete |

---

**Lần cập nhật lần cuối**: 11/12/2025
