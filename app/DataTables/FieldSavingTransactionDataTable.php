<?php

namespace App\DataTables;

use App\Models\FieldSavingTransaction;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class FieldSavingTransactionDataTable extends DataTable
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

        return $dataTable

            ->addColumn('action', 'field_saving_transactions.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\FieldSavingTransaction $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FieldSavingTransaction $model)
    {
        return $model->newQuery()->orderByDesc('field_saving_transactions.id')->with(['vehicle','user','account']);
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
//            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
//                'dom'       => 'Bfrtip',
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
            'vehicle.vehicle'=>[
                'title' => 'Vehicle'
            ],
//            'borrower_id'=>[
//                'title' => 'Owner'
//            ],
            'account.name'=>[
                'title' => 'Account'
            ],
            'user.first_name'=>[
                'title' => 'Recorded By FirstName'
            ],
            'user.last_name'=>[
                'title' => 'Last Name'
            ],
            'type',
            'amount',
//            'system_interest',
            'date',
//            'time',
//            'year',
//            'month',
//            'sacco_id'
            'notes',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'field_saving_transactionsdatatable_' . time();
    }
}
