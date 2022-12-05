<div>
    <footer id="footer">
		<div class="wrap-footer-content footer-style-1">

			<div class="wrap-function-info">
				<div class="container">
					<ul>
						<li class="fc-info-item">
							<i class="fa fa-truck" aria-hidden="true"></i>
							<div class="wrap-left-info">
								<h4 class="fc-name">Free Shipping</h4>
								<p class="fc-desc">Not Available Now</p>
							</div>

						</li>
						<li class="fc-info-item">
							<i class="fa fa-recycle" aria-hidden="true"></i>
							<div class="wrap-left-info">
								<h4 class="fc-name">Guarantee</h4>
								<p class="fc-desc">7 Days Money Back</p>
							</div>

						</li>
						<li class="fc-info-item">
							<i class="fa fa-credit-card-alt" aria-hidden="true"></i>
							<div class="wrap-left-info">
								<h4 class="fc-name">Safe Payment</h4>
								<p class="fc-desc">Safe your online payment</p>
							</div>

						</li>
						<li class="fc-info-item">
							<i class="fa fa-life-ring" aria-hidden="true"></i>
							<div class="wrap-left-info">
								<h4 class="fc-name">Online Suport</h4>
								<p class="fc-desc">We Have Support 24/7</p>
							</div>

						</li>
					</ul>
				</div>
			</div>
			<!--End function info-->

			<div class="main-footer-content">

				<div class="container">

					<div class="row">

						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
							<div class="wrap-footer-item">
								<h3 class="item-header">Contact Details</h3>
								<p class="contact-txt">Roussha International was established in 2022 AD, We work to find everything new in the world of fashion, elegance, and others. We select the finest products for you very carefully and guarantee that all our products are 100% original. Your trust in us is our goal.</p>
								<div class="item-content">
									<div class="wrap-contact-detail">
										<ul>
											<li>
												<i class="fa fa-map-marker" aria-hidden="true"></i>
												<p class="contact-txt">{{$setting->address}}</p>
											</li>
											<li>
												<i class="fa fa-phone" aria-hidden="true"></i>
												<p class="contact-txt">{{$setting->phone}}</p>
											</li>
											<li>
												<i class="fa fa-envelope" aria-hidden="true"></i>
												<p class="contact-txt">{{$setting->email}}</p>
											</li>											
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">

							<div class="wrap-footer-item">
								<h3 class="item-header">Hot Line</h3>
								<div class="item-content">
									<div class="wrap-hotline-footer">
										<span class="desc">Call Us toll Free</span>
										<b class="phone-number">{{$setting->hotline}}</b>
									</div>
								</div>
							</div>

							<div class="wrap-footer-item footer-item-second">
								<h3 class="item-header">Sign up for newsletter</h3>
								<div class="item-content">
									<div class="wrap-newletter-footer">
										<form action="#" class="frm-newletter" id="frm-newletter">
											<input type="email" class="input-email" name="email" value="" placeholder="Enter your email address">
											<button class="btn-submit">Subscribe</button>
										</form>
									</div>
								</div>
							</div>

						</div>

						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 box-twin-content ">
							<div class="row">
								<div class="wrap-footer-item twin-item">
									<h3 class="item-header">My Account</h3>
									<div class="item-content">
										<div class="wrap-vertical-nav">
											<ul>
												<li class="menu-item"><a href="{{ route('user.dashboard') }}" class="link-term">Dashboard</a></li>
												<li class="menu-item"><a href="{{ route('user.orders') }}" class="link-term">My Orders</a></li>
												<li class="menu-item"><a href="{{ route('checkout') }}" class="link-term">Checkout</a></li>
												<li class="menu-item"><a href="{{ route('user.profile') }}" class="link-term">Profile</a></li>
												<li class="menu-item"><a href="{{ route('product.wishlist') }}" class="link-term">Withlist</a></li>
												<li class="menu-item"><a href="{{ route('product.cart') }}" class="link-term">My Cart</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="wrap-footer-item twin-item">
									<h3 class="item-header">Infomation</h3>
									<div class="item-content">
										<div class="wrap-vertical-nav">
											<ul>
												<li class="menu-item"><a href="{{ route('contact') }}" class="link-term">Contact Us</a></li>
												<li class="menu-item"><a href="{{ route('aboutus') }}" class="link-term">About Us</a></li>
												<li class="menu-item"><a href="{{ route('returnexchange') }}" class="link-term">Returns & Exchanges</a></li>
												<li class="menu-item"><a href="{{ route('privacypolicy') }}" class="link-term">Privacy Policy</a></li>
												<li class="menu-item"><a href="{{ route('shop') }}" class="link-term">Shop</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

					<div class="row">

						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
							<div class="wrap-footer-item">
								<h3 class="item-header">We Using Safe Payments:</h3>
								<div class="item-content">
									<div class="wrap-list-item wrap-gallery">
										<img src="{{asset('assets/images/payment.png')}}" style="max-width: 260px;">
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
							<div class="wrap-footer-item">
								<h3 class="item-header">Social network</h3>
								<div class="item-content">
									<div class="wrap-list-item social-network">
										<ul>
											<li><a href="{{$setting->twiter}}" class="link-to-item" title="twitter" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="{{$setting->facebook}}" class="link-to-item" title="facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="https://wa.me/{{$setting->whatsapp}}" class="link-to-item" title="pinterest" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
											<li><a href="{{$setting->instagram}}" class="link-to-item" title="instagram" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
											<li><a href="{{$setting->youtube}}" class="link-to-item" title="youtube" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
							<div class="wrap-footer-item">
								<h3 class="item-header">Dowload App</h3>
								<div class="item-content">
									<div class="wrap-list-item apps-list">
										<ul>
											<li><a href="#" class="link-to-item" title="our application on apple store"><figure><img src="{{asset('assets/images/brands/apple-store.png')}}" alt="apple store" width="128" height="36"></figure></a></li>
											<li><a href="#" class="link-to-item" title="our application on google play store"><figure><img src="{{asset('assets/images/brands/google-play-store.png')}}" alt="google play store" width="128" height="36"></figure></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

			</div>

			<div class="coppy-right-box" style="margin-top: 10px">
				<div class="container">
					<div class="coppy-right-item item-left">
						<p class="coppy-right-text">Copyright © 2022 Rousha Store. All rights reserved</p>
					</div>
					<div class="coppy-right-item item-right">
						<div class="wrap-nav horizontal-nav">
							<ul>
								<li class="menu-item"><a href="/about-us" class="link-term">About us</a></li>							
							</ul>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</footer>
</div>
