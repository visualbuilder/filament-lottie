<?php

declare(strict_types=1);

namespace Visualbuilder\Lottie;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

class LottiePlugin implements Plugin
{
    use EvaluatesClosures;

    protected string|Closure|null $defaultSize = null;

    protected bool|Closure|null $defaultRespectReducedMotion = null;

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        return filament(app(static::class)->getId());
    }

    public function getId(): string
    {
        return 'visualbuilder-lottie';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public function defaultSize(string|Closure|null $size): static
    {
        $this->defaultSize = $size;

        return $this;
    }

    public function getDefaultSize(): ?string
    {
        return $this->evaluate($this->defaultSize)
            ?? config('lottie.default_size');
    }

    public function defaultRespectReducedMotion(bool|Closure|null $respect): static
    {
        $this->defaultRespectReducedMotion = $respect;

        return $this;
    }

    public function getDefaultRespectReducedMotion(): bool
    {
        $value = $this->evaluate($this->defaultRespectReducedMotion);

        return $value ?? (bool) config('lottie.respect_reduced_motion', true);
    }
}
