<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Elshaddai Learning Center') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Scripts (Vite / Tailwind tetap diload) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { margin: 0; padding: 0; font-family: 'Inter', sans-serif; }

        /* ─── WRAPPER ─── */
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: stretch;
        }

        /* ─── PANEL KIRI: Branding ─── */
        .auth-brand-panel {
            display: none;
            flex: 0 0 44%;
            position: relative;
            overflow: hidden;
            background: linear-gradient(150deg, #0f172a 0%, #1e293b 50%, #0c2340 100%);
        }

        @media (min-width: 1024px) {
            .auth-brand-panel {
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 64px 52px;
            }
        }

        .auth-brand-panel::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse at 15% 20%, rgba(234,88,12,0.28) 0%, transparent 55%),
                radial-gradient(ellipse at 85% 85%, rgba(251,146,60,0.18) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Floating orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.25;
            animation: floatOrb 9s ease-in-out infinite;
        }
        .orb-1 { width: 320px; height: 320px; background: #ea580c; top: -100px; right: -100px; animation-delay: 0s; }
        .orb-2 { width: 220px; height: 220px; background: #fb923c; bottom: 40px; left: -60px; animation-delay: 3.5s; }
        .orb-3 { width: 160px; height: 160px; background: #f97316; top: 45%; left: 30%; animation-delay: 6s; }

        @keyframes floatOrb {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-18px) scale(1.06); }
        }

        /* Branding content */
        .b-logo-box {
            width: 58px; height: 58px; border-radius: 16px;
            background: linear-gradient(135deg, #ea580c 0%, #fb923c 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; font-weight: 800; color: #fff; letter-spacing: -1px;
            box-shadow: 0 8px 28px rgba(234,88,12,0.55);
            flex-shrink: 0;
        }

        .b-app-name {
            font-size: 1.55rem; font-weight: 800; color: #fff;
            letter-spacing: -0.5px; line-height: 1.15;
        }
        .b-app-name span { color: #fb923c; }
        .b-subtitle { font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 2px; }

        .b-divider {
            width: 36px; height: 2px;
            background: linear-gradient(90deg, #ea580c, transparent);
            border-radius: 2px; margin: 32px 0;
        }

        .b-quote {
            font-size: 1.1rem; font-weight: 600; color: rgba(255,255,255,0.88);
            line-height: 1.75; font-style: italic; margin-bottom: 10px;
        }
        .b-quote-ref { font-size: 0.75rem; color: #fb923c; font-weight: 700; letter-spacing: 0.5px; }

        .b-features { margin-top: 44px; display: flex; flex-direction: column; gap: 16px; }
        .b-feature { display: flex; align-items: center; gap: 14px; }
        .b-feature-icon {
            width: 38px; height: 38px; border-radius: 12px;
            background: rgba(255,255,255,0.07);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .b-feature-icon i { color: #fb923c; font-size: 0.88rem; }
        .b-feature-text { font-size: 0.82rem; color: rgba(255,255,255,0.65); font-weight: 500; }

        /* ─── PANEL KANAN: Form ─── */
        .auth-form-panel {
            flex: 1;
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            padding: 48px 24px;
            background: #f1f5f9;
            overflow-y: auto;
        }

        .auth-mobile-logo {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 32px;
            text-decoration: none;
        }
        @media (min-width: 1024px) { .auth-mobile-logo { display: none; } }

        .auth-card {
            width: 100%; max-width: 430px;
            background: #ffffff;
            border-radius: 24px;
            padding: 44px 40px;
            box-shadow: 0 4px 50px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.05);
        }

        @media (max-width: 480px) {
            .auth-card { padding: 32px 22px; border-radius: 18px; }
        }

        .auth-footer {
            margin-top: 28px;
            font-size: 0.72rem; color: #94a3b8; text-align: center;
        }
    </style>
</head>
<body>
<div class="auth-wrapper">

    {{-- ─── KIRI: Branding Panel ─── --}}
    <div class="auth-brand-panel">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <div style="position: relative; z-index: 2;">
            {{-- Logo & App Name --}}
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 52px;">
                <div class="b-logo-box">ESC</div>
                <div>
                    <div class="b-app-name">Equip <span>Discipleship</span></div>
                    <div class="b-subtitle">Learning Center</div>
                </div>
            </div>

            {{-- Ayat --}}
            <div class="b-divider"></div>
            <p class="b-quote">
                "Pergilah, jadikanlah semua bangsa murid-Ku, baptislah mereka dan ajarlah mereka..."
            </p>
            <p class="b-quote-ref">— Matius 28:19-20</p>

            {{-- Feature list --}}
            <div class="b-features">
                <div class="b-feature">
                    <div class="b-feature-icon"><i class="fas fa-book-open"></i></div>
                    <span class="b-feature-text">Kurikulum terstruktur & berjenjang</span>
                </div>
                <div class="b-feature">
                    <div class="b-feature-icon"><i class="fas fa-video"></i></div>
                    <span class="b-feature-text">Materi video interaktif & pelacakan progres</span>
                </div>
                <div class="b-feature">
                    <div class="b-feature-icon"><i class="fas fa-users"></i></div>
                    <span class="b-feature-text">Komunitas Disciple Maker aktif</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── KANAN: Form Panel ─── --}}
    <div class="auth-form-panel">

        {{-- Logo Mobile (tersembunyi di desktop) --}}
        <a href="/" class="auth-mobile-logo">
            <div style="
                width: 48px; height: 48px; border-radius: 14px;
                background: linear-gradient(135deg, #ea580c, #fb923c);
                display: flex; align-items: center; justify-content: center;
                font-size: 1.1rem; font-weight: 800; color: #fff;
                box-shadow: 0 6px 22px rgba(234,88,12,0.4);
                flex-shrink: 0;
            ">ESC</div>
            <div>
                <div style="font-size: 1.15rem; font-weight: 800; color: #1e293b; letter-spacing: -0.3px; line-height: 1.2;">
                    Equip <span style="color: #ea580c;">Discipleship</span>
                </div>
                <div style="font-size: 0.68rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.8px;">Learning Center</div>
            </div>
        </a>

        {{-- Form Card --}}
        <div class="auth-card">
            {{ $slot }}
        </div>

        <p class="auth-footer">
            &copy; {{ date('Y') }} Elshaddai Learning Center. All rights reserved.
        </p>
    </div>

</div>
</body>
</html>
