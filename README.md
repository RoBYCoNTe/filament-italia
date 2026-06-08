# Filament Italia

A [Filament](https://filamentphp.com) v5 admin panel theme based on the [**.italia Design System**](https://designers.italia.it/design-system/) by [AGID](https://www.agid.gov.it/) (Agenzia per l'Italia Digitale).

Applies the official Italian public administration visual identity — colors, typography, border radii, and component styling — to any Filament panel, with zero npm dependencies and no Blade view overrides.

## Requirements

- PHP 8.2+
- Laravel 11+
- Filament 5.x
- Tailwind CSS 4.x (via Vite)
- Node.js (for `npm run build`)

## Installation

```bash
composer require robyconte/filament-italia
```

Then run the install command:

```bash
php artisan filament-italia:install
```

This publishes the config file and checks your existing setup.

### Manual Setup

If you prefer to configure manually, follow these three steps.

#### 1. Theme CSS

Create or edit your panel's theme CSS file (e.g. `resources/css/filament/company/theme.css`) with this exact import order:

```css
@import '../../../../vendor/robyconte/filament-italia/resources/css/fonts.css';
@import 'tailwindcss';
@import '../../../../vendor/filament/filament/resources/css/theme.css';
@import '../../../../vendor/robyconte/filament-italia/resources/css/theme.css';
@import '../../../../vendor/robyconte/filament-italia/resources/css/overrides.css';
```

Import order matters — the fonts must load before Tailwind processes the CSS.

#### 2. Panel Provider

In your `PanelProvider`, apply the theme configuration:

```php
use Filament\FontProviders\LocalFontProvider;
use RoBYCoNTe\FilamentItalia\FilamentItaliaTheme;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->viteTheme('resources/css/filament/company/theme.css')
        ->colors([
            'primary' => FilamentItaliaTheme::generateColorPalette(
                config('filament-italia.primary_color')
            ),
        ])
        ->darkMode(false)
        ->defaultThemeMode(\Filament\Enums\ThemeMode::Light)
        ->font('Titillium Web', provider: LocalFontProvider::class)
        ->monoFont('Roboto Mono', provider: LocalFontProvider::class)
        ->serifFont('Lora', provider: LocalFontProvider::class);
}
```

> **Important:** This theme is designed for **light mode only**. Always set `->darkMode(false)`.

#### 3. Build Assets

```bash
npm run build
```

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=filament-italia-config
```

### Primary Color

The default primary color is **Blu Italia** (`#0066cc`), the official color for national-level Italian public administration services.

You can customize it in two ways:

**Via `.env` (recommended):**

```env
FILAMENT_ITALIA_PRIMARY_COLOR=#0066cc
```

**Via config file (`config/filament-italia.php`):**

```php
'primary_color' => '#0066cc',
```

The package automatically generates a full 11-shade palette (50–950) from any hex color using HSL interpolation.

> For local or territorial public services, AGID recommends using a dedicated primary color. See the [AGID color guidelines](https://designers.italia.it/design-system/fondamenti/colori/).

## What's Included

### Typography

| Font | Usage | Weights |
|------|-------|---------|
| **Titillium Web** | Body text, UI elements, headings | 200, 300, 400, 600, 700 + italic 400 |
| **Lora** | Serif (long-form reading) | 400, 700 + italic 400 |
| **Roboto Mono** | Monospace (code, data) | 400, 500 |

All fonts are **self-hosted** — no external CDN dependency. Font files are processed by Vite at build time.

### Color Tokens

Full AGID-aligned color scales (11 shades each: 50–950):

| Token | Base Color | Use |
|-------|-----------|-----|
| `primary` | Blu Italia `#0066cc` | Interactive elements, links, active states |
| `danger` | Red `#cc334d` | Errors, destructive actions |
| `success` | Emerald `#008055` | Confirmations, positive states |
| `warning` | Orange `#cc7a00` | Warnings, alerts |
| `info` | Slate `#5c6f82` | Informational messages |
| `gray` | Neutral `#262626` | Text, borders, backgrounds |

### Component Overrides

The theme overrides Filament's default component styling via un-layered CSS rules (which always beat Filament's `@layer components`):

| Component Area | Override Details |
|----------------|-----------------|
| **Topbar** | Primary blue background, white text/icons, ring removal |
| **Sidebar** | Dark blue (`primary-800`) background, white text, custom scrollbar |
| **Buttons** | `font-weight: 600`, `:active` state, no shadow on outlined, 150ms transition |
| **Tabs** | AGID underline style (flat, no card), full-width, left-aligned |
| **Links** | Primary color instead of gray |
| **Inputs** | AGID `border-radius: 4px` |
| **Tables** | Bold headers with 2px bottom border |
| **Modals** | `border-radius: 8px` (from Filament's 12px) |
| **Pagination** | Active page with `bg-primary-50` |
| **Form editors** | Toolbar border-radius matching inputs |
| **Dropdowns** | Tighter `border-radius: 4px` |
| **Notifications** | `border-radius: 8px` |
| **Stats widgets** | `border-radius: 8px` |
| **Empty states** | Primary-tinted icon background |
| **Breadcrumbs** | Primary color on hover |
| **Badges** | Light-on-dark styling in sidebar |
| **Focus indicators** | White outline on dark backgrounds (WCAG 2.4.7) |

## Architecture

```
resources/css/
├── fonts.css       # @font-face declarations (self-hosted woff2)
├── theme.css       # @theme inline block — AGID color/radius/font tokens
└── overrides.css   # Un-layered component overrides

resources/fonts/    # Self-hosted woff2 font files (11 files)
```

### CSS Cascade Strategy

1. `fonts.css` — `@font-face` declarations (no layer)
2. Tailwind CSS base layer
3. Filament theme CSS — all components in `@layer components`
4. `theme.css` — `@theme inline` overrides Tailwind's theme tokens
5. `overrides.css` — **un-layered** rules, always win over `@layer components`

This means overrides never need `!important`. Doubled selectors (e.g. `.fi-topbar.fi-topbar`) provide extra specificity insurance.

## Limitations

- **Light mode only** — the AGID .italia design system does not define a dark mode palette.
- **No npm dependency** — all styling is pure CSS. No JavaScript runtime impact.
- **No Blade overrides** — the theme works entirely through CSS, preserving Filament's component structure for future compatibility.

## Credits

- [AGID — Agenzia per l'Italia Digitale](https://www.agid.gov.it/)
- [.italia Design System](https://designers.italia.it/design-system/)
- [Filament PHP](https://filamentphp.com)

## License

[MIT](LICENSE)
