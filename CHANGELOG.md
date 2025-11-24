# Changelog

All notable changes to `evo-laravel-profanity` will be documented in this file.

## v1.1.1: Like s**t off a shovel - 2025-11-24

- **Improvement**: Switched to using an HTTP pool request to update profanity source files

## v1.1.0: Dropping that b*****d pest dependency - 2025-11-02

- **Improvement**: Package drops Pest's profanity package as a dependency, instead running a command to download the definition files to storage. Please see README for new installation instructions.
- **Improvement**: Switched to new [AhoCorasick](https://github.com/wikimedia/AhoCorasick) search algorithm rather than using regex
- **Improvement**: Added caching to locale word-list. Cache time is configurable via config file `cacheTime` property (days)
- **Improvement**: Convert all locales to lowercase w/underscores for easier matching.

## v1.0.1: Use the s***ing config - 2025-11-02

- **Improvement**: Add configurable `locale` option to override the Laravel currentLocale.

## v1.0.0: A New F***ing Hope - 2025-11-02

Initial Release
