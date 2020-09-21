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
