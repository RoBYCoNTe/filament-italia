<?php

namespace RoBYCoNTe\FilamentItalia\Commands;

use Illuminate\Console\Command;
use RoBYCoNTe\FilamentItalia\FilamentItaliaTheme;

class InstallCommand extends Command
{
    protected $signature = 'filament-italia:install';

    protected $description = 'Install the Filament Italia (AGID .italia) theme';

    public function handle(): int
    {
        $this->info('Installing Filament Italia theme...');

        $this->publishConfig();
        $this->updateThemeCss();
        $this->updatePanelProvider();

        $this->newLine();
        $this->components->info('Filament Italia theme installed successfully!');
        $this->newLine();
        $this->components->bulletList([
            'Run <fg=yellow>npm run build</> to compile assets.',
            'Adjust the primary color in <fg=yellow>config/filament-italia.php</> if needed.',
            'Set <fg=yellow>FILAMENT_ITALIA_PRIMARY_COLOR</> in <fg=yellow>.env</> for environment-specific colors.',
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

    private function updateThemeCss(): void
    {
        $this->components->task('Checking theme CSS file', function () {
            $themePath = resource_path('css/filament/company/theme.css');

            if (file_exists($themePath)) {
                $content = file_get_contents($themePath);

                if (str_contains($content, 'filament-italia')) {
                    $this->components->twoColumnDetail(
                        'Theme CSS',
                        '<fg=green>Already configured</>'
                    );

                    return;
                }
            }

            $this->components->twoColumnDetail(
                'Theme CSS',
                '<fg=yellow>Manual setup required</>'
            );

            $this->newLine();
            $this->components->info('Add these imports to your theme CSS file:');
            $this->line('');
            $this->line('  <fg=cyan>// resources/css/filament/company/theme.css</>');
            $this->line('');
            $this->line("  <fg=green>@import '../../../../vendor/robyconte/filament-italia/resources/css/fonts.css';</>");
            $this->line("  <fg=green>@import 'tailwindcss';</>");
            $this->line("  <fg=green>@import '../../../../vendor/filament/filament/resources/css/theme.css';</>");
            $this->line("  <fg=green>@import '../../../../vendor/robyconte/filament-italia/resources/css/theme.css';</>");
            $this->line("  <fg=green>@import '../../../../vendor/robyconte/filament-italia/resources/css/overrides.css';</>");
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
            $this->components->info('Add these configurations to your panel provider:');
            $this->line('');
            $this->line('  <fg=cyan>// In your panel() method:</>');
            $this->line("  <fg=green>->colors(['primary' => \\RoBYCoNTe\\FilamentItalia\\FilamentItaliaTheme::generateColorPalette(config('filament-italia.primary_color'))])</>");
            $this->line("  <fg=green>->darkMode(false)</>");
            $this->line("  <fg=green>->font('Titillium Web', provider: \\Filament\\FontProviders\\LocalFontProvider::class)</>");
            $this->line("  <fg=green>->monoFont('Roboto Mono', provider: \\Filament\\FontProviders\\LocalFontProvider::class)</>");
            $this->line("  <fg=green>->serifFont('Lora', provider: \\Filament\\FontProviders\\LocalFontProvider::class)</>");
        });
    }
}
