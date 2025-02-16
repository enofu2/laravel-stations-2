<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        ## [2024.01.24|Hara Takanobu] :start
        # laravel-er-diagram-generatorの設定(ローカル環境下の時だけロードする)
        if ($this->app->environment('local')) {
            $this->app->register(\BeyondCode\ErdGenerator\ErdGeneratorServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        
        //Paginator::useTailwind();
        Paginator::useBootstrap();
        //Paginator::defaultView('vendor.pagination.tailwind');
        
        
        if (config('app.env') !== 'production') {
            DB::listen(function ($query) {
                Log::info("Query Time:{$query->time}s] $query->sql");
            });
        }
        
        
    }
}
