<div class="container-fluid pull-up">
    <div class="row">
        <div class="col m-b-30">
            @include('admin.dashboard._card',['title'=>'EIMT','count'=>$counts['emit'],'icon'=>'mdi-alpha-e-box'])
        </div>
        <div class="col m-b-30">
            @include('admin.dashboard._card',['title'=>'Approved EIMT','count'=>$counts['emit_approved'],'icon'=>'mdi-alpha-a-box'])
        </div>
        <div class="col m-b-30">
            @include('admin.dashboard._card',['title'=>'DST sent','count'=>$counts['dst_count'],'icon'=>'mdi-alpha-d-box'])
        </div>
        <div class="col m-b-30">
            @include('admin.dashboard._card',['title'=>'Approved DST','count'=>$counts['dst_approved_cont'],'icon'=>'mdi-alpha-a-box'])
        </div>
        <div class="col d-lg-block d-none m-b-30">
            @include('admin.dashboard._card',['title'=>'PT sent','count'=>$counts['pt_sent'],'icon'=>'mdi-alpha-p-box'])
        </div>
        <div class="col d-lg-block d-none m-b-30">
            @include('admin.dashboard._card',['title'=>'PT received','count'=>$counts['pt_received'],'icon'=>'mdi-alpha-p-box'])
        </div>
        <div class="col d-lg-block d-none m-b-30">
            @include('admin.dashboard._card',['title'=>'Projet Completed','count'=>$counts['project_complete'],'icon'=>'mdi-alpha-c-box'])
        </div>
    </div>
</div>
