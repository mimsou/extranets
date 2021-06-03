@component('mail::message')
Bonjour {{ $user->firstname }},

Tout **nouvel enregistrement de test** qui vous a été attribué.
@component('mail::button', ['url' => action('ProjetController@edit', $projetId)])
Accéder à la demande
@endcomponent

{{ config('app.name') }}
@endcomponent
