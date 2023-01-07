<?php

namespace App\Providers;

use App\Models\LanguageString;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(Schema::hasTable('language_strings')){
            $response = LanguageString::all();
            foreach($response as $setting){
                //dd($setting->name_key);
                Config::set('languageString.' . $setting->name_key, $setting->name);
            }
        }
    }
}
