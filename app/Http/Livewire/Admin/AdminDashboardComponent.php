<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttribute;
use Carbon\Carbon;
use Livewire\Component;

class AdminDashboardComponent extends Component
{
    public function render()
    {
        $orders = Order::orderBy('created_at','DESC')->get()->take(10);
        $totalSales = Order::where('status','delivered')->count();
        $totalRevenue = Order::where('status','delivered')->sum('total');

        $todaySales = Order::where('status','delivered')->whereDate('created_at',Carbon::today())->count();
        $todayRevenue = Order::where('status','delivered')->whereDate('created_at',Carbon::today())->sum('total');

        $categories_count = Category::all()->count();
        $products_count = Product::all()->count();
        $attributes_count = ProductAttribute::all()->count();
        $orders_count = Order::all()->count();

        return view('livewire.admin.admin-dashboard-component',[
            'orders'=>$orders,
            'totalSales'=>$totalSales,
            'totalRevenue'=>$totalRevenue,
            'todaySales'=>$todaySales,
            'todayRevenue'=>$todayRevenue,
            'categories_count'=>$categories_count,
            'products_count'=>$products_count,
            'attributes_count'=>$attributes_count,
            'orders_count'=>$orders_count,
            ])->layout('layouts.base');
    }
}
