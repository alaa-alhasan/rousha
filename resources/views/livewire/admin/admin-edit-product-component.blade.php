@section('page-title')
Edit Product
@endsection
<div>
    <div class="container" style="padding: 30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Edit Product
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('admin.products')}}" class="btn btn-success pull-right">All Products</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel body">
                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                        @endif
                        <form class="form-horizontal" enctype="multipart/form-data" wire:submit.prevent="updateProduct">
                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Product Name</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="product name" class="form-control input-md" wire:model="name" wire:keyup="generateSlug">
                                    @error('name') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Product Slug</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="product slug" class="form-control input-md" wire:model="slug">
                                    @error('slug') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Short Description</label>
                                <div class="col-md-4" wire:ignore>
                                    <textarea class="form-control" id="short_description" placeholder="short description" wire:model="short_description"></textarea>
                                    @error('short_description') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Description</label>
                                <div class="col-md-4" wire:ignore>
                                    <textarea class="form-control" id="description" placeholder="description" wire:model="description"></textarea>
                                    @error('description') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Regular Price</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Regular Price" class="form-control input-md" wire:model="regular_price">
                                    @error('regular_price') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Sale Price</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Sale Price" class="form-control input-md" wire:model="sale_price">
                                    @error('sale_price') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">SKU</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="SKU" class="form-control input-md" wire:model="SKU">
                                    @error('SKU') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Stock Status</label>
                                <div class="col-md-4">
                                    <select class="form-control" wire:model="stock_status">
                                        <option value="instock">in Stock</option>
                                        <option value="outofstock">Out Of Stock</option>
                                    </select>
                                    @error('stock_status') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Featured</label>
                                <div class="col-md-4">
                                    <select class="form-control" wire:model="featured">
                                        <option value="0">No</option>
                                        <option value="1">YES</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Quantity</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Quantity" class="form-control input-md" wire:model="quantity">
                                    @error('quantity') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Product Image</label>
                                <div class="col-md-4">
                                    <input type="file" class="input-file" wire:model="newimage">
                                    @if($newimage)
                                        <img src="{{$newimage->temporaryUrl()}}" width="120">
                                    @else
                                        <img src="{{asset('assets/images/products')}}/{{$image}}" width="120">
                                    @endif
                                    @error('newimage') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Product Gallery</label>
                                <div class="col-md-4">
                                    <input type="file" class="input-file" wire:model="newimages" multiple>
                                    @if($newimages)
                                       @foreach($newimages as $newimage)
                                       @if($newimage)
                                        <img src="{{$newimage->temporaryUrl()}}" width="120">
                                       @endif
                                       @endforeach
                                    @else
                                        @foreach($images as $image)
                                        @if($image)
                                            <img src="{{asset('assets/images/products')}}/{{$image}}" width="120">
                                        @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Category</label>
                                <div class="col-md-4">
                                    <select class="form-control" wire:model="category_id" wire:change="changeSubcategory">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Sub Category</label>
                                <div class="col-md-4">
                                    <select class="form-control" wire:model="scategory_id">
                                        <option value="0">Select Category</option>
                                        @foreach ($scategories as $scategory)
                                            <option value="{{$scategory->id}}">{{$scategory->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('scategory_id') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Product Attributes</label>
                                <div class="col-md-3">
                                    <select class="form-control" wire:model="attr">
                                        <option value="0">Select Attribute</option>
                                        @foreach ($pattributes as $pattribute)
                                            <option value="{{$pattribute->id}}">{{$pattribute->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-info" wire:click.prevent="add">Add</button>
                                </div>
                            </div>

                            @foreach ($inputs as $key=>$value)
                                <div class="form-group">
                                    <label for="" class="col-md-4 control-label">{{$pattributes->where('id',$attribute_arr[$key])->first()->name}}</label>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{$pattributes->where('id',$attribute_arr[$key])->first()->name}}" class="form-control input-md" wire:model="attribute_values.{{$value}}">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm" wire:click.prevent="remove({{$key}}, {{$value}})">Remove</button>
                                    </div>
                                </div>

                                @if ($pattributes->where('id',$attribute_arr[$key])->first()->name == 'Color')
                                    <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Help To Choose</label>
                                        <div class="col-md-3">
                                            <div class="c-color-swatch">
                                                <label class="c-color-swatch__item" style="background: red" wire:click.prevent="attributeHelper('red',{{$value}})"></label>
                                                <label class="c-color-swatch__item" style="background: green" wire:click.prevent="attributeHelper('green',{{$value}})"></label>
                                                <label class="c-color-swatch__item" style="background: blue" wire:click.prevent="attributeHelper('blue',{{$value}})"></label>
                                                <label class="c-color-swatch__item" style="background: black" wire:click.prevent="attributeHelper('black',{{$value}})"></label>
                                                <label class="c-color-swatch__item" style="background: brown" wire:click.prevent="attributeHelper('brown',{{$value}})"></label>
                                                <label class="c-color-swatch__item" style="background: pink" wire:click.prevent="attributeHelper('pink',{{$value}})"></label>
                                                <label class="c-color-swatch__item" style="background: gold" wire:click.prevent="attributeHelper('gold',{{$value}})"></label>
                                                <label class="c-color-swatch__item" style="background: purple" wire:click.prevent="attributeHelper('purple',{{$value}})"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-info btn-sm" wire:click.prevent="clearHelper({{$value}})">Clear</button>
                                        </div>
                                    </div>
                                @endif

                                @if ($pattributes->where('id',$attribute_arr[$key])->first()->name == 'Size')
                                    <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Help To Choose</label>
                                        <div class="col-md-3">
                                            <div class="c-color-swatch">
                                                <label class="c-color-swatch__item" wire:click.prevent="attributeHelper('XXS',{{$value}})">XXS</label>
                                                <label class="c-color-swatch__item" wire:click.prevent="attributeHelper('XS',{{$value}})">XS</label>
                                                <label class="c-color-swatch__item" wire:click.prevent="attributeHelper('S',{{$value}})">S</label>
                                                <label class="c-color-swatch__item" wire:click.prevent="attributeHelper('M',{{$value}})">M</label>
                                                <label class="c-color-swatch__item" wire:click.prevent="attributeHelper('L',{{$value}})">L</label>
                                                <label class="c-color-swatch__item" wire:click.prevent="attributeHelper('XL',{{$value}})">XL</label>
                                                <label class="c-color-swatch__item" wire:click.prevent="attributeHelper('XXL',{{$value}})">XXL</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-info btn-sm"  wire:click.prevent="clearHelper({{$value}})">Clear</button>
                                        </div>
                                    </div>
                                @endif

                            @endforeach

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label"></label>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('update_product_success', event => {
        toastr.success(event.detail.message)
    });
</script>

@push('scripts')
    <script>
        $(function(){
            tinymce.init({
                selector: '#short_description',
                setup: function(editor){
                    editor.on('Change',function(e){
                        tinyMCE.triggerSave();
                        var sd_data = $('#short_description').val();
                        @this.set('short_description',sd_data);
                    });
                }
            });

            tinymce.init({
                selector: '#description',
                setup: function(editor){
                    editor.on('Change',function(e){
                        tinyMCE.triggerSave();
                        var d_data = $('#description').val();
                        @this.set('description',d_data);
                    });
                }
            });
        });
    </script>
@endpush