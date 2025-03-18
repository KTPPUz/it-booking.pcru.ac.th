<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use App\Services\V3\KeycloakService as KeycloakSocialiteProvider;
use Illuminate\Support\Facades\Log;

class KeycloakProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
            // Socialite::extend('keycloak', function ($app) {
            //     $config = $app['config']['services.keycloak'];
            //     return Socialite::buildProvider(KeycloakSocialiteProvider::class, $config);
            // });

            $this->app->register(\SocialiteProviders\Manager\ServiceProvider::class);
                app('events')->listen(SocialiteWasCalled::class, function (SocialiteWasCalled $event) {
                    $event->extendSocialite('keycloak', \SocialiteProviders\Keycloak\Provider::class);
            });
            // Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            // $event->extendSocialite('services.keycloak', \SocialiteProviders\Keycloak\Provider::class);
        // });
        
    }
}