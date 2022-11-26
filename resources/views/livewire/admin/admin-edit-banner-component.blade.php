
@section('page-title')
Edit Banner
@endsection
<div>
    <div class="container" style="padding: 30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Edit Banner
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('admin.banner')}}" class="btn btn-success pull-right">All Banners</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel body">
                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                        @endif
                        <form class="form-horizontal" enctype="multipart/form-data" wire:submit.prevent="updateBanner">

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Name</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control input-md" disabled wire:model="name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Label</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Label" class="form-control input-md" wire:model="label">
                                    @error('label') <p class="text-danger">{{$message}}</p> @enderror
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
                                <label for="" class="col-md-4 control-label">Button Text</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Button Text" class="form-control input-md" wire:model="btntxt">
                                    @error('btntxt') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Link</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Link" class="form-control input-md" wire:model="link">
                                    @error('link') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Image</label>
                                <div class="col-md-4">
                                    <input type="file" class="input-file" wire:model="newimage">
                                    @if($newimage)
                                        <img src="{{$newimage->temporaryUrl()}}" width="120">
                                    @else
                                        <img src="{{asset('assets/images/banners')}}/{{$image}}" width="120">
                                    @endif
                                    @error('newimage') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label"></label>
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

@push('scripts')
    <script>
        $(function(){
            tinymce.init({
                selector: '#description',
                setup: function(editor){
                    editor.on('Change',function(e){
                        tinyMCE.triggerSave();
                        var sd_data = $('#description').val();
                        @this.set('description',sd_data);
                    });
                }
            });
        });
    </script>
@endpush