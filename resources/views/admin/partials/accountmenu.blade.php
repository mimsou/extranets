    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#"   role="button" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <div class="avatar avatar-sm avatar-online">
                <span class="avatar-title rounded-circle bg-dark">{{ Auth::user()->initials() }}</span>

            </div>
        </a>
        <div class="dropdown-menu  dropdown-menu-right"   >
            {{-- <a class="dropdown-item" href="{{ route('password.request') }}">  Reset Password</a> --}}
            <a class="dropdown-item" href="{{ route('profile.show') }}">  {{ __('Votre profil') }}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Déconnexion') }}</a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	        @csrf
	    </form>
    </li>

