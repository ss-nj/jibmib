<?php

namespace App\DataTables;

use App\Http\Core\Models\Image;
use App\Http\Core\Models\User;
use App\Support\DataTableHelpers;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use function url;

class TakhfifsDataTable extends DataTable
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
                $photo = url($query->images->first()?$query->images->first()->path:Image::NO_IMAGE_PATH);
                return "<img style='height:70px;width:auto;' src='{$photo}' class='preview-image'>";
            })
            ->addColumn('category', function ($query) {

                return isset($query->categories[0])?implode('-', $query->categories->pluck('name')->toArray()) :'';
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
                $route = route('single',$query->slug);

                return "<a href='$route'  class='model-edit btn btn-circle btn-icon-only'>
                    <i class='fa fa-eye '></i></a>";
            })
            ->addColumn('approve', function ($query) {
                if ($query->approved==2){
                    $approved = '<span class="badge bg-warning">بررسی</span>';
                }elseif ($query->approved==1){
                    $approved = '<span class="badge bg-success">تایید</span>';
                }else
                    $approved = '<span class="badge bg-danger">رد</span>';

                return $approved;
            })
            ->addColumn('status', function ($query) {
                return DataTableHelpers::toggleBottom($query, 'takhfifs');
            })->rawColumns(['status', 'image', 'action', 'approve']);
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
            Column::computed('approve')->title('وضعیت'),
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
