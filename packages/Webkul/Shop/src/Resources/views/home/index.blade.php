@php
    $channel = core()->getCurrentChannel();
@endphp

<!-- SEO Meta Content -->
@push ('meta')
    <meta
        name="title"
        content="{{ $channel->home_seo['meta_title'] ?? '' }}"
    />

    <meta
        name="description"
        content="{{ $channel->home_seo['meta_description'] ?? '' }}"
    />

    <meta
        name="keywords"
        content="{{ $channel->home_seo['meta_keywords'] ?? '' }}"
    />
@endPush

@push('scripts')
    @if(! empty($categories))
        <script>
            localStorage.setItem('categories', JSON.stringify(@json($categories)));
        </script>
    @endif
@endpush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{  $channel->home_seo['meta_title'] ?? '' }}
    </x-slot>

    @php
        $heroCustomizations = $customizations->where('type', \Webkul\Theme\Models\ThemeCustomization::IMAGE_CAROUSEL);
        $nonHeroCustomizations = $customizations->reject(fn ($customization) => $customization->type === \Webkul\Theme\Models\ThemeCustomization::IMAGE_CAROUSEL);
        $digitalCollections = [
            ['name' => 'Templates', 'copy' => 'Launch-ready storefront, brand, and workflow systems.', 'accent' => '01'],
            ['name' => 'Ebooks', 'copy' => 'Practical playbooks and premium downloadable guides.', 'accent' => '02'],
            ['name' => 'Courses', 'copy' => 'Focused learning paths for builders and operators.', 'accent' => '03'],
            ['name' => 'AI Products', 'copy' => 'Prompts, automations, and intelligent toolkits.', 'accent' => '04'],
        ];
        $valueProps = [
            ['title' => 'Instant Access', 'copy' => 'Digital purchases are built for fast post-payment delivery.'],
            ['title' => 'Curated Quality', 'copy' => 'Every product area is structured for premium catalog growth.'],
            ['title' => 'Secure Checkout', 'copy' => 'Live Bagisto cart, account, and checkout flows stay intact.'],
        ];
        $brandOptions = \Illuminate\Support\Facades\DB::table('attribute_options')
            ->join('attributes', 'attributes.id', '=', 'attribute_options.attribute_id')
            ->where('attributes.code', 'brand')
            ->orderByRaw('COALESCE(attribute_options.sort_order, 999999)')
            ->orderBy('attribute_options.admin_name')
            ->limit(8)
            ->pluck('attribute_options.admin_name');
    @endphp

    <div class="nex-market-shell">
        <section class="nex-home-block nex-hero-block">
            <section class="nex-vip-hero">
                <div class="nex-hero-content">
                    <span class="nex-vip-eyebrow">Nex Products Digital Storefront</span>

                    <h1 class="nex-vip-title">
                        Premium digital products for builders, creators, and modern teams.
                    </h1>

                    <p class="nex-vip-copy">
                        Discover templates, ebooks, courses, software tools, AI products, and high-value downloadable resources in one polished commerce experience.
                    </p>

                    <form
                        action="{{ route('shop.search.index') }}"
                        class="nex-hero-search"
                        role="search"
                    >
                        <span class="icon-search"></span>

                        <input
                            type="text"
                            name="query"
                            value="{{ request('query') }}"
                            placeholder="Search templates, ebooks, tools, and digital assets"
                            minlength="{{ core()->getConfigData('catalog.products.search.min_query_length') }}"
                            maxlength="{{ core()->getConfigData('catalog.products.search.max_query_length') }}"
                            required
                        >

                        <button type="submit">Search</button>
                    </form>

                    <div class="nex-vip-actions">
                        <a
                            href="{{ route('shop.search.index') }}"
                            class="nex-vip-link"
                        >
                            Explore Catalog
                        </a>

                        <a
                            href="{{ route('shop.search.index', ['type' => 'downloadable']) }}"
                            class="nex-vip-link alt"
                        >
                            Digital Drops
                        </a>
                    </div>

                    <div class="nex-hero-stats">
                        <span><strong>Templates</strong> Launch systems</span>
                        <span><strong>Courses</strong> Skill upgrades</span>
                        <span><strong>AI Tools</strong> Smarter workflows</span>
                    </div>
                </div>

                <div class="nex-hero-visual" aria-hidden="true">
                    <div class="nex-visual-panel is-large">
                        <span>Featured System</span>
                        <strong>Nex Launch Suite</strong>
                        <p>Template + ebook + toolkit bundle</p>
                    </div>

                    <div class="nex-visual-grid">
                        <div><span>AI</span><strong>Prompt Vault</strong></div>
                        <div><span>PDF</span><strong>Growth Guide</strong></div>
                        <div><span>APP</span><strong>Creator OS</strong></div>
                        <div><span>ZIP</span><strong>Asset Pack</strong></div>
                    </div>
                </div>
            </section>
        </section>

        @if ($heroCustomizations->isNotEmpty())
            <section class="nex-home-block nex-editorial-carousel">
                @foreach ($heroCustomizations as $customization)
                    <x-shop::carousel
                        :options="$customization->options"
                        aria-label="{{ trans('shop::app.home.index.image-carousel') }}"
                    />
                @endforeach
            </section>
        @endif

        @if (! empty($categories))
            <section class="nex-home-block">
                <div class="nex-section-heading">
                    <div>
                        <p class="nex-section-kicker">Browse the Library</p>
                        <h2>Shop by collection</h2>
                    </div>

                    <a href="{{ route('shop.search.index') }}">View all</a>
                </div>

                <div class="nex-category-grid">
                    @foreach (collect($categories)->take(8) as $category)
                        <a
                            href="{{ data_get($category, 'url', route('shop.search.index')) }}"
                            class="nex-category-card"
                        >
                            <span>{{ mb_substr(data_get($category, 'name', 'Category'), 0, 1) }}</span>
                            <strong>{{ data_get($category, 'name', 'Category') }}</strong>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="nex-home-block">
            <x-shop::products.carousel
                title="Featured Digital Finds"
                :src="route('shop.api.products.index', ['featured' => 1, 'limit' => 12])"
                :navigation-link="route('shop.search.index', ['featured' => 1])"
                aria-label="Featured Digital Finds"
            />
        </section>

        <section class="nex-home-block nex-collection-showcase">
            @foreach ($digitalCollections as $collection)
                <a
                    href="{{ route('shop.search.index', ['query' => $collection['name']]) }}"
                    class="nex-digital-collection"
                >
                    <span>{{ $collection['accent'] }}</span>
                    <strong>{{ $collection['name'] }}</strong>
                    <p>{{ $collection['copy'] }}</p>
                </a>
            @endforeach
        </section>

        <section class="nex-home-block nex-digital-block">
            <div class="nex-section-heading">
                <div>
                    <p class="nex-section-kicker">Instant Access</p>
                    <h2>Download-ready products</h2>
                </div>

                <a href="{{ route('shop.search.index', ['type' => 'downloadable']) }}">Explore digital</a>
            </div>

            <x-shop::products.carousel
                title=""
                :src="route('shop.api.products.index', ['type' => 'downloadable', 'limit' => 12])"
                :navigation-link="route('shop.search.index', ['type' => 'downloadable'])"
                aria-label="Digital Products"
            />
        </section>

        <section class="nex-home-block nex-promo-band">
            <div>
                <p>Premium commerce system</p>
                <h2>Built for downloadable resources, software, courses, and future high-value digital offers.</h2>
            </div>

            <a href="{{ route('shop.search.index') }}">Start shopping</a>
        </section>

        <section class="nex-home-block">
            <x-shop::products.carousel
                title="New Releases"
                :src="route('shop.api.products.index', ['new' => 1, 'limit' => 12])"
                :navigation-link="route('shop.search.index', ['new' => 1])"
                aria-label="New Releases"
            />
        </section>

        <section class="nex-home-block nex-value-grid">
            @foreach ($valueProps as $valueProp)
                <div>
                    <strong>{{ $valueProp['title'] }}</strong>
                    <p>{{ $valueProp['copy'] }}</p>
                </div>
            @endforeach
        </section>

        <section class="nex-home-block nex-brand-strip">
            <div class="nex-section-heading">
                <div>
                    <p class="nex-section-kicker">Product Families</p>
                    <h2>Curated catalog lines</h2>
                </div>
            </div>

            <div class="nex-brand-grid">
                @forelse ($brandOptions as $brand)
                    <span>{{ $brand }}</span>
                @empty
                    <span>{{ config('app.name') }}</span>
                @endforelse
            </div>
        </section>

        <section class="nex-home-block nex-newsletter">
            <div>
                <p class="nex-section-kicker">Stay Updated</p>
                <h2>Get premium product drops and digital release notes.</h2>
                <p>Join the list for templates, ebooks, tools, AI products, and future downloadable launches.</p>
            </div>
        </section>

        @foreach ($nonHeroCustomizations as $customization)
            @php ($data = $customization->options) @endphp

            @switch ($customization->type)
                @case ($customization::STATIC_CONTENT)
                    @if (! empty($data['css']))
                        @push ('styles')
                            <style>
                                {{ $data['css'] }}
                            </style>
                        @endpush
                    @endif

                    @if (! empty($data['html']))
                        <section class="nex-home-block">
                            {!! $data['html'] !!}
                        </section>
                    @endif

                    @break
                @case ($customization::CATEGORY_CAROUSEL)
                    <section class="nex-home-block">
                        <x-shop::categories.carousel
                            :title="$data['title'] ?? ''"
                            :src="route('shop.api.categories.index', $data['filters'] ?? [])"
                            :navigation-link="route('shop.home.index')"
                            aria-label="{{ trans('shop::app.home.index.categories-carousel') }}"
                        />
                    </section>

                    @break
                @case ($customization::PRODUCT_CAROUSEL)
                    <section class="nex-home-block">
                        <x-shop::products.carousel
                            :title="$data['title'] ?? ''"
                            :src="route('shop.api.products.index', $data['filters'] ?? [])"
                            :navigation-link="route('shop.search.index', $data['filters'] ?? [])"
                            aria-label="{{ trans('shop::app.home.index.product-carousel') }}"
                        />
                    </section>

                    @break
            @endswitch
        @endforeach
    </div>

</x-shop::layouts>
