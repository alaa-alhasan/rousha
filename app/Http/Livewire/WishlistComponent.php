<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Sale;
use Livewire\Component;
use Cart;

class WishlistComponent extends Component
{

    public function removeFromWishlist($product_id){
        foreach(Cart::instance('wishlist')->content() as $witem){
            if($witem->id == $product_id){
                Cart::instance('wishlist')->remove($witem->rowId);
                $this->emitTo('wishlist-count-component','refreshComponent');
                return;
            }
        }
    }

    public function moveProductFromWishlistToCart($rowId){
        $item = Cart::instance('wishlist')->get($rowId);
        Cart::instance('wishlist')->remove($rowId);
        Cart::instance('cart')->add($item->id,$item->name,1,$item->price)->associate('App\Models\Product');
        $this->emitTo('wishlist-count-component','refreshComponent');
        $this->emitTo('cart-count-component','refreshComponent');

        $this->dispatchBrowserEvent('move_to_cart_success',[
            'message' => 'Moved To Cart Successfully',
        ]);
    }

    public function store($product_id, $product_name, $product_price){

        Cart::instance('cart')->add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');
        $this->emitTo('cart-count-component','refreshComponent');
        
        $this->dispatchBrowserEvent('add_to_cart_success',[
            'message' => 'Add To Cart Successfully',
        ]);
    }

    public function render()
    {

        $viewedProducts = Product::orderBy('vtimes','DESC')->get()->take(10);
        $sale= Sale::find(1);

        return view('livewire.wishlist-component',['viewedProducts' => $viewedProducts, 'sale' => $sale])->layout('layouts.base');
    }
}
