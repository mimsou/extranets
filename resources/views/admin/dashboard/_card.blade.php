{{--<div class="card ">--}}
{{--    <div class="text-center card-body">--}}
{{--        <div class="text-success">--}}
{{--            <div class="avatar avatar-sm ">--}}
{{--                <span class="avatar-title rounded-circle badge-soft-success">--}}
{{--                    <i class="mdi {{ $icon }} mdi-18px"></i>--}}
{{--                </span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class=" text-center">--}}
{{--            <h3>{{ $count }}</h3>--}}
{{--        </div>--}}
{{--        <div class="text-overline ">--}}
{{--            {{ $title }}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="card m-t-30">
    <div class="card-body">
        <div class="row">
            <div class="col my-auto">
                <div class="h6 text-muted ">{{ $title }}</div>
            </div>

            <div class="col-auto my-auto">
                <div class="avatar">
                    <div class="avatar-title rounded-circle bg-dark"><i class="mdi {{ $icon }}"></i></div>

                </div>
            </div>
        </div>
        <h1 class="display-4 fw-600">{{ $count }}</h1>
        <div class="h6">
            @if($percent < 0)
                <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> {{ number_format(abs($percent),2) }}% </span>
            @else
                <span class="text-success"> <i class="mdi mdi-arrow-top-right"></i> {{ number_format(abs($percent),2) }}% </span>
            @endif
            Less activity than usual.
        </div>
    </div>
</div>
