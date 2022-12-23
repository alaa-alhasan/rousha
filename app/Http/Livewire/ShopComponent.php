<?php

namespace App\Http\Livewire;

use App\Models\AttributeValue;
use App\Models\Banner;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class ShopComponent extends Component
{
    public $sorting;
    public $pagesize;

    public $min_price;
    public $max_price;

    public $attribute_arr = [];
    public $allattributeValue = [];

    public $display_mode = 'grid';

    public $color_selected;
    public $size_selected;

    public $colored_products_ids = [];
    public $sized_products_ids = [];

    public function mount(){

        $this->sorting = "default";
        $this->pagesize = 6;

        $this->min_price = 1;
        $this->max_price = 50000;

    }

    public function changeDisplayMode($mode)
    {
        $this->display_mode = $mode;
    }

    public function selectColor($colr)
    {
        $this->color_selected = $colr;
        $this->colored_products_ids = AttributeValue::where('value',$this->color_selected)->pluck('product_id')->unique();
        $this->attribute_arr = [];
    }

    public function selectSize($size)
    {
        $this->size_selected = $size;
        $this->sized_products_ids = AttributeValue::where('value',$this->size_selected)->pluck('product_id')->unique();
        $this->attribute_arr = [];
    }

    public function store($product_id, $product_name, $product_price){

        Cart::instance('cart')->add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');
        $this->emitTo('cart-count-component','refreshComponent');
        
        $this->dispatchBrowserEvent('add_to_cart_success',[
            'message' => 'Add To Cart Successfully',
        ]);

        //session()->flash('success_message','Item added to cart');
        //return redirect()->route('product.cart');
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

    public function addAttrFilter($attr_id)
    {

        $this->color_selected = null;
        $this->size_selected = null;
    
        $this->colored_products_ids = [];
        $this->sized_products_ids = [];

        if(!in_array($attr_id,$this->attribute_arr))
        {
            array_push($this->attribute_arr,$attr_id);
            
        }
        else{
            $key = array_search($attr_id, $this->attribute_arr);
            unset($this->attribute_arr[$key]);
        }

        
        $this->allattributeValue = AttributeValue::whereIn('product_attribute_id', $this->attribute_arr)->pluck('product_id');
        
        $this->color_selected = null;
        $this->size_selected = null;

    }

    use WithPagination;
    public function render()
    {
        if($this->attribute_arr)
        {
            if($this->sorting == 'date'){
                $products = Product::whereIn('id',$this->allattributeValue)->whereBetween('regular_price',[$this->min_price,$this->max_price])->orderBy('created_at','DESC')->paginate($this->pagesize);
            }
            else if($this->sorting == 'price'){
                $products = Product::whereIn('id',$this->allattributeValue)->whereBetween('regular_price',[$this->min_price,$this->max_price])->orderBy('regular_price','ASC')->paginate($this->pagesize);
            }
            else if($this->sorting == 'price-desc'){
                $products = Product::whereIn('id',$this->allattributeValue)->whereBetween('regular_price',[$this->min_price,$this->max_price])->orderBy('regular_price','DESC')->paginate($this->pagesize);
            }
            else {
                $products = Product::whereIn('id',$this->allattributeValue)->whereBetween('regular_price',[$this->min_price,$this->max_price])->paginate($this->pagesize);
            }
        }
        else
        {


            if($this->color_selected){

                if($this->sorting == 'date'){
                    $products = Product::whereIn('id',$this->colored_products_ids)->whereBetween('regular_price',[$this->min_price,$this->max_price])->orderBy('created_at','DESC')->paginate($this->pagesize);
                }
                else if($this->sorting == 'price'){
                    $products = Product::whereIn('id',$this->colored_products_ids)->whereBetween('regular_price',[$this->min_price,$this->max_price])->orderBy('regular_price','ASC')->paginate($this->pagesize);
                }
                else if($this->sorting == 'price-desc'){
                    $products = Product::whereIn('id',$this->colored_products_ids)->whereBetween('regular_price',[$this->min_price,$this->max_price])->orderBy('regular_price','DESC')->paginate($this->pagesize);
                }
                else {
                    $products = Product::whereIn('id',$this->colored_products_ids)->whereBetween('regular_price',[$this->min_price,$this->max_price])->paginate($this->pagesize);
                }

            }
            else if($this->size_selected){

                if($this->sorting == 'date'){
                    $products = Product::whereIn('id',$this->sized_products_ids)->whereBetween('regular_price',[$this->min_price,$this->max_price])->orderBy('created_at','DESC')->paginate($this->pagesize);
                }
                else if($this->sorting == 'price'){
                    $products = Product::whereIn('id',$this->sized_products_ids)->whereBetween('regular_price',[$this->min_price,$this->max_price])->orderBy('regular_price','ASC')->paginate($this->pagesize);
                }
                else if($this->sorting == 'price-desc'){
                    $products = Product::whereIn('id',$this->sized_products_ids)->whereBetween('regular_price',[$this->min_price,$this->max_price])->orderBy('regular_price','DESC')->paginate($this->pagesize);
                }
                else {
                    $products = Product::whereIn('id',$this->sized_products_ids)->whereBetween('regular_price',[$this->min_price,$this->max_price])->paginate($this->pagesize);
                }

            }

            else{
                if($this->sorting == 'date'){
                    $products = Product::whereBetween('regular_price',[$this->min_price,$this->max_price])->orderBy('created_at','DESC')->paginate($this->pagesize);
                }
                else if($this->sorting == 'price'){
                    $products = Product::whereBetween('regular_price',[$this->min_price,$this->max_price])->orderBy('regular_price','ASC')->paginate($this->pagesize);
                }
                else if($this->sorting == 'price-desc'){
                    $products = Product::whereBetween('regular_price',[$this->min_price,$this->max_price])->orderBy('regular_price','DESC')->paginate($this->pagesize);
                }
                else {
                    $products = Product::whereBetween('regular_price',[$this->min_price,$this->max_price])->paginate($this->pagesize);
                }
            }

        }
        
        $categories = Category::all();

        $sale= Sale::find(1);

        $pattributes = ProductAttribute::all();

        try {
            // get all color values:
            $colorAttrID = ProductAttribute::where('name','Color')->pluck('id');
            $allColorsUsed = AttributeValue::where('product_attribute_id',$colorAttrID)->pluck('value')->unique();
        } catch (\Throwable $th) {
            $allColorsUsed = [];
        }

        try {
            // get all size values:
            $sizeAttrID = ProductAttribute::where('name','Size')->pluck('id');
            $allSizesUsed = AttributeValue::where('product_attribute_id',$sizeAttrID)->pluck('value')->unique();
        } catch (\Throwable $th) {
            $allSizesUsed = [];
        }

        $shopBanner = Banner::where('name','Shop Banner: 870 x 272 px')->first();

        $popular_products = Product::inRandomOrder()->limit(4)->get();

        if(Auth::check()){
            Cart::instance('cart')->store(Auth::user()->email);
            Cart::instance('wishlist')->store(Auth::user()->email);
        }

        
        return view('livewire.shop-component', ['products' => $products, 'categories' =>$categories, 
        'pattributes'=>$pattributes, 'sale' => $sale, 'dismode' => $this->display_mode, 'allColorsUsed' => $allColorsUsed, 
        'allSizesUsed'=> $allSizesUsed, 'shopBanner' => $shopBanner, 'popular_products' => $popular_products])->layout("layouts.base");
    }
}