<?php

namespace MNobre\TeamProfiler\Console;

use Illuminate\Console\Command;
use Composer\Script\Event;
use Composer\Installer\PackageEvent;



class TeamProfilerInstall extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'team-profiler:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install package and publish assets';

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
        $this->info('Publish Vendor Assets');
        // $this->artisanCommand(['vendor:publish --tag="team-profiler-config"']);
        $this->info('To publish config file run `php artisan vendor:publish --tag="team-profiler-config"`');
        $this->artisanCommand(["optimize:clear"]);
        $this->info('Congratulations, Team profiler was installed successfully.');
    }
}
