<?php

namespace MNobre\TeamProfiler;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\RouteCollectionInterface;
use Laravel\Jetstream\Jetstream;



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
        $this->addRoutesToWeb();
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if (!Lang::hasForLocale(array_key_first(config('team-profiler.translations')), 'en')) {

            // if file exists we will parse json to keep current translations
            
            try {

                $lang_array = json_decode(file_get_contents(lang_path('en').".json"), true);

            } catch (\Throwable $th) {
                
                // TODO - deal with exception case it is not "file not found" and some other error
                // is_array(array_key_exists(3, explode(":",$th->getMessage())))
                
                // File not found, we create  a empty array
                $lang_array = array();

            }

                // if no error, file exists, we need to;

                    // 1 loop through keys and compare with profiler ones, 
                        // if existing then update with translated value from config
                        // if not then append to array with translated value from config


                $translated = array();

                foreach (config('team-profiler.translations') as $key => $value) {

                    /* str_contains is case sensitive */
                    
                    $translated[$key] = str_replace("Team", ucfirst(config('team-profiler.denomination')), str_replace("team", strtolower(config('team-profiler.denomination')), $key));


                }

                foreach ($translated as $key => $value) {
                    /* we would override anyway, so simplified by just updating case exists */
                    $lang_array[$key] = $value;
                }
    
                    // 2. save lang file
                
                    File::ensureDirectoryExists(lang_path());

                    file_put_contents(lang_path('en').".json", json_encode($lang_array, JSON_PRETTY_PRINT));
           
        }
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
