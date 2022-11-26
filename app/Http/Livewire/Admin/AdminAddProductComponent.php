<?php

namespace App\Http\Livewire\Admin;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Subcategory;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AdminAddProductComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $slug;
    public $short_description;
    public $description;
    public $regular_price;
    public $sale_price;
    public $SKU;
    public $stock_status;
    public $featured;
    public $quantity;
    public $image;
    public $category_id;
    public $images;
    public $scategory_id;

    public $attr;
    public $inputs = [];
    public $attribute_arr = [];
    public $attribute_values;

    public function mount(){
        $this->stock_status = 'instock';
        $this->featured = 0;
    }

    public function attributeHelper($the_value, $key)
    {
        if(isset($this->attribute_values[$key]))
        {
            $txt = $this->attribute_values[$key];
            $temp = 0;

            $words = explode(",",$txt);
            foreach($words as $w)
            {
                if($w == $the_value){ $temp = 1; }
            }

            if($temp == 0)
            {
                $txt = $txt . ',' . $the_value;
                $this->attribute_values[$key] = $txt;
            }

            // if(!Str::contains($txt, $the_value))
            // {
            //     $txt = $txt . ',' . $the_value;
            //     $this->attribute_values[$key] = $txt;
            // }
        }
        else{
            $this->attribute_values[$key] = $the_value;
        }
    }

    public function clearHelper($key)
    {
        if(isset($this->attribute_values[$key]))
        {
            unset($this->attribute_values[$key]);
        }
    }

    public function add(){
        if(!in_array($this->attr,$this->attribute_arr)){
            array_push($this->inputs,$this->attr);
            array_push($this->attribute_arr,$this->attr);
        }
    }

    public function remove($attr , $attribute_values_key){
        unset($this->inputs[$attr]);
        $this->clearHelper($attribute_values_key);
    }

    public function generateSlug(){
        $this->slug = Str::slug($this->name,'-');
    }

    public function updated($fields){
        $this->validateOnly($fields,[
            'name' => 'required',
            'slug' => 'required|unique:products',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'numeric|nullable',
            'SKU' => 'required',
            'stock_status' => 'required',
            'quantity' => 'required|numeric',
            'image' => 'required|mimes:jpeg,jpg,png',
            'category_id' => 'required'
        ]);
    }

    public function addProduct(){

        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:products',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'numeric|nullable',
            'SKU' => 'required',
            'stock_status' => 'required',
            'quantity' => 'required|numeric',
            'image' => 'required|mimes:jpeg,jpg,png',
            'category_id' => 'required'
        ]); 
        $product = new Product();
        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->short_description = $this->short_description;
        $product->description = $this->description;
        $product->regular_price = $this->regular_price;
        $product->sale_price = $this->sale_price;
        $product->SKU = $this->SKU;
        $product->stock_status = $this->stock_status;
        $product->featured = $this->featured;
        $product->quantity = $this->quantity;

        $imageName = Carbon::now()->timestamp. '.' . $this->image->extension();
        $this->image->storeAs('products',$imageName);
        $product->image = $imageName;

        if($this->images){
            $imagesname= '';
            foreach($this->images as $key=>$image){
                $imgName = Carbon::now()->timestamp. $key.'.' . $image->extension();
                $image->storeAs('products',$imgName);
                $imagesname = $imagesname. ','. $imgName;
            }

            $product->images = $imagesname;
        }

        $product->category_id = $this->category_id;
        if($this->scategory_id){
            $product->subcategory_id = $this->scategory_id;
        }
        ($this->attribute_values);
        $product->save();

        if($this->attribute_values){
            foreach($this->attribute_values as $key=>$attribute_value){
                $avalues = explode(",",$attribute_value);
                foreach($avalues as $avalue){
                    $attr_value = new AttributeValue();
                    $attr_value->product_attribute_id = $key;
                    $attr_value->value = $avalue;
                    $attr_value->product_id = $product->id;
                    $attr_value->save();
                }
            }
        }


        session()->flash('message','Product has been created successfully!');
        $this->dispatchBrowserEvent('add_product_success',[
            'message' => 'Product has been created successfully!',
        ]);
    }

    public function changeSubcategory(){
        $this->scategory_id = 0;
    }

    public function render()
    {
        $categories = Category::all();
        $scategories = Subcategory::where('category_id',$this->category_id)->get();

        $pattributes = ProductAttribute::all();

        return view('livewire.admin.admin-add-product-component',['categories'=>$categories,'scategories'=>$scategories,'pattributes'=>$pattributes])->layout('layouts.base');
    }
}
