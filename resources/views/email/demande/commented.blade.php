@component('mail::message')
Bonjour {{ $user->firstname }},

{{ $loggedInUserName }} à commenté la demande {{ $project->numero }} du projet {{ $project->titre }}.

### Commentaire:
{{ $comment }}
@component('mail::button', ['url' => action('ProjetController@edit', $project->id)])
    Accéder à la demande
@endcomponent

{{ config('app.name') }}
@endcomponent