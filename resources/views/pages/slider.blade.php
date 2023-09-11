	<!-- Slider -->
	<section class="section-slide">
	    <div class="wrap-slick1">
	        <div class="slick1">
	            @foreach($banner as $key)

	            <div class="item-slick1" href='{{$key->image->path}} ' style="background-image: url({{ asset('uploads\banner\pngtree-background-biru-tosca-keren-dan-kosong-abstract-untuk-wallpaper-template-desain-image-1067527jpg-1681293348-pHCR.jpg ') }})">
	                <div class="container h-full">
	                    <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
	                        <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
	                            <span class="ltext-101 cl2 respon2">
	                                {{$key->name}}
	                            </span>

	                        </div>

	                        <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
	                            <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
	                                {!!$key->intro !!}
	                            </h2>
	                        </div>

	                        <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
	                            <a href="product.html" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
	                                Shop Now

	                            </a>
	                        </div>
	                    </div>
	                </div>
	            </div>

	            @endforeach


	        </div>
	    </div>
	</section>
