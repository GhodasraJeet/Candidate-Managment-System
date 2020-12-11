<?php

namespace App\DataTables;

use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $value = request()->session()->get('email');
        $role=$value->user->role;
        // Check role is admin display crud opeprations

        if($role=="admin")
        {
            return datatables()
            ->eloquent($query)
            ->addColumn('action', function($row){
                $btn = '<div class="d-flex justify-content-around align-items-center"><a href="'.route('admincategory.show',$row->id).'" class="edit btn text-active"><i class="fa fa-eye"></i></a>';
                $btn = $btn.'<button class="btn deleteCategory text-danger" data-id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                $btn = $btn.'<a href="'.route('admincategory.edit',$row->id).'" class="edit btn text-active"><i class="fa fa-edit"></i></a></div>';
                return $btn;
            });
        }

        // Check role is HR display crud opeprations

        if($role=="hr")
        {

            return datatables()
            ->eloquent($query)
            ->addColumn('action', function($row){
                // dd($row->name);
                $btn = '<div class="d-flex justify-content-around align-items-center"><a href="'.route('category.show',$row->id).'" class="edit btn text-active"><i class="fa fa-eye"></i></a>';
                $btn = $btn.'<button class="btn deleteCategory text-danger" data-id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                $btn = $btn.'<a href="'.route('category.edit',$row->id).'" class="edit btn text-active"><i class="fa fa-edit"></i></a></div>';
                return $btn;
            });
        }

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
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
                    ->setTableId('category-table')
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
        return 'Category_' . date('YmdHis');
    }
}
