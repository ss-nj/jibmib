<?php

namespace App\DataTables;

use App\Http\Commerce\Models\Category;
use App\Support\DataTableHelpers;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SliderDataTable extends DataTable
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
            ->addColumn('image', function ($query) {
                $photo = url($query->image->path);
                return "<img style='height:70px;width:auto' src='{$photo}' class='preview-image'>";
            })
            ->addColumn('place_id', function ($query) {
                return $query->city ? $query->city->name : '';
            })
            ->addColumn('takhfif_id', function ($query) {
                return $query->category ? $query->category->name : '';
            })
            ->addColumn('category_id', function ($query) {
                return $query->takhfif ? $query->takhfif->name : '';
            })
            ->addColumn('created_at', function ($query) {
                return verta($query->created_at)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })
             ->addColumn('start_time', function ($query) {
                return verta($query->start_time)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })
            ->addColumn('expire_time', function ($query) {
                return verta($query->expire_time)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })
            ->addColumn('position', function ($query) {
                return
                    $query->position.' '.  DataTableHelpers::positionHandles($query,'sliders');
            })
            ->addColumn('action', function ($query) {

                $route = route('sliders.edit',$query->id);

                $fastEdit = "<a href='$route'  class='model-edit btn btn-circle btn-icon-only' >
                    <i class='fa fa-pencil fa-pen fa-pen'></i></a>";

                return $fastEdit;
            })
            ->addColumn('status', function ($query) {
                return DataTableHelpers::toggleBottom($query, 'slider');
            })->rawColumns(['status', 'image', 'action', 'position']);
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
            ->setTableId('sliders-table')
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
            Column::make('place_id', 'place_id')->title('شهر'),
            Column::make('takhfif_id', 'takhfif_id')->title('تخفیف'),
            Column::make('category_id', 'category_id')->title('دسته بندی'),
            Column::make('created_at', 'created_at')->title('زمان ایجاد'),
            Column::make('start_time', 'start_time')->title('زمان شروع'),
            Column::make('expire_time', 'expire_time')->title('زمان پایان'),
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
