<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Segera Kembali | Equip Discipleship</title>
    <style>
        :root { color-scheme: light; }
        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 24px;
            overflow: hidden;
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 45%, #f8fafc 100%);
            color: #172033;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .orb { position: fixed; border-radius: 999px; filter: blur(4px); pointer-events: none; }
        .orb-one { width: 280px; height: 280px; top: -120px; right: -80px; background: rgba(251, 146, 60, .28); }
        .orb-two { width: 220px; height: 220px; bottom: -100px; left: -70px; background: rgba(234, 88, 12, .18); }
        .panel {
            position: relative;
            width: min(100%, 560px);
            padding: 48px 36px;
            text-align: center;
            background: rgba(255, 255, 255, .88);
            border: 1px solid rgba(234, 88, 12, .14);
            border-radius: 28px;
            box-shadow: 0 24px 70px rgba(124, 45, 18, .14);
            backdrop-filter: blur(14px);
        }
        .logo {
            width: 86px;
            height: 86px;
            margin: 0 auto 28px;
            padding: 18px;
            display: grid;
            place-items: center;
            border-radius: 24px;
            background: linear-gradient(135deg, #ea580c, #fb923c);
            box-shadow: 0 12px 28px rgba(234, 88, 12, .32);
        }
        .logo img { width: 100%; height: 100%; filter: brightness(0) invert(1); }
        .eyebrow { margin: 0 0 10px; color: #ea580c; font-size: .72rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; }
        h1 { margin: 0; color: #0f172a; font-size: clamp(2rem, 6vw, 3rem); line-height: 1.05; }
        .brand { margin: 14px 0 0; color: #475569; font-size: 1rem; font-weight: 700; }
        .message { max-width: 390px; margin: 18px auto 0; color: #64748b; font-size: .95rem; line-height: 1.7; }
        .status { display: inline-flex; align-items: center; gap: 8px; margin-top: 28px; padding: 9px 14px; border-radius: 999px; background: #fff7ed; color: #c2410c; font-size: .78rem; font-weight: 700; }
        .status span { width: 8px; height: 8px; border-radius: 50%; background: #f97316; box-shadow: 0 0 0 5px rgba(249, 115, 22, .14); }
        @media (max-width: 480px) { .panel { padding: 38px 22px; border-radius: 22px; } }
    </style>
</head>
<body>
    <div class="orb orb-one"></div>
    <div class="orb orb-two"></div>
    <main class="panel">
        <div class="logo">
            <img src="{{ asset('img/logos/logo_equip.svg') }}" alt="Equip Discipleship">
        </div>
        <p class="eyebrow">Equip Discipleship Learning Center</p>
        <h1>Kami akan segera kembali</h1>
        <p class="brand">Sedang melakukan pembaruan sistem</p>
        <p class="message">Platform sedang kami siapkan agar pengalaman belajar Anda menjadi lebih baik. Silakan kembali beberapa saat lagi.</p>
        <div class="status"><span></span> Dalam pemeliharaan</div>
    </main>
</body>
</html>
