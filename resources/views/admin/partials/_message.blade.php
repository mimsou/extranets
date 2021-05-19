<div class="message {{ (isMineMessage($n->user_id))?'mine':'' }}">
    <div class="profil">
        <div class="avatar avatar-sm">
            <span class="avatar-title rounded-circle bg-dark">{{$n->user->initials()}}</span>
        </div>
    </div>

    <div class="content">
        <div class="username">{{$n->user->firstname}} {{$n->user->lastname}}</div>
        @if(isset($p) && (isMineMessage($n->user_id) || Auth::user()->role_lvl == 10))
            <span class="fa fa-ellipsis-v {{ (!isMineMessage($n->user_id))?'action-menu-left':'action-menu' }}" data-container="body" data-toggle="popover" data-placement="top"
              data-content="<a href='{{ route('delete.comment',['demande_id'=>$p->id,'comment_id'=>$n->id]) }}' class='btn btn-default btn-xs'>Remove</a>" style="display: none"></span>
        @endif
        <div class="message-bubble">
            <?php
                $url = '@(http(s)?)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
                $message = preg_replace($url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $n->message);
            ?>
            <p style="white-space: pre-line">{!!$message!!}</p>
        </div>
        <div class="moment">{{ $n->created_at->format('j-m-Y @ H:i') }}</div>
    </div>
</div>
