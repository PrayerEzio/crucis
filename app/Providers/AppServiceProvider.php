<?php

namespace App\Providers;

use App\Http\Models\GoodsCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        view()->composer('Home._layouts.navbar', function ($view) {
            $goods_category_model = new GoodsCategory();
            $goods_category_list = $goods_category_model->parent(0)->get();
            $view->with('goods_category_list',$goods_category_list);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
