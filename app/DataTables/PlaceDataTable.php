<?php

namespace App\DataTables;

use App\Http\Commerce\Models\Category;
use App\Support\DataTableHelpers;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PlaceDataTable extends DataTable
{
    protected $queryModel;
    protected $type;

    public function __construct($query = null, $type = null)
    {

        $this->queryModel = $query;
        $this->type = $type;
    }

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
            ->addColumn('DT_RowId', function ($query) {

                return 'dtrid_'. $query->id;
            })
            ->editColumn('created_at', function ($query) {
                return verta($query->created_at)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })

            ->addColumn('city_id', function ($query) {
                return $query->city ? $query->city->name : '';
            })

            ->addColumn('created_at', function ($query) {
                return verta($query->created_at)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })

            ->addColumn('position', function ($query) {
                return
                    $query->position.' '.  DataTableHelpers::positionHandles($query,'places');
            })
            ->addColumn('action', function ($query) {

                $fastEdit = "<a href='' data-toggle='modal' data-target='#model-edit' class='model-edit btn btn-circle btn-icon-only'
                      data-id=$query->id>
                    <i class='fa fa-pencil fa-pen fa-pen'></i></a>";


                $string = $fastEdit;

                return $string;
            })
            ->addColumn('status', function ($query) {
                return DataTableHelpers::toggleBottom($query, 'places');
            })->rawColumns(['status', 'action', 'position']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
    {
        return $this->queryModel ??
            $model->newQuery();
    }


    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('places-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('export')->text('خروجی'),
                Button::make('print')->text('چاپ'),
                Button::make('reset')->text('ریست'),
                Button::make('reload')->text('بارگزاری دوباره')
            )
            ->language(['url' => url('vendors/datatables/Persian.json')]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title('#'),
            Column::computed('image', 'تصویر')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('name', 'name')->title('نام'),
            Column::make('city_id', 'city_id')->title('شهر'),
            Column::make('created_at', 'created_at')->title('زمان ایجاد'),
            Column::make('position', 'position')->title('ترتیب'),

            Column::computed('status')->title('وضعیت')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')->type('html'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')->title('عملیات'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'CategoryTable_' . date('YmdHis');
    }
}
