<table cellpadding="1" cellspacing="0" border="0" width="100%">
    <tr>
        <td>
            <table width="100%" class="child-row-table">
                @foreach($projet->time_records as $tr)
                <tr>
{{--                    <td>{!! json_encode($tr) !!}</td>--}}
                    <td>{!! $tr->user->fullname !!}: {!! \App\Classes\Utils\Tools\TimeTools::floatToHours($tr->total_hours) !!} heures</td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>