<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders the <x-lottie> blade component with mapped attributes', function () {
    $rendered = Blade::render('<x-lottie src="lottie/welcome.lottie" size="80px" :autoplay="true" />');

    expect($rendered)
        ->toContain('<dotlottie-wc')
        ->toContain('lottie/welcome.lottie')
        ->toContain('width: 80px')
        ->toContain('height: 80px')
        ->toContain('autoplay');
});

it('defaults to play-once (no loop attribute) when loop is omitted', function () {
    config(['lottie.default_loop' => false]);

    $rendered = Blade::render('<x-lottie src="https://example.test/w.lottie" />');

    expect($rendered)->not->toContain(' loop ');
});
