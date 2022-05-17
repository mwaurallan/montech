<?php

namespace App\DataTables;

use App\Models\Income;
use App\Models\OtherIncome;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class IncomeDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'other_income.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Income $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(OtherIncome $model)
    {
        return $model->newQuery()->with(['type','vehicle','borrower','user']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                //'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id'=> [
                'title' => '#'
            ],
//            'user_id',
            'type.name' => [
                'title' => 'Type'
            ],
            'borrower.first_name' => [
                'title'=> 'First Name'
            ],
            'borrower.last_name' => [
                'title'=> 'Last Name'
            ],
            'vehicle.vehicle' => [
                'title'=> 'Vehicle'
            ],
            'notes',
//            'year',
//            'month',
            'date',
//            'files',
//            'sacco_id',
//            'branch_id',
//            'chart_id',
//            'account_id',
//            'borrower_id',
            'amount',
            'user.full_name'=>[
                'title'=>'Clerk',
                'searchable' => false,
                'orderable' => false,
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'incomes_datatable_' . time();
    }
}
