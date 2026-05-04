# Changelog

All notable changes to `visualbuilder/filament-lottie` are documented in this file.

## Unreleased — 5.x

- Initial Filament 5 / Livewire 4 release.
- Schema component `Visualbuilder\Lottie\Components\Lottie`.
- Blade component `<x-lottie />`.
- Panel plugin `Visualbuilder\Lottie\LottiePlugin` for panel-level defaults.
- `prefers-reduced-motion` honoured by default.
- Triggers: `mount`, `click`, `hover`, `visible`, `event:NAME`.
- Schema view auto-binds component getters as `$get*()` closures (Filament 5 convention), not `$getComponent()`.
- `play()` calls `dotLottie.stop()` first to seek to frame 0 — replay-from-click works after first playback.
- Polls for `el.dotLottie` for up to 60 frames after a trigger fires, covering the case where the `load` event fired before our handler attached.
- Production esbuild bundle (`resources/dist/visualbuilder-lottie.js`) committed at ~57 KB gzipped; CDN-fallback path remains for development clones without Node.
