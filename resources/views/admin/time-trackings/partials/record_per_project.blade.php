<div class="col-md-12 m-b-30">
    <h4 class="total_duration">Total: {!! $total !!}</h4>
    <div class="table-responsive">
        <table class="table align-td-middle table-card">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Date</th>
                <th>Durée</th>
                <th>Type</th>
            </tr>
            </thead>
            <tbody>
            @forelse($time_record_datas as $time_record_data)
                <tr title="{!! $time_record_data['description'] !!}">
                    <td>{!! $time_record_data['name'] !!}</td>
                    <td>{!! $time_record_data['date'] !!}</td>
                    <td>{!! $time_record_data['duration'] !!}</td>
                    <td>{!! $time_record_data['type'] !!}</td>
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