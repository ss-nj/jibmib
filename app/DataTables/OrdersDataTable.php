<?php

namespace App\DataTables;

use App\Http\Core\Models\User;
use App\Support\DataTableHelpers;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
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
            ->addColumn('name', function ($query) {

                return $query->user->full_name;
            })
            ->addColumn('takhfif_name', function ($query) {

                return $query->takhfif_name;
            })
            ->addColumn('payment_date', function ($query) {

                return verta($query->transaction->payment_date)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })
            ->addColumn('action', function ($query) {

                $route = route('single',$query->takhfif->slug);

                return "<a href='#' data-toggle='modal' class='btn btn-circle btn-icon-only'  data-target='#revoke-takhfif'>
                    <i class='fa fa-times'></i></a>"
                    . "<a href='$route' class='model-edit btn btn-circle btn-icon-only'>
                    <i class='fa fa-eye '></i></a>";
            })
            ->addColumn('status', function ($query) {

                return $query->status_text;
            })
            ->rawColumns(['status', 'action']);
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
            ->setTableId('orders-table')
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
            Column::make('name', 'name')->title('نام'),
            Column::make('takhfif_name', 'takhfif_name')->title('نام'),
            Column::make('count', 'count')->title('تعداد'),
            Column::make('takhfif_discount', 'takhfif_discount')->title('قیمت'),
            Column::make('payment_date', 'payment_day')->title('زمان پرداخت'),

            Column::computed('status')->title('وضعیت')
                ->addClass('text-center')->type('html'),
            Column::computed('action')
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
        return 'Users_' . date('YmdHis');
    }
}
