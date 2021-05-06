<?php

namespace App\DataTables;

use App\Http\Commerce\Models\Attribute;
use App\Http\Core\Models\Slider;
use App\Http\Core\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LogsDataTable extends DataTable
{
    protected $queryModel;
    protected $type;

    public function __construct($query = null, $type = null)
    {
        $this->queryModel = $query;
        $this->type = $type;
    }
//id
//user_type
//user_id
//event
//auditable
//old_values
//new_values
//url
//ip_address
//user_agent
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
            ->addColumn('event', function ($query) {
                $modelEventMap = [
                    'created' => 'ایجاد',
                    'deleted' => 'حذف',
                    'updated' => 'ویرایش',
                    'Logged_In' => 'ورود',
                    'Logged_Out' => 'خروج',
                ];
                return $modelEventMap[$query->event] ?? '';
            })
            ->addColumn('full_name', function ($query) {

                return $query->user ? $query->user->name : '';
            })
            ->addColumn('mobile', function ($query) {

                return $query->user ? $query->user->mobile : '';
            })
            ->addColumn('old_values', function ($query) {

                $order_disalowed = array(
                    'id' => '',
                    'remember_token' => '',
                    'key' => '',
                    'label' => '',
                    'value_en' => '',
                    'setting_group' => '',
                    'length_limit' => '',
                    'sex' => '',
                    'verify_mobile_code' => '',
                    'mobile_verified_at' => '',
                    'affiliate_code' => '',
                    'parent_id' => '',
                    'parents' => '',
                    'parent_active' => '',
                    'cat_lvl' => '',
                    'icon' => '',
                    'type' => '',


                );
                $filtered = array_diff_key(json_decode($query->old_values,true)??[], $order_disalowed);

                return $this->filterCollumns($filtered);
            })
            ->addColumn('new_values', function ($query) {

                $order_disalowed = array(
                    'id' => '',
                    'remember_token' => '',
                    'key' => '',
                    'label' => '',
                    'value_en' => '',
                    'setting_group' => '',
                    'length_limit' => '',
                    'sex' => '',
                    'verify_mobile_code' => '',
                    'mobile_verified_at' => '',
                    'affiliate_code' => '',
                    'parent_id' => '',
                    'parents' => '',
                    'parent_active' => '',
                    'cat_lvl' => '',
                    'icon' => '',
                    'type' => '',


                );
                $filtered = array_diff_key(json_decode($query->new_values,true)??[], $order_disalowed);

                return $this->filterCollumns($filtered);
            })
            ->addColumn('type', function ($query) {
                $modelTypeMap = [
                    'App\Http\Commerce\Models\Place' => 'شهر',
                    'App\Http\Commerce\Models\Coupon' => 'کوپن',
                    'App\Http\Commerce\Models\Attribute' => 'ویژگی',
                    'App\Http\Commerce\Models\AttributeValue' => 'مقدار ویژگی',
                    'App\Http\Core\Models\Slider' => 'اسلایدر',
                    'App\Http\Commerce\Models\Category' => 'دسته بندی',
                    'App\Http\Core\Models\User' => 'کاربر',
                    'App\Http\Core\Models\Setting' => 'تنظیمات',
                    'App\Http\Shop\Models\Takhfif' =>'تخفیف' ,
                     'App\Http\Shop\Models\Shop' =>'کسب و کار',
                    'App\Http\Shop\Models\Refund' =>'درخواست وچه',
                ];
                return $modelTypeMap[$query->auditable_type] ?? $query->auditable_type;
            })
            ->editColumn('auditable_id', function ($query) {

                return $query->auditable_id;
            })
            ->addColumn('action', function ($query) {

                return '';


                '<a href="' . route('log.show', ['user' => $query->id]) . '"' .
                ' data-toggle="tooltip" data-placement="top" title="" data-original-title="پروفایل">
                    <i class="fa fa-eye fa-lg"></i>
                     </a>';

            })
            ->rawColumns(['image', 'action','old_values','new_values']);
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
            ->setTableId('logs-table')
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
            Column::computed('full_name')
                ->addClass('text-center')->title('نام'),
            Column::make('mobile')->title('شماره تماس'),
            Column::make('type')->title('جدول'),
            Column::make('auditable_id')->title('شناسه جدول'),
            Column::make('event')->title('نوع تغییر'),
            Column::make('old_values')->title('مقادیر قبلی'),
            Column::make('new_values')->title('مقادیر جدید'),
            Column::make('created_at')->title('تاریخ ثبت'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
//                  ->width(60)
                ->addClass('text-center')->title('عملیات'),
        ];
    }

    /**
     * @param array $filtered
     * @return string
     */
    public function filterCollumns(array $filtered)
    {
        $string = json_encode($filtered, JSON_UNESCAPED_UNICODE);
        $result = mb_str_replace(
            array('{', '}',
                'value_fa', 'mobile', 'first_name', 'last_name', 'password', 'address', 'wallet', 'active', 'international_post',
                'peyk_motori', 'post', 't_pox', 'barbari', 'express', 'free', 'category_id', 'product_id', 'name',
                'slug', 'link', 'position', 'province_id', 'account_no', 'city_id', 'uuid', 'view_count'
            ),
            array('', '',
                'مقدار', 'موبایل', 'نام', 'نام خانوادگی', 'رمز', 'آدرس', 'کیف پول ', 'وضعیت', 'پست بین الملل',
                'پیک موتوری', 'پست', 'تیپاکس', 'باربری', 'اکسپرس', 'مجانی', 'دسته بندی ', 'محصول', 'نام',
                'نام لینک', 'لینک', 'ترتیب', 'استان', 'شماره حساب', 'شهر', 'کدملی', 'تعداد بازدید'
            ),
            $string
        );
        return '<div style="    max-width: 200px;">' . $result . '</div>';
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Logs_' . date('YmdHis');
    }
}
