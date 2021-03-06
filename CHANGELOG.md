# Changelog

## 2.0.1 - 2018-08-31
### Changed
- Remove PHP version requirement (fixes [#2])

[#2]: https://github.com/experience/entitle.craft-plugin/issues/2

## 2.0.0 - 2018-04-01
### Added
- Update for Craft 3.

## 1.1.1 - 2017-02-19
### Fixed
- Fix fatal error, caused by PHPStorm auto-import.

## 1.1.0 - 2017-02-19
### Added
- Implement support for UTF-8 strings.
- Implement support for strings containing multiple sentences.

### Changed
- Safety first; if all else fails, return the original string.
- Rewrite parser to be more robust. Thank lucky stars for unit tests.
- Improve instructions on settings page.

### Fixed
- Fix issue with words containing an apostrophe.

## 1.0.0 - 2017-02-18
### Added
- Add "release" zips to repository.

### Changed
- Move `releases.json` to root of repository.
- Update "releases feed" URL in `plugin.json`.

## 0.4.0 - 2017-02-14
### Changed
- Remove normalisation of "conjunctions" (+, &, *).

### Fixed
- Fix issue with version number strings (e.g. "5.7.5+").
- Fix documentation URL in `plugin.json`.
- Ensure plugin doesn't attempt to run database migrations on update.

## 0.3.0 - 2017-02-13
### Added
- Add proper plugin icon.

### Changed
- Move plugin README to root.
- Remove build process files from repo.
- Remove "release" zip files from repo.

### Fixed
- Fix "diff" URLs in CHANGELOG.

## 0.2.0 - 2017-02-11
### Added
- Add documentation URL.
- Add releases feed URL.
- Add support for automated testing on Travis CI.

### Fixed
- Fix "latest release" URL in `src/README.md`.

## 0.1.0 - 2017-02-11
### Added
- Implement `craft()->entitle->capitalize` service method.
- Implement `craft.entitle.capitalize` template variable.
- Implement `entitle` Twig filter.
