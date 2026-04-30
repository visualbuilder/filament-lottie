<dotlottie-wc
    {{ $attributes->merge([
        'style' => "width: {$resolvedWidth}; height: {$resolvedHeight};",
    ]) }}
    src="{{ $resolvedSrc }}"
    @if ($resolvedAutoplay) autoplay @endif
    @if ($resolvedLoop) loop @endif
    @if ($speed !== null) speed="{{ $speed }}" @endif
    data-vb-lottie-trigger="{{ $trigger }}"
    @if ($onComplete) data-vb-lottie-on-complete="{{ $onComplete }}" @endif
    @if ($resolvedRespectReducedMotion) data-vb-lottie-respect-reduced-motion="true" @endif
></dotlottie-wc>
