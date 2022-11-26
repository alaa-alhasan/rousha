@section('page-title')
Wishlist
@endsection
<main id="main" class="main-site left-sidebar">
    <div class="container">
        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="/" class="link">home</a></li>
                <li class="item-link"><span>Wishlist</span></li>
            </ul>
        </div>
{{-- 
        <style>
            .product-wish{
                position: absolute;
                top:10%;
                left: 0;
                z-index: 99;
                right: 30px;
                text-align: right;
                padding-top: 0;
            }
            .product-wish .fa{
                color: #cbcbcb;
                font-size: 32px;
            }
            .product-wish .fa:hover{
                color: #ff7007;
            }
            .fill-heart{
                color: #ff7007 !important;
            }
        </style> --}}

        <div class="row">
            @if(Cart::instance('wishlist')->content()->count() > 0)
            <ul class="product-list grid-products equal-container">
                @foreach (Cart::instance('wishlist')->content() as $item)
                <li class="col-lg-3 col-md-6 col-sm-6 col-xs-6 ">
                    <div class="product product-style-3 equal-elem ">
                        <div class="product-thumnail">
                            <a href="{{ route('product.detalis',['slug'=>$item->model->slug]) }}" title="{{ $item->model->name }}">
                                <figure><img src="{{ asset('assets/images/products') }}/{{$item->model->image}}" alt="{{ $item->model->name }}"></figure>
                            </a>
                        </div>
                        <div class="product-info">
                            <a href="{{ route('product.detalis',['slug'=>$item->model->slug]) }}" class="product-name"><span>{{ $item->model->name }}</span></a>

                            @if ($item->model->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                <div class="wrap-price"><ins><p class="product-price">${{$item->model->sale_price}}</p></ins> <del><p class="product-price">${{$item->model->regular_price}}</p></del></div>
                            @else
                                <div class="wrap-price"><span class="product-price">${{ $item->model->regular_price }}</span></div>
                            @endif

                            <a href="#" class="btn add-to-cart" wire:click.prevent="moveProductFromWishlistToCart('{{$item->rowId}}')">
                                Move To Cart
                                <span wire:loading wire:target="moveProductFromWishlistToCart('{{$item->rowId}}')" style="font-size: 14px; color:#365db5;">
                                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                </span>
                            </a>
                            <div class="product-wish">
                                <a href="#" wire:click.prevent="removeFromWishlist({{$item->model->id}})" class="add-to-wish-link"><i class="fa fa-heart"></i></a>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
                <div class="text-center" style="padding: 30px 0;">
                    <h1>Your Wishlist is empty!</h1>
                    <a href="/shop" class="btn btn-success">shop now</a>
                </div>
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
    </div>
</main>

<script>
    window.addEventListener('move_to_cart_success', event => {
        toastr.info(event.detail.message)
    });
    window.addEventListener('add_to_cart_success', event => {
        toastr.success(event.detail.message)
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