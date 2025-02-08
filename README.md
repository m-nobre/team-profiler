![Screenshot](https://raw.githubusercontent.com/m-nobre/team-profiler/master/art/screenshot.png)

  

# Team profiler

  

[![Latest Stable Version](https://poser.pugx.org/m-nobre/team-profiler/version.svg)](https://packagist.org/packages/m-nobre/team-profiler)

[![License](https://poser.pugx.org/m-nobre/team-profiler/license.svg)](https://packagist.org/packages/m-nobre/team-profiler)

[![Downloads](https://poser.pugx.org/m-nobre/team-profiler/d/total.svg)](https://packagist.org/packages/m-nobre/team-profiler)

  

Laravel Teams Profiler (Change frontend Team denomination)

This package makes it possible to change the appearance of all existing jetstream team routes into the chosen denomination ('project' by default) and that can be changed, on the fly, as many times as required, in the team-profiler.php config file after published.
While on early stages of development and still trying to find the best solutions, Team Profiler can serve as a non-intrusive and effective example of how to achieve this, yet further testing is required in order to assert limitations and possibilities.

As described:
 - Masks existing Jetstream Teams routes as desired, across the whole application, with one single parameter.
 - By default changes "Teams" to "Projects", but user can easily change this effortlessly, all across the application, only by changing the config value and then deleting lang/en,json.
 - Uses Translation file (en) to change all existing occurrences of "Team" and "team" across the application, when user updates denomination in config file, my delete the old "Lang/en,json" so a new translation file can be generated, on the fly, to include the new denomination defined in config.  
 - Upon removal of Team Profiler, deleting translations (lang/en.json) will revert app to default configuration, routes file (routes/web.php) will contain some routes inserted by Team Profiler, yet these will become inactive as soon as package is uninstalled, user can safely remove TeamProfiler section in the Routes/Web.php file.

  



Not only the routes but all occurrences of "Team" or "team" in Jetstream views will also, and literaly, be translated into the chosen denomination in the EN locale, for this, the native lang folder with en.json will be created, when changing denomination, only need to delete the Lang/en.json and a new translation is generated on boot.

  

Please remember that despite the apparent stability, this is still in development and should be only used as a starting point for more robust solution

  

## Installation
>:warning: **New applications only** 
>Team-Profiler should only be installed into **new** Laravel Jetstream applications
>Requirements:
> - EN locale
> - Creates a Lang/en.json file, does not exist in new applications.
>- To change denomination from "project" please publish config file.
>- Once denomination has been changed, lang file needs to be deleted so it's generated using the new denomination.

For all the reasons above, Team-Profiler should **only** be installed into **new** Laravel Jetstream applications, attempting to install Team-Profiler into an existing Laravel application may result in unexpected behavior, issues and/or loss of data (namely routes or translations being replaced).
>Routes will be added to routes/web.php and translation file will be added as lang/en.json, make sure to back up these files case theres work you would like to save or ensure it is only installed on a new application.

  

You may use Composer to install Team Profiler into your new Laravel Jetstream project:

  

```bash

composer  require  m-nobre/team-profiler

```

  

## Publish Assets

  

you can publish config file by use this command

  

```bash

php  artisan  vendor:publish  --tag="team-profiler-config"

```

  

## Credits

  
Developer
- [Mário Nobre](mailto:m.nobre@ymail.com)

With inspiration from
- [Mark Nuyens](https://marknuyens.nl/tips/renaming-teams-in-laravel-jetstream)
- [dsbilling (Laracasts Discussion contribution)](https://laracasts.com/discuss/channels/laravel/best-way-to-rename-teams-for-projects-with-jetstream)
  
  Thank you,
  
  "Only by acknowledging the success and sacrifice made by those who came before us, can we fully understand what we must do to ensure the liberty of those who will succeed us." Yvette Clarke

## License

  

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.