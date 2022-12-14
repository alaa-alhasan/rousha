<?php

namespace App\Http\Livewire;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Profile;
use App\Models\Shipping;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Cart;
use Cartalyst\Stripe\Stripe;
use Exception;
use Illuminate\Support\Facades\Mail;

class CheckoutComponent extends Component
{
    public $ship_to_different;

    public $firstname;
    public $lastname;
    public $email;
    public $mobile;
    public $line1;
    public $line2;
    public $city;
    public $province;
    public $country;
    public $zipcode;

    public $s_firstname;
    public $s_lastname;
    public $s_email;
    public $s_mobile;
    public $s_line1;
    public $s_line2;
    public $s_city;
    public $s_province;
    public $s_country;
    public $s_zipcode;

    public $paymentmode;
    public $thankyou;

    public $card_no;
    public $exp_month;
    public $exp_year;
    public $cvc;

    public function mount(){
        $current_user = Profile::where('user_id',Auth::user()->id)->first();
        if($current_user){
            $this->firstname = Auth::user()->name ;
            $this->email = Auth::user()->email ;
            $this->mobile = $current_user->mobile ;
            $this->line1 = $current_user->line1 ;
            $this->line2 = $current_user->line2 ;
            $this->city = $current_user->city ;
            $this->province = $current_user->province ;
            $this->country = $current_user->country ;
            $this->zipcode = $current_user->zipcode ;
        }
    }

    public function updated($fields){
        $this->validateOnly($fields,[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'line1' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
            'paymentmode' => 'required'
        ]);

        if($this->ship_to_different){
            $this->validateOnly($fields,[
                's_firstname' => 'required',
                's_lastname' => 'required',
                's_email' => 'required|email',
                's_mobile' => 'required|numeric',
                's_line1' => 'required',
                's_city' => 'required',
                's_province' => 'required',
                's_country' => 'required',
                's_zipcode' => 'required'
            ]);
        }
        if($this->paymentmode == 'card'){
            $this->validateOnly($fields,[
                'card_no' => 'required|numeric',
                'exp_month' => 'required|numeric',
                'exp_year' => 'required|numeric',
                'cvc' => 'required|numeric'
            ]);
        }
    }

    public function placeOrder(){

        $succ = false;

        $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'line1' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
            'paymentmode' => 'required'
        ]);

        if($this->paymentmode == 'card'){
            $this->validate([
                'card_no' => 'required|numeric',
                'exp_month' => 'required|numeric',
                'exp_year' => 'required|numeric',
                'cvc' => 'required|numeric'
            ]);
        }

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->subtotal = session()->get('checkout')['subtotal'];
        $order->discount = session()->get('checkout')['discount'];
        $order->tax = session()->get('checkout')['tax'];
        $order->total = session()->get('checkout')['total'];
        $order->firstname = $this->firstname;
        $order->lastname = $this->lastname;
        $order->email = $this->email;
        $order->mobile = $this->mobile;
        $order->line1 = $this->line1;
        $order->line2 = $this->line2;
        $order->city = $this->city;
        $order->province = $this->province;
        $order->country = $this->country;
        $order->zipcode = $this->zipcode;
        $order->status = 'ordered';
        $order->is_shipping_different = $this->ship_to_different ? 1:0;
        $order->save();  //connect to database

        foreach(Cart::instance('cart')->content() as $item){
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;

            if($item->options){
                $orderItem->options = serialize($item->options);
            }

            $orderItem->save();  //connect to database
        }

        if($this->ship_to_different){
            $this->validate([
                's_firstname' => 'required',
                's_lastname' => 'required',
                's_email' => 'required|email',
                's_mobile' => 'required|numeric',
                's_line1' => 'required',
                's_city' => 'required',
                's_province' => 'required',
                's_country' => 'required',
                's_zipcode' => 'required'
            ]);

            $shipping = new Shipping();
            $shipping->order_id = $order->id;
            $shipping->firstname = $this->s_firstname;
            $shipping->lastname = $this->s_lastname;
            $shipping->email = $this->s_email;
            $shipping->mobile = $this->s_mobile;
            $shipping->line1 = $this->s_line1;
            $shipping->line2 = $this->s_line2;
            $shipping->city = $this->s_city;
            $shipping->province = $this->s_province;
            $shipping->country = $this->s_country;
            $shipping->zipcode = $this->s_zipcode;

            $shipping->save(); //connect to database
        }

        if($this->paymentmode == 'cod'){
            $this->makeTransaction($order->id, 'pending');
            $this->resetCart();
            $this->dispatchBrowserEvent('cod_order_success',[
                'message' => 'Pinding Your Order Successfully',
            ]);
            $succ = true;
        }
        else if($this->paymentmode == 'card'){
            $stripe = Stripe::make(env('STRIPE_KEY'));
            try{
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number' => $this->card_no,
                        'exp_month' => $this->exp_month,
                        'exp_year' => $this->exp_year,
                        'cvc' => $this->cvc
                    ]
                    ]);

                    if(!isset($token['id'])){
                        session()->flash('stripe_error','the stripe token was not generated correctly!');
                        $this->thankyou = 0;
                    }

                    $customer = $stripe->customers()->create([
                        'name' => $this->firstname. ' '. $this->lastname,
                        'email' => $this->email,
                        'phone' => $this->mobile,
                        'address' =>  [
                            'line1' => $this->line1,
                            'postal_code' => $this->zipcode,
                            'city' => $this->city,
                            'state' => $this->province,
                            'country' => $this->country
                        ],
                        'shipping' => [
                            'name' => $this->firstname. ' '. $this->lastname,
                            'address' =>  [
                                'line1' => $this->line1,
                                'postal_code' => $this->zipcode,
                                'city' => $this->city,
                                'state' => $this->province,
                                'country' => $this->country
                            ],
                        ],
                        'source' => $token['id']
                        ]);

                        $charge = $stripe->charges()->create([
                            'customer' => $customer['id'],
                            'currency' => 'CHF',
                            'amount' => session()->get('checkout')['total'],
                            'description' => 'Payment for order no: '. $order->id
                        ]);

                        if($charge['status'] == 'succeeded'){
                            $this->makeTransaction($order->id, 'approved');
                            $this->resetCart();
                            $this->dispatchBrowserEvent('stripe_order_success',[
                                'message' => 'Approved Your Order Successfully',
                            ]);
                            $succ = true;
                        }
                        else {
                            $order->delete(); // undo
                            session()->flash('stripe_error', "Error in Transaction!");
                            $this->dispatchBrowserEvent('stripe_order_faild',[
                                'message' => 'Faild! Error in Transaction',
                            ]);
                            $this->thankyou = 0;
                        }
            }catch(Exception $e){
                $order->delete(); // undo
                session()->flash('stripe_error', $e->getMessage());
                $this->dispatchBrowserEvent('stripe_order_faild',[
                    'message' => 'Faild! Something wrong',
                ]);
                $this->thankyou = 0;
            }
        }

        if($succ == true){
            $this->sendOrderComfirmationMail($order);
        }

    }

    public function resetCart(){
        $this->thankyou = 1;
        Cart::instance('cart')->destroy();
        session()->forget('checkout'); 
    }

    public function makeTransaction($order_id, $status){
        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->order_id = $order_id;
        $transaction->mode = $this->paymentmode;
        $transaction->status = $status;
        $transaction->save();
    }

    public function sendOrderComfirmationMail($order){
        Mail::to($order->email)->send(new OrderMail($order));
        $this->dispatchBrowserEvent('mail_sent_success',[
            'message' => 'check your email',
        ]);
    }

    public function verifyForCheckout(){
        if(!Auth::check()){
            return redirect()->route('login');
        }
        else if($this->thankyou){
            return redirect()->route('thankyou');
        }
        else if(!session()->get('checkout')){
            return redirect()->route('product.cart');
        }
    }

    public function render()
    {
        $this->verifyForCheckout();
        return view('livewire.checkout-component')->layout("layouts.base");
    }
}
