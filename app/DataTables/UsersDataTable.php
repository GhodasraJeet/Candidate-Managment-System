<?php

namespace App\DataTables;

use App\User;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query=$query->where('role','hr');
        return datatables()
        ->eloquent($query)
        ->addColumn('action', function($row){
            $btn = '<div class="d-flex justify-content-around align-items-center"><a href="'.route('hr.show',$row->id).'" class="edit btn text-active"><i class="fa fa-eye"></i></a>';
            $btn = $btn.'<button class="btn deleteHr text-danger" data-id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
            $btn = $btn.'<a href="'.route('hr.edit',$row->id).'" class="edit btn text-active"><i class="fa fa-edit"></i></a></div>';
            return $btn;
        })->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $start_date=$this->request()->get('start_date');
        $end_date=$this->request()->get('end_date');
        $query= $model->newQuery();
        if(!empty($start_date) && !empty($end_date))
        {
            $start_date=Carbon::parse($start_date);
            $end_date=Carbon::parse($end_date);
            $query=$query->where('role','hr')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59']);
        }
        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->setTableId('users-table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->orderBy(1)
        ->parameters([
            "pageLength"=> 5,
            "order"=> [[ 0, "asc" ]],
            'dom'          => 'Bfrtip',
            'buttons' => ['export'],
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
            Column::make('name'),
            Column::make('email'),
            Column::make('created_at'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
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
        return 'Users_' . date('YmdHis');
    }
}
