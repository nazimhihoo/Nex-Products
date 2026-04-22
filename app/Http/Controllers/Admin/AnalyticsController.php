<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $salesStats = DB::table('orders')
            ->selectRaw('COUNT(*) as total_orders')
            ->selectRaw('COALESCE(SUM(base_grand_total), 0) as total_revenue')
            ->selectRaw('COALESCE(AVG(base_grand_total), 0) as average_order_value')
            ->selectRaw('SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as pending_orders', ['pending'])
            ->first();

        $totals = [
            'products'    => DB::table('products')->count(),
            'categories'  => DB::table('categories')->count(),
            'customers'   => DB::table('customers')->count(),
            'users'       => DB::table('admins')->count(),
            'reviews'     => DB::table('product_reviews')->count(),
            'banners'     => DB::table('theme_customizations')->where('type', 'image_carousel')->count(),
            'low_stock'   => DB::table('product_inventories')->where('qty', '<=', 5)->count(),
            'active_promotions' => DB::table('cart_rules')->where('status', 1)->count() + DB::table('catalog_rules')->where('status', 1)->count(),
        ];

        $recentOrders = DB::table('orders')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get([
                'id',
                'increment_id',
                'status',
                'customer_email',
                'base_grand_total',
                'created_at',
            ]);

        $topProducts = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->groupBy('order_items.product_id', 'products.sku')
            ->orderByDesc(DB::raw('SUM(order_items.qty_ordered)'))
            ->limit(5)
            ->get([
                'products.sku',
                DB::raw('SUM(order_items.qty_ordered) as sold_qty'),
                DB::raw('MAX(order_items.name) as name'),
            ]);

        return view('admin.analytics.index', [
            'salesStats'   => $salesStats,
            'totals'       => $totals,
            'recentOrders' => $recentOrders,
            'topProducts'  => $topProducts,
        ]);
    }
}
