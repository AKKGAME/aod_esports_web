<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('public.home') }}">
            <img src="{{ asset('https://s3.us-east-005.backblazeb2.com/ovtvmain/Upload%2FAOD%2FLogo%20PNG%2FAOD%20PNG.png') }}" alt="AOD Logo" style="width: 40px;">
            ANGELS OF DEATH
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('public.home') }}#hero" data-lang-key="navHome">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('public.home') }}#about" data-lang-key="navAbout">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('public.home') }}#teams" data-lang-key="navTeams">Teams</a></li>
                
                <li class="nav-item"><a class="nav-link" href="#" data-lang-key="navTournament">Tournament</a></li>
                
                <li class="nav-item"><a class="nav-link" href="{{ route('public.home') }}#sponsors" data-lang-key="navSponsors">Sponsors</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact" data-lang-key="navContact">Contact</a></li>

                <li class="nav-item ms-lg-3">
                    <a class="btn btn-sm btn-outline-custom" href="/admin" data-lang-key="navLogin">Login</a>
                </li>
                
                <li class="nav-item dropdown ms-lg-2">
                     <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-lang-key="navLang">
                         Language
                     </a>
                     <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="languageDropdown">
                         <li><a class="dropdown-item lang-switcher" href="#" data-lang="en">English</a></li>
                         <li><a class="dropdown-item lang-switcher" href="#" data-lang="mm">မြန်မာ</a></li>
                     </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>