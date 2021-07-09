<?php

namespace App\DataTables;

use App\Models\AssocUserMap;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AssociationUsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn(
                'firstname', function($model) {
                return $model->user->firstname;
            })
            ->addColumn(
                'email', function($model) {
                return $model->user->email;
            })
            ->editColumn(
                'created_at', function($model) {
                return $model->created_at->diffForHumans();
            })->addColumn(
                'action', function($model) {
                return view('admin.association-users._actions', ['model' => $model->user, 'group_id' => request()->assoc_group_id, 'group' => $model->assoc_name]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AssocUserMap $model)
    {
        $assocId = $this->group_assoc_id;
        return $model->where('group_id', $assocId)->with(['user', 'assoc_name'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('associationusers-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('frtip')
            ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('firstname'),
            Column::make('email'),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'AssociationUsers_' . date('YmdHis');
    }
}
