<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
class ValidatorServiceProvider extends ServiceProvider {

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        $this->app['validator']->extend('numericarray', function ($attribute, $value, $parameters) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    if (!is_int($v))
                        return false;
                } return true;
            } return is_int($value);
        });
   
    }
    
    

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
