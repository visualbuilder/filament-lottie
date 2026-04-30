#!/usr/bin/env node
/**
 * Bundles resources/js/index.js into resources/dist/visualbuilder-lottie.js.
 * Pulls @lottiefiles/dotlottie-wc into a single file so the host app does not
 * need npm.
 */
const esbuild = require('esbuild')

const watch = process.argv.includes('--watch')

const config = {
    bundle: true,
    minify: true,
    sourcemap: false,
    target: ['es2020'],
    format: 'esm',
    platform: 'browser',
    entryPoints: ['resources/js/index.js'],
    outfile: 'resources/dist/visualbuilder-lottie.js',
    define: { 'process.env.NODE_ENV': "'production'" },
}

if (watch) {
    esbuild.context(config).then((ctx) => {
        ctx.watch()
        console.log('Watching resources/js/...')
    })
} else {
    esbuild.build(config).catch(() => process.exit(1))
}
