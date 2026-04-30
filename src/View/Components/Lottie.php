<?php

declare(strict_types=1);

namespace Visualbuilder\Lottie\View\Components;

use Illuminate\View\Component;

/**
 * Blade component for non-Filament views: <x-lottie src="..." />.
 *
 * Mirrors the public surface of the Schema component so the same animation
 * config can be expressed declaratively in Blade.
 */
class Lottie extends Component
{
    public string $resolvedSrc;

    public string $resolvedWidth;

    public string $resolvedHeight;

    public bool $resolvedAutoplay;

    public bool $resolvedLoop;

    public bool $resolvedRespectReducedMotion;

    public function __construct(
        public string $src,
        public ?string $size = null,
        public ?string $width = null,
        public ?string $height = null,
        public ?bool $autoplay = null,
        public ?bool $loop = null,
        public ?float $speed = null,
        public string $trigger = 'mount',
        public ?string $onComplete = null,
        public ?bool $respectReducedMotion = null,
    ) {
        $this->resolvedSrc = $this->resolveSrc($src);
        $this->resolvedWidth = $width ?? $size ?? (string) config('lottie.default_size', '120px');
        $this->resolvedHeight = $height ?? $size ?? (string) config('lottie.default_size', '120px');
        $this->resolvedAutoplay = $autoplay ?? (bool) config('lottie.default_autoplay', true);
        $this->resolvedLoop = $loop ?? (bool) config('lottie.default_loop', false);
        $this->resolvedRespectReducedMotion = $respectReducedMotion
            ?? (bool) config('lottie.respect_reduced_motion', true);
    }

    public function render()
    {
        return view('lottie::components.lottie');
    }

    protected function resolveSrc(string $src): string
    {
        if (preg_match('#^(https?:)?//#', $src) || str_starts_with($src, '/')) {
            return $src;
        }

        return asset($src);
    }
}
