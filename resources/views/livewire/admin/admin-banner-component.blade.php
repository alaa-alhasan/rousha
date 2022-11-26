@section('page-title')
Manage Banners
@endsection
<div>
    <style>
        nav svg{
            height: 20px;
        }
        nav .hidden{
            display: block !important;
        }
        .sclist{
            list-style: none;
        }
        .sclist li{
            line-height: 33px;
            border-bottom: 1px solid #ccc;
        }
        .slink i{
            font-size: 16px;
            margin-left: 12px;
        }
    </style>
    <div class="container" style="padding:30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">All Banners</div>
                            <div class="col-md-6">
                                <a href="{{route('admin.addbanner')}}" class="btn btn-success pull-right">Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                        @endif
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Label</th>
                                    <th>Description</th>
                                    <th>Button Text</th>
                                    <th>Link</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($banners  as $banner)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$banner->name}}</td>
                                        <td>{{$banner->label}}</td>
                                        <td>{!! $banner->description !!}</td>
                                        <td>{{$banner->btntxt}}</td>
                                        <td>{{$banner->link}}</td>
                                        <td><img src="{{asset('assets/images/banners')}}/{{$banner->image}}" width="60"></td>
                                        <td>
                                            <a href="{{route('admin.editbanner',['banner_id'=>$banner->id])}}"><i class="fa fa-edit fa-2x"></i></a>
                                            <a href="#" onclick="confirm('Are You Sure, You want to delete this Banner?') || event.stopImmediatePropagation()" wire:click.prevent="deleteBanner({{$banner->id}})"><i class="fa fa-times fa-2x text-danger"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
