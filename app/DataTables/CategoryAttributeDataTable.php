<?php

namespace App\DataTables;

use App\Http\Commerce\Models\Category;
use App\Support\DataTableHelpers;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoryAttributeDataTable extends DataTable
{
    protected $queryModel;
    protected $type;

    public function __construct($query = null,$type=null)
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
            ->editColumn('created_at', function ($query) {
                return verta($query->created_at)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })
            ->addColumn('image', function ($query) {
                $photo = url($query->image->path);
                return "<img style='height:70px;width:auto' src='{$photo}' class='preview-image'>";
            })
            ->addColumn('menu', function ($query) {
                return $query->menu ? $query->menu->menu->name : 'بدون منو';
            })
             ->addColumn('attribute', function ($query) {
                 return isset($query->attributes[0])?$query->attributes[0]->name:'';
            })
            ->addColumn('subcategory', function ($query) {
                $subcategoryCount = $query->subcategories->count();

                if ($query->parent) {
                    return '';

                }
                return ' <span class="badge badge-inverse">' . $subcategoryCount . ' </span><a class="text-danger"
                                                       data-toggle="tooltip" data-placement="top" title="" data-original-title="مشاهده زیر دسته"
                                                       style="text-decoration: underline;" href="' .
                    route('category.index', ['category_id' => $query->id]) .
                    '">
                                                        <i class="fa fa fa-ellipsis-h fa-2x"></i>
                                                    </a>';


            })
//             ->addColumn('position', function ($query) {
//                return "3";
//            })
            ->addColumn('action', function ($query) {

                $fastEdit = "<a href='' data-toggle='modal' data-target='#model-edit' class='model-edit btn btn-circle btn-icon-only'
                      data-id=$query->id>
                    <i class='fa fa-pencil fa-pen'></i></a>";



                $string = $fastEdit ;

                return $string;
            })
            ->addColumn('status', function ($query) {
                return DataTableHelpers::toggleBottom($query, 'category');
            })->rawColumns(['status', 'image', 'action', 'subcategory']);
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
        $action=$this->type?'return  $("#new-category").modal();':'return  $("#new-sub-category").modal();';
        return $this->builder()
            ->setTableId('product-category-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create')->text('ایجاد')->action($action),
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
            Column::computed('menu', 'عنوان منو')
                ->addClass('text-center')->type('html'),
            Column::computed('attribute', 'ویژگی')
                ->addClass('text-center')->type('html'),
            Column::computed('subcategory', 'تعداد زیر دسته')
                ->addClass('text-center')->type('html'),
//            Column::computed('position', 'ترتیب')
//                ->addClass('text-center')->type('html'),
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
