<a href="{{ route('association.users.edit',['assoc_group_id'=>$group_id,'user_id'=>$model->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-user-edit"></i></a>

<a href="javascript:void(0)" class="btn btn-sm btn-danger delete_assoc_user" data-groupid="{{ $group_id }}" data-assocuserid="{{ $model->id }}" data-nom="{{ $group->title }}"><i class="fas fa-trash"></i></a>
