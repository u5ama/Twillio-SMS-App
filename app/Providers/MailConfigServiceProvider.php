<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\SmtpCredential;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
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
        $array = [];
        $settings = SmtpCredential::where('status', 'Active')->get();
        foreach($settings as $setting){
            $array['driver'] = $setting->mail_driver;
            $array['host'] = $setting->mail_host;
            $array['port'] = $setting->mail_port;
            $array['username'] = $setting->mail_username;
            $array['password'] = $setting->mail_password;
            $array['encryption'] = $setting->mail_encryption;
            $array['from']['address'] = $setting->mail_from_address;
            $array['from']['name'] = env('APP_NAME');
        }
        $data = var_export($array, 1);
        if(\File::put(base_path() . '/config/mail.php', "<?php\n return $data ;")){
        }
        Artisan::call('config:clear');
    }

}
