@section('page-title')
Cart
@endsection
<main id="main" class="main-site">

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="/" class="link">home</a></li>
                <li class="item-link"><span>Cart</span></li>
            </ul>
        </div>
        <div class=" main-content-area">
            @if(Session::has('success_message'))
                <div class="alert alert-success">
                    <strong>Success </strong>{{Session::get('success_message')}}
                </div>
            @endif
            @if(Cart::instance('cart')->count() > 0)
                <div class="wrap-iten-in-cart">
                    
                    @if (Cart::instance('cart')->count() > 0)
                    <h3 class="box-title">Products Name</h3>
                    <ul class="products-cart">
                        @foreach (Cart::instance('cart')->content() as $item)
                        <li class="pr-cart-item">
                            <div class="product-image">
                                <figure><img src="{{ asset('assets/images/products') }}/{{$item->model->image}}" alt="{{$item->model->name}}"></figure>
                            </div>
                            <div class="product-name">
                                <a class="link-to-product" href="{{ route('product.detalis',['slug'=>$item->model->slug]) }}">{{$item->model->name}}</a>
                            </div>

                            @foreach($item->options as $key=>$value)
                                <div style="vertical-align: middle; width: 180px">
                                    <p><b>{{$key}} : {{$value}}</b></p>
                                </div>
                            @endforeach

                            @if ($item->model->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                <div class="price-field produtc-price"><p class="price">${{$item->model->sale_price}}</p></div>
                            @else
                                <div class="price-field produtc-price"><p class="price">${{$item->model->regular_price}}</p></div>
                            @endif

                            <div class="quantity">
                                <div class="quantity-input">
                                    <input type="text" name="product-quatity" value="{{$item->qty}}" data-max="120" pattern="[0-9]*" >									
                                    <a class="btn btn-increase" href="#" wire:click.prevent="increaseQuantity('{{$item->rowId}}')"></a>
                                    <a class="btn btn-reduce" href="#" wire:click.prevent="decreaseQuantity('{{$item->rowId}}')"></a>
                                </div>
                                <p class="text-center"><a href="#" wire:click.prevent="switchToSaveForLater('{{$item->rowId}}')">Save For Later</a></p>
                            </div>
                            <div class="price-field sub-total"><p class="price">${{$item->subtotal}}</p></div>
                            <div class="delete">
                                <a href="#" wire:click.prevent="destroy('{{$item->rowId}}')" class="btn btn-delete" title="">
                                    <span>Delete from your cart</span>
                                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                                </a>
                            </div>
                        </li>
                        @endforeach										
                    </ul>
                </div>
            @else
                <div>
                    <p>No Items In Cart</p>
                </div>
            @endif

            <div class="summary">
                <div class="order-summary">
                    <h4 class="title-box">Order Summary</h4>
                    <p class="summary-info"><span class="title">Subtotal</span><b class="index">${{Cart::instance('cart')->subtotal()}}</b></p>
                    @if(Session::has('coupon'))
                        <p class="summary-info"><span class="title">Discount ({{Session::get('coupon')['code']}}) <a href="#" wire:click.prevent="revoveCoupon"><i class="fa fa-times text-danger"></i></a></span><b class="index"> -${{number_format($discount,2)}}</b></p>
                        <p class="summary-info"><span class="title">Subtotal With Discount</span><b class="index">${{number_format($subtotalAfterDiscount,2)}}</b></p>
                        <p class="summary-info"><span class="title">Tax ({{config('cart.tax')}}%)</span><b class="index">${{number_format($taxAfterDiscount,2)}}</b></p>
                        <p class="summary-info total-info "><span class="title">Total</span><b class="index">${{number_format($totalAfterDiscount,2)}}</b></p>
                    @else
                        <p class="summary-info"><span class="title">Tax</span><b class="index">${{Cart::instance('cart')->tax()}}</b></p>
                        <p class="summary-info"><span class="title">Shipping</span><b class="index">Free Shipping</b></p>
                        <p class="summary-info total-info "><span class="title">Total</span><b class="index">${{Cart::instance('cart')->total()}}</b></p>
                    @endif
                    
                </div>
                <div class="checkout-info">
                    @if(!Session::has('coupon'))
                        <label class="checkbox-field">
                            <input class="frm-input " name="have-code" id="have-code" value="1" type="checkbox" wire:model="haveCouponCode"><span>I have coupon code</span>
                        </label>
                        @if($haveCouponCode == 1)
                            <div class="summary-item">
                                <form wire:click.prevent="applyCouponCode">
                                    <h4 class="title-box">Coupon Code</h4>
                                    @if(Session::has('coupon_message'))
                                        <div class="alert alert-danger" role="danger">{{Session::get('coupon_message')}}</div>
                                    @endif
                                    <p class="row-in-form">
                                        <label for="coupon-code">Enter Your coupon code</label>
                                        <input type="text" name="coupon-code" wire:model="couponCode">
                                    </p>
                                    <button type="submit" class="btn btn-small">Apply</button>
                                </form>
                            </div>
                        @endif
                    @endif
                    <a class="btn btn-checkout" href="#" wire:click.prevent="checkout">Check out</a>
                    <a class="link-to-shop" href="shop.html">Continue Shopping<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                </div>
                <div class="update-clear">
                    <a class="btn btn-clear" href="#" wire:click.prevent="destroyAll()">Clear Shopping Cart</a>
                    <a class="btn btn-update" href="#">Update Shopping Cart</a>
                </div>
            </div>
            @else
                <div class="text-center" style="padding: 30px 0;">
                    <h1>Your Cart is empty!</h1>
                    <p>Add Items to it now</p>
                    <a href="/shop" class="btn btn-success">shop now</a>
                </div>
            @endif

            <div class="wrap-iten-in-cart">
                <h3 class="title-box" style="border-bottom: 1px solid; padding-bottom: 15px">{{Cart::instance('saveForLater')->count()}} item(s) Saved For Later</h3>
                @if(Session::has('s_success_message'))
                    <div class="alert alert-success">
                        <strong>Success </strong>{{Session::get('s_success_message')}}
                    </div>
                @endif
                @if (Cart::instance('saveForLater')->count() > 0)
                <h3 class="box-title">Products Name</h3>
                <ul class="products-cart">
                    @foreach (Cart::instance('saveForLater')->content() as $item)
                    <li class="pr-cart-item">
                        <div class="product-image">
                            <figure><img src="{{ asset('assets/images/products') }}/{{$item->model->image}}" alt="{{$item->model->name}}"></figure>
                        </div>
                        <div class="product-name">
                            <a class="link-to-product" href="{{ route('product.detalis',['slug'=>$item->model->slug]) }}">{{$item->model->name}}</a>
                        </div>
                        
                        @if ($item->model->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                            <div class="price-field produtc-price"><p class="price">${{$item->model->sale_price}}</p></div>
                        @else
                            <div class="price-field produtc-price"><p class="price">${{$item->model->regular_price}}</p></div>
                        @endif

                        <div class="quantity">
                            <p class="text-center"><a href="#" wire:click.prevent="moveToCart('{{$item->rowId}}')">Move To Cart</a></p>
                        </div>
                        <div class="delete">
                            <a href="#" wire:click.prevent="deleteFromSaveForLater('{{$item->rowId}}')" class="btn btn-delete" title="">
                                <span>Delete from save for later</span>
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </a>
                        </div>
                    </li>
                    @endforeach										
                </ul>
                @else
                    <p>No Items Saved For Later</p>
                @endif
            </div>

            <div class="wrap-show-advance-info-box style-1 box-in-site" wire:ignore>
                <h3 class="title-box">Most Viewed Products</h3>
                <div class="wrap-products">
                    <div class="products slide-carousel owl-carousel style-nav-1 equal-container" data-items="{{$viewedProducts->count()}}" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"3"},"1200":{"items":"5"}}' >

                        @foreach ($viewedProducts as $vProduct)
                            <div class="product product-style-2 equal-elem ">
                                <div class="product-thumnail">
                                    <a href="{{ route('product.detalis',['slug'=>$vProduct->slug]) }}" title="{{ $vProduct->name }}">
                                        <figure><img src="{{ asset('assets/images/products') }}/{{$vProduct->image}}" width="214" height="214" alt="{{ $vProduct->name }}"></figure>
                                    </a>
                                    <div class="group-flash">

                                        @if (Carbon\Carbon::now()->subMonth() < $vProduct->created_at)
                                            <span class="flash-item new-label">new</span>
                                        @endif

                                        @if ($vProduct->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                <span class="flash-item sale-label">sale</span>
                                        @endif
                                        
                                    </div>

                                    <div class="wrap-btn" style="bottom: auto; top: 5px; right: 5px;">
                                        <a class="function-link-view btnQuickView"
                                            data-product-name="{{$vProduct->name}}" 
                                            data-product-image="{{ asset('assets/images/products') }}/{{$vProduct->image}}" 
                                            data-product-desc="{{$vProduct->short_description}}"
                                            
                                            @if ($vProduct->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                data-product-price="${{$vProduct->sale_price}}"
                                            @else
                                                data-product-price="${{$vProduct->regular_price}}"
                                            @endif
                                            >
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>

                                    @if ($vProduct->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                        <div class="wrap-btn">
                                            <a href="#" class="function-link" wire:click.prevent="store({{$vProduct->id}},'{{$vProduct->name}}',{{$vProduct->sale_price}})">
                                                Add To Cart
                                                <span wire:loading wire:target="store({{$vProduct->id}},'{{$vProduct->name}}',{{$vProduct->sale_price}})" style="font-size: 14px; color:#365db5;">
                                                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                                </span>
                                            </a>
                                        </div>
                                    @else
                                        <div class="wrap-btn">
                                            <a href="#" class="function-link" wire:click.prevent="store({{$vProduct->id}},'{{$vProduct->name}}',{{$vProduct->regular_price}})">
                                                Add To Cart
                                                <span wire:loading wire:target="store({{$vProduct->id}},'{{$vProduct->name}}',{{$vProduct->regular_price}})" style="font-size: 14px; color:#365db5;">
                                                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                                </span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="product-info">
                                    <a href="{{ route('product.detalis',['slug'=>$vProduct->slug]) }}" class="product-name"><span>{{ $vProduct->name }}</span></a>

                                    @if ($vProduct->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                        <div class="wrap-price"><ins><p class="product-price">${{$vProduct->sale_price}}</p></ins> <del><p class="product-price">${{$vProduct->regular_price}}</p></del></div>
                                    @else
                                        <div class="wrap-price"><span class="product-price">${{ $vProduct->regular_price }}</span></div>
                                    @endif
                                    
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div><!--End wrap-products-->
            </div>

        </div><!--end main content area-->
    </div><!--end container-->

</main>

<script>
    window.addEventListener('add_to_cart_success', event => {
        toastr.success(event.detail.message)
    });

    window.addEventListener('empty_cart_success', event => {
        toastr.info(event.detail.message)
    });
</script>


<div class="modal fade" id="quickViewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col text-end">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="main-content-area">
                            <div class="wrap-product-detail">

                                <div class="detail-media">
                                    <img id="modal-product-image">
                                </div>

                                <div class="detail-info">
                                    <div class="product-rating">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <a href="#" class="count-review">(05 review)</a>
                                    </div>
                                    <h2 class="product-name" id="modal-product-name"></h2>
                                    <div class="short-desc">
                                        <ul>
                                            <li id="modal-product-desc"></li>
                                        </ul>
                                    </div>
                                    <div class="wrap-price"><span class="product-price" id="modal-product-price"></span></div>
                                    <div class="stock-info in-stock">
                                        <p class="availability">Availability: <b>In Stock</b></p>
                                    </div>

                                    
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 




@push('scripts')
<script>
    $(function(){
        $('body').on('click','.btnQuickView', function(e){
            e.preventDefault();
            var data = $(this).data();
            $('#quickViewModal #modal-product-name').html(data.productName);
            $('#quickViewModal #modal-product-image').attr('src', data.productImage);
            $('#quickViewModal #modal-product-price').html(data.productPrice);
            $('#quickViewModal #modal-product-desc').html(data.productDesc);

            $('#quickViewModal').modal();
        });
    });
</script>
@endpush