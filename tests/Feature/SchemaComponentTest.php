<?php

declare(strict_types=1);

use Visualbuilder\Lottie\Components\Lottie;

it('renders a dotlottie-wc tag with the resolved src', function () {
    $component = Lottie::make('welcome')->src('https://example.test/welcome.lottie');

    expect($component->getSrc())->toBe('https://example.test/welcome.lottie');
});

it('resolves relative src paths via asset()', function () {
    config(['app.url' => 'https://example.test']);

    $component = Lottie::make('welcome')->src('lottie/welcome.lottie');

    expect($component->getSrc())->toBe('https://example.test/lottie/welcome.lottie');
});

it('defaults to play-once (loop false) and autoplay true', function () {
    $component = Lottie::make('welcome')->src('w.lottie');

    expect($component->getLoop())->toBeFalse();
    expect($component->getAutoplay())->toBeTrue();
});

it('size() sets both width and height', function () {
    $component = Lottie::make('w')->src('w.lottie')->size('80px');

    expect($component->getWidth())->toBe('80px');
    expect($component->getHeight())->toBe('80px');
});

it('falls back to config default size when none is set', function () {
    config(['lottie.default_size' => '64px']);

    $component = Lottie::make('w')->src('w.lottie');

    expect($component->getWidth())->toBe('64px');
    expect($component->getHeight())->toBe('64px');
});

it('exposes the configured trigger string', function () {
    $component = Lottie::make('w')->src('w.lottie')->trigger('event:celebrate');

    expect($component->getTrigger())->toBe('event:celebrate');
});
