<?php

declare(strict_types=1);

return [
    /*
    | Default size applied when neither width/height nor size() is set on the
    | component. Accepts any CSS length (px, rem, %, etc.).
    */
    'default_size' => '120px',

    /*
    | Default loop behaviour. `false` plays the animation once — the most
    | common use case for welcome / celebration moments. Override per-instance
    | via ->loop(true).
    */
    'default_loop' => false,

    /*
    | Default autoplay. `true` starts the animation when the component mounts.
    | Set to false to require an explicit trigger (click/hover/event).
    */
    'default_autoplay' => true,

    /*
    | When the user has prefers-reduced-motion set, the dist JS replaces the
    | running animation with a static first frame. Set to false to ignore the
    | OS preference (rare — only when motion is essential to comprehension).
    */
    'respect_reduced_motion' => true,

    /*
    | When true, register the dist JS to load on every Filament page. When
    | false, hosts must register the asset themselves (e.g. in a panel-level
    | hook) to control when it loads.
    */
    'auto_register_assets' => true,
];
