<?php

namespace App\Http\Livewire;

use App\Models\Banner;
use App\Models\Category;
use App\Models\HomeCategory;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Cart;

class HomeComponent extends Component
{

    public function store($product_id, $product_name, $product_price){

        Cart::instance('cart')->add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');
        $this->emitTo('cart-count-component','refreshComponent');
        
        $this->dispatchBrowserEvent('add_to_cart_success',[
            'message' => 'Add To Cart Successfully',
        ]);
    }
    
    public function render()
    {
        $sliders = HomeSlider::where('status',1)->get();
        $lproducts = Product::orderBy('created_at','DESC')->get()->take(8);
        $category = HomeCategory::find(1);
        $cats = explode(',',$category->sel_categories);
        $categories = Category::whereIn('id',$cats)->get();
        $no_of_products = $category->no_of_products;
        $sproducts = Product::where('sale_price','>',0)->inRandomOrder()->get()->take(8);
        $sale= Sale::find(1);

        $leftBanner = Banner::where('name','Home Banner Left: 580 x 190 px')->first();
        $rightBanner = Banner::where('name','Home Banner Right: 580 x 190 px')->first();
        $lastProductBanner = Banner::where('name','Last Product Banner: 1170 x 240 px')->first();
        $categoryBanner = Banner::where('name','Categories Banner: 1170 x 240 px')->first();

        if(Auth::check()){
            Cart::instance('cart')->restore(Auth::user()->email);
            Cart::instance('wishlist')->restore(Auth::user()->email);
        }
        return view('livewire.home-component',['sliders'=>$sliders ,'lproducts'=>$lproducts, 'categories'=>$categories,
        'no_of_products'=>$no_of_products, 'sproducts'=>$sproducts, 
        'leftBanner' => $leftBanner, 'rightBanner' => $rightBanner, 'lastProductBanner' => $lastProductBanner, 'categoryBanner' => $categoryBanner, 
        'sale'=>$sale])->layout('layouts.base');
    }
}
