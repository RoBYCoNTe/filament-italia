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
            ->hasCommand(Commands\InstallCommand::class)
            ->hasInstallCommand(function (PackageInstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGithub('robyconte/filament-italia');
            });
    }

    public function packageBooted(): void
    {
        //
    }
}
