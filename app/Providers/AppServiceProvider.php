<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use League\Fractal\Resource\ResourceAbstract;
use Webmozart\Assert\Assert;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        /**
         * Sugar to fractal transformer responses 
         */
        Response::macro('json_from_transformer', function ($value) {
            Assert::isInstanceOf($value, ResourceAbstract::class, 'Transofrmer must be instance of %2$s. Got: %s');

            $fractal = new Manager();

            return Response::json($fractal->createData($value), options: JSON_PRETTY_PRINT);
        });
    }

}
