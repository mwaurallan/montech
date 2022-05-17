<?php

namespace App\DataTables;

use App\Models\Borrower;
use App\Models\MemberVehicle;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class MemberVehicleDataTable extends DataTable
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
//            ->editColumn('member_id',function($row){
//                $b= Borrower::find($row->member_id);
//                return $b->first_name.' '.$b->last_name;
//            })
            ->addColumn('action', 'member_vehicles.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\MemberVehicle $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MemberVehicle $model)
    {
        return $model->newQuery()->select('member_vehicles.*')->with(['member','vehicle'])->orderByDesc('member_vehicles.id');
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
                'title'=>'First Name'
            ],
            'member.last_name'=>[
                'title'=>'Last Name'
            ],
            'vehicle.vehicle'=>[
                'title' => 'Vehicle'
            ],
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
        return 'member_vehiclesdatatable_' . time();
    }
}
