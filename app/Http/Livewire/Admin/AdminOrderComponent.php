<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use App\Models\Transaction;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AdminOrderComponent extends Component
{
    public function updateOrderStatus($order_id,$status){
        $order = Order::find($order_id);
        $transaction = Transaction::where('order_id',$order_id)->first();

        
        if($status == "delivered"){
            $order->status = $status;
            $order->delivered_date = DB::raw('CURRENT_DATE');
            $transaction->status = 'approved';
        }
        else if($status == "canceled"){
            $order->status = $status;
            $order->canceled_date = DB::raw('CURRENT_DATE');
            $transaction->status = 'declined';
        }
        $order->save();
        $transaction->save();
        session()->flash('order_message','Order status has been updated successflly!');
    }
    public function render()
    {
        $orders = Order::orderBy('created_at','DESC')->paginate(12);
        return view('livewire.admin.admin-order-component',['orders'=>$orders])->layout('layouts.base');
    }
}
