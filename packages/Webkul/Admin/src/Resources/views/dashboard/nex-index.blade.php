<x-admin::layouts>
    <x-slot:title>
        Dashboard
    </x-slot>

    @php
        $quickActions = [
            ['label' => 'Products', 'route' => 'admin.catalog.products.index', 'icon' => 'icon-product', 'tone' => 'from-emerald-500 to-teal-600'],
            ['label' => 'View Orders', 'route' => 'admin.sales.orders.index', 'icon' => 'icon-sales', 'tone' => 'from-blue-500 to-indigo-600'],
            ['label' => 'Manage Banners', 'route' => 'admin.banners.index', 'icon' => 'icon-cms', 'tone' => 'from-orange-500 to-amber-600'],
            ['label' => 'Store Settings', 'route' => 'admin.configuration.index', 'icon' => 'icon-configuration', 'tone' => 'from-slate-700 to-slate-950'],
        ];

        $healthItems = [
            ['label' => 'Pending Orders', 'value' => $stats['pending_orders'], 'hint' => 'Need attention'],
            ['label' => 'Low Stock Items', 'value' => $stats['low_stock'], 'hint' => 'Inventory watch'],
            ['label' => 'Active Products', 'value' => $stats['active_products'] ?: $stats['products'], 'hint' => 'Live catalog'],
            ['label' => 'Homepage Banners', 'value' => $stats['banners'], 'hint' => 'Storefront assets'],
        ];

        $totalStatusCount = max(1, $orderStatuses->sum('total'));
    @endphp

    <div class="grid gap-6">
        <section class="relative overflow-hidden rounded-3xl bg-[#101828] p-6 text-white shadow-[0_24px_70px_rgba(16,24,40,0.24)]">
            <div class="absolute -right-20 -top-24 h-72 w-72 rounded-full bg-blue-500/30 blur-3xl"></div>
            <div class="absolute right-32 top-10 h-40 w-40 rounded-full bg-emerald-400/20 blur-2xl"></div>

            <div class="relative flex items-start justify-between gap-6 max-lg:flex-wrap">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.28em] text-blue-200">NexProducts Control Center</p>
                    <h1 class="mt-3 text-3xl font-black tracking-tight md:text-4xl">Dashboard</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-300">
                        Real store pulse, quick actions, recent activity, and inventory signals in one place.
                    </p>
                </div>

                <div class="grid min-w-[260px] grid-cols-2 gap-3 rounded-2xl border border-white/10 bg-white/10 p-3 backdrop-blur">
                    <div>
                        <p class="text-xs text-slate-300">Today</p>
                        <p class="mt-1 text-xl font-black">{{ core()->formatBasePrice($stats['today_revenue']) }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-300">This Month</p>
                        <p class="mt-1 text-xl font-black">{{ core()->formatBasePrice($stats['month_revenue']) }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Total Revenue</p>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">Live</span>
                </div>
                <p class="mt-4 text-3xl font-black text-gray-900 dark:text-white">{{ core()->formatBasePrice($stats['revenue']) }}</p>
                <p class="mt-2 text-xs text-gray-500">Average order: {{ core()->formatBasePrice($stats['average_order']) }}</p>
            </div>

            <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Orders</p>
                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">{{ $stats['today_orders'] }} today</span>
                </div>
                <p class="mt-4 text-3xl font-black text-gray-900 dark:text-white">{{ $stats['orders'] }}</p>
                <p class="mt-2 text-xs text-gray-500">{{ $stats['pending_orders'] }} pending orders</p>
            </div>

            <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Customers / Users</p>
                    <span class="rounded-full bg-purple-50 px-3 py-1 text-xs font-bold text-purple-700">Access</span>
                </div>
                <p class="mt-4 text-3xl font-black text-gray-900 dark:text-white">{{ $stats['customers'] }} / {{ $stats['users'] }}</p>
                <p class="mt-2 text-xs text-gray-500">Customers and admin team accounts</p>
            </div>

            <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Catalog</p>
                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700">{{ (int) $stats['stock_units'] }} stock</span>
                </div>
                <p class="mt-4 text-3xl font-black text-gray-900 dark:text-white">{{ $stats['products'] }} / {{ $stats['categories'] }}</p>
                <p class="mt-2 text-xs text-gray-500">Products and categories</p>
            </div>
        </section>

        <section class="grid gap-4 xl:grid-cols-[1.2fr_0.8fr]">
            <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                    <div>
                        <p class="text-lg font-black text-gray-900 dark:text-white">Quick Access</p>
                        <p class="mt-1 text-sm text-gray-500">Fast paths for daily admin work.</p>
                    </div>
                </div>

                <div class="mt-5 grid gap-3 md:grid-cols-2">
                    @foreach ($quickActions as $action)
                        @if (Route::has($action['route']))
                            <a href="{{ route($action['route']) }}" class="group rounded-2xl border border-gray-100 bg-gray-50 p-4 transition hover:-translate-y-0.5 hover:border-transparent hover:bg-white hover:shadow-xl dark:border-gray-800 dark:bg-gray-950 dark:hover:bg-gray-900">
                                <div class="flex items-center gap-4">
                                    <span class="{{ $action['icon'] }} flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br {{ $action['tone'] }} text-2xl text-white shadow-lg"></span>
                                    <div>
                                        <p class="font-bold text-gray-900 group-hover:text-blue-700 dark:text-white">{{ $action['label'] }}</p>
                                        <p class="mt-1 text-xs text-gray-500">Open now</p>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <p class="text-lg font-black text-gray-900 dark:text-white">Store Health</p>
                <div class="mt-5 grid gap-3">
                    @foreach ($healthItems as $item)
                        <div class="flex items-center justify-between rounded-2xl bg-gray-50 p-3 dark:bg-gray-950">
                            <div>
                                <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $item['label'] }}</p>
                                <p class="text-xs text-gray-500">{{ $item['hint'] }}</p>
                            </div>
                            <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $item['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="grid gap-4 xl:grid-cols-3">
            <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900 xl:col-span-2">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <p class="text-lg font-black text-gray-900 dark:text-white">Recent Orders</p>
                        <p class="mt-1 text-sm text-gray-500">Latest customer purchase activity.</p>
                    </div>
                    @if (Route::has('admin.sales.orders.index'))
                        <a href="{{ route('admin.sales.orders.index') }}" class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-bold text-white transition hover:bg-blue-700">View Orders</a>
                    @endif
                </div>

                <div class="grid gap-3">
                    @forelse ($recentOrders as $order)
                        <div class="flex items-center justify-between gap-4 rounded-2xl border border-gray-100 p-4 transition hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-950">
                            <div>
                                <p class="font-black text-gray-900 dark:text-white">#{{ $order->increment_id ?: $order->id }}</p>
                                <p class="mt-1 text-sm text-gray-500">{{ $order->customer_email ?: 'Guest order' }}</p>
                            </div>

                            <div class="text-right">
                                <p class="font-black text-gray-900 dark:text-white">{{ core()->formatBasePrice($order->base_grand_total) }}</p>
                                <p class="mt-1 text-xs font-bold uppercase tracking-wide text-amber-600">{{ $order->status }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-gray-200 p-6 text-center dark:border-gray-800">
                            <p class="font-bold text-gray-800 dark:text-white">No orders yet</p>
                            <p class="mt-1 text-sm text-gray-500">New sales will appear here as soon as customers place orders.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <p class="text-lg font-black text-gray-900 dark:text-white">Order Status</p>
                <div class="mt-5 grid gap-4">
                    @forelse ($orderStatuses as $status)
                        @php $percent = round(($status->total / $totalStatusCount) * 100); @endphp
                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-bold capitalize text-gray-800 dark:text-white">{{ $status->status }}</span>
                                <span class="text-gray-500">{{ $status->total }}</span>
                            </div>
                            <div class="h-2 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                                <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-emerald-500" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="rounded-2xl border border-dashed border-gray-200 p-5 text-sm text-gray-500 dark:border-gray-800">No order status data yet.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="grid gap-4 xl:grid-cols-2">
            <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <p class="text-lg font-black text-gray-900 dark:text-white">Inventory Attention</p>
                        <p class="mt-1 text-sm text-gray-500">Products at or below 5 units.</p>
                    </div>
                    @if (Route::has('admin.catalog.products.index'))
                        <a href="{{ route('admin.catalog.products.index') }}" class="text-sm font-bold text-blue-700">View Products</a>
                    @endif
                </div>

                <div class="grid gap-3">
                    @forelse ($lowStockProducts as $product)
                        <div class="flex items-center justify-between rounded-2xl bg-red-50 p-4 dark:bg-red-950/20">
                            <div>
                                <p class="font-black text-gray-900 dark:text-white">{{ $product->sku }}</p>
                                <p class="mt-1 text-sm text-gray-500">Product #{{ $product->id }}</p>
                            </div>
                            <p class="rounded-full bg-white px-3 py-1 text-sm font-black text-red-700 shadow-sm dark:bg-gray-900">{{ (int) $product->qty }} left</p>
                        </div>
                    @empty
                        <div class="rounded-2xl bg-emerald-50 p-5 text-sm font-bold text-emerald-800 dark:bg-emerald-950/20 dark:text-emerald-300">
                            Inventory looks healthy. No low-stock products right now.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <p class="text-lg font-black text-gray-900 dark:text-white">Recent Customers</p>
                <div class="mt-5 grid gap-3">
                    @forelse ($recentCustomers as $customer)
                        <div class="flex items-center justify-between rounded-2xl border border-gray-100 p-4 dark:border-gray-800">
                            <div>
                                <p class="font-black text-gray-900 dark:text-white">{{ trim($customer->first_name.' '.$customer->last_name) ?: 'Customer #'.$customer->id }}</p>
                                <p class="mt-1 text-sm text-gray-500">{{ $customer->email }}</p>
                            </div>
                            <p class="text-xs font-semibold text-gray-400">{{ $customer->created_at ? \Illuminate\Support\Carbon::parse($customer->created_at)->diffForHumans() : '' }}</p>
                        </div>
                    @empty
                        <p class="rounded-2xl border border-dashed border-gray-200 p-5 text-sm text-gray-500 dark:border-gray-800">No customers yet.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</x-admin::layouts>
