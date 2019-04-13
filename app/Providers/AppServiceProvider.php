<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //css jsにタイムスタンプを設定して毎回最新を読み込ませる
        Blade::directive('addtimestamp', function ($expression) {
            $path = public_path($expression);

            try {
                $timestamp = \File::lastModified($path);
            } catch (\Exception $e) {
                $timestamp = Carbon::now()->timestamp;
                report($e);
            }

            return asset($expression) . '?v=' . $timestamp;
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
