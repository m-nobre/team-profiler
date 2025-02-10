## [1.1.1] - 2025-02-10

### Added

- Changelog

### Changed

- Changed Route Noun to be always lowercase to minimize impacts of user input in config, can be "Project" or "project" and system keeps it consistent

### Removed

- Post and Pre Uninstall scripts as following documentation does not seem possible to achieve due to being a package, maybe some for as a plugin yet once it's only a section that user must remove on the post uninstall, the TeamProfiler section in the routes file that only gets called case package is installed and it's completely bypassed otherwise. So clean up is not priority, will make sure documentation reflects this so user has the information in the meantime.

## [1.0.2] - 2025-02-09

### Changed

- Improved Translation method so it works better with previous translations and same time recreates the file when denomination changed.

### Removed

- Duplicated actions on Boot and Register (it worked!), so debugged which is really essential and removed where unnecessary.

## [1.0.1] - 2025-02-08

### Added

- Pilot app
- Documentation

## [1.0.0] - 2025-02-08

### Added

- Basesystem


[1.0.2]: https://github.com/m-nobre/team-profiler/compare/v1.0.1...v1.0.2
[1.0.1]: https://github.com/m-nobre/team-profiler/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/m-nobre/team-profiler/releases/tag/v1.0.0