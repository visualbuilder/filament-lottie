<?php

declare(strict_types=1);

namespace Visualbuilder\Lottie\Components;

use Filament\Schemas\Components\Component;
use Visualbuilder\Lottie\Concerns\HasLottieAttributes;
use Visualbuilder\Lottie\LottiePlugin;

/**
 * Display-only Schema component that renders a Lottie animation. Use inside
 * any ->schema([...]) — forms, infolists, custom Livewire schemas.
 *
 * Reads panel-level defaults from {@see LottiePlugin} when the host panel
 * registers it; otherwise falls back to config('lottie.*') values.
 */
class Lottie extends Component
{
    use HasLottieAttributes;

    protected string $view = 'lottie::schema.lottie';

    final public function __construct(?string $name = null)
    {
        $this->statePath($name ?? '');
    }

    public static function make(?string $name = null): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();

        return $static;
    }

    public function getSrc(): ?string
    {
        $src = $this->evaluate($this->src);

        if ($src === null) {
            return null;
        }

        if (preg_match('#^(https?:)?//#', $src) || str_starts_with($src, '/')) {
            return $src;
        }

        return asset($src);
    }

    public function getAutoplay(): bool
    {
        return $this->evaluate($this->autoplay)
            ?? (bool) config('lottie.default_autoplay', true);
    }

    public function getLoop(): bool
    {
        return $this->evaluate($this->loop)
            ?? (bool) config('lottie.default_loop', false);
    }

    public function getSpeed(): ?float
    {
        $speed = $this->evaluate($this->speed);

        return $speed === null ? null : (float) $speed;
    }

    public function getWidth(): ?string
    {
        return $this->evaluate($this->width) ?? $this->resolveDefaultSize();
    }

    public function getHeight(): ?string
    {
        return $this->evaluate($this->height) ?? $this->resolveDefaultSize();
    }

    public function getTrigger(): string
    {
        return $this->evaluate($this->trigger);
    }

    public function getOnComplete(): ?string
    {
        return $this->evaluate($this->onComplete);
    }

    public function getRespectReducedMotion(): bool
    {
        $value = $this->evaluate($this->respectReducedMotion);

        if ($value !== null) {
            return $value;
        }

        return $this->resolvePlugin()?->getDefaultRespectReducedMotion()
            ?? (bool) config('lottie.respect_reduced_motion', true);
    }

    protected function resolveDefaultSize(): ?string
    {
        return $this->resolvePlugin()?->getDefaultSize()
            ?? config('lottie.default_size');
    }

    protected function resolvePlugin(): ?LottiePlugin
    {
        try {
            return LottiePlugin::get();
        } catch (\Throwable) {
            return null;
        }
    }
}
