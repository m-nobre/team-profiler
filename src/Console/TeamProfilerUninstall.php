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

        $user_routes = file_get_contents(base_path('routes/web.php'));

        $section_start = explode("/*TeamProfiler", $user_routes);
        $section_end = explode("TeamProfiler*/", $section_start[1]);
        $user_data = [$section_start[0], $section_end[1]];
        $text = implode("\n", $user_data);
        file_put_contents(base_path('routes/web.php'), $text.PHP_EOL);
    }
}
