<?php

namespace App\DataTables;

use App\Http\Commerce\Models\Category;
use App\Support\DataTableHelpers;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ShopRefundDataTable extends DataTable
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

             ->editColumn('by_admin', function ($query) {
                 return $query->by_admin?'بله':'خیر';
            })
            ->editColumn('status', function ($query) {


                $status_map = [
                    0 => ['badge-warning', 'درانتظار بررسی'],
                    1 => ['badge-success', 'تایید شده'],
                    2 => ['badge-danger', 'رد شده'],
                    3 => ['badge-warning', 'در حال بررسی'],
                    4 => ['badge-secondary', 'پرداخت شده'],
                ];


                return '<span class="edit-status badge ' .
                    ($status_map[$query->status][0])
                    . '">' .
                    ($status_map[$query->status][1])
                    . '</span>';

            })

            ->editColumn('created_at', function ($query) {
                return verta($query->created_at)->timezone('Asia/Tehran')->format('Y/m/d H:i');
            })


            ->addColumn('action', function ($query) {

                if ($query->status!=0)
                    return '';

                $fastEdit = "<a href='' data-toggle='modal' data-target='#model-edit' class='model-edit btn btn-circle btn-icon-only'
                      data-id=$query->id>
                    <i class='fa fa-pencil fa-pen fa-pen'></i></a>";


                $string = $fastEdit;

                return $string;
            })
            ->addColumn('status', function ($query) {
                return '';
            })->rawColumns(['status', 'action']);
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
            ->setTableId('refund-table')
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

            Column::make('by_admin', 'by_admin')->title('ایجاد خودکار'),
            Column::make('amount', 'amount')->title('مقدار'),
            Column::make('bank_id', 'bank_id')->title('شماره حساب'),
            Column::make('description', 'description')->title('توضیح'),
            Column::make('status', 'status')->title('وضعیت'),
            Column::make('created_at', 'created_at')->title('زمان ایجاد'),


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
