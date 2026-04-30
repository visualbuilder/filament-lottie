<?php

declare(strict_types=1);

use Visualbuilder\Lottie\Components\Lottie;
use Visualbuilder\Lottie\LottiePlugin;

it('reads default size from config when no plugin override is registered', function () {
    config(['lottie.default_size' => '48px']);

    $component = Lottie::make('w')->src('w.lottie');

    expect($component->getWidth())->toBe('48px');
});

it('per-instance size overrides every default', function () {
    config(['lottie.default_size' => '48px']);
    LottiePlugin::make()->defaultSize('100px');

    $component = Lottie::make('w')->src('w.lottie')->size('200px');

    expect($component->getWidth())->toBe('200px');
});
