<?php

namespace App\DataTables;

use App\Models\MpesaPayment;
use App\Models\ProcessedMpesaPayment;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ProcessedMpesaPaymentDataTable extends DataTable
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
            ->editColumn('received_on',function($payment){
                return Carbon::parse($payment->received_on)->toDayDateTimeString();
            })
            ->editColumn('status',function ($payment){
                if($payment->status){
                    return '<label class="label label-success">Processed</label>';
                }
                return '<label class="label label-warning">Un processed</label>';
            })
            ->rawColumns(['action','status'])
            ->addColumn('action', 'processed_mpesa_payments.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ProcessedMpesaPayment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MpesaPayment $model)
    {
        return $model->newQuery()->where('status',true);
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
            'id',
//            'payment_mode',
            'ref_number',
            'bill_ref_number',
            'paybill'=>[
                'title' => 'Paybill/Till No.'
            ],
            'first_name',
            'middle_name',
            'last_name',
            'phone_number',
//            'trans_id',
            'amount',
            'received_on',
//            'trans_time',
            'status'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'processed_mpesa_payments_datatable_' . time();
    }
}
