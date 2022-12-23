@section('page-title')
Product Details
@endsection
<main id="main" class="main-site">

    <style>
        .regprice {
            font-weight: 300;
            font-size: 13px !important;
            color: #aaaaaa !important;
            text-decoration: line-through;
            padding-left: 10px;
        }
    </style>

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="/" class="link">home</a></li>
                <li class="item-link"><span>details</span></li>
            </ul>
        </div>
        <div class="row">

            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">
                <div class="wrap-product-detail">
                    <div class="detail-media">
                        <div class="product-gallery" wire:ignore>
                            <ul class="slides">

                                <li data-thumb="{{ asset('assets/images/products') }}/{{ $product->image }}">
                                    <img src="{{ asset('assets/images/products') }}/{{ $product->image }}" data-magnify-src="{{ asset('assets/images/products') }}/{{ $product->image }}" class="zoom" alt="{{ $product->name }}" />
                                </li>
                                @php
                                    $images = explode("," , $product->images);
                                @endphp

                                @foreach ($images as $img)
                                    @if($img)
                                        <li data-thumb="{{ asset('assets/images/products') }}/{{ $img }}">
                                            <img src="{{ asset('assets/images/products') }}/{{ $img }}" data-magnify-src="{{ asset('assets/images/products') }}/{{ $img }}" class="zoom" alt="{{ $product->name }}" />
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="detail-info">
                        <div class="product-rating">
                            <style>
                                .color-gray{
                                    color: #e6e6e6 !important;
                                }
                            </style>
                            @php
                                $avgrating = 0;   
                            @endphp
                            @foreach($product->orderItems->where('rstatus',1) as $orderItem)
                                @php
                                    $avgrating = $avgrating + $orderItem->review->rating;
                                @endphp
                            @endforeach
                            @for($i=1; $i<=5; $i++)
                                @if($i<=$avgrating)
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-star color-gray" aria-hidden="true"></i>
                                @endif
                            @endfor
                            
                            <a href="#" class="count-review">({{$product->orderItems->where('rstatus',1)->count()}} review)</a>
                        </div>
                        <h2 class="product-name">{{$product->name}}</h2>
                        <div class="short-desc">
                            {!!$product->short_description!!}
                        </div>
                        {{-- <div class="wrap-social">
                            <a class="link-socail" href="#"><img src="{{ asset('assets/images/social-list.png') }}" alt=""></a>
                        </div> --}}
                        @if($product->sale_price > 0 && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now() )
                            <div class="wrap-price">
                                <span class="product-price">${{$product->sale_price}}</span>
                                <del><span class="product-price regprice">${{$product->regular_price}}</span></del>
                            </div>
                        @else
                            <div class="wrap-price"><span class="product-price">${{$product->regular_price}}</span></div>
                        @endif
                        <div class="stock-info in-stock">
                            <p class="availability">Availability: <b>{{$product->stock_status}}</b></p>
                        </div>

                        <div>
                            @foreach ($product->attributeValues->unique('product_attribute_id') as $av)
                                <div class="row" style="margin-top :20px">
                                    <div class="col-xs-2">
                                        <p>{{$av->productAttribute->name}}</p>
                                    </div>
                                    <div class="col-xs 10">
                                        <select class="form-control" style="width:200px" wire:model="satt.{{$av->productAttribute->name}}">
                                            @foreach ($av->productAttribute->attributeValues->where('product_id',$product->id) as $pav)
                                                <option value="{{$pav->value}}">{{$pav->value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="quantity" style="margin-top: 10px;">
                            <span>Quantity:</span>
                            <div class="quantity-input">
                                <input type="text" name="product-quatity" value="1" data-max="120" pattern="[0-9]*" wire:model="qty">
                                
                                <a class="btn btn-reduce" href="#" wire:click.prevent="decreaseQuantity"></a>
                                <a class="btn btn-increase" href="#" wire:click.prevent="increaseQuantity"></a>
                            </div>
                        </div>
                        <div class="wrap-butons">
                            @if($product->sale_price > 0 && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now() )
                                <a href="#" class="btn add-to-cart" wire:click.prevent="store({{$product->id}},'{{$product->name}}',{{$product->sale_price}})">
                                    Add to Cart
                                    <span wire:loading wire:target="store({{$product->id}},'{{$product->name}}',{{$product->sale_price}})" style="font-size: 14px; color:#FFFFFF;">
                                        <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                    </span>
                                </a>
                            @else
                                <a href="#" class="btn add-to-cart" wire:click.prevent="store({{$product->id}},'{{$product->name}}',{{$product->regular_price}})">
                                    Add to Cart
                                    <span wire:loading wire:target="store({{$product->id}},'{{$product->name}}',{{$product->regular_price}})" style="font-size: 14px; color:#FFFFFF;">
                                        <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                    </span>
                                </a>
                            @endif

                            <div class="wrap-btn">
                                @php
                                    $witems = Cart::instance('wishlist')->content()->pluck('id');
                                @endphp

                                @if ($witems->contains($product->id))
                                    <a href="#" class="btn btn-wishlist" wire:click.prevent="removeFromWishlist({{$product->id}})">Remove From Wishlist</a>
                                @else
                                    
                                    @if ($product->sale_price > 0 && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                        <a href="#" class="btn btn-wishlist" wire:click.prevent="addToWishlist({{$product->id}},'{{$product->name}}',{{$product->sale_price}})">Add Wishlist</a>
                                    @else
                                        <a href="#" class="btn btn-wishlist" wire:click.prevent="addToWishlist({{$product->id}},'{{$product->name}}',{{$product->regular_price}})">Add Wishlist</a>
                                    @endif

                                @endif
                                
                            </div>
                        </div>
                    </div>
                    <div class="advance-info">
                        <div class="tab-control normal">
                            <a href="#description" class="tab-control-item active">description</a>
                            <a href="#add_infomation" class="tab-control-item">Addtional Infomation</a>
                            <a href="#review" class="tab-control-item">Reviews</a>
                        </div>
                        <div class="tab-contents">
                            <div class="tab-content-item active" id="description">
                                {!!$product->description!!}
                            </div>
                            
                            <div class="tab-content-item " id="add_infomation">
                                <table class="shop_attributes">
                                    <tbody>
                                        @foreach ($product->attributeValues->unique('product_attribute_id') as $av)
                                            
                                        <tr>
                                            <th>{{$av->productAttribute->name}}</th>
                                            <td class="product_weight">
                                                @foreach ($av->productAttribute->attributeValues->where('product_id',$product->id) as $pav)
                                                    {{$pav->value." "}}
                                                @endforeach
                                            </td>
                                        </tr>
                                            
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-content-item " id="review">
                                
                                <div class="wrap-review-form">
                                    <style>
                                        .width-0-percent{
                                            width: 0%;
                                        }
                                        .width-20-percent{
                                            width: 20%;
                                        }
                                        .width-40-percent{
                                            width: 40%;
                                        }
                                        .width-60-percent{
                                            width: 60%;
                                        }
                                        .width-80-percent{
                                            width: 80%;
                                        }
                                        .width-100-percent{
                                            width: 100%;
                                        }
                                    </style>
                                    
                                    <div id="comments">
                                        <h2 class="woocommerce-Reviews-title">{{$product->orderItems->where('rstatus',1)->count()}} review for <span>{{$product->name}}</span></h2>
                                        <ol class="commentlist">
                                            @foreach($product->orderItems->where('rstatus',1) as $orderItem)
                                            <li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1" id="li-comment-20">
                                                <div id="comment-20" class="comment_container"> 
                                                    <img alt="{{$orderItem->order->user->name}}" src="{{asset('assets/images/profile')}}/{{$orderItem->order->user->profile->image}}" height="80" width="80">
                                                    <div class="comment-text">
                                                        <div class="star-rating">
                                                            <span class="width-{{$orderItem->review->rating * 20}}-percent">Rated <strong class="rating">{{$orderItem->review->rating}}</strong> out of 5</span>
                                                        </div>
                                                        <p class="meta"> 
                                                            <strong class="woocommerce-review__author">{{$orderItem->order->user->name}}</strong> 
                                                            <span class="woocommerce-review__dash">–</span>
                                                            <time class="woocommerce-review__published-date" datetime="2008-02-14 20:00" >{{Carbon\Carbon::parse($orderItem->review->created_at)->format('d F Y g:i A')}}</time>
                                                        </p>
                                                        <div class="description">
                                                            <p>{{$orderItem->review->comment}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ol>
                                    </div><!-- #comments -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end main products area-->

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                
                <div class="widget mercado-widget filter-widget">
                    
                    <div class="widget-content">
                        <div class="widget-banner">
                            we have what you want
                            <video width="270" height=auto autoplay muted loop>
                                <source src="{{asset('assets/images/videos/4.mp4')}}" type="video/mp4">
                            </video>
                            
                        </div>
                    </div>
                </div>

                <div class="widget mercado-widget widget-product">
                    <h2 class="widget-title">Popular Products</h2>
                    <div class="widget-content">
                        <ul class="products">
                            @foreach ($popular_products as $p_product)                             
                                <li class="product-item">
                                <div class="product product-widget-style">
                                    <div class="thumbnnail">
                                        <a href="{{ route('product.detalis',['slug'=>$p_product->slug]) }}" title="{{ $p_product->name }}">
                                            <figure><img src="{{ asset('assets/images/products') }}/{{$p_product->image}}" alt="{{ $p_product->name }}"></figure>
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <a href="{{ route('product.detalis',['slug'=>$p_product->slug]) }}" class="product-name"><span>{{ $p_product->name }}</span></a>
                                        <div class="wrap-price"><span class="product-price">${{ $p_product->regular_price }}</span></div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div><!--end sitebar-->

            <div class="single-advance-box col-lg-12 col-md-12 col-sm-12 col-xs-12" wire:ignore>
                <div class="wrap-show-advance-info-box style-1 box-in-site">
                    <h3 class="title-box">Related Products</h3>
                    <div class="wrap-products">
                        <div class="products slide-carousel owl-carousel style-nav-1 equal-container" data-items="{{$related_products->count()}}" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"3"},"1200":{"items":"5"}}' >
                            @foreach ($related_products as $r_product)
                            <div class="product product-style-2 equal-elem ">
                                <div class="product-thumnail">
                                    <a href="{{ route('product.detalis',['slug'=>$r_product->slug]) }}" title="{{$r_product->name}}">
                                        <figure><img src="{{ asset('assets/images/products') }}/{{$r_product->image}}" width="214" height="214" alt="{{$r_product->name}}"></figure>
                                    </a>
                                    <div class="group-flash">

                                        @if (Carbon\Carbon::now()->subMonth() < $r_product->created_at)
                                            <span class="flash-item new-label">new</span>
                                        @endif

                                        @if ($r_product->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                <span class="flash-item sale-label">sale</span>
                                        @endif

                                    </div>

                                    <div class="wrap-btn" style="bottom: auto; top: 5px; right: 5px;">
                                        <a class="function-link-view btnQuickView"
                                            data-product-name="{{$r_product->name}}" 
                                            data-product-image="{{ asset('assets/images/products') }}/{{$r_product->image}}" 
                                            data-product-desc="{{$r_product->short_description}}"
                                            
                                            @if ($r_product->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                data-product-price="${{$r_product->sale_price}}"
                                            @else
                                                data-product-price="${{$r_product->regular_price}}"
                                            @endif
                                            >
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>

                                    @if ($r_product->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                        <div class="wrap-btn">
                                            <a href="#" class="function-link" wire:click.prevent="store({{$r_product->id}},'{{$r_product->name}}',{{$r_product->sale_price}})">
                                                Add To Cart
                                                <span wire:loading wire:target="store({{$r_product->id}},'{{$r_product->name}}',{{$r_product->sale_price}})" style="font-size: 14px; color:#FFFFFF;">
                                                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                                </span>
                                            </a>
                                        </div>
                                    @else
                                        <div class="wrap-btn">
                                            <a href="#" class="function-link" wire:click.prevent="store({{$r_product->id}},'{{$r_product->name}}',{{$r_product->regular_price}})">
                                                Add To Cart
                                                <span wire:loading wire:target="store({{$r_product->id}},'{{$r_product->name}}',{{$r_product->regular_price}})" style="font-size: 14px; color:#FFFFFF;">
                                                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                                </span>
                                            </a>
                                        </div>
                                    @endif

                                </div>
                                <div class="product-info">
                                    <a href="{{ route('product.detalis',['slug'=>$r_product->slug]) }}" class="product-name"><span>{{$r_product->name}}</span></a>
                                    @if ($r_product->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                        <div class="wrap-price"><ins><p class="product-price">${{$r_product->sale_price}}</p></ins> <del><p class="product-price">${{$r_product->regular_price}}</p></del></div>
                                    @else
                                        <div class="wrap-price"><span class="product-price">${{ $r_product->regular_price }}</span></div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div><!--End wrap-products-->
                </div>
            </div>

        </div><!--end row-->

    </div><!--end container-->

</main>

<script>
    window.addEventListener('add_to_cart_success', event => {
        toastr.info(event.detail.message)
    });
    window.addEventListener('add_to_wishlist_success', event => {
        toastr.success(event.detail.message)
    });
    window.addEventListener('remove_from_wishlist_success', event => {
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
    $(document).ready(function() {
        $('.zoom').magnify();
    });
</script>
@endpush