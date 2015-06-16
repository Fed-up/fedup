@extends('tmpl.public')



@section('content')
    <section class="page">  
        <nav class=" subnav subnav--centre">
            <h2 class="content__title--main"><a class="plain__header__link" href="/menu">Today's Menu</a></h2>
        </nav>

        <section class="content__page--sub"> 
            <!-- <h3>Fresh all day - savoury meals</h3> -->
            <div class="row content-boxes__wrapper content">
                <div class="row">
                    <h3 class="section__menu__heading">Fresh all day - savoury meals</h3>
                    @if($savCount == 0)
                        <p class="user__message">Sorry there are no Savoury meals on our menu today</p>
                    @else
                        @foreach($savData as $index=>$recipe)
                            <div class="columns small-12 medium-4 large-3 xlarge-3 xxlarge-2 end">
                                <article class="content-box">
                                    <div class="row collapse" id="recipe__row">                                   
                                        <a href="/recipe/{{$recipe->id}}" class="columns small-4 medium-12 tile__title end">
                                            <span class="tile__title--inner">{{$recipe->name}}</span>
                                            <img src="/uploads/{{ $savImage[$recipe->id] }}" />
                                        </a>
                                        <section class="columns small-8 medium-12 content-box__copy--wrapper">
                                            <div class="content-box__copy">
                                                <a href="/recipe/{{$recipe->id}}" class="content-box__copy__inner--recipe"><h5 class="content-box__title">{{$recipe->name}}</h5></a>
                                                <!-- @if(!empty($category[$recipe->id]))
                                                    <a href="/collection/{{$category[$recipe->id]->id}}" class="content-box__tag">{{$category[$recipe->id]->name}}</a>
                                                @else
                                                    <a href="/collections" class="content-box__tag">Collections</a>
                                                @endif -->
                                            </div>
                                        </section>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="row">
                    <h3 class="section__menu__heading">Quick - savoury snacks</h3>
                    @if($snaCount == 0)
                        <p class="user__message">Sorry there are savoury snacks on our menu today</p>
                    @else
                        @foreach($snaData as $index=>$recipe)
                            <div class="columns small-12 medium-4 large-3 xlarge-3 xxlarge-2 end">
                                <article class="content-box">
                                    <div class="row collapse" id="recipe__row">                                   
                                        <a href="/recipe/{{$recipe->id}}" class="columns small-4 medium-12 tile__title end">
                                            <span class="tile__title--inner">{{$recipe->name}}</span>
                                            <img src="/uploads/{{ $snaImage[$recipe->id] }}" />
                                        </a>
                                        <section class="columns small-8 medium-12 content-box__copy--wrapper">
                                            <div class="content-box__copy">
                                                <a href="/recipe/{{$recipe->id}}" class="content-box__copy__inner--recipe"><h5 class="content-box__title">{{$recipe->name}}</h5></a>
                                                <!-- @if(!empty($category[$recipe->id]))
                                                    <a href="/collection/{{$category[$recipe->id]->id}}" class="content-box__tag">{{$category[$recipe->id]->name}}</a>
                                                @else
                                                    <a href="/collections" class="content-box__tag">Collections</a>
                                                @endif -->
                                            </div>
                                        </section>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="row">
                    <h3 class="section__menu__heading">So Naughty But Nice desserts </h3>
                    @if($desCount == 0)
                        <p class="user__message">Sorry there are no So Naughty But Nice desserts on our menu today</p>
                    @else
                        @foreach($desData as $index=>$recipe)
                            <div class="columns small-12 medium-4 large-3 xlarge-3 xxlarge-2 end">
                                <article class="content-box">
                                    <div class="row collapse" id="recipe__row">                                   
                                        <a href="/recipe/{{$recipe->id}}" class="columns small-4 medium-12 tile__title end">
                                            <span class="tile__title--inner">{{$recipe->name}}</span>
                                            <img src="/uploads/{{ $desImage[$recipe->id] }}" />
                                        </a>
                                        <section class="columns small-8 medium-12 content-box__copy--wrapper">
                                            <div class="content-box__copy">
                                                <a href="/recipe/{{$recipe->id}}" class="content-box__copy__inner--recipe"><h5 class="content-box__title">{{$recipe->name}}</h5></a>
                                                <!-- @if(!empty($category[$recipe->id]))
                                                    <a href="/collection/{{$category[$recipe->id]->id}}" class="content-box__tag">{{$category[$recipe->id]->name}}</a>
                                                @else
                                                    <a href="/collections" class="content-box__tag">Collections</a>
                                                @endif -->
                                            </div>
                                        </section>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="row">
                    <h3 class="section__menu__heading">Pick me  up refreshments</h3>
                    @if($refCount == 0)
                        <p class="user__message">Sorry there are no refreshments on our menu today</p>
                    @else
                        @foreach($refData as $index=>$recipe)
                            <div class="columns small-12 medium-4 large-3 xlarge-3 xxlarge-2 end">
                                <article class="content-box">
                                    <div class="row collapse" id="recipe__row">                                   
                                        <a href="/recipe/{{$recipe->id}}" class="columns small-4 medium-12 tile__title end">
                                            <span class="tile__title--inner">{{$recipe->name}}</span>
                                            <img src="/uploads/{{ $refImage[$recipe->id] }}" />
                                        </a>
                                        <section class="columns small-8 medium-12 content-box__copy--wrapper">
                                            <div class="content-box__copy">
                                                <a href="/recipe/{{$recipe->id}}" class="content-box__copy__inner--recipe"><h5 class="content-box__title">{{$recipe->name}}</h5></a>
                                                <!-- @if(!empty($category[$recipe->id]))
                                                    <a href="/collection/{{$category[$recipe->id]->id}}" class="content-box__tag">{{$category[$recipe->id]->name}}</a>
                                                @else
                                                    <a href="/collections" class="content-box__tag">Collections</a>
                                                @endif -->
                                            </div>
                                        </section>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div> 
        </section> 
  	</section><!--End Band Content-->
@stop
{{-- '<pre>'; print_r($recipe->MenuCategories->name); echo '</pre>'; --}}

@section('_footer')
	<script type="text/javascript" src="/public/js/flexslider.js"></script>
	<script type="text/javascript" src="/public/js/tabs.js"></script>
    <script type="text/javascript" src="/js/gallery.js"></script>
@stop