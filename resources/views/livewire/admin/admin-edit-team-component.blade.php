@section('page-title')
Edit Team
@endsection
<div>
    <div class="container" style="padding: 30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Edit Team Member
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('admin.team')}}" class="btn btn-success pull-right">All Members</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel body">
                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                        @endif
                        <form class="form-horizontal" enctype="multipart/form-data" wire:submit.prevent="updateMember">
                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Name</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="name" class="form-control input-md" wire:model="name">
                                    @error('name') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Role</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="role" class="form-control input-md" wire:model="role">
                                    @error('role') <p class="text-danger">{{$message}}</p> @enderror
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
                                <label for="" class="col-md-4 control-label">Image</label>
                                <div class="col-md-4">
                                    <input type="file" class="input-file" wire:model="newimage">
                                    @if($newimage)
                                        <img src="{{$newimage->temporaryUrl()}}" width="120">
                                    @else
                                        <img src="{{asset('assets/images/team')}}/{{$image}}" width="120">
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