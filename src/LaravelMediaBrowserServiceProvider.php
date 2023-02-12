<?php

namespace RPillz\LaravelMediaBrowser;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use RPillz\LaravelMediaBrowser\Commands\LaravelMediaBrowserCommand;

class LaravelMediaBrowserServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-media-browser')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations(['create_media_libraries_table', 'create_media_attachments_table'])
            ->hasCommand(LaravelMediaBrowserCommand::class);
    }

}
