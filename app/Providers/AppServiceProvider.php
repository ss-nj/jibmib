<?php

namespace App\Providers;

use App\Http\Shop\Models\Shop;
use App\Http\View\Composers\SharedDataComposer;
use Exception;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'ShopLicences' => Shop::class,
            'ShopImage' => Shop::class,
            'ShopLogo' => Shop::class,
        ]);

        Schema::defaultStringLength(191);

        //اضافه کردن پجینیت به کالکشنها
        try {
            // Enable pagination
            if (!Collection::hasMacro('paginate')) {

                Collection::macro('paginate',
                    function ($perPage = 15, $page = null, $options = []) {
                        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                        return (new LengthAwarePaginator(
                            $this->forPage($page, $perPage)->values()->all(), $this->count(), $perPage, $page, $options))
                            ->withPath('');
                    });
            }
        } catch (\Exception $exception) {
            Log::info($exception);
        }

        try {

            View::composer(
                ['*'],
                SharedDataComposer::class
            );


        } catch (Exception $exception) {
            Log::info($exception);

        }
    }
}
