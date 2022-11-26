@section('page-title')
Our Team
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
                            <div class="col-md-6">All Our Team Members</div>
                            <div class="col-md-6">
                                <a href="{{route('admin.addteam')}}" class="btn btn-success pull-right">Add New</a>
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
                                    <th>Member Name</th>
                                    <th>Role</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($team  as $member)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$member->name}}</td>
                                        <td>{{$member->role}}</td>
                                        <td>{!! $member->description !!}</td>
                                        <td><img src="{{asset('assets/images/team')}}/{{$member->image}}" width="60"></td>
                                        <td>
                                            <a href="{{route('admin.editteam',['member_id'=>$member->id])}}"><i class="fa fa-edit fa-2x"></i></a>
                                            <a href="#" onclick="confirm('Are You Sure, You want to delete this Member From Your Team?') || event.stopImmediatePropagation()" wire:click.prevent="deleteTeamMember({{$member->id}})"><i class="fa fa-times fa-2x text-danger"></i></a>
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
