@component('mail::message')
La demande du projet **#{{ $modelToUpdate->projet()->first()->numero }}** a été modifiée.

@foreach($fieldsToUpdate as $field_name => $field_value)
- **{{ ucwords(str_replace('_',' ',$field_name)) }}** a été mise à jour (changé pour **{{ $field_value }}**)
@endforeach
@component('mail::button', ['url' => action('ProjetController@edit', $modelToUpdate->projet_id)])
Accéder à la demande
@endcomponent

{{ config('app.name') }}
@endcomponent
