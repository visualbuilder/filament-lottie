@php
    $src = $getSrc();
    $autoplay = $getAutoplay();
    $loop = $getLoop();
    $speed = $getSpeed();
    $width = $getWidth();
    $height = $getHeight();
    $trigger = $getTrigger();
    $onComplete = $getOnComplete();
    $respectReducedMotion = $getRespectReducedMotion();
@endphp

<dotlottie-wc
    src="{{ $src }}"
    @if ($autoplay) autoplay @endif
    @if ($loop) loop @endif
    @if ($speed !== null) speed="{{ $speed }}" @endif
    style="width: {{ $width }}; height: {{ $height }};"
    data-vb-lottie-trigger="{{ $trigger }}"
    @if ($onComplete) data-vb-lottie-on-complete="{{ $onComplete }}" @endif
    @if ($respectReducedMotion) data-vb-lottie-respect-reduced-motion="true" @endif
></dotlottie-wc>
