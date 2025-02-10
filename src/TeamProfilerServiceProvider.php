<?php

namespace MNobre\TeamProfiler;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class TeamProfilerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \MNobre\TeamProfiler\Console\TeamProfilerInstall::class,
        ]);
 
        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/team-profiler.php', 'team-profiler');
 
        //Publish Config
        $this->publishes([
           __DIR__.'/../config/team-profiler.php' => config_path('team-profiler.php'),
        ], 'team-profiler-config');
 
        //Register Routes
        $this->addRoutesToWeb();

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

 
    }

    public function boot(): void
    {
        // check if translation exists
        if (!strpos(strtolower(Lang::get(array_key_first(config('team-profiler.translations')))), strtolower(config('team-profiler.denomination')))) {
            dd("whoah");
        }
            // if yes
                // checks if it's team profiler
                    // compare both by number of entries and keys
                // checks teams key
                    // if no teams key then it's custom file
                        // save to merge later
                    // if teams key
                      

        // // $this->addRoutesToWeb();
        // // $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // /* If "Manage Team" translation already exists in EN */

        // if (!Lang::hasForLocale(array_key_first(config('team-profiler.translations')), 'en') || !strpos(strtolower(Lang::get(config('team-profiler.translations'))), strtolower(config('team-profiler.denomination')))) {


        //     // if file exists we will parse json to keep current translations
            
        //     // try {

        //     //     $lang_array = json_decode(file_get_contents(lang_path('en').".json"), true);

        //     // } catch (\Throwable $th) {
                
        //     //     // TODO - deal with exception case it is not "file not found" and some other error
        //     //     // is_array(array_key_exists(3, explode(":",$th->getMessage())))
                
        //     //     // File not found, we create  a empty array
        //     //     $lang_array = array();

        //     // }

        //         // if no error, file exists, we need to;

        //             // 1 loop through keys and compare with profiler ones, 
        //                 // if existing then update with translated value from config
        //                 // if not then append to array with translated value from config


        //         $translated = array();

        //         foreach (config('team-profiler.translations') as $key => $value) {

        //             /* str_contains is case sensitive */
                    
        //             $translated[$key] = str_replace("Team", ucfirst(config('team-profiler.denomination')), str_replace("team", strtolower(config('team-profiler.denomination')), $key));


        //         }
                
        //         // $existing_translations = json_decode(file_get_contents(lang_path().'en.json'), true) ?? false;
        //         // dd(count($existing_translations).".".count(config('team-profiler.translations')));
        //         foreach ($translated as $key => $value) {
        //             /* we would override anyway, so simplified by just updating case exists */
        //             $lang_array[$key] = $value;
        //         }
        //             // 2. save lang file
        //             $file = lang_path('vendor/team-profiler/en.json');
                
        //             File::ensureDirectoryExists(lang_path("vendor/team-profiler/"));

        //             // if (Storage::exists($file)) {
        //             //     if ($existing_translations) {
        //             //         /* 
        //             //         existing translations... possibilities:
        //             //         - 
        //             //         - user has changed denomination and there are routes with previous denomination
        //             //         - user has defined some before instlling team profiler (it's not new app, then lower priority)
        //             //         - both of the above, yet user installed with new app but added custom translations to file in the meantime, but now changed denomination, so in this case we need both

        //             //         let's deal with some same time:
        //             //         - let's find if there are any custom translations by checking both translation arrays against each other
        //             //             - if there are, and denomination is different, then we need to merge them with new translation
        //             //             - if there are not, and denomination exists and is the same, then nothing is needed
        //             //         */
        //             //     }
        //             // }


        //             file_put_contents($file, json_encode($lang_array, JSON_PRETTY_PRINT));

        //             $this->loadTranslationsFrom(lang_path('vendor/team-profiler'));

        // }
    }

    public function checkValue($needle, $haystack){
        
        if (is_array($haystack)) {
            foreach (array_values($haystack) as $value) {
                if (str_contains(strtolower($value), strtolower($needle))) {    
                    return true;
                }
            }
        } elseif (is_string($haystack)) {
            if (str_contains(strtolower($haystack), strtolower($needle))) {    
                return true;
            }
        }

        return false;  
    
    }
    public function addRoutesToWeb(){
        
        $profiler_routes = file_get_contents(__DIR__.'/../routes/web.php');
        $truncated_routes = implode("\n", array_slice(explode("\n", $profiler_routes), 3));
        $user_routes = file_get_contents(base_path('routes/web.php'));

        if (!$this->checkValue('MNobre', $user_routes)) {
            try {
                file_put_contents(base_path('routes/web.php'), $truncated_routes.PHP_EOL , FILE_APPEND | LOCK_EX);
                // \Artisan::call('optimize');
                return true;
    
            } catch (\Throwable $th) {
                return false;
            }
        }
    }
    public function postPackageUninstall(){
        
        // not working :(

        $user_routes = file_get_contents(base_path('routes/web.php'));

        $section_start = explode("/*TeamProfiler", $user_routes);
        $section_end = explode("TeamProfiler*/", $section_start[1]);
        $user_data = [$section_start[0], $section_end[1]];
        $text = implode("\n", $user_data);
        file_put_contents(base_path('routes/web.php'), $text.PHP_EOL);

    }

}
