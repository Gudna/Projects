# 📋 AUDIT REPORT - VEHICLE INSURANCE MANAGEMENT SYSTEM

## Toàn Hệ Thống 4 Phân Hệ (FProjects 1,2,3,4) → FProjects 5 (OOP + MVC)

**Ngày Audit**: 2024-12-11  
**Scope**: Toàn bộ 4 mô-đun (Customer, Vehicle, Claims, Accounting)  
**Target**: FProjects/5 (OOP + Base Model)

---

## 1. 🔍 AUDIT FILE GỐC

### A. FProjects/1 (Insurance Management - English)

| Thành phần        | Chi tiết                                                                                           |
| ----------------- | -------------------------------------------------------------------------------------------------- |
| **Purpose**       | Quản lý bảo hiểm khách hàng (Customer, Contract, Dashboard)                                        |
| **Architecture**  | Procedural PHP + PDO + HTML/CSS/JS                                                                 |
| **Key Files**     | `add_customer.php`, `customers.php`, `contracts.php`, `dashboard.php`                              |
| **CSS**           | `/css/style.css` (1131 lines) - Gradient theme (#2c3e50)                                           |
| **JS**            | `/js/script.js` (263 lines) - Tooltips, validation, search, date picker                            |
| **Database**      | `/sql/database.sql` - Tables: customers, contracts, etc.                                           |
| **Forms**         | Customer form: input name="full_name", "id_card", "phone", "email", "occupation", "insurance_type" |
| **Header/Footer** | `/includes/header.php`, `/includes/footer.php`                                                     |

**Key HTML/CSS/JS Patterns**:

- Form grid layout: `class="form-grid"` + `class="form-group"`
- Button styles: `class="btn btn-primary"`, `class="btn btn-secondary"`
- Alert: `class="alert alert-error"`, `class="alert alert-success"`
- Tooltip: `title` attribute + custom-tooltip DIV
- Search: `initSearch()` function
- Date picker: `initDatePickers()` function

---

### B. FProjects/2 (Phân hệ 2 - Claims/Phiếu yêu cầu bồi thường)

| Thành phần       | Chi tiết                                                                                      |
| ---------------- | --------------------------------------------------------------------------------------------- |
| **Purpose**      | Xử lý yêu cầu bồi thường (tiếp nhận, thẩm định, phê duyệt)                                    |
| **Architecture** | OOP (Classes, Namespaces) + PDO + MVC pattern                                                 |
| **Key Files**    | `/phan-he-2/tiep-nhan.php`, `tham-dinh.php`, `phe-duyet.php`, `bao-cao.php`                   |
| **CSS**          | `/tai-nguyen/css/style.css` (1166 lines) - Gradient Purple/Blue (#667eea)                     |
| **JS**           | `/tai-nguyen/js/main.js` (101 lines) - formatMoney, formatDate, modal, confirmDelete          |
| **Key Classes**  | `UngDung\DichVu\*`, `UngDung\KhoDuLieu\*`                                                     |
| **Database**     | `/qlbh_xe.sql` - Tables: khachhang, xeoto, hopdong, yeucauboithuong, phieuthu, phieuchi, etc. |
| **Roles**        | ClaimsStaff, VehicleStaff, CustomerStaff, AccountingStaff                                     |

**Key HTML/CSS/JS Patterns**:

- CSS Variables: `--primary: #667eea`, `--success: #10b981`, `--danger: #ef4444`
- Sidebar: `class="sidebar"`, `class="sidebar-header"`, `class="nav-menu"`
- Form: Same grid layout as FProjects/1
- Status badge: `<span class="badge badge-success">` with colors
- Modal: `class="modal"`, `openModal()`, `closeModal()`
- Money format: `formatMoney(amount)` using Intl.NumberFormat
- Date format: `formatDate(dateString)` → DD/MM/YYYY

---

### C. FProjects/3 (Insurance - Cyberpunk Theme)

| Thành phần       | Chi tiết                                                                  |
| ---------------- | ------------------------------------------------------------------------- |
| **Purpose**      | Quản lý khách hàng (Customer management)                                  |
| **Architecture** | Procedural PHP + PDO                                                      |
| **Key Files**    | `index.php`, `add_customer.php`, `edit_customer.php`, `view_customer.php` |
| **CSS**          | `/styles.css` (393 lines) - **Cyberpunk theme** (#00eaff, #ff6a00)        |
| **JS**           | `/scripts.js` (38 lines) - Table filtering with debounce                  |
| **Forms**        | Same structure as FProjects/1 but with cyberpunk styling                  |
| **Unique**       | Cyberpunk theme: neon colors, gradient text, glowing effects              |

**Key HTML/CSS/JS Patterns**:

- **Top Bar**: `class="top-bar"` with gradient h1 and cyberpunk styling
- **User Menu**: `class="user-menu"` with dropdown
- **Table Search**: `<input id="search" placeholder="Tìm theo...">` + `filterTable()` debounce function
- **Colors**: Primary #00eaff (cyan), Accent #ff00ff (magenta), Dark #0a0a14
- **Effects**: Glowing text shadow, backdrop filter, neon borders

---

### D. FProjects/4 (Phân hệ 4 - Accounting/Kế toán)

| Thành phần       | Chi tiết                                                       |
| ---------------- | -------------------------------------------------------------- |
| **Purpose**      | Xử lý phiếu thu/chi và báo cáo tài chính                       |
| **Architecture** | OOP (Classes, Namespaces) + PDO + MVC pattern                  |
| **Key Files**    | `/ke-toan/phieu-thu.php`, `phieu-chi.php`, `bao-cao.php`       |
| **Also**         | `/phan-he-4/` (duplicate of ke-toan)                           |
| **CSS**          | `/tai-nguyen/css/style.css` (1166 lines) - Same as FProjects/2 |
| **JS**           | `/tai-nguyen/js/main.js` (101 lines) - Same as FProjects/2     |
| **Key Classes**  | `UngDung\KhoDuLieu\PhieuThuKho`, `PhieuChiKho`, `BaoCaoKho`    |
| **Database**     | `/qlbh_xe.sql` - Same schema as FProjects/2                    |

**Key Features**:

- Phiếu Thu (Receipt): CRUD with filtering (search, date range)
- Phiếu Chi (Payout): CRUD with filtering
- Báo Cáo (Report): Summary stats (tổng thu, tổng chi, lợi nhuận), daily chart, top customers
- Form Fields: `ma_hd`, `so_tien`, `ngay_gd` (phiếu thu), `ma_yc`, `noi_dung` (phiếu chi)

---

## 2. 📊 DATABASE SCHEMA COMPARISON

### Unified Schema (All use qlbh_xe.sql)

```sql
Customers:
  - MaKH (PK)
  - HoTen, NgaySinh, GioiTinh, DiaChi, SoDienThoai, Email, CCCD
  - TrangThai (Hoạt động, DaXoa)

Vehicles:
  - MaXe (PK)
  - MaKH (FK), BienSo, HangXe, DongXe, NamSanXuat, MauSac, SoKhung, SoMay
  - TrangThai

Contracts:
  - MaHD (PK)
  - MaKH (FK), MaXe (FK), MaGoi (FK)
  - NgayLap, NgayHetHan, PhiBaoHiem, TrangThai

Claims (YeuCauBoiThuong):
  - MaYC (PK)
  - MaHD (FK)
  - NgayYeuCau, NgaySuCo, DiaDiemSuCo, MoTaSuCo, SoTienDeXuat, SoTienDuyet
  - TrangThai (Chờ duyệt, Thẩm định xong, Đã duyệt, Từ chối)
  - KetQuaThamDinh, LyDoTuChoi

Receipts (PhieuThu):
  - MaPT (PK)
  - MaHD (FK)
  - NgayThuTien, SoTienThu, GhiChu, MaNV
  - TrangThai

Payouts (PhieuChi):
  - MaPC (PK)
  - MaYC (FK)
  - NgayChiTien, SoTienChi, GhiChu, MaNV
  - TrangThai

Audit Log (qlbh_lichsu):
  - MaLichSu (PK)
  - BangDuLieu, MaBanGhi, HanhDong (INSERT, UPDATE, DELETE)
  - DuLieuCu (JSON), DuLieuMoi (JSON), MaNV, IP, ThoiGian
```

**Conclusion**: All 4 systems use **qlbh_xe.sql** (FProjects 2 & 4 share same DB)

---

## 3. 🎨 HTML/CSS/JS MAPPING

### CSS Resources to Consolidate

| File                | Source           | Lines | Theme                | Status                       |
| ------------------- | ---------------- | ----- | -------------------- | ---------------------------- |
| `/style.css` (Main) | FProjects/2 or 4 | 1166  | Gradient Purple/Blue | ✅ Use as Base               |
| `/bao-cao.css`      | FProjects/2 or 4 | -     | Chart styling        | ✅ Keep for reports          |
| FProjects/3 styles  | `/styles.css`    | 393   | Cyberpunk            | ⚠️ Separate (optional theme) |

**CSS Variables to Use** (From FProjects/2 & 4):

```css
:root {
  --primary: #667eea;
  --secondary: #764ba2;
  --success: #10b981;
  --danger: #ef4444;
  --warning: #f59e0b;
  --info: #3b82f6;
  --dark: #111827;
  --light: #f8fafc;
}
```

---

### JS Functions to Consolidate

| Function                 | Source        | Purpose                       | Status  |
| ------------------------ | ------------- | ----------------------------- | ------- |
| `formatMoney(amount)`    | FProjects/2,4 | Format currency VND           | ✅ Keep |
| `formatDate(dateString)` | FProjects/2,4 | Format date DD/MM/YYYY        | ✅ Keep |
| `confirmDelete(message)` | FProjects/2,4 | Confirm delete dialog         | ✅ Keep |
| `openModal(modalId)`     | FProjects/2,4 | Open modal                    | ✅ Keep |
| `closeModal(modalId)`    | FProjects/2,4 | Close modal                   | ✅ Keep |
| `initSearch()`           | FProjects/1   | Table search                  | ✅ Add  |
| `initDatePickers()`      | FProjects/1   | Date picker                   | ✅ Add  |
| `filterTable()`          | FProjects/3   | Table filtering with debounce | ✅ Add  |

---

## 4. 🔧 HTML FORM PATTERNS

### Customer Form (FProjects/1)

```html
<form method="POST" class="customer-form">
  <div class="form-grid">
    <div class="form-group">
      <label for="customer_code">Mã Khách Hàng *</label>
      <input type="text" id="customer_code" name="customer_code" required />
    </div>
    <div class="form-group">
      <label for="full_name">Họ và Tên *</label>
      <input type="text" id="full_name" name="full_name" required />
    </div>
    <!-- ... -->
  </div>
  <button type="submit" class="btn btn-primary">Lưu</button>
  <a href="customers.php" class="btn btn-secondary">Quay Lại</a>
</form>
```

**Key Points**:

- **Grid layout**: `class="form-grid"` with responsive columns
- **Input names**: `customer_code`, `full_name`, `date_of_birth`, `id_card`, `phone`, `email`, `occupation`, `insurance_type`
- **Buttons**: `class="btn btn-primary"`, `class="btn btn-secondary"`
- **Error display**: `<div class="alert alert-error">` above form
- **Validation**: Server-side + HTML5 attributes (required, type)

---

### Phiếu Thu/Chi Form (FProjects/4)

```html
<form method="POST">
  <input type="hidden" name="action" value="create" />
  <label>Mã HĐ: <input name="ma_hd" required /></label>
  <label
    >Số Tiền: <input type="number" name="so_tien" step="0.01" required
  /></label>
  <label>Ngày GD: <input type="date" name="ngay_gd" required /></label>
  <label>Ghi Chú: <textarea name="ghi_chu"></textarea></label>
  <button type="submit">Tạo</button>
</form>
```

**Key Points**:

- **Hidden action field**: `<input type="hidden" name="action" value="create|edit|delete">`
- **Input names**: `ma_hd`, `so_tien`, `ngay_gd`, `ghi_chu`
- **Money input**: `type="number"` with `step="0.01"`
- **Date input**: `type="date"`

---

## 5. ✅ CURRENT STATUS - FProjects/5

### Already Created

✅ **Core Files**:

- `/core/Database.php` (PDO singleton)
- `/core/Logger.php` (Soft-delete logging to qlbh_lichsu)
- `/core/Model.php` (Base Model with CRUD + soft-delete)
- `/core/Controller.php` (Base Controller)

✅ **Models** (6 files):

- Khachhang, Xe, Hopdong, YeuCau, PhieuThu, PhieuChi

✅ **Controllers** (4 files):

- CustomerController, VehicleController, ClaimsController, AccountingController

✅ **Views** (25 files):

- Customer (4), Vehicle (4), Claims (6), Accounting (11)

✅ **CSS/JS**:

- Inline CSS in views (need consolidation)
- Inline JS in views (need consolidation)

---

## 6. ⚠️ IDENTIFIED ISSUES & MISMATCHES

### Issue #1: CSS Not Consolidated

**Current**: Each view has inline `<style>` block  
**Required**: Shared `/assets/css/style.css` + theme variables  
**Action**: Extract CSS from all views → `/assets/css/style.css`

### Issue #2: JS Functions Not in Main File

**Current**: JS inline in views  
**Required**: All JS in `/assets/js/main.js` + compatibility wrapper  
**Action**: Extract JS → `/assets/js/main.js`, reference in base layout

### Issue #3: No Base Layout/Template

**Current**: Each view has full HTML boilerplate  
**Required**: Base layout (header, navigation, footer) + content inheritance  
**Action**: Create `/app/Views/layout.php`, include in all views

### Issue #4: Form Input Names May Differ

**Current**: OOP model fields vs original form names  
**Required**: Keep original input names, map to model fields  
**Action**: Create hidden input aliases or middleware translator

### Issue #5: Phiếu Thu/Chi Receipt_create.php Changed

**Current**: Modified from audit baseline  
**Required**: Restore exact HTML/CSS/JS from original  
**Action**: Compare with FProjects/4 phieu-thu.php, restore if needed

### Issue #6: README.md Modified

**Current**: Custom documentation  
**Required**: Keep only audit/mapping info  
**Action**: Review and align with requirements

---

## 7. 📋 DETAILED MAPPING DOCUMENT

### Module-1: Customer (Khách hàng)

| Aspect           | FProjects Source                                                                           | Current (FProjects/5)          | Status | Action                          |
| ---------------- | ------------------------------------------------------------------------------------------ | ------------------------------ | ------ | ------------------------------- |
| **File**         | FProjects/1: add_customer.php, customers.php                                               | /app/Views/Customer/ (4 files) | ✅     | OK                              |
| **Form HTML**    | `<form class="customer-form">`                                                             | Same structure                 | ✅     | OK                              |
| **Input names**  | customer_code, full_name, date_of_birth, id_card, phone, email, occupation, insurance_type | Keep exact names               | ✅     | OK                              |
| **CSS Classes**  | form-grid, form-group, btn btn-primary, btn btn-secondary, alert alert-error               | Inline CSS                     | ⚠️     | Move to shared style.css        |
| **JS Functions** | initSearch(), initDatePickers()                                                            | Not implemented                | ❌     | Add to main.js                  |
| **Table Search** | Search box + table filtering                                                               | Not in create/edit             | ✅     | Keep in index view              |
| **Validation**   | Client-side (HTML5) + Server-side                                                          | Server-side only               | ⚠️     | Add HTML5 validation attributes |

---

### Module-2: Claims (Yêu cầu bồi thường)

| Aspect              | FProjects Source                                                              | Current (FProjects/5)        | Status | Action                      |
| ------------------- | ----------------------------------------------------------------------------- | ---------------------------- | ------ | --------------------------- |
| **File**            | FProjects/2: tiep-nhan.php, tham-dinh.php, phe-duyet.php                      | /app/Views/Claims/ (6 files) | ✅     | OK                          |
| **Workflow**        | Chờ duyệt → Thẩm định xong → Đã duyệt/Từ chối                                 | Implemented                  | ✅     | OK                          |
| **Status Badges**   | badge badge-success, badge-warning, badge-danger                              | Inline styles                | ⚠️     | Use CSS variables           |
| **Form Fields**     | ma_hd, ngay_yeu_cau, ngay_su_co, dia_diem_su_co, mo_ta_su_co, so_tien_de_xuat | Correct mapping              | ✅     | OK                          |
| **CSS Variables**   | --primary: #667eea, --success: #10b981, --danger: #ef4444                     | Hardcoded colors             | ⚠️     | Use CSS variables           |
| **Modal Functions** | openModal(), closeModal()                                                     | Not used                     | ⚠️     | Add if needed for workflows |

---

### Module-3: Vehicle (Phương tiện)

| Aspect            | FProjects Source                                                          | Current (FProjects/5)         | Status | Action               |
| ----------------- | ------------------------------------------------------------------------- | ----------------------------- | ------ | -------------------- |
| **File**          | FProjects/1: (implicit in customers)                                      | /app/Views/Vehicle/ (4 files) | ✅     | New module, OK       |
| **Form HTML**     | Same as customer form                                                     | Similar structure             | ✅     | OK                   |
| **Input names**   | ma_xe, bien_so, hang_xe, dong_xe, nam_san_xuat, mau_sac, so_khung, so_may | Check mapping                 | ⚠️     | Verify against model |
| **Unique Fields** | SoKhung, SoMay read-only in edit                                          | Implemented                   | ✅     | OK                   |
| **Validation**    | Unique: BienSo, SoKhung, SoMay                                            | Implemented in controller     | ✅     | OK                   |

---

### Module-4: Accounting (Kế toán)

| Aspect               | FProjects Source                                       | Current (FProjects/5)                           | Status | Action                |
| -------------------- | ------------------------------------------------------ | ----------------------------------------------- | ------ | --------------------- |
| **File**             | FProjects/4: phieu-thu.php, phieu-chi.php, bao-cao.php | /app/Views/Accounting/ (9 files)                | ✅     | Mapped                |
| **Phiếu Thu Fields** | ma_hd, so_tien, ngay_gd, ghi_chu                       | Mapped to: MaHD, SoTienThu, NgayThuTien, GhiChu | ⚠️     | Verify aliases        |
| **Phiếu Chi Fields** | ma_yc, noi_dung, so_tien, ngay_chi, ghi_chu            | Mapped to: MaYC, SoTienChi, NgayChiTien, GhiChu | ⚠️     | Verify aliases        |
| **Report Chart**     | Chart.js for daily data (Thu/Chi by day)               | `/app/Views/Accounting/reports.php`             | ✅     | Check implementation  |
| **Report Metrics**   | Tổng Thu, Tổng Chi, Lợi Nhuận, % Tăng/Giảm YoY         | Implemented                                     | ✅     | OK                    |
| **CSS/JS**           | /tai-nguyen/css/style.css, /tai-nguyen/js/main.js      | Inline CSS/JS                                   | ⚠️     | Move to shared assets |

---

## 8. 🔴 CRITICAL WARNINGS

### W1: Form Input Name Mismatches

**Risk**: Server can't read POST data if form names differ from controller expectations  
**Example**: Form sends `ma_hd` but controller expects `MaHD`  
**Mitigation**: Create input name aliases or middleware translator

### W2: CSS Not Consolidated

**Risk**: Inconsistent styling across modules, hard to maintain theme  
**Mitigation**: Extract all inline CSS → `/assets/css/style.css` with CSS variables

### W3: No Base Layout

**Risk**: HTML boilerplate duplicated in 25 files, hard to update header/footer  
**Mitigation**: Create `/app/Views/layout.php` with header/nav/footer includes

### W4: Missing Compatibility Layer

**Risk**: Original JS functions (formatMoney, formatDate, etc.) not available in OOP structure  
**Mitigation**: Add `window.Legacy = { ... }` wrapper in main.js

### W5: Receipt Create Form Changed

**Risk**: File was modified, may not match original UI  
**Verification**: Need to compare with FProjects/4 phieu-thu.php

### W6: No Visual Regression Tests

**Risk**: UI may look different from original  
**Mitigation**: Create test cases comparing screenshots before/after

---

## 9. 📝 ACTION PLAN

### Phase 1: Infrastructure Setup (BEFORE touching any views)

- [ ] Create `/assets/css/style.css` with consolidated CSS + CSS variables
- [ ] Create `/assets/js/main.js` with all functions + compatibility wrapper
- [ ] Create `/app/Views/layout.php` (header, nav, footer)
- [ ] Document all form input name mappings

### Phase 2: View Consolidation

- [ ] Extract inline CSS from all 25 views → external style.css
- [ ] Extract inline JS from all 25 views → external main.js
- [ ] Update views to inherit from layout.php
- [ ] Create input name aliases if needed

### Phase 3: Functional Testing

- [ ] Visual regression test (screenshot comparisons)
- [ ] Functional test (CRUD workflows)
- [ ] Database integrity test (soft-delete, logging)
- [ ] JS behavior test (submit, validation, modal)

### Phase 4: Sign-off & Merge

- [ ] Changelog with screenshots
- [ ] Owner sign-off
- [ ] Merge to production

---

## 10. 📊 SUMMARY STATISTICS

| Item                        | Count      | Status                    |
| --------------------------- | ---------- | ------------------------- |
| **Files Audited**           | 4 projects | ✅ Complete               |
| **Key Patterns Identified** | 20+        | ✅ Documented             |
| **CSS Resources**           | 4 files    | ⚠️ Need consolidation     |
| **JS Functions**            | 10+        | ⚠️ Need consolidation     |
| **Form Patterns**           | 3 types    | ✅ Documented             |
| **Database Tables**         | 10+        | ✅ Unified schema         |
| **Views Created**           | 25         | ⚠️ Need layout extraction |
| **Critical Issues**         | 6          | ⚠️ See section 8          |

---

## NEXT STEPS

**Based on this audit, the following must be completed BEFORE testing**:

1. ✅ **Extract & Consolidate CSS**: All inline styles → `/assets/css/style.css`
2. ✅ **Extract & Consolidate JS**: All inline functions → `/assets/js/main.js`
3. ✅ **Create Base Layout**: `/app/Views/layout.php` with header/nav/footer
4. ✅ **Verify Input Mappings**: Form names vs controller fields
5. ✅ **Create Compatibility Layer**: `window.Legacy = { ... }` wrapper
6. ✅ **Run Visual Regression**: Compare screenshots before/after
7. ✅ **Run Functional Tests**: CRUD + workflows in all 4 modules
8. ✅ **Database Integrity Tests**: Soft-delete, logging, constraints
9. ✅ **Sign-off & Changelog**: Document all changes with screenshots

---

**Report Status**: ✅ COMPLETE  
**Recommendation**: PROCEED TO PHASE 1 IMMEDIATELY
