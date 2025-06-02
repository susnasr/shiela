<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     * (For listing orders)
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'customer'; // Only customers can view their orders
    }

    /**
     * Determine whether the user can view a specific order.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id; // Only the order owner can view
    }

    /**
     * Determine whether the user can create orders.
     */
    public function create(User $user): bool
    {
        return $user->role === 'customer'; // Only customers can create orders
    }

    /**
     * Determine whether the user can update the model.
     * (Typically for admin only)
     */
    public function update(User $user, Order $order): bool
    {
        return $user->role === 'admin'; // Only admins can update orders
    }

    /**
     * Determine whether the user can delete the model.
     * (Typically for admin only)
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->role === 'admin'; // Only admins can delete orders
    }

    /**
     * Determine whether the user can restore soft-deleted models.
     */
    public function restore(User $user, Order $order): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete models.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return $user->role === 'admin';
    }
}
