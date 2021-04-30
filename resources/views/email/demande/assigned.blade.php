@component('mail::message')
Dear {{ $user_assigned->firstname }},

{{ $assigner_name }} vous a assigné à la demande {{ $demande->id }} du projet {{ $project->titre }}.
@component('mail::button', ['url' => action('ProjetController@edit', $project->id)])
Accéder à la demande
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
