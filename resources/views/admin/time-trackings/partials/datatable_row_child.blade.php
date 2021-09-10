<table cellpadding="1" cellspacing="0" border="0" width="100%" style="m-r-40">
    <tr>
        <td style="padding: 5px">
            <table width="100%" class="child-row-table">
                <thead>
                    <tr>
                        <th style="padding: 5px">&nbsp;</th>
                        <th style="padding: 5px">Utilisateur</th>
                        <th style="padding: 5px">Total</th>
                        @if($has_task_type === true)
                            <th style="padding: 5px">Type de tâche - {!! __($task_type) !!}</th>
                        @else
                            <th style="padding: 5px">&nbsp;</th>
                        @endif
                        <th style="padding: 5px;padding-right:40px;text-align: right">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($projet->time_records as $tr)
                <tr>
                    <td width="40px">&nbsp;</td>
                    <td width="220px" class="align-middle">{!! $tr->user->fullname !!}</td>
                    <td class="align-middle">{!! \App\Classes\Utils\Tools\TimeTools::floatToHours($tr->total_hours) !!}</td>
                    @if($has_task_type === true)
                        <td class="align-middle" style="max-width: 100%">{!! \App\Classes\Utils\Tools\TimeTools::floatToHours($tr->total_for_task_type_selected) !!}</td>
                    @else
                        <td style="max-width: 100%">&nbsp;</td>
                    @endif
                    <td class="align-middle" style="padding: 5px;padding-right:40px;text-align: right">
                        <button type="button" class="btn btn-warning btn-sm"
                                data-toggle="modal"
                                data-user-id="{!! $tr->user->id !!}"
                                data-projet-id="{!! $projet->id !!}"
                                data-target="#timeTrackingDetails">
                            <i class="fas fa-business-time "></i>&nbsp;Détails
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </td>
    </tr>
</table>