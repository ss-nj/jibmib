<?php

namespace App\DataTables;

use App\Http\Core\Models\User;
use App\Support\DataTableHelpers;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
//        $user = Auth::user();

        return datatables()
            ->eloquent($query)
            ->editColumn('created_at', function ($query) {
                return verta($query->created_at)->timezone('Asia/Tehran')->format('Y-m-d H:i');
            })
            ->addColumn('image', function ($query) {
                $photo = url($query->image->path);
                return "<img style='height:70px;width:auto' src='{$photo}' class='preview-image'>";
            })
            ->addColumn('full_name', function ($query) {

                return $query->full_name;
            })
            ->addColumn('action', function ($query) {

                $string = "<a href='' data-toggle='modal' data-target='#model-edit' class='model-edit btn btn-circle btn-icon-only'
                      data-id=$query->id>
                    <i class='fa fa-pen'></i></a>";

                $string .= '<a href="' . route('users.show', ['user' => $query->id]) . '"' .
                    ' data-toggle="tooltip" data-placement="top" title="" data-original-title="پروفایل">'
                    . '<i class="fa fa-eye fa-lg"></i>'
                    . ' </a>';

                return $string;
            })
            ->addColumn('roles', function ($query) {
                $roles = '';
                foreach ($query->roles as $user_role) $roles .= ($user_role->display_name . '-');

                return $roles;
            })
            ->addColumn('status', function ($query) {
//                if (!$query->hasRole('super_administrator')) {
                    return DataTableHelpers::toggleBottom($query, 'user');
//                }
                return '';
            })->rawColumns(['roles', 'status', 'image', 'action']);
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
        $action = $this->type ? 'return  $("#new-category").modal();' : 'return  $("#new-user").modal();';

        return $this->builder()
            ->setTableId('users-table')
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

            Column::computed('image')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')->title('تصویر'),
            Column::make('id')->title('#'),
            Column::computed('name')
                ->addClass('text-center')->title('نام')
            , Column::computed('wallet')
                ->addClass('text-center')->title('کیف پول'),
             Column::computed('roles')->addClass('text-center')->title('نقشها'),
            Column::make('mobile')->title('شماره تماس'),
            Column::make('created_at')->title('تاریخ ثبت نام'),
            Column::computed('status')->title('وضعیت')
//                  ->width(60)
                ->addClass('text-center')->type('html'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
//                  ->width(60)
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
