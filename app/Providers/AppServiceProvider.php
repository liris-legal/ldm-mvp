<?php

namespace App\Providers;

use App\Services\FileService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('FileService', function () {
            return new FileService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //　追加
        Validator::extendImplicit('cognito_user_unique', 'App\Validators\CognitoUserUniqueValidator@validate');
    }
}
