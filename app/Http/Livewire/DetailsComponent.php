<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Cache\RateLimiting\Limit;
use Livewire\Component;
use Cart;

class DetailsComponent extends Component
{
    public $slug;
    public $qty;
    public $satt = [];

    public function mount($slug){

        $this->slug = $slug;
        $this->qty = 1;

        $prod = Product::where('slug', $this->slug)->first();
        $temp = $prod->vtimes + 1;
        $prod->vtimes = $temp;
        $prod->save();

    }

    public function store($product_id, $product_name, $product_price){
        Cart::instance('cart')->add($product_id,$product_name,$this->qty,$product_price,$this->satt)->associate('App\Models\Product');
        session()->flash('success_message','Item added to cart');
        $this->emitTo('cart-count-component','refreshComponent');
        //return redirect()->route('product.cart');

        $this->dispatchBrowserEvent('add_to_cart_success',[
            'message' => 'Added To Cart Successfully',
        ]);
    }

    public function addToWishlist($product_id, $product_name, $product_price){
        Cart::instance('wishlist')->add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');
        $this->emitTo('wishlist-count-component','refreshComponent');

        $this->dispatchBrowserEvent('add_to_wishlist_success',[
            'message' => 'Add To Wishlist Successfully',
        ]);
    }

    public function removeFromWishlist($product_id){
        foreach(Cart::instance('wishlist')->content() as $witem){
            if($witem->id == $product_id){
                Cart::instance('wishlist')->remove($witem->rowId);
                $this->emitTo('wishlist-count-component','refreshComponent');

                $this->dispatchBrowserEvent('remove_from_wishlist_success',[
                    'message' => 'Removed From Wishlist Successfully',
                ]);
                return;
            }
        }
    }

    public function increaseQuantity(){
        $this->qty++;
    }

    public function decreaseQuantity(){
        if($this->qty > 1){
            $this->qty--;
        }
    }

    public function render()
    {
        $product = Product::where('slug', $this->slug)->first();
        $popular_products = Product::inRandomOrder()->limit(4)->get();
        $related_products = Product::where('category_id', $product->category_id)->inRandomOrder()->limit(5)->get();
        $sale = Sale::find(1);
        return view('livewire.details-component', ['product' => $product, 'popular_products' => $popular_products, 'related_products' => $related_products, 'sale'=>$sale])->layout('layouts.base');
    }
}
