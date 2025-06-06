<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Send a notification when a new order is created
        $this->sendNotification($order, 'New Order Created');
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Send a notification when an order is updated
        $this->sendNotification($order, 'Order Updated');

    }
    public function deleted(Order $order): void
    {
        // Send a notification when an order is updated
        $this->sendNotification($order, 'Order Deleted');

    }


    /**
     * Send a notification for an order event.
     */
    private function sendNotification(Order $order, string $title): void
    {
        $currentOrderBranchId = $order->branch_id;

        // Get the current authenticated user's assigned branch
        $currentUser = User::find(auth()->id());
        $currentUserBranchId = $currentUser ? $currentUser->store_assigned : null;

        // Get the branch name for the order's branch ID
        $orderBranchName = $order->storeBranch ? $order->storeBranch->store_name : 'Unknown Branch';

        // Get the branch name for the current user's assigned branch
        $currentUserBranchName = $this->getBranchName($currentUserBranchId);

        // Log details for debugging
        // Log::info("Order Branch Name: {$orderBranchName}, Current User Branch Name: {$currentUserBranchName}");

        // Only show notifications if the user's branch matches the order's branch
        if ($currentUserBranchId === $currentOrderBranchId) {
            // Get recipients for the notification
            $recipients = User::whereIn('role', ['Superadmin', 'Admin', 'Store_Staff'])
                ->where('store_assigned', $currentOrderBranchId)
                ->get();

            // Send the notification
            Notification::make()
                ->title($title)
                ->body("Order ID: {$order->order_id}, Status: {$order->status}, Store Branch: {$orderBranchName}")
                ->sendToDatabase($recipients);
        }
    }

    /**
     * Get the branch name by branch ID.
     */
    private function getBranchName($branchId): string
    {
        // Fetch the branch name from the Order model's related branch information
        $order = Order::where('branch_id', $branchId)->first();
        return $order && $order->storeBranch ? $order->storeBranch->store_name : 'Unknown Branch';
    }
}
