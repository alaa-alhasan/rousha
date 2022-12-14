@section('page-title')
Orders
@endsection
<div>
    <style>
        nav svg{
            height: 20px;

        }
        nav .hidden{
            display: block !important;
        }
    </style>
    <div class="container" style="padding: 30px 0;">
        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="/" class="link">home</a></li>
                <li class="item-link"><span>Orders</span></li>
            </ul>
        </div>

        @if ($orders->count() > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            All Orders
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Subtotal(CHF)</th>
                                        <th>Discount(CHF)</th>
                                        <th>Tax(CHF)</th>
                                        <th>Total(CHF)</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Zipcode</th>
                                        <th>Status</th>
                                        <th>Order Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{$i++;}}</td>
                                            <td>{{$order->subtotal}}</td>
                                            <td>{{$order->discount}}</td>
                                            <td>{{$order->tax}}</td>
                                            <td>{{$order->total}}</td>
                                            <td>{{$order->firstname}}</td>
                                            <td>{{$order->lastname}}</td>
                                            <td>{{$order->mobile}}</td>
                                            <td>{{$order->email}}</td>
                                            <td>{{$order->zipcode}}</td>
                                            <td>
                                                @php
                                                if($order->status == 'canceled'){$color = 'red';}elseif($order->status == 'delivered'){$color = 'green';}else{$color = 'blue';}
                                                @endphp
                                                <span style="color: {{$color}}">
                                                {{$order->status}}
                                                </span>
                                            </td>
                                            <td>{{$order->created_at}}</td>
                                            <td><a href="{{route('user.orderdetails',['order_id'=>$order->id])}}" class="btn btn-info btn-sm">Details</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$orders->links()}}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center" style="padding: 30px 0;">
                <h1>You Have Not Any Order Yet, Shop Now!</h1>
                <a href="/shop" class="btn btn-success">shop now</a>
            </div>
        @endif

        
    </div>
</div>
