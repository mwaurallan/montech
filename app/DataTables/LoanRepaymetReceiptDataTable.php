<?php

namespace App\DataTables;

use App\Models\LoanRepaymetReceipt;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class LoanRepaymetReceiptDataTable extends DataTable
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
            ->editColumn('status',function($row){
                if($row->status){
                    return '<label class="label label-success">Processed</label>';
                }
                return '<label class="label label-info">Un Processed</label>';
            })
            ->addColumn('process',function($row){
                if($row->status){
                    return '<label class="label label-success">Processed</label>';
                }
                return '<a href="#process-modal" data-toggle="modal" class="btn btn-sm btn-primary process-btn" b-id="'.$row->borrower_id.'" receipt-id="'.$row->id.'">Process</a>';
            })
            ->rawColumns(['action','status','process'])
            ->addColumn('action', 'loan_repaymet_receipts.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LoanRepaymetReceipt $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LoanRepaymetReceipt $model)
    {
        return $model->newQuery()->select('loan_payment_receipts.*')->with(['vehicle','member'])->orderByDesc('loan_payment_receipts.id');
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
            'member.first_name'=>[
                'title' => 'Member'
            ],

            'vehicle.vehicle'=>[
                'title' => 'Vehicle'
            ],
            'loan_product',
            'date',
            'receipt',
            'amount',
//            'user_id',
            'status',
            'process'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'loan_repaymet_receiptsdatatable_' . time();
    }
}
