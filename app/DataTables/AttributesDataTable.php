<?php

namespace App\DataTables;

use App\Http\Commerce\Models\Attribute;
use App\Http\Commerce\Models\Category;
use App\Support\DataTableHelpers;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AttributesDataTable extends DataTable
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
            ->editColumn('created_at', function ($query) {
                return verta($query->created_at)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })
            ->addColumn('DT_RowId', function ($query) {

                return 'dtrid_' . $query->id;
            })
            ->addColumn('validation_unit', function ($query) {
                return $query->validation_unit;
            })
            ->addColumn('description', function ($query) {
                return Str::limit($query->description, 80);
            })
            ->addColumn('field_type', function ($query) {
                return Attribute::TYPE_MAP[$query->field_type];
            })
            ->addColumn('validation_length', function ($query) {
                return $query->validation_length;
            })
            ->addColumn('values', function ($query) {
                if (in_array($query->field_type, ['number', 'short-text', 'long-text']))
                    return '';
                $valuesCount = $query->values->count();

                return ' <span class="badge badge-inverse">' . $valuesCount . ' </span><a class="text-danger"
                                                       data-toggle="tooltip" data-placement="top" title="" data-original-title="مشاهده مقادیر"
                                                       style="text-decoration: underline;" href="' .
                    route('attribute-value.index', $query->id) .
                    '">
                                                        <i class="fa fa fa-ellipsis-h fa-2x"></i>
                                                    </a>';


            })
            ->addColumn('position', function ($query) {
                return
                    $query->position . ' ' . DataTableHelpers::positionHandles($query, 'attributes');
            })
            ->addColumn('action', function ($query) {

                $fastEdit = "<a href='' data-toggle='modal' data-target='#model-edit' class='model-edit btn btn-circle btn-icon-only'
                      data-id=$query->id>
                    <i class='fa fa-pencil fa-pen'></i></a>";

                $string = $fastEdit;

                return $string;
            })
            ->addColumn('status', function ($query) {
                return DataTableHelpers::toggleBottom($query, 'attribute');
            })->rawColumns(['status', 'image', 'action', 'position', 'values']);
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
        $action = 'return  $("#new-attribute").modal();';
        return $this->builder()
            ->setTableId('attributes-table')
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
            Column::make('name', 'name')->title('نام'),
            Column::computed('description', 'توضیح')->addClass('text-center')->type('html'),
            Column::computed('title', 'نوع')->addClass('text-center')->type('html'),
            Column::computed('validation_unit', 'واحد')->addClass('text-center')->type('html'),
            Column::computed('validation_length', 'طول')->addClass('text-center')->type('html'),
            Column::computed('position', 'ترتیب')->addClass('text-center')->type('html'),
            Column::computed('values', 'مقادیر')->addClass('text-center')->type('html'),
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
