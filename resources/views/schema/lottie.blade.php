@php
    /** @var \Visualbuilder\Lottie\Components\Lottie $component */
    $component = $getComponent();
@endphp

<dotlottie-wc
    src="{{ $component->getSrc() }}"
    @if ($component->getAutoplay()) autoplay @endif
    @if ($component->getLoop()) loop @endif
    @if ($component->getSpeed() !== null) speed="{{ $component->getSpeed() }}" @endif
    style="width: {{ $component->getWidth() }}; height: {{ $component->getHeight() }};"
    data-vb-lottie-trigger="{{ $component->getTrigger() }}"
    @if ($component->getOnComplete()) data-vb-lottie-on-complete="{{ $component->getOnComplete() }}" @endif
    @if ($component->getRespectReducedMotion()) data-vb-lottie-respect-reduced-motion="true" @endif
></dotlottie-wc>
