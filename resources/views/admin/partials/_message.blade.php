<div class="message {{ ($n->user_id == Auth::user()->id)?'mine':'' }}">
    <div class="profil">
        <div class="avatar avatar-sm">
            <span class="avatar-title rounded-circle bg-dark">{{$n->user->initials()}}</span>
        </div>
    </div>

    <div class="content">
        <div class="username">{{$n->user->firstname}} {{$n->user->lastname}}</div>
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
