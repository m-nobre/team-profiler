<?php

namespace MNobre\TeamProfiler\Console;

use Illuminate\Console\Command;
use \Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;



class TeamProfilerUninstall extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'team-profiler:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'uninstall package and publish assets';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Uninstalling Team Profiler.');
        $this->info('Removing Custom Routes...');

        $user_routes = file_get_contents(base_path('routes/web.php'));

        $section_start = explode("/*TeamProfiler", $user_routes);
        $section_end = explode("TeamProfiler*/", $section_start[1]);
        $user_data = [$section_start[0], $section_end[1]];
        $text = implode("\n", $user_data);
        file_put_contents(base_path('routes/web.php'), $text.PHP_EOL);
        $this->info('Removing Package translations..');
        
        $this->cleanProfilerTranslation() ? 
            $this->info('Removed translations successfully') : 
            $this->error('Error removing translations, check file.');
        
        $this->info('Thank you.');

        passthru('composer remove m-nobre/team-profiler');
    }

    public function cleanProfilerTranslation(): bool {
        
        $profilerDenomination = config('team-profiler.denomination'); // project
        $profilerFirstTrKey = array_key_first(config('team-profiler.translations')); // Returns "Team Name"
        $profilerFirstTrValue = Lang::get($profilerFirstTrKey); // The translation for key "Team Name". Returns "Project Name"

        try {
            if (Lang::hasForLocale($profilerFirstTrKey, 'en') && strpos( strtolower($profilerFirstTrValue), strtolower($profilerDenomination))) {
                
                // folder exists
                $existing_translations = json_decode(file_get_contents(lang_path('en.json')), true);
    
                foreach (config('team-profiler.translations') as $key => $value) {
                    
                    if (!empty($existing_translations[$key])) {
                        Log::info(strtolower($existing_translations[$key])." - ". strtolower($profilerDenomination));
                        if (
                            str_contains(strtolower($existing_translations[$key]), strtolower($profilerDenomination)) ||
                            str_starts_with(strtolower($existing_translations[$key]), strtolower($profilerDenomination))
                            ) {
                            Log::info(strtolower($existing_translations[$key])." - ". strtolower($profilerDenomination));
                            unset($existing_translations[$key]);
                        }
                    }
                }
                
                file_put_contents(lang_path('en.json'), json_encode($existing_translations, JSON_PRETTY_PRINT));

                return true;
    
            }
        } catch (\Throwable $th) {            
            return false;
        }
        return false;
    }
}