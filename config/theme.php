<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Theme
    |--------------------------------------------------------------------------
    |
    | This option defines the default theme for the application. The theme
    | can be either 'light' or 'dark'. This will be used as the fallback
    | theme when no user preference is set.
    |
    */

    'default' => env('DEFAULT_THEME', 'light'),

    /*
    |--------------------------------------------------------------------------
    | Available Themes
    |--------------------------------------------------------------------------
    |
    | This array contains all the available themes that can be used in the
    | application. You can add more themes here and implement them in your
    | views and CSS.
    |
    */

    'themes' => [
        'light' => [
            'name' => 'Light',
            'class' => 'light',
        ],
        'dark' => [
            'name' => 'Dark',
            'class' => 'dark',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme Colors
    |--------------------------------------------------------------------------
    |
    | Define the color palette for each theme. These colors can be used
    | throughout the application using CSS custom properties.
    |
    */

    'colors' => [
        'light' => [
            'primary' => '#3b82f6',      // Blue-500
            'secondary' => '#6b7280',    // Gray-500
            'success' => '#22c55e',      // Green-500
            'warning' => '#eab308',      // Yellow-500
            'danger' => '#ef4444',       // Red-500
            'info' => '#06b6d4',         // Cyan-500
            'purple' => '#a855f7',       // Purple-500
            'background' => '#f8fafc',    // Gray-50
            'surface' => '#ffffff',       // White
            'text' => '#1e293b',         // Gray-800
            'text-secondary' => '#64748b', // Gray-500
        ],
        'dark' => [
            'primary' => '#60a5fa',      // Blue-400
            'secondary' => '#9ca3af',    // Gray-400
            'success' => '#4ade80',      // Green-400
            'warning' => '#facc15',      // Yellow-400
            'danger' => '#f87171',       // Red-400
            'info' => '#22d3ee',         // Cyan-400
            'purple' => '#c084fc',       // Purple-400
            'background' => '#0f172a',   // Gray-900
            'surface' => '#1e293b',      // Gray-800
            'text' => '#f8fafc',         // Gray-50
            'text-secondary' => '#cbd5e1', // Gray-300
        ],
    ],
];
