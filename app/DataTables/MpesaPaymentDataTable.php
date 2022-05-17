<?php

namespace App\DataTables;

use App\Models\Borrower;
use App\Models\MpesaPayment;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class MpesaPaymentDataTable extends DataTable
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
                return Carbon::parse($payment->received_on)->format('d-m-Y H:i');
            })
            ->editColumn('status',function ($payment){
                if($payment->status){
                    return '<label class="label label-success">Processed</label>';
                }
                return '<label class="label label-warning">Un processed</label>';
            })
            ->rawColumns(['action','status','process'])
            ->addColumn('action', 'mpesa_payments.datatables_actions')
            ->addColumn('process',function ($row){
                if(!$row->status){
                    return '<a href="#edit-modal" data-toggle="modal" e-id="'.$row->id.'" hint="'.url('mpesaPayments/'.$row->id).'" class="btn btn-info btn-xs edit-common" ><i class="glyphicon glyphicon-eye-edit"></i>Process</a>';
                }
                return '';
            })
            ->editColumn('borrower_id',function($row){
                if(!is_null($row->borrower_id)){
                    $b = Borrower::find($row->borrower_id);

                    if(!is_null($b)){
                        return $b->first_name.' '.$b->last_name;
                    }
                }
                return '';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\MpesaPayment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MpesaPayment $model)
    {
        return $model->newQuery()->where('status',false);
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
//            'paybill'=>[
//                'title' => 'Paybill/Till No.'
//            ],
            'first_name',
            'middle_name',
            'last_name',
            'phone_number',
            'borrower_id' => [
                'title' => 'Member',
                'width' => '300px'
            ],
//            'trans_id',
            'amount',
            'received_on',
//            'trans_time',
            'status',
            'process'=>[

            ]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'mpesa_payments_datatable_' . time();
    }
}
