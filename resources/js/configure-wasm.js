/**
 * Repoint the dotlottie renderer WASM before the web component registers.
 *
 * dotlottie-web (inlined inside dotlottie-wc) defaults to fetching
 * dotlottie-player.wasm from a jsdelivr CDN; strict Content-Security-Policies
 * (connect-src) block that, so the animation fails to render. Consumers can
 * self-host the WASM and set `window.vbLottieWasmUrl` to its URL.
 *
 * IMPORTANT: import setWasmUrl from dotlottie-wc (not @lottiefiles/dotlottie-web)
 * — dotlottie-wc bundles its OWN copy of dotlottie-web, so the external package's
 * setWasmUrl targets a different, unused instance.
 */
import { setWasmUrl } from '@lottiefiles/dotlottie-wc'

if (typeof window !== 'undefined' && window.vbLottieWasmUrl) {
    setWasmUrl(window.vbLottieWasmUrl)
}
