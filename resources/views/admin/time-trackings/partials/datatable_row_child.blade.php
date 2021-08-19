<table cellpadding="1" cellspacing="0" border="0" width="100%" class="m-l-40">
    <tr>
        <td>
            <table width="100%" class="child-row-table">
                @foreach($projet->time_records as $tr)
                <tr>
                    <td width="220px">{!! $tr->user->fullname !!}: </td>
                    <td>{!! \App\Classes\Utils\Tools\TimeTools::floatToHours($tr->total_hours) !!} h.</td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>