@extends('tmpl.admin')

@section('title')
    {{ $title }}
@stop

@section('_head') 
	<script type="text/javascript" src="/packages/jquery-1.11.1.min/vendor/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
	<script type="text/javascript" src="/packages/plupload-2.1.2/js/plupload.full.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/packages/jquery-1.11.1.min/vendor/jquery-ui-1.10.4.custom/css/no-theme/jquery-ui-1.10.4.custom.min.css"/> 
    
    <script>
      


	$(function() {
		  
		$( "._mySortable" ).sortable({ 
			axis: "y", 
			opacity: 0.3,
			placeholder: "sortable-placeholder",
			// callback function
			update: function( event, ui ) {
				ui.item.css({'background':'#DBEEC9'})
			},
		});
		$( "._mySortable" ).disableSelection();







		//Start Ingredients
		$('#counterProtein').val( $('#_ListProtein li').length );
		$('#btnActionAddProtein').click(function(e) {
			e.preventDefault();
			
			var currentID = $('#counterProtein').val();
					
			$ix = 0;
			var ingredientsArray = [];
			<?php
			
			$ix = 0;
			foreach ($ingredients as $i=>$v) {
				echo 'ingredientsArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectList	= $('<select>',{
						'name':'ingredients_p[][x]',
						'id':'ingredients_p_'+currentID,
						'class':'form-control input--ingredient',
					});
			
			$.each(ingredientsArray, function(key,value) {
				SelectList
					.append($('<option></option>')
					.attr('value',value[0])
					.text(value[1])); 
			});
			
			var metricArray = [];
			<?php
			
			$ix = 0;
			foreach ($metric as $i=>$v) {
				echo 'metricArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectListM	= $('<select>',{
						'name':'metric_p[][x]',
						'id':'metric_p_'+currentID,
						'class':'form-control input--metric',
					});
			
			$.each(metricArray, function(key,value) {
				SelectListM
					.append($('<option></option>')
					.attr('value',value[0])//Returns first element in the array
					.text(value[1])); //Returns second element in the array
			});
			
			var deleteButton	= $('<button>',{
										'class':'glyphicon glyphicon-remove btn btn-danger'
									});
			deleteButton.bind('click', function(e){
				e.preventDefault();
				$(this).parent('li').remove().unbind('click');
			});
			
			$('#_ListProtein')
				.append( $('<li>') 
				
					.append( SelectList )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'amount_p[][x]',
						'id':'amount_p_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'amount',
					}) )
					.append( '&nbsp;' )
					.append( SelectListM )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'ri_sales_amount_p[][x]',
						'id':'ri_sales_amount_p_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'0.00',
					}) )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'grams_p[][x]',
						'id':'grams_b_'+currentID,
						'class':'form-control input--grams',
						'placeholder':'grams',
					}) )
					.append( '&nbsp;' )

					.append( deleteButton )
					.append( '&nbsp;' )
					.append( $('<span>',{
						'class':'glyphicon glyphicon-sort btn btn-default disabled'
					}) )
					
				)
			;
			
			$('#counterProtein').val( parseInt(currentID, 10) + 1 );
			
		});






		

		//Start Delete Ingredient
		$('#counterBase').val( $('#_ListBase li').length );

		$('.deleteBase').click(function(e) {
			e.preventDefault();
			
			//var currentID = 0;	
					
			var currentID = (this.id);
			
			if($("#ddb" + currentID).length == 0) {
				$('#_ListBase')
					
						.append( $('<input>',{
							'type':'hidden',
							'name':'ddb[]',
							'id':'ddi'+currentID, /*ddi = delete data ingredient*/
							'class':'form-control',
							'value':''+currentID,
						}) )
				;
				$(this).parent('li').hide().unbind('click');
				
			} else {
			//alert('this record already exists');
				$("#ddb" + currentID).closest('input').remove().unbind('click');
			}
			
			
			
		});

		
		//Start Ingredients
		$('#counterBase').val( $('#_ListBase li').length );
		$('#btnActionAddBase').click(function(e) {
			e.preventDefault();
			
			var currentID = $('#counterBase').val();
					
			$ix = 0;
			var ingredientsArray = [];
			<?php
			
			$ix = 0;
			foreach ($ingredients as $i=>$v) {
				echo 'ingredientsArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectList	= $('<select>',{
						'name':'ingredients_b[][x]',
						'id':'ingredients_b_'+currentID,
						'class':'form-control input--ingredient',
					});
			
			$.each(ingredientsArray, function(key,value) {
				SelectList
					.append($('<option></option>')
					.attr('value',value[0])
					.text(value[1])); 
			});
			
			var metricArray = [];
			<?php
			
			$ix = 0;
			foreach ($metric as $i=>$v) {
				echo 'metricArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectListM	= $('<select>',{
						'name':'metric_b[][x]',
						'id':'metric_b_'+currentID,
						'class':'form-control input--metric',
					});
			
			$.each(metricArray, function(key,value) {
				SelectListM
					.append($('<option></option>')
					.attr('value',value[0])//Returns first element in the array
					.text(value[1])); //Returns second element in the array
			});
			
			var deleteButton	= $('<button>',{
										'class':'glyphicon glyphicon-remove btn btn-danger'
									});
			deleteButton.bind('click', function(e){
				e.preventDefault();
				$(this).parent('li').remove().unbind('click');
			});
			
			$('#_ListBase')
				.append( $('<li>') 
				
					.append( SelectList )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'amount_b[][x]',
						'id':'amount_b_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'amount',
					}) )
					.append( '&nbsp;' )
					.append( SelectListM )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'ri_sales_amount_b[][x]',
						'id':'ri_sales_amount_b_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'0.00',
					}) )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'grams_b[][x]',
						'id':'grams_b_'+currentID,
						'class':'form-control input--grams',
						'placeholder':'grams',
					}) )
					.append( '&nbsp;' )

					.append( deleteButton )
					.append( '&nbsp;' )
					.append( $('<span>',{
						'class':'glyphicon glyphicon-sort btn btn-default disabled'
					}) )
					
				)
			;
			
			$('#counterBase').val( parseInt(currentID, 10) + 1 );
			
		});



		// //Start Delete Side1
		$('#counterSide1').val( $('#_ListSide1 li').length );

		$('.deleteSide1').click(function(e) {
			e.preventDefault();
			
			//var currentID = 0;	
					
			var currentID = (this.id);
			
			if($("#dds" + currentID).length == 0) {
				$('#_ListSide1')
					
						.append( $('<input>',{
							'type':'hidden',
							'name':'dds[]',
							'id':'dds'+currentID, /*ddi = delete data ingredient*/
							'class':'form-control',
							'value':''+currentID,
						}) )
				;
				$(this).parent('li').hide().unbind('click');
				
			} else {
			//alert('this record already exists');
				$("#dds" + currentID).closest('input').remove().unbind('click');
			}
			
			
			
		});

		
		// //Start Ingredients Side 1
		$('#counterSide1').val( $('#_ListSide1 li').length );
		$('#btnActionAddSide1').click(function(e) {
			e.preventDefault();
			
			var currentID = $('#counterSide1').val();
					
			$ix = 0;
			var ingredientsArray = [];
			<?php
			
			$ix = 0;
			foreach ($ingredients as $i=>$v) {
				echo 'ingredientsArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectList	= $('<select>',{
						'name':'ingredients_s[][x]',
						'id':'ingredients_s_'+currentID,
						'class':'form-control input--ingredient',
					});
			
			$.each(ingredientsArray, function(key,value) {
				SelectList
					.append($('<option></option>')
					.attr('value',value[0])
					.text(value[1])); 
			});
			
			var metricArray = [];
			<?php
			
			$ix = 0;
			foreach ($metric as $i=>$v) {
				echo 'metricArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectListM	= $('<select>',{
						'name':'metric_s[][x]',
						'id':'metric_s_'+currentID,
						'class':'form-control input--metric',
					});
			
			$.each(metricArray, function(key,value) {
				SelectListM
					.append($('<option></option>')
					.attr('value',value[0])//Returns first element in the array
					.text(value[1])); //Returns second element in the array
			});
			
			var deleteButton	= $('<button>',{
										'class':'glyphicon glyphicon-remove btn btn-danger'
									});
			deleteButton.bind('click', function(e){
				e.preventDefault();
				$(this).parent('li').remove().unbind('click');
			});
			
			$('#_ListSide1')
				.append( $('<li>') 
				
					.append( SelectList )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'amount_s[][x]',
						'id':'amount_s_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'amount',
					}) )
					.append( '&nbsp;' )
					.append( SelectListM )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'ri_sales_amount_s[][x]',
						'id':'ri_sales_amount_s_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'0.00',
					}) )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'grams_s[][x]',
						'id':'grams_s_'+currentID,
						'class':'form-control input--grams',
						'placeholder':'grams',
					}) )
					.append( '&nbsp;' )

					.append( deleteButton )
					.append( '&nbsp;' )
					.append( $('<span>',{
						'class':'glyphicon glyphicon-sort btn btn-default disabled'
					}) )
					
				)
			;
			
			$('#counterSide1').val( parseInt(currentID, 10) + 1 );
			
		});
		


		
		// //Start Ingredients Topping
		$('#counterTopping').val( $('#_ListTopping li').length );
		$('#btnActionAddTopping').click(function(e) {
			e.preventDefault();
			
			var currentID = $('#counterTopping').val();
					
			$ix = 0;
			var ingredientsArray = [];
			<?php
			
			$ix = 0;
			foreach ($ingredients as $i=>$v) {
				echo 'ingredientsArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectList	= $('<select>',{
						'name':'ingredients_t[][x]',
						'id':'ingredients_t_'+currentID,
						'class':'form-control input--ingredient',
					});
			
			$.each(ingredientsArray, function(key,value) {
				SelectList
					.append($('<option></option>')
					.attr('value',value[0])
					.text(value[1])); 
			});
			
			var metricArray = [];
			<?php
			
			$ix = 0;
			foreach ($metric as $i=>$v) {
				echo 'metricArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectListM	= $('<select>',{
						'name':'metric_t[][x]',
						'id':'metric_t_'+currentID,
						'class':'form-control input--metric',
					});
			
			$.each(metricArray, function(key,value) {
				SelectListM
					.append($('<option></option>')
					.attr('value',value[0])//Returns first element in the array
					.text(value[1])); //Returns second element in the array
			});
			
			var deleteButton	= $('<button>',{
										'class':'glyphicon glyphicon-remove btn btn-danger'
									});
			deleteButton.bind('click', function(e){
				e.preventDefault();
				$(this).parent('li').remove().unbind('click');
			});
			
			$('#_ListTopping')
				.append( $('<li>') 
				
					.append( SelectList )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'amount_t[][x]',
						'id':'amount_t_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'amount',
					}) )
					.append( '&nbsp;' )
					.append( SelectListM )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'ri_sales_amount_t[][x]',
						'id':'ri_sales_amount_t_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'0.00',
					}) )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'grams_t[][x]',
						'id':'grams_t_'+currentID,
						'class':'form-control input--grams',
						'placeholder':'grams',
					}) )
					.append( '&nbsp;' )

					.append( deleteButton )
					.append( '&nbsp;' )
					.append( $('<span>',{
						'class':'glyphicon glyphicon-sort btn btn-default disabled'
					}) )
					
				)
			;
			
			$('#counterTopping').val( parseInt(currentID, 10) + 1 );
			
		});











































		
		// //Start Delete Ingredient
		// $('#counterIngredients').val( $('#_ListIngredients li').length );

		// $('.deleteIngredient').click(function(e) {
		// 	e.preventDefault();
			
		// 	//var currentID = 0;	
					
		// 	var currentID = (this.id);
			
		// 	if($("#ddi" + currentID).length == 0) {
		// 		$('#_ListIngredients')
					
		// 				.append( $('<input>',{
		// 					'type':'hidden',
		// 					'name':'ddi[]',
		// 					'id':'ddi'+currentID, /*ddi = delete data ingredient*/
		// 					'class':'form-control',
		// 					'value':''+currentID,
		// 				}) )
		// 		;
		// 		$(this).parent('li').hide().unbind('click');
				
		// 	} else {
		// 	//alert('this record already exists');
		// 		$("#ddi" + currentID).closest('input').remove().unbind('click');
		// 	}
			
			
			
		// });

		
		// //Start Ingredients
		// $('#counterIngredients').val( $('#_ListIngredients li').length );
		// $('#btnActionAddIngredient').click(function(e) {
		// 	e.preventDefault();
			
		// 	var currentID = $('#counterIngredients').val();
			
		// 	var ingredientsArray = [];
		// 	<?php
			
		// 	$ix = 0;
		// 	foreach ($ingredients as $i=>$v) {
		// 		echo 'ingredientsArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
		// 		$ix++;
		// 	}; 

		// 	?>
			
		// 	var SelectList	= $('<select>',{
		// 				'name':'ingredients[][x]',
		// 				'id':'ingredients_'+currentID,
		// 				'class':'form-control input--ingredient',
		// 			});
			
		// 	$.each(ingredientsArray, function(key,value) {
		// 		SelectList
		// 			.append($('<option></option>')
		// 			.attr('value',value[0])
		// 			.text(value[1])); 
		// 	});
			
		// 	var metricArray = [];
		// 	<?php
			
		// 	$ix = 0;
		// 	foreach ($metric as $i=>$v) {
		// 		echo 'metricArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
		// 		$ix++;
		// 	}; 

		// 	?>
			
		// 	var SelectListM	= $('<select>',{
		// 				'name':'metric[][x]',
		// 				'id':'metric_'+currentID,
		// 				'class':'form-control input--metric',
		// 			});
			
		// 	$.each(metricArray, function(key,value) {
		// 		SelectListM
		// 			.append($('<option></option>')
		// 			.attr('value',value[0])//Returns first element in the array
		// 			.text(value[1])); //Returns second element in the array
		// 	});
			
		// 	var deleteButton	= $('<button>',{
		// 								'class':'glyphicon glyphicon-remove btn btn-danger'
		// 							});
		// 	deleteButton.bind('click', function(e){
		// 		e.preventDefault();
		// 		$(this).parent('li').remove().unbind('click');
		// 	});
			
		// 	$('#_ListIngredients')
		// 		.append( $('<li>') 
				
		// 			.append( SelectList )
		// 			.append( '&nbsp;' )
		// 			.append( $('<input>',{
		// 				'name':'amount[][x]',
		// 				'id':'amount_'+currentID,
		// 				'class':'form-control input--amount',
		// 				'placeholder':'amount',
		// 			}) )
		// 			.append( '&nbsp;' )
		// 			.append( SelectListM )
		// 			.append( '&nbsp;' )
		// 			.append( $('<input>',{
		// 				'name':'ri_sales_amount[][x]',
		// 				'id':'ri_sales_amount_'+currentID,
		// 				'class':'form-control input--amount',
		// 				'placeholder':'0.00',
		// 			}) )
		// 			.append( '&nbsp;' )
		// 			.append( $('<input>',{
		// 				'name':'grams[][x]',
		// 				'id':'grams_'+currentID,
		// 				'class':'form-control input--grams',
		// 				'placeholder':'grams',
		// 			}) )
		// 			.append( '&nbsp;' )

		// 			.append( deleteButton )
		// 			.append( '&nbsp;' )
		// 			.append( $('<span>',{
		// 				'class':'glyphicon glyphicon-sort btn btn-default disabled'
		// 			}) )
					
		// 		)
		// 	;
			
		// 	$('#counterIngredients').val( parseInt(currentID, 10) + 1 );
			
		// });
		
		
	}) ;


	</script>
@stop

@section('content')

	<?php //echo '<pre>'; print_r($json_calc); echo '</pre>'; exit; ?>
  
  <div class="row">
  	<h1 class="page-header">@yield('title')</h1>

  	@if ($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
	@endif


    @if(isset($data->id))
    	{{ Form::open(array('action' => 'Admin_QuickController@postUpdateQuick', 'class' => 'form-horizontal')) }} 
   	@else
  		{{ Form::open(array('action' => 'Admin_QuickController@postAddQuick', 'class' => 'form-horizontal')) }} 
    @endif
    
    <ul id="myTab" class="nav nav-tabs">
      	<li class="@if($calculated != 1)active@endif"><a href="#protein" data-toggle="tab">Protein</a></li>
      	<li><a href="#base" data-toggle="tab">Base</a></li>
      	<li><a href="#side1" data-toggle="tab">Side 1</a></li>
      	<li><a href="#topping" data-toggle="tab">Topping</a></li>
      <li class="@if($calculated == 1)active@endif"><a href="#sales" data-toggle="tab">Sales Data</a></li>
    </ul>
    
    <div id="myTabContent" class="tab-content ">
    	<div class="tab-pane fade in @if($calculated != 1)active@endif" id="protein">
    		<div class="col-sm-1">
	          	{{-- Form::button('+ Add', array('id' => 'btnActionAddProtein','class' => 'btn btn-primary')) --}}
	          	<a href="#" id="btnActionAddProtein" class="btn btn-primary">+ Add</a>
	          	{{ Form::hidden('counterProtein',null,array('id'=>'counterProtein')) }} 
	        </div>
			<hr/>
			 <div class="form-group {{ ($errors->has('protein')) ? 'has-error' : '' ; }}">
	           	{{ ($errors->has('protein'))? '<p>'. $errors->first('protein') .'</p>' : '' }}
	          	<ul id="_ListProtein" class="_mySortable">
	            	<?php $x = 0; ?>
	                @if(isset($ingredients_p))
	                	@foreach($ingredients_p as $p_ingredient)
	                    	<li>
	                            <select name="ingredients[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--ingredient"/>
	                                @foreach($base as $i=>$v)
	                                	<option value="{{ $i }}" @if ($b_ingredient->menu_ingredients_id == $i) selected="selected" @endif >{{ $v }}</option>
	                                @endforeach
	                            </select>
	                            <input name="amount[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--amount " value="{{ $r_ingredient->amount }}" />
	                            <select name="metric[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--metric"/>
	                                @foreach($metric as $in=>$val)
	                                	<option value="{{ $in }}" @if ($r_ingredient->metric_id == $in) selected="selected" @endif >{{ $val }}</option>
	                                @endforeach
	                            </select>
	                            <input name="ri_sales_amount[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--amount " value="{{ $r_ingredient->ri_sales_amount }}" />
	                            <input name="grams[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--grams " value="{{ $r_ingredient->grams }}" />

	                            @foreach($json_array as $i => $in)
	                            	@if($i == $r_ingredient->menu_ingredients_id)
	                            		<input type="hidden" name="i_grams[{{$i}}]" value="{{ $in['grams'] }}" />
	                            		<input type="hidden" name="i_price[{{$i}}]" value="{{ $in['price'] }}" />
		                        	@endif
		                        @endforeach

	                            <button id="{{ $r_ingredient->id }}" class="deleteIngredient glyphicon glyphicon-remove btn btn-danger"></button>
	                            <span class="glyphicon glyphicon-sort btn btn-default disabled"></span>
	                            
	                   		</li>
		                 	<?php $x++; ?>                    
	                   	@endforeach
	                @endif
	         	</ul>
			</div>

		</div>
		<div class="tab-pane fade in" id="base">
			<div class="col-sm-1">
	          	{{-- Form::button('+ Add', array('id' => 'btnActionAddBase','class' => 'btn btn-primary')) --}}
	          	<a href="#" id="btnActionAddBase" class="btn btn-primary">+ Add</a>
	          	{{ Form::hidden('counterBase',null,array('id'=>'counterBase')) }} 
	        </div>
			<hr/>
	        <div class="form-group {{ ($errors->has('base')) ? 'has-error' : '' ; }}">
	           	{{ ($errors->has('base'))? '<p>'. $errors->first('base') .'</p>' : '' }}
	          	<ul id="_ListBase" class="_mySortable">
	            	<?php $x = 0; ?>
	                @if(isset($b_ingredients))
	                	@foreach($b_ingredients as $b_ingredient)
	                    	<li>
	                            <select name="ingredients[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--ingredient"/>
	                                @foreach($base as $i=>$v)
	                                	<option value="{{ $i }}" @if ($b_ingredient->menu_ingredients_id == $i) selected="selected" @endif >{{ $v }}</option>
	                                @endforeach
	                            </select>
	                            <input name="amount[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--amount " value="{{ $r_ingredient->amount }}" />
	                            <select name="metric[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--metric"/>
	                                @foreach($metric as $in=>$val)
	                                	<option value="{{ $in }}" @if ($r_ingredient->metric_id == $in) selected="selected" @endif >{{ $val }}</option>
	                                @endforeach
	                            </select>
	                            <input name="ri_sales_amount[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--amount " value="{{ $r_ingredient->ri_sales_amount }}" />
	                            <input name="grams[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--grams " value="{{ $r_ingredient->grams }}" />

	                            @foreach($json_array as $i => $in)
	                            	@if($i == $r_ingredient->menu_ingredients_id)
	                            		<input type="hidden" name="i_grams[{{$i}}]" value="{{ $in['grams'] }}" />
	                            		<input type="hidden" name="i_price[{{$i}}]" value="{{ $in['price'] }}" />
		                        	@endif
		                        @endforeach

	                            <button id="{{ $r_ingredient->id }}" class="deleteIngredient glyphicon glyphicon-remove btn btn-danger"></button>
	                            <span class="glyphicon glyphicon-sort btn btn-default disabled"></span>
	                            
	                   		</li>
		                 	<?php $x++; ?>                    
	                   	@endforeach
	                @endif
	         	</ul>
			</div> 
		</div>
		<div class="tab-pane fade in" id="side1">
			<div class="col-sm-1">
	          	{{-- Form::button('+ Add', array('id' => 'btnActionAddSide1','class' => 'btn btn-primary')) --}}
	          	<a href="#" id="btnActionAddSide1" class="btn btn-primary">+ Add</a>
	          	{{ Form::hidden('counterSide1',null,array('id'=>'counterSide1')) }} 
	        </div>
			<hr/>
			<div class="form-group {{ ($errors->has('side1')) ? 'has-error' : '' ; }}">
	           	{{ ($errors->has('side1'))? '<p>'. $errors->first('side1') .'</p>' : '' }}
	          	<ul id="_ListSide1" class="_mySortable">
	            	<?php $x = 0; ?>
	                @if(isset($r_ingredients))
	                	@foreach($r_ingredients as $r_ingredient)
	                    	<li>
	                            <select name="ingredients[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--ingredient"/>
	                                @foreach($ingredients as $i=>$v)
	                                	<option value="{{ $i }}" @if ($r_ingredient->menu_ingredients_id == $i) selected="selected" @endif >{{ $v }}</option>
	                                @endforeach
	                            </select>
	                            <input name="amount[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--amount " value="{{ $r_ingredient->amount }}" />
	                            <select name="metric[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--metric"/>
	                                @foreach($metric as $in=>$val)
	                                	<option value="{{ $in }}" @if ($r_ingredient->metric_id == $in) selected="selected" @endif >{{ $val }}</option>
	                                @endforeach
	                            </select>
	                            <input name="ri_sales_amount[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--amount " value="{{ $r_ingredient->ri_sales_amount }}" />
	                            <input name="grams[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--grams " value="{{ $r_ingredient->grams }}" />

	                            @foreach($json_array as $i => $in)
	                            	@if($i == $r_ingredient->menu_ingredients_id)
	                            		<input type="hidden" name="i_grams[{{$i}}]" value="{{ $in['grams'] }}" />
	                            		<input type="hidden" name="i_price[{{$i}}]" value="{{ $in['price'] }}" />
		                        	@endif
		                        @endforeach

	                            <button id="{{ $r_ingredient->id }}" class="deleteIngredient glyphicon glyphicon-remove btn btn-danger"></button>
	                            <span class="glyphicon glyphicon-sort btn btn-default disabled"></span>
	                            
	                   		</li>
		                 	<?php $x++; ?>                    
	                   	@endforeach
	                @endif
	         	</ul>
			</div>
		</div>

		<!-- <div class="tab-pane fade in" id="side2">
			<div class="col-sm-1">
	          	{{-- Form::button('+ Add', array('id' => 'btnActionAddSide2','class' => 'btn btn-primary')) --}}
	          	<a href="#" id="btnActionAddSide2" class="btn btn-primary">+ Add</a>
	          	{{ Form::hidden('counterSide2',null,array('id'=>'counterSide2')) }} 
	        </div>
			<hr/>
			<div class="form-group {{ ($errors->has('side2')) ? 'has-error' : '' ; }}">
	           	{{ ($errors->has('side2'))? '<p>'. $errors->first('side2') .'</p>' : '' }}
	          	<ul id="_ListSide2" class="_mySortable">
	            	<?php ?> - Line need to be fixed $x = 0
	                @if(isset($r_ingredients))
	                	@foreach($r_ingredients as $r_ingredient)
	                    	<li>
	                            <select name="ingredients[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--ingredient"/>
	                                @foreach($ingredients as $i=>$v)
	                                	<option value="{{ $i }}" @if ($r_ingredient->menu_ingredients_id == $i) selected="selected" @endif >{{ $v }}</option>
	                                @endforeach
	                            </select>
	                            <input name="amount[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--amount " value="{{ $r_ingredient->amount }}" />
	                            <select name="metric[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--metric"/>
	                                @foreach($metric as $in=>$val)
	                                	<option value="{{ $in }}" @if ($r_ingredient->metric_id == $in) selected="selected" @endif >{{ $val }}</option>
	                                @endforeach
	                            </select>
	                            <input name="ri_sales_amount[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--amount " value="{{ $r_ingredient->ri_sales_amount }}" />
	                            <input name="grams[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--grams " value="{{ $r_ingredient->grams }}" />

	                            @foreach($json_array as $i => $in)
	                            	@if($i == $r_ingredient->menu_ingredients_id)
	                            		<input type="hidden" name="i_grams[{{$i}}]" value="{{ $in['grams'] }}" />
	                            		<input type="hidden" name="i_price[{{$i}}]" value="{{ $in['price'] }}" />
		                        	@endif
		                        @endforeach

	                            <button id="{{ $r_ingredient->id }}" class="deleteIngredient glyphicon glyphicon-remove btn btn-danger"></button>
	                            <span class="glyphicon glyphicon-sort btn btn-default disabled"></span>
	                            
	                   		</li>
		                 	<?php $x++; ?>                    
	                   	@endforeach
	                @endif
	         	</ul>
			</div>
		</div> -->
		
      	<div class="tab-pane fade in" id="topping">
      		<div class="col-sm-1">
	          	{{-- Form::button('+ Add', array('id' => 'btnActionAddTopping','class' => 'btn btn-primary')) --}}
	          	<a href="#" id="btnActionAddTopping" class="btn btn-primary">+ Add</a>
	          	{{ Form::hidden('counterTopping',null,array('id'=>'counterTopping')) }} 
	        </div>
			<hr/>
			<div class="form-group {{ ($errors->has('Topping')) ? 'has-error' : '' ; }}">
	           	{{ ($errors->has('Topping'))? '<p>'. $errors->first('Topping') .'</p>' : '' }}
	          	<ul id="_ListTopping" class="_mySortable">
	            	<?php $x = 0; ?>
	                @if(isset($r_ingredients))
	                	@foreach($r_ingredients as $r_ingredient)
	                    	<li>
	                            <select name="ingredients[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--ingredient"/>
	                                @foreach($ingredients as $i=>$v)
	                                	<option value="{{ $i }}" @if ($r_ingredient->menu_ingredients_id == $i) selected="selected" @endif >{{ $v }}</option>
	                                @endforeach
	                            </select>
	                            <input name="amount[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--amount " value="{{ $r_ingredient->amount }}" />
	                            <select name="metric[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--metric"/>
	                                @foreach($metric as $in=>$val)
	                                	<option value="{{ $in }}" @if ($r_ingredient->metric_id == $in) selected="selected" @endif >{{ $val }}</option>
	                                @endforeach
	                            </select>
	                            <input name="ri_sales_amount[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--amount " value="{{ $r_ingredient->ri_sales_amount }}" />
	                            <input name="grams[][{{ $r_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--grams " value="{{ $r_ingredient->grams }}" />

	                            @foreach($json_array as $i => $in)
	                            	@if($i == $r_ingredient->menu_ingredients_id)
	                            		<input type="hidden" name="i_grams[{{$i}}]" value="{{ $in['grams'] }}" />
	                            		<input type="hidden" name="i_price[{{$i}}]" value="{{ $in['price'] }}" />
		                        	@endif
		                        @endforeach

	                            <button id="{{ $r_ingredient->id }}" class="deleteIngredient glyphicon glyphicon-remove btn btn-danger"></button>
	                            <span class="glyphicon glyphicon-sort btn btn-default disabled"></span>
	                            
	                   		</li>
		                 	<?php $x++; ?>                    
	                   	@endforeach
	                @endif
	         	</ul>
			</div>
		</div>
      	<div class="tab-pane fade in @if($calculated == 1)active@endif" id="sales">
            <div class="col-sm-1">
            	{{ Form::submit('+ Calc', array('id' => 'btnActionCalculate','name' => 'calc','class' => 'btn btn-primary')) }}
            </div>
            <hr/>
            @if(isset($data->id))                	
            	@foreach($r_sales as $sdata)
					{{ Form::hidden('sdata_id', $sdata->id) }}
		            <div class="row">
			            <div class="form-group">
				              {{ Form::label('staff_cost_per_hour', 'Staff cost per hour: ', array('class' => 'col-sm-2 control-label')) }}
				            <div class="col-sm-3">
				            {{ Form::text('staff_cost_per_hour', (isset($input['staff_cost_per_hour'])? Input::old('staff_cost_per_hour') : (isset($sdata->staff_cost_per_hour)? $sdata->staff_cost_per_hour : '' )), array('class' => 'form-control')) }}				            </div>

				            {{ Form::label('sales_price', 'Price: ', array('class' => 'col-sm-2 control-label')) }}
				            <div class="col-sm-3">
				               {{ Form::text('sales_price', (isset($input['sales_price'])? Input::old('sales_price') : (isset($sdata->sales_price)? $sdata->sales_price : '' )), array('class' => 'form-control')) }} 
				            </div>

				        </div>
				        <div class="form-group">
				        	<h5 class="col-sm-2 control-label sales-data__title">Staff cost to make recipe batch:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">$ {{(isset($sdata->staff_cost_to_make_recipe_batch)? $sdata->staff_cost_to_make_recipe_batch : '' )}}</p>
				            </div>

				            {{ Form::label('B2B_sales_price', 'B2B - Price: ', array('class' => 'col-sm-2 control-label')) }}
				            <div class="col-sm-3">
				               {{ Form::text('B2B_sales_price', (isset($input['B2B_sales_price'])? Input::old('B2B_sales_price') : (isset($sdata->B2B_sales_price)? $sdata->B2B_sales_price : '' )), array('class' => 'form-control')) }} 
				            </div>
				        </div>
				        <div class="form-group">
				        	<h5 class="col-sm-2 control-label sales-data__title">Staff cost per piece:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">$ {{(isset($sdata->staff_cost_per_piece)? $sdata->staff_cost_per_piece : '' )}}</p>
				            </div>

				            {{ Form::label('sales_amount', 'Amount: ', array('class' => 'col-sm-2 control-label')) }}
				            <div class="col-sm-3">
				               {{ Form::text('sales_amount', (isset($input['sales_amount'])? Input::old('sales_amount') : (isset($sdata->sales_amount)? $sdata->sales_amount : '' )), array('class' => 'form-control')) }}
				            </div>
				        </div>
				        <div class="form-group">
				        	<h5 class="col-sm-2 control-label sales-data__title">Generate Total Recipe Grams</h5>
				            <div class="col-sm-3">
				            	{{ Form::checkbox('total_recipe_grams_active', 1, (isset($input['total_recipe_grams_active'])? Input::old('total_recipe_grams_active') : (isset($sdata->total_recipe_grams_active)? $sdata->total_recipe_grams_active : '' )), array('class' => '')) }}
				            </div>

				            {{ Form::label('sales_time', 'Time - minutes: ', array('class' => 'col-sm-2 control-label')) }}
				            <div class="col-sm-3">
				               {{ Form::text('sales_time', (isset($input['sales_time'])? Input::old('sales_time') : (isset($sdata->sales_time)? $sdata->sales_time : '' )), array('class' => 'form-control')) }}
				            </div>
				        </div>
				        <hr/>

				        <div class="form-group {{ ($errors->has('title')) ? ' has-error' : '' ; }}">
				        	<h5 class="col-sm-2 control-label sales-data__title">Total recipe grams:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">{{$sdata->total_recipe_grams}} g</p>
				            </div>

				            <h5 class="col-sm-2 control-label sales-data__title">Total grams per piece:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">{{$sdata->total_grams_per_piece}} g</p>
				            </div>

				        </div>
				        <!-- <hr>  -->
				        <div class="form-group">
				        	 <h5 class="col-sm-2 control-label sales-data__title">B2C - Desired Sales Price:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">$ {{(isset($sdata->desired_sales_price)? $sdata->desired_sales_price : '' )}}</p>
				            </div>

				            {{ Form::label('desired_total_markup', 'Desired Total Markup - %: ', array('class' => 'col-sm-2 control-label')) }}
				            <div class="col-sm-2">
				               {{ Form::text('desired_total_markup', (isset($input['desired_total_markup'])? Input::old('desired_total_markup') : (isset($sdata->desired_total_markup)? $sdata->desired_total_markup : '' )), array('class' => 'form-control', 'placeholder' => '350')) }}
				            </div>
				            <!-- <div class="col-sm-1"></div> -->
				             
				        </div>
				        <div class="form-group">
				        	<h5 class="col-sm-2 control-label sales-data__title">B2B - Desired Sales Price:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">$ {{$sdata->B2B_desired_sales_price}}</p>
				            </div>
				            <h5 class="col-sm-2 control-label sales-data__title">B2B Total markup - %:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">{{$sdata->B2B_desired_total_markup}} %</p>
				            </div>  
				        </div>
						<hr/>
				        <div class="form-group {{ ($errors->has('title')) ? ' has-error' : '' ; }}">
			        	    <h5 class="col-sm-2 control-label sales-data__title">Total recipe cost:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">$ {{$sdata->total_recipe_cost}}</p>
				            </div>
				            <h5 class="col-sm-2 control-label sales-data__title">B2C Total markup - %:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">{{$sdata->total_markup_percentage}} %</p>
				            </div>           
						 </div>
				        <div class="form-group {{ ($errors->has('title')) ? ' has-error' : '' ; }}">
			        	    <h5 class="col-sm-2 control-label sales-data__title">Total ingredient cost:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">$ {{$sdata->total_ingredient_cost}}</p>
				            </div>
				            <h5 class="col-sm-2 control-label sales-data__title">B2B Total Recipe Revenue:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">$ {{$sdata->B2B_total_recipe_revenue}}</p>
				            </div>  
				        </div>
				        <div class="form-group {{ ($errors->has('title')) ? ' has-error' : '' ; }}">
			        	    <h5 class="col-sm-2 control-label sales-data__title">Total ingredient cost per piece:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">$ {{$sdata->total_ingredient_cost_per_piece}}</p>
				            </div>

				            <h5 class="col-sm-2 control-label sales-data__title">B2C Total recipe revenue:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">$ {{$sdata->total_recipe_revenue}}</p>
				            </div>
				        </div>
				        <hr/>
				        <div class="form-group {{ ($errors->has('title')) ? ' has-error' : '' ; }}">
			        	    
				        	<h5 class="col-sm-2 control-label sales-data__title">Total cost percentage</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info"> {{$sdata->total_cost_percentage}} %</p>
				            </div>


				            <h5 class="col-sm-2 control-label sales-data__title">Total gross profit:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">$ {{$sdata->total_profit}}</p>
				            </div>
				        </div>
				        <div class="form-group {{ ($errors->has('title')) ? ' has-error' : '' ; }}">
			        	    <h5 class="col-sm-2 control-label sales-data__title">Staff cost percentage:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">{{$sdata->staff_cost_percentage}} %</p>
				            </div>

				            <h5 class="col-sm-2 control-label sales-data__title">Total profit per piece:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">$ {{$sdata->total_profit_per_piece}}</p>
				            </div>
				        </div>
				        <div class="form-group {{ ($errors->has('title')) ? ' has-error' : '' ; }}">
			        	    <h5 class="col-sm-2 control-label sales-data__title">Ingredient cost percentage:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">{{$sdata->ingredient_cost_percentage}} %</p>
				            </div>

				            <h5 class="col-sm-2 control-label sales-data__title">Total cost per piece:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">$ {{$sdata->total_cost_per_piece}}</p>
				            </div>
				        </div>
				        <div class="form-group {{ ($errors->has('title')) ? ' has-error' : '' ; }}">
				        	<h5 class="col-sm-2 control-label sales-data__title">Total gross margin percentage:</h5>
				            <div class="col-sm-3">
				               <p class="sales-data__info">{{$sdata->total_margin_percentage}} %</p>
				            </div>

				            
				        </div>
				        
				        <hr/>
		        		<?php //echo '<pre>'; print_r($sdata->price); echo '</pre>'; exit; ?>
               	@endforeach
            @endif
	        <!-- <div class="form-group {{ ($errors->has('title')) ? ' has-error' : '' ; }}">
        	    <h5 class="col-sm-2 control-label sales-data__title">Ingredient cost percentage:</h5>
	            <div class="col-sm-3">
	               <p class="sales-data__info">$$$$ %%</p>
	            </div>

	            <h5 class="col-sm-2 control-label sales-data__title">Total markup percentage:</h5>
	            <div class="col-sm-3">
	               <p class="sales-data__info">$$$$ %%</p>
	            </div>
	        </div> -->
	        <div class="row">

	        	<div class="col-sm-offset-1 col-sm-10">
			       	<table class="table table-striped">
			            <thead>
			            	<tr>
			                    <th>Ingredient</td>
			                    <th>Ingredient Cost</th>
			                    <th>Packet Grams</th>
			                    <th>Packet Grams %</th>
			                    <th>Recipe Ingredient Cost</th>
			                    <th>Recipe Grams</th>
			                </tr>
			            </thead>
			            @if(isset($r_ingredients))

            			@foreach($r_ingredients as $r_ingredient)

	            			@foreach($s_ingredients as $ingredient)

		            			
		            				<?php //echo '<pre>'; print_r($sales_data_ingredients); echo '</pre>'; exit;?>
		            				
		            				<?php //echo '<pre>'; print_r($ingredient->id); echo '</pre>'; exit; ?>


		                            @if ($r_ingredient->menu_ingredients_id == $ingredient->id)    	
						            <tbody>
							            <tr>
							                <td> {{ $ingredient->name }} </td>
							                <td>$ {{ $ingredient->price }} </td>
							                <td> {{ $ingredient->grams }}g </td>
							                <td> {{ $r_ingredient->packet_grams_percentage }} % </td>
							                <td>$ {{ $r_ingredient->recipe_ingredient_cost }} </td>
							                <td> {{ $r_ingredient->sales_grams }}g </td>
							            </tr>
						            </tbody>
						            @endif 
					            
				            @endforeach
			            @endforeach
			            @endif
			            <tfoot>
			            	<tr>
			                	<td colspan="20">
			                    	
			                    </td>
			               	</tr>
			            </tfoot>
			       	</table>
		        </div>	
			</div>
	        </div>
      </div>
            
            <div class="form-group {{ ($errors->has('extra')) ? 'has-error' : '' ; }}">
	           	{{ ($errors->has('extra'))? '<p>'. $errors->first('extra') .'</p>' : '' }}
            </div>
      </div>
      
    </div>
        
        	{{ Form::hidden('id', (isset($input['id'])? Input::old('id') : (isset($data->id)? $data->id : '' ))) }}
        	{{-- Form::hidden('sc', ( '10' )) --}}
            
            <hr/>
            
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
              {{ Form::submit('Save & Close', array('name' => 'sc','class' => 'btn btn-success')) }}
              <!-- <input type="submit" name="sc" id="1" value="Save & Close" class="btn btn-success"> -->
            <a href="/admin/menu/recipes/">
                {{ Form::button('Cancel' ,array('class' => 'btn btn-danger')) }}
            </a>
            </div>
        </div>
    {{ Form::close() }}
    	        	
  </div>

@stop


@section('_tail')

@stop