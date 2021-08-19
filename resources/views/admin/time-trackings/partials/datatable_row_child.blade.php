<table cellpadding="1" cellspacing="0" border="0" width="100%" style="m-r-40">
    <tr>
        <td style="padding: 5px">
            <table width="100%" class="child-row-table">
                <thead>
                    <tr>
                        <th style="padding: 5px">&nbsp;</th>
                        <th style="padding: 5px">Utilisateur</th>
                        <th style="padding: 5px">Total</th>
                        @if(1===1)
                            <th style="padding: 5px">Type de tâche</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @foreach($projet->time_records as $tr)
                <tr>
                    <td width="40px">&nbsp;</td>
                    <td width="220px">{!! $tr->user->fullname !!}: </td>
                    <td>{!! \App\Classes\Utils\Tools\TimeTools::floatToHours($tr->total_hours) !!}</td>
                    @if(1===1)
                        <td>TODO Type de tâche to fill</td>
                    @endif
                </tr>
                @endforeach
                </tbody>
            </table>
        </td>
    </tr>
</table>