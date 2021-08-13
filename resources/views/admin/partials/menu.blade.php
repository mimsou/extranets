@if(Auth::user()->role_lvl > 3)
    <li class="menu-item {{ classActivePath(route('dashboard.details')) }}">
        <a href="{{ route('dashboard.details') }}" class="menu-link">
            <span class="menu-label">
                <span class="menu-name">{{ __('Tableau de bord') }}</span>
            </span>

            <span class="menu-icon">
                {{-- <span class="icon-badge badge-success badge badge-pill">NEW</span> --}}
                <i class="icon-placeholder mdi mdi-desktop-mac-dashboard"></i>
            </span>
        </a>
    </li>
@endif
@if(Auth::user()->role_lvl > 3)
    <li class="menu-item {{ classActivePath(route('dashboard')) }}">
        <a href="{{ route('dashboard') }}" class="menu-link">
            <span class="menu-label">
                <span class="menu-name">{{ __('Nos bons coups') }}</span>
            </span>

            <span class="menu-icon">
                {{-- <span class="icon-badge badge-success badge badge-pill">NEW</span> --}}
                <i class="icon-placeholder mdi mdi-airplay"></i>
            </span>
        </a>
    </li>
@endif

@if(Auth::user()->role_lvl > 3 || Auth::user()->role_lvl == 2)
    <li class="menu-item {{ classActiveSegment(2,'employeurs') }}">
        <a href="{{ action('EmployeurController@index') }}" class="menu-link">
            <span class="menu-label">
                <span class="menu-name">{{ __('Employeurs') }}</span>
            </span>

            <span class="menu-icon">
                {{-- <span class="icon-badge badge-success badge badge-pill">NEW</span> --}}
                <i class="icon-placeholder fas fa-user-tie"></i>
            </span>
        </a>
    </li>
@endif

@if(Auth::user()->role_lvl >= 2)
    <li class="menu-item {{ classActiveSegment(2,'projets') }}">
        <a href="{{ action('ProjetController@index') }}" class="menu-link">
            <span class="menu-label">
                <span class="menu-name">{{ __('Projets') }}</span>
            </span>

            <span class="menu-icon">
                {{-- <span class="icon-badge badge-success badge badge-pill">NEW</span> --}}
                <i class="icon-placeholder far fa-search-location"></i>
            </span>
        </a>
    </li>
@endif

@if(Auth::user()->role_lvl > 3)
    <li class="menu-item {{ classActiveSegment(2,'candidats') }}">
        <a href="{{ action('CandidatController@index') }}" class="menu-link">
            <span class="menu-label">
                <span class="menu-name">{{ __('Candidats') }}</span>
            </span>

            <span class="menu-icon">
                {{-- <span class="icon-badge badge-success badge badge-pill">NEW</span> --}}
                <i class="icon-placeholder fas fa-user-hard-hat"></i>
            </span>
        </a>
    </li>

    <li class="menu-item {{ classActiveSegment(2, 'gestion') }}">
        <a href="#" class="open-dropdown menu-link">
            <span class="menu-label">
                <span class="menu-name">Gestion <span class="menu-arrow"></span></span>
                <span class="menu-info">Options du système</span>
            </span>
            <span class="menu-icon">
                {{-- <span class="icon-badge badge-success badge badge-pill">NEW</span> --}}
                <i class="icon-placeholder fas fa-cog"></i>
            </span>
        </a>

        <!--submenu-->
        <ul class="sub-menu">
            <li class=" menu-item">
                <a href="{{ action('RegroupementController@index') }}" class="{{ classActiveSegment(3,'regroupements') }} menu-link">
                    <span class="menu-label">
                        <span class="menu-name">{{ __('Regroupements') }}</span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder fas fa-users"></i>
                    </span>
                </a>

                <a href="{{ action('EmploiController@index') }}" class="{{ classActiveSegment(3,'emplois') }} menu-link">
                    <span class="menu-label">
                        <span class="menu-name">{{ __('Liste des emplois') }}</span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder fas fa-tools"></i>
                    </span>
                </a>

                <a href="{{ action('PaysController@index') }}" class="{{ classActiveSegment(3,'pays') }} menu-link">
                    <span class="menu-label">
                        <span class="menu-name">{{ __('Liste des pays') }}</span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder fas fa-globe-americas"></i>
                    </span>
                </a>

                <a href="{{ action('UserController@index') }}" class="{{ classActiveSegment(3,'utilisateurs') }} menu-link">
                    <span class="menu-label">
                        <span class="menu-name">{{ __('Utilisateurs') }}</span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder fas fa-user-lock"></i>
                    </span>
                </a>
                <a href="{{ action('TodoController@manageTemplates') }}" class="{{ classActiveSegment(3,'templates') }} menu-link">
                    <span class="menu-label">
                        <span class="menu-name">{{ __('Liste de contrôle') }}</span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder fas fa-clipboard-list"></i>
                    </span>
                </a>
            </li>
        </ul>
    </li>
@endif


{{--
<li class="menu-item {{ classActiveSegment(3, 'utilisateurs') }}">
	<a href="{{ action('Admin\UserController@index') }}" class="menu-link">
		<span class="menu-label">
			<span class="menu-name">{{ __('Utilisateurs') }}</span>
		</span>

		<span class="menu-icon">
			{!! (isThisANewFeature(0.9))? getIsNewFeatureHTML():'' !!}
			<i class="icon-placeholder mdi mdi-account-edit"></i>
		</span>
	</a>
</li> --}}
