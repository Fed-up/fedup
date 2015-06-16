@extends('tmpl.public')

@section('_header')
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script>
      function initialize() {
  var myLatlng = new google.maps.LatLng(-37.831043,144.959600);
  var mapOptions = {
    zoom: 16,
    center: myLatlng,
    scrollwheel: false,
    navigationControl: false,
    mapTypeControl: false,
    scaleControl: false,
    draggable: false,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    // How you would like to style the map. 
    // This is where you would paste any style found on Snazzy Maps.
    styles: [
    {
        "featureType": "water",
        "stylers": [
            {
                "saturation": 43
            },
            {
                "lightness": -11
            },
            {
                "hue": "#0088ff"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "hue": "#ff0000"
            },
            {
                "saturation": -100
            },
            {
                "lightness": 99
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#808080"
            },
            {
                "lightness": 54
            }
        ]
    },
    {
        "featureType": "landscape.man_made",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#ece2d9"
            }
        ]
    },
    {
        "featureType": "poi.park",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#ccdca1"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#767676"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "color": "#ffffff"
            }
        ]
    },
    {
        "featureType": "poi",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape.natural",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "color": "#b8cb93"
            }
        ]
    },
    {
        "featureType": "poi.park",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "poi.sports_complex",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "poi.medical",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "poi.business",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    }
]
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions); 

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Selection Cafe - Indulge in local fresh foods'
  });
}

google.maps.event.addDomListener(window, 'load', initialize);
    </script> 

@stop

@section('content')

<main class="main page home">
    <div class="bg"></div>
        <div class="video__home">
            <!-- <video autoplay loop poster="/images/paws/videopic.jpg" id="bgvid" class="hide-for-large-up">
                <source src="videos/websitefood2.webm" type="video/webm">
                <source src="videos/websitefood2.mp4" type="video/mp4">
            </video> -->
        </div>
        <div id="vidpause"></div>
        <section class="columns small-12 medium-10 medium-push-1 large-8 large-push-2 xlarge-6 xlarge-push-3 section__white--form">
            @if (isset($message))
               <div class="message__alert">{{ $message }}</div>
            @endif
            @if (isset($registered))
                <div class="registered__message">{{ $registered }}</div>
            @else
                {{ Form::open(array('action' => 'UserProfileController@postAddUserHome', 'class' => 'form-horizontal')) }}
                    <h2 class="homepage_title">Fed Up Project</h2> 

                    <div class="form-group {{ ($errors->has('fname')) ? 'has-error' : '' ; }} row">
                        {{ Form::label('fname', 'Full Name: ', array('class' => ' form_field_title ')) }}
                        <div class=""> 
                            {{ Form::text('fname', (isset($input['fname'])? Input::old('fname') : (isset($data->fname)? $data->fname : '' )), array('class' => ($errors->has('fname'))? 'columns small-12 medium-8 input__text--home input__text--error' : 'columns small-12 medium-8 input__text--home', 'placeholder' => ($errors->has('fname'))? $errors->first('fname') : '' )) }} 
                        </div>
                    </div>
                    <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' ; }} row">
                        {{ Form::label('email', 'Email: ', array('class' => ' form_field_title ')) }}
                        <div class="">
                            {{ Form::text('email', (isset($input['email'])? Input::old('email') : (isset($data->email)? $data->email : '' )), array('class' => ($errors->has('email'))? 'columns small-12 medium-8 input__text--home input__text--error' : 'columns small-12 medium-8 input__text--home', 'placeholder' => ($errors->has('email'))? $errors->first('email') : '' )) }}  
                        </div>
                    </div>  
     
           
                
                    <div class="form__buttons">
                        {{ Form::submit('', array('class' => 'form__image__submit')) }}
                    </div>

                    <!-- <div class="form-group">
                        {{ Form::submit('', array('class' => 'form__image__submit form__image__submit--small')) }}
                    </div> -->
                {{ Form::close() }} 
            @endif         
        </section>
        <section class="section__white--homepage">
            <!-- <img src="/images/paws/s2leaf.png" alt="Where Real food comes to life" name="Where Real food comes to life" class="leaf1"> -->
            <p class="business_name">Fed Up Project coming soon..</p>
            <p class="map_location">210 Clarendon Street, South Melbourne, 3250</p>
            <p class="business_hours">Open: Sunrise - Sunset</p>
        </section>
        <div id="map-canvas"></div>
        <section id=""class="section__points row">
            <!-- <div class="columns small-12 medium-4 end">
                <article class="points">
                    <div id="1" class="iconbox">
                        <div id="2" class="iconbox__content"> 
                            <a href="/menu"><img src="/images/selection/menu.png" alt="Today's Menu"/></a>
                        </div>
                    </div>
                </article>
            </div>
            <div class="columns small-12 medium-4 end">
                <article class="points">
                    <div id="1" class="iconbox">
                        <div id="2" class="iconbox__content">
                            <a href="/catering"><img src="/images/selection/catering.png" alt="Order Catering"/></a>
                        </div>
                    </div>
                </article>
            </div> -->
            <div class="columns small-12end">
                <a href="/aboutus">
                <article class="points">
                    <div id="1" class="iconbox">
                        <div id="2" class="iconbox__content">
                            
                        </div>
                    </div>
                </article>
                </a>
            </div>
        </section>
        <section id="mission"class="section__mission">
            <!-- <img src="/images/paws/rleaf.png" alt="Where Real food comes to life" name="Where Real food comes to life" class="leaf3"> -->
            <article class="small-12 medium-10 medium-push-1 large-8 large-push-2 xlarge-6 xlarge-push-3">
                <p class="">
                    Every now and then something special turns into reality and this is true for the new proud owners of Selection Cafe.
                    Our passion and love for food has developed into a career. We are currently expanding our current business<a class="textlink" href="https://www.sonaughtybutnice.com"> SoNaughtyButNice.com </a>.
                    We look forward to introducing a new concept into South Melbourne and celebrating the best food our country has to offer!
                </p>

            </article>         
        </section>
        @if(!empty($insta_array))
            <a href="https://instagram.com/fedupproject">
            <div class=" section__white--insta"> 
                <section class="row">
                    <p class="section__heading instagram__feed">Instagram Feed</p>

                    @foreach($insta_array['data'] as $image)
                    <div class="columns small-4 large-2 end">
                        <!-- <a href="https://instagram.com/sonaughtybutnice"> -->
                            <img src="{{$image['images']['low_resolution']['url']}}"> </img>
                        <!-- </a>     -->
                        <!-- </a> -->
                    </div> 
                    @endforeach
                </section>
            </div>
            </a>            
        @endif
        <section id="fs" class="section__facebook">
            <!-- <img src="/images/paws/s2leaf.png" alt="Where Real food comes to life" name="Where Real food comes to life" class="leaf1"> -->
            <a id="fl" href="https://www.facebook.com/pages/fedupproject" class="facebook__link">
                Check us out on facebook
            </a>
        </section>
        <!-- <section id="vision"class="section__vision">
            <article class="small-12 medium-10 medium-push-1 large-8 large-push-2 xlarge-6 xlarge-push-3">
                <b class="vision_p">
                A cafe that welcomes the ENTIRE family, with menus
                for everyone including you furbaby!
                </b>
                <br/><br/>
                <p class="vision_p">We invite you to</p>
                <ul class="vision_list">
                    <li class="bullet_point">Treat your 4-legged part of the family to a nutritious breaky, brunch or lunch</li>
                    <li class="bullet_point">Make new friends for you and your fur baby in a safe and friendly environment</li>
                    <li class="bullet_point">Experience personalised service where you and your family are our family</li>
                    <li class="bullet_point">Interested in adopting a real food lifestyle in your home? Let us show you how</li>
                    <li class="bullet_point">Check out Eco friendly products for your dog</li>
                    <li class="bullet_point">Try our exclusive Time 4 Paws home cooked ‘real’ dry food for your fury friend.</li>
                    <li class="bullet_point">Incorporate Paleo/LCHF lifestyle into your household</li>
                    <li class="bullet_point">Be amongst like minded people</li>
                <br/>
                <p class="vision_p">
                    Don’t have a furbaby?
                </p>
                <p class="vision_p">
                    Come experience great service, great atmosphere and get your 4 legged fur fix =) After all everyone needs to take ‘Time 4 Paws’
                </p>
            </article>  
            <!-- <img src="/images/paws/bleaf.png" alt="Where Real food comes to life" name="Where Real food comes to life" class="leaf2">        -->
        </section>
    </main>
@stop

@section('_footer')
    <script type="text/javascript" src="/js/flexslider.js"></script>
    <script type="text/javascript" src="/js/tabs.js"></script>
    <script type="text/javascript" src="/js/gallery.js"></script>
    <script>
        // $(window).load(function() {
        //   $('.flexslider--thumbs').flexslider({
        //     controlNav: "thumbnails",
        //     controlsContainer: "#thumbs",
        //     animationSpeed: 300,
        //     slideshow: false,
        //     directionNav: false,

        //     animation: "slide",
        //     direction: "vertical"
        //   });
        // });

        var vid = document.getElementById("bgvid");
        var pauseButton = document.getElementById("vidpause");
        function vidFade() {
        vid.classList.add("stopfade");
        }
        vid.addEventListener('ended', function() {
        // only functional if "loop" is removed
        vid.pause();
        // to capture IE10
        vidFade();
        });
        pauseButton.addEventListener("click", function() {
        vid.classList.toggle("stopfade");
        if (vid.paused) {
        vid.play();
        pauseButton.innerHTML = "Pause";
        } else {
        vid.pause();
        pauseButton.innerHTML = "Paused";
        }
        })
        $('video').prop('volume', 0)
        $('video').prop('muted', true)
        
    </script>
    <script>
        video#bgvid { transition: 5s opacity; }
        .stopfade { opacity: .5; }
        

    </script>
@stop
