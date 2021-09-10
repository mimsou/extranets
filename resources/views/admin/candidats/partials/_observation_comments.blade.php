@forelse ($comments as $item)
    <div class="list-group-item d-flex  align-items-center">
        <div class="m-r-20">
            <div class="avatar avatar-sm ">
                <div class="avatar-title rounded-circle bg-dark">{!! substr($item->creator->firstname, 0, 1).substr($item->creator->lastname, 0, 1) !!}</div>
            </div>
        </div>
        <div class="">
            <div>{!! $item->creator->fullname !!} <span class="text-muted">{!! $item->created_at->format('d-M-Y h:i A'); !!}</span></div>
            <div class="text-muted">{!! $item->body !!}</div>
        </div>
    </div>
@empty
    <div class="list-group-item d-flex  align-items-center">
        Aucune observation
    </div>
@endforelse
