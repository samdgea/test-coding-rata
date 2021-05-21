<?php


namespace App\Http\Controllers;


use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrderStatus;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController
{
    public function getOrderDetails($id, Request $request)
    {
        $order = Order::where('order_number', $id)->with('orderProgress', function($q) {
            $q->orderBy('created_at', 'desc');
        })->first();

        if (!$order->isEmpty()) {
            $items = OrderItems::where('order_id', $id)->get();

            return response()->json([
                'error' => false,
                'data' => [
                    'order_detail' => $order,
                    'items' => $items
                ]
            ]);
        } else {
            return response()->json([
                'error' => true,
                'desc' => 'Order tidak ditemukan'
            ]);
        }
    }

    public function postNewOrder(Request $request)
    {
        $request->validate([
            'receiver_name' => 'required|string|max:100',
            'receiver_address' => 'required|string|max:255',
            'order_item.*.item_id' => 'required|string',
            'order_item.*.qty' => 'required|integer'
        ]);

        DB::beginTransaction();

        try {
            $order = Order::create([
                'order_receiver' => $request->receiver_name,
                'order_receiver_address' => $request->receiver_address
            ]);

            $items = [];
            foreach ($request->order_item as $item) {
                $item = Item::where('item_code', $item['item_id'])->first();
                if (!empty($item)) {
                    $items[] = OrderItems::create([
                        'order_id' => $order->id,
                        'order_items_id' => $item->id,
                        'qty' => $item['qty']
                    ]);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'desc' => 'Failed to create new order'
            ]);
        }

        DB::commit();

        return response()->json([
            'error' => false,
            'desc' => 'success creating new order',
            'data' => [
                'order' => $order,
                'items' => $items
             ]
        ]);
    }

    public function postPayments(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'payment_method' => 'required|string',
            'payment_proof' => 'required|image',
            'payment_status' => 'nullable|string'
        ]);

        $order = Order::where('order_number', $request->order_number)->first();

        if (!empty($order) && $order->payments_id == null) {
            $filePath = $request->file('payment_proof')->store('payment_proof');
            $payment = Payment::create([
                'payment_method' => $request->payment_method,
                'payment_proof' => $filePath,
                'payment_status' => ($request->payment_status == null) ? 'pending' : $request->payment_status
            ]);

            $order->payments_id = $payment->id;
            $order->save();

            return response()->json([
                'error' => false,
                'desc' => 'Success store payment proof',
                'data' => $payment
            ]);
        } else {
            return response()->json([
                'error' => true,
                'desc'=> 'Invalid Order Number'
            ]);
        }
    }

    public function updatePayments(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'payment_method' => 'required|string',
            'payment_status' => 'nullable|string'
        ]);

        $order = Order::where('order_number', $request->order_number)->first();

        if (!empty($order) && $order->payments_id !== null) {
            $payments = Payment::where('id', $order->payments_id)
                                ->update([
                                    'payment_method' => $request->payment_method,
                                    'payment_status' => $request->payment_status
                                ]);

            return response()->json([
                'error' => false,
                'desc' => 'Success update payment proof',
                'data' => $payments
            ]);
        } else {
            return response()->json([
                'error' => true,
                'desc' => 'Invalid Order Number'
            ]);
        }
    }

    public function updateProgressOrder(Request $request) {
        $request->validate([
            'order_number' => 'required|string',
            'status_order' => 'required|string|in:Design,Confirmed,Printing,Ready,Sent,Completes',
            'status_remarks' => 'nullable|string'
        ]);

        $order = Order::where('order_number', $request->order_number)->first();

        if (!empty($order)) {
            $status = OrderStatus::create([
                'order_id' => $order->id,
                'order_status' => $request->status_order,
                'status_remarks' => $request->status_remarks
            ]);

            return response()->json([
                'error' => false,
                'desc' => 'Success update progress order number ' . $order->order_number,
                'data' => $status
            ]);
        } else {
            return response()->json([
                'error' => true,
                'desc' => 'Invalid Order Number'
            ]);
        }
    }
}
