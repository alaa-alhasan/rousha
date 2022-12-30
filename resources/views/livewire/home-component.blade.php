@section('page-title')
HOME
@endsection
<main id="main">
    <div class="container">

        <!--MAIN SLIDE-->
        <div class="wrap-main-slide">
            <div class="slide-carousel owl-carousel style-nav-1" data-items="1" data-loop="1" data-nav="true" data-dots="false">
                @foreach ($sliders as $slide)
                    <div class="item-slide">
                        <img src="{{asset('assets/images/sliders')}}/{{$slide->image}}" alt="" class="img-slide">
                        {{-- <div class="slide-info slide-1">
                            <h2 class="f-title"><b>{{$slide->title}}</b></h2>
                            <span class="subtitle">{{$slide->subtitle}}</span>
                            <p class="sale-info">
                                @if ($slide->price)
                                Only price: <span class="price">${{$slide->price}}</span>
                                @endif
                            </p>
                            <a href="{{$slide->link}}" class="btn-link">Shop Now</a>
                        </div> --}}
                    </div>
                @endforeach
            </div>
        </div> 

        <!--BANNER-->
        @if($leftBanner && $rightBanner)
            <div class="wrap-banner style-twin-default">

                <div class="banner-item" style="position: relative">
                    <a href="{{$leftBanner->link}}" class="link-banner banner-effect-1">
                        <figure><img src="{{ asset('assets/images/banners') }}/{{$leftBanner->image}}" alt="{{$leftBanner->name}}" width="580" height="190"></figure>
                    </a>
                    <div class="banner-content-wide">
                        <h2>{{$leftBanner->label}}</h2>
                        <p>{!! $leftBanner->description !!}</p>
                        <a href="{{$leftBanner->link}}" class="btn">{{$leftBanner->btntxt}}</a>
                    </div>
                </div>

                <div class="banner-item" style="position: relative">
                    <a href="{{$rightBanner->link}}" class="link-banner banner-effect-1">
                        <figure><img src="{{ asset('assets/images/banners') }}/{{$rightBanner->image}}" alt="{{$rightBanner->name}}" width="580" height="190"></figure>
                    </a>
                    <div class="banner-content-wide">
                        <h2>{{$rightBanner->label}}</h2>
                        <p>{!! $rightBanner->description !!}</p>
                        <a href="{{$rightBanner->link}}" class="btn">{{$rightBanner->btntxt}}</a>
                    </div>
                </div>

            </div>
        @endif

        

        <!--On Sale-->
        @if($sproducts->count() > 0 && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now() )
        <div class="wrap-show-advance-info-box style-1 has-countdown" wire:ignore>
            <h3 class="title-box">On Sale</h3>
            <div class="wrap-countdown mercado-countdown" data-expire="{{Carbon\Carbon::parse($sale->sale_date)->format('Y/m/d h:m:s')}}"></div>
            <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container " data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>

                @foreach ($sproducts as $sproduct)
                <div class="product product-style-2 equal-elem ">
                    <div class="product-thumnail">
                        <a href="{{route('product.detalis',['slug'=>$sproduct->slug])}}" title="{{$sproduct->name}}">
                            <figure><img src=" {{ asset('assets/images/products') }}/{{$sproduct->image}}" width="800" height="800" alt=""></figure>
                        </a>
                        <div class="group-flash">
                            <span class="flash-item sale-label">sale</span>

                            @if (Carbon\Carbon::now()->subMonth() < $sproduct->created_at)
                                <span class="flash-item new-label">new</span>
                            @endif
                        </div>
                        <div class="wrap-btn" style="bottom: auto; top: 5px; right: 5px;">
                            <a class="function-link-view btnQuickView"
                                data-product-name="{{$sproduct->name}}" 
                                data-product-image="{{ asset('assets/images/products') }}/{{$sproduct->image}}" 
                                data-product-desc="{{$sproduct->short_description}}"
                                data-product-price="{{$sproduct->sale_price}} CHF">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                        <div class="wrap-btn">
                            <a href="#" class="function-link" wire:click.prevent="store({{$sproduct->id}},'{{$sproduct->name}}',{{$sproduct->sale_price}})">
                                Add To Cart
                                <span wire:loading wire:target="store({{$sproduct->id}},'{{$sproduct->name}}',{{$sproduct->sale_price}})" style="font-size: 14px; color:#FFFFFF;">
                                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="product-info">
                        <a href="{{route('product.detalis',['slug'=>$sproduct->slug])}}" class="product-name"><span>{{$sproduct->name}}</span></a>
                        <div class="wrap-price"><ins><p class="product-price">{{$sproduct->sale_price}} CHF</p></ins> <del><p class="product-price">{{$sproduct->regular_price}} CHF</p></del></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!--Latest Products-->
        <div class="wrap-show-advance-info-box style-1" wire:ignore>
            <h3 class="title-box">Latest Products</h3>

            @if($lastProductBanner)
                <div class="wrap-top-banner" style="position: relative">
                    <a href="{{$lastProductBanner->link}}" class="link-banner banner-effect-2">
                        <figure><img src="{{ asset('assets/images/banners') }}/{{$lastProductBanner->image}}" alt="{{$lastProductBanner->name}}" width="1170" height="240"></figure>
                    </a>
                    <div class="banner-content">
                        <h2>{{$lastProductBanner->label}}</h2>
                        <p>{!! $lastProductBanner->description !!}</p>
                        <a href="{{$lastProductBanner->link}}" class="btn">{{$lastProductBanner->btntxt}}</a>
                    </div>
                </div>
            @endif

            <div class="wrap-products">
                <div class="wrap-product-tab tab-style-1">						
                    <div class="tab-contents">
                        <div class="tab-content-item active" id="digital_1a">
                            <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}' >
                                @foreach ($lproducts as $lproduct)
                                    <div class="product product-style-2 equal-elem ">
                                        <div class="product-thumnail">
                                            <a href="{{route('product.detalis',['slug'=>$lproduct->slug])}}" title="{{$lproduct->name}}">
                                                <figure><img src="{{asset('assets/images/products')}}/{{$lproduct->image}}" width="800" height="800" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                            </a>

                                            <div class="group-flash">
                                                @if (Carbon\Carbon::now()->subMonth() < $lproduct->created_at)
                                                    <span class="flash-item new-label">new</span>
                                                @endif

                                                @if ($lproduct->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                        <span class="flash-item sale-label">sale</span>
                                                @endif
                                            </div>

                                            <div class="wrap-btn" style="bottom: auto; top: 5px; right: 5px;">
                                                <a class="function-link-view btnQuickView"
                                                    data-product-name="{{$lproduct->name}}" 
                                                    data-product-image="{{ asset('assets/images/products') }}/{{$lproduct->image}}" 
                                                    data-product-desc="{{$lproduct->short_description}}"
                                                    
                                                    @if ($lproduct->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                        data-product-price="{{$lproduct->sale_price}} CHF"
                                                    @else
                                                        data-product-price="{{$lproduct->regular_price}} CHF"
                                                    @endif
                                                    >
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </div>

                                            @if ($lproduct->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                <div class="wrap-btn">
                                                    <a href="#" class="function-link" wire:click.prevent="store({{$lproduct->id}},'{{$lproduct->name}}',{{$lproduct->sale_price}})">
                                                        Add To Cart
                                                        <span wire:loading wire:target="store({{$lproduct->id}},'{{$lproduct->name}}',{{$lproduct->sale_price}})" style="font-size: 14px; color:#FFFFFF;">
                                                            <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            @else
                                                <div class="wrap-btn">
                                                    <a href="#" class="function-link" wire:click.prevent="store({{$lproduct->id}},'{{$lproduct->name}}',{{$lproduct->regular_price}})">
                                                        Add To Cart
                                                        <span wire:loading wire:target="store({{$lproduct->id}},'{{$lproduct->name}}',{{$lproduct->regular_price}})" style="font-size: 14px; color:#FFFFFF;">
                                                            <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            @endif

                                        </div>
                                        <div class="product-info">
                                            <a href="{{route('product.detalis',['slug'=>$lproduct->slug])}}" class="product-name"><span>{{$lproduct->name}}</span></a>

                                            @if ($lproduct->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                <div class="wrap-price"><ins><p class="product-price">{{$lproduct->sale_price}} CHF</p></ins> <del><p class="product-price">{{$lproduct->regular_price}} CHF</p></del></div>
                                            @else
                                                <div class="wrap-price"><span class="product-price">{{ $lproduct->regular_price }} CHF</span></div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>							
                    </div>
                </div>
            </div>
        </div>

        <!--Product Categories-->
        <div class="wrap-show-advance-info-box style-1" wire:ignore>
            <h3 class="title-box">Product Categories</h3>

            @if ($categoryBanner)
                <div class="wrap-top-banner" style="position: relative">
                    <a href="{{$categoryBanner->link}}" class="link-banner banner-effect-2">
                        <figure><img src="{{ asset('assets/images/banners') }}/{{$categoryBanner->image}}" alt="{{$categoryBanner->name}}" width="1170" height="240"></figure>
                    </a>
                    <div class="banner-content">
                        <h2>{{$categoryBanner->label}}</h2>
                        <p>{!! $categoryBanner->description !!}</p>
                        <a href="{{$categoryBanner->link}}" class="btn">{{$categoryBanner->btntxt}}</a>
                    </div>
                </div>
            @endif

            <div class="wrap-products">
                <div class="wrap-product-tab tab-style-1">
                    <div class="tab-control">
                        @foreach ($categories as $key=>$category)
                            <a href="#category_{{$category->id}}" class="tab-control-item {{$key==0 ? 'active':''}}">{{$category->name}}</a>
                        @endforeach
                    </div>
                    <div class="tab-contents">
                        @foreach ($categories as $key=>$category)
                        <div class="tab-content-item {{$key==0 ? 'active':''}}" id="category_{{$category->id}}">
                            <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}' >
                                @php
                                    $c_products = DB::table('products')->where('category_id',$category->id)->get()->take($no_of_products);
                                @endphp
                                @foreach ($c_products as $c_product)
                                    <div class="product product-style-2 equal-elem ">
                                        <div class="product-thumnail">
                                            <a href="{{route('product.detalis',['slug'=>$c_product->slug])}}" title="{{$c_product->name}}">
                                                <figure><img src=" {{ asset('assets/images/products') }}/{{$c_product->image}}" width="800" height="800" alt="{{$c_product->name}}"></figure>
                                            </a>

                                            <div class="group-flash">
                                                @if (Carbon\Carbon::now()->subMonth() < $c_product->created_at)
                                                    <span class="flash-item new-label">new</span>
                                                @endif

                                                @if ($c_product->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                    <span class="flash-item sale-label">sale</span>
                                                @endif
                                            </div>

                                            <div class="wrap-btn" style="bottom: auto; top: 5px; right: 5px;">
                                                <a class="function-link-view btnQuickView"
                                                    data-product-name="{{$c_product->name}}" 
                                                    data-product-image="{{ asset('assets/images/products') }}/{{$c_product->image}}" 
                                                    data-product-desc="{{$c_product->short_description}}"
                                                    
                                                    @if ($c_product->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                        data-product-price="{{$c_product->sale_price}} CHF"
                                                    @else
                                                        data-product-price="{{$c_product->regular_price}} CHF"
                                                    @endif
                                                    >
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </div>
                                            
                                            @if ($c_product->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                <div class="wrap-btn">
                                                    <a href="#" class="function-link" wire:click.prevent="store({{$c_product->id}},'{{$c_product->name}}',{{$c_product->sale_price}})">
                                                        Add To Cart
                                                        <span wire:loading wire:target="store({{$c_product->id}},'{{$c_product->name}}',{{$c_product->sale_price}})" style="font-size: 14px; color:#FFFFFF;">
                                                            <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            @else
                                                <div class="wrap-btn">
                                                    <a href="#" class="function-link" wire:click.prevent="store({{$c_product->id}},'{{$c_product->name}}',{{$c_product->regular_price}})">
                                                        Add To Cart
                                                        <span wire:loading wire:target="store({{$c_product->id}},'{{$c_product->name}}',{{$c_product->regular_price}})" style="font-size: 14px; color:#FFFFFF;">
                                                            <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product-info">
                                            <a href="{{route('product.detalis',['slug'=>$c_product->slug])}}" class="product-name"><span>{{$c_product->name}}</span></a>
                                            
                                            @if ($c_product->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                <div class="wrap-price"><ins><p class="product-price">{{$c_product->sale_price}} CHF</p></ins> <del><p class="product-price">{{$c_product->regular_price}} CHF</p></del></div>
                                            @else
                                                <div class="wrap-price"><span class="product-price">{{ $c_product->regular_price }} CHF</span></div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>





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


<script>
    window.addEventListener('add_to_cart_success', event => {
        toastr.success(event.detail.message)
    });
</script>


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