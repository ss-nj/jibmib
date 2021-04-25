<?php

namespace App\DataTables;

use App\Http\Core\Models\Image;
use App\Http\Core\Models\User;
use App\Support\DataTableHelpers;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use function url;

class ShopTakhfifsDataTable extends DataTable
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
            ->addColumn('image', function ($query) {
                $photo = url($query->images->first() ? $query->images->first()->path : Image::NO_IMAGE_PATH);
                return "<img style='height:70px;width:auto;' src='{$photo}' class='preview-image'>";
            })
            ->addColumn('category', function ($query) {

                return isset($query->categories[0]) ? implode('-', $query->categories->pluck('name')->toArray()) : '';
            })
            ->addColumn('display_start_time', function ($query) {

                return verta($query->display_start_time)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })
            ->addColumn('display_end_time', function ($query) {

                return verta($query->display_end_time)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })
            ->addColumn('start_time', function ($query) {

                return verta($query->start_time)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })
            ->addColumn('expire_time', function ($query) {

                return verta($query->expire_time)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })
            ->addColumn('price', function ($query) {

                return $query->price;
            })
            ->addColumn('discount_price', function ($query) {

                return $query->discount_price;
            })
            ->addColumn('created_at', function ($query) {

                return verta($query->created_at)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })
            ->addColumn('action', function ($query) {


//
//                                    <form action="{{ route('shop.takhfifs.destroy', $takhfif->id) }}"
//                                          style="display: inline;"
//                                          id="frm-delete-takhfif-value{{ $takhfif->id }}"
//                                          method="post">
//                                        {{ csrf_field() }}
//                                        {{ method_field('delete') }}
//                                        <a href="#" class="btn btn-circle btn-icon-only"
//                                           onclick="deleteWithModal('frm-delete-takhfif-value', '{{ $takhfif->id }}', event)"><i
//                                                class="fa fa-trash alert-danger"></i></a>
//                                    </form>



                $deleteRoute = route('shop.takhfifs.destroy', $query->id);
                $csrf=csrf_field();
                $deleteAction = "  <form action='$deleteRoute '
                                          style='display: inline;'
                                          id='frm-delete-takhfif$query->id'
                                          method='post'>
                                         $csrf
                                        <input type='hidden' name='_method' value='delete'>
                                        <a href='#' class='btn btn-circle btn-icon-only'
                                           onclick='deleteWithModal(\"frm-delete-takhfif\", \"$query->id\", event)'><i
                                                class='fa fa-trash alert-danger'></i></a>
                                    </form>";

                $showRoute = route('single', $query->slug);
                $showAction = "<a href='$showRoute'  class='model-edit btn btn-circle btn-icon-only'>
                    <i class='fa fa-eye '></i></a>";

                 $editRoute = route('shop.takhfifs.edit', $query->id);
                $editAction = "<a href='$editRoute'  class='model-edit btn btn-circle btn-icon-only'>
                    <i class='fa fa-pen fa-pencil '></i></a>";


                return $showAction .$editAction.$deleteAction;
            })
            ->addColumn('status', function ($query) {
                return DataTableHelpers::toggleBottom($query, 'takhfifs');
            })->rawColumns(['status', 'image', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
            ->setTableId('takhfifs-table')
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

            Column::computed('image')->title('تصویر'),
            Column::make('id')->title('#'),
            Column::make('name')->title('نام'),
            Column::computed('category')->title('دسته بندی'),
            Column::computed('display_start_time')->title('زمان شروع نمایش'),
            Column::computed('display_end_time')->title('زمان اتمام نمایش'),
            Column::make('price')->title('قیمت'),
            Column::computed('discount_price')->title('قیمت با تخفیف'),
            Column::computed('created_at')->title('قیمت با تخفیف'),
            Column::computed('status')->title('وضعیت'),
            Column::computed('action')->title('عملیات'),
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
