<div class="content" id="historique">
    <div class="row">

        @foreach ($candidat->getLogs() as $log)
            <div class="d-flex border-bottom align-items-center p-2" style="width:100%">

                <div class="px-3 py-2 mailbox-name text-muted">
                    {{ $log->user->firstname }} <br>
                    {{ $log->user->lastname }}
                </div>
                <div class="px-3" style="flex-grow: 1;">
                    <div class="">
                        <i>{{ $log->message }}</i>
                    </div>
                </div>

                <div class="mailbox-options">
                    <strong>{{ $log->created_at->diffForHumans() }}</strong> <br>
                    <small>{{ $log->created_at }}</small>
                </div>
            </div>
        @endforeach

    </div>
</div>
