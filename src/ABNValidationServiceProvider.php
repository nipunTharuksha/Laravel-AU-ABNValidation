<?php

namespace Nipun\Abnvalidation;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rule;
use Nipun\Abnvalidation\Rules\IsAValidAustralianBusinessNumber;

class ABNValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['validator']->extendDependent('valid_abn', IsAValidAustralianBusinessNumber::class . '@validate');

        Rule::macro('valid_abn', function () {
            return new IsAValidAustralianBusinessNumber;
        });
    }
}
