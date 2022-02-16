@php
    $class = "link";
    if(Str::contains($projet->statut, 'imm_')) $class = "danger";
    if(Str::contains($projet->statut, 'rec_')) $class = "secondary";
    if(Str::contains($projet->statut, 'acc_')) $class = "success";
@endphp

<div class="col-md-12 m-b-30">
    <h2 class="total_duration"><small><i class="fas fa-user mr-2"></i></small> {!! $user->fullname !!}</h2>
    <div><a href="{{ action('ProjetController@edit', $projet->id) }}" target="blank" class="mr-3 btn btn-sm btn-{{ $class }}">{!! $projet->numero !!}</a> {!! $projet->titre !!}</div>
    <h4 class="total_duration mt-4">Total: {!! $total !!}</h4>
    <div class="table-responsive">
        <table class="table align-td-middle table-card">
            <thead>
            <tr>
                   <th>Type de tâche</th>
                   <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @forelse($time_record_by_task_type as $key => $tr_by_task_type)
                <tr">
                    <td>{!! __($key) !!}</td>
                    <td>{!! \App\Classes\Utils\Tools\TimeTools::floatToHours($tr_by_task_type->sum()) !!}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center">Aucun</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <table class="table align-td-middle table-card">
            <thead>
            <tr>
                <th>Date</th>
                <th>Durée</th>
                <th>Type de tâche</th>
            </tr>
            </thead>
            <tbody>
            @forelse($time_record_datas as $time_record_data)
                <tr title="{!! $time_record_data['description'] !!}">
                    <td>{!! $time_record_data['date'] !!}</td>
                    <td>{!! $time_record_data['duration'] !!}</td>
                    <td>{!! __($time_record_data['type']) !!}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center">Aucun</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
