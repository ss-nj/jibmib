<?php

namespace App\DataTables;

use App\Http\Core\Models\User;
use App\Support\DataTableHelpers;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use function url;

class ShopsDataTable extends DataTable
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
                $photo = url($query->logo->path);
                return "<img style='height:70px;width:auto;' src='{$photo}' class='preview-image'>";
            })
            ->addColumn('category', function ($query) {

                return $query->category->name;
            })
            ->addColumn('address', function ($query) {

                return $query->full_address;
            })
            ->addColumn('action', function ($query) {

                $string = '';

                return $string;
            })

            ->addColumn('approve', function ($query) {
                $approveMap = [
                    '0'=>'رد شده',
                    '1'=>'تایید شده',
                    '2'=>'در دست بررسی',
                ];

                return $approveMap[$query->approved] ;
            })
            ->addColumn('status', function ($query) {
                return DataTableHelpers::toggleBottom($query, 'shops');
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
            ->setTableId('shops-table')
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
            Column::computed('shop_name')->title(' نام بنگاه'),
            Column::make('full_address')->title('آدرس'),
            Column::computed('phone')->title('شماره تلفن'),
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
