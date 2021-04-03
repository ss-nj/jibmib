<?php

namespace Database\Seeders;

use App\Http\Core\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                'key' => 'policy',
                'label' => 'قوانین و مقررات',
                'value_fa' => 'قوانین و مقررات',
                'value_en' => 'policy',
                'type' => 'text',
                'length_limit' => '99999',
                'setting_group' => 'policy', 'created_at' => now()

            ],
            [
                'key' => 'E_namad',
                'label' => 'اینماد',
                'value_fa' => 'اینماد',
                'value_en' => 'e_namad',
                'type' => 'string',
                'length_limit' => '99999',
                'setting_group' => 'licences', 'created_at' => now()

            ],
            [
                'key' => 'samandehi',
                'label' => 'ساماندهی',
                'value_fa' => 'ساماندهی',
                'value_en' => 'samandehi',
                'type' => 'string',
                'length_limit' => '99999',
                'setting_group' => 'licences', 'created_at' => now()

            ],
            [
                'key' => 'watermark',
                'label' => 'واترمارک',
                'value_fa' => 'واترمارک',
                'value_en' => 'watermark',
                'type' => 'logo',
                'setting_group' => 'logo', 'created_at' => now()

            ],
            [
                'key' => 'site_logo',
                'label' => 'لوگوی سایت',
                'value_fa' => 'لوگوی سایت',
                'value_en' => 'site logo',
                'type' => 'logo',
                'setting_group' => 'logo', 'created_at' => now()

            ],
            [
                'key' => 'site_url',
                'label' => 'آدرس سایت',
                'value_fa' => 'آدرس سایت',
                'value_en' => 'site url',
                'length_limit' => '200',
                'type' => 'string',
                'setting_group' => 'general_settings', 'created_at' => now()

            ],
            [
                'key' => 'abuse',
                'label' => 'شکایات',
                'value_fa' => 'متن شکایات',
                'value_en' => 'abuse',
                'type' => 'text',
                'setting_group' => 'abuse', 'created_at' => now()

            ],
            [
                'key' => 'site_keywords',
                'label' => 'کلمات کلیدی سایت',
                'value_fa' => 'کلمات کلیدی سایت',
                'value_en' => 'Site keyword',
                'type' => 'text',
                'setting_group' => 'seo', 'created_at' => now()

            ],
            [
                'key' => 'site_slogan',
                'label' => 'شعار سایت',
                'value_fa' => 'شعار سایت',
                'value_en' => 'Site slogan',
                'type' => 'string',
                'length_limit' => '200',
                'setting_group' => 'seo', 'created_at' => now()

            ],
            [
                'key' => 'site_description',
                'label' => 'توضیحات سایت',
                'value_fa' => 'توضیحات سایت',
                'value_en' => 'Site description',
                'type' => 'string',
                'length_limit' => '200',
                'setting_group' => 'seo', 'created_at' => now()

            ],
            [
                'key' => 'site_name',
                'label' => 'نام سایت',
                'value_fa' => 'نام سایت',
                'value_en' => 'Site name',
                'type' => 'string',
                'length_limit' => '200',
                'setting_group' => 'seo', 'created_at' => now()

            ],
            [
                'key' => 'site_name_fa',
                'label' => 'نام فارسی سایت',
                'value_fa' => 'نام فارسی سایت',
                'value_en' => 'site url',
                'length_limit' => '200',
                'type' => 'string',
                'setting_group' => 'general_settings', 'created_at' => now()

            ],

            [
                'key' => 'about_us_page',
                'label' => 'متن در باره ی ما',
                'value_fa' => 'متن درباره ی ما',
                'value_en' => 'about us text',
                'type' => 'text',
                'setting_group' => 'about_us_page', 'created_at' => now()

            ],
            [
                'key' => 'contact_us',
                'label' => 'تماس با ما',
                'value_fa' => 'متن تماس با ما',
                'value_en' => 'contact us text',
                'type' => 'text',
                'setting_group' => 'contact_us', 'created_at' => now()

            ],
            [
                'key' => 'address',
                'label' => 'نشانی',
                'value_fa' => 'نشانی',
                'value_en' => 'address',
                'type' => 'string',
                'length_limit' => '400',
                'setting_group' => 'contact_us', 'created_at' => now()

            ],
            [
                'key' => 'phone',
                'label' => 'شماره تماس',
                'value_fa' => 'شماره تماس',
                'value_en' => 'phone no',
                'type' => 'string',
                'length_limit' => '100',
                'setting_group' => 'contact_us', 'created_at' => now()

            ],
            [
                'key' => 'Email',
                'label' => 'پست الکترونیک',
                'value_fa' => 'پست الکترونیک',
                'value_en' => 'Email',
                'type' => 'string',
                'length_limit' => '100',
                'setting_group' => 'contact_us', 'created_at' => now()

            ],
            [
                'key' => 'user_guide',
                'label' => 'راهنمای کاربر',
                'value_fa' => 'متن راهنمای کاربر',
                'value_en' => 'user guide',
                'type' => 'text',
                'setting_group' => 'user_guide', 'created_at' => now()

            ], [
                'key' => 'register_hint',
                'label' => 'متن ثبت نام',
                'value_fa' => 'متن ثبت نام',
                'value_en' => 'register hint',
                'type' => 'text',
                'setting_group' => 'register', 'created_at' => now()

            ],
            [
                'key' => 'twitter',
                'label' => 'توییتر',
                'value_fa' => 'توییتر',
                'value_en' => 'twitter',
                'type' => 'string',
                'length_limit' => '100',
                'setting_group' => 'social', 'created_at' => now()

            ],
            [
                'key' => 'facebook',
                'label' => 'فیسبوک',
                'value_fa' => 'فیسبوک',
                'value_en' => 'facebook',
                'length_limit' => '100',
                'type' => 'string',
                'setting_group' => 'social', 'created_at' => now()

            ],
            [
                'key' => 'telegram',
                'label' => 'تلگرام',
                'value_fa' => 'تلگرام',
                'value_en' => 'telegram',
                'length_limit' => '100',
                'type' => 'string',
                'setting_group' => 'social', 'created_at' => now()

            ],
            [
                'key' => 'instagram',
                'label' => 'اینستاگرام',
                'value_fa' => 'اینستاگرام',
                'value_en' => 'اینستاگرام',
                'length_limit' => '100',
                'type' => 'string',
                'setting_group' => 'social', 'created_at' => now()

            ]
            , [
                'key' => 'whatsapp',
                'label' => 'واتساپ',
                'value_fa' => 'واتزاپ',
                'value_en' => 'whatsapp',
                'type' => 'string',
                'setting_group' => 'social', 'created_at' => now()

            ], [
                'key' => 'google_download_link',
                'label' => 'لینک دانلود از گوگل پلی',
                'value_fa' => 'لینک دانلود از گوگل پلی',
                'value_en' => '',
                'type' => 'string',
                'length_limit' => '200',
                'setting_group' => 'application', 'created_at' => now()

            ], [
                'key' => 'application_download_link',
                'label' => 'اپلیکیشن اندروید',
                'value_fa' => 'اپلیکیشن اندروید',
                'value_en' => '',
                'type' => 'file',
                'setting_group' => 'application', 'created_at' => now()

            ], [
                'key' => 'app_store_download_link',
                'label' => 'لینک دانلود از اپ استور',
                'value_fa' => 'لینک دانلود از اپ استور',
                'value_en' => '',
                'length_limit' => '200',
                'type' => 'string',
                'setting_group' => 'application', 'created_at' => now()

            ], [
                'key' => 'win_store_download_link',
                'label' => 'لینک دانلود از وین استور',
                'value_fa' => 'لینک دانلود از وین استور',
                'value_en' => '',
                'length_limit' => '200',
                'type' => 'string',
                'setting_group' => 'application', 'created_at' => now()

            ], [
                'key' => 'address',
                'label' => 'ادرس محل فعالیت',
                'value_fa' => 'ادرس محل فعالیت',
                'value_en' => '',
                'length_limit' => '200',
                'type' => 'string',
                'setting_group' => 'contact_us', 'created_at' => now()

            ], [
                'key' => 'phone',
                'label' => 'تلفن سایت',
                'value_fa' => '091333333333',
                'value_en' => '',
                'length_limit' => '100',
                'type' => 'string',
                'setting_group' => 'contact_us', 'created_at' => now()

            ], [
                'key' => 'licenses',
                'label' => 'لایسنس سایت',
                'value_fa' => 'لایسنس سایت',
                'value_en' => '',
                'length_limit' => '300',
                'type' => 'string',
                'setting_group' => 'licences', 'created_at' => now()

            ], [
                'key' => 'takhfif_edit_cost',
                'label' => 'هزینه ی ویرایش تخفیف',
                'value_fa' => '0',
                'value_en' => '',
                'length_limit' => '9',
                'type' => 'string',
                'setting_group' => 'commerce', 'created_at' => now()

            ], [
                'key' => 'min_withdrawal ',
                'label' => 'حداقل موجوی جهت درخواست برداشت',
                'value_fa' => '0',
                'value_en' => '',
                'length_limit' => '9',
                'type' => 'string',
                'setting_group' => 'commerce', 'created_at' => now()

            ], [
                'key' => 'commission',
                'label' => 'درصد پورسانت',
                'value_fa' => 'درصد پورسانت',
                'value_en' => '',
                'length_limit' => '9',
                'type' => 'string',
                'setting_group' => 'commerce', 'created_at' => now()

            ], [
                'key' => 'login_admin_redirect_path',
                'label' => 'هدایت ادمین بعد از ورود',
                'value_fa' => '0',
                'value_en' => '0',
                'length_limit' => '9',
                'type' => 'login_admin_redirect_path',
                'setting_group' => 'register', 'created_at' => now()

            ], [
                'key' => 'login_redirect_intended',
                'label' => 'بازگشت به آخرین صفحه بعد از ورود',
                'value_fa' => '0',
                'value_en' => '0',
                'length_limit' => '9',
                'type' => 'login_redirect_intended',
                'setting_group' => 'register', 'created_at' => now()

            ], [
                'key' => 'login_redirect_path',
                'label' => 'هدایت کاربر بعد از ورود',
                'value_fa' => '0',
                'value_en' => '0',
                'length_limit' => '9',
                'type' => 'login_redirect_path',
                'setting_group' => 'register', 'created_at' => now()

            ],  [
                'key' => 'register_sms',
                'label' => 'نیاز به ارسال پیامک بعد از ثبت نام ؟',
                'value_fa' => '1',
                'value_en' => '0',
                'length_limit' => '9',
                'type' => 'register_sms',
                'setting_group' => 'register', 'created_at' => now()

            ],
            [
                'key' => 'footer_copy_rights',
                'label' => 'متن کپی رایت فوتر',
                'value_fa' => ' حقوق مادی و معنوی این سامانه متعلق
                به شرکت فناوری اطلاعات طراحان داتیس ایرانیان تحت برند طراحان ایرانیان می‌باشد',
                'value_en' => 'footer copy rights',
                'type' => 'text',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ]
            , [
                'key' => 'footer_logo',
                'label' => 'لوگوی فوتر',
                'value_fa' => '',
                'value_en' => '',
                'type' => 'logo',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_text',
                'label' => 'متن توضیح فوتر',
                'value_fa' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم
                 از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و
                 مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و
                کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشدم ایپسوم متن ساختگی با
                تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ',
                'value_en' => 'footer copy rights',
                'type' => 'text',
                'length_limit' => '400',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_address',
                'label' => 'ادرس فوتر',
                'value_fa' => 'آدرس : اصفهان، خیابان شمس آبادی ساختمان آلا، طبقه دوم، واحد 204 ',
                'value_en' => 'footer copy rights',
                'type' => 'text',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_phone',
                'label' => 'شماره تماس فوتر',
                'value_fa' => 'تلفن همراه :  09132230000
                تلفن تماس :  03135144',
                'value_en' => 'footer copy rights',
                'type' => 'text',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_menu_1',
                'label' => 'منوی فوتر',
                'value_fa' => '<a href="http://jibmib.com/home">صفحه اصلی سایت</a>',
                'value_en' => 'footer copy rights',
                'type' => 'menu',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_menu_2',
                'label' => 'منوی فوتر',
                'value_fa' => '<a href="http://jibmib.com/home">صفحه اصلی سایت</a>',
                'value_en' => 'footer copy rights',
                'type' => 'menu',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_menu_3',
                'label' => 'منوی فوتر',
                'value_fa' => '<a href="http://jibmib.com/home">صفحه اصلی سایت</a>',
                'value_en' => 'footer copy rights',
                'type' => 'menu',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_menu_4',
                'label' => 'منوی فوتر',
                'value_fa' => '<a href="http://jibmib.com/home">صفحه اصلی سایت</a>',
                'value_en' => 'footer copy rights',
                'type' => 'menu',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_menu_5',
                'label' => 'منوی فوتر',
                'value_fa' => '<a href="http://jibmib.com/home">صفحه اصلی سایت</a>',
                'value_en' => 'footer copy rights',
                'type' => 'menu',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_menu_6',
                'label' => 'منوی فوتر',
                'value_fa' => '<a href="http://jibmib.com/home">صفحه اصلی سایت</a>',
                'value_en' => 'footer copy rights',
                'type' => 'menu',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_menu_7',
                'label' => 'منوی فوتر',
                'value_fa' => '<a href="http://jibmib.com/home">صفحه اصلی سایت</a>',
                'value_en' => 'footer copy rights',
                'type' => 'menu',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_menu_8',
                'label' => 'منوی فوتر',
                'value_fa' => '<a href="http://jibmib.com/home">صفحه اصلی سایت</a>',
                'value_en' => 'footer copy rights',
                'type' => 'menu',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_menu_9',
                'label' => 'منوی فوتر',
                'value_fa' => '<a href="http://jibmib.com/home">صفحه اصلی سایت</a>',
                'value_en' => 'footer copy rights',
                'type' => 'menu',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_menu_10',
                'label' => 'منوی فوتر',
                'value_fa' => '<a href="http://jibmib.com/home">صفحه اصلی سایت</a>',
                'value_en' => 'footer copy rights',
                'type' => 'menu',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_menu_11',
                'label' => 'منوی فوتر',
                'value_fa' => '<a href="http://jibmib.com/home">صفحه اصلی سایت</a>',
                'value_en' => 'footer copy rights',
                'type' => 'menu',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'footer_menu_12',
                'label' => 'منوی فوتر',
                'value_fa' => '<a href="http://jibmib.com/home">صفحه اصلی سایت</a>',
                'value_en' => 'footer copy rights',
                'type' => 'menu',
                'length_limit' => '120',
                'setting_group' => 'footer', 'created_at' => now()

            ],
            [
                'key' => 'home_category_1',
                'label' => 'دسته بندی صفحه اول ردیف اول',
                'value_fa' => '',
                'value_en' => '',
                'type' => 'home_category',
                'length_limit' => '120',
                'setting_group' => 'home_page', 'created_at' => now()

            ],
            [
                'key' => 'home_category_2',
                'label' => 'دسته بندی صفحه اول ردیف دوم',
                'value_fa' => '',
                'value_en' => '',
                'type' => 'home_category',
                'length_limit' => '120',
                'setting_group' => 'home_page', 'created_at' => now()

            ],
            [
                'key' => 'home_category_3',
                'label' => 'دسته بندی صفحه اول ردیف سوم',
                'value_fa' => '',
                'value_en' => '',
                'type' => 'home_category',
                'length_limit' => '120',
                'setting_group' => 'home_page', 'created_at' => now()

            ],
            [
                'key' => 'home_category_4',
                'label' => 'دسته بندی صفحه اول ردیف چهارم',
                'value_fa' => '',
                'value_en' => '',
                'type' => 'home_category',
                'length_limit' => '120',
                'setting_group' => 'home_page', 'created_at' => now()

            ],
            [
                'key' => 'home_category_5',
                'label' => 'دسته بندی صفحه اول ردیف پنجم',
                'value_fa' => '',
                'value_en' => '',
                'type' => 'home_category',
                'length_limit' => '120',
                'setting_group' => 'home_page', 'created_at' => now()

            ],
            [
                'key' => 'vip_takhfif1',
                'label' => 'تخفیف ویژه صفحه ی اول 1',
                'value_fa' => '',
                'value_en' => '',
                'type' => 'home_takhfif',
                'length_limit' => '120',
                'setting_group' => 'home_page', 'created_at' => now()

            ],
            [
                'key' => 'vip_takhfif2',
                'label' => 'تخفیف ویژه صفحه ی اول 2',
                'value_fa' => '',
                'value_en' => '',
                'type' => 'home_takhfif',
                'length_limit' => '120',
                'setting_group' => 'home_page', 'created_at' => now()

            ]

        ];
        foreach ($data as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);

        }

    }
}
