<?php

namespace App\DataTables;

use App\Interview;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InterviewReportDataTable extends DataTable
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
            ->addColumn('Hr',function($query){
                return $query->getHrDetails->name;
            })->addColumn('category',function($query){
                return $query->getCategory->name;
            })->addColumn('action', function($query){
                $btn = '<div class="d-flex justify-content-around align-items-center">
                <a href="'.route('candidates.show',$query->id).'" class="edit btn"><i class="fa fa-eye text-active"></i></a>';
                return $btn;
            });

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\InterviewReport $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Interview $model)
    {
        $start_date=$this->request()->get('start_date');
        $end_date=$this->request()->get('end_date');
        $query= $model->newQuery();
            if(!empty($start_date) && !empty($end_date))
            {
                $start_date=Carbon::parse($start_date);
                $end_date=Carbon::parse($end_date);
                $query=$query->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59']);
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
                    ->setTableId('interviewreport-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
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
            Column::make('Hr'),
            Column::make('email'),
            Column::make('phone'),
            Column::make('other_phone')->visible(false),
            Column::make('category'),
            Column::make('experience')->visible(false),
            Column::make('current_salary'),
            Column::make('expected_salary')->visible(false),
            Column::make('graduation'),
            Column::make('practical_remarks')->visible(false),
            Column::make('technical_remarks')->visible(false),
            Column::make('general_remarks')->visible(false),
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
        return 'InterviewReport_' . date('YmdHis');
    }
}
