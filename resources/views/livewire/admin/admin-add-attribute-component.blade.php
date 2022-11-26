@section('page-title')
Add Attribute
@endsection
<div>
    <div class="container" style="padding: 30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Add New Attribute
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('admin.attributes')}}" class="btn btn-success pull-right">All Attribute</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

                        @if (!$colorAttr)
                            <div class="alert alert-warning alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>warning!</strong> You Shoud Add <strong>Color</strong> Attribute.
                            </div>
                        @endif

                        @if (!$sizeAttr)
                            <div class="alert alert-warning alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>warning!</strong> You Shoud Add <strong>Size</strong> Attribute.
                            </div>
                        @endif

                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                        @endif
                        <form class="form-horizontal" action="" wire:submit.prevent="storeAttribute">
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="">Attribute Name</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Attribute Name" class="form-control input-md" wire:model="name">
                                    @error('name') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-md-4 control-label" for=""></label>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
