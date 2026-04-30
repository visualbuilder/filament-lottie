<?php

declare(strict_types=1);

namespace Visualbuilder\Lottie\Concerns;

use Closure;

/**
 * Shared fluent setters / getters used by both the Schema component and the
 * Blade component. Keeps the public API identical across both call sites.
 *
 * Hosts using closures: any setter accepting Closure is evaluated at render
 * time via the host's evaluator (Schema components inherit Filament's
 * EvaluatesClosures; Blade components evaluate eagerly).
 */
trait HasLottieAttributes
{
    protected string|Closure|null $src = null;

    protected bool|Closure|null $autoplay = null;

    protected bool|Closure|null $loop = null;

    protected float|Closure|null $speed = null;

    protected string|Closure|null $width = null;

    protected string|Closure|null $height = null;

    protected string|Closure $trigger = 'mount';

    protected string|Closure|null $onComplete = null;

    protected bool|Closure|null $respectReducedMotion = null;

    public function src(string|Closure|null $src): static
    {
        $this->src = $src;

        return $this;
    }

    public function autoplay(bool|Closure $autoplay = true): static
    {
        $this->autoplay = $autoplay;

        return $this;
    }

    public function loop(bool|Closure $loop = true): static
    {
        $this->loop = $loop;

        return $this;
    }

    public function speed(float|Closure $speed): static
    {
        $this->speed = $speed;

        return $this;
    }

    public function size(string|Closure $size): static
    {
        $this->width = $size;
        $this->height = $size;

        return $this;
    }

    public function width(string|Closure $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function height(string|Closure $height): static
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Trigger that starts the animation. Recognised values:
     *   - 'mount'       Plays as soon as the component is in the DOM (default).
     *   - 'click'       Plays when the host element is clicked.
     *   - 'hover'       Plays on pointerenter.
     *   - 'visible'     Plays once when scrolled into view (IntersectionObserver).
     *   - 'event:NAME'  Plays when a window event of NAME fires (e.g. dispatched
     *                   by Livewire `$this->dispatch('NAME')`).
     */
    public function trigger(string|Closure $trigger): static
    {
        $this->trigger = $trigger;

        return $this;
    }

    public function onComplete(string|Closure|null $onComplete): static
    {
        $this->onComplete = $onComplete;

        return $this;
    }

    public function respectReducedMotion(bool|Closure $respect = true): static
    {
        $this->respectReducedMotion = $respect;

        return $this;
    }
}
