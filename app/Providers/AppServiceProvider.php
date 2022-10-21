<?php

namespace App\Providers;

//use Dotenv\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use function foo\func;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('image64', function ($attribute, $value, $parameters, $validator){
            $ext = explode('/', explode(':', substr($value, 0, strpos($value, ";")))[1])[1];
            if(in_array($ext, $parameters)){
                return true;
            }
            else{
                return false;
            }
        });

        Validator::replacer('image64', function ($message, $attribute, $rule, $parameters){
            return str_replace(':value', join(",", $parameters), $message);
        });
    }
}
