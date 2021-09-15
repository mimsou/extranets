<a href="#informations" class="mail-sidebar-item active btn-ghost">
    <div class="w-100 text-truncate">
        Information
    </div>
</a>

<a href="#observation" class=" mail-sidebar-item btn-ghost">
    <div class="w-100 text-truncate">
        Observation
    </div>
</a>

<a href="#recrutement" class="mail-sidebar-item btn-ghost">
    <div class="w-100 text-truncate">
        Recrutement
    </div>
</a>


{{-- <a href="#administration" class=" mail-sidebar-item btn-ghost">
    <div class="w-100 text-truncate">
        Administration
    </div>
</a> --}}
{{-- <a href="#bureau" class=" mail-sidebar-item btn-ghost">
    <div class="w-100 text-truncate">
        Bureau à l'étranger
    </div>
</a> --}}

<a href="#immigration" class=" mail-sidebar-item btn-ghost">
    <div class="w-100 text-truncate">
        Immigration
    </div>
</a>

@if(Auth::user()->role_lvl > 3)
    <a href="#accueil" class=" mail-sidebar-item btn-ghost">
        <div class="w-100 text-truncate">
            Accueil
        </div>
    </a>
@endif

{{-- <a href="#resources" class="m-t-20 mail-sidebar-item btn-ghost clearfix border-bottom border-white">
    <div class="w-100 text-truncate">
        Medias
    </div>
</a> --}}


{{-- <a href="#commentaires" class="m-t-20 mail-sidebar-item btn-ghost clearfix border-bottom border-white">
    <div class="w-100 text-truncate">
        Commentaires
    </div>
</a> --}}

@if(Auth::user()->role_lvl > 3)
    <a href="#historique" class="m-t-20 mail-sidebar-item btn-ghost clearfix border-top border-white">
        <div class="w-100 text-truncate">
            Historique <span class="badge badge-danger ml-2">{{ count($candidat->getLogs()) }}</span>
        </div>
    </a>
@endif
