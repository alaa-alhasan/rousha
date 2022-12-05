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
                <p class="txt-content">Roussha International was established in 2022 AD, We work to find everything new in the world of fashion, elegance, and others. We select the finest products for you very carefully and guarantee that all our products are 100% original. Your trust in us is our goal.</p>
            </div>

            <div class="row">

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="aboutus-info style-small-left">
                        <b class="box-title">What we really do?</b>
                        <p class="txt-content">We create unique masterpieces of garments that are unique. Each piece has a feel, a history that began with an idea that shaped the design, the choice of colors, and the fabric. We don’t compromise on quality. All that, for our clients – just as unique and with exquisite taste for “that special something”.</p>
                    </div>
                    <div class="aboutus-info style-small-left">
                        <b class="box-title">History of the Company</b>
                        <p class="txt-content">One day I and my wife came back from a shopping tour barehanded. Nothing stood out to match her beauty and sense of self-empowerment. She told me that she craved something different that stood out from the mass of garments that would match the desire I had for her. Sometimes we crave something special and unique, full of passion– to express our personality and being. After all, our clothing is the skin we wear… The next morning the idea was born to start my own fashion brand. Because life is too short to not be surrounded by what we truly love.</p>
                    </div>
                </div>
                

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="aboutus-info style-small-left">
                        <b class="box-title">Our Vision</b>
                        <p class="txt-content">We all wear our clothing as a second skin for the entire day. It is as much a part of our being as our hair, our eyes….we express our hearts thru our clothes. For that reason, we don’t compromise when it comes to expressing ourselves thru the clothing who we wear. Since clothes in stores and boutiques do not catch all the nuances that we seek, we took the task into our hands – to create the fashion that we and our clients really desire.</p>
                    </div>
                    <div class="aboutus-info style-small-left">
                        <b class="box-title">Cooperate with Us!</b>
                        <p class="txt-content">You didn’t find anything that suits your taste and desire? Do you have some idea of what you love to wear but cannot find it anywhere? Contact us and team up – we will make it a reality. Let us discover the roads to your desire together.</p>
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