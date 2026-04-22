<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Webkul\Theme\Repositories\ThemeCustomizationRepository;

class BannerController extends Controller
{
    public function __construct(
        protected ThemeCustomizationRepository $themes
    ) {}

    public function index(): View
    {
        $banners = DB::table('theme_customizations')
            ->leftJoin('theme_customization_translations as translations', function ($join): void {
                $join->on('translations.theme_customization_id', '=', 'theme_customizations.id')
                    ->where('translations.locale', '=', app()->getLocale());
            })
            ->leftJoin('channels', 'channels.id', '=', 'theme_customizations.channel_id')
            ->where('theme_customizations.type', 'image_carousel')
            ->orderBy('theme_customizations.sort_order')
            ->orderByDesc('theme_customizations.id')
            ->selectRaw('
                theme_customizations.id,
                theme_customizations.name,
                theme_customizations.sort_order,
                theme_customizations.status,
                theme_customizations.theme_code,
                channels.code as channel_code,
                COALESCE(JSON_LENGTH(translations.options, "$.images"), 0) as slides_count
            ')
            ->get();

        $channels = core()->getAllChannels();

        return view('admin.banners.index', compact('banners', 'channels'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'channel_id' => ['required', 'integer'],
            'theme_code' => ['required', 'string', 'max:255'],
        ]);

        $theme = $this->themes->create([
            'name'       => trim($validated['name']),
            'sort_order' => $validated['sort_order'],
            'channel_id' => $validated['channel_id'],
            'theme_code' => trim($validated['theme_code']),
            'type'       => 'image_carousel',
            'status'     => 1,
        ]);

        return redirect()
            ->route('admin.settings.themes.edit', $theme->id)
            ->with('success', 'Banner created. Add slides, links, and status on the edit screen.');
    }

    public function destroy(int $themeId): RedirectResponse
    {
        $theme = $this->themes->findOrFail($themeId);

        abort_if($theme->type !== 'image_carousel', 404);

        $this->themes->delete($themeId);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully.');
    }
}
