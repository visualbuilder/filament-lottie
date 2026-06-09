/**
 * Repoint the dotlottie renderer WASM before the web component registers.
 *
 * dotlottie-web defaults to fetching dotlottie-player.wasm from a jsdelivr CDN.
 * Strict Content-Security-Policies (connect-src) block that, so the animation
 * fails to render. Consumers can self-host the WASM and set
 * `window.vbLottieWasmUrl` to its URL; otherwise the CDN default is kept
 * (backward compatible). This module is imported before '@lottiefiles/dotlottie-wc'
 * so setWasmUrl() runs before the custom element upgrades and fetches the WASM.
 */
import { DotLottie } from '@lottiefiles/dotlottie-web'

if (typeof window !== 'undefined' && window.vbLottieWasmUrl) {
    DotLottie.setWasmUrl(window.vbLottieWasmUrl)
}
