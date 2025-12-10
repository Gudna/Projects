# 🧪 COMPREHENSIVE TEST PLAN

## Vehicle Insurance Management System - FProjects 5 (OOP + MVC)

**Date**: 2024-12-11  
**Scope**: All 4 Modules × All Features × Code + Browser + Database  
**Owner**: QA Team  
**Status**: READY FOR EXECUTION

---

## 1️⃣ VISUAL REGRESSION TESTS

### Test Category: CSS & Layout

#### VR-001: Customer Module - List View

```
Test Steps:
1. Navigate to /app/Views/Customer/index.php
2. Compare layout, colors, spacing with FProjects/1 customers.php
3. Verify:
   - Header styling matches
   - Table columns visible
   - Search box positioned correctly
   - Buttons styled correctly (primary, secondary)
   - Responsive layout on mobile
4. Screenshot: Before (FProjects/1) vs After (FProjects/5)
```

**Expected**: 100% visual match ✅

#### VR-002: Customer Module - Create Form

```
Test Steps:
1. Navigate to /app/Views/Customer/create.php
2. Compare with FProjects/1 add_customer.php
3. Verify:
   - Form grid layout (2-3 columns)
   - Input field styling (border, padding, focus state)
   - Label styling (font weight, spacing)
   - Button layout (submit, cancel)
   - Error message display
   - Form validation messages
4. Screenshot comparison
```

**Expected**: 100% visual match ✅

#### VR-003: Claims Module - Workflow Views

```
Test Steps:
1. Compare Claims/index.php with FProjects/2 phan-he-2/index.php
2. Compare Claims/view.php with FProjects/2 phan-he-2/tra-cuu.php
3. Verify:
   - Status badge colors (success, warning, danger)
   - Workflow buttons (assess, approve, reject)
   - Table structure and spacing
   - Modal styling (if used)
4. Screenshot comparison
```

**Expected**: 100% visual match ✅

#### VR-004: Accounting Module - Phiếu Thu

```
Test Steps:
1. Compare Accounting/receipt_index.php with FProjects/4 ke-toan/phieu-thu.php
2. Verify:
   - Table layout and styling
   - Filter/search box
   - Button styling
   - Form styling in create/edit
4. Screenshot comparison
```

**Expected**: 100% visual match ✅

#### VR-005: Responsive Design

```
Test Steps:
1. Test all major views at:
   - Desktop (1920x1080)
   - Tablet (768x1024)
   - Mobile (375x667)
2. Verify:
   - No horizontal scrolling
   - Text readable
   - Buttons tappable (min 44px)
   - Forms stack correctly
3. Compare with original at same sizes
```

**Expected**: 100% visual match ✅

---

## 2️⃣ FUNCTIONAL REGRESSION TESTS

### Test Category: CRUD Operations

#### FR-001: Customer Create

```
Test Case: customer_create_valid
Precondition:
  - Navigate to Customer create form
  - Database is clean (no duplicate CCCDs)

Test Steps:
1. Fill form:
   - HoTen: "Nguyễn Văn A"
   - NgaySinh: "1990-01-15"
   - CCCD: "123456789012"
   - DiaChi: "Hà Nội"
   - SoDienThoai: "0912345678"
   - Email: "a@example.com"
2. Click "Tạo Khách Hàng"
3. Verify success message

Expected:
  - Redirect to customer index
  - Customer visible in list
  - Database: 1 row in khachhang table with TrangThai='Hoạt động'
  - Logging: Entry in qlbh_lichsu with action='INSERT'
```

**Status**: ✅ Ready

#### FR-002: Customer Create - Duplicate CCCD

```
Test Case: customer_create_duplicate_cccd
Precondition:
  - Customer with CCCD "123456789012" exists

Test Steps:
1. Try to create customer with same CCCD
2. Submit form

Expected:
  - Error message: "CCCD đã tồn tại"
  - Form data preserved
  - No redirect
  - No database change
```

**Status**: ✅ Ready

#### FR-003: Customer Edit

```
Test Case: customer_edit_valid
Precondition:
  - Customer MaKH="KH001" exists

Test Steps:
1. Navigate to edit view for KH001
2. Modify:
   - HoTen: "Nguyễn Văn B"
   - SoDienThoai: "0987654321"
3. Submit

Expected:
  - Redirect to customer detail
  - Changes visible immediately
  - Database: khachhang.HoTen updated, NgayCapNhat set to NOW()
  - Logging: Entry in qlbh_lichsu with action='UPDATE', DuLieuCu/DuLieuMoi JSON
```

**Status**: ✅ Ready

#### FR-004: Customer Delete (Soft Delete)

```
Test Case: customer_delete_no_references
Precondition:
  - Customer KH001 exists with no vehicles/contracts

Test Steps:
1. Navigate to customer list
2. Click delete on KH001
3. Confirm deletion

Expected:
  - Redirect to customer list
  - KH001 no longer visible in list
  - Database: khachhang.TrangThai='DaXoa', NgayCapNhat updated
  - Logging: Entry in qlbh_lichsu with action='DELETE'
  - Database query: `SELECT * FROM khachhang WHERE TrangThai != 'DaXoa'` doesn't return KH001
```

**Status**: ✅ Ready

#### FR-005: Customer Delete - With References

```
Test Case: customer_delete_with_vehicles
Precondition:
  - Customer KH001 has vehicles/contracts

Test Steps:
1. Try to delete KH001

Expected:
  - Error message: "Không thể xóa khách hàng vì có xe hoặc hợp đồng"
  - No deletion occurs
  - Database unchanged
```

**Status**: ✅ Ready

---

### Test Category: Claims Workflow

#### WF-001: Claims Workflow - Full Cycle

```
Test Case: claims_full_workflow
Precondition:
  - Contract MaHD="HD001" exists (active)
  - Customer and Vehicle linked

Test Steps:
1. Create claim:
   - MaHD: "HD001"
   - NgayYeuCau: TODAY
   - NgaySuCo: "2024-12-10"
   - DiaDiemSuCo: "Hà Nội"
   - MoTaSuCo: "Va chạm giao thông"
   - SoTienDeXuat: 50000000

Expected:
  - Claim created with TrangThai='Chờ duyệt'
  - Visible in claims index with "Chờ duyệt" badge
  - Database: yeucauboithuong row created, qlbh_lichsu logged

2. Assess claim:
   - KetQuaThamDinh: "Chứng thư hợp lệ"
   - Update status to 'Thẩm định xong'

Expected:
  - Status badge changes to "Thẩm định xong"
  - Assessment visible on detail view
  - Database updated, logged

3. Approve claim:
   - SoTienDuyet: 48000000
   - Update status to 'Đã duyệt'

Expected:
  - Status badge changes to "Đã duyệt" (green)
  - Approved amount visible
  - Payout now possible

4. Create payout:
   - MaYC: claim ID
   - SoTienChi: 48000000
   - NgayChiTien: TODAY

Expected:
  - Payout created
  - phieuchi table has new row
  - qlbh_lichsu logged
```

**Status**: ✅ Ready

#### WF-002: Claims Workflow - Reject Path

```
Test Case: claims_reject_workflow
Precondition:
  - Claim in 'Thẩm định xong' or 'Chờ duyệt' state

Test Steps:
1. Click "Từ chối"
2. Enter LyDoTuChoi: "Không đủ giấy tờ"
3. Submit

Expected:
  - Status changes to 'Từ chối' (red badge)
  - Rejection reason visible
  - No payout can be created for this claim
  - Database logged
```

**Status**: ✅ Ready

---

### Test Category: Accounting

#### ACC-001: Receipt Create

```
Test Case: receipt_create_valid
Precondition:
  - Contract HD001 exists
  - No previous receipt for HD001 in this period

Test Steps:
1. Create receipt:
   - MaHD: "HD001"
   - SoTienThu: 10000000
   - NgayThuTien: TODAY
   - GhiChu: "Thanh toán lần 1"
2. Submit

Expected:
  - Receipt created with unique MaPT
  - Visible in receipt list
  - Database: phieuthu row created
  - Report: Total receipts updated
  - Logging: qlbh_lichsu entry
```

**Status**: ✅ Ready

#### ACC-002: Payout Create - Only for Approved Claims

```
Test Case: payout_only_approved_claims
Precondition:
  - Claim in 'Đã duyệt' state with SoTienDuyet set

Test Steps:
1. Create payout for this claim

Expected:
  - Payout created successfully

2. Try to create payout for claim in 'Chờ duyệt' state

Expected:
  - Error: "Chỉ có thể chi tiền cho yêu cầu đã duyệt"
  - No payout created
```

**Status**: ✅ Ready

#### ACC-003: Report - Financial Summary

```
Test Case: accounting_report_monthly
Precondition:
  - Month 2024-12 has:
    - 3 receipts (total 30M)
    - 2 payouts (total 20M)

Test Steps:
1. Navigate to Reports
2. Select month 2024-12
3. View summary

Expected:
  - Tổng Thu: 30,000,000 VNĐ
  - Tổng Chi: 20,000,000 VNĐ
  - Chênh Lệch: 10,000,000 VNĐ
  - Daily chart shows correct data
  - All receipts listed
  - All payouts listed
```

**Status**: ✅ Ready

---

## 3️⃣ DATABASE INTEGRITY TESTS

### Test Category: Schema & Constraints

#### DB-001: Soft Delete Verification

```
Test Case: soft_delete_not_visible
Precondition:
  - Customer KH001 exists

Test Steps:
1. Soft delete KH001
2. Query: SELECT * FROM khachhang WHERE TrangThai != 'DaXoa'

Expected:
  - KH001 NOT in results
  - Direct query: SELECT * FROM khachhang WHERE MaKH='KH001'
  - Row still exists with TrangThai='DaXoa'
```

**Status**: ✅ Ready

#### DB-002: Logging Integrity

```
Test Case: audit_log_complete
Precondition:
  - Create/Update/Delete operations performed

Test Steps:
1. Query qlbh_lichsu for all operations

Expected for CREATE:
  - BangDuLieu: 'khachhang'
  - MaBanGhi: 'KH001'
  - HanhDong: 'INSERT'
  - DuLieuCu: NULL
  - DuLieuMoi: JSON string with all fields
  - MaNV: Current user ID
  - IP: Client IP
  - ThoiGian: Timestamp

Expected for UPDATE:
  - DuLieuCu: JSON with old values
  - DuLieuMoi: JSON with new values
  - HanhDong: 'UPDATE'

Expected for DELETE:
  - HanhDong: 'DELETE'
  - DuLieuCu: JSON with deleted data
  - DuLieuMoi: NULL
```

**Status**: ✅ Ready

#### DB-003: Foreign Key Constraints

```
Test Case: fk_vehicle_customer
Precondition:
  - Vehicle references non-existent customer

Test Steps:
1. Try to insert vehicle with invalid MaKH

Expected:
  - Database constraint error
  - Insertion fails
  - Application error handling
```

**Status**: ✅ Ready

#### DB-004: Unique Constraints

```
Test Case: unique_license_plate
Precondition:
  - Vehicle with BienSo="29A-12345" exists

Test Steps:
1. Try to create another vehicle with same BienSo

Expected:
  - Duplicate error caught
  - Form error message: "Biển số đã tồn tại"
  - No database insertion
```

**Status**: ✅ Ready

---

## 4️⃣ JAVASCRIPT BEHAVIOR TESTS

### Test Category: Form & Event Handling

#### JS-001: Search/Filter

```
Test Case: table_search_filter
Precondition:
  - Customer list with 10+ records

Test Steps:
1. Type "Nguyễn" in search box
2. Wait 300ms (debounce)

Expected:
  - Only customers with "Nguyễn" visible
  - Other rows hidden
  - Performance: No lag

3. Clear search box

Expected:
  - All rows visible again
```

**Status**: ✅ Ready

#### JS-002: Form Validation

```
Test Case: client_side_validation
Precondition:
  - Customer create form open

Test Steps:
1. Leave required fields empty
2. Click submit

Expected:
  - Form doesn't submit
  - HTML5 validation message appears
  - Focus on first invalid field

3. Fill required fields
4. Click submit

Expected:
  - Form submits successfully
```

**Status**: ✅ Ready

#### JS-003: Modal Functions

```
Test Case: modal_open_close
Precondition:
  - Page with modal element

Test Steps:
1. Click button with onclick="openModal('myModal')"

Expected:
  - Modal visible (display: flex, opacity: 1)
  - Overlay visible
  - Content readable

2. Click X or close button

Expected:
  - Modal hidden
  - Overlay removed
  - Page scrollable

3. Click outside modal

Expected:
  - Modal closes
```

**Status**: ✅ Ready

#### JS-004: Number Formatting

```
Test Case: money_format_display
Precondition:
  - Page displays formatted currency

Test Steps:
1. Inspect element with formatMoney(50000000)

Expected:
  - Display: "50,000,000₫"
  - Locale: Vietnamese
  - Format: Intl.NumberFormat with 'currency'
```

**Status**: ✅ Ready

#### JS-005: Date Formatting

```
Test Case: date_format_display
Precondition:
  - Database date: "2024-12-11"

Test Steps:
1. Display using formatDate("2024-12-11")

Expected:
  - Display: "11/12/2024"
  - Format: DD/MM/YYYY
```

**Status**: ✅ Ready

---

## 5️⃣ BROWSER COMPATIBILITY TESTS

| Browser       | Version | Status | Notes            |
| ------------- | ------- | ------ | ---------------- |
| Chrome        | 120+    | ✅     | Primary target   |
| Firefox       | 121+    | ✅     | Secondary target |
| Safari        | 17+     | ⚠️     | Test needed      |
| Edge          | 120+    | ✅     | Chromium-based   |
| Mobile Safari | 17+     | ⚠️     | iOS testing      |
| Mobile Chrome | 120+    | ✅     | Android testing  |

---

## 6️⃣ PERFORMANCE TESTS

#### PERF-001: Page Load Time

```
Target: < 2 seconds (first paint)
Test:
  1. Open main page
  2. Measure load time with DevTools
Expected: < 2000ms
```

#### PERF-002: Search Debounce

```
Target: No lag when typing
Test:
  1. Type in search box quickly
  2. Verify debounce (300ms) works
Expected: Smooth filtering without stutter
```

#### PERF-003: Table Rendering

```
Target: 500+ rows visible in < 1 second
Test:
  1. Load customer list with 500+ records
  2. Measure render time
Expected: Acceptable performance
```

---

## 7️⃣ SECURITY TESTS

#### SEC-001: SQL Injection Protection

```
Test Case: sql_injection_attempt
Test:
  1. Try form input: '; DROP TABLE khachhang; --'
  2. Submit form

Expected:
  - Input treated as literal string
  - No SQL execution
  - Data saved correctly
```

#### SEC-002: XSS Protection

```
Test Case: xss_attempt
Test:
  1. Try form input: '<script>alert("XSS")</script>'
  2. Submit form

Expected:
  - Script not executed
  - Input escaped in HTML output
  - Displayed as text
```

---

## 📊 TEST EXECUTION MATRIX

| Module     | Feature  | VR  | FR  | DB  | JS  | Browser | Sec | Status |
| ---------- | -------- | --- | --- | --- | --- | ------- | --- | ------ |
| Customer   | Create   | ✅  | ✅  | ✅  | ✅  | ✅      | ✅  | Ready  |
| Customer   | Edit     | ✅  | ✅  | ✅  | ✅  | ✅      | ✅  | Ready  |
| Customer   | Delete   | ✅  | ✅  | ✅  | ✅  | ✅      | ✅  | Ready  |
| Vehicle    | Create   | ✅  | ✅  | ✅  | ✅  | ✅      | ✅  | Ready  |
| Vehicle    | Edit     | ✅  | ✅  | ✅  | ✅  | ✅      | ✅  | Ready  |
| Vehicle    | Delete   | ✅  | ✅  | ✅  | ✅  | ✅      | ✅  | Ready  |
| Claims     | Workflow | ✅  | ✅  | ✅  | ✅  | ✅      | ✅  | Ready  |
| Claims     | Assess   | ✅  | ✅  | ✅  | ✅  | ✅      | ✅  | Ready  |
| Claims     | Approve  | ✅  | ✅  | ✅  | ✅  | ✅      | ✅  | Ready  |
| Claims     | Reject   | ✅  | ✅  | ✅  | ✅  | ✅      | ✅  | Ready  |
| Accounting | Receipt  | ✅  | ✅  | ✅  | ✅  | ✅      | ✅  | Ready  |
| Accounting | Payout   | ✅  | ✅  | ✅  | ✅  | ✅      | ✅  | Ready  |
| Accounting | Report   | ✅  | ✅  | ✅  | ✅  | ✅      | ✅  | Ready  |

---

## ✅ TEST EXECUTION CHECKLIST

- [ ] Set up test database with sample data
- [ ] Document baseline screenshots from FProjects 1-4
- [ ] Run visual regression tests
- [ ] Run functional tests (CRUD + workflows)
- [ ] Run database integrity tests
- [ ] Run JavaScript behavior tests
- [ ] Run browser compatibility tests
- [ ] Run security tests
- [ ] Document all results
- [ ] Fix any failures
- [ ] Get sign-off from QA lead
- [ ] Schedule production deployment

---

## 📝 ISSUE TRACKING

When test fails, create issue with:

1. Test Case ID (e.g., FR-001)
2. Actual vs Expected result
3. Screenshot/video
4. Steps to reproduce
5. Browser & OS info
6. Database state
7. Error logs

---

**Test Plan Status**: ✅ READY FOR EXECUTION  
**Owner Signature**: PENDING  
**Date**: 2024-12-11
