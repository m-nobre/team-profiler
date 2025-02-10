![Screenshot](https://raw.githubusercontent.com/m-nobre/team-profiler/master/art/screenshot.png)

  

# Team profiler

  

[![Latest Stable Version](https://poser.pugx.org/m-nobre/team-profiler/version.svg)](https://packagist.org/packages/m-nobre/team-profiler)

[![License](https://poser.pugx.org/m-nobre/team-profiler/license.svg)](https://packagist.org/packages/m-nobre/team-profiler)

[![Downloads](https://poser.pugx.org/m-nobre/team-profiler/d/total.svg)](https://packagist.org/packages/m-nobre/team-profiler)

  

Laravel Teams Profiler (Change frontend Team denomination)

Change the appearance of all existing jetstream team routes into the chosen denomination ('project' by default) and that can be changed on the fly, as many times as required, in the team-profiler.php config file after published.

While on early stages of development and still trying to find the best solutions, Team Profiler can serve as a non-intrusive and effective example of how to achieve this, yet further testing is required in order to assert limitations and possibilities.

As described:
 - Masks existing Jetstream Teams routes as desired, across the whole application, with one single parameter.
 - Uses Laravel's built-in Translation system to change all existing values
 - By default changes "Teams" to "Projects", but user can easily change this effortlessly across the whole application, only by changing the config value.
 - When user updates denomination in config file, Team Profiler will recreated relevant translations while keeping your custom ones safe
 - Removal of Team Profiler will revert app to default configuration (Team Profiler routes become ineffective and jetstream routes return to normal)
 - Auto removal and clean up method provided: despite created routes being non intrusive (become ineffective if package is not installed), the normal "composer remove" will not remove inserted routes and translations, user can choose to automatically delete these while safeguarding their work, yet for this is important to not add anything in the TeamProfiler section, only before or after, under the risk of loosing such data upon uninstall.


Please remember that despite the apparent stability, this is still in development and should be only used as a starting point for more robust solution

  

## Installation
>:warning: **New applications only** 
>Team-Profiler should only be installed into **new** Laravel Jetstream applications
>Requirements:
>- EN locale
>- To change denomination from "project" please publish config file.
>- Once denomination has been changed, page needs to be refreshed twice to allow new terms to take place.


>:warning: Routes will be added to routes/web.php, do not enter any information in the TeamProfiler section in routes file, only before or after otherwise data may be lost upon automatic removal, the other file that will be created or updated is the translation file, will be added as lang/en.json, so despite our best efforts to safeguard your data in those files, if not installing into a new fresh laravel jetstream application then make sure to back up them up before advancing.

  

You may use Composer to install Team Profiler into your new Laravel Jetstream project:

  

```bash

composer  require  m-nobre/team-profiler

```

  

## Publish Config

  

you can publish config file by use this command

  

```bash

php  artisan  vendor:publish  --tag="team-profiler-config"

```



## Automatic Removal

  
If you wish to remove Team Profiler manually, you may do so using composer in the normal way, then you can proceed to delete translations in "lang/en.json" and the TeamProfiler routes in "routes/web.php" despite these becoming ineffective upon composer removal.

If you wish to proceed with automatic removal then ensure you have not added any data inside the TeamProfiler section in "routes/web.php", as it will be removed, yet, any custom routes before and after TeamProfiler section will be safeguarded, same as custom translations.

If you wish to proceed with automatic removal then use this command


```bash

php  artisan  team-profiler:uninstall

```

## Changelog
  
Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

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