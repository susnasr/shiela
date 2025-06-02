<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    public function salesReport(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->subMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : now();

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->get();

        $totalSales = $orders->sum('total_amount');
        $orderCount = $orders->count();
        $productsSold = $orders->sum(fn($order) => $order->orderItems->sum('quantity'));

        $topProducts = Product::withCount([
            'orderItems as sales' => function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate])
                        ->where('status', '!=', 'cancelled');
                });
            }
        ])->orderBy('sales', 'desc')->take(5)->get();

        return view('admin.reports.sales', compact(
            'startDate',
            'endDate',
            'totalSales',
            'orderCount',
            'productsSold',
            'topProducts'
        ));
    }

    public function customerReport()
    {
        $customers = User::where('role', 'buyer')
            ->withCount(['orders as total_orders'])
            ->withSum(['orders as total_spent' => function($query) {
                $query->where('status', '!=', 'cancelled');
            }])
            ->orderBy('total_spent', 'desc')
            ->paginate(10);

        return view('admin.reports.customers', compact('customers'));
    }
}
