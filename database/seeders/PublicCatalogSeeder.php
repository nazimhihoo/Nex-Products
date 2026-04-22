<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Webkul\Attribute\Repositories\AttributeOptionRepository;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Product\Models\Product;

class PublicCatalogSeeder extends Seeder
{
    /**
     * Seed a compact, realistic storefront catalog for public-flow verification.
     */
    public function run(): void
    {
        $channel = DB::table('channels')->where('code', 'default')->first();

        if (! $channel) {
            throw new \RuntimeException('Default sales channel was not found.');
        }

        $inventorySource = DB::table('inventory_sources')->where('code', 'default')->first();

        if (! $inventorySource) {
            throw new \RuntimeException('Default inventory source was not found.');
        }

        $taxCategoryId = $this->ensureTaxCategory();
        $brandOptions = $this->ensureBrandOptions();
        $categories = $this->ensureCategories((int) $channel->root_category_id);

        $products = [
            [
                'sku' => 'NEX-KEY-001',
                'name' => 'Axiom Mechanical Keyboard',
                'slug' => 'axiom-mechanical-keyboard',
                'short_description' => 'A compact mechanical keyboard tuned for long writing sessions and clean desk setups.',
                'description' => 'The Axiom Mechanical Keyboard pairs tactile switches with a compact layout, hotkey shortcuts, and a stable aluminum top plate. It is built for everyday office work, focused writing, and comfortable late-night sessions.',
                'price' => 129.00,
                'weight' => 0.90,
                'brand' => 'Apex Gear',
                'category' => 'desk-accessories',
                'inventory' => 18,
                'featured' => true,
                'new' => true,
                'status' => 1,
                'images' => [
                    'packages/Webkul/Installer/src/Resources/assets/images/seeders/products/1/1.webp',
                    'packages/Webkul/Installer/src/Resources/assets/images/seeders/products/1/2.webp',
                ],
            ],
            [
                'sku' => 'NEX-MSE-001',
                'name' => 'Contour Wireless Mouse',
                'slug' => 'contour-wireless-mouse',
                'short_description' => 'A quiet wireless mouse with precise tracking and all-day battery life.',
                'description' => 'The Contour Wireless Mouse is designed for calm, focused work. It offers reliable wireless performance, accurate tracking across common desk surfaces, and an ergonomic shape that stays comfortable through long sessions.',
                'price' => 59.00,
                'weight' => 0.22,
                'brand' => 'Apex Gear',
                'category' => 'desk-accessories',
                'inventory' => 32,
                'featured' => false,
                'new' => true,
                'status' => 1,
                'images' => [
                    'packages/Webkul/Installer/src/Resources/assets/images/seeders/products/2/1.webp',
                    'packages/Webkul/Installer/src/Resources/assets/images/seeders/products/2/2.webp',
                ],
            ],
            [
                'sku' => 'NEX-DCK-001',
                'name' => 'Focus USB-C Dock',
                'slug' => 'focus-usb-c-dock',
                'short_description' => 'A streamlined USB-C dock for charging, display output, and desk-side connectivity.',
                'description' => 'The Focus USB-C Dock adds the ports most workstations need without clutter. It supports charging passthrough, fast data transfer, and an external display connection for laptops used in hybrid work setups.',
                'price' => 149.00,
                'weight' => 0.38,
                'brand' => 'Lumio Tech',
                'category' => 'desk-accessories',
                'inventory' => 11,
                'featured' => true,
                'new' => false,
                'status' => 1,
                'images' => [
                    'packages/Webkul/Installer/src/Resources/assets/images/seeders/products/8/1.webp',
                    'packages/Webkul/Installer/src/Resources/assets/images/seeders/products/8/2.webp',
                ],
            ],
            [
                'sku' => 'NEX-HDP-001',
                'name' => 'Pulse ANC Headphones',
                'slug' => 'pulse-anc-headphones',
                'short_description' => 'Over-ear wireless headphones with active noise cancellation for focused listening.',
                'description' => 'Pulse ANC Headphones reduce day-to-day office noise and keep calls clear. The balanced sound profile works well for music, meetings, and concentrated work, with comfortable ear cups for longer sessions.',
                'price' => 199.00,
                'weight' => 0.48,
                'brand' => 'Nex Audio',
                'category' => 'headphones',
                'inventory' => 0,
                'featured' => true,
                'new' => false,
                'status' => 1,
                'images' => [
                    'packages/Webkul/Installer/src/Resources/assets/images/seeders/products/9/1.webp',
                    'packages/Webkul/Installer/src/Resources/assets/images/seeders/products/9/2.webp',
                ],
            ],
            [
                'sku' => 'NEX-EAR-001',
                'name' => 'Echo Studio Earbuds',
                'slug' => 'echo-studio-earbuds',
                'short_description' => 'Lightweight wireless earbuds with a secure fit for commute and office use.',
                'description' => 'Echo Studio Earbuds are made for quick calls, focused playlists, and lightweight everyday carry. They offer stable Bluetooth performance and a clean profile that works well for travel and desk use alike.',
                'price' => 89.00,
                'weight' => 0.06,
                'brand' => 'Nex Audio',
                'category' => 'headphones',
                'inventory' => 21,
                'featured' => false,
                'new' => true,
                'status' => 1,
                'images' => [
                    'packages/Webkul/Installer/src/Resources/assets/images/seeders/products/10/1.webp',
                    'packages/Webkul/Installer/src/Resources/assets/images/seeders/products/10/2.webp',
                ],
            ],
            [
                'sku' => 'NEX-EAR-002',
                'name' => 'Echo Studio Earbuds Pro',
                'slug' => 'echo-studio-earbuds-pro',
                'short_description' => 'A hidden draft product kept inactive for backend visibility checks.',
                'description' => 'This inactive catalog item exists so public category and search checks can confirm unpublished products do not leak into live browsing flows.',
                'price' => 119.00,
                'weight' => 0.07,
                'brand' => 'Nex Audio',
                'category' => 'headphones',
                'inventory' => 14,
                'featured' => false,
                'new' => false,
                'status' => 0,
                'images' => [
                    'packages/Webkul/Installer/src/Resources/assets/images/seeders/products/11/1.webp',
                    'packages/Webkul/Installer/src/Resources/assets/images/seeders/products/11/2.webp',
                ],
            ],
        ];

        $seededProducts = [];

        foreach ($products as $definition) {
            $product = $this->seedProduct(
                $definition,
                (int) $channel->id,
                (int) $inventorySource->id,
                (int) $taxCategoryId,
                (int) $brandOptions[$definition['brand']],
                (int) $categories[$definition['category']]
            );

            $seededProducts[$definition['sku']] = $product;
        }

        $seededProducts['NEX-HDP-001']->related_products()->sync([
            $seededProducts['NEX-EAR-001']->id,
        ]);

        $seededProducts['NEX-EAR-001']->related_products()->sync([
            $seededProducts['NEX-HDP-001']->id,
        ]);

        $this->seedReviews($seededProducts);
    }

    /**
     * Ensure a usable tax category exists for checkout and indexing.
     */
    protected function ensureTaxCategory(): int
    {
        $existingId = DB::table('tax_categories')
            ->where('code', 'default-tax')
            ->value('id');

        if ($existingId) {
            return (int) $existingId;
        }

        return (int) DB::table('tax_categories')->insertGetId([
            'code'        => 'default-tax',
            'name'        => 'Default Tax',
            'description' => 'Default tax category for the Nex-Products public catalog.',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    /**
     * Ensure the storefront brand options exist on the Bagisto brand attribute.
     *
     * @return array<string, int>
     */
    protected function ensureBrandOptions(): array
    {
        $brandAttributeId = (int) DB::table('attributes')
            ->where('code', 'brand')
            ->value('id');

        if (! $brandAttributeId) {
            throw new \RuntimeException('The brand attribute was not found.');
        }

        $attributeOptionRepository = app(AttributeOptionRepository::class);
        $brands = ['Nex Audio', 'Apex Gear', 'Lumio Tech'];
        $optionIds = [];

        foreach ($brands as $index => $brandName) {
            $optionId = DB::table('attribute_options')
                ->where('attribute_id', $brandAttributeId)
                ->where('admin_name', $brandName)
                ->value('id');

            if (! $optionId) {
                $option = $attributeOptionRepository->create([
                    'admin_name'   => $brandName,
                    'sort_order'   => $index + 1,
                    'attribute_id' => $brandAttributeId,
                    'en'           => [
                        'label' => $brandName,
                    ],
                ]);

                $optionId = $option->id;
            }

            $optionIds[$brandName] = (int) $optionId;
        }

        return $optionIds;
    }

    /**
     * Ensure a compact category tree exists for public storefront testing.
     *
     * @return array<string, int>
     */
    protected function ensureCategories(int $rootCategoryId): array
    {
        $categoryRepository = app(CategoryRepository::class);

        $definitions = [
            'office-setup' => [
                'name'        => 'Office Setup',
                'description' => 'Essential equipment for practical desk and workstation builds.',
                'parent_id'   => $rootCategoryId,
                'position'    => 1,
            ],
            'desk-accessories' => [
                'name'        => 'Desk Accessories',
                'description' => 'Focused accessories for keyboards, mice, docks, and compact workstation gear.',
                'parent_id'   => null,
                'position'    => 1,
            ],
            'audio' => [
                'name'        => 'Audio',
                'description' => 'Listening gear for focused work, calls, and everyday office use.',
                'parent_id'   => $rootCategoryId,
                'position'    => 2,
            ],
            'headphones' => [
                'name'        => 'Headphones',
                'description' => 'Wireless headphones and earbuds for calls, travel, and focused listening.',
                'parent_id'   => null,
                'position'    => 1,
            ],
        ];

        $ids = [];

        foreach (['office-setup', 'audio'] as $slug) {
            $ids[$slug] = $this->ensureCategory($categoryRepository, $definitions[$slug]);
        }

        $definitions['desk-accessories']['parent_id'] = $ids['office-setup'];
        $definitions['headphones']['parent_id'] = $ids['audio'];

        foreach (['desk-accessories', 'headphones'] as $slug) {
            $ids[$slug] = $this->ensureCategory($categoryRepository, $definitions[$slug], $slug);
        }

        $filterableAttributeIds = DB::table('attributes')
            ->whereIn('code', ['brand', 'color', 'size'])
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();

        foreach (['office-setup', 'desk-accessories', 'audio', 'headphones'] as $slug) {
            DB::table('category_filterable_attributes')
                ->where('category_id', $ids[$slug])
                ->delete();

            foreach ($filterableAttributeIds as $attributeId) {
                DB::table('category_filterable_attributes')->insert([
                    'category_id'  => $ids[$slug],
                    'attribute_id' => $attributeId,
                ]);
            }
        }

        return $ids;
    }

    /**
     * Create a category if it does not already exist.
     */
    protected function ensureCategory(
        CategoryRepository $categoryRepository,
        array $definition,
        ?string $slug = null
    ): int {
        $slug ??= str($definition['name'])->slug()->value();
        $localeId = (int) DB::table('locales')->where('code', 'en')->value('id');

        $existingId = DB::table('category_translations')
            ->where('locale', 'en')
            ->where('slug', $slug)
            ->value('category_id');

        if ($existingId) {
            return (int) $existingId;
        }

        $category = $categoryRepository->create([
            'position'     => $definition['position'],
            'status'       => 1,
            'display_mode' => 'products_and_description',
            'parent_id'    => $definition['parent_id'],
            'en'           => [
                'name'        => $definition['name'],
                'slug'        => $slug,
                'description' => $definition['description'],
                'url_path'    => $slug,
                'locale_id'   => $localeId,
            ],
        ]);

        return (int) $category->id;
    }

    /**
     * Create or refresh a simple Bagisto product.
     */
    protected function seedProduct(
        array $definition,
        int $channelId,
        int $inventorySourceId,
        int $taxCategoryId,
        int $brandOptionId,
        int $categoryId
    ): Product {
        $product = Product::query()->where('sku', $definition['sku'])->first();

        if (! $product) {
            $product = Product::query()->create([
                'type'                => 'simple',
                'attribute_family_id' => 1,
                'sku'                 => $definition['sku'],
            ]);
        }

        $product->forceFill([
            'type'                => 'simple',
            'attribute_family_id' => 1,
            'parent_id'           => null,
        ])->save();

        DB::table('product_channels')->updateOrInsert([
            'product_id' => $product->id,
            'channel_id' => $channelId,
        ], []);

        DB::table('product_categories')->where('product_id', $product->id)->delete();
        DB::table('product_categories')->insert([
            'product_id'  => $product->id,
            'category_id' => $categoryId,
        ]);

        DB::table('product_inventories')->updateOrInsert([
            'product_id'          => $product->id,
            'inventory_source_id' => $inventorySourceId,
            'vendor_id'           => 0,
        ], [
            'qty' => $definition['inventory'],
        ]);

        $attributes = DB::table('attributes')
            ->whereIn('code', [
                'name',
                'url_key',
                'short_description',
                'description',
                'price',
                'weight',
                'status',
                'visible_individually',
                'guest_checkout',
                'new',
                'featured',
                'tax_category_id',
                'brand',
                'meta_title',
                'meta_description',
                'meta_keywords',
            ])
            ->get()
            ->keyBy('code');

        $attributeValues = [
            'name'                 => $definition['name'],
            'url_key'              => $definition['slug'],
            'short_description'    => $definition['short_description'],
            'description'          => $definition['description'],
            'price'                => $definition['price'],
            'weight'               => $definition['weight'],
            'status'               => (int) $definition['status'],
            'visible_individually' => 1,
            'guest_checkout'       => 1,
            'new'                  => $definition['new'] ? 1 : 0,
            'featured'             => $definition['featured'] ? 1 : 0,
            'tax_category_id'      => $taxCategoryId,
            'brand'                => $brandOptionId,
            'meta_title'           => $definition['name'].' | Nex-Products',
            'meta_description'     => $definition['short_description'],
            'meta_keywords'        => implode(', ', [
                $definition['name'],
                $definition['brand'],
                'Nex-Products',
            ]),
        ];

        DB::table('product_attribute_values')
            ->where('product_id', $product->id)
            ->whereIn('attribute_id', $attributes->pluck('id')->all())
            ->delete();

        foreach ($attributeValues as $code => $value) {
            $attribute = $attributes->get($code);

            if (! $attribute) {
                continue;
            }

            $locale = $attribute->value_per_locale ? 'en' : null;
            $channel = $attribute->value_per_channel ? 'default' : null;
            $uniqueId = implode('|', array_filter([
                $channel,
                $locale,
                $product->id,
                $attribute->id,
            ], fn ($segment) => $segment !== null && $segment !== ''));

            $row = [
                'locale'         => $locale,
                'channel'        => $channel,
                'text_value'     => null,
                'boolean_value'  => null,
                'integer_value'  => null,
                'float_value'    => null,
                'datetime_value' => null,
                'date_value'     => null,
                'json_value'     => null,
                'product_id'     => $product->id,
                'attribute_id'   => $attribute->id,
                'unique_id'      => $uniqueId,
            ];

            match ($attribute->type) {
                'text', 'textarea' => $row['text_value'] = (string) $value,
                'price'            => $row['float_value'] = $value,
                'boolean'          => $row['boolean_value'] = (int) $value,
                'select'           => $row['integer_value'] = (int) $value,
                default            => $row['text_value'] = (string) $value,
            };

            DB::table('product_attribute_values')->updateOrInsert([
                'unique_id' => $uniqueId,
            ], $row);
        }

        $this->syncProductImages($product->id, $definition['images']);

        return $product->refresh();
    }

    /**
     * Replace a product's gallery with a deterministic local image set.
     *
     * @param  string[]  $imageSources
     */
    protected function syncProductImages(int $productId, array $imageSources): void
    {
        Storage::deleteDirectory('product/'.$productId);

        DB::table('product_images')->where('product_id', $productId)->delete();

        foreach (array_values($imageSources) as $index => $sourcePath) {
            $absolutePath = base_path($sourcePath);

            if (! is_file($absolutePath)) {
                throw new \RuntimeException("Product image not found: {$absolutePath}");
            }

            $storedPath = 'product/'.$productId.'/'.str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT).'.webp';

            Storage::put($storedPath, file_get_contents($absolutePath));

            DB::table('product_images')->insert([
                'type'       => 'images',
                'path'       => $storedPath,
                'product_id' => $productId,
                'position'   => $index + 1,
            ]);
        }
    }

    /**
     * Seed approved and pending reviews so review filtering can be verified.
     *
     * @param  array<string, Product>  $seededProducts
     */
    protected function seedReviews(array $seededProducts): void
    {
        $approvedProductId = $seededProducts['NEX-HDP-001']->id;

        DB::table('product_reviews')
            ->whereIn('product_id', [
                $approvedProductId,
                $seededProducts['NEX-EAR-001']->id,
            ])
            ->delete();

        DB::table('product_reviews')->insert([
            [
                'name'       => 'Jordan Rivera',
                'title'      => 'Comfortable for daily focus',
                'rating'     => 5,
                'comment'    => 'The fit is comfortable, calls are clear, and the sound stays balanced through a full workday.',
                'status'     => 'approved',
                'product_id' => $approvedProductId,
                'customer_id'=> null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Mina Shah',
                'title'      => 'Useful but still awaiting review',
                'rating'     => 4,
                'comment'    => 'This review stays pending so the public product page can confirm unapproved reviews are hidden.',
                'status'     => 'pending',
                'product_id' => $approvedProductId,
                'customer_id'=> null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Chris Nolan',
                'title'      => 'Great travel audio',
                'rating'     => 4,
                'comment'    => 'Easy to carry, simple to pair, and solid for commute listening.',
                'status'     => 'approved',
                'product_id' => $seededProducts['NEX-EAR-001']->id,
                'customer_id'=> null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
