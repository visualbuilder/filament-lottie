/**
 * Placeholder dist build for visualbuilder/lottie.
 *
 * The committed bundle is produced by `npm install && npm run build`, which
 * runs bin/build.js (esbuild) over resources/js/index.js. Until that has been
 * run on a clone, this fallback registers <dotlottie-wc> from the unpkg CDN
 * and re-imports the same orchestration logic so the package stays usable in
 * dev environments without a Node toolchain.
 *
 * Replace this file by running `npm install && npm run build` in the package
 * root before tagging a release.
 */
;(async () => {
    if (!customElements.get('dotlottie-wc')) {
        try {
            await import('https://unpkg.com/@lottiefiles/dotlottie-wc?module')
        } catch (e) {
            console.warn('[visualbuilder/lottie] CDN load failed; run `npm run build` to bundle locally.', e)
        }
    }

    const TRIGGER_ATTR = 'data-vb-lottie-trigger'
    const ON_COMPLETE_ATTR = 'data-vb-lottie-on-complete'
    const RESPECT_RM_ATTR = 'data-vb-lottie-respect-reduced-motion'
    const prefersRM = () => window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches === true
    const play = (el) => { try { el.play?.() } catch {} }

    const wireOnComplete = (el) => {
        const target = el.getAttribute(ON_COMPLETE_ATTR)
        if (!target) return
        const event = target.startsWith('event:') ? target.slice(6) : target
        el.addEventListener('complete', () => window.dispatchEvent(new CustomEvent(event, { detail: { source: el } })))
    }

    const wireTrigger = (el) => {
        const t = el.getAttribute(TRIGGER_ATTR) ?? 'mount'
        if (t === 'mount') return
        el.removeAttribute('autoplay')
        if (t === 'click') return el.addEventListener('click', () => play(el))
        if (t === 'hover') return el.addEventListener('pointerenter', () => play(el))
        if (t === 'visible') {
            if (!('IntersectionObserver' in window)) return play(el)
            const obs = new IntersectionObserver((entries) => {
                for (const e of entries) if (e.isIntersecting) { play(el); obs.disconnect() }
            }, { threshold: 0.5 })
            return obs.observe(el)
        }
        if (t.startsWith('event:')) {
            const name = t.slice(6)
            window.addEventListener(name, () => play(el))
        }
    }

    const honourRM = (el) => {
        if (el.getAttribute(RESPECT_RM_ATTR) !== 'true' || !prefersRM()) return
        el.removeAttribute('autoplay')
        el.setAttribute('data-vb-lottie-paused-rm', 'true')
    }

    const init = (el) => {
        if (el.dataset.vbLottieReady === '1') return
        el.dataset.vbLottieReady = '1'
        honourRM(el)
        wireTrigger(el)
        wireOnComplete(el)
    }

    const scan = (root = document) => root.querySelectorAll('dotlottie-wc').forEach(init)
    scan()
    if ('MutationObserver' in window) {
        new MutationObserver((muts) => {
            for (const m of muts) for (const n of m.addedNodes) {
                if (!(n instanceof Element)) continue
                if (n.tagName?.toLowerCase() === 'dotlottie-wc') init(n)
                n.querySelectorAll?.('dotlottie-wc').forEach(init)
            }
        }).observe(document.documentElement, { childList: true, subtree: true })
    }
})()
