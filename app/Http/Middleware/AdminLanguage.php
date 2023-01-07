<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\LanguageString;
use Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Session::has('locale')){
            App::setLocale(Session::get('locale'));
        } else if(Auth::user()->locale == 'ar'){
            App::setLocale(Auth::user()->locale);
        } else{
            if(substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2) == 'en'){
                App::setLocale('en');
            } else{
                App::setLocale('ar');
            }
        }

        if(Schema::hasTable('language_strings')){
            $response = LanguageString::listsTranslations('name')
                ->select('language_strings.name_key', 'language_string_translations.name')
                ->get();
            foreach($response as $setting){
                Config::set('languageString.' . $setting->name_key, $setting->name);
            }
        }
       
        return $next($request);
    }
}
