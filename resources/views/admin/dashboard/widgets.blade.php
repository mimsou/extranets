<div class="container-fluid pull-up">
    <div class="row">
        <div class="col-md-3 m-b-30">
            @include('admin.dashboard._card',['title'=>'EIMT Envoyées','count'=>$counts['emit'],'icon'=>'mdi-alpha-e-box','percent'=>$counts['emit_percent']])
        </div>
        <div class="col-md-3 m-b-30">
            @include('admin.dashboard._card',['title'=>'EIMT Approuvées','count'=>$counts['emit_approved'],'icon'=>'mdi-alpha-a-box','percent'=>$counts['emit_approved_percent']])
        </div>
        <div class="col-md-3 m-b-30">
            @include('admin.dashboard._card',['title'=>'DST Envoyées','count'=>$counts['dst_count'],'icon'=>'mdi-alpha-d-box','percent'=>$counts['dst_percent']])
        </div>
        <div class="col-md-3 m-b-30">
            @include('admin.dashboard._card',['title'=>'DST Approuvées','count'=>$counts['dst_approved_cont'],'icon'=>'mdi-alpha-a-box','percent'=>$counts['dst_approved_percent']])
        </div>
        <div class="col-md-3 m-b-30">
            @include('admin.dashboard._card',['title'=>'PT Envoyées','count'=>$counts['pt_sent'],'icon'=>'mdi-alpha-p-box','percent'=>$counts['pt_sent_percent']])
        </div>
        <div class="col-md-3 m-b-30">
            @include('admin.dashboard._card',['title'=>'PT Reçues','count'=>$counts['pt_received'],'icon'=>'mdi-alpha-p-box','percent'=>$counts['pt_received_percent']])
        </div>
        <div class="col-md-3 m-b-30">
            @include('admin.dashboard._card',['title'=>'Projets terminés','count'=>$counts['project_complete'],'icon'=>'mdi-alpha-c-box','percent'=>$counts['project_complete_percent']])
        </div>
        <div class="col-md-3 m-b-30">
            @include('admin.dashboard._card',['title'=>'Sélection de travailleur','count'=>$counts['date_selection'],'icon'=>'mdi-alpha-t-box','percent'=>$counts['date_selection_percent']])
        </div>
    </div>

    <div class="row ">
        <div class="col-md-12 mb-5 text-center">
            <small class=" px-4">Comparaisons basées sur la différence entre le <strong>{{ $counts['date_from'] }} au {{ $counts['date_to'] }}</strong> et le <strong>{{ $counts['date_compare_from'] }} au {{ $counts['date_compare_to'] }}</strong></small>
        </div>
    </div>
</div>
