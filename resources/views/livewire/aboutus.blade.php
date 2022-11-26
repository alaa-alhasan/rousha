@section('page-title')
About us
@endsection
<main id="main" class="main-site">

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">home</a></li>
                <li class="item-link"><span>About us</span></li>
            </ul>
        </div>
    </div>
    
    <div class="container">
        <!-- <div class="main-content-area"> -->
            <div class="aboutus-info style-center">
                <b class="box-title">Interesting Facts</b>
                <p class="txt-content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the dummy text ever since the 1500s, when an unknown printer took a galley of type</p>
            </div>

            <div class="row">

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="aboutus-info style-small-left">
                        <b class="box-title">What we really do?</b>
                        <p class="txt-content">We seek out and connect with project managers in the emerging markets.  Our focus is to organize fundings that connect our customers to their passion. We follow the client to the very end of the funding process.</p>
                    </div>
                    <div class="aboutus-info style-small-left">
                        <b class="box-title">History of the Company</b>
                        <p class="txt-content">Izaat began his entrepreneurship in 2020 to follow his passion for design and real estate. Together with his partners, his company established itself quickly in the niche of customized real-estate development.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="aboutus-info style-small-left">
                        <b class="box-title">Our Vision</b>
                        <p class="txt-content">To provide customers solutions that are life-changing, We strive to be a global leader in fashion-knit and fashion outerwear by empowering innovation and design to provide total customer satisfaction. </p>
                    </div>
                    <div class="aboutus-info style-small-left">
                        <b class="box-title">Cooperate with Us!</b>
                        <p class="txt-content">Let's give form and life to your real-estate project. Contact us today.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="aboutus-info style-small-left">
                        <b class="box-title">Cooperate with Us!</b>
                        <div class="list-showups">
                            <label>
                                <input type="radio" class="hidden" name="showup" id="shoup1" value="shoup1" checked="checked">
                                <span class="check-box"></span>
                                <span class='function-name'>Support 24/7</span>
                                <span class="desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry...</span>
                            </label>
                            <label>
                                <input type="radio" class="hidden" name="showup" id="shoup2" value="shoup2">
                                <span class="check-box"></span>
                                <span class='function-name'>Best Quanlity</span>
                                <span class="desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry...</span>
                            </label>
                            <label>
                                <input type="radio" class="hidden" name="showup" id="shoup3" value="shoup3">
                                <span class="check-box"></span>
                                <span class='function-name'>Fastest Delivery</span>
                                <span class="desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry...</span>
                            </label>
                            <label>
                                <input type="radio" class="hidden" name="showup" id="shoup4" value="shoup4">
                                <span class="check-box"></span>
                                <span class='function-name'>Customer Care</span>
                                <span class="desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry...</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            @if ($team->count() > 0)
            <div class="our-team-info">
                <h4 class="title-box">Our teams</h4>
                <div class="our-staff">
                    <div 
                        class="slide-carousel owl-carousel style-nav-1 equal-container" 
                        data-items="{{$team->count()}}" 
                        data-loop="false" 
                        data-nav="true" 
                        data-dots="false"
                        data-margin="30"
                        data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"3"},"1200":{"items":"4"}}' >

                        @foreach ($team as $member)
                            <div class="team-member equal-elem">
                                <div class="media">
                                    <a href="#" title="{{$member->name}}">
                                        <figure><img src="{{ asset('assets/images/team') }}/{{$member->image}}" alt="{{$member->name}}"></figure>
                                    </a>
                                </div>
                                <div class="info">
                                    <b class="name">{{$member->name}}</b>
                                    <span class="title">{{$member->role}}</span>
                                    <p class="desc">{!! $member->description !!}</p>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>

            </div>
            @endif
        <!-- </div> -->
        

    </div><!--end container-->

</main>