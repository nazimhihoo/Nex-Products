<?php

namespace Webkul\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Webkul\Admin\Helpers\Dashboard;

class DashboardController extends Controller
{
    /**
     * Request param functions
     *
     * @var array
     */
    protected $typeFunctions = [
        'over-all' => 'getOverAllStats',
        'today' => 'getTodayStats',
        'stock-threshold-products' => 'getStockThresholdProducts',
        'total-sales' => 'getSalesStats',
        'top-selling-products' => 'getTopSellingProducts',
        'top-customers' => 'getTopCustomers',
    ];

    /**
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct(protected Dashboard $dashboardHelper) {}

    /**
     * Dashboard page.
     *
     * @return View|JsonResponse
     */
    public function index()
    {
        $today = now()->toDateString();
        $monthStart = now()->startOfMonth();

        $stats = [
            'orders'        => DB::table('orders')->count(),
            'today_orders'  => DB::table('orders')->whereDate('created_at', $today)->count(),
            'pending_orders'=> DB::table('orders')->where('status', 'pending')->count(),
            'customers'     => DB::table('customers')->count(),
            'users'         => DB::table('admins')->count(),
            'products'      => DB::table('products')->count(),
            'categories'    => DB::table('categories')->count(),
            'banners'       => DB::table('theme_customizations')->where('type', 'image_carousel')->count(),
            'low_stock'     => DB::table('product_inventories')->where('qty', '<=', 5)->count(),
            'stock_units'   => DB::table('product_inventories')->sum('qty'),
            'revenue'       => DB::table('orders')->sum('base_grand_total'),
            'today_revenue' => DB::table('orders')->whereDate('created_at', $today)->sum('base_grand_total'),
            'month_revenue' => DB::table('orders')->where('created_at', '>=', $monthStart)->sum('base_grand_total'),
        ];

        $stats['average_order'] = $stats['orders']
            ? $stats['revenue'] / $stats['orders']
            : 0;

        $activeProducts = 0;

        if (Schema::hasTable('product_flat') && Schema::hasColumn('product_flat', 'status')) {
            $activeProducts = DB::table('product_flat')
                ->where('status', 1)
                ->distinct('product_id')
                ->count('product_id');
        }

        $stats['active_products'] = $activeProducts;

        $orderStatuses = DB::table('orders')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $recentOrders = DB::table('orders')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get(['id', 'increment_id', 'status', 'customer_email', 'base_grand_total', 'created_at']);

        $recentCustomers = DB::table('customers')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get(['id', 'first_name', 'last_name', 'email', 'created_at']);

        $lowStockProducts = DB::table('product_inventories')
            ->join('products', 'products.id', '=', 'product_inventories.product_id')
            ->where('product_inventories.qty', '<=', 5)
            ->orderBy('product_inventories.qty')
            ->limit(5)
            ->get(['products.id', 'products.sku', 'product_inventories.qty']);

        return view('admin::dashboard.nex-index', compact('stats', 'orderStatuses', 'recentOrders', 'recentCustomers', 'lowStockProducts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function stats()
    {
        $stats = $this->dashboardHelper->{$this->typeFunctions[request()->query('type')]}();

        return response()->json([
            'statistics' => $stats,
            'date_range' => $this->dashboardHelper->getDateRange(),
        ]);
    }
}
