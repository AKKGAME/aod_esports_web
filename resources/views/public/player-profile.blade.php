@extends('layouts.public')

@section('title', $player->ign . ' - Player Profile')

@section('content')

    <section class="roster-hero fade-in-section">
        <div class="container text-center">
            <h1 class="roster-hero-title">{{ $player->ign }}</h1>
            
            @if ($player->real_name)
                <p class="roster-hero-subtitle" style="text-shadow: 0 0 10px rgba(0,0,0,0.5);">
                    {{ $player->real_name }}
                </p>
            @endif
        </div>
    </section>

    <section id="profile-details" class="roster-section py-5 fade-in-section">
        <div class="container">
            
            <div class="row g-4 g-md-5 justify-content-center">

                <div class="col-12 col-md-6 col-lg-5">
                    <div class="player-card">
                        <div class="player-card-inner"> 
                            <img src="{{ asset('https://s3.us-east-005.backblazeb2.com/ovtvmain/Upload%2FAOD%2FLogo%20PNG%2FAOD%20PNG.png') }}" alt="AOD Logo" class="player-card-logo">
                            <div class="player-card-img-container">
                                <img src="{{ $player->photo_url ?? asset('img/default-player.png') }}" alt="{{ $player->ign }}" class="player-card-img">
                                <div class="player-role">{{ $player->status == 'Player' ? $player->role : $player->status }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-7">
                    
                    <h2 class="section-title mb-4 text-center text-md-start">PLAYER DETAILS</h2>

                    <div class="row g-3 mb-4 fs-5">
                        <div class="col-md-6">
                            <strong style="font-size: 0.9rem; text-transform: uppercase; color: #adb5bd;">Team</strong>
                            <span class="d-block fw-bold fs-4">{{ $player->team->name ?? 'Free Agent' }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong style="font-size: 0.9rem; text-transform: uppercase; color: #adb5bd;">Country</strong>
                            <span class="d-block fw-bold fs-4 d-flex align-items-center">
                                @if ($player->country_code)
                                    <img src="https://flagcdn.com/w40/{{ strtolower($player->country_code) }}.png" alt="{{ $player->country_code }}" class="player-flag me-2" style="width: 30px;">
                                @endif
                                {{ $player->country_code ?? 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <h4 style="color: var(--primary-color);">Biography</h4>
                    <p class="text-white-50" style="line-height: 1.7;">
                        {{ $player->bio ?? 'No biography available for this player.' }}
                    </p>
                    
                    <h4 class="mt-5" style="color: var(--primary-color);">Follow On Social</h4>
                    <div class="player-socials text-start mt-3" style="font-size: 1.5rem;">
                        @if ($player->facebook_url && $player->facebook_url !== '#')
                            <a href="{{ $player->facebook_url }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if ($player->youtube_url && $player->youtube_url !== '#')
                            <a href="{{ $player->youtube_url }}" target="_blank"><i class="fab fa-youtube"></i></a>
                        @endif
                        @if ($player->tiktok_url && $player->tiktok_url !== '#')
                            <a href="{{ $player->tiktok_url }}" target="_blank"><i class="fab fa-tiktok"></i></a>
                        @endif
                        
                        @if (empty($player->facebook_url) && empty($player->youtube_url) && empty($player->tiktok_url))
                            <p class="text-white-50 fst-italic">No social media links provided.</p>
                        @endif
                    </div>
                    
                    <div class="text-start mt-5">
                        <a href="{{ route('public.roster', ['team' => $player->team_id]) }}" class="btn btn-secondary-custom">&larr; Back to Roster</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection