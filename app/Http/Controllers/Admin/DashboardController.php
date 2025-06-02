<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfWeek = Carbon::now()->startOfWeek();

        // Optimized queries using your actual column names
        $productStats = Product::selectRaw('
            COUNT(*) as total,
            SUM(is_active = 1) as active,
            SUM(stock_quantity < 5) as low_stock
        ')->first();

        $orderStats = Order::selectRaw('
            COUNT(*) as total,
            SUM(status = "completed") as completed,
            SUM(status = "pending") as pending,
            SUM(CASE WHEN status = "completed" THEN total_amount ELSE 0 END) as revenue
        ')->first();

        // Fetch recent orders with strict filtering for non-deleted products
        $recentOrders = Order::withCount(['items' => function ($query) {
            $query->whereHas('product', function ($query) {
                $query->whereNull('deleted_at');
            });
        }])
            ->having('items_count', '>', 0)
            ->with(['user', 'items' => function ($query) {
                $query->whereExists(function ($subQuery) {
                    $subQuery->select(DB::raw(1))
                        ->from('products')
                        ->whereColumn('products.id', 'order_items.product_id')
                        ->whereNull('products.deleted_at');
                })->with(['product' => function ($query) {
                    $query->whereNull('deleted_at');
                }]);
            }])
            ->latest()
            ->take(5)
            ->get();

        // Log the fetched orders for debugging
        Log::info('Recent Orders Fetched:', ['orders' => $recentOrders->toArray()]);

        return view('admin.dashboard', [
            'metrics' => [
                'products' => [
                    'total' => $productStats->total,
                    'active' => $productStats->active,
                    'low_stock' => $productStats->low_stock
                ],
                'orders' => [
                    'total' => $orderStats->total,
                    'completed' => $orderStats->completed,
                    'pending' => $orderStats->pending,
                    'revenue' => $orderStats->revenue
                ],
                'users' => [
                    'total' => User::count(),
                    'customers' => User::where('is_admin', false)->count(),
                    'new_this_month' => User::where('created_at', '>=', $startOfMonth)->count()
                ],
                'revenue' => [
                    'total' => $orderStats->revenue,
                    'monthly' => Order::where('status', 'completed')
                        ->where('created_at', '>=', $startOfMonth)
                        ->sum('total_amount'),
                    'weekly' => Order::where('status', 'completed')
                        ->where('created_at', '>=', $startOfWeek)
                        ->sum('total_amount')
                ]
            ],
            'recent_orders' => $recentOrders,
            'low_stock_products' => Product::with('category')
                ->where('stock_quantity', '<', 5)
                ->orderBy('stock_quantity')
                ->take(5)
                ->get()
        ]);
    }

    public function deleteOrder($id)
    {
        try {
            // Find the order
            $order = Order::find($id);

            if (!$order) {
                Log::warning("Order #{$id} not found for deletion.");
                return redirect()->back()->with('error', "Order #{$id} not found.");
            }

            // Delete related order_items (if no ON DELETE CASCADE)
            DB::table('order_items')
                ->where('order_id', $id)
                ->delete();

            // Delete the order
            $order->delete();

            Log::info("Order #{$id} deleted successfully.");

            return redirect()->back()->with('success', "Order #{$id} deleted successfully.");
        } catch (\Exception $e) {
            Log::error("Failed to delete Order #{$id}: " . $e->getMessage());
            return redirect()->back()->with('error', "Failed to delete Order #{$id}: " . $e->getMessage());
        }
    }
}
