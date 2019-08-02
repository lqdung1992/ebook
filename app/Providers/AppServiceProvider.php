<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Schema;
use App\tbltype;
use App\tbllanguage;
use App\tblauthor;
use App\tblpublisher;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        view()->composer('user.layout.header',function($view){
                $theloai = tbltype::all();
                $ngonngu = tbllanguage::all();
                $tacgia = tblauthor::all();
                $nhaxuatban = tblpublisher::all();
                $view->with('theloai',$theloai);
                $view->with('ngonngu',$ngonngu);
                $view->with('tacgia',$tacgia);
                $view->with('nhaxuatban',$nhaxuatban);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production'
            && class_exists(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class)) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        //
        Passport::ignoreMigrations();
    }
}
