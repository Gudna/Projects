# 📋 INPUT NAME MAPPING DOCUMENT

## Form Field Names: Original → OOP Model

**Purpose**: Ensure form submissions from original UI work correctly with OOP controller

---

## MODULE-1: CUSTOMER (Khách hàng)

### Customer Create/Edit Form

| Original Name (Form) | OOP Model Field | Type  | Validation          | Notes                           |
| -------------------- | --------------- | ----- | ------------------- | ------------------------------- |
| `customer_code`      | `MaKH`          | TEXT  | NOT NULL, UNIQUE    | Auto-generated if empty         |
| `full_name`          | `HoTen`         | TEXT  | NOT NULL, MAX 200   | Required field                  |
| `date_of_birth`      | `NgaySinh`      | DATE  | -                   | ISO format YYYY-MM-DD           |
| `id_card`            | `CCCD`          | TEXT  | UNIQUE, MAX 50      | ID Card / CCCD number           |
| `phone`              | `SoDienThoai`   | TEXT  | MAX 20              | Phone number format             |
| `email`              | `Email`         | EMAIL | -                   | Valid email or empty            |
| `occupation`         | `NgheNghiep`    | TEXT  | -                   | Optional                        |
| `insurance_type`     | `MaGoi`         | TEXT  | -                   | Package code (FK to goibaohiem) |
| `address`            | `DiaChi`        | TEXT  | -                   | Address                         |
| `status`             | `TrangThai`     | ENUM  | DEFAULT 'Hoat dong' | Auto-set on create              |

**Form Alias Solution**:

```html
<!-- Original form field names are kept -->
<input name="customer_code" id="customer_code" />
<input name="full_name" id="full_name" />
<input name="date_of_birth" id="date_of_birth" />
<!-- ... -->

<!-- Hidden alias fields for OOP model (if needed) -->
<input type="hidden" name="MaKH" id="MaKH" />
<input type="hidden" name="HoTen" id="HoTen" />
```

**Controller Handler**:

```php
// In CustomerController::create()
$postData = [
    'customer_code' => $this->post('customer_code') ?? $this->post('MaKH'),
    'full_name' => $this->post('full_name') ?? $this->post('HoTen'),
    'date_of_birth' => $this->post('date_of_birth') ?? $this->post('NgaySinh'),
    'id_card' => $this->post('id_card') ?? $this->post('CCCD'),
    'phone' => $this->post('phone') ?? $this->post('SoDienThoai'),
    'email' => $this->post('email') ?? $this->post('Email'),
    'occupation' => $this->post('occupation') ?? $this->post('NgheNghiep'),
    'insurance_type' => $this->post('insurance_type') ?? $this->post('MaGoi'),
    'address' => $this->post('address') ?? $this->post('DiaChi'),
];

$this->khachhang->create($postData, $this->userId);
```

---

## MODULE-2: CLAIMS (Yêu cầu bồi thường)

### Claim Create Form

| Original Name     | OOP Model Field | Type     | Validation    | Notes                |
| ----------------- | --------------- | -------- | ------------- | -------------------- |
| `ma_hd`           | `MaHD`          | TEXT     | NOT NULL      | Contract ID (FK)     |
| `ngay_yeu_cau`    | `NgayYeuCau`    | DATE     | DEFAULT TODAY | Request date         |
| `ngay_su_co`      | `NgaySuCo`      | DATE     | NOT NULL      | Incident date        |
| `dia_diem_su_co`  | `DiaDiemSuCo`   | TEXT     | -             | Incident location    |
| `mo_ta_su_co`     | `MoTaSuCo`      | LONGTEXT | -             | Incident description |
| `so_tien_de_xuat` | `SoTienDeXuat`  | DECIMAL  | > 0           | Proposed amount      |

### Claim Assess Form

| Original Name       | OOP Model Field  | Type     | Validation           | Notes                |
| ------------------- | ---------------- | -------- | -------------------- | -------------------- |
| `ma_yc`             | `MaYC`           | TEXT     | PK                   | Claim ID (read-only) |
| `ket_qua_tham_dinh` | `KetQuaThamDinh` | LONGTEXT | NOT NULL             | Assessment result    |
| `trang_thai`        | `TrangThai`      | ENUM     | SET 'Thẩm định xong' | Status update        |

### Claim Approve Form

| Original Name   | OOP Model Field | Type    | Validation     | Notes                |
| --------------- | --------------- | ------- | -------------- | -------------------- |
| `ma_yc`         | `MaYC`          | TEXT    | PK             | Claim ID (read-only) |
| `so_tien_duyet` | `SoTienDuyet`   | DECIMAL | > 0            | Approved amount      |
| `trang_thai`    | `TrangThai`     | ENUM    | SET 'Đã duyệt' | Status update        |

### Claim Reject Form

| Original Name   | OOP Model Field | Type     | Validation    | Notes                |
| --------------- | --------------- | -------- | ------------- | -------------------- |
| `ma_yc`         | `MaYC`          | TEXT     | PK            | Claim ID (read-only) |
| `ly_do_tu_choi` | `LyDoTuChoi`    | LONGTEXT | NOT NULL      | Rejection reason     |
| `trang_thai`    | `TrangThai`     | ENUM     | SET 'Từ chối' | Status update        |

---

## MODULE-3: VEHICLE (Phương tiện)

### Vehicle Create/Edit Form

| Original Name  | OOP Model Field | Type | Validation          | Notes                              |
| -------------- | --------------- | ---- | ------------------- | ---------------------------------- |
| `ma_xe`        | `MaXe`          | TEXT | PK, UNIQUE          | Vehicle ID                         |
| `ma_kh`        | `MaKH`          | TEXT | NOT NULL, FK        | Customer ID                        |
| `bien_so`      | `BienSo`        | TEXT | UNIQUE, NOT NULL    | License plate                      |
| `hang_xe`      | `HangXe`        | TEXT | -                   | Brand                              |
| `dong_xe`      | `DongXe`        | TEXT | -                   | Model                              |
| `nam_san_xuat` | `NamSanXuat`    | INT  | -                   | Year of manufacture                |
| `mau_sac`      | `MauSac`        | TEXT | -                   | Color                              |
| `so_khung`     | `SoKhung`       | TEXT | UNIQUE, NOT NULL    | Chassis number (read-only in edit) |
| `so_may`       | `SoMay`         | TEXT | UNIQUE, NOT NULL    | Engine number (read-only in edit)  |
| `status`       | `TrangThai`     | ENUM | DEFAULT 'Hoat dong' | Auto-set on create                 |

**Special Rules**:

- SoKhung and SoMay are read-only in edit form (cannot be changed)
- BienSo, SoKhung, SoMay must be unique
- Cannot delete vehicle if it has active contracts

---

## MODULE-4: ACCOUNTING (Kế toán)

### Phiếu Thu (Receipt) Create/Edit Form

| Original Name     | OOP Model Field | Type    | Validation           | Notes                  |
| ----------------- | --------------- | ------- | -------------------- | ---------------------- |
| `ma_hd`           | `MaHD`          | TEXT    | NOT NULL, FK         | Contract ID            |
| `so_tien`         | `SoTienThu`     | DECIMAL | > 0, NOT NULL        | Receipt amount         |
| `ngay_gd`         | `NgayThuTien`   | DATE    | NOT NULL             | Receipt date           |
| `ghi_chu`         | `GhiChu`        | TEXT    | -                    | Notes                  |
| `action`          | -               | HIDDEN  | create\|edit\|delete | Form action            |
| `ma_pt` / `ma_gd` | `MaPT`          | TEXT    | PK (edit only)       | Receipt ID (read-only) |

### Phiếu Chi (Payout) Create/Edit Form

| Original Name | OOP Model Field | Type    | Validation           | Notes                         |
| ------------- | --------------- | ------- | -------------------- | ----------------------------- |
| `ma_yc`       | `MaYC`          | TEXT    | NOT NULL, FK         | Claim ID                      |
| `noi_dung`    | `NoiDung`       | TEXT    | -                    | Content/Description           |
| `so_tien`     | `SoTienChi`     | DECIMAL | > 0, NOT NULL        | Payout amount                 |
| `ngay_chi`    | `NgayChiTien`   | DATE    | NOT NULL             | Payout date                   |
| `ghi_chu`     | `GhiChu`        | TEXT    | -                    | Notes                         |
| `action`      | -               | HIDDEN  | create\|edit\|delete | Form action                   |
| `ma_pc`       | `MaPC`          | TEXT    | PK (edit only)       | Payout ID (read-only)         |
| `loai_chi`    | -               | SELECT  | -                    | Payout type (optional filter) |

**Special Rules**:

- Phiếu Chi can only be created for claims with `TrangThai='Đã duyệt'`
- Cannot delete receipts/payouts (soft-delete only)
- Amount must be > 0

---

## IMPLEMENTATION STRATEGY

### Option A: Form Field Translator Middleware

```php
// In Controller base class or central middleware
protected function translateFormFields($postData, $mapping) {
    $result = [];
    foreach ($mapping as $original => $model) {
        if (isset($postData[$original])) {
            $result[$model] = $postData[$original];
        }
    }
    return $result;
}

// Usage in controller
$mapping = [
    'customer_code' => 'MaKH',
    'full_name' => 'HoTen',
    'date_of_birth' => 'NgaySinh',
    // ... etc
];
$modelData = $this->translateFormFields($this->postAll(), $mapping);
```

### Option B: Keep Original Names in Forms

```php
// Forms use original names (backward compatible)
// Controllers accept BOTH original and model field names
$maKH = $this->post('customer_code') ?? $this->post('MaKH');
$hoTen = $this->post('full_name') ?? $this->post('HoTen');
// ... etc
```

### Option C: Hidden Alias Fields

```html
<!-- Original visible field -->
<input type="text" name="customer_code" id="customer_code" />

<!-- Hidden alias field (auto-populated by JS) -->
<input type="hidden" name="MaKH" id="MaKH" />

<!-- JavaScript sync -->
<script>
  document
    .getElementById("customer_code")
    .addEventListener("change", function () {
      document.getElementById("MaKH").value = this.value;
    });
</script>
```

---

## RECOMMENDATIONS

✅ **Use Option B (Accept Both Names)**

- Simplest implementation
- Fully backward compatible
- No JavaScript needed
- Controllers check both names: `$this->post('original') ?? $this->post('model')`

✅ **Validate & Sanitize Both Names**

```php
protected function getPostField($original, $model) {
    return $this->post($original) ?? $this->post($model);
}
```

✅ **Document in Each View**

```html
<!-- 
  Form uses original field names for backward compatibility
  Controller accepts both original and model field names
  Mapping: customer_code → MaKH, full_name → HoTen, etc.
-->
```

---

## TESTING CHECKLIST

- [ ] Test form submission with original field names
- [ ] Test form submission with model field names
- [ ] Verify data saves to correct database columns
- [ ] Test validation works for both name sets
- [ ] Test error messages display correctly
- [ ] Test redirect/success flow
- [ ] Test database logging captures correct data

---

## SIGN-OFF

**Created By**: Audit Team  
**Date**: 2024-12-11  
**Status**: ✅ READY FOR IMPLEMENTATION  
**Owner Approval**: PENDING
