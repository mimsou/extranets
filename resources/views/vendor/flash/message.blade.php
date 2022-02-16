
<script>
    var notification_template = '<div data-notify="container" class=" bootstrap-notify alert " role="alert">' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar bg-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<div class="media "> <div class="avatar m-r-10 avatar-sm"> <div class="avatar-title bg-{0} rounded-circle"><span data-notify="icon"></span></div> </div>' +
                    '<div class="media-body"><div class="font-secondary" data-notify="title">{1}</div> ' +
                    '<span class="opacity-75" data-notify="message">{2}</span></div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    ' <button type="button" aria-hidden="true" class="close" data-notify="dismiss"><span>x</span></button></div></div>';

    document.addEventListener('DOMContentLoaded', function($){

        @foreach (session('flash_notification', collect())->toArray() as $message)
            @if (!$message['overlay'])
                <?php
                    $icon = 'alert';
                    switch($message['level']){
                        case 'success':
                            $icon = 'check'; break;
                    }

                    $flash_message = $message['message'];
                    if($errors->any()){
                        $flash_message .= '<ul>';
                        foreach ($errors->all() as $msg) {
                            $flash_message .= "<li>".$msg."</li>";
                        }
                        $flash_message .= '</ul>';
                    }
                ?>
                jQuery.notify({
                    // options
                    icon: 'mdi mdi-{{ $icon }}',
                    title: "{{ ucfirst($message['level']) }}",
                    message: "{!! $flash_message !!}"
                }, {
                    placement: {
                        align: "center",
                        from: "top"
                    },
                    showProgressbar: true,
                    timer: 120,
                    // settings
                    type: '{{ $message['level'] }}',
                    template: notification_template
                });
            @endif
        @endforeach

    }, false);

</script>



@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
