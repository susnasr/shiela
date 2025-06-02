<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // Redirect admin users to admin dashboard
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $user = Auth::user();

        // Calculate metrics
        $metrics = [
            'total_orders' => $user->orders()->count(),
            'pending_orders' => $user->orders()->where('status', 'pending')->count(),
            'wishlist_items' => $user->wishlist()->count(),
            'on_sale_items' => $user->wishlist()->whereHas('product', function ($q) {
                $q->where('discount_price', '>', 0);
            })->count(),
            'member_since' => $user->created_at->format('F Y'),
        ];

        // Fetch recent orders, excluding those with deleted products
        $recentOrders = $user->orders()
            ->with(['items' => function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->whereNull('deleted_at');
                });
            }])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', [
            'metrics' => $metrics,
            'recentActivities' => $this->getRecentActivities($user),
            'recentOrders' => $recentOrders,
        ]);
    }

    private function getRecentActivities($user)
    {
        $activities = collect();

        // Recent orders
        $user->orders()->latest()->take(2)->get()->each(function ($order) use ($activities) {
            $activities->push([
                'type' => 'order',
                'message' => "Order #{$order->id} - {$order->status}",
                'time' => $order->created_at,
            ]);
        });

        // Recent wishlist additions
        $user->wishlist()->latest()->take(2)->get()->each(function ($item) use ($activities) {
            $activities->push([
                'type' => 'wishlist',
                'message' => "Added {$item->product->name} to wishlist",
                'time' => $item->created_at,
            ]);
        });

        return $activities->sortByDesc('time')->take(4)->map(function ($activity) {
            $activity['time'] = $activity['time']->diffForHumans();
            return $activity;
        })->values();
    }
}
