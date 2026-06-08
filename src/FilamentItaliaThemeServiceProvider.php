<?php

namespace RoBYCoNTe\FilamentItalia;

use RoBYCoNTe\FilamentItalia\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Commands\InstallCommand as PackageInstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentItaliaThemeServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-italia';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasCommand(InstallCommand::class)
            ->hasInstallCommand(function (PackageInstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGithub('robyconte/filament-italia');
            });
    }

    public function packageBooted(): void
    {
        $this->publishes([
            $this->package->basePath('/../resources/stubs/theme.css') => resource_path('css/filament-italia/theme.css'),
        ], 'filament-italia-theme');
    }
}
