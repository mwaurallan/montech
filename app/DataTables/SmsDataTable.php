<?php

namespace App\DataTables;

use App\Models\Borrower;
use App\Models\Sms;
use http\Client\Curl\User;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class SmsDataTable extends DataTable
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
            ->editColumn('user_id',function($row){
                if(is_null($row->user_id)){
                    return '';
                }
                $user = \App\Models\User::find($row->user_id);
                return $user->first_name.' '.$user->last_name;
            })
            ->editColumn('status',function($row){
                $reports = [
                    'DeliveredToTerminal',
                    'DELIVERED',
                    'DELIVERD',
//                    'Forwarded',
                ];

                $failed = [
                    'DeliveryImpossible',
                    'NO_CREDITS',
                    'SenderName Blacklisted'
                ];

                if(in_array($row->status,$reports)){
                    return '<label class="label label-success">Delivered</label>';
                }elseif (in_array($row->status,$failed)){
                    return '<label class="label label-danger">'.$row->status.'</label>';
                }
                return $row->status;
            })
            ->addColumn('action', 'communication.datatables_actions')
            ->addColumn('resend',function($row){
                if($row->sent){
                    return '<a href="'.url('communication/resend').'/'.$row->id.'" class="btn btn-xs btn-info">Resend</a>';
                }
                return '<label class="label label-danger">Resent</label>';

            })
            ->rawColumns(['status','action','resend']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Sms $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Sms $model)
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
            ->columns($this->getColumns())
            ->minifiedAjax()
//            ->addAction(['width' => '120px', 'printable' => false])
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
            'message',
            'user_id'=>[
                'title'=> 'Sent By'
            ],

//            'recipients',
            'send_to'=>[
                'title'=>'Phone Number'
            ],
            'notes',
//            'gateway',
//            'sacco_id',
//            'branch_id',
            'created_at',
            'status',
            'resend',
//            'reason',
//            'created_at',
//            'delivery_checked',
//            'sent'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'sms_datatable_' . time();
    }
}
