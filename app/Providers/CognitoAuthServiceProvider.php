<?php
namespace App\Providers;

use App\Auth\CognitoGuard ;
use App\Cognito\CognitoClient ;
use Illuminate\Support\ServiceProvider ;
use Illuminate\Foundation\Application ;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient ;

class CognitoAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(CognitoClient::class, function (Application $app) {
            $config = [
                'region'      => config('cognito.region', 'ap-northeast-1'),
                'version'     => config('cognito.version', 'latest'),
                'credentials' => [
                    'key' => config('cognito.key', 'AKIA4LAKE72Y6RZJVB7T'),
                    'secret' => config('cognito.secret', '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'),
                ]
            ];

            return new CognitoClient(
                new CognitoIdentityProviderClient($config),
                config('cognito.app_client_id'),
                config('cognito.app_client_secret'),
                config('cognito.user_pool_id')
            );
        });

        $this->app['auth']->extend('cognito', function (Application $app, $name, array $config) {
            $guard = new CognitoGuard(
                $name,
                $app->make(CognitoClient::class),
                $app['auth']->createUserProvider($config['provider']),
                $app['session.store'],
                $app['request']
            );

            $guard->setCookieJar($this->app['cookie']);
            $guard->setDispatcher($this->app['events']);
            $guard->setRequest($this->app->refresh('request', $guard, 'setRequest'));

            return $guard;
        });
    }
}
