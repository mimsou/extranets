<li class="menu-item {{ classActivePath(route('dashboard')) }}">
    <a href="{{ route('dashboard') }}" class="menu-link">
        <span class="menu-label">
            <span class="menu-name">{{ __('Tableau de bord') }}</span>
        </span>

        <span class="menu-icon">
            {{-- <span class="icon-badge badge-success badge badge-pill">NEW</span> --}}
            <i class="icon-placeholder mdi mdi-desktop-mac-dashboard"></i>
        </span>
	</a>
</li>





<li class="menu-item {{ classActiveSegment(2,'regroupements') }}">
    <a href="{{ action('RegroupementController@index') }}" class="menu-link">
        <span class="menu-label">
            <span class="menu-name">{{ __('Regroupements') }}</span>
        </span>

        <span class="menu-icon">
            {{-- <span class="icon-badge badge-success badge badge-pill">NEW</span> --}}
            <i class="icon-placeholder far fa-building"></i>
        </span>
    </a>
</li>


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



<li class="menu-item {{ classActiveSegment(2,'utilisateurs') }}">
    <a href="{{ action('UserController@index') }}" class="menu-link">
        <span class="menu-label">
            <span class="menu-name">{{ __('Utilisateurs') }}</span>
        </span>

        <span class="menu-icon">
            {{-- <span class="icon-badge badge-success badge badge-pill">NEW</span> --}}
            <i class="icon-placeholder fas fa-user-unlock"></i>
        </span>
    </a>
</li>






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
