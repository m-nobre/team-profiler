<?php

namespace MNobre\TeamProfiler\Console;

use Illuminate\Console\Command;
use Composer\Script\Event;
use Composer\Installer\PackageEvent;



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
        $this->info('Removing Package..');

        if (function_exists('pcntl_fork')) {
            $pid = pcntl_fork();
            switch($pid){
                case -1:    
                    $this->Error('Could not fork');
                    break;
    
                case 0:    
                    exec("php composer remove m-nobre/team-profiler");
                    
                    break;
    
                default: 
                    echo "Running uninstaller...";
                    echo "Thank you.";
                    break;
    
            }
        } else {
            exec('php composer remove m-nobre/team-profiler > /dev/null &');
        }
    }
}