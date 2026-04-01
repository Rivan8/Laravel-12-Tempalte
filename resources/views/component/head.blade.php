<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
<link rel="icon" sizes="32x32" type="image/png" href="{{ asset('img/free.png') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!--     Fonts and icons     -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
<!-- Nucleo Icons -->
<link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
<link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
<link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
<!-- CSS Files -->
<link id="pagestyle" href="{{ asset('css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
<link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<style>
    /* ============================================================
       SIDEBAR NOTIFICATION BADGE
    ============================================================ */
    .sidebar-badge-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        min-width: 20px;
        height: 20px;
        padding: 0 5px;
        background: linear-gradient(310deg, #f5365c 0%, #f56036 100%);
        color: #fff;
        font-size: 0.65rem;
        font-weight: 700;
        border-radius: 50px;
        line-height: 1;
        box-shadow: 0 2px 8px rgba(245, 54, 92, 0.55);
        animation: badge-pulse 2s infinite;
        z-index: 10;
        pointer-events: none;
    }

    @keyframes badge-pulse {
        0%   { box-shadow: 0 0 0 0 rgba(245, 54, 92, 0.7); }
        70%  { box-shadow: 0 0 0 6px rgba(245, 54, 92, 0); }
        100% { box-shadow: 0 0 0 0 rgba(245, 54, 92, 0); }
    }

    /* ============================================================
       REQUEST KELAS — TABLE BADGE DALAM TABEL USER
    ============================================================ */
    .kelas-request-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 6px;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(33, 82, 255, 0.3);
    }

    .kelas-request-row {
        animation: fadeInRow 0.4s ease both;
    }

    @keyframes fadeInRow {
        from { opacity: 0; transform: translateY(-4px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Notification toast style untuk tabel request */
    .request-status-new {
        border-left: 3px solid #f5365c !important;
    }
</style>
