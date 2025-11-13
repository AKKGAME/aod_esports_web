<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" type="image/png" href="{{ asset('img/aod_logo.png') }}" sizes="32x32">
    <title>@yield('title', 'Angels Of Death - Esports Team')</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Raleway:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    <style>
        /* ===== 1. General Setup & Color Variables ===== */
        :root {
            --primary-color: #00ff7f; /* Esports Green */
            --dark-color: #0a0f1e;
            --dark-secondary: #1a2238;
            --light-color: #f0f0f0;
            --font-primary: 'Raleway', sans-serif;
            --font-secondary: 'Roboto', sans-serif;
            --rank-gold: #ffd700;
            --rank-silver: #c0c0c0;
            --rank-bronze: #cd7f32;
        }

        body {
            background-color: var(--dark-color);
            color: var(--light-color);
            font-family: var(--font-secondary);
        }

        /* ===== 2. Fluid Typography ===== */
        h1, .hero-title, .roster-hero-title {
            font-family: var(--font-primary);
            font-weight: 900;
            color: #ffffff;
            font-size: clamp(2.5rem, 5vw + 1rem, 4.5rem);
        }
        h2, .section-title {
            font-family: var(--font-primary);
            font-weight: 900;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: clamp(1.8rem, 4vw + 0.5rem, 2.5rem);
        }
        h3, .team-card-title, .player-card-title, .player-name {
            font-family: var(--font-primary);
            font-weight: 700;
            color: #ffffff;
        }

        /* ===== 3. Animations & Keyframes (ရှင်းလင်းပြီး) ===== */
        /* @keyframes kenburns, @keyframes logoPulse, @keyframes shine, @keyframes bounce, @keyframes spin, @keyframes clean-flicker (အားလုံး ဖြုတ်လိုက်ပါပြီ) */
        
        /* (Scroll animation ကိုတော့ ချန်ထားပါမယ်) */
        .fade-in-section {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        .fade-in-section.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        /* (Tournament အတွက် ကျန်နေတဲ့ animation တွေ) */
        @keyframes pulse-live { 0% { box-shadow: 0 0 0 0 rgba(255, 27, 27, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(255, 27, 27, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 27, 27, 0); } }
        @keyframes fade-in-row { to { opacity: 1; transform: translateY(0); } }

        /* ===== 4. Reusable Components (Buttons, etc.) ===== */
        .btn-primary-custom, .btn-secondary-custom {
            padding: 0.8rem 2.5rem;
            font-weight: 700;
            font-family: var(--font-primary);
            border: 2px solid var(--primary-color);
            border-radius: 50px;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }
        .btn-primary-custom {
            background-color: var(--primary-color);
            color: var(--dark-color);
        }
        .btn-secondary-custom {
            background-color: transparent;
            color: var(--primary-color);
        }
        .btn-primary-custom:hover, .btn-secondary-custom:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 255, 127, 0.2);
            color: var(--dark-color);
            background-color: var(--primary-color);
        }
        .btn-outline-custom {
            color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 700;
            transition: all 0.3s ease;
            border-radius: 50px;
        }
        .btn-outline-custom:hover {
            color: var(--dark-color);
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: scale(1.05);
            box-shadow: 0 0 15px var(--primary-color);
        }

        /* ===== 5. Page Sections ===== */

        /* --- Header & Navbar --- */
        .header .navbar {
            background-color: transparent;
            transition: background-color 0.4s ease;
        }
        .header .navbar.scrolled {
            background-color: rgba(10, 15, 30, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--dark-secondary);
        }
        .navbar-brand {
            font-family: var(--font-primary);
            font-weight: 900;
            font-size: 1.5rem;
            letter-spacing: 1px;
            color: var(--light-color);
            transition: all 0.4s ease;
        }
        .navbar-brand:hover {
            color: var(--primary-color);
            text-shadow: 0 0 15px var(--primary-color);
        }
        .nav-link {
            font-family: var(--font-primary);
            font-weight: 700;
            text-transform: uppercase;
            transition: color 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }
        .dropdown-item.lang-switcher.active {
            font-weight: bold;
            background-color: var(--primary-color);
            color: #0a0f1e;
        }
        
        /* --- Hero Section (Effect ဖြုတ်ပြီး) --- */
        .hero {
            height: 100vh;
            background: url('https://www.pubgmobile.com/images/event/home/part6.jpg') no-repeat center center/cover;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
            /* animation: kenburns 20s ease-out infinite; (ဖြုတ်လိုက်ပါပြီ) */
        }
            
        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, var(--dark-color) 5%, rgba(0,0,0,0.6) 100%);
            z-index: 1;
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .hero-logo {
            width: 180px;
            height: auto;
            /* animation: logoPulse 4s infinite ease-in-out; (ဖြုတ်လိုက်ပါပြီ) */
            filter: drop-shadow(0 0 15px var(--primary-color)); /* Static glow effect */
        }
        .hero-title {
            font-family: var(--font-primary);
            font-size: 4.5rem;
            font-weight: 900;
            /* (Shine effect အတွက် gradient ကို ချန်ထားပါမယ်၊ animation ပဲ ဖြုတ်ပါ) */
            background: linear-gradient(90deg, #fff, #fff, var(--primary-color), #fff, #fff);
            background-size: 200% auto;
            color: #fff;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            /* animation: shine 5s linear infinite; (ဖြုတ်လိုက်ပါပြီ) */
        }
        .hero-subtitle {
            font-size: 1.5rem;
            font-family: var(--font-primary);
            letter-spacing: 2px;
            color: #fff;
        }
        .scroll-down {
            position: absolute;
            bottom: 30px;
            color: var(--primary-color);
            z-index: 3;
            font-size: 1.5rem;
            /* animation: bounce 2s infinite; (ဖြုတ်လိုက်ပါပြီ) */
        }

        /* --- About Section --- */
        .about-section {
            background-color: var(--dark-secondary);
            padding: 100px 0;
        }
        .about-logo {
            max-width: 300px;
            filter: drop-shadow(0 0 40px var(--primary-color));
        }

        /* --- Team Card (ပုံမှန်အတိုင်း) --- */
        .teams-section {
            padding: 100px 0;
            background-color: var(--dark-color);
        }
        .team-card {
            background-color: var(--dark-secondary);
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid #222;
            transition: transform 0.4s ease, box-shadow 0.4s ease, border-color 0.4s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 255, 127, 0.2);
            border-color: rgba(0, 255, 127, 0.5); 
        }
        .team-card-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.4s ease-out;
        }
        .team-card:hover .team-card-img {
            transform: scale(1.1);
        }
        .team-card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .team-card-title {
            margin-bottom: 0.75rem;
        }
        .team-card-text {
            color: #adb5bd;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        /* --- Sponsors Section --- */
        .sponsors-section {
            background-color: var(--dark-secondary);
            padding: 80px 0;
        }
        .sponsor-card {
            background-color: var(--dark-secondary);
            border: 1px solid #2a344a;
            border-radius: 12px;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%; 
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        .sponsor-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
            box-shadow: 0 8px 25px rgba(0, 255, 127, 0.1);
        }
        .sponsor-card-logo-wrapper {
            height: 100px; 
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .sponsor-card-logo {
            max-height: 80px; 
            max-width: 200px; 
            object-fit: contain;
            filter: brightness(0) invert(1); 
            opacity: 0.8;
            transition: all 0.3s ease;
        }
        .sponsor-card:hover .sponsor-card-logo {
            filter: none; 
            opacity: 1;
        }
        .sponsor-card-name {
            color: var(--primary-color);
            font-family: var(--font-primary);
            font-weight: 700;
            font-size: 1.25rem;
            margin-top: 1rem;
        }
        .sponsor-card-desc {
            color: #a0aec0; 
            font-size: 0.9rem;
            margin-top: 0.5rem;
            flex-grow: 1;
        }
        .sponsor-level-title {
            font-family: var(--font-primary);
            font-weight: 700;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 1.2rem;
            text-align: center;
            margin-top: 2.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--dark-secondary);
            padding-bottom: 10px;
        }

        /* --- Footer --- */
        .footer {
            background-color: #000;
        }
        .footer-title {
            color: #fff;
            font-size: 2rem;
        }
        .footer .social-icons a {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 45px;
            height: 45px;
            border: 2px solid var(--dark-secondary);
            border-radius: 50%;
            color: #fff;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        .footer .social-icons a:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--dark-color);
            transform: translateY(-5px);
        }
        .copyright {
            margin-top: 2rem;
            font-size: 0.9rem;
            opacity: 0.6;
        }

        /* ===== 6. Roster Page Specific Styles ===== */
        .roster-hero {
            padding-top: 150px; padding-bottom: 80px;
            background: url('https://www.pubgmobile.com/images/event/home/part6.jpg') no-repeat center center/cover;
            position: relative; z-index: 1;
        }
        .roster-hero::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to bottom, rgba(10, 15, 30, 0.8), rgba(10, 15, 30, 1));
            z-index: -1;
        }
        .roster-hero-title {
            font-size: 4rem; font-weight: 900; text-transform: uppercase; color: #ffffff;
            text-shadow: 0 0 15px rgba(0, 255, 127, 0.5);
        }
        .roster-hero-subtitle {
            font-size: 1.25rem; color: var(--light-color); max-width: 600px; margin: 0 auto;
        }

        /* --- Team Header (PUBG, etc) --- */
        .team-header {
            display: flex; align-items: center; justify-content: center;
            gap: 20px; margin-bottom: 50px;
        }
        .game-logo { width: 70px; height: auto; }

        /* --- Player Card (Spinning Border ဖြုတ်ပြီး) --- */
        /* @property --rotate (ဖြုတ်လိုက်ပါပြီ) */
        
        .player-card {
            background-color: var(--dark-secondary); /* (၁) Inner က style ကို အပြင်ကို ထုတ်ပါ */
            border-radius: 12px;
            overflow: hidden; /* (၂) overflow: visible အစား hidden ပြန်ထားပါ */
            text-align: center;
            position: relative;
            z-index: 1;
            transition: transform 0.4s ease, box-shadow 0.4s ease, border-color 0.4s ease; /* (၃) team-card လိုမျိုး transition ထည့်ပါ */
            border: 1px solid #222; /* (၄) team-card လိုမျိုး border ထည့်ပါ */
        }
        .player-card-inner {
            /* (၅) ဒီ class က အခု ဘာမှ မလုပ်တော့ပါဘူး (HTML structure မပြောင်းချင်လို့ ချန်ထားတာပါ) */
            width: 100%;
            height: 100%;
            border-radius: inherit;
            overflow: hidden;
            position: relative;
            z-index: 2;
        }
        /* .player-card::before, .player-card::after (Spinning border တွေ ဖြုတ်လိုက်ပါပြီ) */

        .player-card:hover {
            transform: translateY(-10px);
            /* (၆) team-card လိုမျိုး hover effect ပြောင်းထည့်ပါ */
            box-shadow: 0 10px 25px rgba(0, 255, 127, 0.2);
            border-color: rgba(0, 255, 127, 0.5); 
        }

        /* --- Player Card Content --- */
        .player-card-logo {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: auto;
            z-index: 10;
            filter: drop-shadow(0 0 5px rgba(0, 255, 127, 0.7));
            transition: transform 0.3s ease, filter 0.3s ease;
        }
        .player-card:hover .player-card-logo {
            transform: scale(1.1);
            filter: drop-shadow(0 0 10px var(--primary-color));
        }
        .player-card-img-container { 
            position: relative; 
            overflow: hidden;
            background-color: #000;
        }
        .player-card-img {
            width: 100%;
            display: block;
            aspect-ratio: 3 / 4;
            object-fit: cover;
            object-position: top;
            transition: transform 0.4s ease, filter 0.4s ease;
        }
        .player-card:hover .player-card-img {
            transform: scale(1.05);
            filter: brightness(1.1);
        }
        .player-role, .player-card-body, .player-name, .player-flag, .player-real-name, .player-socials {
            position: relative;
            z-index: 3;
        }
        .player-role {
            position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.7); color: var(--primary-color);
            padding: 5px 15px; border-radius: 20px; font-family: var(--font-primary);
            font-weight: 700; font-size: 0.8rem; text-transform: uppercase;
        }
        .player-card-body { padding: 25px; }
        .player-name {
            font-size: 1.30rem; margin-bottom: 5px; color: var(--primary-color);
            display: flex; justify-content: center; align-items: center;
            gap: 0.75rem;
        }
        .player-flag {
            width: 25px; height: auto; border-radius: 3px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.5);
        }
        /* .player-card:hover .player-name { animation: clean-flicker 2s infinite alternate; } (Flicker effect ဖြုတ်လိုက်ပါပြီ) */
        
        .player-real-name {
            color: #8a93a7; font-size: 0.9rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 1px;
            margin-bottom: 15px; min-height: 20px;
            display: flex; justify-content: center; align-items: center;
        }
        .player-real-name .fa-user-circle { margin-right: 8px; font-size: 0.8rem; }
        .player-socials a {
            color: #a0a0a0; font-size: 1.2rem; margin: 0 10px;
            transition: color 0.3s ease, transform 0.3s ease;
        }
        .player-socials a:hover { color: var(--primary-color); transform: scale(1.2); }
        
        /* --- Team Achievements --- */
        .team-achievements { background-color: var(--dark-secondary); padding: 30px; border-radius: 10px; border-left: 5px solid var(--primary-color); }
        .achievements-title { color: var(--primary-color); margin-bottom: 20px; }
        .team-achievements ul { list-style: none; padding: 0; margin: 0; }
        .team-achievements li { font-size: 1.1rem; margin-bottom: 10px; }
        .team-achievements li .fa-trophy { color: #ffd700; margin-right: 10px; }

        
/* resources/views/layouts/public.blade.php (CSS အဟောင်းကို အစားထိုးပါ) */

        /* ===== 7. Responsive Media Queries (Roster) ===== */
        @media (max-width: 992px) {
            .about-section .text-center {
                margin-top: 3rem;
            }
        }
        
        @media (max-width: 768px) {
            .hero {
                height: 85vh;
            }
            .hero-title, .roster-hero-title { font-size: 2.5rem; }
            .hero-subtitle { font-size: 1.2rem; }
            .hero-logo { width: 120px; }
            .section-title { font-size: 1.8rem; }
            
            /* (၁) Mobile မှာ Card တွေ hover (မြောက်တက်) effect ကို ပိတ်ပါ */
            .player-card:hover {
                transform: none;
                /* (shadow ကို မူလ card shadow နဲ့ တူအောင် ပြန်ထားပါ) */
                box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
            }
            
            /* === (၂) (အရေးကြီး) Mobile မှာ Spinning Border ကို လုံးဝ ပိတ်ပါ === */
            .player-card::before,
            .player-card::after {
                animation: none; /* spin animation ကို ပိတ်ပါ */
                opacity: 0; /* လုံးဝ ဖျောက်ထားပါ */
                width: 100%; /* (overflow မဖြစ်အောင် width 100% ပြန်ထားပါ) */
                left: 0;
            }
            /* === (Spinning Border အဆုံး) === */

            /* (၃) Mobile မှာ Player Name flicker animation ကို ပိတ်ပါ */
            .player-card:hover .player-name {
                animation: none;
            }
            
            /* (၄) Card ထဲက စာလုံး အရွယ်အစား အနည်းငယ် ချိန်ညှိပါ */
            .player-name {
                font-size: 1.15rem;
            }
            .player-real-name {
                font-size: 0.8rem;
            }
            
            /* (၅) Player Profile Page အတွက် CSS */
            #profile-details .fs-4 {
                font-size: 1.25rem !important; 
            }
            #profile-details .player-socials a {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body> 
    <header class="header">
        @include('includes.header')
    </header>

    <main>
        @yield('content')
    </main>

    <section id="sponsors" class="sponsors-section py-5 fade-in-section">
        <div class="container">
            <h2 class="section-title text-center mb-5" data-lang-key="sponsorsTitle">OUR PARTNERS</h2>
            
            @if (isset($groupedSponsors) && $groupedSponsors->has('Title Partner'))
                <h4 class="sponsor-level-title">Title Partner</h4>
                <div class="row g-4 justify-content-center mb-5">
                    @foreach ($groupedSponsors['Title Partner'] as $sponsor)
                        <div class="col-lg-6 col-md-8"> 
                            <a href="{{ $sponsor->website_url ?? '#' }}" target="_blank" class="text-decoration-none">
                                <div class="sponsor-card">
                                    <div class="sponsor-card-logo-wrapper">
                                        <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }} Logo" class="sponsor-card-logo">
                                    </div>
                                    <h3 class="sponsor-card-name">{{ $sponsor->name }}</h3>
                                    <p class="sponsor-card-desc">{{ $sponsor->description }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            @if (isset($groupedSponsors) && $groupedSponsors->has('Official Partner'))
                <h4 class="sponsor-level-title">Official Partners</h4>
                <div class="row g-4 justify-content-center mb-5">
                    @foreach ($groupedSponsors['Official Partner'] as $sponsor)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ $sponsor->website_url ?? '#' }}" target="_blank" class="text-decoration-none">
                                <div class="sponsor-card">
                                    <div class="sponsor-card-logo-wrapper">
                                        <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }} Logo" class="sponsor-card-logo">
                                    </div>
                                    <h3 class="sponsor-card-name">{{ $sponsor->name }}</h3>
                                    <p class="sponsor-card-desc">{{ $sponsor->description }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
            
            @php
                if (isset($groupedSponsors)) {
                    $otherSponsors = collect()
                        ->merge($groupedSponsors['Partner'] ?? [])
                        ->merge($groupedSponsors['Supporter'] ?? []);
                } else {
                    $otherSponsors = collect();
                }
            @endphp

            @if ($otherSponsors->isNotEmpty())
                <h4 class="sponsor-level-title">Partners & Supporters</h4>
                <div class="row g-4 justify-content-center">
                    @foreach ($otherSponsors as $sponsor)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <a href="{{ $sponsor->website_url ?? '#' }}" target="_blank" class="text-decoration-none">
                                <div class="sponsor-card">
                                    <div class="sponsor-card-logo-wrapper">
                                        <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }} Logo" class="sponsor-card-logo">
                                    </div>
                                    <h3 class="sponsor-card-name" style="font-size: 1.1rem;">{{ $sponsor->name }}</h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

    <footer id="contact" class="footer pt-5 pb-4">
        <div class="container text-center">
            <h3 class="footer-title">ANGELS OF DEATH</h3>
            <p data-lang-key="footerText">Follow us on our journey to the top!</p>
            <div class="social-icons my-4">
                <a href="https://www.facebook.com/hzaod" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
                <a href="#"><i class="fab fa-discord"></i></a>
            </div>
            <p class="copyright" data-lang-key="copyright">&copy; 2025 Angels Of Death | Crafted with  by AKK</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ... (Language switcher, scroll animations, etc. - အရင်အတိုင်း) ...
            const translations = {
                en: {
                    navHome: 'Home',
                    navAbout: 'About',
                    navTeams: 'Teams',
                    navTournament: 'Tournament',
                    navSponsors: 'Sponsors',
                    navContact: 'Contact',
                    navLogin: 'Login',
                    navLang: 'Language',
                    heroSubtitle: 'FEAR THE WINGS',
                    heroButton: 'Explore Our Teams',
                    aboutTitle: 'WHO WE ARE',
                    aboutText: `ANGELS OF DEATH (AOD) Esports is a premier esports organization based in Myanmar, founded in 2018. Our mission is to dominate the digital battlefield. We're dedicated to competing at the highest level, fostering new talent, and building a passionate community of gamers and fans. Join us as we strive for victory and redefine what it means to be a champion in the world of esports.`,
                    aboutButton: 'Contact our team',
                    teamsTitle: 'OUR ROSTERS',
                    pubgDesc: 'Dominating the battlegrounds with precision shooting and tactical rotations.',
                    viewRosterBtn: 'View Roster',
                    sponsorsTitle: 'OUR PARTNERS',
                    footerText: 'Follow us on our journey to the top!',
                    copyright: '&copy; 2025 Angels Of Death | Crafted with  by AKK'
                },
                mm: {
                    navHome: 'ပင်မစာမျက်နှာ',
                    navAbout: 'ကျွန်ုပ်တို့အကြောင်း',
                    navTeams: 'အသင်းများ',
                    navTournament: 'ပြိုင်ပွဲများ',
                    navSponsors: 'ပံ့ပိုးကူညီသူများ',
                    navContact: 'ဆက်သွယ်ရန်',
                    navLogin: 'ဝင်ရောက်ရန်',
                    navLang: 'ဘာသာစကား',
                    heroSubtitle: 'အတောင်ပံများကို ကြောက်ရွံ့လိုက်ပါ',
                    heroButton: 'ကျွန်ုပ်တို့အသင်းများကို ကြည့်ရှုပါ',
                    aboutTitle: 'ကျွန်ုပ်တို့အကြောင်း',
                    aboutText: 'ANGELS OF DEATH (AOD) Esports ဆိုတာ ၂၀၁၈ ခုနှစ်မှာ စတင်တည်ထောင်ခဲ့တဲ့ မြန်မာနိုင်ငံအခြေစိုက် ထိပ်တန်း Esports အဖွဲ့အစည်းတစ်ခု ဖြစ်ပါတယ်။ ကျွန်တော်တို့ရဲ့ အဓိကရည်မှန်းချက်ကတော့ ဒစ်ဂျစ်တယ်စစ်မြေပြင်ကို လွှမ်းမိုးစိုးမိုးထားဖို့ပါပဲ။ကျွန်တော်တို့ဟာ အမြင့်ဆုံးအဆင့် ပြိုင်ပွဲတွေမှာ ပါဝင်ယှဉ်ပြိုင်ဖို့၊ အရည်အချင်းရှိတဲ့ မျိုးဆက်သစ်တွေကို မြေတောင်မြှောက်ပေးဖို့နဲ့ ဂိမ်းကစားသူတွေ၊ ပရိသတ်တွေအတွက် ခိုင်မာအားကောင်းတဲ့ Community တစ်ခု တည်ဆောက်ပေးဖို့ကို အစဉ်တစိုက် ကြိုးပမ်းနေပါတယ်။Esports လောကရဲ့ ချန်ပီယံဆိုတဲ့ အဓိပ္ပာယ်ကို အသစ်ပြန်လည်ရေးထိုးပြီး အောင်ပွဲတွေဆီချီတက်မယ့် ကျွန်တော်တို့ရဲ့ ခရီးလမ်းမှာ အတူတူလိုက်ပါခဲ့ဖို့ ဖိတ်ခေါ်လိုက်ပါတယ်။',
                    aboutButton: 'ကျွန်ုပ်တို့၏အဖွဲ့ကို ဆက်သွယ်ပါ။',
                    teamsTitle: 'ကျွန်ုပ်တို့၏ အသင်းသားများ',
                    pubgDesc: 'တိကျသောပစ်ခတ်မှုနှင့် နည်းဗျူဟာကျသော လှည့်ပတ်မှုများဖြင့် စစ်မြေပြင်ကို စိုးမိုးထားသည်။',
                    viewRosterBtn: 'ကစားသမားများကြည့်ရန်',
                    sponsorsTitle: 'ကျွန်ုပ်တို့၏ မိတ်ဖက်များ',
                    footerText: 'ကျွန်တော်တို့ရဲ့ ထိပ်ဆုံးရောက်ဖို့ ခရီးစဉ်ကို အားပေးစောင့်ကြည့်လိုက်ပါ။',
                    copyright: '&copy; 2025 Angels Of Death. အခွင့်အရေးများအားလုံး ကန့်သတ်ထားသည်။'
                }
            };
            
            const switchLanguage = (lang) => {
                document.querySelectorAll('[data-lang-key]').forEach(element => {
                    const key = element.getAttribute('data-lang-key');
                    if (translations[lang] && translations[lang][key]) {
                        element.innerHTML = translations[lang][key];
                    }
                });
                localStorage.setItem('language', lang);
                document.querySelectorAll('.lang-switcher').forEach(switcher => {
                    if (switcher.getAttribute('data-lang') === lang) {
                        switcher.classList.add('active');
                    } else {
                        switcher.classList.remove('active');
                    }
                });
            };

            document.querySelectorAll('.lang-switcher').forEach(switcher => {
                switcher.addEventListener('click', (e) => {
                    e.preventDefault();
                    const selectedLang = switcher.getAttribute('data-lang');
                    switchLanguage(selectedLang);
                });
            });

            const savedLang = localStorage.getItem('language') || 'en';
            switchLanguage(savedLang);

            const handleNavbarScroll = () => {
                const navbar = document.querySelector('.navbar');
                if (navbar && window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else if (navbar) {
                    navbar.classList.remove('scrolled');
                }
            };

            const setupSmoothScroll = () => {
                document.querySelectorAll('a.nav-link[href^="#"], a.btn[href^="#"], a.scroll-down[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        e.preventDefault();
                        const targetElement = document.querySelector(this.getAttribute('href'));
                        if (targetElement) {
                            targetElement.scrollIntoView({ behavior: 'smooth' });
                        }
                    });
                });
            };
            
            const setupScrollAnimations = () => {
                const sections = document.querySelectorAll('.fade-in-section');
                const options = { threshold: 0.15, rootMargin: '0px' };
                const observer = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) return;
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    });
                }, options);
                sections.forEach(section => { observer.observe(section); });
            };

            handleNavbarScroll();
            window.addEventListener('scroll', handleNavbarScroll);
            setupSmoothScroll();
            setupScrollAnimations();
        });
    </script>
</body>
</html>