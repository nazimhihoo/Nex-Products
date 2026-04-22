<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(): View
    {
        $brandAttribute = $this->getBrandAttribute();

        $brands = DB::table('attribute_options')
            ->leftJoin('attribute_option_translations as translations', function ($join): void {
                $join->on('translations.attribute_option_id', '=', 'attribute_options.id')
                    ->where('translations.locale', '=', app()->getLocale());
            })
            ->leftJoin('product_attribute_values as usage', function ($join) use ($brandAttribute): void {
                $join->on('usage.integer_value', '=', 'attribute_options.id')
                    ->where('usage.attribute_id', '=', $brandAttribute->id);
            })
            ->where('attribute_options.attribute_id', $brandAttribute->id)
            ->groupBy('attribute_options.id', 'attribute_options.admin_name', 'attribute_options.sort_order', 'translations.label')
            ->orderByRaw('COALESCE(attribute_options.sort_order, 999999)')
            ->orderBy('attribute_options.admin_name')
            ->selectRaw('
                attribute_options.id,
                attribute_options.admin_name,
                attribute_options.sort_order,
                COALESCE(translations.label, attribute_options.admin_name) as label,
                COUNT(DISTINCT usage.product_id) as products_count
            ')
            ->get();

        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $brandAttribute = $this->getBrandAttribute();
        $label = trim($validated['name']);

        $exists = DB::table('attribute_options')
            ->where('attribute_id', $brandAttribute->id)
            ->whereRaw('LOWER(admin_name) = ?', [mb_strtolower($label)])
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'That brand already exists.'])->withInput();
        }

        $optionId = DB::table('attribute_options')->insertGetId([
            'attribute_id' => $brandAttribute->id,
            'admin_name'   => $label,
            'sort_order'   => $validated['sort_order'] ?? 0,
            'swatch_value' => null,
        ]);

        DB::table('attribute_option_translations')->updateOrInsert([
            'attribute_option_id' => $optionId,
            'locale'              => app()->getLocale(),
        ], [
            'label' => $label,
        ]);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand created successfully.');
    }

    public function update(Request $request, int $optionId): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $brandAttribute = $this->getBrandAttribute();
        $option = DB::table('attribute_options')
            ->where('attribute_id', $brandAttribute->id)
            ->where('id', $optionId)
            ->first();

        abort_if(! $option, 404);

        $label = trim($validated['name']);

        $exists = DB::table('attribute_options')
            ->where('attribute_id', $brandAttribute->id)
            ->where('id', '<>', $optionId)
            ->whereRaw('LOWER(admin_name) = ?', [mb_strtolower($label)])
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'That brand already exists.'])->withInput();
        }

        DB::table('attribute_options')
            ->where('id', $optionId)
            ->update([
                'admin_name' => $label,
                'sort_order' => $validated['sort_order'] ?? 0,
            ]);

        DB::table('attribute_option_translations')->updateOrInsert([
            'attribute_option_id' => $optionId,
            'locale'              => app()->getLocale(),
        ], [
            'label' => $label,
        ]);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    public function destroy(int $optionId): RedirectResponse
    {
        $brandAttribute = $this->getBrandAttribute();
        $option = DB::table('attribute_options')
            ->where('attribute_id', $brandAttribute->id)
            ->where('id', $optionId)
            ->first();

        abort_if(! $option, 404);

        $inUse = DB::table('product_attribute_values')
            ->where('attribute_id', $brandAttribute->id)
            ->where('integer_value', $optionId)
            ->exists();

        if ($inUse) {
            return redirect()
                ->route('admin.brands.index')
                ->with('error', 'This brand is assigned to products and cannot be deleted yet.');
        }

        DB::table('attribute_options')->where('id', $optionId)->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }

    protected function getBrandAttribute(): object
    {
        $attribute = DB::table('attributes')->where('code', 'brand')->first();

        abort_if(! $attribute, 404, 'Brand attribute not found.');

        return $attribute;
    }
}
