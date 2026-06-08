<?php

namespace RoBYCoNTe\FilamentItalia\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'filament-italia:install';

    protected $description = 'Install the Filament Italia (AGID .italia) theme';

    public function handle(): int
    {
        $this->info('Installing Filament Italia theme...');

        $this->publishConfig();
        $this->publishThemeCss();
        $this->updatePanelProvider();

        $this->newLine();
        $this->components->info('Filament Italia theme installed successfully!');
        $this->newLine();
        $this->components->bulletList([
            'Add <fg=yellow>FilamentItaliaTheme::applyTo($panel)</> to your PanelProvider.',
            'Run <fg=yellow>npm run build</> to compile assets.',
            'Adjust the primary color in <fg=yellow>config/filament-italia.php</> if needed.',
        ]);

        return self::SUCCESS;
    }

    private function publishConfig(): void
    {
        $this->components->task('Publishing configuration file', function () {
            $this->callSilent('vendor:publish', [
                '--tag' => 'filament-italia-config',
            ]);
        });
    }

    private function publishThemeCss(): void
    {
        $this->components->task('Publishing theme CSS', function () {
            $this->callSilent('vendor:publish', [
                '--tag' => 'filament-italia-theme',
            ]);
        });
    }

    private function updatePanelProvider(): void
    {
        $this->components->task('Checking panel provider', function () {
            $providerPath = app_path('Providers/AdminPanelProvider.php');

            if (! file_exists($providerPath)) {
                $this->components->twoColumnDetail(
                    'Panel provider',
                    '<fg=yellow>Manual setup required</>'
                );

                return;
            }

            $content = file_get_contents($providerPath);

            if (str_contains($content, 'FilamentItaliaTheme')) {
                $this->components->twoColumnDetail(
                    'Panel provider',
                    '<fg=green>Already configured</>'
                );

                return;
            }

            $this->components->twoColumnDetail(
                'Panel provider',
                '<fg=yellow>Manual setup required</>'
            );

            $this->newLine();
            $this->components->info('Replace your panel configuration with:');
            $this->line('');
            $this->line('  <fg=cyan>use RoBYCoNTe\FilamentItalia\FilamentItaliaTheme;</>');
            $this->line('');
            $this->line('  <fg=green>return FilamentItaliaTheme::applyTo(</>');
            $this->line('      <fg=green>$panel->id(\'admin\')->path(\'admin\')</>');
            $this->line('          ->discoverResources(...)</>');
            $this->line('          ->discoverPages(...)</>');
            $this->line('          ->middleware([...])</>');
            $this->line('  <fg=green>);</>');
        });
    }
}
