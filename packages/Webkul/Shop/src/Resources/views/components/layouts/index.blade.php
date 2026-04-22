@props([
    'hasHeader'  => true,
    'hasFeature' => true,
    'hasFooter'  => true,
])

<!DOCTYPE html>

<html
    lang="{{ app()->getLocale() }}"
    dir="{{ core()->getCurrentLocale()->direction }}"
>
    <head>

        {!! view_render_event('bagisto.shop.layout.head.before') !!}

        <title>{{ $title ?? '' }}</title>

        <meta charset="UTF-8">

        <meta
            http-equiv="X-UA-Compatible"
            content="IE=edge"
        >
        <meta
            http-equiv="content-language"
            content="{{ app()->getLocale() }}"
        >

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1"
        >
        <meta
            name="base-url"
            content="{{ url()->to('/') }}"
        >
        <meta
            name="currency"
            content="{{ core()->getCurrentCurrency()->toJson() }}"
        >
        <meta 
            name="generator" 
            content="{{ config('app.name') }}"
        >

        @stack('meta')

        <link
            rel="icon"
            sizes="16x16"
            href="{{ core()->getCurrentChannel()->favicon_url ?? bagisto_asset('images/favicon.ico') }}"
        />

        @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

        <link
            rel="preconnect"
            href="https://fonts.googleapis.com"
            crossorigin
        />

        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin
        />

        <link
            rel="preload" as="style"
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=DM+Serif+Display&display=swap"
        />

        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=DM+Serif+Display&display=swap"
        />

        @stack('styles')

        <style>
            :root {
                --nex-ink: #17211b;
                --nex-muted: #66756b;
                --nex-cream: #f7f1e4;
                --nex-sand: #e7d6b0;
                --nex-gold: #bd8f31;
                --nex-green: #12372a;
            }

            body {
                background:
                    radial-gradient(circle at top left, rgba(189, 143, 49, 0.14), transparent 34rem),
                    linear-gradient(180deg, #fffaf0 0%, #ffffff 34%, #f6f8f5 100%);
                color: var(--nex-ink);
            }

            header,
            .sticky.top-0,
            .max-lg\:hidden > .flex,
            .max-lg\:hidden + div {
                backdrop-filter: blur(18px);
            }

            header,
            footer {
                background: rgba(255, 250, 240, 0.92) !important;
                border-color: rgba(18, 55, 42, 0.10) !important;
            }

            .primary-button,
            button.primary-button,
            a.primary-button {
                background: linear-gradient(135deg, var(--nex-green), #245844) !important;
                border-color: transparent !important;
                box-shadow: 0 16px 30px rgba(18, 55, 42, 0.18);
            }

            .secondary-button,
            button.secondary-button,
            a.secondary-button {
                border-color: rgba(189, 143, 49, 0.35) !important;
                color: var(--nex-green) !important;
            }

            [class*="box-shadow"],
            .rounded-xl,
            .rounded-lg {
                box-shadow: 0 18px 45px rgba(23, 33, 27, 0.08);
            }

            .nex-vip-hero {
                position: relative;
                overflow: hidden;
                margin: 24px auto 0;
                max-width: 1320px;
                border-radius: 28px;
                background:
                    radial-gradient(circle at 85% 15%, rgba(255, 255, 255, 0.22), transparent 16rem),
                    linear-gradient(135deg, #102d24 0%, #1f4f3c 48%, #c59537 100%);
                padding: 64px;
                color: #fffaf0;
                box-shadow: 0 26px 80px rgba(18, 55, 42, 0.26);
            }

            .nex-vip-hero:after {
                content: "";
                position: absolute;
                inset: auto -8% -30% 48%;
                height: 320px;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.16);
                transform: rotate(-12deg);
            }

            .nex-vip-eyebrow {
                display: inline-flex;
                border: 1px solid rgba(255, 255, 255, 0.34);
                border-radius: 999px;
                padding: 8px 14px;
                background: rgba(255, 255, 255, 0.12);
                font-size: 13px;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .nex-vip-title {
                position: relative;
                z-index: 1;
                margin-top: 20px;
                max-width: 760px;
                font-family: "DM Serif Display", serif;
                font-size: 64px;
                line-height: 0.95;
            }

            .nex-vip-copy {
                position: relative;
                z-index: 1;
                margin-top: 20px;
                max-width: 620px;
                color: rgba(255, 250, 240, 0.86);
                font-size: 18px;
                line-height: 1.7;
            }

            .nex-vip-actions {
                position: relative;
                z-index: 1;
                display: flex;
                flex-wrap: wrap;
                gap: 14px;
                margin-top: 30px;
            }

            .nex-vip-link {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 999px;
                padding: 13px 22px;
                background: #fffaf0;
                color: var(--nex-green);
                font-weight: 800;
            }

            .nex-vip-link.alt {
                border: 1px solid rgba(255, 255, 255, 0.35);
                background: rgba(255, 255, 255, 0.10);
                color: #fffaf0;
            }

            .nex-vip-strip {
                margin: 0 auto;
                padding: 10px 18px;
                background: linear-gradient(90deg, var(--nex-green), #245844, var(--nex-gold));
                color: #fffaf0;
                text-align: center;
                font-size: 13px;
                font-weight: 800;
                letter-spacing: 0.06em;
                text-transform: uppercase;
            }

            .nex-market-shell {
                display: grid;
                gap: 48px;
                padding-bottom: 56px;
            }

            .nex-home-block {
                width: min(100% - 28px, 1360px);
                margin-inline: auto;
            }

            .nex-hero-block {
                width: min(100% - 16px, 1440px);
            }

            .nex-section-heading {
                display: flex;
                align-items: end;
                justify-content: space-between;
                gap: 18px;
                margin-bottom: 18px;
            }

            .nex-section-heading h2,
            .nex-promo-band h2,
            .nex-newsletter h2 {
                color: var(--nex-ink);
                font-family: "DM Serif Display", serif;
                font-size: 36px;
                line-height: 1;
            }

            .nex-section-heading a,
            .nex-promo-band a {
                color: var(--nex-green);
                font-weight: 800;
            }

            .nex-section-kicker {
                color: var(--nex-gold);
                font-size: 12px;
                font-weight: 900;
                letter-spacing: 0.14em;
                text-transform: uppercase;
            }

            .nex-category-grid {
                display: grid;
                grid-template-columns: repeat(8, minmax(0, 1fr));
                gap: 14px;
            }

            .nex-category-card {
                display: grid;
                place-items: center;
                gap: 10px;
                min-height: 138px;
                border: 1px solid rgba(18, 55, 42, 0.10);
                border-radius: 22px;
                background: rgba(255, 255, 255, 0.86);
                padding: 18px 12px;
                text-align: center;
                transition: transform 180ms ease, box-shadow 180ms ease, border-color 180ms ease;
            }

            .nex-category-card:hover {
                transform: translateY(-4px);
                border-color: rgba(189, 143, 49, 0.42);
                box-shadow: 0 20px 45px rgba(23, 33, 27, 0.10);
            }

            .nex-category-card span {
                display: grid;
                place-items: center;
                width: 54px;
                height: 54px;
                border-radius: 18px;
                background: linear-gradient(135deg, var(--nex-green), #245844);
                color: #fffaf0;
                font-weight: 900;
            }

            .nex-category-card strong {
                color: var(--nex-ink);
                font-size: 14px;
            }

            .nex-digital-block {
                border-radius: 30px;
                background:
                    radial-gradient(circle at top right, rgba(74, 91, 255, 0.16), transparent 22rem),
                    linear-gradient(135deg, rgba(18, 55, 42, 0.06), rgba(189, 143, 49, 0.10));
                padding: 28px;
            }

            .nex-promo-band,
            .nex-newsletter {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 24px;
                border-radius: 30px;
                background:
                    radial-gradient(circle at 88% 20%, rgba(255,255,255,0.20), transparent 18rem),
                    linear-gradient(135deg, #111827, #1e3a8a 56%, #0891b2);
                padding: 42px;
                color: #fffaf0;
                box-shadow: 0 28px 70px rgba(19, 25, 33, 0.20);
            }

            .nex-promo-band p,
            .nex-newsletter p {
                color: rgba(255, 250, 240, 0.82);
                font-weight: 700;
            }

            .nex-promo-band h2,
            .nex-newsletter h2 {
                color: #fffaf0;
                max-width: 780px;
            }

            .nex-promo-band a {
                border-radius: 999px;
                background: #fffaf0;
                padding: 13px 22px;
                white-space: nowrap;
            }

            .nex-brand-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 14px;
            }

            .nex-brand-grid span {
                border: 1px solid rgba(18, 55, 42, 0.10);
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.80);
                padding: 18px;
                color: var(--nex-ink);
                font-weight: 900;
                text-align: center;
            }

            .nex-product-card {
                border: 1px solid rgba(18, 55, 42, 0.09);
                border-radius: 22px !important;
                background: rgba(255, 255, 255, 0.92);
                padding: 10px;
                box-shadow: 0 16px 42px rgba(23, 33, 27, 0.07);
            }

            .nex-product-card:hover {
                border-color: rgba(94, 77, 255, 0.24);
                box-shadow: 0 24px 60px rgba(23, 33, 27, 0.13);
            }

            .nex-digital-badge {
                position: absolute;
                top: 10px;
                right: 10px;
                z-index: 1;
                display: inline-flex;
                border-radius: 999px;
                background: linear-gradient(135deg, #5e4dff, #22a7f0);
                padding: 6px 10px;
                color: white;
                font-size: 11px;
                font-weight: 900;
                letter-spacing: 0.05em;
                text-transform: uppercase;
            }

            .nex-instant-label {
                display: inline-flex;
                width: max-content;
                border-radius: 999px;
                background: rgba(94, 77, 255, 0.08);
                padding: 5px 9px;
                color: #4a3dca;
                font-size: 11px;
                font-weight: 900;
            }

            .nex-download-info {
                margin-top: 22px;
                border: 1px solid rgba(94, 77, 255, 0.20);
                border-radius: 22px;
                background: linear-gradient(135deg, rgba(94, 77, 255, 0.08), rgba(34, 167, 240, 0.08));
                padding: 18px;
            }

            @media (max-width: 1024px) {
                .nex-category-grid,
                .nex-brand-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 640px) {
                .nex-category-grid,
                .nex-brand-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 10px;
                }

                .nex-promo-band,
                .nex-newsletter,
                .nex-section-heading {
                    align-items: start;
                    flex-direction: column;
                }
            }

            /* Ultra polish: typography, conversion clarity, and consistency without layout changes. */
            body {
                text-rendering: optimizeLegibility;
                -webkit-font-smoothing: antialiased;
            }

            h1,
            h2,
            h3,
            h4 {
                letter-spacing: 0;
            }

            p,
            li,
            label,
            input,
            select,
            textarea,
            button,
            a {
                line-height: 1.55;
            }

            a,
            button,
            [role="button"] {
                transition:
                    background-color 160ms ease,
                    border-color 160ms ease,
                    color 160ms ease,
                    opacity 160ms ease,
                    transform 160ms ease,
                    box-shadow 160ms ease;
            }

            button:active,
            [role="button"]:active,
            .primary-button:active,
            .secondary-button:active {
                transform: translateY(1px);
            }

            button:disabled,
            .primary-button:disabled,
            .secondary-button:disabled {
                cursor: not-allowed !important;
                opacity: 0.55 !important;
                box-shadow: none !important;
            }

            input,
            select,
            textarea {
                border-radius: 12px !important;
                line-height: 1.45 !important;
            }

            input:focus,
            select:focus,
            textarea:focus {
                border-color: rgba(94, 77, 255, 0.50) !important;
                box-shadow: 0 0 0 4px rgba(94, 77, 255, 0.10) !important;
                outline: none !important;
            }

            [class*="error"],
            .text-red-500,
            .text-red-600 {
                line-height: 1.45;
            }

            .primary-button,
            .secondary-button {
                min-height: 42px;
                align-items: center;
                justify-content: center;
                font-weight: 800 !important;
                letter-spacing: 0;
            }

            .secondary-button:hover {
                background: rgba(18, 55, 42, 0.045) !important;
                border-color: rgba(18, 55, 42, 0.22) !important;
            }

            .nex-product-card img,
            .nex-product-card picture,
            .nex-product-card [class*="lazy"] {
                object-fit: contain;
            }

            .nex-product-card p {
                overflow-wrap: anywhere;
            }

            .nex-product-title {
                display: -webkit-box;
                min-height: 48px;
                overflow: hidden;
                -webkit-box-orient: vertical;
                -webkit-line-clamp: 2;
                color: var(--nex-ink);
                font-weight: 750;
                line-height: 1.35;
            }

            .nex-product-card [v-html="product.price_html"],
            .nex-product-card .price,
            .nex-product-card [class*="price"] {
                color: var(--nex-green);
                font-weight: 900 !important;
                letter-spacing: 0;
            }

            .nex-product-card .action-items button {
                border-radius: 14px !important;
            }

            .nex-product-card a {
                outline-offset: 4px;
            }

            .nex-product-card a:focus-visible,
            button:focus-visible,
            [role="button"]:focus-visible {
                outline: 3px solid rgba(94, 77, 255, 0.35);
                outline-offset: 3px;
            }

            #main .container {
                scroll-margin-top: 110px;
            }

            #main .container p {
                line-height: 1.7;
            }

            #main [class*="quantity"] button,
            #main [class*="quantity"] input {
                min-width: 42px;
                min-height: 42px;
            }

            #main [class*="summary"],
            #main [class*="cart"] [class*="summary"],
            #main [class*="checkout"] [class*="summary"] {
                border-radius: 22px;
            }

            #main [class*="total"],
            #main [class*="grand"] {
                letter-spacing: 0;
            }

            #main [class*="cart"] .primary-button,
            #main [class*="checkout"] .primary-button,
            #main [class*="onepage"] .primary-button {
                min-height: 48px;
                border-radius: 16px !important;
                box-shadow: 0 18px 34px rgba(18, 55, 42, 0.20) !important;
            }

            #main [class*="checkout"] label,
            #main [class*="onepage"] label {
                margin-bottom: 6px;
                color: var(--nex-ink);
                font-size: 13px;
                font-weight: 800;
            }

            #main [class*="checkout"] input,
            #main [class*="checkout"] select,
            #main [class*="checkout"] textarea,
            #main [class*="onepage"] input,
            #main [class*="onepage"] select,
            #main [class*="onepage"] textarea {
                min-height: 46px;
                background: rgba(255, 255, 255, 0.94);
            }

            #main [class*="checkout"] [class*="error"],
            #main [class*="onepage"] [class*="error"] {
                margin-top: 6px;
                font-size: 12px;
                font-weight: 700;
            }

            #main img {
                height: auto;
            }

            .shimmer {
                border-radius: 14px;
            }

            #main:has(img) {
                min-height: 420px;
            }

            #main [class*="empty"],
            #main [class*="no-result"],
            #main [class*="not-found"] {
                border-radius: 24px;
            }

            #main [class*="empty"] p,
            #main [class*="no-result"] p {
                color: var(--nex-muted);
                font-size: 15px;
                line-height: 1.65;
            }

            @media (max-width: 768px) {
                body {
                    font-size: 15px;
                }

                .primary-button,
                .secondary-button {
                    min-height: 44px;
                }

                #main [class*="checkout"] input,
                #main [class*="checkout"] select,
                #main [class*="checkout"] textarea,
                #main [class*="onepage"] input,
                #main [class*="onepage"] select,
                #main [class*="onepage"] textarea {
                    min-height: 48px;
                }
            }

            /* Nex Products premium digital commerce system */
            :root {
                --nex-ink: #111318;
                --nex-muted: #69717f;
                --nex-line: #e5e9f0;
                --nex-panel: #ffffff;
                --nex-soft: #f6f8fb;
                --nex-night: #111827;
                --nex-blue: #2563eb;
                --nex-cyan: #06b6d4;
                --nex-emerald: #10b981;
                --nex-amber: #f59e0b;
                --nex-coral: #f97362;
            }

            html {
                scroll-behavior: smooth;
            }

            body {
                background:
                    linear-gradient(180deg, #f8fafc 0%, #ffffff 36%, #f4f7fb 100%) !important;
                color: var(--nex-ink);
                font-family: "Poppins", sans-serif;
            }

            h1,
            h2,
            h3,
            h4,
            p,
            a,
            button,
            label {
                letter-spacing: 0 !important;
            }

            .container {
                max-width: 1440px;
            }

            header,
            footer,
            .sticky.top-0,
            .max-lg\:hidden > .flex,
            .max-lg\:hidden + div {
                background: rgba(255, 255, 255, 0.94) !important;
                border-color: rgba(17, 19, 24, 0.08) !important;
                backdrop-filter: blur(18px);
            }

            .nex-vip-strip {
                border-block: 1px solid rgba(37, 99, 235, 0.16);
                background: #eff6ff !important;
                color: #1d4ed8;
                font-size: 12px;
                font-weight: 800;
                letter-spacing: 0 !important;
                text-transform: none;
            }

            .nex-desktop-header,
            .nex-mobile-header {
                border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            }

            .nex-brand-mark span {
                line-height: 1;
            }

            .nex-global-search {
                box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
            }

            .nex-global-search input,
            .nex-global-search select {
                box-shadow: none !important;
            }

            .nex-header-actions a,
            .nex-header-actions [role="button"] {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 40px;
                min-height: 40px;
                border-radius: 999px;
            }

            .primary-button,
            button.primary-button,
            a.primary-button {
                min-height: 46px;
                border: 0 !important;
                border-radius: 999px !important;
                background: var(--nex-night) !important;
                color: #ffffff !important;
                box-shadow: 0 18px 36px rgba(17, 24, 39, 0.18) !important;
            }

            .primary-button:hover,
            button.primary-button:hover,
            a.primary-button:hover {
                background: #2563eb !important;
                transform: translateY(-1px);
            }

            .secondary-button,
            button.secondary-button,
            a.secondary-button {
                min-height: 44px;
                border: 1px solid rgba(37, 99, 235, 0.22) !important;
                border-radius: 999px !important;
                background: #ffffff !important;
                color: #1d4ed8 !important;
                box-shadow: 0 12px 28px rgba(37, 99, 235, 0.08);
            }

            .secondary-button:hover,
            button.secondary-button:hover,
            a.secondary-button:hover {
                border-color: rgba(37, 99, 235, 0.48) !important;
                background: #eff6ff !important;
                transform: translateY(-1px);
            }

            input,
            select,
            textarea {
                border-color: var(--nex-line) !important;
                border-radius: 14px !important;
                background: #ffffff !important;
            }

            input:focus,
            select:focus,
            textarea:focus {
                border-color: rgba(37, 99, 235, 0.58) !important;
                box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.10) !important;
            }

            .nex-market-shell {
                gap: 72px;
                padding-bottom: 72px;
            }

            .nex-home-block {
                width: min(100% - 40px, 1320px);
            }

            .nex-hero-block {
                width: min(100% - 24px, 1420px);
            }

            .nex-vip-hero {
                display: grid;
                grid-template-columns: minmax(0, 1.04fr) minmax(380px, 0.76fr);
                align-items: center;
                gap: 44px;
                min-height: 600px;
                margin-top: 22px;
                border: 1px solid rgba(255, 255, 255, 0.22);
                border-radius: 34px;
                background:
                    radial-gradient(circle at 72% 20%, rgba(6, 182, 212, 0.28), transparent 18rem),
                    radial-gradient(circle at 18% 88%, rgba(16, 185, 129, 0.18), transparent 18rem),
                    linear-gradient(135deg, #0b1020 0%, #111827 52%, #1f2937 100%);
                padding: 62px;
                color: #ffffff;
                box-shadow: 0 32px 80px rgba(15, 23, 42, 0.26);
            }

            .nex-vip-hero:after {
                display: none;
            }

            .nex-hero-content,
            .nex-hero-visual {
                position: relative;
                z-index: 1;
            }

            .nex-vip-eyebrow {
                border: 1px solid rgba(255, 255, 255, 0.20);
                background: rgba(255, 255, 255, 0.08);
                color: #bae6fd;
                font-size: 12px;
                font-weight: 800;
                letter-spacing: 0 !important;
                text-transform: none;
            }

            .nex-vip-title {
                max-width: 850px;
                margin-top: 22px;
                font-family: "Poppins", sans-serif;
                font-size: 64px;
                font-weight: 800;
                line-height: 1.03;
            }

            .nex-vip-copy {
                max-width: 720px;
                margin-top: 22px;
                color: rgba(255, 255, 255, 0.76);
                font-size: 18px;
                line-height: 1.75;
            }

            .nex-hero-search {
                display: grid;
                grid-template-columns: auto 1fr auto;
                align-items: center;
                gap: 12px;
                max-width: 720px;
                margin-top: 30px;
                border: 1px solid rgba(255, 255, 255, 0.18);
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.96);
                padding: 8px;
                box-shadow: 0 24px 60px rgba(0, 0, 0, 0.20);
            }

            .nex-hero-search span {
                margin-inline-start: 14px;
                color: #64748b;
                font-size: 20px;
            }

            .nex-hero-search input {
                min-height: 46px;
                border: 0 !important;
                background: transparent !important;
                color: #111827;
                font-size: 14px;
                font-weight: 600;
                box-shadow: none !important;
            }

            .nex-hero-search button {
                min-height: 46px;
                border-radius: 999px;
                background: #111827;
                padding: 0 24px;
                color: #ffffff;
                font-weight: 800;
            }

            .nex-vip-actions {
                margin-top: 24px;
            }

            .nex-vip-link {
                min-height: 48px;
                border-radius: 999px;
                background: #ffffff;
                color: #111827;
                padding: 0 24px;
                font-weight: 800;
            }

            .nex-vip-link.alt {
                border: 1px solid rgba(255, 255, 255, 0.22);
                background: rgba(255, 255, 255, 0.08);
                color: #ffffff;
            }

            .nex-hero-stats {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 28px;
            }

            .nex-hero-stats span {
                display: grid;
                min-width: 150px;
                border: 1px solid rgba(255, 255, 255, 0.14);
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.07);
                padding: 12px 14px;
                color: rgba(255, 255, 255, 0.68);
                font-size: 12px;
                font-weight: 600;
            }

            .nex-hero-stats strong {
                color: #ffffff;
                font-size: 14px;
            }

            .nex-hero-visual {
                display: grid;
                gap: 16px;
            }

            .nex-visual-panel,
            .nex-visual-grid div {
                border: 1px solid rgba(255, 255, 255, 0.18);
                background: rgba(255, 255, 255, 0.10);
                backdrop-filter: blur(16px);
                box-shadow: 0 28px 70px rgba(0, 0, 0, 0.20);
            }

            .nex-visual-panel {
                min-height: 250px;
                border-radius: 30px;
                padding: 28px;
            }

            .nex-visual-panel span,
            .nex-visual-grid span {
                display: inline-flex;
                width: max-content;
                border-radius: 999px;
                background: rgba(6, 182, 212, 0.16);
                padding: 6px 10px;
                color: #a5f3fc;
                font-size: 11px;
                font-weight: 800;
            }

            .nex-visual-panel strong {
                display: block;
                max-width: 300px;
                margin-top: 56px;
                color: #ffffff;
                font-size: 34px;
                line-height: 1.08;
            }

            .nex-visual-panel p {
                margin-top: 12px;
                color: rgba(255, 255, 255, 0.70);
                font-weight: 600;
            }

            .nex-visual-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 16px;
            }

            .nex-visual-grid div {
                display: grid;
                gap: 24px;
                min-height: 130px;
                border-radius: 24px;
                padding: 20px;
            }

            .nex-visual-grid strong {
                color: #ffffff;
                font-size: 16px;
            }

            .nex-editorial-carousel {
                margin-top: -36px;
            }

            .nex-section-heading {
                margin-bottom: 24px;
            }

            .nex-section-heading h2,
            .nex-promo-band h2,
            .nex-newsletter h2 {
                font-family: "Poppins", sans-serif;
                color: var(--nex-ink);
                font-size: 36px;
                font-weight: 800;
                line-height: 1.12;
            }

            .nex-section-kicker {
                color: #2563eb;
                font-size: 12px;
                font-weight: 800;
                letter-spacing: 0 !important;
                text-transform: none;
            }

            .nex-section-heading a,
            .nex-promo-band a {
                color: #1d4ed8;
                font-weight: 800;
            }

            .nex-category-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 16px;
            }

            .nex-category-card {
                position: relative;
                place-items: start;
                min-height: 154px;
                overflow: hidden;
                border: 1px solid var(--nex-line);
                border-radius: 24px;
                background: #ffffff;
                padding: 22px;
                text-align: start;
                box-shadow: 0 18px 42px rgba(15, 23, 42, 0.06);
            }

            .nex-category-card:after {
                content: "";
                position: absolute;
                inset: auto 18px 18px auto;
                width: 46px;
                height: 46px;
                border-radius: 16px;
                background: linear-gradient(135deg, rgba(37, 99, 235, 0.12), rgba(6, 182, 212, 0.16));
            }

            .nex-category-card:hover {
                border-color: rgba(37, 99, 235, 0.38);
                box-shadow: 0 24px 60px rgba(15, 23, 42, 0.11);
            }

            .nex-category-card span {
                width: 46px;
                height: 46px;
                border-radius: 16px;
                background: #111827;
                color: #ffffff;
            }

            .nex-category-card strong {
                max-width: 220px;
                color: var(--nex-ink);
                font-size: 17px;
                line-height: 1.3;
            }

            .nex-collection-showcase,
            .nex-value-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 16px;
            }

            .nex-digital-collection,
            .nex-value-grid div {
                border: 1px solid var(--nex-line);
                border-radius: 24px;
                background: #ffffff;
                padding: 24px;
                box-shadow: 0 18px 42px rgba(15, 23, 42, 0.06);
            }

            .nex-digital-collection span {
                color: var(--nex-coral);
                font-size: 12px;
                font-weight: 900;
            }

            .nex-digital-collection strong,
            .nex-value-grid strong {
                display: block;
                margin-top: 12px;
                color: var(--nex-ink);
                font-size: 20px;
                font-weight: 800;
            }

            .nex-digital-collection p,
            .nex-value-grid p {
                margin-top: 10px;
                color: var(--nex-muted);
                font-size: 14px;
                line-height: 1.65;
            }

            .nex-digital-block {
                border: 1px solid rgba(37, 99, 235, 0.14);
                border-radius: 30px;
                background:
                    linear-gradient(135deg, rgba(37, 99, 235, 0.06), rgba(6, 182, 212, 0.08));
                padding: 28px;
            }

            .nex-promo-band,
            .nex-newsletter {
                border: 1px solid rgba(255, 255, 255, 0.26);
                border-radius: 30px;
                background:
                    radial-gradient(circle at 90% 12%, rgba(249, 115, 98, 0.28), transparent 18rem),
                    linear-gradient(135deg, #111827, #1e3a8a 58%, #0891b2);
                box-shadow: 0 28px 70px rgba(30, 58, 138, 0.22);
            }

            .nex-promo-band h2,
            .nex-newsletter h2,
            .nex-promo-band p,
            .nex-newsletter p {
                color: #ffffff;
            }

            .nex-promo-band a {
                background: #ffffff;
                color: #111827;
            }

            .nex-brand-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 16px;
            }

            .nex-brand-grid span {
                border: 1px solid var(--nex-line);
                border-radius: 20px;
                background: #ffffff;
                color: var(--nex-ink);
                box-shadow: 0 14px 34px rgba(15, 23, 42, 0.05);
            }

            .nex-product-card {
                border: 1px solid var(--nex-line) !important;
                border-radius: 22px !important;
                background: #ffffff !important;
                padding: 12px !important;
                box-shadow: 0 16px 40px rgba(15, 23, 42, 0.07) !important;
            }

            .nex-product-card:hover {
                border-color: rgba(37, 99, 235, 0.32) !important;
                box-shadow: 0 24px 58px rgba(15, 23, 42, 0.12) !important;
                transform: translateY(-3px);
            }

            .nex-product-media {
                aspect-ratio: 1 / 1;
                width: 100%;
                max-width: none !important;
                max-height: none !important;
                border-radius: 18px;
                background: linear-gradient(135deg, #f1f5f9, #ffffff);
            }

            .nex-product-card img,
            .nex-product-card picture,
            .nex-product-card [class*="lazy"] {
                object-fit: contain;
            }

            .nex-product-info {
                max-width: none !important;
                margin-top: 0 !important;
                transform: none !important;
                background: transparent !important;
                padding: 14px 2px 2px !important;
            }

            .nex-product-title {
                min-height: 44px;
                color: var(--nex-ink);
                font-size: 15px;
                font-weight: 800;
                line-height: 1.45;
            }

            .nex-digital-badge,
            .nex-instant-label {
                background: #eff6ff;
                color: #1d4ed8;
                font-size: 11px;
                font-weight: 900;
            }

            .nex-product-card [v-html="product.price_html"],
            .nex-product-card .price,
            .nex-product-card [class*="price"] {
                color: var(--nex-ink);
                font-weight: 900 !important;
            }

            .nex-product-card .action-items.flex {
                opacity: 1 !important;
                gap: 8px;
            }

            .nex-product-card .action-items.flex .secondary-button {
                width: 100%;
                min-height: 40px;
                border-radius: 14px !important;
                font-size: 13px;
            }

            .nex-product-card .action-items.flex span {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border: 1px solid var(--nex-line);
                border-radius: 14px;
                background: #ffffff;
                color: #475569;
            }

            .nex-page-shell {
                margin-top: 34px;
                border: 1px solid rgba(17, 19, 24, 0.07);
                border-radius: 30px;
                background: rgba(255, 255, 255, 0.78);
                padding-block: 28px 42px;
                box-shadow: 0 22px 60px rgba(15, 23, 42, 0.07);
            }

            .nex-page-title {
                margin-top: 34px;
                color: var(--nex-ink);
                font-size: 34px;
                font-weight: 800;
                line-height: 1.18;
            }

            .nex-product-detail-shell {
                border-radius: 34px;
                background: rgba(255, 255, 255, 0.84);
                padding: 28px;
                box-shadow: 0 24px 70px rgba(15, 23, 42, 0.08);
            }

            .nex-download-info {
                border-color: rgba(37, 99, 235, 0.18);
                background: #eff6ff;
                color: #1e3a8a;
            }

            footer {
                background: #ffffff !important;
            }

            .nex-footer > div:first-child > div:first-child {
                border: 1px solid rgba(255, 255, 255, 0.20);
                background:
                    radial-gradient(circle at 82% 10%, rgba(6, 182, 212, 0.24), transparent 18rem),
                    linear-gradient(135deg, #111827, #1e3a8a) !important;
                box-shadow: 0 26px 70px rgba(30, 58, 138, 0.18);
            }

            .nex-product-gallery img {
                border: 1px solid var(--nex-line);
                background: #ffffff;
            }

            .panel-side {
                border: 1px solid var(--nex-line);
                border-radius: 24px;
                background: #ffffff;
                padding: 18px;
                box-shadow: 0 18px 42px rgba(15, 23, 42, 0.06);
            }

            .nex-auth-shell {
                min-height: 100vh;
            }

            .nex-auth-shell > div:nth-of-type(2) {
                background: #ffffff;
            }

            @media (max-width: 1180px) {
                .nex-vip-hero {
                    grid-template-columns: 1fr;
                    min-height: auto;
                    padding: 44px;
                }

                .nex-vip-title {
                    font-size: 48px;
                }

                .nex-collection-showcase,
                .nex-value-grid,
                .nex-category-grid,
                .nex-brand-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 768px) {
                .nex-vip-strip {
                    padding-inline: 14px;
                    font-size: 11px;
                }

                .nex-market-shell {
                    gap: 42px;
                    padding-bottom: 46px;
                }

                .nex-home-block,
                .nex-hero-block {
                    width: min(100% - 24px, 100%);
                }

                .nex-vip-hero {
                    margin-top: 12px;
                    border-radius: 24px;
                    padding: 28px 18px;
                }

                .nex-vip-title {
                    font-size: 34px;
                }

                .nex-vip-copy {
                    font-size: 15px;
                }

                .nex-hero-search {
                    grid-template-columns: auto 1fr;
                    border-radius: 22px;
                    padding: 8px;
                }

                .nex-hero-search button {
                    grid-column: 1 / -1;
                    width: 100%;
                }

                .nex-hero-stats {
                    display: none;
                }

                .nex-hero-visual {
                    display: none;
                }

                .nex-section-heading {
                    align-items: flex-start;
                    flex-direction: column;
                    gap: 10px;
                }

                .nex-section-heading h2,
                .nex-promo-band h2,
                .nex-newsletter h2 {
                    font-size: 26px;
                }

                .nex-category-grid,
                .nex-collection-showcase,
                .nex-value-grid,
                .nex-brand-grid {
                    grid-template-columns: 1fr;
                }

                .nex-digital-block,
                .nex-promo-band,
                .nex-newsletter {
                    border-radius: 24px;
                    padding: 22px;
                }
            }
        </style>

        <style>
            {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
        </style>

        @if(core()->getConfigData('general.content.speculation_rules.enabled'))
            <script type="speculationrules">
                @json(core()->getSpeculationRules(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            </script>
        @endif

        {!! view_render_event('bagisto.shop.layout.head.after') !!}

    </head>

    <body>
        {!! view_render_event('bagisto.shop.layout.body.before') !!}

        <a
            href="#main"
            class="skip-to-main-content-link"
        >
            Skip to main content
        </a>

        <!-- Built With Nex-Products -->
        <div id="app">
            <!-- Flash Message Blade Component -->
            <x-shop::flash-group />

            <!-- Confirm Modal Blade Component -->
            <x-shop::modal.confirm />

            <!-- Page Header Blade Component -->
            @if ($hasHeader)
                <x-shop::layouts.header />

                <div class="nex-vip-strip">
                    Nex-Products VIP commerce experience: live catalog, cart, checkout, and secure account flow
                </div>
            @endif

            @if(
                core()->getConfigData('general.gdpr.settings.enabled')
                && core()->getConfigData('general.gdpr.cookie.enabled')
            )
                <x-shop::layouts.cookie />
            @endif

            {!! view_render_event('bagisto.shop.layout.content.before') !!}

            <!-- Page Content Blade Component -->
            <main id="main" class="bg-transparent">
                {{ $slot }}
            </main>

            {!! view_render_event('bagisto.shop.layout.content.after') !!}


            <!-- Page Services Blade Component -->
            @if ($hasFeature)
                <x-shop::layouts.services />
            @endif

            <!-- Page Footer Blade Component -->
            @if ($hasFooter)
                <x-shop::layouts.footer />
            @endif
        </div>

        {!! view_render_event('bagisto.shop.layout.body.after') !!}

        @stack('scripts')

        {!! view_render_event('bagisto.shop.layout.vue-app-mount.before') !!}
        <script>
            /**
             * Load event, the purpose of using the event is to mount the application
             * after all of our `Vue` components which is present in blade file have
             * been registered in the app. No matter what `app.mount()` should be
             * called in the last.
             */
            window.addEventListener("load", function (event) {
                app.mount("#app");
            });
        </script>

        {!! view_render_event('bagisto.shop.layout.vue-app-mount.after') !!}

        <script type="text/javascript">
            {!! core()->getConfigData('general.content.custom_scripts.custom_javascript') !!}
        </script>
    </body>
</html>
