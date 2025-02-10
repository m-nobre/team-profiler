<?php

namespace MNobre\TeamProfiler;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;



class TeamProfilerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
        //    \MNobre\TeamProfiler\Console\TeamProfilerInstall::class,
           \MNobre\TeamProfiler\Console\TeamProfilerUninstall::class,
        ]);
 
        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/team-profiler.php', 'team-profiler');
 
        //Publish Config
        $this->publishes([
           __DIR__.'/../config/team-profiler.php' => config_path('team-profiler.php'),
        ], 'team-profiler-config');
 
        //Register Routes
        $this->addRoutesToWeb();

        // $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

 
    }

    public function boot(): void
    {
        // checks, creates and or appends translations
        $this->checkProfilerTranslation();
    }

    public function checkProfilerTranslation(): bool {
        
        $profilerDenomination = config('team-profiler.denomination'); // project
        $profilerFirstTrKey = array_key_first(config('team-profiler.translations')); // Returns "Team Name"
        $profilerFirstTrValue = Lang::get($profilerFirstTrKey); // The translation for key "Team Name". Returns "Project Name"

        // if translation for teams in english is set and if the correspondent translation includes our custom denomination returns true
        if (Lang::hasForLocale($profilerFirstTrKey, 'en') && strpos( strtolower($profilerFirstTrValue), strtolower($profilerDenomination))) {
            
            // folder exists
            $existing_translations = json_decode(file_get_contents(lang_path('en.json')), true);

            if (!array_diff_key($existing_translations, config('team-profiler.translations')) && count($existing_translations) === count(config('team-profiler.translations'))) {
                
                return true;
            
            } else {

                if ($this->createProfilerTranslations(true)) {
                    return true;
                }
            }

            return false;

        } else { // translation does not exist
            /* check for file */
            if(!File::exists(lang_path('en.json'))) {

                // path does not exist, create our file guilt free
                if ($this->createProfilerTranslations()) {
                    return true;
                }
                // else
                return false;
            }

            // File exists yet no ProfilerTranslations
            // so we need to append to file by passing "true" as attribute
            if ($this->createProfilerTranslations(true)) {
                return true;
            }

        }


        return false;
    }
    public function createProfilerTranslations($append = false): bool {
        
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

        try {
            // double verification file exists if append is True
            if ($append && File::exists(lang_path('en.json'))) { 
                $existing_translations = json_decode(file_get_contents(lang_path('en.json')), true);
                $lang_array = $lang_array + $existing_translations;
            }
            
            file_put_contents(lang_path('en.json'), json_encode($lang_array, JSON_PRETTY_PRINT));
            
            return True;

        } catch (\Throwable $th) {
            
            Log::debug('Error saving translation file by TeamProfiler', array($th->getMessage()));
            
            return False;
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

    //not working... TODO
    public function prePackageUninstall(){
        
        // not working :(

        $user_routes = file_get_contents(base_path('routes/web.php'));

        $section_start = explode("/*TeamProfiler", $user_routes);
        $section_end = explode("TeamProfiler*/", $section_start[1]);
        $user_data = [$section_start[0], $section_end[1]];
        $text = implode("\n", $user_data);
        file_put_contents(base_path('routes/web.php'), $text.PHP_EOL);

    }

}
