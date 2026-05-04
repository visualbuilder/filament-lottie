<?php

declare(strict_types=1);

namespace Visualbuilder\Lottie;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Visualbuilder\Lottie\View\Components\Lottie as LottieBladeComponent;

class LottieServiceProvider extends PackageServiceProvider
{
    public static string $name = 'lottie';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile('lottie')
            ->hasViews('lottie');
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        if (config('lottie.auto_register_assets', true)) {
            FilamentAsset::register([
                Js::make('visualbuilder-lottie', __DIR__.'/../resources/dist/visualbuilder-lottie.js'),
                Css::make('visualbuilder-lottie', __DIR__.'/../resources/css/lottie.css'),
            ], package: $this->getAssetPackageName());
        }

        // Register the Blade component as <x-lottie /> directly (no prefix).
        // Using loadViewComponentsAs would prefix-mangle the tag to <x-lottie-lottie>.
        Blade::component('lottie', LottieBladeComponent::class);
    }

    protected function getAssetPackageName(): string
    {
        return 'visualbuilder/filament-lottie';
    }
}
