<?php

namespace App\DataTables;

use App\Models\TodoTemplate;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TodoTemplatesDataTable extends DataTable
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
            ->editColumn('created_at', function($model){
                return $model->created_at->diffForHumans();
            })->addColumn('action', function($model){
                return view('admin.todo._actions',['model'=>$model]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\TodoTemplate $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TodoTemplate $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('todotemplates-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('lfrtip')
                    ->orderBy(0,'desc');
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
            Column::make('template_name')->title('Gabarit'),
            Column::make('created_at')->title('Créé le'),
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
        return 'TodoTemplates_' . date('YmdHis');
    }
}
