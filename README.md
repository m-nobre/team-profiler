![Screenshot](https://raw.githubusercontent.com/m-nobre/team-profiler/master/art/screenshot.png)

# Team profiler

[![Latest Stable Version](https://poser.pugx.org/m-nobre/team-profiler/version.svg)](https://packagist.org/packages/m-nobre/team-profiler)
[![License](https://poser.pugx.org/m-nobre/team-profiler/license.svg)](https://packagist.org/packages/m-nobre/team-profiler)
[![Downloads](https://poser.pugx.org/m-nobre/team-profiler/d/total.svg)](https://packagist.org/packages/m-nobre/team-profiler)

Larvel Teams Profiler (Change frontend Team denomination)

Just by adding non intrusive routes (which become ineffective upon package removal despite requiring manual removal) this package makes it possible to effectively change the appearance of all team routes into the denomination chose in the team-profiler.php config file which can be published by following instructions below.
The remaining terms spread out in Jetstream views are also and literaly translated into the denomination in the EN locale, for this, lang folder with en.json will be created.
Please remember that despite the apparent stability, this is still in development and should be only used as a starting point for more robust solution
## Installation

You may use Composer to install Team Profiler into your new Laravel Jetstream project:

```bash
composer require m-nobre/team-profiler
```

>:warning: **New applications only** 
>Team-Profiler should only be installed into new Laravel Jetstream applications and in EN locale. 
>Attempting to install Team-Profiler into an existing Laravel application may result in unexpected behavior, issues and/or loss of data: Routes will be added to routes/web.php and translation file will be added as lang/en.json, make sure to back up these files case theres work you would like to save or ensure it is only installed on a new application.


After installing the Team-Profiler package, new routes will be added to your main routes file, these routes are written in a **non-intrusive** way as auto-removal is not available, these routes can manually be removed upon uninstallation.

## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="team-profiler-config"
```

## Credits

- [Mário Nobre](mailto:m.nobre@ymail.com)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
