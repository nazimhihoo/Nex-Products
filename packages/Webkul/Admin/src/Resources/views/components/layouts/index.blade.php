<!DOCTYPE html>

<html
    class="{{ request()->cookie('dark_mode') ?? 0 ? 'dark' : '' }}"
    lang="{{ app()->getLocale() }}"
    dir="{{ core()->getCurrentLocale()->direction }}"
>

<head>
    {!! view_render_event('bagisto.admin.layout.head.before') !!}

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
        content="{{ core()->getBaseCurrency()->toJson() }}"
    >
    <meta 
        name="generator" 
        content="{{ config('app.name') }}"
    >

    @stack('meta')

    @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    />

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap"
        rel="stylesheet"
    />

    <link
        rel="preload"
        as="image"
        href="{{ url('cache/logo/bagisto.png') }}"
    >

    @if ($favicon = core()->getConfigData('general.design.admin_logo.favicon'))
        <link
            type="image/x-icon"
            href="{{ Storage::url($favicon) }}"
            rel="shortcut icon"
            sizes="16x16"
        >
    @else
        <link
            type="image/x-icon"
            href="{{ bagisto_asset('images/favicon.ico') }}"
            rel="shortcut icon"
            sizes="16x16"
        />
    @endif

    @stack('styles')

    <style>
        :root {
            --nex-admin-ink: #17211b;
            --nex-admin-green: #12372a;
            --nex-admin-gold: #bd8f31;
            --nex-admin-cream: #fffaf0;
        }

        body {
            background:
                radial-gradient(circle at top left, rgba(189, 143, 49, 0.12), transparent 36rem),
                linear-gradient(180deg, #fffaf0 0%, #f7f8f5 45%, #ffffff 100%) !important;
        }

        body:not(.dark) .dark\:bg-gray-950,
        body:not(.dark) .dark\:bg-gray-900,
        body:not(.dark) .bg-white {
            background-color: rgba(255, 255, 255, 0.92) !important;
        }

        .primary-button,
        button.primary-button,
        a.primary-button {
            background: linear-gradient(135deg, var(--nex-admin-green), #245844) !important;
            border-color: transparent !important;
            box-shadow: 0 14px 28px rgba(18, 55, 42, 0.18);
        }

        .secondary-button,
        button.secondary-button,
        a.secondary-button {
            border-color: rgba(189, 143, 49, 0.38) !important;
            color: var(--nex-admin-green) !important;
        }

        .box-shadow,
        [class*="box-shadow"] {
            border: 1px solid rgba(18, 55, 42, 0.08);
            box-shadow: 0 18px 45px rgba(23, 33, 27, 0.08) !important;
        }

        .fixed.top-14,
        header,
        .journal-scroll {
            backdrop-filter: blur(18px);
        }

        .fixed.top-14 {
            border-right: 1px solid rgba(18, 55, 42, 0.08);
            background:
                linear-gradient(180deg, rgba(255, 250, 240, 0.96), rgba(255, 255, 255, 0.94)) !important;
        }

        .fixed.top-14 a.bg-blue-600,
        .fixed.top-14 .bg-blue-600 {
            background: linear-gradient(135deg, var(--nex-admin-green), #245844) !important;
            box-shadow: 0 12px 24px rgba(18, 55, 42, 0.20);
        }

        .tabs a > div.-mb-px {
            border-color: var(--nex-admin-gold) !important;
            color: var(--nex-admin-green) !important;
        }

        table,
        .datagrid,
        [class*="datagrid"] {
            border-radius: 18px;
        }

        table thead,
        .datagrid thead {
            background: rgba(18, 55, 42, 0.04);
        }

        table th,
        table td {
            padding-top: 14px !important;
            padding-bottom: 14px !important;
        }

        input,
        select,
        textarea {
            border-radius: 12px !important;
        }

        .nex-admin-note {
            border: 1px solid rgba(94, 77, 255, 0.18);
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(94, 77, 255, 0.08), rgba(34, 167, 240, 0.08));
            padding: 14px 16px;
            color: #17211b;
        }
    </style>

    <style>
        {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
    </style>

    {!! view_render_event('bagisto.admin.layout.head.after') !!}
</head>

<body class="h-full dark:bg-gray-950">
    {!! view_render_event('bagisto.admin.layout.body.before') !!}

    <!-- Built With Nex-Products -->
    <div
        id="app"
        class="h-full"
    >
        <!-- Flash Message Blade Component -->
        <x-admin::flash-group />

        <!-- Confirm Modal Blade Component -->
        <x-admin::modal.confirm />

        {!! view_render_event('bagisto.admin.layout.content.before') !!}

        <!-- Page Header Blade Component -->
        <x-admin::layouts.header />

        <div
            class="group/container {{ request()->cookie('sidebar_collapsed') ?? 0 ? 'sidebar-collapsed' : 'sidebar-not-collapsed' }} flex flex-col lg:flex-row gap-0 lg:gap-4"
            ref="appLayout"
        >
            <!-- Page Sidebar Blade Component -->
            <div class="lg:fixed lg:top-[62px] lg:left-0 rtl:lg:right-0 rtl:lg:left-auto lg:z-10 w-full lg:w-auto">
                <x-admin::layouts.sidebar />
            </div>

            <div class="flex min-h-[calc(100vh-62px)] max-w-full flex-1 flex-col bg-white transition-all duration-300 dark:bg-gray-950 pt-3 px-2 sm:px-4 lg:pt-3 lg:px-4 lg:ltr:pl-[286px] lg:group-[.sidebar-collapsed]/container:ltr:pl-[85px] lg:rtl:pr-[286px] lg:group-[.sidebar-collapsed]/container:rtl:pr-[85px]">
                <!-- Added dynamic tabs for third level menus  -->
                <div class="pb-4 lg:pb-6">
                    <!-- Todo @suraj-webkul need to optimize below statement. -->
                    @if (! request()->routeIs('admin.configuration.index'))
                        <div class="overflow-x-auto">
                            <x-admin::layouts.tabs />
                        </div>
                    @endif

                    <!-- Page Content Blade Component -->
                    <div class="w-full overflow-x-hidden">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Powered By -->
                <div class="mt-auto">
                    <div class="border-t bg-white py-2 text-center text-xs sm:text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                        @lang('admin::app.components.layouts.powered-by.description', [
                            'bagisto' => '<span class="text-blue-600 dark:text-darkBlue">Nex-Products</span>',
                            'webkul' => '<a class="text-blue-600 hover:underline dark:text-darkBlue" href="https://webkul.com/">Webkul</a>',
                        ])
                    </div>
                </div>
            </div>
        </div>

        {!! view_render_event('bagisto.admin.layout.content.after') !!}
    </div>

    {!! view_render_event('bagisto.admin.layout.body.after') !!}

    @stack('scripts')

    {!! view_render_event('bagisto.admin.layout.vue-app-mount.before') !!}

    <script>
        /**
         * Load event, the purpose of using the event is to mount the application
         * after all of our `Vue` components which is present in blade file have
         * been registered in the app. No matter what `app.mount()` should be
         * called in the last.
         */
        window.addEventListener("load", function(event) {
            app.mount("#app");
        });
    </script>

    {!! view_render_event('bagisto.admin.layout.vue-app-mount.after') !!}
</body>

</html>
