<?
    $ident = (isset($ident))? $ident: 'default';
    $title = (isset($title))? $title: __('Are you sure?');
    $text = (isset($text))? $text: __('Action will delete all of your devices');
    $controller = (isset($controller))? $controller: '#';
    $redirect = (isset($redirect))? $redirect: '';
?>

<div class="modal fade"   id="modalConfirmation_{{ $ident }}" data-backdrop="static"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ $controller }}">
                @csrf

                <input type="hidden" name="redirect_to" value="{{ $redirect }}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="modal-body">
                    <div class="px-3 pt-3 text-center">
                        <div class="event-type warning">
                            <div class="event-indicator ">
                                <i class="mdi mdi-exclamation text-white" style="font-size: 60px"></i>
                            </div>
                        </div>
                        <h3 class="pt-3">{!! $title !!}</h3>
                        <p class="text-muted">
                            {!! $text !!}
                        </p>

                    </div>
                    <div class="hiddenfields"></div>
                </div>
                <div class="modal-footer ">
                    <button class="btn btn-primary" type="submit">Okay</button>
                    <a href="#" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancel</a>
                </div>

            </form>
        </div>

    </div>
</div>
