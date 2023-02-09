<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Cart;
use Ramsey\Uuid\Type\Integer;

class ApiController extends Controller
{

    function login(Request $req){

        try{
            $user = User::where('email',$req->email)->first(); // get from database

            if(!$user || !Hash::check($req->password,$user->password)){
                return response()->json([
                    'status' => 0,
                    'user_id' => -1,
                    'token' => '',
                    'message' => 'Invalid Username Or Password'
                ]);
            }

            $token = $user->createToken($user->email.'_Token')->plainTextToken;  // create token
            return response()->json([
                'status' => 1,
                'user_id' => $user->id,
                'token' => $token,
                'message' => 'Login Success'
            ]);
        }catch(\Throwable $th){
            return response()->json([
                'status' => -1,
                'user_id' => -1,
                'token' => '',
                'message' => 'Something Wrong'
            ]);
        }
    }

    function register(Request $req){

        try{
            if(User::where('email',$req->email)->first()){
                return response()->json([
                    'status' => 0,
                    'user_id' => -1,
                    'token' => '',
                    'message' => 'Already Exists'
                ]);
            }else{
                $user = new User();
                $user->name = $req->input('name');
                $user->email = $req->input('email');
                $user->password = Hash::make($req->input('password'));
    
                $user->save();  // save to database
    
                $token = $user->createToken($user->email.'_Token')->plainTextToken;  // create token
    
                return response()->json([
                    'status' => 1,
                    'user_id' => $user->id,
                    'token' => $token,
                    'message' => 'Register Success'
                ]);
            }
        }catch(\Throwable $th){
            return response()->json([
                'status' => -1,
                'user_id' => -1,
                'token' => '',
                'message' => 'Something Wrong'
            ]);
        }
    }

    function logout(Request $req){

        try{
            $req->user()->currentAccessToken()->delete();
            return true;
        }catch(\Throwable $th){
            return false;
        }
        
    }

    function recentlyAddedProducts() {

        $result = Product::latest()->take(4)->get();

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'result' => $result
        ]);
    }

    function mostViewedProducts() {

        $result = Product::orderBy('vtimes','DESC')->get()->take(4);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'result' => $result
        ]);
    }

    function featuredProducts() {

        $result = Product::where('featured',1)->get()->take(4);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'result' => $result
        ]);
    }

    
    function allCategories() {

        $result = Category::all();

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'result' => $result
        ]);
    }

    function productsByCategory($cat_id) {

        $result =  Product::where('category_id',$cat_id)->get();
        $message = $result->count() == 0 ? 'No Products Found!' : 'success';

        return response()->json([
            'status' => 200,
            'message' => $message,
            'result' => $result
        ]);
    }

    function productsSaleByCategory($cat_id) {

        $result =  Product::where('category_id',$cat_id)->where('sale_price','!=', null)->get();
        $message = $result->count() == 0 ? 'No Products Found!' : 'success';

        return response()->json([
            'status' => 200,
            'message' => $message,
            'result' => $result
        ]);
    }

    function randomProducts() {

        $result = Product::get()->take(5);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'result' => $result
        ]);
    }

    function getColors() {

        $result = [];
        try {
            // get all color values:
            $colorAttrID = ProductAttribute::where('name','Color')->pluck('id');
            $allColorsUsed = AttributeValue::where('product_attribute_id',$colorAttrID)->pluck('value')->unique();
        } catch (\Throwable $th) {
            $allColorsUsed = [];
        }

        foreach($allColorsUsed as $c){
            array_push($result, $c);
        }

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'result' => $result
        ]);
    }

    function getSizes() {

        $result = [];
        try {
            // get all size values:
            $sizeAttrID = ProductAttribute::where('name','Size')->pluck('id');
            $allSizesUsed = AttributeValue::where('product_attribute_id',$sizeAttrID)->pluck('value')->unique();
        } catch (\Throwable $th) {
            $allSizesUsed = [];
        }
        
        foreach($allSizesUsed as $s){
            array_push($result, $s);
        }

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'result' => $result
        ]);
    }

    function getPriceFilter() {

        $result = [];

        $min = intval(Product::min('regular_price'));
        $max = intval(Product::max('regular_price'));

        $diff = intval($max-$min);
        $stage = intval($diff/6);

        array_push($result, $min);

        for($i=$min+$stage; $i<$max; $i+=$stage){
            array_push($result, $i);
        }

        array_push($result, $max);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'result' => $result
        ]);
    }
    
    function filteredProducts(Request $req){

        $filtered_ids = Product::pluck('id');

        if ($req->has(['color', 'size'])) {
            $filtered_ids = AttributeValue::whereIn('value', [ (string) $req->input("color") , (string) $req->input("size") ] )->pluck('product_id')->unique();

        }elseif ($req->has('color')) {
            $filtered_ids = AttributeValue::where('value', (string) $req->input("color"))->pluck('product_id')->unique();

        }elseif ($req->has('size')) {
            $filtered_ids = AttributeValue::where('value', (string) $req->input("size"))->pluck('product_id')->unique();
            
        }else{}

        $minprice = (int)$req->input('minprice', 1);
        $maxprice = (int)$req->input('maxprice', 50000);

        $result = Product::whereIn('id', $filtered_ids)->whereBetween('regular_price',[$minprice,$maxprice])->get();

        $message = $result->count() == 0 ? 'No Products Found!' : 'success';

        return response()->json([
            'status' => 200,
            'message' => $message,
            'result' => $result
        ]);
    }

    function getProductColors($id){

        $result = [];

        $product = Product::find($id);

        try{
            foreach ($product->attributeValues->unique('product_attribute_id') as $av){
                if($av->productAttribute->name == 'Color'){
                    foreach ($av->productAttribute->attributeValues->where('product_id',$product->id) as $pav){
                        array_push($result, $pav->value);
                    }
                }
            }
        }catch(\Throwable $th){
        }

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'result' => $result
        ]);
    }

    function getProductSizes($id){

        $result = [];

        $product = Product::find($id);

        try{
            foreach ($product->attributeValues->unique('product_attribute_id') as $av){
                if($av->productAttribute->name == 'Size'){
                    foreach ($av->productAttribute->attributeValues->where('product_id',$product->id) as $pav){
                        array_push($result, $pav->value);
                    }
                }
            }
        }catch(\Throwable $th){
        }

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'result' => $result
        ]);
    }


    function productById($id){

        $result = Product::find($id);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'result' => $result
        ]);
    }


    function relatedProducts($id){

        $prod = Product::find($id);

        $result = Product::where('category_id', $prod->category_id)->inRandomOrder()->limit(5)->get();

        $message = $result->count() == 0 ? 'No Products Related!' : 'success';

        return response()->json([
            'status' => 200,
            'message' => $message,
            'result' => $result
        ]);
    }

    function search($str){

        $result = Product::where('name', 'like' , '%'. $str .'%')->get();

        $message = $result->count() == 0 ? 'No Products Found!' : 'success';

        return response()->json([
            'status' => 200,
            'message' => $message,
            'result' => $result
        ]);
    }


    function nameAndImage(Request $req){

        $user = $req->user();

        $username = $user->name;

        $p = Profile::where('user_id', $user->id)->first();
        $image = $p->image;
        
        return response()->json([
            'username' => $username,
            'image' => $image
        ]);

    }


    function myOrders(Request $req) {

        $result = Order::where('user_id',$req->user()->id)->get();

        if( $result->count() == 0 ){
            return [];
        }
        else return $result;
    }

    function myProfile(Request $req) {

        $result = Profile::where('user_id',$req->user()->id)->first();

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'result' => $result
        ]);
    }

    function updateMyProfile(Request $req) {

        $user = $req->user();

        $profile_updated = false;

        if ($req->has('name')){
            $user->name = $req->input('name');
            $user->save();
        }

        if ($req->has('mobile')){
            $user->profile->mobile = $req->input('mobile');
            $profile_updated = true;
        }
        if ($req->has('date_of_birth')){
            $user->profile->date_of_birth = $req->input('date_of_birth');
            $profile_updated = true;
        }
        if ($req->has('image')){

            if($user->profile->image){
                unlink('assets/images/profile/'.$user->profile->image);
            }

            $imageName = Carbon::now()->timestamp .'.' . $req->file('image')->extension();
            $req->file('image')->storeAs('profile',$imageName);

            $user->profile->image = $imageName;
            $profile_updated = true;
        }
        if ($req->has('line1')){
            $user->profile->line1 = $req->input('line1');
            $profile_updated = true;
        }
        if ($req->has('line2')){
            $user->profile->line2 = $req->input('line2');
            $profile_updated = true;
        }
        if ($req->has('city')){
            $user->profile->city = $req->input('city');
            $profile_updated = true;
        }
        if ($req->has('province')){
            $user->profile->province = $req->input('province');
            $profile_updated = true;
        }
        if ($req->has('country')){
            $user->profile->country = $req->input('country');
            $profile_updated = true;
        }
        if ($req->has('zipcode')){
            $user->profile->zipcode = $req->input('zipcode');
            $profile_updated = true;
        }

        if($profile_updated == true){
            $user->profile->save();
            return true;
        }

        return false;
    }


    function myWishlist(Request $req) {

        $result = [];

        try{

            Cart::instance('wishlist')->restore($req->user()->email);  // get your wishlist from database
            if(Cart::instance('wishlist')->count() == 0){
                return [];
            }else{

                foreach(Cart::instance('wishlist')->content() as $w){
                    array_push($result, $w);
                }

                return $result;

                // return Cart::instance('wishlist')->content();
            }

        }catch(\Throwable $th){
            return [];
        }
    }

    function addToWishlist(Request $req) {

        $message = 'Item Not Added!, Check The Product ID';

        if($req->has('product_id')){

            $product_id = $req->input('product_id');
            $product = Product::find($product_id);
            $product_name = $product->name;
            $product_price = $product->regular_price;

            Cart::instance('wishlist')->add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');

            Cart::instance('wishlist')->store($req->user()->email); // store wishlist in database

            $message = 'Item Added Successfully!';

        }

        return response()->json([
            'status' => 200,
            'message' => $message
        ]);

    }

    function removeItemWishlist(Request $req) {


        if($req->has('rowId')){

            try{
                Cart::instance('wishlist')->restore($req->user()->email);
            
                Cart::instance('wishlist')->remove($req->input('rowId'));

                Cart::instance('wishlist')->store($req->user()->email);

                return true;

            }catch(\Exception $th){
                return false;
            }

            
        }else{

            return false;
        }
    }

    function moveToCart(Request $req) {


        if($req->has('rowId')){

            try{
                Cart::instance('wishlist')->restore($req->user()->email);

                $item = Cart::instance('wishlist')->get($req->input('rowId'));

                Cart::instance('wishlist')->remove($req->input('rowId'));

                Cart::instance('cart')->restore($req->user()->email);

                Cart::instance('cart')->add($item->id,$item->name,1,$item->price)->associate('App\Models\Product');

                Cart::instance('cart')->store($req->user()->email);
                Cart::instance('wishlist')->store($req->user()->email);

                return true;

            }catch(\Exception $th){
                return false;
            }


        }else{
            return false;
        }

    }

    function clearWishlist(Request $req) {

        try{

            Cart::instance('wishlist')->restore($req->user()->email);
            Cart::instance('wishlist')->destroy();
            Cart::instance('wishlist')->store($req->user()->email);

            if(Cart::instance('wishlist')->count() == 0){
                return true;
            }else{
                return false;
            }


        }catch(\Exception $th){
            return false;
        }

        
    }


    function myCart(Request $req) {

        $result = [];

        try{

            Cart::instance('cart')->restore($req->user()->email);  // get your cart from database
            if(Cart::instance('cart')->count() == 0){
                return [];
            }else{

                foreach( Cart::instance('cart')->content() as $c){
                    array_push($result, $c);
                }

                return $result;

            }

        }catch(\Throwable $th){
            return [];
        }
    }

    function removeItemCart(Request $req) {

        
        if($req->has('rowId')){

            try{
                Cart::instance('cart')->restore($req->user()->email);
            
                Cart::instance('cart')->remove($req->input('rowId'));

                Cart::instance('cart')->store($req->user()->email);

                return true;

            }catch(\Exception $th){
                return false;
            }

            
        }else{

            return false;
        }
    }

    function clearCart(Request $req) {

        try{

            Cart::instance('cart')->restore($req->user()->email);
            Cart::instance('cart')->destroy();
            Cart::instance('cart')->store($req->user()->email);

            if(Cart::instance('cart')->count() == 0){
                return true;
            }else{
                return false;
            }


        }catch(\Exception $th){
            return false;
        }
    }

    function cartSummary(Request $req){

        $result = [];
        try{

            Cart::instance('cart')->restore($req->user()->email);  // get your cart from database
            if(Cart::instance('cart')->count() == 0){
                return [];
            }else{

                $subtotal = Cart::instance('cart')->subtotal();
                $tax = Cart::instance('cart')->tax();
                $total = Cart::instance('cart')->total();

                array_push($result, $subtotal);
                array_push($result, $tax);
                array_push($result, $total);

                return $result;

            }

        }catch(\Throwable $th){
            return [];
        }
    }

    function addToCart(Request $req) {  // need to add product option

        $message = 'Item Not Added!, Check The Product ID';

        if($req->has('product_id')){

            $product_id = $req->input('product_id');
            $product = Product::find($product_id);
            $product_name = $product->name;
            $product_price = $product->regular_price;

            Cart::instance('cart')->add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');

            Cart::instance('cart')->store($req->user()->email); // store cart in database

            $message = 'Item Added Successfully!';

        }

        return response()->json([
            'status' => 200,
            'message' => $message
        ]);

    }

    function increaseItemCartQuantity(Request $req) {

        $message = 'Increase Quantity Faild!, Check The rowId';

        if($req->has('rowId')){

            Cart::instance('cart')->restore($req->user()->email);
            $product = Cart::instance('cart')->get($req->input('rowId'));
            $qty = $product->qty + 1;
            Cart::instance('cart')->update($req->input('rowId') , $qty);

            Cart::instance('cart')->store($req->user()->email); // store cart in database

            $message = 'Increase Quantity Success!';
        }

        return response()->json([
            'status' => 200,
            'message' => $message
        ]);
    }

    function decreaseItemCartQuantity(Request $req) {

        $message = 'Decrease Quantity Faild!, Check The rowId';

        if($req->has('rowId')){

            Cart::instance('cart')->restore($req->user()->email);
            $product = Cart::instance('cart')->get($req->input('rowId'));
            $qty = $product->qty - 1;
            Cart::instance('cart')->update($req->input('rowId') , $qty);

            Cart::instance('cart')->store($req->user()->email); // store cart in database

            $message = 'Decrease Quantity Success!';
        }

        return response()->json([
            'status' => 200,
            'message' => $message
        ]);
    }




}
