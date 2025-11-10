@extends('layouts.public')

@section('title', 'Angels Of Death - Home')

@section('content')

    <section id="hero" class="hero">
        <div class="hero-content">
            <img src="{{ asset('https://s3.us-east-005.backblazeb2.com/ovtvmain/Upload%2FAOD%2FLogo%20PNG%2FAOD%20PNG.png') }}" alt="AOD Logo" class="hero-logo">
            <h1 class="hero-title">ANGELS OF DEATH</h1>
            <h2 class="hero-subtitle" data-lang-key="heroSubtitle">FEAR THE WINGS</h2> 
            <a href="#teams" class="btn btn-primary-custom mt-3" data-lang-key="heroButton">Explore Our Teams</a>
        </div>
        <a href="#about" class="scroll-down">
            <i class="fa-solid fa-chevron-down"></i>
        </a>
    </section>

    <section id="about" class="about-section py-5 fade-in-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title" data-lang-key="aboutTitle">WHO WE ARE</h2>
                    <p data-lang-key="aboutText">ANGELS OF DEATH (AOD) Esports is a premier esports organization based in Myanmar, founded in 2018. Our mission is to dominate the digital battlefield. We're dedicated to competing at the highest level, fostering new talent, and building a passionate community of gamers and fans. Join us as we strive for victory and redefine what it means to be a champion in the world of esports.</p>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('https://s3.us-east-005.backblazeb2.com/ovtvmain/Upload%2FAOD%2FLogo%20PNG%2FAOD%20PNG.png') }}" alt="About AOD" class="img-fluid about-logo">
                </div>
            </div>
        </div>
    </section>

    <section id="teams" class="teams-section py-5 fade-in-section">
        <div class="container">
            <h2 class="section-title text-center mb-5" data-lang-key="teamsTitle">OUR ROSTERS</h2>
            
            <div class="row g-4 justify-content-center">
                @forelse ($teams as $team)
                    <div class="col-md-4">
                        <div class="team-card h-100">
                            <img src="{{ $team->logo_url ?? 'https://s3.us-east-005.backblazeb2.com/ovtvmain/Upload%2FAOD%2Froster.png' }}" alt="{{ $team->name }} Team" class="team-card-img">
                            <div class="team-card-body d-flex flex-column">
                                <h3 class="team-card-title">{{ $team->name }}</h3>
                                <p class="team-card-text flex-grow-1">{{ $team->description ?? 'Our elite team.' }}</p>
                                
                                <a href="{{ route('public.roster', ['team' => $team->id]) }}" class="btn btn-sm btn-outline-custom" data-lang-key="viewRosterBtn">View Roster</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">No teams found.</p>
                    </div>
                @endforelse
            </div>
            
        </div>
    </section>

    <section id="sponsors" class="sponsors-section py-5 fade-in-section">
        <div class="container">
            <h2 class="section-title text-center mb-5" data-lang-key="sponsorsTitle">OUR PARTNERS</h2>
            
            @if ($groupedSponsors->has('Title Partner'))
                <h4 class="sponsor-level-title">Title Partner</h4>
                <div class="row g-4 justify-content-center mb-5">
                    @foreach ($groupedSponsors['Title Partner'] as $sponsor)
                        <div class="col-lg-6 col-md-8"> <a href="{{ $sponsor->website_url ?? '#' }}" target="_blank" class="text-decoration-none">
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

            @if ($groupedSponsors->has('Official Partner'))
                <h4 class="sponsor-level-title">Official Partners</h4>
                <div class="row g-4 justify-content-center mb-5">
                    @foreach ($groupedSponsors['Official Partner'] as $sponsor)
                        <div class="col-lg-4 col-md-6"> <a href="{{ $sponsor->website_url ?? '#' }}" target="_blank" class="text-decoration-none">
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
                // ကျန်တဲ့ level တွေကို စုစည်းလိုက်ပါ
                $otherSponsors = collect()
                    ->merge($groupedSponsors['Partner'] ?? [])
                    ->merge($groupedSponsors['Supporter'] ?? []);
            @endphp

            @if ($otherSponsors->isNotEmpty())
                <h4 class="sponsor-level-title">Partners & Supporters</h4>
                <div class="row g-4 justify-content-center">
                    @foreach ($otherSponsors as $sponsor)
                        <div class="col-lg-3 col-md-4 col-sm-6"> <a href="{{ $sponsor->website_url ?? '#' }}" target="_blank" class="text-decoration-none">
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

@endsection