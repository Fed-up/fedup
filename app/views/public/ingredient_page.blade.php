@extends('tmpl.public')



@section('content')
    <div class="page">
        <section class="row">
        	@foreach($iData as $ingredient)
                <h2 class="content__title content__title--main"><a class="content__title--link" href="/ingredients">{{$ingredient->name}}</a></h2>
                <div class="columns small-12 medium-6 medium-push-3 large-4 large-pull-0">
                    <!-- <pre>{{print_r($iImage[$ingredient->id])}}</pre> -->
                    <img src="/uploads/{{ $iImage[$ingredient->id] }}" />
                </div>
                <div class="columns small-12 medium-12 large-8 end">
                     
                    <h4 class="content__title">{{$ingredient->name}} Story</h4>
                    <div class="section__box">

                        @if($ingredient->description != null) 
                            {{-- '<pre>'; print_r($ingredient); echo '</pre>'; --}}
                            <p class="recipe_box_summary">{{$ingredient->description}}</p>
                        @else  
                            <p class="recipe_box_summary">We are researching right now to bring you the most relevent information about the nutrition and history, stay tuned =)</p>
                        @endif
                    </div>
                </div><!--End column--> 	
            @endforeach
        </section>
    	{{-- '<pre>'; print_r($rData); echo '</pre>'; --}}
        
        @if(isset($rData))
    	<div class="row "> <!--Recipe section-->
            @foreach($iData as $ingredient)
                <h2 class="content__title">Recipes that contain {{$ingredient->name}}</h2>
            @endforeach
            @foreach($rData as $recipe)
                
                <div class="columns small-12 medium-6 large-4 xlarge-2 end">
                    <article class="content-box">
                        <div class="row collapse">
                            
                            <a href="/recipe/{{$recipe->id}}" class="columns small-4 medium-12">
                              <img src="/uploads/{{ $rImage[$recipe->id] }}" />
                            </a>
                            

                            <section class="columns small-8 medium-12">
                                <div class="content-box__copy">
                                    <a href="/recipe/{{$recipe->id}}" class="content-box__copy__inner--recipe">
                                        <h5 class="content-box__title">{{$recipe->name}}</h5>
                                        <!-- <p class="content-box__summary">{{$recipe->summary}}</p> -->
                                    </a>
                                    <a href="/collection/{{$recipe->MenuCategories->id}}" class="content-box__tag">{{$recipe->MenuCategories->name}}</a>
                                </div>
                            </section>
                        </div>
                    </article>
                </div> 
            @endforeach
        </div><!--End container-->
		@endif
        
        
        
  	</div><!--End Band Content-->
   
@stop

@section('_footer')
	<script type="text/javascript" src="/public/js/flexslider.js"></script>
	<script type="text/javascript" src="/public/js/tabs.js"></script>
    <script type="text/javascript" src="/js/gallery.js"></script>
@stop


