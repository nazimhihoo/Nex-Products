@php
    $navigation = collect(config('nex_admin_navigation', []));

    $activeSection = $navigation->first(function (array $item) {
        return collect($item['active'] ?? [])->contains(fn (string $pattern) => request()->routeIs($pattern));
    });

    $tabs = collect($activeSection['children'] ?? []);
@endphp

@if (
    $tabs
    && $tabs->isNotEmpty()
)
    <div class="tabs">
        <div class="mb-4 flex gap-4 border-b-2 pt-2 dark:border-gray-800 max-sm:hidden">
            @foreach ($tabs as $tab)
                @php
                    $isActive = collect($tab['active'] ?? [])->contains(fn (string $pattern) => request()->routeIs($pattern));
                @endphp

                <a href="{{ route($tab['route']) }}">
                    <div class="{{ $isActive ? '-mb-px border-blue-600 border-b-2 transition' : '' }} pb-3.5 px-2.5 text-base font-medium text-gray-600 dark:text-gray-300 cursor-pointer">
                        {{ $tab['label'] }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
