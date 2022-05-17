<?php

namespace App\DataTables;

use App\Models\Invoice;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class InvoiceDataTable extends DataTable
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
//                $payments = InvoicePayment::where('invoice_id',$row->id)->withoutGlobalScopes()->sum('amount');
                if(!$row->status){
                    return '<button class="btn btn-xs btn-danger">Unpaid</button> ';
                }else{
                    return '<button class="btn btn-xs btn-success">Paid</button> ';
                }
            })
            ->editColumn('invoice_date',function($row){
                return Carbon::parse($row->invoice_date)->format('D, d M Y');
            })
            ->editColumn('due_date',function($row){
                return Carbon::parse($row->due_date)->format('D, d M Y');
            })
            ->addColumn('view_invoice',function($row){
                return '<a href="'.url('invoices/'.$row->id).'" class="btn btn-success btn-xs">View/Print Invoice</button>';
            })
            ->rawColumns(['status','action','view_invoice'])
            ->addColumn('action', 'invoices.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Invoice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Invoice $model)
    {
        return $model->newQuery()->orderByDesc('invoice_date');
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
//            'sacco_id',
            'invoice_date',
            'due_date',
            'amount',
            'status',
            'view_invoice'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'invoices_datatable_' . time();
    }
}
