@component('mail::message')
Bonjour {{ $user_assigned->firstname }},

{{ $assigner_name }} vous a assigné à la demande {{ $project->numero }} du projet {{ $project->titre }}.
@component('mail::button', ['url' => action('ProjetController@edit', $project->id)])
Accéder à la demande
@endcomponent

{{ config('app.name') }}
@endcomponent
