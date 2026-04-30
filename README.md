# visualbuilder/lottie

Lottie animation Schema component and Blade component for Filament 5 panels.

Bundles [`@lottiefiles/dotlottie-wc`](https://www.npmjs.com/package/@lottiefiles/dotlottie-wc) and exposes it as:

- A Schema component (`Visualbuilder\Lottie\Components\Lottie`) usable inside any `->schema([…])`.
- A Blade component (`<x-lottie />`) for views outside the Filament Schema system.

## Install

```bash
composer require visualbuilder/lottie
```

The dist JS and CSS are auto-registered on every Filament page. Disable via `config('lottie.auto_register_assets', false)` and register the assets yourself if you want load-on-request behaviour.

## Configure (optional)

```bash
php artisan vendor:publish --tag=lottie-config
```

`config/lottie.php` exposes `default_size`, `default_loop`, `default_autoplay`, `respect_reduced_motion`, and `auto_register_assets`.

## Panel-level defaults (optional)

```php
use Visualbuilder\Lottie\LottiePlugin;

->plugins([
    LottiePlugin::make()
        ->defaultSize('80px')
        ->defaultRespectReducedMotion(true),
])
```

## API

```php
use Visualbuilder\Lottie\Components\Lottie;

Lottie::make('welcome')
    ->src('lottie/welcome.lottie')
    ->autoplay()                 // default true
    ->loop(false)                // default false (play once)
    ->speed(1.0)
    ->size('120px')              // shorthand → width + height
    ->trigger('mount')           // mount | click | hover | visible | event:NAME
    ->onComplete('event:NAME')   // dispatch a window event when animation finishes
    ->respectReducedMotion();    // default true
```

```blade
<x-lottie src="lottie/welcome.lottie" autoplay :loop="false" size="120px" />
```

## Development

```bash
npm install
npm run build         # bundle resources/js/index.js → resources/dist/
composer test
```

## Branches

- `5.x` — Filament 5 / Livewire 4 (this branch).
- `4.x` — Filament 4 / Livewire 3.

## License

MIT.
