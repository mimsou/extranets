<?php

namespace App\Console\Commands;

use App\Models\Todo;
use App\Models\TodoGroup;
use Illuminate\Console\Command;

class CreateDefaultGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:default-group';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To create default group for todos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $todos = Todo::where(['group_id'=>0])->get();
        foreach($todos as $key => $todo){
            $isGroupExist = TodoGroup::where(['projet_id'=>$todo->projet_id,'demande_id'=>$todo->demande_id,'group_name'=>'Titre de la liste'])->first();
            if($isGroupExist == null){
                $createDefaultGroup = new TodoGroup;
                $createDefaultGroup->group_name = 'Titre de la liste';
                $createDefaultGroup->status = 1;
                $createDefaultGroup->demande_id = $todo->demande_id;
                $createDefaultGroup->projet_id = $todo->projet_id;
                $createDefaultGroup->sort_order = 0;
                $createDefaultGroup->save();
                $todo->group_id = $createDefaultGroup->id;
            }else{
                $todo->group_id = $isGroupExist->id;
            }
            $todo->save();
        }
    }
}
