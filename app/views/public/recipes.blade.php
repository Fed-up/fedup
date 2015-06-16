@extends('tmpl.public')



@section('content')
    <section class="page">  
        <nav class=" subnav subnav--centre" >
            <h2 class="content__title--main"><a class="plain__header__link" href="/menu">All Catering Options</a></h2>
        </nav>

        <section class="content__page--sub"> 
            <!-- <h3>Fresh all day - savoury meals</h3> -->
            <div class="row content-boxes__wrapper content">
                <div class="row">
                    @foreach($rData as $index=>$recipe)
                        <div class="columns small-12 medium-4 large-3 xlarge-3 xxlarge-2 end">
                            <article class="content-box">
                                <div class="row collapse" id="recipe__row">                                   
                                    <a href="/recipe/{{$recipe->id}}" class="columns small-4 medium-12 tile__title end">
                                        <span class="tile__title--inner">{{$recipe->name}}</span>
                                        <img src="/uploads/{{ $rImage[$recipe->id] }}" />
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
                </div>
            </div>           
        </section>

        <!-- <h2 class="content__title content__title--main"><a class="content__title--link" href="/recipes">More Recipes</a></h2> -->
        <!-- <div class="footer__push"></div> -->
  	</section><!--End Band Content-->
@stop
{{-- '<pre>'; print_r($recipe->MenuCategories->name); echo '</pre>'; --}}

@section('_footer')
	<script type="text/javascript" src="/public/js/flexslider.js"></script>
	<script type="text/javascript" src="/public/js/tabs.js"></script>
    <script type="text/javascript" src="/js/gallery.js"></script>
@stop