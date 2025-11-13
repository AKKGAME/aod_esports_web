@extends('layouts.public')

@section('title', $pageTitle . ' - Angels Of Death')

@section('content')

        <section class="roster-hero fade-in-section">
            <div class="container text-center">
                <h1 class="roster-hero-title">MEET OUR SQUADS</h1>
                <p class="roster-hero-subtitle">The talent, the passion, and the force behind our victories.</p>
            </div>
        </section>
        
        <section class="team-section fade-in-section is-visible" id="pubg">
            <div class="container">
                <div class="team-header">
                    <h2 class="section-title">{{ $pageTitle }}</h2>
                </div>
                
                <div class="row g-4">
                    
                    @forelse ($allMembers as $member)
                        <div class="col-lg-3 col-md-6 col-12"> 
                            
                            <a href="{{ route('public.player.profile', ['player' => $member->ign]) }}" class="player-card" style="text-decoration: none; display: block; height: 100%;">
                                
                                <div class="player-card-inner"> 
                                    <img src="https://s3.us-east-005.backblazeb2.com/ovtvmain/Upload%2FAOD%2FLogo%20PNG%2FAOD%20PNG.png" alt="AOD Logo" class="player-card-logo">
                                    <div class="player-card-img-container">
                                        <img src="{{ $member->photo_url ?? asset('img/default-player.png') }}" alt="{{ $member->ign ?? 'Member' }}" class="player-card-img">
                                        <div class="player-role">{{ $member->status == 'Player' ? $member->role : $member->status }}</div>
                                    </div>
                                    <div class="player-card-body">
                                        <h3 class="player-name">
                                            <span>{{ $member->ign ?? 'Unknown' }}</span>
                                            @if ($member->country_code)
                                                <img src="https://flagcdn.com/w40/{{ strtolower($member->country_code) }}.png" alt="{{ $member->country_code }} Flag" class="player-flag">
                                            @endif
                                        </h3>
                                        @if ($member->real_name)
                                            <p class="player-real-name">
                                                <i class="fas fa-user-circle"></i>
                                                <span>{{ $member->real_name }}</span>
                                            </p>
                                        @else
                                            <p class="player-real-name"></p> 
                                        @endif

                                        <div class="player-socials text-center mt-auto border-top border-secondary pt-3">
                                            <span class="btn btn-sm btn-outline-custom" data-lang-key="viewRosterBtn" style="width: 100%;">
                                                View Profile
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a> 
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center fs-4 text-white-50">No members found for this team roster.</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="team-achievements mt-5 mb-5">
                    <h4 class="achievements-title">{{ $team->name }} Achievements</h4>
                    <ul>
                        <li><i class="fas fa-trophy"></i> 2025 MPL MM Season 4 - Champion</li>
                        <li><i class="fas fa-trophy"></i> 2024 Myanmar Gaming Festival - 1st Runner Up</li>
                    </ul>
                </div>
            </div>
        </section>


@endsection