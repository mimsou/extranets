@component('mail::message')
Bonjour {{ $user->firstname }},

Tout **nouvel enregistrement de test** qui vous a été attribué.
@component('mail::button', ['url' => route('verify.token',['token'=>base64_encode($projetId.'-'.$todo->demande_id)])])
Accéder à la demande
@endcomponent

{{ config('app.name') }}
@endcomponent
