<?php

namespace RoBYCoNTe\FilamentItalia;

/**
 * The AGID palettes of the .italia Design System, as PHP arrays for Filament's
 * `->colors()`.
 *
 * Filament keeps its own default Tailwind palette for `danger`, `success`,
 * `warning`, `info` and `gray` unless a panel registers them: without these the
 * panel keeps a blue "info" and a Tailwind green next to an .italia blue, and no
 * amount of component CSS fixes it. The values mirror `resources/css/theme.css`,
 * which holds the same scales as Tailwind tokens.
 *
 * https://designers.italia.it/design-system/fondamenti/colori/
 */
final class ItaliaPalette
{
    /** Blu Italia (#0066cc at shade 600). */
    public const PRIMARY = [
        50 => '#f2f7fc',
        100 => '#bfdfff',
        200 => '#94c4f5',
        300 => '#6aaaeb',
        400 => '#4392e0',
        500 => '#207ad5',
        600 => '#0066cc',
        700 => '#004d99',
        800 => '#004080',
        900 => '#003366',
        950 => '#001a33',
    ];

    /** Rosso AGID (#b32d43 at shade 600). */
    public const DANGER = [
        50 => '#fbeff1',
        100 => '#f5d6db',
        200 => '#ebadb8',
        300 => '#e08593',
        400 => '#d65c70',
        500 => '#cc334d',
        600 => '#b32d43',
        700 => '#992639',
        800 => '#7a1f2e',
        900 => '#661a26',
        950 => '#4d141c',
    ];

    /** Verde AGID (#00b377 at shade 600). */
    public const SUCCESS = [
        50 => '#c8f6e7',
        100 => '#99eed2',
        200 => '#6ee7bf',
        300 => '#43e0ac',
        400 => '#22d499',
        500 => '#00cc88',
        600 => '#00b377',
        700 => '#008055',
        800 => '#006644',
        900 => '#004d33',
        950 => '#003322',
    ];

    /** Arancio AGID (#b36b00 at shade 600). */
    public const WARNING = [
        50 => '#f6e4c8',
        100 => '#eecd9a',
        200 => '#e7b66e',
        300 => '#e0a243',
        400 => '#d48d22',
        500 => '#cc7a00',
        600 => '#b36b00',
        700 => '#995c00',
        800 => '#804d00',
        900 => '#663d00',
        950 => '#4d2e00',
    ];

    /** Grigio-slate AGID (#5c6f82 at shade 600). */
    public const INFO = [
        50 => '#ebeced',
        100 => '#d9dadb',
        200 => '#c5c7c9',
        300 => '#a3adb7',
        400 => '#929da9',
        500 => '#768594',
        600 => '#5c6f82',
        700 => '#455b71',
        800 => '#2f475e',
        900 => '#17324d',
        950 => '#0d1a2e',
    ];

    /** Neutro AGID (#525252 at shade 600). */
    public const GRAY = [
        50 => '#fafafa',
        100 => '#f5f5f5',
        200 => '#e5e5e5',
        300 => '#d4d4d4',
        400 => '#a3a3a3',
        500 => '#737373',
        600 => '#525252',
        700 => '#404040',
        800 => '#262626',
        900 => '#1a1a1a',
        950 => '#0d0d0d',
    ];
}
