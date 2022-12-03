<main id="main" class="main-site left-sidebar">

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="/" class="link">home</a></li>
                <li class="item-link"><span>Product Categories</span></li>
                <li class="item-link"><span>{{$category_name}}</span></li>
            </ul>
        </div>
        <div class="row">

            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">

                @if ($shopBanner)
                    <div class="banner-shop" style="position: relative">
                        <a href="{{$shopBanner->link}}" class="banner-link">
                            <figure><img src="{{ asset('assets/images/banners') }}/{{$shopBanner->image}}" alt="{{$shopBanner->name}}"></figure>
                        </a>
                        <div class="banner-content">
                            <h2>{{$shopBanner->label}}</h2>
                            <p>{!! $shopBanner->description !!}</p>
                            <a href="{{$shopBanner->link}}" class="btn">{{$shopBanner->btntxt}}</a>
                        </div>
                    </div>
                @endif

                <div class="wrap-shop-control">

                    <h1 class="shop-title">{{$category_name}}: Filter Results <span style="color: #000000">({{$products->count()}})</h1>

                    <div class="wrap-right">

                        <div class="sort-item orderby ">
                            <select name="orderby" class="use-chosen" wire:model="sorting">
                                <option value="default" selected="selected">Default sorting</option>
                                <option value="date">Sort by newness</option>
                                <option value="price">Sort by price: low to high</option>
                                <option value="price-desc">Sort by price: high to low</option>
                            </select>
                        </div>

                        <div class="sort-item product-per-page">
                            <select name="post-per-page" class="use-chosen" wire:model="pagesize">
                                <option value="12" selected="selected">12 per page</option>
                                <option value="16">16 per page</option>
                                <option value="18">18 per page</option>
                                <option value="21">21 per page</option>
                                <option value="24">24 per page</option>
                                <option value="30">30 per page</option>
                                <option value="32">32 per page</option>
                            </select>
                        </div>

                        <div class="change-display-mode" wire:ignore>
                            <a href="#" id="dis-grid" class="grid-mode display-mode active" wire:click.prevent="changeDisplayMode('grid')"
                                onclick="document.getElementById('dis-list').classList.remove('active');document.getElementById('dis-grid').classList.add('active');">
                                <i class="fa fa-th"></i>Grid
                            </a>
                            <a href="#" id="dis-list" class="list-mode display-mode" wire:click.prevent="changeDisplayMode('list')"
                                onclick="document.getElementById('dis-grid').classList.remove('active');document.getElementById('dis-list').classList.add('active');">
                                <i class="fa fa-th-list"></i>List
                            </a>
                        </div>

                    </div>

                </div><!--end wrap shop control-->

                

                @if ($dismode == 'grid')
                    <div class="row"> <!-- grid-display-mode -->
                        <ul class="product-list grid-products equal-container">
                            @php
                                $witems = Cart::instance('wishlist')->content()->pluck('id');
                            @endphp
                            @foreach ($products as $product)
                            <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
                                <div class="product product-style-3 equal-elem ">
                                    <div class="product-thumnail">
                                        <a href="{{ route('product.detalis',['slug'=>$product->slug]) }}" title="{{ $product->name }}">
                                            <figure><img src="{{ asset('assets/images/products') }}/{{$product->image}}" alt="{{ $product->name }}"></figure>
                                        </a>
                                    </div>
                                    
                                    <div class="product-info">
                                        <a href="{{ route('product.detalis',['slug'=>$product->slug]) }}" class="product-name"><span>{{ $product->name }}</span></a>

                                        @if ($product->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                            <div class="wrap-price"><ins><p class="product-price">${{$product->sale_price}}</p></ins> <del><p class="product-price">${{$product->regular_price}}</p></del></div>
                                            <a href="#" class="btn add-to-cart" wire:click.prevent="store({{$product->id}},'{{$product->name}}',{{$product->sale_price}})">
                                                Add To Cart
                                                <span wire:loading wire:target="store({{$product->id}},'{{$product->name}}',{{$product->sale_price}})" style="font-size: 14px; color:#FFFFFF;">
                                                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                                </span>
                                            </a>
                                        @else
                                            <div class="wrap-price"><span class="product-price">${{ $product->regular_price }}</span></div>
                                            <a href="#" class="btn add-to-cart" wire:click.prevent="store({{$product->id}},'{{$product->name}}',{{$product->regular_price}})">
                                                Add To Cart
                                                <span wire:loading wire:target="store({{$product->id}},'{{$product->name}}',{{$product->regular_price}})" style="font-size: 14px; color:#FFFFFF;">
                                                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                                </span>
                                            </a>
                                        @endif

                                        
                                        
                                        <div class="product-wish">
                                            @if($witems->contains($product->id))
                                                <a href="#" wire:click.prevent="removeFromWishlist({{$product->id}})" class="add-to-wish-link"><i class="fa fa-heart"></i></a>
                                            @else
                                                
                                                @if ($product->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                    <a href="#" wire:click.prevent="addToWishlist({{$product->id}},'{{$product->name}}',{{$product->sale_price}})" class="add-to-wish-link"><i class="fa fa-heart-o"></i></a>
                                                @else
                                                    <a href="#" wire:click.prevent="addToWishlist({{$product->id}},'{{$product->name}}',{{$product->regular_price}})" class="add-to-wish-link"><i class="fa fa-heart-o"></i></a>
                                                @endif
                                                
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="row" style="margin-top: 20px"> <!-- list-display-mode -->

                        @php
                            $witems = Cart::instance('wishlist')->content()->pluck('id');
                        @endphp 
                        @foreach ($products as $product)
                            
                            <div class="row product product-style-3 equal-elem" style="display: flex; align-items: center; margin: auto;">
                                <div class="col-md-4">
                                    <div class="product-thumnail">
                                        <a href="{{ route('product.detalis',['slug'=>$product->slug]) }}" title="{{ $product->name }}">
                                            <figure><img src="{{ asset('assets/images/products') }}/{{$product->image}}" alt="{{ $product->name }}"></figure>
                                        </a>
                                        <div class="product-wish">
                                            @if($witems->contains($product->id))
                                                <a href="#" wire:click.prevent="removeFromWishlist({{$product->id}})" class="add-to-wish-link"><i class="fa fa-heart"></i></a>
                                            @else
                                                
                                                @if ($product->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                                    <a href="#" wire:click.prevent="addToWishlist({{$product->id}},'{{$product->name}}',{{$product->sale_price}})" class="add-to-wish-link"><i class="fa fa-heart-o"></i></a>
                                                @else
                                                    <a href="#" wire:click.prevent="addToWishlist({{$product->id}},'{{$product->name}}',{{$product->regular_price}})" class="add-to-wish-link"><i class="fa fa-heart-o"></i></a>
                                                @endif
                                                
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="product-info">
                                        <a href="{{ route('product.detalis',['slug'=>$product->slug]) }}" class="product-name"><span style="font-size: 18px">{{ $product->name }}</span></a>
                    
                                        <p style="margin-top: 15px">{!!$product->short_description!!}</p>
                        
                                        @if ($product->sale_price && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                            <div class="wrap-price"><ins><p class="product-price">${{$product->sale_price}}</p></ins> <del><p class="product-price">${{$product->regular_price}}</p></del></div>
                                            <a href="#" class="btn add-to-cart" wire:click.prevent="store({{$product->id}},'{{$product->name}}',{{$product->sale_price}})" style="max-width: 50%">
                                                Add To Cart
                                                <span wire:loading wire:target="store({{$product->id}},'{{$product->name}}',{{$product->sale_price}})" style="font-size: 14px; color:#FFFFFF;">
                                                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                                </span>
                                            </a>
                                        @else
                                            <div class="wrap-price"><span class="product-price">${{ $product->regular_price }}</span></div>
                                            <a href="#" class="btn add-to-cart" wire:click.prevent="store({{$product->id}},'{{$product->name}}',{{$product->regular_price}})" style="max-width: 50%">
                                                Add To Cart
                                                <span wire:loading wire:target="store({{$product->id}},'{{$product->name}}',{{$product->regular_price}})" style="font-size: 14px; color:#FFFFFF;">
                                                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                                </span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                    
                        @endforeach
                    
                    </div>
                @endif

                @if ($products->items() == [])
                    <figure style="text-align: center"><img src="{{ asset('assets/images/oops.jpg') }}" alt="oops"><h5>No Reasuls Found!!</h5></figure>
                @endif

                <div class="wrap-pagination-info">
                    {{$products->links()}}
                </div>
            </div><!--end main products area-->

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                <div class="widget mercado-widget categories-widget">
                    <h2 class="widget-title">All Categories</h2>
                    <div class="widget-content">
                        <ul class="list-category">
                            @foreach ($categories as $category)
                                <li class="category-item {{count($category->subCategories) > 0 ? 'has-child-cate':''}}">
                                    <a href="{{route('product.category',['category_slug'=>$category->slug])}}" class="cate-link">{{$category->name}} <span style="color: #365db5">({{DB::table('products')->where('category_id',$category->id)->get()->count()}})</span></a>
                                    @if(count($category->subCategories) > 0)
                                        <span class="toggle-control">+</span>
                                        <ul class="sub-cate">
                                            @foreach ($category->subCategories as $scategory)
                                                <li class="category-item">
                                                    <a href="{{route('product.category',['category_slug'=>$category->slug,'scategory_slug'=>$scategory->slug])}}" class="cat-link"><i class="fa fa-caret-right"></i>{{$scategory->name}} <span style="color: #365db5">({{DB::table('products')->where('subcategory_id',$scategory->id)->get()->count()}})</span></a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div><!-- Categories widget-->

                {{-- <div class="widget mercado-widget filter-widget brand-widget">
                    <h2 class="widget-title">Brand</h2>
                    <div class="widget-content">
                        <ul class="list-style vertical-list list-limited" data-show="6">
                            <li class="list-item"><a class="filter-link active" href="#">Fashion Clothings</a></li>
                            <li class="list-item"><a class="filter-link " href="#">Laptop Batteries</a></li>
                            <li class="list-item"><a class="filter-link " href="#">Printer & Ink</a></li>
                            <li class="list-item"><a class="filter-link " href="#">CPUs & Prosecsors</a></li>
                            <li class="list-item"><a class="filter-link " href="#">Sound & Speaker</a></li>
                            <li class="list-item"><a class="filter-link " href="#">Shop Smartphone & Tablets</a></li>
                            <li class="list-item default-hiden"><a class="filter-link " href="#">Printer & Ink</a></li>
                            <li class="list-item default-hiden"><a class="filter-link " href="#">CPUs & Prosecsors</a></li>
                            <li class="list-item default-hiden"><a class="filter-link " href="#">Sound & Speaker</a></li>
                            <li class="list-item default-hiden"><a class="filter-link " href="#">Shop Smartphone & Tablets</a></li>
                            <li class="list-item"><a data-label='Show less<i class="fa fa-angle-up" aria-hidden="true"></i>' class="btn-control control-show-more" href="#">Show more<i class="fa fa-angle-down" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div><!-- brand widget--> --}}

                

                <div class="widget mercado-widget filter-widget price-filter">
                    <h2 class="widget-title">Price <span class="text-info">${{$min_price}} - ${{$max_price}}</span></h2>
                    <div class="widget-content" style="margin-bottom: 40px">
                        <div id="slider" wire:ignore></div>
                    </div>
                </div><!-- Price-->

                <div class="widget mercado-widget filter-widget">
                    <h2 class="widget-title">Main Attributes</h2>
                    <div class="widget-content" wire:ignore>
                        <ul class="list-style vertical-list has-count-index">
                            @foreach ($pattributes as $pattribute)
                                <li class="list-item">
                                    <a class="filter-link " id="attrFilterLink{{$pattribute->id}}" href="#" wire:click.prevent="addAttrFilter({{$pattribute->id}})"
                                        onclick="document.getElementById('attrFilterLink{{$pattribute->id}}').classList.toggle('active');">
                                        {{$pattribute->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div><!-- Color -->

                <div class="widget mercado-widget filter-widget" wire:ignore>
                    <h2 class="widget-title">Colors</h2>
                    <div class="widget-content">
                        <ul class="list-style inline-round ">
                            @foreach ($allColorsUsed as $colorUsed)
                                <li><a style="background-color: {{$colorUsed}}; border-radius:0;" href="#"
                                    wire:click.prevent="selectColor('{{$colorUsed}}')">{{$colorUsed}}</a>
                                </li>
                            @endforeach
                            
                        </ul>
                    </div>
                </div><!-- Color Details -->

                <div class="widget mercado-widget filter-widget">
                    <h2 class="widget-title">Size</h2>
                    <div class="widget-content">
                        <ul class="list-style inline-round ">
                            @foreach ($allSizesUsed as $sizeUsed)
                                <li><a href="#" wire:click.prevent="selectSize({{$sizeUsed}})">{{$sizeUsed}}</a></li>
                            @endforeach
                            
                        </ul>
                        {{-- <div class="widget-banner">
                            <figure><img src="{{ asset('assets/images/size-banner-widget.jpg') }}" width="270" height="331" alt=""></figure>
                        </div> --}}
                    </div>
                </div><!-- Size -->

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
                </div><!-- brand widget-->

            </div><!--end sitebar-->

        </div><!--end row-->

    </div><!--end container-->

</main>

@push('scripts')
    <script>
        var slider = document.getElementById('slider');
        noUiSlider.create(slider,{
            start: [1,10000],
            connect: true,
            range: {
                'min' : 1,
                'max' : 10000
            },
            pips: {
                mode:'steps',
                stepped: true,
                density: 5
            }
        });

        slider.noUiSlider.on('update',function(value){
            @this.set('min_price',value[0]);
            @this.set('max_price',value[1]);
        });
    </script>
@endpush

<script>
    window.addEventListener('add_to_cart_success', event => {
        toastr.success(event.detail.message)
    });
    window.addEventListener('add_to_wishlist_success', event => {
        toastr.success(event.detail.message)
    });
    window.addEventListener('remove_from_wishlist_success', event => {
        toastr.info(event.detail.message)
    });
</script>