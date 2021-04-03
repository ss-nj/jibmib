<?php

namespace App\Http\Core\Controllers;

use App\Http\Commerce\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Core\Models\Image;
use App\Http\Core\Models\Setting;
use App\Http\Shop\Models\Takhfif;
use function dd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    /**
     * @var array
     */
    private $defaultOption;

    public function __construct()
    {
        $this->defaultOption = [
            'size' => ['width' => 420, 'height' => 100],
            'watermark' => false,
            'changesize' => true,
            'dir' => 'img/settings'
        ];
    }

    public function update(Request $request)
    {
//        dd($request);
//        if (!Auth::user()->can('update-setting')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $request->validate([
            'logo' => 'file|mimes:jpeg,png,svg',
            'factor_logo' => 'file|mimes:jpeg,png,svg',
            'site_logo' => 'file|mimes:jpeg,png,svg',
            'watermark' => 'file|mimes:jpeg,png,svg',
            'home_banner_mobile' => 'file|mimes:jpeg,png,svg',
            'home_bottom_banner' => 'file|mimes:jpeg,png,svg',
            'home_banner_web' => 'file|mimes:jpeg,png,svg',
            'application_download_link' => 'file|mimes:apk',

        ]);
        $settings = $request->settings;

        if ($settings) {
            foreach ($settings as $key => $setting) {
                Setting::where('key', $key)->update([
                    'value_fa' => $setting
                ]);
            }
        }
        $this->saveFiles($request);

        return redirect()->back();
    }

    /**
     * @param Request $request
     */
    private function saveFiles(Request $request): void
    {
        $maps = [
            ['factor_logo', 'factor_logo'], ['site_logo', 'site_logo'], ['watermark', 'watermark'],
            ['home_banner_mobile', 'home_banner_mobile'],
            ['home_bottom_banner', 'home_bottom_banner'],
            ['home_banner_web', 'home_banner_web'],
            ['application_download_link', 'application_download_link'],

        ];

        foreach ($maps as $map) {
            $file = $request->file($map[0]);
//            dd($file);
            if ($file) {
                $setting = Setting::where('key', $map[1])->first();
                try {
                    //save curent path for ramove
                    $path = $setting->value_fa;
//                    get extention and file name
                    $extention = '.' . $file->getClientOriginalExtension();
                    $imageName = uniqid() . md5($file->getClientOriginalName()) . $extention;
                    //save file to folder
                    $imgaddress = $file->move($this->defaultOption['dir'], $imageName)->getpathname();
                    Image::removeImage($path);
                    $setting->update(['value_fa' => $imgaddress]);

                } catch (\Exception $e) {
                    Log::info($e);
                }
            }
        }
    }

    public function settingPages($pages)
    {
//        if (!Auth::user()->can('read-setting')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $titleMap = [
            'application' => 'اپلیکیشن',
            'register' => 'ورود و ثبت نام',
            'about_us_page' => 'درباره ی ما',
            'footer' => 'فوتر',
            'general_settings' => 'عمومی',
            'commerce' => 'مالی',
            'logo' => 'لوگوها',
            'social' => 'شبکه های اجتماعی',
            'seo' => 'سئو',
            'licences' => 'مجوزها',
            'policy' => 'قوانین سایت',
            'abuse' => 'شکایات',
            'contact_us' => 'تماس با ما',
            'user_guide' => 'راهنمای کاربر',
            'home_page' => 'صفحه ی اول',
        ];

        $title = $titleMap[$pages];
        $settings = Setting::where('setting_group', $pages)->get();

        $categories = null;
        if ($pages === 'home_page')
            $categories = Category::all();

        $takhfifs = null;
        if ($pages === 'home_page')
            $takhfifs = Takhfif::all();

        return view('panel.settings.settings', compact('settings', 'title', 'categories', 'takhfifs'));
    }


}
