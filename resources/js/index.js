/**
 * visualbuilder/filament-lottie — entry point bundled by bin/build.js into
 * resources/dist/visualbuilder-lottie.js.
 *
 * Imports the dotlottie web component (registers <dotlottie-wc> as a custom
 * element on import side effect) and adds a tiny trigger orchestrator so
 * authors can declaratively control playback via data-vb-lottie-* attributes.
 */
// Must precede the dotlottie-wc import: repoints the renderer WASM (via
// window.vbLottieWasmUrl, for self-hosting under strict CSP) before the custom
// element registers and fetches it.
import './configure-wasm.js'
import '@lottiefiles/dotlottie-wc'

const TRIGGER_ATTR = 'data-vb-lottie-trigger'
const ON_COMPLETE_ATTR = 'data-vb-lottie-on-complete'
const RESPECT_RM_ATTR = 'data-vb-lottie-respect-reduced-motion'

const prefersReducedMotion = () =>
    window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches === true

/**
 * Replay the animation from frame 0. dotlottie-wc exposes its imperative API
 * on el.dotLottie, populated once the 'load' event fires. Three races to
 * guard:
 *   1. play() called before load — queue via 'load' event
 *   2. load already fired before our click handler ran — poll briefly
 *   3. animation already at its end frame — stop() seeks to 0 first
 */
const invokePlay = (el) => {
    if (!el.dotLottie) return false
    try {
        el.dotLottie.stop()
        el.dotLottie.play()
    } catch { /* element not yet ready */ }
    return true
}

const play = (el) => {
    if (invokePlay(el)) return
    el.addEventListener('load', () => invokePlay(el), { once: true })
    let attempts = 60
    const tick = () => {
        if (--attempts <= 0) return
        if (invokePlay(el)) return
        requestAnimationFrame(tick)
    }
    requestAnimationFrame(tick)
}

const wireOnComplete = (el) => {
    const target = el.getAttribute(ON_COMPLETE_ATTR)
    if (!target) return
    const event = target.startsWith('event:') ? target.slice('event:'.length) : target
    el.addEventListener('complete', () => {
        window.dispatchEvent(new CustomEvent(event, { detail: { source: el } }))
    })
}

const wireTrigger = (el) => {
    const trigger = el.getAttribute(TRIGGER_ATTR) ?? 'mount'

    if (trigger === 'mount') return // autoplay attribute handles it

    el.removeAttribute('autoplay')

    if (trigger === 'click') {
        el.addEventListener('click', () => play(el))
        return
    }

    if (trigger === 'hover') {
        el.addEventListener('pointerenter', () => play(el))
        return
    }

    if (trigger === 'visible') {
        if (!('IntersectionObserver' in window)) {
            play(el)
            return
        }
        const obs = new IntersectionObserver(
            (entries) => {
                for (const entry of entries) {
                    if (entry.isIntersecting) {
                        play(el)
                        obs.disconnect()
                    }
                }
            },
            { threshold: 0.5 },
        )
        obs.observe(el)
        return
    }

    if (trigger.startsWith('event:')) {
        const eventName = trigger.slice('event:'.length)
        const handler = () => play(el)
        window.addEventListener(eventName, handler)
        // Remove the listener if the element is detached.
        if ('MutationObserver' in window) {
            const detach = new MutationObserver(() => {
                if (!el.isConnected) {
                    window.removeEventListener(eventName, handler)
                    detach.disconnect()
                }
            })
            detach.observe(document.body, { childList: true, subtree: true })
        }
    }
}

const honourReducedMotion = (el) => {
    if (el.getAttribute(RESPECT_RM_ATTR) !== 'true') return
    if (!prefersReducedMotion()) return
    el.removeAttribute('autoplay')
    el.setAttribute('data-vb-lottie-paused-rm', 'true')
}

const initialise = (el) => {
    if (el.dataset.vbLottieReady === '1') return
    el.dataset.vbLottieReady = '1'
    honourReducedMotion(el)
    wireTrigger(el)
    wireOnComplete(el)
}

const scan = (root = document) => {
    root.querySelectorAll('dotlottie-wc').forEach(initialise)
}

const observe = () => {
    if (!('MutationObserver' in window)) return
    const observer = new MutationObserver((mutations) => {
        for (const m of mutations) {
            for (const node of m.addedNodes) {
                if (!(node instanceof Element)) continue
                if (node.tagName?.toLowerCase() === 'dotlottie-wc') initialise(node)
                node.querySelectorAll?.('dotlottie-wc').forEach(initialise)
            }
        }
    })
    observer.observe(document.documentElement, { childList: true, subtree: true })
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        scan()
        observe()
    })
} else {
    scan()
    observe()
}
