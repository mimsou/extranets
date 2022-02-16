<!-- Modal -->
<div class="modal fade" id="todo-list-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="modal-body">
                <div class="px-3 pt-3 text-center">
                    <div class="event-type info">
                        <div class="event-indicator ">
                            <i class="fas fa-check text-white" style="font-size: 40px"></i>
                        </div>
                    </div>
                    <h3 class="pt-3">
                        {{ $template->template_name }}
                    </h3>
                </div>
                <hr/>
                {{--                <div class="row">--}}
                {{--                    <div class="col-md-7">--}}
                {{--                        <small><span class="number-of-completed-todos">0</span> complété sur--}}
                {{--                            <span class="total-todos">0</span></small>--}}
                {{--                        <div class="time-progresssion mb-2">--}}
                {{--                            <div class="progression todo-progress text-right" id="part_prog_"--}}
                {{--                                 style="transition: all 0.5s ease; background-color: aquamarine; height:7px; border-radius: 13px;"></div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="row todo-list-div">
                    <div class="col-md-12 todo-list-group scroll-height">
                        @foreach($groups as $key => $group)
                            <div class="row group-section">
                                <div class="col-md-12 mt-3">
                                    <h3 class="d-inline float-left todo-group-title">{{ $group['group_name'] }}</h3>
                                </div>
                                <div class="todo-list-section col-md-12 pl-4 connectedSortable">
                                    @foreach(collect($group['todos'])->sortBy('order') as $key => $todo)
                                        <div class="row single-todo-div">
                                            <div class="col-md-9">
                                                <div class="option-box-grid">
                                                    <input class="todo-checkbox" name="bigradios" type="checkbox">
                                                    <label for="check"></label>
                                                    <p class="edit-todo">{{ $todo['to_do'] }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-right">
                                                <i class="sort-handle fas fa-bars"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>