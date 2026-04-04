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
</style>

{{-- ================================================= --}}
{{-- PAGE SPECIFIC (DARI @push('styles')) --}}
{{-- ================================================= --}}
@stack('styles')