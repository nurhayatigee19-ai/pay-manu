{{-- ================================================= --}}
{{-- VENDOR CSS (JANGAN DIUBAH URUTANNYA) --}}
{{-- ================================================= --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<link rel="stylesheet" href="{{ asset('Template/assets/compiled/css/app.css') }}">
<link rel="stylesheet" href="{{ asset('Template/assets/compiled/css/app-dark.css') }}">
<link rel="stylesheet" href="{{ asset('Template/assets/compiled/css/iconly.css') }}">

{{-- ================================================= --}}
{{-- ICON --}}
{{-- ================================================= --}}
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

{{-- ================================================= --}}
{{-- GLOBAL THEME SYSTEM (SOURCE OF TRUTH) --}}
{{-- ================================================= --}}
<style>
/* ================================================= */
/* ROOT THEME VARIABLE */
/* ================================================= */
:root {
    --theme-primary: #198754;
    --theme-primary-dark: #0f5132;
    --theme-accent: #ffc107;
    --theme-bg-soft: rgba(25, 135, 84, 0.06);
}

/* ================================================= */
/* SIDEBAR */
/* ================================================= */
#sidebar,
#sidebar .sidebar-wrapper,
#sidebar .sidebar-wrapper.active {
    background: linear-gradient(
        180deg,
        var(--theme-primary),
        var(--theme-primary-dark)
    ) !important;
}

/* ================================================= */
/* TABLE SYSTEM – GRID VERSION (FINAL) */
/* ================================================= */

.table-theme {
    border-collapse: collapse; /* penting untuk garis rapi */
    width: 100%;
}

/* HEADER */
.table-theme thead th {
    background-color: var(--bs-success) !important;
    color: #ffffff !important;
    text-align: center;
    vertical-align: middle;
    font-weight: 600;
    border: 1px solid rgba(255,255,255,0.25) !important;
}

/* BODY CELL */
.table-theme tbody td {
    vertical-align: middle;
    border: 1px solid rgba(0,0,0,0.08);
}

/* HOVER */
.table-theme tbody tr:hover {
    background-color: rgba(var(--bs-success-rgb), 0.08) !important;
}

/* ================================================= */
/* CARD */
/* ================================================= */
.card-stat {
    transition: all .3s ease;
}

.card-stat:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 18px rgba(0,0,0,.15);
}

/* ================================================= */
/* BADGE STATUS SYSTEM */
/* ================================================= */
.badge-lunas {
    background: var(--theme-primary);
}

.badge-belum {
    background: #dc3545;
}

/* ================================================= */
/* UTILITIES */
/* ================================================= */
.text-gold {
    color: #f1c40f;
}

.text-theme {
    color: var(--theme-primary);
}

.bg-theme {
    background: var(--theme-primary);
    color: #fff;
}

/* PAGINATION CUSTOM HIJAU */
.pagination .page-link {
    color: #198754;
}

.pagination .page-item.active .page-link {
    background-color: #198754;
    border-color: #198754;
    color: #fff;
}

.pagination .page-link:hover {
    background-color: #157347;
    color: #fff;
}

/* ================================================= */
/* BUTTON ACTION SYSTEM (GLOBAL) */
/* ================================================= */

/* container tombol aksi */
.action-group {
    display: inline-flex;
    gap: 6px; /* jarak otomatis antar tombol */
}

/* tombol kecil konsisten */
.btn-action {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* hover lebih halus */
.btn-action:hover {
    transform: scale(1.08);
    transition: 0.2s;
}

/* tombol kembali */
.btn-back-pro {
    background: linear-gradient(135deg, #198754, #157347);
    color: #fff;
    padding: 10px 18px;
    border-radius: 12px;
    font-weight: 500;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(25, 135, 84, 0.25);
    transition: all 0.25s ease;
}

/* Hover */
.btn-back-pro:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 6px 14px rgba(25, 135, 84, 0.35);
    color: #fff;
}

/* Klik */
.btn-back-pro:active {
    transform: scale(0.97);
}

/* Icon */
.btn-back-pro i {
    font-size: 16px;
}

/* ============ GLOBAL ICON BUTTON ============ */
.action-icons {
    display: inline-flex;
    gap: 6px;
}

.btn-icon {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    border: none;
    cursor: pointer;
    transition: all .2s ease;
}

/* EDIT */
.btn-edit {
    background: rgba(0, 123, 255, .15);
    color: #0d6efd;
}
.btn-edit:hover {
    background: #0d6efd;
    color: white;
}

/* DELETE */
.btn-delete {
    background: rgba(220, 53, 69, .15);
    color: #dc3545;
}
.btn-delete:hover {
    background: #dc3545;
    color: white;
}

/* RESET PASSWORD */
.btn-reset {
    background: rgba(255, 193, 7, .20);
    color: #d39e00;
}
.btn-reset:hover {
    background: #ffc107;
    color: black;
}

/* Tambah User Button */
.btn-add-icon {
    padding: 8px 14px;
    border-radius: 10px;
    background: var(--theme-primary);
    color: #fff;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: .2s;
}
.btn-add-icon:hover {
    transform: scale(1.05);
    color: #fff;
}

.btn-add-icon {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 6px;
}

.btn-add-icon i {
    font-size: 18px;
    line-height: 0; 
}

</style>

{{-- ================================================= --}}
{{-- PAGE SPECIFIC (DARI @push('styles')) --}}
{{-- ================================================= --}}
@stack('styles')